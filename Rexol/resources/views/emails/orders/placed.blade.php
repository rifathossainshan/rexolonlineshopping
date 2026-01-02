<!DOCTYPE html>
<html>

<head>
    <title>Order Confirmation</title>
</head>

<body style="font-family: sans-serif;">
    <h2>Thank you for your order, {{ $order->name }}!</h2>
    <p>Your order ID is <strong>#{{ $order->id }}</strong>.</p>
    <p>We are processing your order and will let you know once it's shipped.</p>

    <h3>Order Summary:</h3>
    <table style="width: 100%; border-collapse: collapse;">
        <thead>
            <tr style="background-color: #f2f2f2;">
                <th style="padding: 8px; text-align: left; border-bottom: 1px solid #ddd;">Product</th>
                <th style="padding: 8px; text-align: left; border-bottom: 1px solid #ddd;">Quantity</th>
                <th style="padding: 8px; text-align: left; border-bottom: 1px solid #ddd;">Price</th>
            </tr>
        </thead>
        <tbody>
            @foreach($order->items as $item)
                <tr>
                    <td style="padding: 8px; border-bottom: 1px solid #ddd;">{{ $item->product->title ?? 'Product' }}
                        {{ $item->size ? '(' . $item->size . ')' : '' }}</td>
                    <td style="padding: 8px; border-bottom: 1px solid #ddd;">{{ $item->quantity }}</td>
                    <td style="padding: 8px; border-bottom: 1px solid #ddd;">
                        {{ number_format($item->price * $item->quantity) }}</td>
                </tr>
            @endforeach
        </tbody>
        <tfoot>
            <tr>
                <td colspan="2" style="padding: 8px; text-align: right; font-weight: bold;">Total:</td>
                <td style="padding: 8px; font-weight: bold;">{{ number_format($order->total_amount) }}</td>
            </tr>
        </tfoot>
    </table>

    <p style="margin-top: 20px;">Shipping Address:<br>
        {{ $order->address }}<br>
        Phone: {{ $order->phone }}</p>

    <p>Thanks,<br>
        Rexol Team</p>
</body>

</html>