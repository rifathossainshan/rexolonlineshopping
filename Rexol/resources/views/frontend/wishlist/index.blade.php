@extends('layouts.frontend')

@section('content')
    <div class="container py-5">
        <h2 class="mb-5 display-5 fw-bold text-uppercase">My Wishlist</h2>

        @if(session('success'))
            <div class="alert alert-success rounded-0 mb-4">{{ session('success') }}</div>
        @endif
        @if(session('info'))
            <div class="alert alert-info rounded-0 mb-4">{{ session('info') }}</div>
        @endif

        @if(count($wishlist) > 0)
            <div class="row g-4">
                @foreach($wishlist as $id => $item)
                    <div class="col-md-3 col-6">
                        <div class="card h-100 border-0 shadow-sm product-card">
                            <div class="position-relative overflow-hidden">
                                <a href="{{ route('products.show', $item['slug']) }}">
                                    <img src="{{ $item['image'] }}" class="card-img-top" alt="{{ $item['name'] }}"
                                        style="height: 300px; object-fit: cover; transition: transform 0.5s ease;">
                                </a>
                                <a href="{{ route('wishlist.remove', $id) }}"
                                    class="btn btn-sm btn-white position-absolute top-0 end-0 m-3 shadow-sm rounded-circle"
                                    title="Remove from Wishlist">
                                    <i class="fas fa-times text-danger"></i>
                                </a>
                            </div>
                            <div class="card-body text-center">
                                <h6 class="card-title fw-bold text-uppercase mb-2 text-truncate">
                                    <a href="{{ route('products.show', $item['slug']) }}"
                                        class="text-decoration-none text-dark">{{ $item['name'] }}</a>
                                </h6>
                                <p class="card-text fw-bold text-danger mb-3">
                                    ৳{{ number_format($item['price']) }}
                                    @if($item['original_price'] > $item['price'])
                                        <small
                                            class="text-muted text-decoration-line-through fw-normal ms-1">৳{{ number_format($item['original_price']) }}</small>
                                    @endif
                                </p>
                                <a href="{{ route('products.show', $item['slug']) }}"
                                    class="btn btn-dark w-100 rounded-0 text-uppercase fw-bold btn-sm">View Item</a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <div class="text-center py-5">
                <i class="far fa-heart display-1 text-muted mb-4 opacity-25"></i>
                <h3 class="text-uppercase fw-bold mb-3">Your Wishlist is Empty</h3>
                <p class="text-muted mb-4">Save items you love here for later.</p>
                <a href="{{ route('products.index') }}" class="btn btn-dark px-5 py-3 rounded-0 text-uppercase fw-bold">Start
                    Shopping</a>
            </div>
        @endif
    </div>

    <style>
        .product-card:hover img {
            transform: scale(1.05);
        }
    </style>
@endsection