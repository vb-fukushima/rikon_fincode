<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Barryvdh\DomPDF\Facade\Pdf;

class PaymentController extends Controller
{
    /**
     * 決済セッションを作成してfincodeにリダイレクト
     */
    public function createPayment(Request $request)
    {
        $amount = $request->input('amount', '1000');

        try {
            $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . config('services.fincode.secret_key'),
                'Content-Type' => 'application/json',
            ])->post(config('services.fincode.api_url') . '/v1/sessions', [
                'success_url' => route('payment.success'),
                'cancel_url' => route('payment.cancel'),
                'transaction' => [
                    'pay_type' => ['Card'],
                    'amount' => (string)$amount,
                ],
                'card' => [
                    'job_code' => 'CAPTURE',
                    'tds_type' => '2',
                    'tds2_type' => '2',
                ],
            ]);

            if ($response->successful()) {
                $data = $response->json();
                return redirect($data['link_url']);
            }

            Log::error('fincode API error', [
                'status' => $response->status(),
                'body' => $response->body(),
            ]);

            return back()->with('error', '決済URLの作成に失敗しました');

        } catch (\Exception $e) {
            Log::error('Payment creation failed', ['error' => $e->getMessage()]);
            return back()->with('error', 'エラーが発生しました: ' . $e->getMessage());
        }
    }

    /**
     * 決済成功時のコールバック
     */
    public function success(Request $request)
    {
        $sessionId = $request->input('session_id') ?? $request->query('session_id');

        Log::info('Payment success callback', $request->all());

        // 決済情報を取得
        $paymentData = null;
        if ($sessionId) {
            $paymentData = $this->getPaymentData($sessionId);
        }

        return view('payment.success', [
            'session_id' => $sessionId,
            'payment_data' => $paymentData,
        ]);
    }

    /**
     * 決済キャンセル時のコールバック
     */
    public function cancel(Request $request)
    {
        return view('payment.cancel');
    }

    /**
     * 領収書PDFをダウンロード
     */
    public function downloadReceipt(Request $request)
    {
        $sessionId = $request->input('session_id');

        if (!$sessionId) {
            return back()->with('error', 'セッションIDが見つかりません');
        }

        try {
            $paymentData = $this->getPaymentData($sessionId);

            if (!$paymentData) {
                return back()->with('error', '決済情報が見つかりません');
            }

            $pdf = PDF::loadView('payment.receipt', [
                'payment_data' => $paymentData,
                'issue_date' => now()->format('Y年m月d日'),
            ]);

            return $pdf->download('領収書_' . $sessionId . '.pdf');

        } catch (\Exception $e) {
            Log::error('Receipt download failed', ['error' => $e->getMessage()]);
            return back()->with('error', '領収書のダウンロードに失敗しました');
        }
    }

    /**
     * fincodeから決済情報を取得
     */
    private function getPaymentData($sessionId)
    {
        try {
            // セッション情報の取得にはパブリックキーを使う
            $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . config('services.fincode.public_key'), // publicに変更
                'Content-Type' => 'application/json',
            ])->get(config('services.fincode.api_url') . '/v1/sessions/' . $sessionId);

            if ($response->successful()) {
                Log::info('Payment data retrieved', $response->json());
                return $response->json();
            }

            Log::error('Failed to get payment data', [
                'status' => $response->status(),
                'body' => $response->body(),
            ]);

            return null;

        } catch (\Exception $e) {
            Log::error('Get payment data exception', ['error' => $e->getMessage()]);
            return null;
        }
    }
}
