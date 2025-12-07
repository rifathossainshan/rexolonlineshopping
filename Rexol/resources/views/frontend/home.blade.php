@extends('layouts.frontend')

@section('content')
    <style>
        /* Hypebeast / Sneaker Shop Specific Styles */

        /* Hero Section */
        .hero-section {
            position: relative;
            overflow: hidden;
            margin-top: -1.5rem;
        }

        .carousel-item img {
            height: 70vh;
            min-height: 500px;
            object-fit: cover;
            filter: brightness(0.7);
        }

        .carousel-caption {
            bottom: 35%;
            text-align: left;
        }

        .carousel-caption h2 {
            font-size: 4rem;
            line-height: 1;
            margin-bottom: 1rem;
            text-shadow: 2px 2px 0 rgba(0, 0, 0, 0.5);
        }

        .btn-hero {
            padding: 15px 40px;
            border-radius: 0;
            font-weight: 700;
            background: var(--accent-color);
            border: none;
            color: white;
            transition: transform 0.2s;
        }

        .btn-hero:hover {
            background: black;
            color: white;
            transform: scale(1.05);
        }

        /* Gender Section */
        .gender-card {
            position: relative;
            height: 600px;
            overflow: hidden;
            margin-bottom: 2rem;
            cursor: pointer;
        }

        .gender-bg {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform 0.5s ease;
        }

        .gender-card:hover .gender-bg {
            transform: scale(1.1);
        }

        .gender-overlay {
            position: absolute;
            bottom: 0;
            left: 0;
            width: 100%;
            padding: 3rem;
            background: linear-gradient(to top, rgba(0, 0, 0, 0.8), transparent);
            color: white;
        }

        .gender-overlay h3 {
            font-size: 2.5rem;
            margin-bottom: 0;
        }

        /* Product Cards */
        .product-card {
            border: 1px solid #eee;
            border-radius: 0;
            transition: all 0.3s ease;
            background: white;
        }

        .product-card:hover {
            border-color: black;
            transform: translateY(-5px);
        }

        .product-img-wrapper {
            position: relative;
            height: 300px;
            background: #f8f9fa;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .product-img-wrapper img {
            max-width: 90%;
            max-height: 90%;
            transition: transform 0.3s ease;
        }

        .product-card:hover .product-img-wrapper img {
            transform: rotate(-5deg) scale(1.1);
        }

        /* Brand Ticker */
        .brand-section {
            background: black;
            padding: 3rem 0;
            color: white;
        }

        .brand-link {
            color: rgba(255, 255, 255, 0.5);
            text-decoration: none;
            font-size: 1.5rem;
            font-weight: 700;
            margin: 0 2rem;
            transition: color 0.3s;
        }

        .brand-link:hover {
            color: white;
        }
    </style>

    <!-- Hero Section -->
    <div class="hero-section mb-5">
        <div id="mainCarousel" class="carousel slide" data-bs-ride="carousel">
            <div class="carousel-inner">
                <div class="carousel-item active">
                    <img src="https://images.unsplash.com/photo-1552346154-21d32810aba3?q=80&w=1920&auto=format&fit=crop"
                        class="d-block w-100" alt="Sneaker Culture">
                    <div class="carousel-caption container">
                        <h2>THE FUTURE<br>OF SNEAKERS</h2>
                        <p class="fs-4 mb-4">Verification runner for the streets.</p>
                        <a href="{{ route('products.index') }}" class="btn btn-hero">SHOP LATEST</a>
                    </div>
                </div>
                <div class="carousel-item">
                    <img src="https://images.unsplash.com/photo-1607522370275-f14206abe5d3?q=80&w=1920&auto=format&fit=crop"
                        class="d-block w-100" alt="New Drops">
                    <div class="carousel-caption container">
                        <h2>ICONIC<br>DROPS ONLY</h2>
                        <p class="fs-4 mb-4">Limited edition releases available now.</p>
                        <a href="{{ route('products.index') }}" class="btn btn-hero">VIEW COLLECTION</a>
                        <!-- Brand Ticker -->
                        <div class="brand-section mb-5 text-center">
                            <div class="container d-flex justify-content-center flex-wrap">
                                @foreach($brandCategories as $brand)
                                    <a href="{{ route('products.index', ['category' => $brand->slug]) }}"
                                        class="brand-link">{{ strtoupper($brand->name) }}</a>
                                @endforeach
                                <a href="#" class="brand-link">YEEZY</a>
                                <a href="#" class="brand-link">OFF-WHITE</a>
                                <a href="#" class="brand-link">BALENCIAGA</a>
                            </div>
                        </div>

                        <!-- Gender Section -->
                        <div class="container mb-5">
                            <h2 class="section-title mb-4">SHOP BY GENDER</h2>
                            <div class="row">
                                @foreach($genderCategories as $gender)
                                    <div class="col-md-4 mb-4">
                                        <div class="gender-card"
                                            onclick="window.location.href='{{ route('products.index', ['gender' => $gender->name]) }}'">
                                            <img src="{{ $gender->image ? asset('storage/' . $gender->image) : 'https://via.placeholder.com/600x800' }}"
                                                class="gender-bg" alt="{{ $gender->name }}">
                                            <div class="gender-overlay">
                                                <h3>{{ strtoupper($gender->name) }}</h3>
                                                <p>View Collection <i class="fas fa-arrow-right ms-2"></i></p>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>

                        <div class="container">
                            <!-- Best Sellers -->
                            <div class="d-flex justify-content-between align-items-end mb-4">
                                <h2 class="section-title mb-0">BEST SELLERS</h2>
                                <a href="{{ route('products.index') }}" class="text-dark fw-bold text-decoration-none">VIEW
                                    ALL</a>
                            </div>

                            <div class="row mb-5">
                                @foreach($bestSellers as $product)
                                    <div class="col-md-3 mb-4">
                                        <div class="product-card h-100 position-relative">
                                            <div class="product-img-wrapper">
                                                @if($loop->index < 2)
                                                    <span
                                                        class="badge bg-danger position-absolute top-0 start-0 m-3 rounded-0 px-3 py-2">HOT</span>
                                                @endif
                                                <img src="{{ $product->images->first()->image ?? 'https://via.placeholder.com/300' }}"
                                                    alt="{{ $product->title }}">
                                                <a href="{{ route('wishlist.add', $product->id) }}"
                                                    class="btn btn-sm btn-white position-absolute top-0 end-0 m-3 shadow-sm rounded-circle z-2"
                                                    title="Add to Wishlist">
                                                    @if(session('wishlist') && isset(session('wishlist')[$product->id]))
                                                        <i class="fas fa-heart text-danger"></i>
                                                    @else
                                                        <i class="far fa-heart"></i>
                                                    @endif
                                                </a>
                                            </div>
                                            <div class="card-body">
                                                <p class="text-muted small mb-1 text-uppercase">
                                                    {{ $product->category->name ?? 'Sneakers' }}
                                                </p>
                                                <h5 class="card-title text-truncate mb-2">{{ $product->title }}</h5>
                                                <div class="d-flex justify-content-between align-items-center">
                                                    @if($product->discount_price && $product->discount_price > 0)
                                                        <div>
                                                            <h5 class="fw-bold mb-0 text-danger">
                                                                ৳{{ number_format($product->discount_price) }}</h5>
                                                            <small class="text-muted text-decoration-line-through"
                                                                style="font-size: 0.8rem;">৳{{ number_format($product->price) }}</small>
                                                        </div>
                                                    @else
                                                        <h5 class="fw-bold mb-0">৳{{ number_format($product->price) }}</h5>
                                                    @endif
                                                    <a href="{{ route('products.show', $product->slug) }}"
                                                        class="btn btn-sm btn-outline-dark rounded-0"><i
                                                            class="fas fa-plus"></i></a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>

                            <!-- Fresh Drops / New Arrivals -->
                            <div class="d-flex justify-content-between align-items-end mb-4">
                                <h2 class="section-title mb-0">FRESH DROPS</h2>
                            </div>
                            <div class="row mb-5">
                                @foreach($newArrivals->take(4) as $product)
                                    <div class="col-md-3 mb-4">
                                        <div class="product-card h-100 position-relative">
                                            <div class="product-img-wrapper">
                                                <span
                                                    class="badge bg-dark position-absolute top-0 start-0 m-3 rounded-0 px-3 py-2">NEW</span>
                                                <img src="{{ $product->images->first()->image ?? 'https://via.placeholder.com/300' }}"
                                                    alt="{{ $product->title }}">
                                                <a href="{{ route('wishlist.add', $product->id) }}"
                                                    class="btn btn-sm btn-white position-absolute top-0 end-0 m-3 shadow-sm rounded-circle z-2"
                                                    title="Add to Wishlist">
                                                    @if(session('wishlist') && isset(session('wishlist')[$product->id]))
                                                        <i class="fas fa-heart text-danger"></i>
                                                    @else
                                                        <i class="far fa-heart"></i>
                                                    @endif
                                                </a>
                                            </div>
                                            <div class="card-body">
                                                <p class="text-muted small mb-1 text-uppercase">
                                                    {{ $product->category->name ?? 'Sneakers' }}
                                                </p>
                                                <h5 class="card-title text-truncate mb-2">{{ $product->title }}</h5>
                                                <div class="d-flex justify-content-between align-items-center">
                                                    @if($product->discount_price && $product->discount_price > 0)
                                                        <div>
                                                            <h5 class="fw-bold mb-0 text-danger">
                                                                ৳{{ number_format($product->discount_price) }}</h5>
                                                            <small class="text-muted text-decoration-line-through"
                                                                style="font-size: 0.8rem;">৳{{ number_format($product->price) }}</small>
                                                        </div>
                                                    @else
                                                        <h5 class="fw-bold mb-0">৳{{ number_format($product->price) }}</h5>
                                                    @endif
                                                    <a href="{{ route('products.show', $product->slug) }}"
                                                        class="btn btn-sm btn-outline-dark rounded-0"><i
                                                            class="fas fa-plus"></i></a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>

                        <!-- Newsletter -->
                        <div class="bg-light py-5 mt-5">
                            <div class="container text-center">
                                <h2 class="mb-3">NEVER MISS A DROP</h2>
                                <p class="text-muted mb-4">Sign up for updates on new releases and exclusive access.</p>
                                <div class="row justify-content-center">
                                    <div class="col-md-6">
                                        <div class="input-group">
                                            <input type="email" class="form-control rounded-0 p-3"
                                                placeholder="ENTER EMAIL ADDRESS">
                                            <button class="btn btn-dark rounded-0 px-5 fw-bold" type="button">JOIN</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
@endsection