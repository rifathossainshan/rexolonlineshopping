@extends('layouts.admin')

@section('title', 'Hero Slides')

@section('content')
    <div class="row mb-2">
        <div class="col-sm-6">
            <h1 class="m-0 text-dark">Hero Slides</h1>
        </div>
        <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
                <li class="breadcrumb-item active">Hero Slides</li>
            </ol>
        </div>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif

    <div class="card">
        <div class="card-header">
            <h3 class="card-title">All Slides</h3>
            <div class="card-tools">
                <a href="{{ route('admin.hero-slides.create') }}" class="btn btn-primary btn-sm">
                    <i class="fas fa-plus"></i> Add New Slide
                </a>
            </div>
        </div>
        <div class="card-body p-0">
            <table class="table table-striped projects">
                <thead>
                    <tr>
                        <th style="width: 1%">#</th>
                        <th style="width: 20%">Image</th>
                        <th style="width: 30%">Title / Subtitle</th>
                        <th style="width: 20%">Link</th>
                        <th>Status</th>
                        <th style="width: 20%">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($slides as $slide)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>
                                <img src="{{ $slide->image }}" alt="Slide Image" class="img-fluid rounded"
                                    style="max-height: 50px;">
                            </td>
                            <td>
                                <strong>{{ $slide->title }}</strong><br>
                                <small>{{ $slide->sub_title }}</small>
                            </td>
                            <td>
                                @if($slide->link)
                                    <a href="{{ $slide->link }}" target="_blank">{{ Str::limit($slide->link, 30) }}</a>
                                @else
                                    <span class="text-muted">No Link</span>
                                @endif
                            </td>
                            <td>
                                <span class="badge badge-{{ $slide->status ? 'success' : 'secondary' }}">
                                    {{ $slide->status ? 'Active' : 'Inactive' }}
                                </span>
                            </td>
                            <td>
                                <a class="btn btn-info btn-sm" href="{{ route('admin.hero-slides.edit', $slide->id) }}">
                                    <i class="fas fa-pencil-alt"></i> Edit
                                </a>
                                <form action="{{ route('admin.hero-slides.destroy', $slide->id) }}" method="POST"
                                    style="display:inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm"
                                        onclick="return confirm('Are you sure?')">
                                        <i class="fas fa-trash"></i> Delete
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center text-muted">No slides found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection