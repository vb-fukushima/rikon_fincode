<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class PaymentController extends Controller
{
    /**
     * 決済セッションを作成してfincodeにリダイレクト
     */
    public function createPayment(Request $request)
    {
        $amount = $request->input('amount', '1000'); // デフォルト1000円

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
                    'job_code' => 'CAPTURE', // 即時決済
                    'tds_type' => '2',        // 3Dセキュア認証
                    'tds2_type' => '2',
                ],
            ]);

            if ($response->successful()) {
                $data = $response->json();
                // 決済URLにリダイレクト
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
        return view('payment.success', [
            'session_id' => $request->input('session_id'),
        ]);
    }

    /**
     * 決済キャンセル時のコールバック
     */
    public function cancel(Request $request)
    {
        return view('payment.cancel');
    }
}
