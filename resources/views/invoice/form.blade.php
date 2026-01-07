<!-- resources/views/invoice/form.blade.php -->
<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>チケット購入</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            max-width: 600px;
            margin: 50px auto;
            padding: 20px;
        }
        .form-group {
            margin-bottom: 20px;
        }
        label {
            display: block;
            margin-bottom: 5px;
            font-weight: bold;
        }
        input {
            width: 100%;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 4px;
            box-sizing: border-box;
        }
        button {
            background-color: #4CAF50;
            color: white;
            padding: 12px 30px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 16px;
        }
        button:hover {
            background-color: #45a049;
        }
        .error {
            color: red;
            margin-bottom: 20px;
        }
    </style>
</head>
<body>
<h1>カウンセリングチケット購入</h1>

@if(session('error'))
    <div class="error">{{ session('error') }}</div>
@endif

<form action="{{ route('invoice.create') }}" method="POST">
    @csrf

    <div class="form-group">
        <label for="amount">金額（円）</label>
        <input type="number" name="amount" id="amount" value="10000" required min="1">
    </div>

    <div class="form-group">
        <label for="customer_name">お名前</label>
        <input type="text" name="customer_name" id="customer_name" value="山田太郎" required>
    </div>

    <div class="form-group">
        <label for="customer_email">メールアドレス</label>
        <input type="email" name="customer_email" id="customer_email" value="test@example.com" required>
    </div>

    <button type="submit">チケットを購入する</button>
</form>

<p style="margin-top: 30px;">
    <a href="{{ route('invoice.index') }}">購入履歴を見る</a>
</p>
</body>
</html>
