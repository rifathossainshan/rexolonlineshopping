@extends('layouts.admin')

@section('title', 'Products')

@section('content')
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">All Products</h3>
            <div class="card-tools">
                <a href="{{ route('admin.products.create') }}" class="btn btn-primary btn-sm">
                    <i class="fas fa-plus"></i> Add New
                </a>
            </div>
        </div>
        <div class="card-body p-0">
            <table class="table table-striped projects">
                <thead>
                    <tr>
                        <th style="width: 1%">#</th>
                        <th style="width: 10%">Image</th>
                        <th style="width: 30%">Title</th>
                        <th style="width: 15%">Category</th>
                        <th style="width: 10%">Price</th>
                        <th style="width: 10%">Stock</th>
                        <th style="width: 20%">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($products as $product)
                        <tr>
                            <td>{{ $product->id }}</td>
                            <td>
                                <img src="{{ $product->images->first()->image ?? '' }}" alt="Product Image"
                                    class="img-circle img-size-32 mr-2">
                            </td>
                            <td>{{ $product->title }}</td>
                            <td>{{ $product->category->name ?? 'N/A' }}</td>
                            <td>৳{{ $product->price }}</td>
                            <td>{{ $product->stock }}</td>
                            <td class="project-actions">
                                <!-- Edit button omitted for brevity but link should exist -->
                                <form action="{{ route('admin.products.destroy', $product->id) }}" method="POST"
                                    style="display:inline-block;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm"
                                        onclick="return confirm('Are you sure?')">
                                        <i class="fas fa-trash"></i> Delete
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection