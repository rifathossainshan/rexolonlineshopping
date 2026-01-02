@extends('layouts.admin')

@section('title', 'Edit Category')

@section('content')
    <div class="card card-primary">
        <div class="card-header">
            <h3 class="card-title">Edit Category: {{ $category->name }}</h3>
        </div>
        <form action="{{ route('admin.categories.update', $category->id) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="card-body">
                <div class="form-group">
                    <label>Category Name</label>
                    <input type="text" name="name" class="form-control" value="{{ $category->name }}" required>
                </div>
                <div class="form-group">
                    <label>Type</label>
                    <select name="type" class="form-control">
                        <option value="standard" {{ $category->type == 'standard' ? 'selected' : '' }}>Standard Category
                        </option>
                        <option value="gender" {{ $category->type == 'gender' ? 'selected' : '' }}>Gender (for Shop By Gender)
                        </option>
                    </select>
                </div>
                <div class="form-group mb-0">
                    <div class="custom-control custom-checkbox">
                        <input type="checkbox" name="status" class="custom-control-input" id="status" {{ $category->status ? 'checked' : '' }}>
                        <label class="custom-control-label" for="status">Active</label>
                    </div>
                </div>
            </div>
            <div class="card-footer">
                <button type="submit" class="btn btn-primary">Update</button>
                <a href="{{ route('admin.categories.index') }}" class="btn btn-default float-right">Cancel</a>
            </div>
        </form>
    </div>
@endsection