@extends('layouts.frontend')

@section('content')
    <div class="container mx-auto px-4 py-12">
        <h1 class="text-3xl md:text-4xl font-black uppercase tracking-tighter mb-8 md:mb-12 text-center md:text-left">
            Shopping Bag</h1>

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
            <div class="flex flex-col lg:flex-row gap-8 lg:gap-12">
                <!-- Cart Items -->
                <div class="w-full lg:w-2/3">
                    <!-- Desktop Table (Hidden on Mobile) -->
                    <div class="hidden md:block">
                        <table class="w-full text-left border-collapse">
                            <thead class="text-xs font-bold uppercase text-gray-400 border-b border-gray-100">
                                <tr>
                                    <th class="pb-4">Product</th>
                                    <th class="pb-4">Price</th>
                                    <th class="pb-4">Quantity</th>
                                    <th class="pb-4 text-right">Total</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-100">
                                @php $total = 0; @endphp
                                @foreach($cart as $id => $details)
                                    @php $total += $details['price'] * $details['quantity']; @endphp
                                    <tr class="group">
                                        <td class="py-6">
                                            <div class="flex items-center">
                                                <img src="{{ $details['image'] }}" class="w-20 h-20 object-cover mr-6"
                                                    alt="{{ $details['name'] }}">
                                                <div>
                                                    <h6
                                                        class="text-sm font-bold uppercase text-black mb-1 group-hover:text-accent transition-colors">
                                                        <a
                                                            href="{{ route('products.show', \Illuminate\Support\Str::slug($details['name'])) }}">{{ $details['name'] }}</a>
                                                    </h6>
                                                    @if(isset($details['size']))
                                                        <span class="text-xs font-bold text-gray-400 uppercase block mb-2">Size:
                                                            {{ $details['size'] }}</span>
                                                    @endif
                                                    <a href="{{ route('cart.remove', $id) }}"
                                                        class="text-xs font-bold uppercase text-red-600 hover:text-red-800 transition-colors">Remove</a>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="py-6 font-bold text-sm">৳{{ number_format($details['price']) }}</td>
                                        <td class="py-6">
                                            <form action="{{ route('cart.update', $id) }}" method="POST">
                                                @csrf
                                                <input type="number" name="quantity" value="{{ $details['quantity'] }}"
                                                    class="w-16 text-center border border-gray-200 font-bold py-2 text-sm focus:outline-none focus:border-black"
                                                    min="1" onchange="this.form.submit()">
                                            </form>
                                        </td>
                                        <td class="py-6 text-right font-black text-sm">
                                            ৳{{ number_format($details['price'] * $details['quantity']) }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <!-- Mobile Stacked View (Visible on Mobile) -->
                    <div class="md:hidden space-y-6">
                        @foreach($cart as $id => $details)
                            <div class="flex gap-4 border border-gray-100 p-4">
                                <img src="{{ $details['image'] }}" class="w-20 h-20 object-cover" alt="{{ $details['name'] }}">
                                <div class="flex-grow">
                                    <div class="flex justify-between items-start mb-2">
                                        <h6 class="text-sm font-bold uppercase text-black max-w-[70%]">
                                            <a
                                                href="{{ route('products.show', \Illuminate\Support\Str::slug($details['name'])) }}">{{ $details['name'] }}</a>
                                        </h6>
                                        <a href="{{ route('cart.remove', $id) }}" class="text-gray-400 hover:text-red-600">
                                            <i class="fas fa-times"></i>
                                        </a>
                                    </div>
                                    @if(isset($details['size']))
                                        <span class="text-xs font-bold text-gray-400 uppercase block mb-2">Size:
                                            {{ $details['size'] }}</span>
                                    @endif

                                    <div class="flex justify-between items-center mt-3">
                                        <form action="{{ route('cart.update', $id) }}" method="POST">
                                            @csrf
                                            <input type="number" name="quantity" value="{{ $details['quantity'] }}"
                                                class="w-14 text-center border border-gray-200 font-bold py-1 text-sm focus:outline-none focus:border-black"
                                                min="1" onchange="this.form.submit()">
                                        </form>
                                        <span
                                            class="font-black text-sm">৳{{ number_format($details['price'] * $details['quantity']) }}</span>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>

                <!-- Order Summary -->
                <div class="w-full lg:w-1/3">
                    <div class="bg-gray-50 p-6 md:p-8 sticky top-24">
                        <h4 class="text-lg font-black uppercase mb-6 tracking-tight">Summary</h4>

                        <div class="flex justify-between mb-4 text-sm">
                            <span class="font-bold text-gray-500 uppercase">Subtotal</span>
                            <span class="font-bold">৳{{ number_format($total) }}</span>
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
                            <div class="flex justify-between mb-2 text-sm text-green-600">
                                <span class="font-bold uppercase">Discount</span>
                                <span class="font-bold">-৳{{ number_format($discount) }}</span>
                            </div>
                            <form action="{{ route('cart.coupon.remove') }}" method="POST" class="mb-6 text-right">
                                @csrf
                                @method('DELETE')
                                <button type="submit"
                                    class="text-xs font-bold uppercase text-red-500 hover:text-red-700 underline">Remove
                                    Coupon</button>
                            </form>
                            <div class="border-t border-gray-200 my-4"></div>
                            <div class="flex justify-between mb-6 text-lg">
                                <span class="font-black uppercase">Total</span>
                                <span class="font-black">৳{{ number_format(max(0, $total - $discount)) }}</span>
                            </div>
                        @else
                            <form action="{{ route('cart.coupon.apply') }}" method="POST" class="mb-6">
                                @csrf
                                <label class="block text-xs font-bold uppercase text-gray-400 mb-2">Coupon Code</label>
                                <div class="flex">
                                    <input type="text" name="code"
                                        class="flex-grow border border-gray-300 px-4 py-2 text-sm font-bold uppercase focus:outline-none focus:border-black placeholder-gray-400"
                                        placeholder="ENTER CODE">
                                    <button
                                        class="bg-black text-white px-6 py-2 font-bold uppercase text-sm hover:bg-gray-800 transition-colors"
                                        type="submit">Apply</button>
                                </div>
                            </form>
                            <div class="border-t border-gray-200 my-4"></div>
                            <div class="flex justify-between mb-6 text-lg">
                                <span class="font-black uppercase">Total</span>
                                <span class="font-black">৳{{ number_format($total) }}</span>
                            </div>
                        @endif

                        <a href="{{ route('checkout.index') }}"
                            class="block w-full bg-black text-white text-center py-4 font-bold uppercase text-sm hover:bg-gray-900 transition-colors mb-4">
                            Proceed to Checkout
                        </a>
                        <a href="{{ route('products.index') }}"
                            class="block w-full border border-black text-black text-center py-4 font-bold uppercase text-sm hover:bg-black hover:text-white transition-colors">
                            Continue Shopping
                        </a>
                    </div>
                </div>
            </div>
        @else
            <div class="text-center py-20 bg-gray-50">
                <i class="fas fa-shopping-bag text-6xl text-gray-200 mb-6"></i>
                <h3 class="text-xl font-black uppercase mb-2">Your Cart is Empty</h3>
                <p class="text-gray-500 mb-8 max-w-md mx-auto">Looks like you haven't added anything to your cart yet. Browse
                    our collection to find your new favorites.</p>
                <a href="{{ route('products.index') }}"
                    class="inline-block bg-black text-white px-8 py-3 font-bold uppercase tracking-widest hover:bg-gray-900 transition-colors">
                    Start Shopping
                </a>
            </div>
        @endif
    </div>
@endsection