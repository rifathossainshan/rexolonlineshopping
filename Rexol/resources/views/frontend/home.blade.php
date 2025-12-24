@extends('layouts.frontend')

@section('content')
    <!-- Hero Slider -->
    <div class="relative w-full h-[600px] md:h-[800px] overflow-hidden bg-black text-white group">
        <div id="hero-slider" class="relative w-full h-full">
            @forelse($heroSlides as $key => $slide)
                <div class="absolute inset-0 w-full h-full transition-opacity duration-1000 ease-in-out {{ $key === 0 ? 'opacity-100 relative z-10' : 'opacity-0 z-0' }}"
                    data-index="{{ $key }}">
                    <!-- Background Image -->
                    <div class="absolute inset-0">
                        <img src="{{ $slide->image }}" alt="{{ $slide->title }}" class="w-full h-full object-cover opacity-60">
                    </div>
                    <!-- Content -->
                    <div class="relative z-10 h-full flex flex-col justify-center items-start px-6 md:px-20 max-w-7xl mx-auto">
                        <p class="text-accent font-bold tracking-[0.2em] uppercase mb-4 animate-fade-in-up">
                            {{ $slide->sub_title }}</p>
                        <h1
                            class="text-5xl md:text-8xl font-black uppercase leading-none mb-8 tracking-tighter animate-fade-in-up delay-100">
                            {!! nl2br(e($slide->title)) !!}
                        </h1>
                        @if($slide->link)
                            <a href="{{ $slide->link }}"
                                class="inline-block border-2 border-white text-white px-10 py-4 font-bold uppercase tracking-widest hover:bg-white hover:text-black transition-all duration-300 animate-fade-in-up delay-200">
                                Shop Now <i class="fas fa-arrow-right ml-2"></i>
                            </a>
                        @endif
                    </div>
                </div>
            @empty
                <!-- Fallback Slide -->
                <div class="absolute inset-0 w-full h-full transition-opacity duration-1000 ease-in-out opacity-100 relative z-10"
                    data-index="0">
                    <div class="absolute inset-0">
                        <img src="https://images.unsplash.com/photo-1552346154-21d32810aba3?auto=format&fit=crop&q=80&w=2070"
                            class="w-full h-full object-cover opacity-60">
                    </div>
                    <div class="relative z-10 h-full flex flex-col justify-center items-start px-6 md:px-20 max-w-7xl mx-auto">
                        <p class="text-accent font-bold tracking-[0.2em] uppercase mb-4 animate-fade-in-up">The Future of
                            Sneakers</p>
                        <h1
                            class="text-5xl md:text-8xl font-black uppercase leading-none mb-8 tracking-tighter animate-fade-in-up delay-100">
                            Step Into <br> The New Era
                        </h1>
                        <a href="{{ route('products.index') }}"
                            class="inline-block border-2 border-white text-white px-10 py-4 font-bold uppercase tracking-widest hover:bg-white hover:text-black transition-all duration-300 animate-fade-in-up delay-200">
                            Shop Collection <i class="fas fa-arrow-right ml-2"></i>
                        </a>
                    </div>
                </div>
            @endforelse
        </div>

        <!-- Slider Indicators -->
        <div class="absolute bottom-10 left-6 md:left-24 flex space-x-4 z-20">
            @forelse($heroSlides as $key => $slide)
                <button onclick="goToSlide({{ $key }})"
                    class="w-12 h-1 bg-white transition-opacity duration-300 {{ $key === 0 ? 'opacity-100' : 'opacity-50' }}"></button>
            @empty
                <button onclick="goToSlide(0)" class="w-12 h-1 bg-white transition-opacity duration-300 opacity-100"></button>
            @endforelse
        </div>
    </div>

    <!-- Brand Ticker -->
    <div class="bg-black py-8 border-t border-gray-800 overflow-hidden">
        <div class="flex whitespace-nowrap justify-center w-full px-4 overflow-x-auto no-scrollbar">
            <div class="flex space-x-12">
                @foreach($brandCategories as $brand)
                    <a href="{{ route('products.index', ['category' => $brand->slug]) }}"
                        class="text-2xl md:text-4xl font-black text-gray-700 hover:text-white uppercase transition-colors duration-300">
                        {{ $brand->name }}
                    </a>
                @endforeach
            </div>
        </div>
    </div>

    <!-- Gender Section -->
    <div class="container mx-auto px-4 py-16">
        <h2 class="text-4xl font-black uppercase mb-12 text-center tracking-tighter">Shop By Gender</h2>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            @foreach($genderCategories as $gender)
                <div class="group relative h-[600px] overflow-hidden cursor-pointer"
                    onclick="window.location.href='{{ route('products.index', ['gender' => $gender->name]) }}'">
                    <img src="{{ $gender->image ? asset('storage/' . $gender->image) : 'https://via.placeholder.com/600x800' }}"
                        alt="{{ $gender->name }}"
                        class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-110 grayscale group-hover:grayscale-0">
                    <div class="absolute inset-0 bg-gradient-to-t from-black via-transparent to-transparent opacity-90"></div>
                    <div class="absolute bottom-0 left-0 p-10">
                        <h3
                            class="text-5xl font-black text-white uppercase italic mb-2 transform translate-y-4 group-hover:translate-y-0 transition-transform duration-300">
                            {{ $gender->name }}</h3>
                        <p
                            class="text-white text-lg font-bold opacity-0 group-hover:opacity-100 transition-opacity duration-300 flex items-center">
                            View Collection <i class="fas fa-arrow-right ml-2"></i>
                        </p>
                    </div>
                </div>
            @endforeach
        </div>
    </div>

    <!-- Best Sellers -->
    <div class="container mx-auto px-4 py-16 border-t border-gray-200">
        <div class="flex justify-between items-end mb-10">
            <h2 class="text-4xl font-black uppercase tracking-tighter">Best Sellers</h2>
            <a href="{{ route('products.index') }}"
                class="text-sm font-bold uppercase underline decoration-2 underline-offset-4 hover:text-accent">View All</a>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-8">
            @foreach($bestSellers as $product)
                <div class="group relative bg-white border border-gray-100 hover:border-black transition-colors duration-300">
                    <div class="relative h-[350px] bg-gray-50 overflow-hidden flex items-center justify-center p-4">
                        @if($loop->index < 2)
                            <span
                                class="absolute top-0 left-0 bg-red-600 text-white text-xs font-bold uppercase px-3 py-1.5 z-20">Hot</span>
                        @endif

                        <img src="{{ $product->images->first()->image ?? 'https://via.placeholder.com/300' }}"
                            alt="{{ $product->title }}"
                            class="max-w-[90%] max-h-[90%] object-contain transition-transform duration-500 group-hover:rotate-[-5deg] group-hover:scale-110 mix-blend-multiply">

                        <!-- Wishlist Button -->
                        <a href="{{ session('wishlist') && isset(session('wishlist')[$product->id]) ? route('wishlist.remove', $product->id) : route('wishlist.add', $product->id) }}"
                            class="absolute top-4 right-4 w-10 h-10 bg-white rounded-full flex items-center justify-center shadow-md z-20 hover:bg-gray-100 transition"
                            onclick="toggleWishlist(event, {{ $product->id }})">
                            <i
                                class="{{ session('wishlist') && isset(session('wishlist')[$product->id]) ? 'fas fa-heart text-red-600' : 'far fa-heart text-black' }}"></i>
                        </a>

                        <!-- Quick Add Overlay (Mobile safe by checking group-hover) -->
                        <div
                            class="absolute bottom-0 left-0 w-full p-4 transform translate-y-full group-hover:translate-y-0 transition-transform duration-300 z-20">
                            <a href="{{ route('products.show', $product->slug) }}"
                                class="block w-full bg-black text-white text-center py-3 font-bold uppercase text-sm hover:bg-accent transition-colors">
                                Add to Cart -
                                {{ $product->discount_price > 0 ? '৳' . number_format($product->discount_price) : '৳' . number_format($product->price) }}
                            </a>
                        </div>
                    </div>

                    <div class="p-6">
                        <p class="text-xs font-bold text-gray-400 uppercase mb-1">{{ $product->category->name ?? 'Sneakers' }}
                        </p>
                        <h3
                            class="text-lg font-bold text-black uppercase leading-tight mb-2 truncate group-hover:text-accent transition-colors">
                            {{ $product->title }}</h3>
                        <div class="flex items-center space-x-2">
                            @if($product->discount_price && $product->discount_price > 0)
                                <span class="text-lg font-black text-red-600">৳{{ number_format($product->discount_price) }}</span>
                                <span class="text-sm text-gray-400 line-through">৳{{ number_format($product->price) }}</span>
                            @else
                                <span class="text-lg font-black text-black">৳{{ number_format($product->price) }}</span>
                            @endif
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>

    <!-- Fresh Drops -->
    <div class="bg-gray-50 py-16">
        <div class="container mx-auto px-4">
            <div class="flex justify-between items-end mb-10">
                <h2 class="text-4xl font-black uppercase tracking-tighter">Fresh Drops</h2>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-8">
                @foreach($newArrivals->take(4) as $product)
                    <div
                        class="group relative bg-white border border-transparent hover:border-black transition-colors duration-300">
                        <div class="relative h-[350px] overflow-hidden flex items-center justify-center p-4">
                            <span
                                class="absolute top-0 left-0 bg-black text-white text-xs font-bold uppercase px-3 py-1.5 z-20">New</span>

                            <img src="{{ $product->images->first()->image ?? 'https://via.placeholder.com/300' }}"
                                alt="{{ $product->title }}"
                                class="max-w-[90%] max-h-[90%] object-contain transition-transform duration-500 group-hover:scale-105 mix-blend-multiply">

                            <a href="{{ route('products.show', $product->slug) }}" class="absolute inset-0 z-10"></a>
                        </div>
                        <div class="p-6 pt-0">
                            <h3 class="text-lg font-bold uppercase truncate">{{ $product->title }}</h3>
                            <p class="text-gray-500 text-sm mt-1">৳{{ number_format($product->price) }}</p>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>

    <!-- Newsletter -->
    <div class="bg-accent text-white py-20">
        <div class="container mx-auto px-4 text-center max-w-2xl">
            <h2 class="text-4xl md:text-5xl font-black uppercase mb-4">Never Miss A Drop</h2>
            <p class="text-lg font-medium opacity-90 mb-8">Sign up for updates on new releases, styling tips, and exclusive
                access.</p>
            <div class="flex flex-col md:flex-row gap-4">
                <input type="email" placeholder="ENTER EMAIL ADDRESS"
                    class="flex-grow px-6 py-4 bg-white text-black font-bold uppercase placeholder-gray-400 focus:outline-none focus:ring-0 rounded-none border-none">
                <button
                    class="px-10 py-4 bg-black text-white font-black uppercase hover:bg-gray-900 transition-colors tracking-widest">
                    Join
                </button>
            </div>
        </div>
    </div>

    <!-- Custom Slider Script -->
    <script>
        let currentSlide = 0;
        const slides = document.querySelectorAll('#hero-slider > div');
        const indicators = document.querySelectorAll('.bottom-10 button');
        const totalSlides = slides.length;

        function goToSlide(index) {
            slides[currentSlide].classList.remove('opacity-100', 'z-10');
            slides[currentSlide].classList.add('opacity-0', 'z-0');
            indicators[currentSlide].classList.add('opacity-50');

            currentSlide = index;

            slides[currentSlide].classList.remove('opacity-0', 'z-0');
            slides[currentSlide].classList.add('opacity-100', 'z-10');
            indicators[currentSlide].classList.remove('opacity-50');
        }

        setInterval(() => {
            let next = (currentSlide + 1) % totalSlides;
            goToSlide(next);
        }, 5000);
    </script>
@endsection