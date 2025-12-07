@extends('layouts.frontend')

@section('content')
    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-md-8 text-center">
                <div class="mb-4">
                    <i class="fas fa-check-circle text-success" style="font-size: 5rem;"></i>
                </div>
                <h1 class="mb-3">Thank You for Your Order!</h1>
                <p class="lead mb-4">Your order <strong>#{{ $order->id }}</strong> has been placed and is currently
                    <strong>PENDING REVIEW</strong>.</p>

                <div class="card shadow-sm border-0 mb-4 text-start">
                    <div class="card-body p-4">
                        <p class="mb-2">Our representative will contact you soon to confirm your order details.</p>
                        <p class="text-muted small mb-0">Order Date: {{ $order->created_at->format('M d, Y') }}</p>
                    </div>
                </div>

                <div class="d-flex justify-content-center gap-3">
                    <a href="{{ route('home') }}"
                        class="btn btn-outline-dark rounded-0 px-4 py-2 fw-bold text-uppercase">Return Home</a>
                    <a href="{{ route('invoice.download', $order->id) }}"
                        class="btn btn-primary rounded-0 px-4 py-2 fw-bold text-uppercase">
                        <i class="fas fa-file-pdf me-2"></i> Download Invoice
                    </a>
                </div>
            </div>
        </div>
    </div>
@endsection