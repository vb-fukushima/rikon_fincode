<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Cache;

class PaymentController extends Controller
{
    /**
     * 決済セッションを作成してfincodeにリダイレクト
     */
// PaymentController.php

// PaymentController.php

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
                    'tds_type' => config('services.fincode.tds_type'),
                    'tds2_type' => config('services.fincode.tds_type'),
                ],
            ]);

            if ($response->successful()) {
                $data = $response->json();
                $sessionId = $data['id'];

                // キャッシュに保存（24時間有効）
                Cache::put('fincode_session_' . $sessionId, [
                    'session_id' => $sessionId,
                    'amount' => $amount,
                    'created_at' => now()->toIso8601String(),
                ], now()->addHours(24));

                Log::info('fincode session created and cached', [
                    'session_id' => $sessionId,
                    'amount' => $amount,
                ]);

                // success_urlにsession_idを追加
                $successUrl = route('payment.success', ['session_id' => $sessionId]);

                // 再度セッション作成（success_urlを更新）
                $response = Http::withHeaders([
                    'Authorization' => 'Bearer ' . config('services.fincode.secret_key'),
                    'Content-Type' => 'application/json',
                ])->post(config('services.fincode.api_url') . '/v1/sessions', [
                    'success_url' => $successUrl,
                    'cancel_url' => route('payment.cancel'),
                    'transaction' => [
                        'pay_type' => ['Card'],
                        'amount' => (string)$amount,
                    ],
                    'card' => [
                        'job_code' => 'CAPTURE',
                        'tds_type' => config('services.fincode.tds_type'),
                        'tds2_type' => config('services.fincode.tds_type'),
                    ],
                ]);

                if ($response->successful()) {
                    $data = $response->json();
                    return redirect($data['link_url']);
                }
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

    public function success(Request $request)
    {
        $sessionId = $request->query('session_id');

        // すべてのリクエストパラメータを取得
        $allParams = $request->all();
        $queryParams = $request->query();
        $headers = $request->headers->all();

        Log::info('Success callback received', [
            'session_id' => $sessionId,
            'all_params' => $allParams,
            'query_params' => $queryParams,
        ]);

        if (!$sessionId) {
            return redirect()->route('payment.form')->with('error', 'セッション情報が見つかりません');
        }

        // キャッシュから取得
        $cachedData = Cache::get('fincode_session_' . $sessionId);

        if (!$cachedData) {
            return redirect()->route('payment.form')->with('error', 'セッション情報が見つかりません');
        }

        // fincodeのAPIからセッション詳細を取得
        $sessionDetails = null;
        try {
            $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . config('services.fincode.secret_key'),
            ])->get(config('services.fincode.api_url') . '/v1/sessions/' . $sessionId);

            if ($response->successful()) {
                $sessionDetails = $response->json();
                Log::info('Session details retrieved', $sessionDetails);
            }
        } catch (\Exception $e) {
            Log::error('Failed to retrieve session details', ['error' => $e->getMessage()]);
        }

        // キャッシュをクリア
        Cache::forget('fincode_session_' . $sessionId);

        return view('payment.success', [
            'session_id' => $sessionId,
            'amount' => $cachedData['amount'],
            'all_params' => $allParams,
            'query_params' => $queryParams,
            'cached_data' => $cachedData,
            'session_details' => $sessionDetails,
            'request_method' => $request->method(),
            'request_url' => $request->fullUrl(),
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
    public function getPaymentReceipt($paymentId)
    {
        $apiKey = config('services.fincode.secret_key');
        $apiUrl = config('services.fincode.api_url');

        // 決済情報取得
        $response = Http::withHeaders([
            'Authorization' => 'Bearer ' . $apiKey,
        ])->get("{$apiUrl}/v1/payments/{$paymentId}");

        if ($response->successful()) {
            $payment = $response->json();

            // レスポンス全体を確認（デバッグ用）
            dd($payment);

            // もし receipt_url があれば
            if (isset($payment['receipt_url'])) {
                return redirect($payment['receipt_url']);
            }
        }

        return back()->with('error', '領収書が見つかりません');
    }


    public function failed(Request $request)
    {
        Log::warning('3DS authentication failed', [
            'session_id' => $request->query('session_id'),
            'all_params' => $request->all(),
        ]);

        return view('payment.failed', [
            'message' => '3Dセキュア認証に失敗しました。もう一度お試しください。'
        ]);
    }
}
