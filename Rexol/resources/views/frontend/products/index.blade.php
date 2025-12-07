@extends('layouts.frontend')

@section('content')
    <div class="container">
        <div class="row">
            <!-- Sidebar Filters -->
            <div class="col-md-3 mb-4">
                <div class="card">
                    <div class="card-header">Filters</div>
                    <div class="card-body">
                        <form action="{{ route('products.index') }}" method="GET">
                            <div class="mb-3">
                                <label class="form-label">Category</label>
                                <select name="category" class="form-select" onchange="this.form.submit()">
                                    <option value="">All Categories</option>
                                    @foreach($categories as $cat)
                                        <option value="{{ $cat->slug }}" {{ request('category') == $cat->slug ? 'selected' : '' }}>
                                            {{ $cat->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            
                            <div class="mb-3">
                                <label class="form-label">Gender</label>
                                <select name="gender" class="form-select" onchange="this.form.submit()">
                                    <option value="">All Genders</option>
                                    @foreach(['Men', 'Women', 'Boys', 'Girls', 'Kids', 'Unisex'] as $g)
                                        <option value="{{ $g }}" {{ request('gender') == $g ? 'selected' : '' }}>
                                            {{ $g }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Price Range</label>
                                <div class="d-flex gap-2">
                                    <input type="number" name="min_price" class="form-control" placeholder="Min"
                                        value="{{ request('min_price') }}">
                                    <input type="number" name="max_price" class="form-control" placeholder="Max"
                                        value="{{ request('max_price') }}">
                                </div>
                            </div>

                            <button type="submit" class="btn btn-primary w-100">Apply Filters</button>
                            <a href="{{ route('products.index') }}" class="btn btn-outline-secondary w-100 mt-2">Clear</a>
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
                            <div class="card h-100">
                                <img src="{{ $product->images->first()->image ?? 'https://via.placeholder.com/300' }}"
                                    class="card-img-top" alt="{{ $product->title }}">
                                <div class="card-body">
                                    <h5 class="card-title">{{ $product->title }}</h5>
                                    <p class="card-text text-danger fw-bold">৳{{ $product->price }}</p>
                                    <a href="{{ route('products.show', $product->slug) }}" class="btn btn-primary w-100">View
                                        Details</a>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="col-12">
                            <div class="alert alert-info">No products found.</div>
                        </div>
                    @endforelse
                </div>

                <!-- Pagination -->
                <div class="d-flex justify-content-center">
                    {{ $products->withQueryString()->links() }}
                </div>
            </div>
        </div>
    </div>
@endsection