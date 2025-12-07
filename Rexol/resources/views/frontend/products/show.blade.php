@extends('layouts.frontend')

@section('content')
    <div class="container">
        <div class="row">
            <!-- Product Images -->
            <div class="col-md-6 mb-4">
                <div id="productCarousel" class="carousel slide" data-bs-ride="carousel">
                    <div class="carousel-inner">
                        @forelse($product->images as $key => $image)
                            <div class="carousel-item {{ $key == 0 ? 'active' : '' }}">
                                <img src="{{ $image->image }}" class="d-block w-100" alt="{{ $product->title }}">
                            </div>
                        @empty
                            <div class="carousel-item active">
                                <img src="https://via.placeholder.com/600x400" class="d-block w-100"
                                    alt="{{ $product->title }}">
                            </div>
                        @endforelse
                    </div>
                    @if($product->images->count() > 1)
                        <button class="carousel-control-prev" type="button" data-bs-target="#productCarousel"
                            data-bs-slide="prev">
                            <span class="carousel-control-prev-icon"></span>
                        </button>
                        <button class="carousel-control-next" type="button" data-bs-target="#productCarousel"
                            data-bs-slide="next">
                            <span class="carousel-control-next-icon"></span>
                        </button>
                    @endif
                </div>
            </div>

            <!-- Product Details -->
            <div class="col-md-6">
                <h1>{{ $product->title }}</h1>
                <p class="text-muted">Category: {{ $product->category->name }}</p>
                @if($product->discount_price && $product->discount_price > 0)
                    <h3 class="text-danger mb-3">
                        ৳{{ number_format($product->discount_price) }}
                        <small
                            class="text-muted text-decoration-line-through fs-6">৳{{ number_format($product->price) }}</small>
                    </h3>
                @else
                    <h3 class="text-danger mb-3">৳{{ number_format($product->price) }}</h3>
                @endif

                <p>{{ $product->description }}</p>

                <div class="mb-4">
                    @if($product->stock > 0)
                        <span class="badge bg-success">In Stock ({{ $product->stock }})</span>
                    @else
                        <span class="badge bg-danger">Out of Stock</span>
                    @endif
                </div>

                <form action="{{ route('cart.add', $product->id) }}" method="POST" class="mb-3">
                    @csrf

                    @if($product->sizes)
                        <div class="mb-3">
                            <label class="form-label fw-bold">Select Size:</label>
                            <div class="d-flex gap-2 flex-wrap">
                                @foreach($product->sizes as $size)
                                    <input type="radio" class="btn-check" name="size" id="size_{{ $loop->index }}"
                                        value="{{ $size->name }}" required>
                                    <label class="btn btn-outline-dark" for="size_{{ $loop->index }}">{{ $size->name }}</label>
                                @endforeach
                            </div>
                        </div>
                    @endif

                    <div class="input-group mb-3" style="max-width: 200px;">
                        <span class="input-group-text">Qty</span>
                        <input type="number" name="quantity" class="form-control" value="1" min="1"
                            max="{{ $product->stock }}">
                    </div>

                    <div class="d-flex gap-2">
                        <button type="submit" class="btn btn-primary btn-lg flex-grow-1">Add to Cart</button>
                        <button type="submit" name="buy_now" value="1" class="btn btn-success btn-lg flex-grow-1">Buy
                            Now</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection