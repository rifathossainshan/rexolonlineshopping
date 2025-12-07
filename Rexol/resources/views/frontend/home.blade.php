@extends('layouts.frontend')

@section('content')
<div class="container">
    <!-- Slider -->
    <div id="mainCarousel" class="carousel slide mb-5" data-bs-ride="carousel">
        <div class="carousel-inner">
            <div class="carousel-item active">
                <img src="https://images.unsplash.com/photo-1556906781-9a412961d28c?q=80&w=1200&auto=format&fit=crop" class="d-block w-100" style="height: 400px; object-fit: cover;" alt="Sneaker Banner 1">
                <div class="carousel-caption d-none d-md-block">
                    <h3 class="bg-dark d-inline-block px-3 py-1 rounded">New Season Arrivals</h3>
                    <p class="bg-dark d-inline-block px-2 rounded">Check out the latest drops from Nike & Jordan.</p>
                </div>
            </div>
            <div class="carousel-item">
                <img src="https://images.unsplash.com/photo-1514989940723-e8e51635b782?q=80&w=1200&auto=format&fit=crop" class="d-block w-100" style="height: 400px; object-fit: cover;" alt="Sneaker Banner 2">
                <div class="carousel-caption d-none d-md-block">
                    <h3 class="bg-dark d-inline-block px-3 py-1 rounded">Exclusive Collection</h3>
                    <p class="bg-dark d-inline-block px-2 rounded">Limited edition sneakers available now.</p>
                </div>
            </div>
        </div>
        <button class="carousel-control-prev" type="button" data-bs-target="#mainCarousel" data-bs-slide="prev">
            <span class="carousel-control-prev-icon"></span>
        </button>
        <button class="carousel-control-next" type="button" data-bs-target="#mainCarousel" data-bs-slide="next">
            <span class="carousel-control-next-icon"></span>
        </button>
    </div>

    <!-- Categories -->
    <h2 class="mb-4">Shop by Brand</h2>
    <div class="row mb-5">
        @foreach($categories as $category)
        <div class="col-md-3 col-6 mb-3">
            <div class="card text-center">
                <div class="card-body">
                    <h5 class="card-title">{{ $category->name }}</h5>
                    <a href="{{ route('products.index', ['category' => $category->slug]) }}" class="btn btn-sm btn-outline-primary">View Collection</a>
                </div>
            </div>
        </div>
        @endforeach
    </div>

    <!-- New Arrivals -->
    <h2 class="mb-4">Fresh Drops</h2>
    <div class="row">
        @foreach($newArrivals as $product)
        <div class="col-md-3 mb-4">
            <div class="card h-100">
                <img src="{{ $product->images->first()->image ?? 'https://via.placeholder.com/300' }}" class="card-img-top" alt="{{ $product->title }}">
                <div class="card-body">
                    <h5 class="card-title">{{ $product->title }}</h5>
                    <p class="card-text text-danger fw-bold">৳{{ $product->price }}</p>
                    <a href="{{ route('products.show', $product->slug) }}" class="btn btn-primary w-100">View Details</a>
                </div>
            </div>
        </div>
        @endforeach
    </div>
</div>
@endsection