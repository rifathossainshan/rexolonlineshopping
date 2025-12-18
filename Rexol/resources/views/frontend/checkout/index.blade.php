@extends('layouts.frontend')

@section('content')
    <div class="mb-3">
        <label class="form-label">Full Name</label>
        <input type="text" name="name" class="form-control" value="{{ Auth::user()->name ?? '' }}" required>
    </div>
    <div class="mb-3">
        <label class="form-label">Phone</label>
        <input type="text" name="phone" class="form-control" value="{{ Auth::user()->phone ?? '' }}" required>
    </div>
    <div class="mb-3">
        <label class="form-label">Address</label>
        <textarea name="address" class="form-control" rows="3" required></textarea>
    </div>

    <h4 class="mt-4 mb-3">Payment Method</h4>
    <div class="form-check mb-2">
        <input class="form-check-input" type="radio" name="payment_method" value="cod" id="cod" checked>
        <label class="form-check-label" for="cod">
            Cash on Delivery
        </label>
    </div>
    <div class="form-check mb-4">
        <input class="form-check-input" type="radio" name="payment_method" value="sslcommerz" id="sslcommerz" disabled>
        <label class="form-check-label" for="sslcommerz">
            Online Payment (SSLCommerz) - Coming Soon
        </label>
    </div>

    <button type="submit" class="btn btn-primary btn-lg w-100">Place Order</button>
    </form>
    </div>
    </div>
    </div>

    <div class="col-md-4">
        <div class="card">
            <div class="card-header">Order Summary</div>
            <div class="card-body">
                <ul class="list-group list-group-flush mb-3">
                    @php $subtotal = 0; @endphp
                    @foreach($cart as $details)
                        @php $subtotal += $details['price'] * $details['quantity']; @endphp
                        <li class="list-group-item d-flex justify-content-between lh-sm">
                            <div>
                                <h6 class="my-0">{{ $details['name'] }}</h6>
                                <small class="text-muted">Qty: {{ $details['quantity'] }}</small>
                            </div>
                            <span class="text-muted">৳{{ $details['price'] * $details['quantity'] }}</span>
                        </li>
                    @endforeach

                    @php
                        $discount = 0;
                        if (session()->has('coupon')) {
                            $coupon = session()->get('coupon');
                            if ($coupon['type'] == 'fixed') {
                                $discount = $coupon['value'];
                            } else {
                                $discount = ($subtotal * $coupon['value']) / 100;
                            }
                        }
                        $total = max(0, $subtotal - $discount);
                    @endphp

                    <li class="list-group-item d-flex justify-content-between">
                        <span>Subtotal</span>
                        <span>৳{{ $subtotal }}</span>
                    </li>

                    @if(session()->has('coupon'))
                        <li class="list-group-item d-flex justify-content-between text-success">
                            <span>Discount ({{ session()->get('coupon')['code'] }})</span>
                            <span>-৳{{ $discount }}</span>
                        </li>
                    @endif

                    <li class="list-group-item d-flex justify-content-between">
                        <span>Total (BDT)</span>
                        <strong>৳{{ $total }}</strong>
                    </li>
                </ul>

                <!-- Coupon Input -->
                @if(!session()->has('coupon'))
                    <form action="{{ route('cart.coupon.apply') }}" method="POST" class="mt-3">
                        @csrf
                        <div class="input-group">
                            <input type="text" name="code" class="form-control" placeholder="Promo code">
                            <button type="submit" class="btn btn-secondary">Redeem</button>
                        </div>
                    </form>
                @else
                    <form action="{{ route('cart.coupon.remove') }}" method="POST" class="mt-3">
                        @csrf
                        @method('DELETE')
                        <div class="alert alert-success d-flex justify-content-between align-items-center mb-0 p-2">
                            <small>Coupon applied</small>
                            <button type="submit" class="btn btn-sm btn-link text-danger p-0"
                                style="text-decoration: none;">Remove</button>
                        </div>
                    </form>
                @endif
            </div>
        </div>
    </div>
    </div>
    </div>
@endsection