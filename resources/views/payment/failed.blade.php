<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>決済失敗</title>
</head>
<body>
<h1>決済に失敗しました</h1>
<p>{{ $message }}</p>
<a href="{{ route('payment.form') }}">もう一度試す</a>
</body>
</html>
