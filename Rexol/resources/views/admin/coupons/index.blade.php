@extends('layouts.admin')

@section('title', 'Manage Coupons')

@section('content')
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Coupons</h3>
            <div class="card-tools">
                <a href="{{ route('admin.coupons.create') }}" class="btn btn-primary btn-sm">Add New Coupon</a>
            </div>
        </div>
        <div class="card-body table-responsive p-0">
            <table class="table table-hover text-nowrap">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Code</th>
                        <th>Type</th>
                        <th>Value</th>
                        <th>Min Amount</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($coupons as $coupon)
                        <tr>
                            <td>{{ $coupon->id }}</td>
                            <td><span class="badge badge-info">{{ $coupon->code }}</span></td>
                            <td>{{ ucfirst($coupon->discount_type) }}</td>
                            <td>{{ $coupon->discount_value }}</td>
                            <td>{{ $coupon->min_amount ?? '-' }}</td>
                            <td>
                                @if($coupon->status)
                                    <span class="badge badge-success">Active</span>
                                @else
                                    <span class="badge badge-danger">Inactive</span>
                                @endif
                            </td>
                            <td>
                                <a href="{{ route('admin.coupons.edit', $coupon->id) }}" class="btn btn-sm btn-warning">Edit</a>
                                <form action="{{ route('admin.coupons.destroy', $coupon->id) }}" method="POST"
                                    style="display:inline-block;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger"
                                        onclick="return confirm('Are you sure?')">Delete</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="text-center">No coupons found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="card-footer clearfix">
            {{ $coupons->links() }}
        </div>
    </div>
@endsection