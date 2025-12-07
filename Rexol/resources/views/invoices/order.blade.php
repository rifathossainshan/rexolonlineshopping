<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>Invoice #{{ $order->id }}</title>
    <style>
        body {
            font-family: 'Helvetica', sans-serif;
            color: #333;
            line-height: 1.6;
        }

        .container {
            width: 100%;
            margin: 0 auto;
        }

        .header {
            border-bottom: 2px solid #000;
            padding-bottom: 20px;
            margin-bottom: 30px;
        }

        .logo {
            font-size: 24px;
            font-weight: bold;
            text-transform: uppercase;
        }

        .invoice-info {
            float: right;
            text-align: right;
        }

        .table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 30px;
        }

        .table th,
        .table td {
            padding: 12px;
            border-bottom: 1px solid #ddd;
            text-align: left;
        }

        .table th {
            background-color: #f8f9fa;
            font-weight: bold;
        }

        .text-right {
            text-align: right;
        }

        .total-section {
            text-align: right;
            margin-top: 20px;
        }

        .fw-bold {
            font-weight: bold;
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="header">
            <span class="logo">Rexol</span>
            <div class="invoice-info">
                <strong>Invoice #{{ $order->id }}</strong><br>
                Date: {{ $order->created_at->format('M d, Y') }}<br>
                Status: {{ ucfirst($order->status) }}
            </div>
        </div>

        <div style="margin-bottom: 30px;">
            <strong>Bill To:</strong><br>
            {{ $order->name }}<br>
            {{ $order->address }}<br>
            {{ $order->phone }}
        </div>

        <table class="table">
            <thead>
                <tr>
                    <th>Item</th>
                    <th>Size</th>
                    <th>Price</th>
                    <th>Qty</th>
                    <th class="text-right">Total</th>
                </tr>
            </thead>
            <tbody>
                @foreach($order->items as $item)
                    <tr>
                        <td>{{ $item->product->title ?? 'Product' }}</td>
                        <td>{{ $item->size ?? 'N/A' }}</td>
                        <td>৳{{ number_format($item->price) }}</td>
                        <td>{{ $item->quantity }}</td>
                        <td class="text-right">৳{{ number_format($item->price * $item->quantity) }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <div class="total-section">
            <p>Subtotal: ৳{{ number_format($order->total_amount) }}</p>
            <p class="fw-bold" style="font-size: 1.2rem;">Total: ৳{{ number_format($order->total_amount) }}</p>
        </div>

        <div style="margin-top: 50px; text-align: center; color: #777; font-size: 0.8rem;">
            Thank you for shopping with Rexol!
        </div>
    </div>
</body>

</html>