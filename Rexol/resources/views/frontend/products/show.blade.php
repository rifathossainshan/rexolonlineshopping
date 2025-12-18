@extends('layouts.frontend')

@section('content')
    <div class="container mx-auto px-4 py-12">
        <div class="flex flex-col lg:flex-row gap-12">
            <!-- Product Images -->
            <div class="w-full lg:w-3/5">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    @forelse($product->images as $key => $image)
                        <div class="bg-gray-50 aspect-square overflow-hidden cursor-zoom-in group">
                            <img src="{{ $image->image }}" alt="{{ $product->title }}"
                                class="w-full h-full object-contain mix-blend-multiply transition-transform duration-500 group-hover:scale-110">
                        </div>
                    @empty
                        <div class="bg-gray-50 aspect-square overflow-hidden col-span-2">
                            <img src="https://via.placeholder.com/600x600" alt="{{ $product->title }}"
                                class="w-full h-full object-cover">
                        </div>
                    @endforelse
                </div>
            </div>

            <!-- Product Details -->
            <div class="w-full lg:w-2/5 relative">
                <div class="sticky top-24">
                    <p class="text-sm font-bold text-gray-400 uppercase tracking-widest mb-2">{{ $product->category->name }}
                    </p>
                    <h1 class="text-3xl md:text-5xl font-black uppercase tracking-tight mb-4 leading-none">
                        {{ $product->title }}</h1>

                    <div class="mb-6">
                        @if($product->discount_price && $product->discount_price > 0)
                            <div class="flex items-center space-x-4">
                                <span
                                    class="text-3xl font-black text-red-600">৳{{ number_format($product->discount_price) }}</span>
                                <span
                                    class="text-xl text-gray-400 line-through font-bold">৳{{ number_format($product->price) }}</span>
                            </div>
                        @else
                            <span class="text-3xl font-black text-black">৳{{ number_format($product->price) }}</span>
                        @endif
                    </div>

                    <div class="prose prose-sm text-gray-600 mb-8 max-w-none">
                        <p>{{ $product->description }}</p>
                    </div>

                    <form action="{{ route('cart.add', $product->id) }}" method="POST">
                        @csrf

                        <!-- Size Selector -->
                        @if($product->sizes)
                            <div class="mb-8">
                                <div class="flex justify-between items-center mb-3">
                                    <label class="text-sm font-bold uppercase">Select Size</label>
                                    <a href="#"
                                        class="text-xs font-bold uppercase underline text-gray-500 hover:text-black">Size
                                        Guide</a>
                                </div>
                                <div class="grid grid-cols-3 sm:grid-cols-4 gap-3">
                                    @foreach($product->sizes as $size)
                                        <label class="cursor-pointer">
                                            <input type="radio" name="size" value="{{ $size->name }}" class="peer sr-only" required>
                                            <div
                                                class="border border-gray-200 py-3 text-center text-sm font-bold uppercase peer-checked:bg-black peer-checked:text-white peer-checked:border-black hover:border-black transition-all">
                                                {{ $size->name }}
                                            </div>
                                        </label>
                                    @endforeach
                                </div>
                            </div>
                        @endif

                        <!-- Actions -->
                        <div class="flex flex-col gap-4">
                            @if($product->stock > 0)
                                <div class="flex gap-4">
                                    <div class="w-24">
                                        <input type="number" name="quantity" value="1" min="1" max="{{ $product->stock }}"
                                            class="w-full bg-gray-50 border border-gray-200 text-center font-bold py-4 focus:outline-none focus:border-black">
                                    </div>
                                    <button type="submit"
                                        class="flex-grow bg-black text-white font-black uppercase py-4 hover:bg-zinc-800 transition-colors">
                                        Add to Cart
                                    </button>
                                </div>
                                <button type="submit" name="buy_now" value="1"
                                    class="w-full bg-accent text-white font-black uppercase py-4 hover:bg-orange-600 transition-colors">
                                    Buy It Now
                                </button>
                            @else
                                <div
                                    class="w-full bg-gray-100 text-gray-400 font-bold uppercase py-4 text-center cursor-not-allowed">
                                    Out of Stock
                                </div>
                            @endif
                        </div>
                    </form>

                    <!-- Features -->
                    <div class="mt-8 border-t border-gray-100 pt-6 space-y-4">
                        <div class="flex items-center space-x-3 text-sm font-bold text-gray-600">
                            <i class="fas fa-check-circle text-green-500"></i>
                            <span>100% Authentic Guarantee</span>
                        </div>
                        <div class="flex items-center space-x-3 text-sm font-bold text-gray-600">
                            <i class="fas fa-truck text-black"></i>
                            <span>Fast Shipping Available</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection