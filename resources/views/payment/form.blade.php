<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>fincode 決済テスト</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            max-width: 800px;
            margin: 50px auto;
            padding: 20px;
            background-color: #f5f5f5;
        }
        .container {
            background: white;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }
        h1 {
            color: #333;
            border-bottom: 2px solid #4CAF50;
            padding-bottom: 10px;
        }
        h2 {
            color: #555;
            margin-top: 30px;
            border-bottom: 1px solid #ddd;
            padding-bottom: 5px;
        }
        .test-cards {
            background: #f8f9fa;
            padding: 20px;
            border-radius: 5px;
            margin: 20px 0;
        }
        .card-item {
            background: white;
            padding: 15px;
            margin: 10px 0;
            border-radius: 4px;
            border-left: 4px solid #4CAF50;
        }
        .card-number {
            font-family: 'Courier New', monospace;
            font-size: 18px;
            font-weight: bold;
            color: #2c3e50;
            margin: 5px 0;
        }
        .card-label {
            font-size: 12px;
            color: #666;
            margin-bottom: 3px;
        }
        .card-type {
            display: inline-block;
            background: #4CAF50;
            color: white;
            padding: 2px 8px;
            border-radius: 3px;
            font-size: 11px;
            margin-right: 5px;
        }
        .card-result {
            display: inline-block;
            padding: 2px 8px;
            border-radius: 3px;
            font-size: 11px;
        }
        .success {
            background: #d4edda;
            color: #155724;
        }
        .error {
            background: #f8d7da;
            color: #721c24;
        }
        .warning {
            background: #fff3cd;
            color: #856404;
        }
        .form-group {
            margin-bottom: 20px;
        }
        label {
            display: block;
            margin-bottom: 5px;
            font-weight: bold;
        }
        input[type="number"] {
            width: 100%;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 4px;
            font-size: 16px;
        }
        button {
            width: 100%;
            padding: 12px;
            background-color: #4CAF50;
            color: white;
            border: none;
            border-radius: 4px;
            font-size: 16px;
            cursor: pointer;
        }
        button:hover {
            background-color: #45a049;
        }
        .note {
            background: #e3f2fd;
            padding: 15px;
            border-radius: 5px;
            margin: 20px 0;
            border-left: 4px solid #2196F3;
        }
        .copy-btn {
            background: #2196F3;
            color: white;
            border: none;
            padding: 4px 8px;
            border-radius: 3px;
            cursor: pointer;
            font-size: 11px;
            margin-left: 10px;
        }
        .copy-btn:hover {
            background: #1976D2;
        }
    </style>
</head>
<body>
<div class="container">
    <h1>💳 fincode 決済テスト</h1>

    <div class="note">
        <p><strong>📝 使い方：</strong></p>
        <ol>
            <li>下の金額を入力して「決済画面へ進む」をクリック</li>
            <li>fincodeの決済画面が開きます</li>
            <li>以下のテストカード番号を使って決済テスト</li>
        </ol>
    </div>

    <h2>🧪 テストカード番号一覧</h2>
    <div class="test-cards">
        <div class="card-item">
            <span class="card-type">VISA</span>
            <span class="card-result success">正常</span>
            <div class="card-label">カード番号</div>
            <div class="card-number">
                4111 1111 1111 1111
                <button class="copy-btn" onclick="copyToClipboard('4111111111111111')">コピー</button>
            </div>
        </div>

        <div class="card-item">
            <span class="card-type">VISA</span>
            <span class="card-result success">3Dセキュア認証成功</span>
            <div class="card-label">カード番号</div>
            <div class="card-number">
                4100 0000 0000 0100
                <button class="copy-btn" onclick="copyToClipboard('4100000000000100')">コピー</button>
            </div>
        </div>

        <div class="card-item">
            <span class="card-type">VISA</span>
            <span class="card-result warning">3Dセキュアチャレンジ認証</span>
            <div class="card-label">カード番号</div>
            <div class="card-number">
                4100 0000 0000 5000
                <button class="copy-btn" onclick="copyToClipboard('4100000000005000')">コピー</button>
            </div>
        </div>

        <div class="card-item">
            <span class="card-type">VISA</span>
            <span class="card-result error">残高不足</span>
            <div class="card-label">カード番号</div>
            <div class="card-number">
                4999 0000 0000 0002
                <button class="copy-btn" onclick="copyToClipboard('4999000000000002')">コピー</button>
            </div>
        </div>

        <div class="card-item">
            <span class="card-type">VISA</span>
            <span class="card-result error">限度額オーバー</span>
            <div class="card-label">カード番号</div>
            <div class="card-number">
                4999 0000 0000 0005
                <button class="copy-btn" onclick="copyToClipboard('4999000000000005')">コピー</button>
            </div>
        </div>

        <div class="card-item">
            <span class="card-type">Mastercard</span>
            <span class="card-result success">正常</span>
            <div class="card-label">カード番号</div>
            <div class="card-number">
                5555 5555 5555 4444
                <button class="copy-btn" onclick="copyToClipboard('5555555555554444')">コピー</button>
            </div>
        </div>

        <div class="card-item">
            <span class="card-type">JCB</span>
            <span class="card-result success">正常</span>
            <div class="card-label">カード番号</div>
            <div class="card-number">
                3530 1113 3330 0000
                <button class="copy-btn" onclick="copyToClipboard('3530111333300000')">コピー</button>
            </div>
        </div>

        <div class="card-item">
            <span class="card-type">AMEX</span>
            <span class="card-result success">正常</span>
            <div class="card-label">カード番号</div>
            <div class="card-number">
                3782 822463 10005
                <button class="copy-btn" onclick="copyToClipboard('378282246310005')">コピー</button>
            </div>
        </div>

        <div class="card-item">
            <span class="card-type">Diners</span>
            <span class="card-result success">正常</span>
            <div class="card-label">カード番号</div>
            <div class="card-number">
                3600 666633 3344
                <button class="copy-btn" onclick="copyToClipboard('36006666333344')">コピー</button>
            </div>
        </div>
    </div>

    <div class="note">
        <p><strong>💡 その他の入力項目：</strong></p>
        <ul>
            <li><strong>有効期限：</strong> 未来の日付（例：12/28）</li>
            <li><strong>セキュリティコード：</strong> 任意の3桁（例：123）</li>
            <li><strong>カード名義人：</strong> 任意のローマ字（例：TARO YAMADA）</li>
        </ul>
    </div>

    <h2>💰 決済金額入力</h2>
    <form action="/payment/create" method="POST">
        <input type="hidden" name="_token" value="{{ csrf_token() }}">
        <div class="form-group">
            <label for="amount">決済金額（円）</label>
            <input type="number" id="amount" name="amount" value="1000" min="1" required>
        </div>
        <button type="submit">決済画面へ進む</button>
    </form>
</div>

<script>
    function copyToClipboard(text) {
        navigator.clipboard.writeText(text).then(function() {
            alert('カード番号をコピーしました: ' + text);
        }, function(err) {
            console.error('コピー失敗:', err);
        });
    }
</script>
</body>
</html>
