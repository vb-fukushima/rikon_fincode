<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>決済完了</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            max-width: 600px;
            margin: 50px auto;
            padding: 20px;
            background-color: #f5f5f5;
        }
        .container {
            background: white;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            text-align: center;
        }
        h1 {
            color: #4CAF50;
        }
        .success-icon {
            font-size: 64px;
            color: #4CAF50;
            margin-bottom: 20px;
        }
        .info {
            background: #f8f9fa;
            padding: 15px;
            border-radius: 4px;
            margin: 20px 0;
            text-align: left;
        }
        .info-row {
            display: flex;
            justify-content: space-between;
            padding: 8px 0;
            border-bottom: 1px solid #e0e0e0;
        }
        .info-row:last-child {
            border-bottom: none;
        }
        .label {
            font-weight: bold;
            color: #555;
        }
        .value {
            color: #333;
        }
        .btn {
            display: inline-block;
            margin: 10px 5px;
            padding: 12px 30px;
            border-radius: 4px;
            text-decoration: none;
            font-weight: bold;
            cursor: pointer;
        }
        .btn-primary {
            background-color: #4CAF50;
            color: white;
        }
        .btn-primary:hover {
            background-color: #45a049;
        }
        .btn-secondary {
            background-color: #2196F3;
            color: white;
        }
        .btn-secondary:hover {
            background-color: #0b7dda;
        }
    </style>
</head>
<body>
<div class="container">
    <div class="success-icon">✓</div>
    <h1>決済が完了しました</h1>
    <p>ご利用ありがとうございます。</p>

    @if($payment_data)
        <div class="info">
            <div class="info-row">
                <span class="label">決済ID</span>
                <span class="value">{{ $session_id }}</span>
            </div>
            @if(isset($payment_data['transaction']['amount']))
                <div class="info-row">
                    <span class="label">決済金額</span>
                    <span class="value">¥{{ number_format($payment_data['transaction']['amount']) }}</span>
                </div>
            @endif
            <div class="info-row">
                <span class="label">決済日時</span>
                <span class="value">{{ now()->format('Y年m月d日 H:i') }}</span>
            </div>
        </div>

        <a href="{{ route('payment.receipt.download', ['session_id' => $session_id]) }}" class="btn btn-secondary">
            📄 領収書をダウンロード
        </a>
    @endif

    <a href="{{ route('payment.form') }}" class="btn btn-primary">トップに戻る</a>
</div>
</body>
</html>
