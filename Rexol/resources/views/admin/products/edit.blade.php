@extends('layouts.admin')

@section('title', 'Edit Product')

@section('content')
    <div class="card card-primary">
        <div class="card-header">
            <h3 class="card-title">Edit Product: {{ $product->title }}</h3>
        </div>
        <form action="{{ route('admin.products.update', $product->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Product Title</label>
                            <input type="text" name="title" class="form-control" value="{{ $product->title }}" required>
                        </div>
                        <div class="form-group">
                            <label>Category</label>
                            <select name="category_id" class="form-control" required>
                                <option value="">Select Category</option>
                                @foreach($categories as $category)
                                    <option value="{{ $category->id }}" {{ $product->category_id == $category->id ? 'selected' : '' }}>
                                        {{ $category->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Price</label>
                            <input type="number" name="price" class="form-control" value="{{ $product->price }}" required>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Stock</label>
                            <input type="number" name="stock" class="form-control" value="{{ $product->stock }}">
                        </div>
                        <div class="form-group">
                            <label>Sizes (Comma separated)</label>
                            <input type="text" name="sizes" class="form-control"
                                value="{{ $product->sizes ? implode(',', $product->sizes) : '' }}"
                                placeholder="US 7,US 8,US 9">
                        </div>
                        <div class="form-group">
                            <label>Main Image</label>
                            @if($product->images->count() > 0)
                                <div class="mb-2">
                                    <img src="{{ $product->images->first()->image }}" alt="Current Image" style="height: 50px;">
                                </div>
                            @endif
                            <div class="input-group">
                                <div class="custom-file">
                                    <input type="file" name="image" class="custom-file-input" id="exampleInputFile">
                                    <label class="custom-file-label" for="exampleInputFile">Choose file to replace</label>
                                </div>
                            </div>
                        </div>
                        <div class="form-group mb-0">
                            <div class="custom-control custom-checkbox">
                                <input type="checkbox" name="status" class="custom-control-input" id="status" {{ $product->status ? 'checked' : '' }}>
                                <label class="custom-control-label" for="status">Active</label>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <label>Description</label>
                    <textarea name="description" class="form-control" rows="3">{{ $product->description }}</textarea>
                </div>
            </div>
            <div class="card-footer">
                <button type="submit" class="btn btn-primary">Update Product</button>
                <a href="{{ route('admin.products.index') }}" class="btn btn-default float-right">Cancel</a>
            </div>
        </form>
    </div>
@endsection