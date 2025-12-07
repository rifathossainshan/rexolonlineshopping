@extends('layouts.frontend')

@section('content')
    <div class="container">
        <div class="row">
            <!-- Sidebar Filters -->
            <div class="col-md-3 mb-4">
                <div class="card border-0 shadow-sm">
                    <div class="card-header bg-white fw-bold text-uppercase py-3">Filter Products</div>
                    <div class="card-body">
                        <form action="{{ route('products.index') }}" method="GET">
                            <div class="mb-4">
                                <label class="form-label text-muted small fw-bold text-uppercase">Category</label>
                                <select name="category" class="form-select border-0 bg-light" onchange="this.form.submit()">
                                    <option value="">All Categories</option>
                                    @foreach($categories as $cat)
                                        <option value="{{ $cat->slug }}" {{ request('category') == $cat->slug ? 'selected' : '' }}>
                                            {{ $cat->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            
                            <div class="mb-4">
                                <label class="form-label text-muted small fw-bold text-uppercase">Gender</label>
                                <select name="gender" class="form-select border-0 bg-light" onchange="this.form.submit()">
                                    <option value="">All Genders</option>
                                    @foreach(['Men', 'Women', 'Boys', 'Girls', 'Kids', 'Unisex'] as $g)
                                        <option value="{{ $g }}" {{ request('gender') == $g ? 'selected' : '' }}>
                                            {{ $g }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="mb-4">
                                <label class="form-label text-muted small fw-bold text-uppercase">Price Range</label>
                                <div class="d-flex gap-2">
                                    <input type="number" name="min_price" class="form-control border-0 bg-light" placeholder="Min"
                                        value="{{ request('min_price') }}">
                                    <input type="number" name="max_price" class="form-control border-0 bg-light" placeholder="Max"
                                        value="{{ request('max_price') }}">
                                </div>
                            </div>

                            <button type="submit" class="btn btn-dark w-100 mb-2">Apply Filters</button>
                            <a href="{{ route('products.index') }}" class="btn btn-outline-secondary w-100">Clear</a>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Product Grid -->
            <div class="col-md-9">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h2>Products</h2>
                    <form action="{{ route('products.index') }}" method="GET" class="d-flex align-items-center">
                        @if(request('category')) <input type="hidden" name="category" value="{{ request('category') }}"> @endif
                        @if(request('gender')) <input type="hidden" name="gender" value="{{ request('gender') }}"> @endif
                        @if(request('min_price')) <input type="hidden" name="min_price" value="{{ request('min_price') }}"> @endif
                        @if(request('max_price')) <input type="hidden" name="max_price" value="{{ request('max_price') }}"> @endif
                        
                        <label class="me-2">Sort By:</label>
                        <select name="sort" class="form-select w-auto" onchange="this.form.submit()">
                            <option value="newest" {{ request('sort') == 'newest' ? 'selected' : '' }}>Newest</option>
                            <option value="price_asc" {{ request('sort') == 'price_asc' ? 'selected' : '' }}>Price: Low to High</option>
                            <option value="price_desc" {{ request('sort') == 'price_desc' ? 'selected' : '' }}>Price: High to Low</option>
                        </select>
                    </form>
                </div>

                <div class="row">
                    @forelse($products as $product)
                        <div class="col-md-4 mb-4">
                            <div class="card h-100 product-card border-0 shadow-sm">
                                <div class="position-relative overflow-hidden">
                                    <img src="{{ $product->images->first()->image ?? 'https://via.placeholder.com/300' }}"
                                        class="card-img-top" alt="{{ $product->title }}"
                                        style="height: 250px; object-fit: cover; transition: transform 0.5s ease;">
                                     <a href="{{ session('wishlist') && isset(session('wishlist')[$product->id]) ? route('wishlist.remove', $product->id) : route('wishlist.add', $product->id) }}"
                                        class="btn btn-sm btn-white position-absolute top-0 end-0 m-3 shadow-sm rounded-circle"
                                        title="{{ session('wishlist') && isset(session('wishlist')[$product->id]) ? 'Remove from Wishlist' : 'Add to Wishlist' }}"
                                        onclick="toggleWishlist(event, {{ $product->id }})">
                                        @if(session('wishlist') && isset(session('wishlist')[$product->id]))
                                            <i class="fas fa-heart text-danger"></i>
                                        @else
                                            <i class="far fa-heart"></i>
                                        @endif
                                     </a>
                                </div>
                                <div class="card-body text-center">
                                    <h5 class="card-title fw-bold mb-1">{{ $product->title }}</h5>
                                    @if($product->discount_price && $product->discount_price > 0)
                                        <p class="card-text text-danger fw-bold mb-3">
                                            ৳{{ number_format($product->discount_price) }}
                                            <small class="text-muted text-decoration-line-through fw-normal ms-1">৳{{ number_format($product->price) }}</small>
                                        </p>
                                    @else
                                        <p class="card-text text-danger fw-bold mb-3">৳{{ number_format($product->price) }}</p>
                                    @endif
                                    <a href="{{ route('products.show', $product->slug) }}" class="btn btn-outline-dark w-100">View Details</a>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="col-12">
                            <div class="alert alert-info rounded-0 border-0 bg-light p-4 text-center">
                                <h5>No products found.</h5>
                                <p class="text-muted">Try adjusting your filters.</p>
                            </div>
                        </div>
                    @endforelse
                </div>
                
                <style>
                    .product-card:hover img {
                        transform: scale(1.05);
                    }
                    .product-card {
                        transition: box-shadow 0.3s ease;
                    }
                    .product-card:hover {
                        box-shadow: 0 10px 20px rgba(0,0,0,0.1) !important;
                    }
                </style>

                <!-- Pagination -->
                <div class="d-flex justify-content-center">
                    {{ $products->withQueryString()->links() }}
                </div>
            </div>
        </div>
    </div>
@endsection