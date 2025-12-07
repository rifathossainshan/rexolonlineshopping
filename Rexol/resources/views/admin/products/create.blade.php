@extends('layouts.admin')

@section('title', 'Add Product')

@section('content')
    <div class="card card-primary">
        <div class="card-header">
            <h3 class="card-title">Create New Product</h3>
        </div>
        <form action="{{ route('admin.products.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Product Title</label>
                            <input type="text" name="title" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label>Category</label>
                            <select name="category_id" class="form-control" required>
                                <option value="">Select Category</option>
                                @foreach($categories as $category)
                                    <option value="{{ $category->id }}">{{ $category->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
                <div class="form-group mb-0">
                    <div class="custom-control custom-checkbox">
                        <input type="checkbox" name="status" class="custom-control-input" id="status" checked>
                        <label class="custom-control-label" for="status">Active</label>
                    </div>
                </div>
            </div>
    </div>
    <div class="form-group">
        <label>Description</label>
        <textarea name="description" class="form-control" rows="3"></textarea>
    </div>
    </div>
    <div class="card-footer">
        <button type="submit" class="btn btn-primary">Create Product</button>
    </div>
    </form>
    </div>
@endsection