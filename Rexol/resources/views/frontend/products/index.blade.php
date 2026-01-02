@extends('layouts.frontend')

@section('content')
    <div class="container mx-auto px-4 py-8">
        <div class="flex flex-col md:flex-row gap-8">
            <!-- Mobile Filter Toggle -->
            <button class="md:hidden w-full bg-black text-white py-3 font-bold uppercase mb-4 sticky top-20 z-30 shadow-md"
                onclick="toggleFilters()">
                Show Filters <i class="fas fa-filter ml-2"></i>
            </button>

            <!-- Mobile Filter Overlay -->
            <div id="filter-overlay"
                class="fixed inset-0 bg-black bg-opacity-50 z-40 hidden transition-opacity duration-300 md:hidden"
                onclick="toggleFilters()"></div>

            <!-- Sidebar Filters -->
            <div id="filter-sidebar"
                class="fixed inset-y-0 left-0 w-[85%] max-w-sm bg-white z-50 transform -translate-x-full transition-transform duration-300 md:relative md:inset-auto md:w-1/4 md:translate-x-0 md:block md:bg-transparent md:z-auto shadow-2xl md:shadow-none overflow-y-auto md:overflow-visible">
                <div class="p-6 md:p-0 md:sticky md:top-24 max-h-[calc(100vh-6rem)] overflow-y-auto pl-4">
                    <!-- Mobile Header -->
                    <div class="flex justify-between items-center mb-6 md:hidden">
                        <h3 class="text-xl font-black uppercase tracking-tight">Filters</h3>
                        <button onclick="toggleFilters()"
                            class="w-8 h-8 flex items-center justify-center bg-gray-100 rounded-full text-gray-500 hover:text-black hover:bg-gray-200 transition">
                            <i class="fas fa-times"></i>
                        </button>
                    </div>

                    <h3 class="text-xl font-black uppercase tracking-tighter mb-6 pb-2 border-b border-gray-100">Filter
                        Products</h3>

                    <form action="{{ route('products.index') }}" method="GET">
                        <!-- Category -->
                        <div class="mb-8">
                            <label class="block text-xs font-bold uppercase text-gray-400 mb-4 tracking-widest">Category</label>
                            <div class="space-y-3">
                                <label class="flex items-center space-x-3 cursor-pointer group">
                                    <input type="radio" name="category" value="" class="hidden"
                                        onchange="this.form.submit()" {{ request('category') == '' ? 'checked' : '' }}>
                                    <span
                                        class="w-4 h-4 border-2 border-gray-200 flex items-center justify-center group-hover:border-black transition-colors">
                                        @if(request('category') == '')
                                            <div class="w-2 h-2 bg-black"></div>
                                        @endif
                                    </span>
                                    <span
                                        class="text-sm font-bold uppercase text-gray-600 group-hover:text-black transition-colors">All
                                        Categories</span>
                                </label>
                                @foreach($categories as $cat)
                                    <label class="flex items-center space-x-3 cursor-pointer group">
                                        <input type="radio" name="category" value="{{ $cat->slug }}" class="hidden"
                                            onchange="this.form.submit()"
                                            {{ request('category') == $cat->slug ? 'checked' : '' }}>
                                        <span
                                            class="w-4 h-4 border-2 border-gray-200 flex items-center justify-center group-hover:border-black transition-colors">
                                            @if(request('category') == $cat->slug)
                                                <div class="w-2 h-2 bg-black"></div>
                                            @endif
                                        </span>
                                        <span
                                            class="text-sm font-bold uppercase text-gray-600 group-hover:text-black transition-colors">{{ $cat->name }}</span>
                                    </label>
                                @endforeach
                            </div>
                        </div>

                        <!-- Gender -->
                        <div class="mb-8">
                            <label class="block text-xs font-bold uppercase text-gray-400 mb-4 tracking-widest">Gender</label>
                            <div class="flex flex-wrap gap-2">
                                <button type="button" onclick="setGender('')"
                                    class="px-4 py-2 text-xs font-bold uppercase border-2 {{ request('gender') == '' ? 'bg-black text-white border-black' : 'bg-transparent text-gray-600 border-gray-200 hover:border-black hover:text-black' }} transition-all">All</button>
                                @foreach($genders as $g)
                                    <button type="button" onclick="setGender('{{ $g->name }}')"
                                        class="px-4 py-2 text-xs font-bold uppercase border-2 {{ request('gender') == $g->name ? 'bg-black text-white border-black' : 'bg-transparent text-gray-600 border-gray-200 hover:border-black hover:text-black' }} transition-all">{{ $g->name }}</button>
                                @endforeach
                                <input type="hidden" name="gender" id="genderInput" value="{{ request('gender') }}">
                            </div>
                        </div>

                        <!-- Price Range -->
                        <div class="mb-8">
                            <label class="block text-xs font-bold uppercase text-gray-400 mb-4 tracking-widest">Price
                                Range</label>
                            <div class="flex items-center gap-3">
                                <input type="number" name="min_price" placeholder="Min"
                                    value="{{ request('min_price') }}"
                                    class="w-1/2 px-3 py-2 bg-gray-50 border border-gray-200 text-sm font-bold focus:outline-none focus:border-black focus:ring-0 transition-colors placeholder-gray-400">
                                <span class="text-gray-400 font-bold">-</span>
                                <input type="number" name="max_price" placeholder="Max"
                                    value="{{ request('max_price') }}"
                                    class="w-1/2 px-3 py-2 bg-gray-50 border border-gray-200 text-sm font-bold focus:outline-none focus:border-black focus:ring-0 transition-colors placeholder-gray-400">
                            </div>
                        </div>

                        <button type="submit"
                            class="w-full bg-black text-white font-black uppercase text-xs tracking-[0.2em] py-4 hover:bg-zinc-800 hover:scale-[1.02] transition-all duration-300 shadow-lg">Apply Filters</button>
                        
                        @if(request()->hasAny(['category', 'gender', 'min_price', 'max_price', 'sort']))
                            <a href="{{ route('products.index') }}"
                                class="block w-full text-center text-xs font-bold uppercase text-gray-500 mt-4 hover:text-black hover:underline tracking-wide">Clear All Filters</a>
                        @endif
                    </form>
                </div>
            </div>

            <!-- Main Shop Area -->
            <div class="w-full md:w-3/4">
                <!-- Header -->
                <div class="flex flex-col md:flex-row justify-between items-end mb-10 pb-4 border-b border-black">
                    <h2 class="text-5xl font-black uppercase tracking-tighter leading-none mb-4 md:mb-0">Shop All</h2>
                    
                    <form action="{{ route('products.index') }}" method="GET" class="flex items-center">
                         @if(request('category')) <input type="hidden" name="category" value="{{ request('category') }}"> @endif
                        @if(request('gender')) <input type="hidden" name="gender" value="{{ request('gender') }}"> @endif
                        @if(request('min_price')) <input type="hidden" name="min_price" value="{{ request('min_price') }}"> @endif
                        @if(request('max_price')) <input type="hidden" name="max_price" value="{{ request('max_price') }}"> @endif

                        <label class="text-xs font-bold uppercase text-gray-500 mr-3 tracking-widest">Sort By:</label>
                        <select name="sort" class="border-none bg-transparent text-sm font-bold uppercase cursor-pointer focus:ring-0 pl-0 py-0" onchange="this.form.submit()">
                            <option value="newest" {{ request('sort') == 'newest' ? 'selected' : '' }}>Newest Drops</option>
                            <option value="price_asc" {{ request('sort') == 'price_asc' ? 'selected' : '' }}>Price: Low to High</option>
                            <option value="price_desc" {{ request('sort') == 'price_desc' ? 'selected' : '' }}>Price: High to Low</option>
                        </select>
                    </form>
                </div>

                <!-- Product Grid -->
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-x-6 gap-y-10">
                    @forelse($products as $product)
                        <div class="group relative flex flex-col">
                            <!-- Image Container -->
                            <div class="relative bg-gray-50 aspect-[4/5] overflow-hidden mb-4 border border-transparent group-hover:border-black/5 transition-colors">
                                @if($product->discount_price && $product->discount_price > 0)
                                    <span class="absolute top-3 left-3 bg-red-600 text-white text-[10px] font-black uppercase px-2 py-1 z-20 tracking-widest">Sale</span>
                                @endif

                                <img src="{{ $product->images->first()->image ?? 'https://via.placeholder.com/300' }}"
                                     alt="{{ $product->title }}"
                                     class="w-full h-full object-contain p-6 transition-transform duration-700 group-hover:scale-105 mix-blend-multiply">

                                <!-- Wishlist Button -->
                                <button
                                    class="absolute top-3 right-3 z-20 w-8 h-8 flex items-center justify-center rounded-full bg-white text-black opacity-0 group-hover:opacity-100 transition-all duration-300 hover:bg-black hover:text-white shadow-sm"
                                    onclick="event.preventDefault(); toggleWishlist(event, {{ $product->id }});">
                                    <i class="{{ session('wishlist') && isset(session('wishlist')[$product->id]) ? 'fas fa-heart text-red-600' : 'far fa-heart' }} text-xs"></i>
                                </button>

                                <!-- Bottom Quick Add (Slide Up) -->
                                <div class="absolute bottom-0 left-0 w-full translate-y-full group-hover:translate-y-0 transition-transform duration-300 z-20">
                                    <div class="flex h-12">
                                        <form action="{{ route('cart.add', $product->id) }}" method="POST" class="w-1/2 h-full">
                                            @csrf
                                            <input type="hidden" name="quantity" value="1">
                                            <button type="submit" class="w-full h-full bg-black text-white font-black uppercase text-[10px] tracking-widest hover:bg-zinc-800 transition-colors border border-black">
                                                Add Cart
                                            </button>
                                        </form>
                                        <a href="{{ route('products.show', $product->slug) }}"
                                            class="w-1/2 h-full bg-white text-black font-black uppercase text-[10px] tracking-widest border border-black flex items-center justify-center hover:bg-black hover:text-white transition-colors">
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
                                <div class="flex items-center space-x-2">
                                    @if($product->discount_price && $product->discount_price > 0)
                                        <span class="text-lg font-black text-red-600">Tk. {{ number_format($product->discount_price) }}</span>
                                        <span class="text-sm font-bold text-gray-300 line-through">Tk. {{ number_format($product->price) }}</span>
                                    @else
                                        <span class="text-lg font-black text-black">Tk. {{ number_format($product->price) }}</span>
                                    @endif
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="col-span-full py-20 text-center">
                            <div class="mb-4">
                                <i class="fas fa-search text-gray-300 text-6xl"></i>
                            </div>
                            <h3 class="text-xl font-black uppercase text-gray-400 mb-2 tracking-wide">No Drops Found</h3>
                            <p class="text-gray-500 font-medium">Try adjusting your filters or check back later.</p>
                            <a href="{{ route('products.index') }}" class="inline-block mt-6 px-8 py-3 bg-black text-white font-bold uppercase tracking-widest text-xs hover:bg-gray-800 transition-colors">Clear Filters</a>
                        </div>
                    @endforelse
                </div>

                <!-- Pagination -->
                <div class="mt-16">
                    {{ $products->withQueryString()->links() }}
                </div>
            </div>
        </div>
    </div>

    <script>
        function setGender(gender) {
            document.getElementById('genderInput').value = gender;
            document.getElementById('genderInput').form.submit();
        }

        function toggleFilters() {
            const sidebar = document.getElementById('filter-sidebar');
            const overlay = document.getElementById('filter-overlay');
            const body = document.body;
            
            if (sidebar.classList.contains('-translate-x-full')) {
                sidebar.classList.remove('-translate-x-full');
                overlay.classList.remove('hidden');
                body.style.overflow = 'hidden';
            } else {
                sidebar.classList.add('-translate-x-full');
                overlay.classList.add('hidden');
                body.style.overflow = '';
            }
        }
    </script>
@endsection
