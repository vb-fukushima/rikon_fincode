<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>エラー - インボイス発行</title>
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
            color: #dc3545;
            border-bottom: 3px solid #dc3545;
            padding-bottom: 10px;
        }
        .error-message {
            background: #f8d7da;
            color: #721c24;
            padding: 20px;
            border-radius: 5px;
            margin-bottom: 20px;
            border-left: 5px solid #dc3545;
        }
        .error-details {
            background: #f4f4f4;
            padding: 15px;
            border-radius: 5px;
            overflow-x: auto;
            font-family: monospace;
            font-size: 12px;
            margin: 20px 0;
        }
        .suggestions {
            background: #d1ecf1;
            padding: 20px;
            border-radius: 5px;
            margin: 20px 0;
            border-left: 5px solid #0c5460;
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
            background: #007bff;
            color: white;
        }
        .btn-secondary {
            background: #6c757d;
            color: white;
        }
        .btn:hover {
            opacity: 0.9;
        }
    </style>
</head>
<body>
<div class="container">
    <h1>❌ インボイス発行エラー</h1>

    <div class="error-message">
        <p><strong>インボイスの発行に失敗しました</strong></p>
        @if(isset($status))
            <p>HTTPステータス: {{ $status }}</p>
        @endif
    </div>

    @if(isset($error))
        <div class="error-details">
            {{ $error }}
        </div>
    @endif

    <div class="suggestions">
        <h3>💡 考えられる原因：</h3>
        <ul>
            <li>インボイス機能が有効になっていない可能性があります（管理画面で確認）</li>
            <li>APIキーの権限が不足している可能性があります</li>
            <li>リクエストパラメータが正しくない可能性があります</li>
            <li>テスト環境でインボイス機能が利用可能か確認してください</li>
        </ul>
    </div>

    <div class="button-group">
        <a href="{{ route('invoice.form') }}" class="btn btn-primary">
            🔄 再試行
        </a>
        <a href="{{ url('/') }}" class="btn btn-secondary">
            🏠 トップに戻る
        </a>
    </div>
</div>
</body>
</html>
