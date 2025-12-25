<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laravel - fincode決済テスト</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .container {
            background: white;
            padding: 50px;
            border-radius: 12px;
            box-shadow: 0 10px 40px rgba(0,0,0,0.2);
            text-align: center;
            max-width: 500px;
        }
        h1 {
            color: #333;
            margin-bottom: 10px;
        }
        p {
            color: #666;
            margin-bottom: 30px;
        }
        .btn {
            display: inline-block;
            padding: 15px 40px;
            background-color: #4CAF50;
            color: white;
            text-decoration: none;
            border-radius: 6px;
            font-size: 18px;
            font-weight: bold;
            transition: background-color 0.3s;
        }
        .btn:hover {
            background-color: #45a049;
        }
        .logo {
            font-size: 48px;
            margin-bottom: 20px;
        }
    </style>
</head>
<body>
<div class="container">
    <div class="logo">💳</div>
    <h1>Laravel × fincode</h1>
    <p>離婚相談マーケットプレイス<br>決済機能テスト</p>
    <a href="{{ route('payment.form') }}" class="btn">決済テストを開始</a>
</div>
</body>
</html>
