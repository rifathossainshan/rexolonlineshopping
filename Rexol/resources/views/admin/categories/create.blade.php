@extends('layouts.admin')

@section('title', 'Create ' . (request('type') == 'gender' ? 'Gender' : 'Category'))

@section('content')
    <div class="card card-primary">
        <div class="card-header">
            <h3 class="card-title">Add New {{ request('type') == 'gender' ? 'Gender' : 'Category' }}</h3>
        </div>
        <form action="{{ route('admin.categories.store') }}" method="POST">
            @csrf
            <div class="card-body">
                <div class="form-group">
                    <label>Name</label>
                    <input type="text" name="name" class="form-control" placeholder="Enter name" required>
                </div>
                <div class="form-group">
                    <label>Filter Name (Slug)</label>
                    <input type="text" name="slug" class="form-control"
                        placeholder="Enter filter name (optional - auto generated if empty)">
                    <small class="text-muted">This will be used in the URL filter (e.g., ?gender=male).</small>
                </div>

                @if(request('type'))
                    <input type="hidden" name="type" value="{{ request('type') }}">
                @else
                    <div class="form-group">
                        <label>Type</label>
                        <select name="type" class="form-control">
                            <option value="standard">Standard Category</option>
                            <option value="gender">Gender (for Shop By Gender)</option>
                        </select>
                    </div>
                @endif
                <div class="form-group mb-0">
                    <div class="custom-control custom-checkbox">
                        <input type="checkbox" name="status" class="custom-control-input" id="status" checked>
                        <label class="custom-control-label" for="status">Active</label>
                    </div>
                </div>
            </div>
            <div class="card-footer">
                <button type="submit" class="btn btn-primary">Submit</button>
                <a href="{{ route('admin.categories.index') }}" class="btn btn-default float-right">Cancel</a>
            </div>
        </form>
    </div>
@endsection