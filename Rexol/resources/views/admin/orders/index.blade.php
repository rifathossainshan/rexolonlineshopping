@extends('layouts.admin')

@section('title', 'Orders')

@section('content')
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Order List</h3>
        </div>
        <div class="card-body p-0">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Customer</th>
                        <th>Total</th>
                        <th>Status</th>
                        <th>Date</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($orders as $order)
                        <tr>
                            <td>{{ $order->id }}</td>
                            <td>
                                {{ $order->name }}<br>
                                <small>{{ $order->phone }}</small>
                            </td>
                            <td>৳{{ $order->total_amount }}</td>
                            <td>
                                <span
                                    class="badge badge-{{ $order->status == 'completed' ? 'success' : ($order->status == 'pending' ? 'warning' : ($order->status == 'rejected' || $order->status == 'cancelled' ? 'danger' : ($order->status == 'accepted' ? 'primary' : 'info'))) }}">
                                    {{ ucfirst($order->status) }}
                                </span>
                            </td>
                            <td>{{ $order->created_at->format('d M Y') }}</td>
                            <td>
                                <a href="{{ route('admin.orders.show', $order->id) }}" class="btn btn-primary btn-sm">View</a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection