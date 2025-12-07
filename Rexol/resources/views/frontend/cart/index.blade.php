@extends('layouts.frontend')

@section('content')
    <div class="container">
        <h2 class="mb-4">Shopping Cart</h2>

        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif
        @if(session('error'))
            <div class="alert alert-danger">{{ session('error') }}</div>
        @endif

        @if(count($cart) > 0)
            <div class="row">
                <div class="col-md-9">
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>Image</th>
                                    <th>Product</th>
                                    <th>Size</th>
                                    <th>Price</th>
                                    <th>Quantity</th>
                                    <th>Total</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php $total = 0; @endphp
                                @foreach($cart as $id => $details)
                                    @php $total += $details['price'] * $details['quantity']; @endphp
                                    <tr>
                                        <td style="width: 100px;">
                                            <img src="{{ $details['image'] }}" class="img-fluid" alt="{{ $details['name'] }}">
                                        </td>
                                        <td>{{ $details['name'] }}</td>
                                        <td>{{ $details['size'] ?? '-' }}</td>
                                        <td>৳{{ $details['price'] }}</td>
                                        <td style="width: 150px;">
                                            <form action="{{ route('cart.update', $id) }}" method="POST" class="d-flex gap-2">
                                                @csrf
                                                <input type="number" name="quantity" value="{{ $details['quantity'] }}"
                                                    class="form-control" min="1">
                                                <button type="submit" class="btn btn-sm btn-secondary">Update</button>
                                            </form>
                                        </td>
                                        <td>৳{{ $details['price'] * $details['quantity'] }}</td>
                                        <td>
                                            <a href="{{ route('cart.remove', $id) }}" class="btn btn-sm btn-danger">Remove</a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>

                <div class="col-md-3">
                    <div class="card">
                        <div class="card-header">Cart Summary</div>
                        <div class="card-body">
                            <h5 class="card-title d-flex justify-content-between mb-3">
                                <span>Subtotal:</span>
                                <span class="fw-bold">৳{{ $total }}</span>
                            </h5>

                            @if(session()->has('coupon'))
                                @php
                                    $coupon = session()->get('coupon');
                                    $discount = 0;
                                    if ($coupon['type'] == 'fixed') {
                                        $discount = $coupon['value'];
                                    } else {
                                        $discount = ($total * $coupon['value']) / 100;
                                    }
                                @endphp
                                <h5 class="card-title d-flex justify-content-between text-success mb-3">
                                    <span>Discount ({{ $coupon['code'] }}):</span>
                                    <span>-৳{{ number_format($discount, 0) }}</span>
                                </h5>
                                <form action="{{ route('cart.coupon.remove') }}" method="POST" class="mb-3">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-outline-danger w-100">Remove Coupon</button>
                                </form>
                                <hr>
                                <h5 class="card-title d-flex justify-content-between mb-3">
                                    <span>Grand Total:</span>
                                    <span class="fw-bold">৳{{ max(0, $total - $discount) }}</span>
                                </h5>
                            @else
                                <form action="{{ route('cart.coupon.apply') }}" method="POST" class="mb-3">
                                    @csrf
                                    <div class="input-group">
                                        <input type="text" name="code" class="form-control" placeholder="Coupon Code">
                                        <button class="btn btn-outline-secondary" type="submit">Apply</button>
                                    </div>
                                </form>
                                <hr>
                                <h5 class="card-title d-flex justify-content-between mb-3">
                                    <span>Grand Total:</span>
                                    <span class="fw-bold">৳{{ $total }}</span>
                                </h5>
                            @endif

                            <a href="{{ route('checkout.index') }}" class="btn btn-success w-100 mt-3">Proceed to Checkout</a>
                        </div>
                    </div>
                </div>
            </div>
        @else
            <div class="alert alert-info">
                Your cart is empty. <a href="{{ route('products.index') }}">Start Shopping</a>
            </div>
        @endif
    </div>
@endsection