@extends('layouts.frontend')

@section('content')
    <div class="container mx-auto px-4 py-8 md:py-12">
        <h1 class="text-2xl md:text-3xl font-black uppercase tracking-tighter mb-8 text-center md:text-left">Checkout</h1>

        <!-- Global Errors -->
        @if(session('error'))
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-6 font-bold uppercase text-sm"
                role="alert">
                <span class="block sm:inline">{{ session('error') }}</span>
            </div>
        @endif
        @if ($errors->any())
            <div
                class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-6 font-bold uppercase text-sm">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>• {{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('checkout.store') }}" method="POST">
            @csrf
            <div class="flex flex-col lg:flex-row gap-8 lg:gap-12">

                <!-- Billing Details -->
                <div class="w-full lg:w-2/3">
                    <div class="bg-white p-0 md:p-6">
                        <h4 class="text-xl font-bold uppercase mb-6 border-b border-gray-100 pb-4">Billing Details</h4>

                        <div class="space-y-6">
                            <div>
                                <label class="block text-sm font-bold uppercase text-gray-800 mb-2">Full Name</label>
                                <input type="text" name="name"
                                    class="w-full bg-gray-50 border border-gray-200 px-4 py-3 font-bold focus:outline-none focus:border-black focus:ring-0 transition-colors @error('name') border-red-500 @enderror"
                                    value="{{ old('name', Auth::user()->name ?? '') }}" required>
                                @error('name')
                                    <p class="text-red-500 text-xs mt-1 font-bold">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label class="block text-sm font-bold uppercase text-gray-800 mb-2">Phone</label>
                                <input type="text" name="phone"
                                    class="w-full bg-gray-50 border border-gray-200 px-4 py-3 font-bold focus:outline-none focus:border-black focus:ring-0 transition-colors @error('phone') border-red-500 @enderror"
                                    value="{{ old('phone', Auth::user()->phone ?? '') }}" required>
                                @error('phone')
                                    <p class="text-red-500 text-xs mt-1 font-bold">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label class="block text-sm font-bold uppercase text-gray-800 mb-2">Delivery Address</label>
                                <textarea name="address"
                                    class="w-full bg-gray-50 border border-gray-200 px-4 py-3 font-bold focus:outline-none focus:border-black focus:ring-0 transition-colors @error('address') border-red-500 @enderror"
                                    rows="3" required>{{ old('address') }}</textarea>
                                @error('address')
                                    <p class="text-red-500 text-xs mt-1 font-bold">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <div class="mt-10">
                            <h4 class="text-xl font-bold uppercase mb-6 border-b border-gray-100 pb-4">Payment Method</h4>

                            <div class="space-y-4">
                                <label
                                    class="flex items-center space-x-3 cursor-pointer group p-4 border border-black bg-gray-50">
                                    <input type="radio" name="payment_method" value="cod"
                                        class="text-black focus:ring-black" checked>
                                    <span class="font-bold uppercase group-hover:text-black">Cash on Delivery</span>
                                </label>

                                <span class="font-bold uppercase group-hover:text-black">Cash on Delivery</span>
                                </label>

                                <label class="flex items-center space-x-3 cursor-pointer group p-4 border border-gray-200">
                                    <input type="radio" name="payment_method" value="stripe"
                                        class="text-black focus:ring-black" id="payment_stripe">
                                    <span class="font-bold uppercase group-hover:text-black">Credit Card (Stripe)</span>
                                </label>

                                <!-- Stripe Elements Placeholder -->
                                <div id="stripe-card-element" class="hidden p-4 border border-gray-200 bg-gray-50 mt-4">
                                    <label class="block text-sm font-bold uppercase text-gray-800 mb-2">Card Details</label>
                                    <div id="card-element" class="p-3 bg-white border border-gray-200">
                                        <!-- A Stripe Element will be inserted here. -->
                                    </div>
                                    <div id="card-errors" role="alert" class="text-red-500 text-xs mt-2 font-bold"></div>
                                    <input type="hidden" name="stripeToken" id="stripeToken">
                                </div>
                            </div>
                        </div>

                        <button type="submit"
                            class="w-full bg-black text-white py-4 mt-8 font-black uppercase tracking-widest hover:bg-zinc-800 transition-colors text-lg">
                            Place Order
                        </button>
                    </div>
                </div>

                <!-- Order Summary -->
                <div class="w-full lg:w-1/3">
                    <div class="bg-gray-50 p-6 md:p-8 sticky top-24 border border-gray-100">
                        <h4 class="text-lg font-black uppercase mb-6 tracking-tight">Your Order</h4>

                        <div class="space-y-4 mb-6">
                            @php $subtotal = 0; @endphp
                            @foreach($cart as $details)
                                @php $subtotal += $details['price'] * $details['quantity']; @endphp
                                <div class="flex justify-between items-start text-sm">
                                    <div class="pr-4">
                                        <p class="font-bold uppercase leading-tight">{{ $details['name'] }}</p>
                                        <p class="text-xs text-gray-500 mt-1">Qty: {{ $details['quantity'] }}</p>
                                    </div>
                                    <span
                                        class="font-bold whitespace-nowrap">৳{{ number_format($details['price'] * $details['quantity']) }}</span>
                                </div>
                            @endforeach
                        </div>

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

                        <div class="border-t border-gray-200 py-4 space-y-2">
                            <div class="flex justify-between text-sm">
                                <span class="font-bold text-gray-600 uppercase">Subtotal</span>
                                <span class="font-bold">৳{{ number_format($subtotal) }}</span>
                            </div>

                            @if(session()->has('coupon'))
                                <div class="flex justify-between text-sm text-green-600">
                                    <span class="font-bold uppercase">Discount ({{ session()->get('coupon')['code'] }})</span>
                                    <span class="font-bold">-৳{{ number_format($discount) }}</span>
                                </div>
                            @endif
                        </div>

                        <div class="border-t-2 border-black py-4 flex justify-between items-center">
                            <span class="font-black uppercase text-lg">Total</span>
                            <span class="font-black text-xl">৳{{ number_format($total) }}</span>
                        </div>

                        <!-- Coupon Input -->
                        @if(!session()->has('coupon'))
                            {{-- Coupon form inside checkout usually not needed if handled in cart,
                            but kept for completeness, ensuring separate form tag to avoid nesting --}}
                        @else
                            {{-- Cannot nest update form inside the main order form.
                            Ideally user manages coupon in cart.
                            Display only here. --}}
                            <div class="bg-green-100 text-green-800 text-xs font-bold uppercase p-2 text-center mt-2">
                                Coupon Applied
                            </div>
                        @endif

                        <p class="text-xs text-gray-400 mt-4 text-center leading-relaxed">
                            By placing your order, you agree to our Terms of Service and Privacy Policy.
                        </p>
                    </div>
                </div>
            </div>
        </form>
    </div>

    <!-- Stripe JS -->
    <script src="https://js.stripe.com/v3/"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const stripe = Stripe('{{ config('services.stripe.key') }}');
            const elements = stripe.elements();
            const card = elements.create('card', {
                style: {
                    base: {
                        color: '#32325d',
                        fontFamily: '"Helvetica Neue", Helvetica, sans-serif',
                        fontSmoothing: 'antialiased',
                        fontSize: '16px',
                        '::placeholder': {
                            color: '#aab7c4'
                        }
                    },
                    invalid: {
                        color: '#fa755a',
                        iconColor: '#fa755a'
                    }
                }
            });

            // Handle Payment Method Toggle
            const stripeRadio = document.getElementById('payment_stripe');
            const stripeContainer = document.getElementById('stripe-card-element');
            const paymentRadios = document.querySelectorAll('input[name="payment_method"]');

            function toggleStripe() {
                if (stripeRadio.checked) {
                    stripeContainer.classList.remove('hidden');
                    card.mount('#card-element');
                } else {
                    stripeContainer.classList.add('hidden');
                    card.unmount();
                }
            }

            paymentRadios.forEach(radio => radio.addEventListener('change', toggleStripe));

            // Handle Form Submission
            const form = document.querySelector('form');
            form.addEventListener('submit', function (event) {
                if (stripeRadio.checked) {
                    event.preventDefault();

                    stripe.createToken(card).then(function (result) {
                        if (result.error) {
                            // Inform the user if there was an error.
                            const errorElement = document.getElementById('card-errors');
                            errorElement.textContent = result.error.message;
                        } else {
                            // Send the token to your server.
                            document.getElementById('stripeToken').value = result.token.id;
                            form.submit();
                        }
                    });
                }
            });
        });
    </script>
@endsection