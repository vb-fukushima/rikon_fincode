<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <style>
        body {
            font-family: "Yu Gothic", "游ゴシック", sans-serif;
            margin: 40px;
        }
        .header {
            text-align: center;
            margin-bottom: 40px;
        }
        h1 {
            font-size: 28px;
            border-bottom: 2px solid #333;
            padding-bottom: 10px;
        }
        .info-section {
            margin: 30px 0;
        }
        .info-row {
            display: flex;
            padding: 10px 0;
            border-bottom: 1px solid #ddd;
        }
        .label {
            width: 150px;
            font-weight: bold;
        }
        .value {
            flex: 1;
        }
        .amount {
            text-align: center;
            margin: 40px 0;
            font-size: 24px;
            font-weight: bold;
        }
        .footer {
            margin-top: 60px;
            text-align: right;
            font-size: 12px;
        }
    </style>
</head>
<body>
<div class="header">
    <h1>領　収　書</h1>
    <p>発行日: {{ $issue_date }}</p>
</div>

<div class="amount">
    金額: ¥{{ number_format($payment_data['transaction']['amount'] ?? 0) }}
</div>

<div class="info-section">
    <div class="info-row">
        <div class="label">取引ID</div>
        <div class="value">{{ $payment_data['id'] ?? 'N/A' }}</div>
    </div>
    <div class="info-row">
        <div class="label">決済方法</div>
        <div class="value">クレジットカード決済</div>
    </div>
    <div class="info-row">
        <div class="label">但し書き</div>
        <div class="value">カウンセリングサービス利用料として</div>
    </div>
</div>

<div class="footer">
    <p>発行元: 離婚相談マーケットプレイス</p>
    <p>※この領収書は再発行できません。大切に保管してください。</p>
</div>
</body>
</html>
