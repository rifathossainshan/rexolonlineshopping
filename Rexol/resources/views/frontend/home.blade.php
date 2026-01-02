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
                            {{ $slide->sub_title }}
                        </p>
                        <h1
                            class="text-5xl md:text-8xl font-black uppercase leading-none mb-8 tracking-tighter animate-fade-in-up delay-100">
                            {!! nl2br(e($slide->title)) !!}
                        </h1>
                        @if($slide->link)
                            <a href="{{ $slide->link }}"
                                class="inline-block border-2 border-white text-white px-10 py-4 font-bold uppercase tracking-widest hover:bg-white hover:text-black transition-all duration-300 animate-fade-in-up delay-200">
                                Shop Collection <i class="fas fa-arrow-right ml-2"></i>
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
    <!-- Brand Ticker -->
    <div class="py-10 border-y border-gray-100 overflow-hidden relative backdrop-blur-md active-glass-effect group">
        <!-- Glass Background Layer -->
        <div class="absolute inset-0 bg-white/70 z-0"></div>
        
        <!-- Gradient Fades -->
        <div class="absolute inset-y-0 left-0 w-32 bg-gradient-to-r from-white to-transparent z-10 pointer-events-none"></div>
        <div class="absolute inset-y-0 right-0 w-32 bg-gradient-to-l from-white to-transparent z-10 pointer-events-none"></div>

        <style>
            @keyframes marquee {
                0% { transform: translateX(0); }
                100% { transform: translateX(-50%); }
            }
            .animate-marquee-infinite {
                animation: marquee 40s linear infinite;
                width: max-content;
            }
            .group:hover .animate-marquee-infinite {
                animation-play-state: paused;
            }
        </style>

        <div class="relative z-0 flex items-center animate-marquee-infinite">
            <!-- Logo Set 1 -->
            <div class="flex items-center px-16" style="gap: 8rem;">
                <!-- Logos (Repeated twice to ensure width) -->
                @foreach(range(1, 2) as $i)
                    <img src="{{ asset('frontend/images/logos/nike.svg') }}" alt="Nike" class="h-8 md:h-10 w-auto object-contain opacity-60 grayscale group-hover:grayscale-0 transition-all duration-500">
                    <img src="{{ asset('frontend/images/logos/adidas.svg') }}" alt="Adidas" class="h-10 md:h-12 w-auto object-contain opacity-60 grayscale group-hover:grayscale-0 transition-all duration-500">
                    <img src="{{ asset('frontend/images/logos/puma.svg') }}" alt="Puma" class="h-10 md:h-12 w-auto object-contain opacity-60 grayscale group-hover:grayscale-0 transition-all duration-500">
                    <img src="{{ asset('frontend/images/logos/reebok.svg') }}" alt="Reebok" class="h-10 md:h-12 w-auto object-contain opacity-60 grayscale group-hover:grayscale-0 transition-all duration-500">
                    <img src="{{ asset('frontend/images/logos/newbalance.svg') }}" alt="New Balance" class="h-10 md:h-12 w-auto object-contain opacity-60 grayscale group-hover:grayscale-0 transition-all duration-500">
                    <img src="{{ asset('frontend/images/logos/converse.svg') }}" alt="Converse" class="h-10 md:h-12 w-auto object-contain opacity-60 grayscale group-hover:grayscale-0 transition-all duration-500">
                    <img src="{{ asset('frontend/images/logos/vans.svg') }}" alt="Vans" class="h-8 md:h-10 w-auto object-contain opacity-60 grayscale group-hover:grayscale-0 transition-all duration-500">
                @endforeach
            </div>

            <!-- Logo Set 2 (Identical Duplicate) -->
            <div class="flex items-center px-16" style="gap: 8rem;">
                 @foreach(range(1, 2) as $i)
                    <img src="{{ asset('frontend/images/logos/nike.svg') }}" alt="Nike" class="h-8 md:h-10 w-auto object-contain opacity-60 grayscale group-hover:grayscale-0 transition-all duration-500">
                    <img src="{{ asset('frontend/images/logos/adidas.svg') }}" alt="Adidas" class="h-10 md:h-12 w-auto object-contain opacity-60 grayscale group-hover:grayscale-0 transition-all duration-500">
                    <img src="{{ asset('frontend/images/logos/puma.svg') }}" alt="Puma" class="h-10 md:h-12 w-auto object-contain opacity-60 grayscale group-hover:grayscale-0 transition-all duration-500">
                    <img src="{{ asset('frontend/images/logos/reebok.svg') }}" alt="Reebok" class="h-10 md:h-12 w-auto object-contain opacity-60 grayscale group-hover:grayscale-0 transition-all duration-500">
                    <img src="{{ asset('frontend/images/logos/newbalance.svg') }}" alt="New Balance" class="h-10 md:h-12 w-auto object-contain opacity-60 grayscale group-hover:grayscale-0 transition-all duration-500">
                    <img src="{{ asset('frontend/images/logos/converse.svg') }}" alt="Converse" class="h-10 md:h-12 w-auto object-contain opacity-60 grayscale group-hover:grayscale-0 transition-all duration-500">
                    <img src="{{ asset('frontend/images/logos/vans.svg') }}" alt="Vans" class="h-8 md:h-10 w-auto object-contain opacity-60 grayscale group-hover:grayscale-0 transition-all duration-500">
                @endforeach
            </div>
        </div>
    </div>

    <!-- Shop By Gender -->
    <div class="container mx-auto px-4 py-16">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <!-- Men -->
            <a href="{{ route('products.index', ['gender' => 'Men']) }}" class="group relative h-[500px] overflow-hidden rounded-xl shadow-lg">
                <img src="{{ asset('frontend/images/men-fashion.png') }}" alt="Men's Collection" class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-110">
                <div class="absolute inset-0 bg-gradient-to-t from-black/80 via-transparent to-transparent opacity-90"></div>
                
                <div class="absolute bottom-8 left-8 text-white z-10 transform translate-y-4 group-hover:translate-y-0 transition-transform duration-500">
                    <p class="text-xs font-bold uppercase tracking-[0.2em] mb-2 text-gray-300">Streetwear Essentials</p>
                    <h3 class="text-4xl font-black uppercase tracking-tighter">Men</h3>
                </div>
            </a>
            
            <!-- Women -->
            <a href="{{ route('products.index', ['gender' => 'Women']) }}" class="group relative h-[500px] overflow-hidden rounded-xl shadow-lg">
                 <img src="{{ asset('frontend/images/women-fashion.png') }}" alt="Women's Collection" class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-110">
                 <div class="absolute inset-0 bg-gradient-to-t from-black/80 via-transparent to-transparent opacity-90"></div>
 
                 <div class="absolute bottom-8 left-8 text-white z-10 transform translate-y-4 group-hover:translate-y-0 transition-transform duration-500">
                     <p class="text-xs font-bold uppercase tracking-[0.2em] mb-2 text-gray-300">New Season Fit</p>
                     <h3 class="text-4xl font-black uppercase tracking-tighter">Women</h3>
                 </div>
            </a>
 
            <!-- Kids -->
            <a href="{{ route('products.index', ['gender' => 'Juniors']) }}" class="group relative h-[500px] overflow-hidden rounded-xl shadow-lg">
                 <img src="{{ asset('frontend/images/kids-fashion.png') }}" alt="Kids' Collection" class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-110">
                 <div class="absolute inset-0 bg-gradient-to-t from-black/80 via-transparent to-transparent opacity-90"></div>
 
                 <div class="absolute bottom-8 left-8 text-white z-10 transform translate-y-4 group-hover:translate-y-0 transition-transform duration-500">
                     <p class="text-xs font-bold uppercase tracking-[0.2em] mb-2 text-gray-300">Mini Hype</p>
                     <h3 class="text-4xl font-black uppercase tracking-tighter">Kids</h3>
                 </div>
            </a>
        </div>
    </div>

    <!-- Main Content Area (Sidebar + Shop All) -->
    <div class="container mx-auto px-4 py-8">
        <div class="flex flex-col md:flex-row gap-8">
            <!-- Sidebar Filters (Visible on Desktop) -->
            <div class="hidden md:block w-1/4 space-y-10 sticky top-24 h-fit">
                <div>
                    <h3 class="text-xl font-black uppercase tracking-tighter mb-6 pb-2 border-b border-gray-100">Filters</h3>

                    <!-- Category -->
                    <div class="mb-8">
                        <p class="text-xs font-bold text-gray-400 uppercase tracking-widest mb-4">Category</p>
                        <ul class="space-y-3">
                            @foreach($categories->take(5) as $cat)
                                <li>
                                    <a href="{{ route('products.index', ['category' => $cat->slug]) }}"
                                        class="group flex items-center text-sm font-bold text-gray-600 hover:text-black uppercase transition-colors">
                                        <span class="w-4 h-4 border-2 border-gray-200 mr-3 flex items-center justify-center group-hover:border-black transition-colors">
                                            @if(request('category') == $cat->slug) <div class="w-2 h-2 bg-black"></div> @endif
                                        </span>
                                        {{ $cat->name }}
                                    </a>
                                </li>
                            @endforeach
                        </ul>
                    </div>

                    <!-- Gender -->
                    <div class="mb-8">
                        <p class="text-xs font-bold text-gray-400 uppercase tracking-widest mb-4">Gender</p>
                        <ul class="space-y-3">
                            @foreach(['Men', 'Women', 'Juniors'] as $g)
                                <li>
                                    <a href="{{ route('products.index', ['gender' => $g]) }}"
                                        class="group flex items-center text-sm font-bold text-gray-600 hover:text-black uppercase transition-colors">
                                         <span class="w-4 h-4 border-2 border-gray-200 mr-3 flex items-center justify-center group-hover:border-black transition-colors">
                                             @if(request('gender') == $g) <div class="w-2 h-2 bg-black"></div> @endif
                                         </span>
                                        {{ $g }}
                                    </a>
                                </li>
                            @endforeach
                        </ul>
                    </div>

                    <div class="mt-10">
                        <a href="{{ route('products.index') }}"
                            class="block w-full bg-black text-white text-center py-4 font-black uppercase text-xs tracking-[0.2em] hover:bg-zinc-800 hover:scale-[1.02] transition-all duration-300">
                            Apply Filters
                        </a>
                    </div>
                </div>
            </div>

            <!-- Main Shop Area -->
            <div class="w-full md:w-3/4">
                <!-- Header -->
                <div class="flex flex-col md:flex-row justify-between items-end mb-10 pb-4 border-b border-black">
                    <h2 class="text-5xl font-black uppercase tracking-tighter leading-none mb-4 md:mb-0">Shop All</h2>
                    <div class="flex items-center space-x-4">
                        <a href="{{ route('products.index') }}"
                            class="text-xs font-bold uppercase text-gray-500 hover:text-black tracking-widest transition-colors">
                            Sort By: <span class="text-black border-b border-black pb-0.5">Newest Drops</span>
                        </a>
                    </div>
                </div>

                <!-- Product Grid -->
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-x-6 gap-y-10">
                    @foreach($shopAllProducts as $product)
                        <div class="group relative flex flex-col">
                            <!-- Image Container -->
                            <div class="relative bg-gray-50 aspect-[4/5] overflow-hidden mb-4">
                                @if($product->discount_price && $product->discount_price > 0)
                                    <span class="absolute top-3 left-3 bg-red-600 text-white text-[10px] font-black uppercase px-2 py-1 z-20 tracking-widest">Sale</span>
                                @endif

                                <img src="{{ $product->images->first()->image ?? 'https://via.placeholder.com/300' }}"
                                    alt="{{ $product->title }}"
                                    class="w-full h-full object-contain p-6 transition-transform duration-700 group-hover:scale-105 mix-blend-multiply">
                                
                                <!-- Wishlist -->
                                <button class="absolute top-3 right-3 z-20 w-8 h-8 flex items-center justify-center rounded-full bg-white text-black opacity-0 group-hover:opacity-100 transition-all duration-300 hover:bg-black hover:text-white"
                                    onclick="event.preventDefault(); toggleWishlist(event, {{ $product->id }});">
                                    <i class="far fa-heart text-xs"></i>
                                </button>

                                <!-- Bottom Quick Add (Slide Up) -->
                                <div class="absolute bottom-0 left-0 w-full translate-y-full group-hover:translate-y-0 transition-transform duration-300 z-20">
                                    <div class="flex h-12">
                                        <form action="{{ route('cart.add', $product->id) }}" method="POST" class="w-1/2 h-full">
                                            @csrf
                                            <input type="hidden" name="quantity" value="1">
                                            <button type="submit" class="w-full h-full bg-black text-white font-black uppercase text-[10px] tracking-widest hover:bg-zinc-800 transition-colors">
                                                Add To Cart
                                            </button>
                                        </form>
                                        <a href="{{ route('products.show', $product->slug) }}"
                                            class="w-1/2 h-full bg-white text-black font-black uppercase text-[10px] tracking-widest border-t border-black flex items-center justify-center hover:bg-gray-50 transition-colors">
                                            View
                                        </a>
                                    </div>
                                </div>
                            </div>

                            <!-- Info -->
                            <div>
                                <p class="text-[10px] font-bold text-gray-400 uppercase tracking-widest mb-1">
                                    {{ $product->category->name ?? 'Sneakers' }}
                                </p>
                                <h3 class="text-lg font-black uppercase leading-tight mb-2 group-hover:text-gray-600 transition-colors">
                                    <a href="{{ route('products.show', $product->slug) }}">{{ $product->title }}</a>
                                </h3>
                                <div class="flex items-center space-x-3 font-bold">
                                    @if($product->discount_price && $product->discount_price > 0)
                                        <span class="text-red-600">৳{{ number_format($product->discount_price) }}</span>
                                        <span class="text-gray-300 line-through text-sm">৳{{ number_format($product->price) }}</span>
                                    @else
                                        <span>৳{{ number_format($product->price) }}</span>
                                    @endif
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>

    <!-- Fresh Drops -->
    <div class="container mx-auto px-4 py-16">
        <h2 class="text-2xl font-black uppercase tracking-tight mb-8">Fresh Drops</h2>
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
            @foreach($newArrivals as $product)
                <div
                    class="group relative bg-white border border-transparent hover:border-black transition-colors duration-300">
                    <!-- Image Container -->
                    <div class="relative h-[280px] bg-gray-50 overflow-hidden flex items-center justify-center p-4">
                        <span
                            class="absolute top-2 left-2 bg-black text-white text-[10px] font-bold uppercase px-2 py-1 z-20">New</span>

                        <img src="{{ $product->images->first()->image ?? 'https://via.placeholder.com/300' }}"
                            alt="{{ $product->title }}"
                            class="max-w-[90%] max-h-[90%] object-contain transition-transform duration-500 group-hover:rotate-[-5deg] group-hover:scale-110 mix-blend-multiply">

                        <a href="{{ route('products.show', $product->slug) }}" class="absolute inset-0 z-10"></a>

                        <!-- Quick View Slide Up (Decorative for New Arrivals or functional) -->
                        <div
                            class="absolute bottom-0 left-0 w-full bg-white/90 backdrop-blur-sm text-black text-center py-2 font-bold uppercase text-[10px] tracking-widest transform translate-y-full group-hover:translate-y-0 transition-transform duration-300 z-20">
                            View
                        </div>
                    </div>

                    <div class="p-4">
                        <h3 class="text-sm font-bold uppercase truncate mb-1 group-hover:text-accent transition-colors">
                            {{ $product->title }}
                        </h3>
                        <p class="text-sm text-gray-500">৳{{ number_format($product->price) }}</p>
                    </div>
                </div>
            @endforeach
        </div>
    </div>

    <!-- Newsletter / Footer Promo -->
    <div class="bg-orange-500 text-white py-16 mt-8">
        <div class="container mx-auto px-4 text-center">
            <h2 class="text-4xl font-black uppercase mb-2">Never Miss A Drop</h2>
            <p class="text-sm mb-8 opacity-90">Sign up for updates on new releases, styling tips, and exclusive access.</p>
            <div class="flex justify-center max-w-md mx-auto">
                <input type="email" placeholder="ENTER EMAIL ADDRESS"
                    class="flex-grow px-4 py-3 bg-white text-black text-xs font-bold uppercase focus:outline-none">
                <button
                    class="bg-black text-white px-8 py-3 text-xs font-bold uppercase tracking-widest hover:bg-gray-900 transition">Join</button>
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
            if (slides.length === 0) return;
            slides[currentSlide].classList.remove('opacity-100', 'z-10');
            slides[currentSlide].classList.add('opacity-0', 'z-0');
            if (indicators.length > currentSlide) indicators[currentSlide].classList.add('opacity-50');

            currentSlide = index;

            slides[currentSlide].classList.remove('opacity-0', 'z-0');
            slides[currentSlide].classList.add('opacity-100', 'z-10');
            if (indicators.length > currentSlide) indicators[currentSlide].classList.remove('opacity-50');
        }

        if (totalSlides > 1) {
            setInterval(() => {
                let next = (currentSlide + 1) % totalSlides;
                goToSlide(next);
            }, 5000);
        }
    </script>
@endsection