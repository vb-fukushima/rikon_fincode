<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>インボイス発行成功</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            max-width: 800px;
            margin: 50px auto;
            padding: 20px;
            background: #f5f5f5;
        }
        .container {
            background: white;
            padding: 40px;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }
        h1 {
            color: #4CAF50;
            border-bottom: 3px solid #4CAF50;
            padding-bottom: 10px;
        }
        .success-message {
            background: #d4edda;
            color: #155724;
            padding: 20px;
            border-radius: 5px;
            margin-bottom: 20px;
            border-left: 5px solid #28a745;
        }
        .payment-link {
            background: #fff3cd;
            padding: 20px;
            border-radius: 5px;
            margin: 20px 0;
            border-left: 5px solid #ffc107;
        }
        .payment-link a {
            color: #856404;
            font-weight: bold;
            word-break: break-all;
        }
        .invoice-details {
            background: #f8f9fa;
            padding: 20px;
            border-radius: 5px;
            margin: 20px 0;
        }
        .invoice-details dt {
            font-weight: bold;
            color: #555;
            margin-top: 10px;
        }
        .invoice-details dd {
            margin-left: 0;
            margin-bottom: 10px;
            padding: 8px;
            background: white;
            border-radius: 3px;
        }
        .button-group {
            margin-top: 30px;
            display: flex;
            gap: 10px;
        }
        .btn {
            padding: 15px 30px;
            border: none;
            border-radius: 5px;
            font-size: 16px;
            cursor: pointer;
            text-decoration: none;
            display: inline-block;
            text-align: center;
            flex: 1;
        }
        .btn-primary {
            background: #4CAF50;
            color: white;
        }
        .btn-secondary {
            background: #6c757d;
            color: white;
        }
        .btn:hover {
            opacity: 0.9;
        }
        pre {
            background: #f4f4f4;
            padding: 15px;
            border-radius: 5px;
            overflow-x: auto;
            font-size: 12px;
        }
    </style>
</head>
<body>
<div class="container">
    <h1>✅ インボイス発行成功！</h1>

    <div class="success-message">
        <p><strong>請求書が正常に発行されました。</strong></p>
        <p>顧客は以下の決済URLから支払いを完了できます。</p>
    </div>

    @if($payment_url)
        <div class="payment-link">
            <p><strong>🔗 決済URL（顧客に送信）:</strong></p>
            <a href="{{ $payment_url }}" target="_blank">{{ $payment_url }}</a>
        </div>
    @endif

    <div class="invoice-details">
        <h3>📋 インボイス詳細</h3>
        <dl>
            @if($invoice_id)
                <dt>インボイスID:</dt>
                <dd>{{ $invoice_id }}</dd>
            @endif

            @if(isset($invoice['amount']))
                <dt>請求金額:</dt>
                <dd>¥{{ number_format($invoice['amount']) }}</dd>
            @endif

            @if(isset($invoice['due_date']))
                <dt>支払期限:</dt>
                <dd>{{ $invoice['due_date'] }}</dd>
            @endif

            @if(isset($invoice['status']))
                <dt>ステータス:</dt>
                <dd>{{ $invoice['status'] }}</dd>
            @endif
        </dl>
    </div>

    <div class="button-group">
        <a href="{{ route('invoice.form') }}" class="btn btn-primary">
            ➕ 別のインボイスを作成
        </a>
        <a href="{{ url('/') }}" class="btn btn-secondary">
            🏠 トップに戻る
        </a>
    </div>

    <details style="margin-top: 30px;">
        <summary style="cursor: pointer; font-weight: bold;">🔍 APIレスポンス詳細</summary>
        <pre>{{ json_encode($invoice, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE) }}</pre>
    </details>
</div>
</body>
</html>
