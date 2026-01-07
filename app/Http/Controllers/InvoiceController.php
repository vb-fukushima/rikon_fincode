<?php

namespace App\Http\Controllers;

use App\Models\Invoice;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class InvoiceController extends Controller
{
    /**
     * チケット購入フォーム
     */
    public function form()
    {
        return view('invoice.form');
    }




    /**
     * インボイス作成 → 決済画面へ遷移
     */
// InvoiceController.php の create() メソッドを修正

    public function create(Request $request)
    {
        $validated = $request->validate([
            'amount' => 'required|integer|min:1',
            'customer_name' => 'required|string|max:100',
            'customer_email' => 'required|email|max:100',
        ]);

        try {
            $apiKey = config('services.fincode.secret_key');
            $apiUrl = config('services.fincode.api_url');

            // ステップ0: 顧客作成
            $customerResponse = Http::withHeaders([
                'Authorization' => 'Bearer ' . $apiKey,
                'Content-Type' => 'application/json',
            ])->post($apiUrl . '/v1/customers', [
                'name' => $validated['customer_name'],
                'email' => $validated['customer_email'],
            ]);

            if (!$customerResponse->successful()) {
                Log::error('Failed to create customer', [
                    'status' => $customerResponse->status(),
                    'body' => $customerResponse->body(),
                ]);
                return back()->with('error', '顧客の作成に失敗しました');
            }

            $customerData = $customerResponse->json();
            $customerId = $customerData['id'];

            Log::info('Customer created', ['customer_id' => $customerId]);

            // ステップ1: インボイス作成
            $createResponse = Http::withHeaders([
                'Authorization' => 'Bearer ' . $apiKey,
                'Content-Type' => 'application/json',
            ])->post($apiUrl . '/v1/invoices', [
                'pay_types' => ['Card'],
            ]);

            if (!$createResponse->successful()) {
                Log::error('Failed to create invoice', [
                    'status' => $createResponse->status(),
                    'body' => $createResponse->body(),
                ]);
                return back()->with('error', 'インボイスの作成に失敗しました');
            }

            $invoiceData = $createResponse->json();
            $invoiceId = $invoiceData['id'];

            Log::info('Invoice created (DRAFT)', ['invoice_id' => $invoiceId]);

            // ステップ2: インボイス情報を更新
            $updateResponse = Http::withHeaders([
                'Authorization' => 'Bearer ' . $apiKey,
                'Content-Type' => 'application/json',
            ])->put($apiUrl . '/v1/invoices/' . $invoiceId, [
                'due_date' => now()->addDays(7)->format('Y/m/d'),
                'customer_id' => $customerId,
                'lines' => [
                    [
                        'date' => now()->format('Y/m/d'),
                        'name' => 'カウンセリングチケット',
                        'unit_price' => (int)$validated['amount'],
                        'quantity' => 1,
                        'tax_rate' => 10,
                    ],
                ],
                'pay_types' => ['Card'],
                'card' => [
                    'job_code' => 'CAPTURE',
                    'tds_type' => config('services.fincode.tds_type', '0'),
                    'tds2_type' => config('services.fincode.tds_type', '0'),
                ],
            ]);

            if (!$updateResponse->successful()) {
                Log::error('Failed to update invoice', [
                    'status' => $updateResponse->status(),
                    'body' => $updateResponse->body(),
                ]);
                return back()->with('error', 'インボイスの更新に失敗しました');
            }

            Log::info('Invoice updated', ['invoice_id' => $invoiceId]);

            // ステップ3: インボイスを発行（公開）
            $openResponse = Http::withHeaders([
                'Authorization' => 'Bearer ' . $apiKey,
                'Content-Type' => 'application/json',
            ])->put($apiUrl . '/v1/invoices/' . $invoiceId . '/open', [
                'bill_mail_send_flag' => '0',
                'receipt_mail_send_flag' => '0',
                'underpayment_mail_send_flag' => '0',
            ]);

            if (!$openResponse->successful()) {
                Log::error('Failed to open invoice', [
                    'status' => $openResponse->status(),
                    'body' => $openResponse->body(),
                ]);
                return back()->with('error', 'インボイスの発行に失敗しました');
            }

            $openData = $openResponse->json();

            Log::info('Invoice opened', $openData);

            if (empty($openData['invoice_url'])) {
                Log::error('invoice_url is empty', $openData);
                return back()->with('error', 'invoice_urlの取得に失敗しました');
            }

            // DB保存
            $invoice = Invoice::create([
                'fincode_invoice_id' => $invoiceId,
                'invoice_url' => $openData['invoice_url'],
                'status' => $openData['status'],
                'amount' => $validated['amount'],
                'customer_name' => $validated['customer_name'],
                'customer_email' => $validated['customer_email'],
            ]);

            Log::info('Invoice saved to DB', ['id' => $invoice->id]);

            // invoice_urlに遷移（fincodeの決済画面）
            return redirect($openData['invoice_url']);

        } catch (\Exception $e) {
            Log::error('Invoice creation failed', ['error' => $e->getMessage()]);
            return back()->with('error', 'エラーが発生しました: ' . $e->getMessage());
        }
    }

    /**
     * Webhook受信（決済完了通知）
     */
    public function webhook(Request $request)
    {
        Log::info('Invoice webhook received', $request->all());

        $invoiceId = $request->input('id');
        $status = $request->input('status');

        if ($invoiceId && $status === 'PAID') {
            $invoice = Invoice::where('fincode_invoice_id', $invoiceId)->first();

            if ($invoice) {
                $invoice->update([
                    'status' => 'PAID',
                    'paid_at' => now(),
                ]);

                Log::info('Invoice status updated to PAID', ['invoice_id' => $invoiceId]);
            }
        }

        return response()->json(['success' => true]);
    }

    /**
     * インボイス一覧（マイページ用）
     */
    public function index()
    {
        $invoices = Invoice::orderBy('created_at', 'desc')->get();

        return view('invoice.index', compact('invoices'));
    }
}
