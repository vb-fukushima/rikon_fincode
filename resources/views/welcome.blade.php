<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>fincode テストページ</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            max-width: 900px;
            margin: 50px auto;
            padding: 20px;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
        }
        .container {
            background: white;
            padding: 40px;
            border-radius: 10px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.3);
        }
        h1 {
            color: #333;
            text-align: center;
            margin-bottom: 10px;
        }
        .subtitle {
            text-align: center;
            color: #666;
            margin-bottom: 40px;
        }
        .features {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 20px;
            margin-top: 30px;
        }
        .feature-card {
            background: #f8f9fa;
            padding: 30px;
            border-radius: 8px;
            text-align: center;
            transition: transform 0.3s, box-shadow 0.3s;
            border: 2px solid transparent;
        }
        .feature-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 5px 20px rgba(0,0,0,0.1);
            border-color: #4CAF50;
        }
        .feature-icon {
            font-size: 48px;
            margin-bottom: 15px;
        }
        .feature-title {
            font-size: 20px;
            font-weight: bold;
            color: #333;
            margin-bottom: 10px;
        }
        .feature-description {
            color: #666;
            font-size: 14px;
            margin-bottom: 20px;
            line-height: 1.6;
        }
        .btn {
            display: inline-block;
            padding: 12px 30px;
            background: #4CAF50;
            color: white;
            text-decoration: none;
            border-radius: 5px;
            font-weight: bold;
            transition: background 0.3s;
        }
        .btn:hover {
            background: #45a049;
        }
        .btn-secondary {
            background: #2196F3;
        }
        .btn-secondary:hover {
            background: #1976D2;
        }
        .info-section {
            background: #e3f2fd;
            padding: 20px;
            border-radius: 8px;
            margin-top: 30px;
            border-left: 4px solid #2196F3;
        }
        .info-section h3 {
            color: #1976D2;
            margin-top: 0;
        }
        .comparison {
            margin-top: 20px;
        }
        .comparison table {
            width: 100%;
            border-collapse: collapse;
        }
        .comparison th, .comparison td {
            padding: 12px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }
        .comparison th {
            background: #f5f5f5;
            font-weight: bold;
        }
        .check {
            color: #4CAF50;
            font-weight: bold;
        }
        .cross {
            color: #f44336;
            font-weight: bold;
        }
    </style>
</head>
<body>
<div class="container">
    <h1>🚀 fincode 決済テスト環境</h1>
    <p class="subtitle">離婚相談マーケットプレイス向け決済機能</p>

    <div class="features">
        <!-- リダイレクト型決済 -->
        <div class="feature-card">
            <div class="feature-icon">💳</div>
            <div class="feature-title">リダイレクト型決済</div>
            <div class="feature-description">
                即時決済。カウンセリング予約時にその場で決済完了。
                画面実装不要で素早く導入可能。
            </div>
            <a href="/payment" class="btn">決済テスト</a>
        </div>

        <!-- インボイス機能 NEW! -->
        <div class="feature-card">
            <div class="feature-icon">📧</div>
            <div class="feature-title">インボイス機能 🆕</div>
            <div class="feature-description">
                カウンセリング完了後に請求書を自動発行。
                決済URLをメール送信。領収書も自動発行。
            </div>
            <a href="/invoice" class="btn btn-secondary">インボイステスト</a>
        </div>
    </div>

    <div class="info-section">
        <h3>📊 機能比較</h3>
        <div class="comparison">
            <table>
                <thead>
                <tr>
                    <th>項目</th>
                    <th>リダイレクト型決済</th>
                    <th>インボイス機能</th>
                </tr>
                </thead>
                <tbody>
                <tr>
                    <td><strong>決済タイミング</strong></td>
                    <td>予約時に即時決済</td>
                    <td>カウンセリング完了後</td>
                </tr>
                <tr>
                    <td><strong>請求書発行</strong></td>
                    <td><span class="cross">✗</span> なし</td>
                    <td><span class="check">✓</span> 自動発行</td>
                </tr>
                <tr>
                    <td><strong>領収書発行</strong></td>
                    <td>手動生成（PDF）</td>
                    <td><span class="check">✓</span> 自動発行</td>
                </tr>
                <tr>
                    <td><strong>決済手段</strong></td>
                    <td>カード決済のみ</td>
                    <td>カード + 銀行振込</td>
                </tr>
                <tr>
                    <td><strong>インボイス制度対応</strong></td>
                    <td><span class="cross">✗</span></td>
                    <td><span class="check">✓</span> 完全対応</td>
                </tr>
                <tr>
                    <td><strong>おすすめユースケース</strong></td>
                    <td>簡単な予約決済</td>
                    <td>後払い請求、複数カウンセラー</td>
                </tr>
                </tbody>
            </table>
        </div>
    </div>

    <div class="info-section" style="background: #fff3cd; border-left-color: #ffc107;">
        <h3 style="color: #ff6f00;">💡 離婚プロダクトへの実装推奨</h3>
        <p><strong>インボイス機能の利用をおすすめします：</strong></p>
        <ul>
            <li>✅ カウンセリング完了後に確実に請求</li>
            <li>✅ 請求書・領収書が自動で発行される（税務処理に必須）</li>
            <li>✅ 複数カウンセラーへの一括請求も可能</li>
            <li>✅ インボイス制度完全対応</li>
            <li>✅ カード決済 + 銀行振込の両対応</li>
        </ul>
    </div>
</div>
</body>
</html>
