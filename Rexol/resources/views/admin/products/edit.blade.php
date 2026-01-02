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
                                <label>Gender</label>
                                <select name="gender" class="form-control">
                                    <option value="">Select Gender</option>
                                    @foreach($genders as $gender)
                                        <option value="{{ $gender->name }}" {{ $product->gender == $gender->name ? 'selected' : '' }}>{{ $gender->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label>Price</label>
                                <input type="number" step="0.01" name="price" class="form-control"
                                    value="{{ $product->price }}" required>
                            </div>
                            <div class="form-group">
                                <label>Discount Price</label>
                                <input type="number" step="0.01" name="discount_price" class="form-control"
                                    value="{{ $product->discount_price }}">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Stock</label>
                                <input type="number" name="stock" class="form-control" value="{{ $product->stock }}">
                            </div>
                            <div class="form-group">
                                <label>Sizes</label>
                                <select class="form-control" name="sizes[]" multiple style="height: 100px;">
                                    @foreach($sizes as $size)
                                        <option value="{{ $size->id }}" {{ $product->sizes->contains($size->id) ? 'selected' : '' }}>
                                            {{ $size->name }}
                                        </option>
                                    @endforeach
                                </select>
                                <small class="text-muted">Hold Ctrl/Cmd to select multiple</small>
                            </div>
                            <div class="form-group">
                                <label>Add More Images</label>
                                <div class="input-group">
                                    <div class="custom-file">
                                        <input type="file" name="images[]" class="custom-file-input" id="exampleInputFile"
                                            multiple>
                                        <label class="custom-file-label" for="exampleInputFile">Choose files</label>
                                    </div>
                                </div>
                                @if($product->images->count() > 0)
                                    <div class="mt-2 row">
                                        @foreach($product->images as $img)
                                            <div class="col-3">
                                                <img src="{{ $img->image }}" class="img-thumbnail" style="height: 50px;">
                                            </div>
                                        @endforeach
                                    </div>
                                @endif
                            </div>
                            <div class="form-group mb-0">
                                <div class="custom-control custom-checkbox">
                                    <input type="checkbox" name="status" class="custom-control-input" id="status" {{ $product->status ? 'checked' : '' }}>
                                    <label class="custom-control-label" for="status">Active</label>
                                </div>
                                <div class="custom-control custom-checkbox mt-2">
                                    <input type="checkbox" name="featured" class="custom-control-input" id="featured" {{ $product->featured ? 'checked' : '' }}>
                                    <label class="custom-control-label" for="featured">Featured Product</label>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label>Description</label>
                        <textarea name="description" class="form-control" rows="3">{{ $product->description }}</textarea>
                    </div>

                    <div class="card card-secondary">
                        <div class="card-header">
                            <h3 class="card-title">SEO Settings</h3>
                        </div>
                        <div class="card-body">
                            <div class="form-group">
                                <label>Meta Title</label>
                                <input type="text" name="meta_title" class="form-control" value="{{ $product->meta_title }}" placeholder="SEO Title">
                            </div>
                            <div class="form-group">
                                <label>Meta Description</label>
                                <textarea name="meta_description" class="form-control" rows="2" placeholder="SEO Description">{{ $product->meta_description }}</textarea>
                            </div>
                            <div class="form-group">
                                <label>Meta Keywords</label>
                                <input type="text" name="meta_keywords" class="form-control" value="{{ $product->meta_keywords }}" placeholder="keyword1, keyword2">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-footer">
                    <button type="submit" class="btn btn-primary">Update Product</button>
                    <a href="{{ route('admin.products.index') }}" class="btn btn-default float-right">Cancel</a>
                </div>
        </form>
    </div>
@endsection