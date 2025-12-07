@extends('layouts.admin')

@section('title', 'Create Coupon')

@section('content')
    <div class="card card-primary">
        <div class="card-header">
            <h3 class="card-title">Add New Coupon</h3>
        </div>
        <form action="{{ route('admin.coupons.store') }}" method="POST">
            @csrf
            <div class="card-body">
                <div class="form-group">
                    <label>Coupon Code</label>
                    <input type="text" name="code" class="form-control" placeholder="Enter unique code" required>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Discount Type</label>
                            <select name="discount_type" class="form-control">
                                <option value="fixed">Fixed Amount</option>
                                <option value="percent">Percentage (%)</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Discount Value</label>
                            <input type="number" name="discount_value" class="form-control" step="0.01" required>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <label>Minimum Order Amount (Optional)</label>
                    <input type="number" name="min_amount" class="form-control" step="0.01">
                </div>
                <div class="form-group mb-0">
                    <div class="custom-control custom-checkbox">
                        <input type="checkbox" name="status" class="custom-control-input" id="status" checked>
                        <label class="custom-control-label" for="status">Active</label>
                    </div>
                </div>
            </div>
            <div class="card-footer">
                <button type="submit" class="btn btn-primary">Save Coupon</button>
                <a href="{{ route('admin.coupons.index') }}" class="btn btn-default float-right">Cancel</a>
            </div>
        </form>
    </div>
@endsection