<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>決済成功 - デバッグ情報</title>
    <style>
        body {
            font-family: sans-serif;
            max-width: 1200px;
            margin: 20px auto;
            padding: 20px;
        }
        .section {
            background: #f5f5f5;
            border: 1px solid #ddd;
            border-radius: 5px;
            padding: 15px;
            margin-bottom: 20px;
        }
        .section h2 {
            margin-top: 0;
            color: #333;
            border-bottom: 2px solid #4CAF50;
            padding-bottom: 10px;
        }
        pre {
            background: white;
            border: 1px solid #ccc;
            padding: 10px;
            overflow-x: auto;
            border-radius: 3px;
        }
        .success {
            background: #4CAF50;
            color: white;
            padding: 15px;
            border-radius: 5px;
            margin-bottom: 20px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            background: white;
        }
        table td, table th {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }
        table th {
            background-color: #4CAF50;
            color: white;
        }
        .button {
            display: inline-block;
            background: #4CAF50;
            color: white;
            padding: 10px 20px;
            text-decoration: none;
            border-radius: 5px;
            margin-top: 10px;
        }
    </style>
</head>
<body>
<div class="success">
    <h1>✅ 決済が完了しました</h1>
    <p>金額: ¥{{ number_format($amount) }}</p>
</div>

<div class="section">
    <h2>1. リクエスト基本情報</h2>
    <table>
        <tr>
            <th>項目</th>
            <th>値</th>
        </tr>
        <tr>
            <td>HTTPメソッド</td>
            <td>{{ $request_method }}</td>
        </tr>
        <tr>
            <td>リクエストURL</td>
            <td>{{ $request_url }}</td>
        </tr>
        <tr>
            <td>セッションID</td>
            <td>{{ $session_id }}</td>
        </tr>
    </table>
</div>

<div class="section">
    <h2>2. すべてのパラメータ ($request->all())</h2>
    <pre>{{ json_encode($all_params, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE) }}</pre>
</div>

<div class="section">
    <h2>3. クエリパラメータ ($request->query())</h2>
    <pre>{{ json_encode($query_params, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE) }}</pre>
</div>

<div class="section">
    <h2>4. キャッシュデータ</h2>
    <pre>{{ json_encode($cached_data, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE) }}</pre>
</div>

@if($session_details)
    <div class="section">
        <h2>5. fincodeセッション詳細 (APIから取得)</h2>
        <pre>{{ json_encode($session_details, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE) }}</pre>
    </div>
@endif

<a href="{{ route('payment.form') }}" class="button">新しい決済を試す</a>
</body>
</html>
