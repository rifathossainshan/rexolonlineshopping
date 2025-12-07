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
                                <div class="form-group">
                                    <label>Price</label>
                                    <input type="number" step="0.01" name="price" class="form-control" required>
                                </div>
                                <div class="form-group">
                                    <label>Discount Price</label>
                                    <input type="number" step="0.01" name="discount_price" class="form-control">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Stock</label>
                                    <input type="number" name="stock" class="form-control" value="0">
                                </div>
                                <div class="form-group">
                                    <label>Sizes</label>
                                    <div class="select2-purple">
                                        <select class="select2" name="sizes[]" multiple="multiple"
                                            data-placeholder="Select a Size" data-dropdown-css-class="select2-purple"
                                            style="width: 100%;">
                                            @foreach($sizes as $size)
                                                <option value="{{ $size->id }}">{{ $size->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <small class="text-muted">Hold Ctrl/Cmd to select multiple if not using Select2</small>
                                </div>
                                <div class="form-group">
                                    <label>Product Images (Multiple)</label>
                                    <div class="input-group">
                                        <div class="custom-file">
                                            <input type="file" name="images[]" class="custom-file-input" id="exampleInputFile"
                                                multiple>
                                            <label class="custom-file-label" for="exampleInputFile">Choose files</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group mb-0">
                                    <div class="custom-control custom-checkbox">
                                        <input type="checkbox" name="status" class="custom-control-input" id="status" checked>
                                        <label class="custom-control-label" for="status">Active</label>
                                    </div>
                                    <div class="custom-control custom-checkbox mt-2">
                                        <input type="checkbox" name="featured" class="custom-control-input" id="featured">
                                        <label class="custom-control-label" for="featured">Featured Product</label>
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
                        <a href="{{ route('admin.products.index') }}" class="btn btn-default float-right">Cancel</a>
                    </div>
            </form>
        </div>
    @endsection

    @section('scripts')
        <script>
            // Initialize Select2 Elements if available, or just standard select
            /* $('.select2').select2(); */
        </script>
    @endsection