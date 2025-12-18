@extends('layouts.frontend')

@section('content')
    <div class="container mx-auto px-4 py-12">
        <h1 class="text-4xl font-black uppercase tracking-tighter mb-12">Shopping Bag</h1>

        @if(session('success'))
            <div class="bg-green-50 text-green-800 px-4 py-3 rounded mb-8 border border-green-200 flex items-center">
                <i class="fas fa-check-circle mr-2"></i> {{ session('success') }}
            </div>
        @endif
        @if(session('error'))
            <div class="bg-red-50 text-red-800 px-4 py-3 rounded mb-8 border border-red-200 flex items-center">
                <i class="fas fa-exclamation-circle mr-2"></i> {{ session('error') }}
            </div>
        @endif

        @if(count($cart) > 0)
            <div class="row g-5">
                <div class="col-lg-8">
                    <div class="table-responsive">
                        <table class="table align-middle">
                            <thead class="text-uppercase small fw-bold text-muted border-bottom-0">
                                <tr>
                                    <th class="border-0 pb-3 ps-0">Product</th>
                                    <th class="border-0 pb-3">Price</th>
                                    <th class="border-0 pb-3">Quantity</th>
                                    <th class="border-0 pb-3 text-end pe-0">Total</th>
                                </tr>
                            </thead>
                            <tbody class="border-top-0">
                                @php $total = 0; @endphp
                                @foreach($cart as $id => $details)
                                    @php $total += $details['price'] * $details['quantity']; @endphp
                                    <tr class="border-bottom">
                                        <td class="py-4 ps-0">
                                            <div class="d-flex align-items-center">
                                                <img src="{{ $details['image'] }}" class="img-fluid me-4"
                                                    alt="{{ $details['name'] }}"
                                                    style="width: 80px; height: 80px; object-fit: cover;">
                                                <div>
                                                    <h6 class="mb-1 text-uppercase fw-bold">{{ $details['name'] }}</h6>
                                                    @if(isset($details['size']))
                                                        <small class="text-muted d-block mb-2">Size: {{ $details['size'] }}</small>
                                                    @endif
                                                    <a href="{{ route('cart.remove', $id) }}"
                                                        class="text-danger small text-decoration-none fw-bold text-uppercase">Remove</a>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="py-4 fw-bold">৳{{ number_format($details['price']) }}</td>
                                        <td class="py-4" style="width: 150px;">
                                            <form action="{{ route('cart.update', $id) }}" method="POST" class="cart-update-form">
                                                @csrf
                                                <input type="number" name="quantity" value="{{ $details['quantity'] }}"
                                                    class="form-control text-center border-0 bg-light fw-bold" min="1"
                                                    onchange="this.form.submit()">
                                            </form>
                                        </td>
                                        <td class="py-4 text-end pe-0 fw-bold">
                                            ৳{{ number_format($details['price'] * $details['quantity']) }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>

                <div class="col-lg-4">
                    <div class="bg-light p-4">
                        <h4 class="text-uppercase fw-bold mb-4">Summary</h4>

                        <div class="d-flex justify-content-between mb-3">
                            <span class="text-uppercase fw-bold small">Subtotal</span>
                            <span class="fw-bold">৳{{ number_format($total) }}</span>
                        </div>

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
                            <div class="d-flex justify-content-between mb-3 text-success">
                                <span class="text-uppercase fw-bold small">Discount</span>
                                <span>-৳{{ number_format($discount) }}</span>
                            </div>
                            <form action="{{ route('cart.coupon.remove') }}" method="POST" class="mb-4">
                                @csrf
                                @method('DELETE')
                                <button type="submit"
                                    class="btn btn-link px-0 text-danger text-decoration-none small text-uppercase fw-bold">Remove
                                    Coupon</button>
                            </form>
                            <hr class="my-4">
                            <div class="d-flex justify-content-between mb-4">
                                <span class="text-uppercase fw-bold">Total</span>
                                <span class="fw-bold fs-4">৳{{ number_format(max(0, $total - $discount)) }}</span>
                            </div>
                        @else
                            <form action="{{ route('cart.coupon.apply') }}" method="POST" class="mb-4">
                                @csrf
                                <label class="form-label text-uppercase small fw-bold text-muted">Coupon Code</label>
                                <div class="input-group">
                                    <input type="text" name="code" class="form-control border-secondary rounded-0"
                                        placeholder="ENTER CODE">
                                    <button class="btn btn-dark rounded-0 px-3" type="submit">APPLY</button>
                                </div>
                            </form>
                            <hr class="my-4">
                            <div class="d-flex justify-content-between mb-4">
                                <span class="text-uppercase fw-bold">Total</span>
                                <span class="fw-bold fs-4">৳{{ number_format($total) }}</span>
                            </div>
                        @endif

                        <a href="{{ route('checkout.index') }}"
                            class="btn btn-dark w-100 py-3 fw-bold rounded-0 text-uppercase">Proceed to Checkout</a>
                        <a href="{{ route('products.index') }}"
                            class="btn btn-outline-dark w-100 py-3 fw-bold rounded-0 text-uppercase mt-2">Continue Shopping</a>
                    </div>
                </div>
            </div>
        @else
            <div class="text-center py-5">
                <i class="fas fa-shopping-bag display-1 text-muted mb-4 opacity-25"></i>
                <h3 class="text-uppercase fw-bold mb-3">Your Cart is Empty</h3>
                <p class="text-muted mb-4">Looks like you haven't added anything to your cart yet.</p>
                <a href="{{ route('products.index') }}" class="btn btn-dark px-5 py-3 rounded-0 text-uppercase fw-bold">Start
                    Shopping</a>
            </div>
        @endif
    </div>
@endsection