@extends('layouts.admin')

@section('title', 'Edit Coupon')

@section('content')
    <div class="card card-primary">
        <div class="card-header">
            <h3 class="card-title">Edit Coupon: {{ $coupon->code }}</h3>
        </div>
        <form action="{{ route('admin.coupons.update', $coupon->id) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="card-body">
                <div class="form-group">
                    <label>Coupon Code</label>
                    <input type="text" name="code" class="form-control" value="{{ $coupon->code }}" required>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Discount Type</label>
                            <select name="discount_type" class="form-control">
                                <option value="fixed" {{ $coupon->discount_type == 'fixed' ? 'selected' : '' }}>Fixed Amount
                                </option>
                                <option value="percent" {{ $coupon->discount_type == 'percent' ? 'selected' : '' }}>Percentage
                                    (%)</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Discount Value</label>
                            <input type="number" name="discount_value" class="form-control" step="0.01"
                                value="{{ $coupon->discount_value }}" required>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <label>Minimum Order Amount (Optional)</label>
                    <input type="number" name="min_amount" class="form-control" step="0.01"
                        value="{{ $coupon->min_amount }}">
                </div>
                <div class="form-group mb-0">
                    <div class="custom-control custom-checkbox">
                        <input type="checkbox" name="status" class="custom-control-input" id="status" {{ $coupon->status ? 'checked' : '' }}>
                        <label class="custom-control-label" for="status">Active</label>
                    </div>
                </div>
            </div>
            <div class="card-footer">
                <button type="submit" class="btn btn-primary">Update Coupon</button>
                <a href="{{ route('admin.coupons.index') }}" class="btn btn-default float-right">Cancel</a>
            </div>
        </form>
    </div>
@endsection