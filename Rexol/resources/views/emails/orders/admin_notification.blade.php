<!DOCTYPE html>
<html>

<head>
    <title>New Order Notification</title>
</head>

<body style="font-family: sans-serif;">
    <h2 style="color: #d32f2f;">New Order Received!</h2>
    <p><strong>Order ID:</strong> #{{ $order->id }}</p>
    <p><strong>Customer:</strong> {{ $order->name }}</p>
    <p><strong>Total Amount:</strong> {{ number_format($order->total_amount) }}</p>
    <p><strong>Payment Method:</strong> {{ ucfirst($order->payment_method) }}</p>

    <h3>Items:</h3>
    <ul>
        @foreach($order->items as $item)
            <li>{{ $item->quantity }}x {{ $item->product->title ?? 'Product' }} ({{ $item->price }})</li>
        @endforeach
    </ul>

    <a href="{{ url('/admin/orders/' . $order->id) }}"
        style="background-color: #000; color: #fff; padding: 10px 20px; text-decoration: none;">View Order in Admin
        Panel</a>
</body>

</html>