@extends('layouts.admin')

@section('title', 'Edit Slide')

@section('content')
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0 text-dark">Edit Slide</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('admin.hero-slides.index') }}">Hero Slides</a></li>
                        <li class="breadcrumb-item active">Edit Slide</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <section class="content">
        <div class="container-fluid">
            <div class="row justify-content-center">
                <div class="col-md-8">
                    <div class="card card-info">
                        <div class="card-header">
                            <h3 class="card-title">Edit Slide Details</h3>
                        </div>
                        <form action="{{ route('admin.hero-slides.update', $heroSlide->id) }}" method="POST"
                            enctype="multipart/form-data">
                            @csrf
                            @method('PUT')
                            <div class="card-body">
                                <div class="form-group">
                                    <label>Current Image</label><br>
                                    <img src="{{ $heroSlide->image }}" alt="Current Image" class="img-fluid rounded mb-2"
                                        style="max-height: 200px">
                                </div>
                                <div class="form-group">
                                    <label for="title">Title <small>(Optional)</small></label>
                                    <input type="text" name="title"
                                        class="form-control @error('title') is-invalid @enderror" id="title"
                                        value="{{ old('title', $heroSlide->title) }}">
                                    @error('title')
                                        <span class="error invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label for="sub_title">Subtitle <small>(Optional)</small></label>
                                    <input type="text" name="sub_title"
                                        class="form-control @error('sub_title') is-invalid @enderror" id="sub_title"
                                        value="{{ old('sub_title', $heroSlide->sub_title) }}">
                                    @error('sub_title')
                                        <span class="error invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label for="link">Button Link <small>(Optional)</small></label>
                                    <input type="url" name="link" class="form-control @error('link') is-invalid @enderror"
                                        id="link" value="{{ old('link', $heroSlide->link) }}">
                                    @error('link')
                                        <span class="error invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label for="image">Change Image <small>(Leave empty to keep current)</small></label>
                                    <div class="input-group">
                                        <div class="custom-file">
                                            <input type="file" name="image"
                                                class="custom-file-input @error('image') is-invalid @enderror" id="image">
                                            <label class="custom-file-label" for="image">Choose file</label>
                                        </div>
                                    </div>
                                    @error('image')
                                        <span class="error invalid-feedback" style="display:block">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <div class="custom-control custom-switch">
                                        <input type="checkbox" class="custom-control-input" id="status" name="status" {{ $heroSlide->status ? 'checked' : '' }}>
                                        <label class="custom-control-label" for="status">Active</label>
                                    </div>
                                </div>
                            </div>
                            <div class="card-footer">
                                <button type="submit" class="btn btn-info">Update Slide</button>
                                <a href="{{ route('admin.hero-slides.index') }}"
                                    class="btn btn-default float-right">Cancel</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection