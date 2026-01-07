<!-- resources/views/invoice/index.blade.php -->
<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>購入履歴</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            max-width: 800px;
            margin: 50px auto;
            padding: 20px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 12px;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
        }
        .status-paid {
            color: green;
            font-weight: bold;
        }
        .status-awaiting {
            color: orange;
        }
        .btn {
            padding: 8px 16px;
            background-color: #2196F3;
            color: white;
            text-decoration: none;
            border-radius: 4px;
            display: inline-block;
        }
        .btn:hover {
            background-color: #0b7dda;
        }
    </style>
</head>
<body>
<h1>購入履歴</h1>

@if($invoices->isEmpty())
    <p>購入履歴がありません。</p>
@else
    <table>
        <thead>
        <tr>
            <th>購入日</th>
            <th>金額</th>
            <th>ステータス</th>
            <th>領収書</th>
        </tr>
        </thead>
        <tbody>
        @foreach($invoices as $invoice)
            <tr>
                <td>{{ $invoice->created_at->format('Y/m/d H:i') }}</td>
                <td>¥{{ number_format($invoice->amount) }}</td>
                <td>
                    @if($invoice->status === 'PAID')
                        <span class="status-paid">支払い完了</span>
                    @elseif($invoice->status === 'AWAITING_CUSTOMER_PAYMENT')
                        <span class="status-awaiting">支払い待ち</span>
                    @else
                        {{ $invoice->status }}
                    @endif
                </td>
                <td>
                    @if($invoice->status === 'PAID')
                        <a href="{{ $invoice->invoice_url }}" target="_blank" class="btn">
                            📄 領収書を見る
                        </a>
                    @else
                        -
                    @endif
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
@endif

<p style="margin-top: 30px;">
    <a href="{{ route('invoice.form') }}">新しいチケットを購入する</a>
</p>
</body>
</html>
