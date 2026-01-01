@extends('layouts.frontend')

@section('content')
    <div class="container mx-auto px-4 py-8">
        <div class="flex flex-col md:flex-row gap-8">
            <!-- Mobile Filter Toggle -->
            <!-- Mobile Filter Toggle -->
            <button class="md:hidden w-full bg-black text-white py-3 font-bold uppercase mb-4 sticky top-20 z-30 shadow-md" onclick="toggleFilters()">
                Show Filters <i class="fas fa-filter ml-2"></i>
            </button>

            <!-- Mobile Filter Overlay -->
            <div id="filter-overlay" class="fixed inset-0 bg-black bg-opacity-50 z-40 hidden transition-opacity duration-300 md:hidden" onclick="toggleFilters()"></div>

            <!-- Sidebar Filters (Drawer on Mobile) -->
            <div id="filter-sidebar" class="fixed inset-y-0 left-0 w-[85%] max-w-sm bg-white z-50 transform -translate-x-full transition-transform duration-300 md:relative md:inset-auto md:w-1/4 md:translate-x-0 md:block md:bg-transparent md:z-auto shadow-2xl md:shadow-none overflow-y-auto md:overflow-visible">
                <div class="p-6 md:p-0">
                    <!-- Mobile Header -->
                    <div class="flex justify-between items-center mb-6 md:hidden">
                        <h3 class="text-xl font-black uppercase tracking-tight">Filters</h3>
                        <button onclick="toggleFilters()" class="w-8 h-8 flex items-center justify-center bg-gray-100 rounded-full text-gray-500 hover:text-black hover:bg-gray-200 transition">
                            <i class="fas fa-times"></i>
                        </button>
                    </div>

                    <div class="sticky top-24 bg-white md:p-6 md:border md:border-gray-100 md:shadow-sm">
                    <h3 class="text-xl font-black uppercase mb-6 tracking-tight">Filter Products</h3>
                    
                    <form action="{{ route('products.index') }}" method="GET">
                        <!-- Category -->
                        <div class="mb-8">
                            <label class="block text-xs font-bold uppercase text-gray-400 mb-3">Category</label>
                            <div class="space-y-2">
                                <label class="flex items-center space-x-2 cursor-pointer group">
                                    <input type="radio" name="category" value="" class="hidden" onchange="this.form.submit()" {{ request('category') == '' ? 'checked' : '' }}>
                                    <span class="w-4 h-4 border border-gray-300 flex items-center justify-center group-hover:border-black transition-colors">
                                        @if(request('category') == '') <div class="w-2 h-2 bg-black"></div> @endif
                                    </span>
                                    <span class="text-sm font-medium {{ request('category') == '' ? 'text-black' : 'text-gray-600' }} group-hover:text-black">All Categories</span>
                                </label>
                                @foreach($categories as $cat)
                                    <label class="flex items-center space-x-2 cursor-pointer group">
                                        <input type="radio" name="category" value="{{ $cat->slug }}" class="hidden" onchange="this.form.submit()" {{ request('category') == $cat->slug ? 'checked' : '' }}>
                                        <span class="w-4 h-4 border border-gray-300 flex items-center justify-center group-hover:border-black transition-colors">
                                            @if(request('category') == $cat->slug) <div class="w-2 h-2 bg-black"></div> @endif
                                        </span>
                                        <span class="text-sm font-medium {{ request('category') == $cat->slug ? 'text-black' : 'text-gray-600' }} group-hover:text-black">{{ $cat->name }}</span>
                                    </label>
                                @endforeach
                            </div>
                        </div>

                        <!-- Gender -->
                        <div class="mb-8">
                            <label class="block text-xs font-bold uppercase text-gray-400 mb-3">Gender</label>
                            <div class="flex flex-wrap gap-2">
                                <button type="button" onclick="setGender('')" class="px-3 py-1 text-xs font-bold uppercase border {{ request('gender') == '' ? 'bg-black text-white border-black' : 'bg-white text-gray-600 border-gray-200 hover:border-black' }} transition-colors">All</button>
                                @foreach(['Men', 'Women', 'Boys', 'Girls', 'Kids', 'Unisex'] as $g)
                                    <button type="button" onclick="setGender('{{ $g }}')" class="px-3 py-1 text-xs font-bold uppercase border {{ request('gender') == $g ? 'bg-black text-white border-black' : 'bg-white text-gray-600 border-gray-200 hover:border-black' }} transition-colors">{{ $g }}</button>
                                @endforeach
                                <input type="hidden" name="gender" id="genderInput" value="{{ request('gender') }}">
                            </div>
                        </div>

                        <!-- Price Range -->
                         <div class="mb-8">
                            <label class="block text-xs font-bold uppercase text-gray-400 mb-3">Price Range</label>
                            <div class="flex items-center gap-2">
                                <input type="number" name="min_price" placeholder="Min" value="{{ request('min_price') }}" class="w-1/2 px-3 py-2 bg-gray-50 border border-gray-200 text-sm font-bold focus:outline-none focus:border-black transition-colors">
                                <span class="text-gray-400">-</span>
                                <input type="number" name="max_price" placeholder="Max" value="{{ request('max_price') }}" class="w-1/2 px-3 py-2 bg-gray-50 border border-gray-200 text-sm font-bold focus:outline-none focus:border-black transition-colors">
                            </div>
                        </div>

                        <button type="submit" class="w-full bg-black text-white font-bold uppercase py-3 hover:bg-gray-800 transition-colors">Apply Filters</button>
                        @if(request()->hasAny(['category', 'gender', 'min_price', 'max_price', 'sort']))
                            <a href="{{ route('products.index') }}" class="block w-full text-center text-xs font-bold uppercase text-gray-500 mt-4 hover:text-black underline">Clear All</a>
                        @endif
                    </form>
                </div>
                    </div> <!-- End Sticky wrapper -->
                </div> <!-- End Padding wrapper -->
            </div>

            <!-- Product Grid -->
            <div class="w-full md:w-3/4">
                <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-8 pb-4 border-b border-gray-100">
                    <h2 class="text-3xl font-black uppercase tracking-tight mb-4 md:mb-0">Shop All</h2>
                    
                    <form action="{{ route('products.index') }}" method="GET" class="flex items-center">
                         @if(request('category')) <input type="hidden" name="category" value="{{ request('category') }}"> @endif
                        @if(request('gender')) <input type="hidden" name="gender" value="{{ request('gender') }}"> @endif
                        @if(request('min_price')) <input type="hidden" name="min_price" value="{{ request('min_price') }}"> @endif
                        @if(request('max_price')) <input type="hidden" name="max_price" value="{{ request('max_price') }}"> @endif

                        <label class="text-sm font-bold uppercase text-gray-500 mr-3">Sort By:</label>
                        <select name="sort" class="border-none bg-transparent text-sm font-bold uppercase cursor-pointer focus:ring-0" onchange="this.form.submit()">
                            <option value="newest" {{ request('sort') == 'newest' ? 'selected' : '' }}>Newest Drops</option>
                            <option value="price_asc" {{ request('sort') == 'price_asc' ? 'selected' : '' }}>Price: Low to High</option>
                            <option value="price_desc" {{ request('sort') == 'price_desc' ? 'selected' : '' }}>Price: High to Low</option>
                        </select>
                    </form>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8">
                    @forelse($products as $product)
                        <div class="group relative bg-white border border-transparent hover:border-black transition-colors duration-300">
                            <!-- Image Container -->
                            <div class="relative h-[350px] bg-gray-50 overflow-hidden flex items-center justify-center p-4">
                                @if($product->discount_price && $product->discount_price > 0)
                                    <span class="absolute top-0 left-0 bg-red-600 text-white text-xs font-bold uppercase px-3 py-1.5 z-20">Sale</span>
                                @endif

                                <img src="{{ $product->images->first()->image ?? 'https://via.placeholder.com/300' }}" 
                                     alt="{{ $product->title }}" 
                                     class="max-w-[90%] max-h-[90%] object-contain transition-transform duration-500 group-hover:rotate-[-5deg] group-hover:scale-110 mix-blend-multiply">

                                <!-- Wishlist Button -->
                                <a href="{{ session('wishlist') && isset(session('wishlist')[$product->id]) ? route('wishlist.remove', $product->id) : route('wishlist.add', $product->id) }}"
                                   class="absolute top-4 right-4 w-10 h-10 bg-white rounded-full flex items-center justify-center shadow-md z-20 hover:bg-gray-100 transition"
                                   onclick="toggleWishlist(event, {{ $product->id }})">
                                    <i class="{{ session('wishlist') && isset(session('wishlist')[$product->id]) ? 'fas fa-heart text-red-600' : 'far fa-heart text-black' }}"></i>
                                </a>

                                <!-- Quick View / Add -->
                                <a href="{{ route('products.show', $product->slug) }}" class="absolute bottom-0 left-0 w-full bg-black text-white text-center py-3 font-bold uppercase text-sm transform translate-y-full group-hover:translate-y-0 transition-transform duration-300 z-20 hover:bg-accent">
                                    View Details
                                </a>
                            </div>

                            <!-- Info -->
                            <div class="p-6">
                                <p class="text-xs font-bold text-gray-400 uppercase mb-1">{{ $product->category->name ?? 'Sneakers' }}</p>
                                <h3 class="text-lg font-bold text-black uppercase leading-tight mb-2 truncate group-hover:text-accent transition-colors">
                                    <a href="{{ route('products.show', $product->slug) }}">{{ $product->title }}</a>
                                </h3>
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
                    @empty
                        <div class="col-span-full py-20 text-center">
                            <h3 class="text-xl font-bold uppercase text-gray-400 mb-2">No Products Found</h3>
                            <p class="text-gray-500">Try adjusting your filters or check back later.</p>
                        </div>
                    @endforelse
                </div>

                <!-- Pagination -->
                <div class="mt-12">
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
                // Open
                sidebar.classList.remove('-translate-x-full');
                overlay.classList.remove('hidden');
                body.style.overflow = 'hidden'; // Prevent background scrolling
            } else {
                // Close
                sidebar.classList.add('-translate-x-full');
                overlay.classList.add('hidden');
                body.style.overflow = '';
            }
        }
    </script>
@endsection