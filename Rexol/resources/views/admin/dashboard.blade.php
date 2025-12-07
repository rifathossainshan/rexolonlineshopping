@extends('layouts.admin')

@section('title', 'Dashboard')

@section('content')
    <style>
        /* Premium Dashboard Styles */
        .content-wrapper {
            background-color: #f4f6f9;
        }
        .small-box {
            border-radius: 12px;
            box-shadow: 0 5px 15px rgba(0,0,0,0.08);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            overflow: hidden;
            border: none;
        }
        .small-box:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 25px rgba(0,0,0,0.15);
        }
        .small-box .inner {
            padding: 20px;
        }
        .small-box h3 {
            font-weight: 700;
            font-size: 2.5rem;
            margin-bottom: 5px;
        }
        .small-box p {
            font-size: 1.1rem;
            opacity: 0.9;
        }
        .small-box .icon {
            top: 15px;
            right: 15px;
            opacity: 0.2;
            transition: all 0.3s linear;
        }
        .small-box:hover .icon {
            transform: scale(1.1);
            opacity: 0.3;
        }
        .small-box-footer {
            background: rgba(0,0,0,0.1) !important;
            border-radius: 0 0 12px 12px;
            padding: 8px 0;
        }
        
        /* Quick Actions Toolbar */
        .quick-actions-card {
            background: #fff;
            border-radius: 12px;
            box-shadow: 0 4px 6px rgba(0,0,0,0.05);
            padding: 15px 20px;
            margin-bottom: 20px;
        }
        .quick-action-btn {
            display: inline-flex;
            align-items: center;
            padding: 8px 16px;
            margin-right: 10px;
            border-radius: 8px;
            font-weight: 600;
            transition: all 0.2s;
            text-decoration: none !important;
        }
        .quick-action-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 8px rgba(0,0,0,0.1);
        }
        .btn-action-primary {
            background-color: #e3f2fd;
            color: #1976d2;
        }
        .btn-action-success {
            background-color: #e8f5e9;
            color: #2e7d32;
        }
        .btn-action-info {
            background-color: #e1f5fe;
            color: #0288d1;
        }

        /* Gradients */
        .bg-gradient-info-custom {
            background: linear-gradient(135deg, #17a2b8 0%, #117a8b 100%) !important;
            color: white;
        }
        .bg-gradient-success-custom {
            background: linear-gradient(135deg, #28a745 0%, #1e7e34 100%) !important;
            color: white;
        }
        .bg-gradient-warning-custom {
            background: linear-gradient(135deg, #ffc107 0%, #d39e00 100%) !important;
            color: #1f2d3d;
        }
        .bg-gradient-danger-custom {
            background: linear-gradient(135deg, #dc3545 0%, #bd2130 100%) !important;
            color: white;
        }
        .bg-gradient-primary-custom {
            background: linear-gradient(135deg, #007bff 0%, #0056b3 100%) !important;
            color: white;
        }

        /* Cards */
        .card {
            border-radius: 12px;
            border: none;
            box-shadow: 0 4px 12px rgba(0,0,0,0.05);
            margin-bottom: 25px;
        }
        .card-header {
            background-color: transparent;
            border-bottom: 1px solid rgba(0,0,0,0.05);
            padding: 1.25rem;
        }
        .card-title {
            font-weight: 600;
            color: #343a40;
        }
        .table thead th {
            border-top: none;
            border-bottom: 2px solid #f4f6f9;
            font-weight: 600;
            color: #6c757d;
            text-transform: uppercase;
            font-size: 0.85rem;
            letter-spacing: 0.5px;
        }
        .table td {
            vertical-align: middle;
            border-top: 1px solid #f4f6f9;
        }
        .badge {
            font-weight: 500;
            padding: 6px 10px;
            border-radius: 6px;
        }
        
        /* User List */
        .users-list > li {
            width: 100%;
            float: none;
            display: flex;
            align-items: center;
            padding: 15px;
            border-bottom: 1px solid #f4f6f9;
            transition: background-color 0.2s;
        }
        .users-list > li:hover {
            background-color: #fafafa;
        }
        .users-list > li:last-child {
            border-bottom: none;
        }
        .user-avatar {
            width: 45px; 
            height: 45px; 
            border-radius: 50%; 
            background: #e9ecef; 
            color: #6c757d;
            display: flex; 
            align-items: center; 
            justify-content: center; 
            margin-right: 15px;
            font-size: 1.2rem;
        }
        .users-list-name {
            color: #343a40;
            font-weight: 600;
            font-size: 1rem;
        }
        .users-list-date {
            color: #adb5bd;
            font-size: 0.85rem;
        }
        
        /* Product Image in Table */
        .img-product-small {
            width: 40px;
            height: 40px;
            object-fit: cover;
            border-radius: 6px;
        }
    </style>

    <!-- Quick Actions Toolbar -->
    <div class="quick-actions-card d-flex align-items-center justify-content-between">
        <div class="d-flex align-items-center">
            <h5 class="mb-0 mr-4 font-weight-bold text-dark"><i class="fas fa-bolt text-warning mr-2"></i> Quick Actions</h5>
            <a href="{{ route('admin.products.create') }}" class="quick-action-btn btn-action-primary">
                <i class="fas fa-plus mr-2"></i> Add Product
            </a>
            <a href="{{ route('admin.categories.index') }}" class="quick-action-btn btn-action-success">
                <i class="fas fa-tags mr-2"></i> Add Category
            </a>
            <a href="{{ route('admin.orders.index') }}" class="quick-action-btn btn-action-info">
                <i class="fas fa-list mr-2"></i> View Orders
            </a>
        </div>
        <div class="text-muted text-sm">
            <i class="far fa-clock mr-1"></i> {{ date('l, F j, Y') }}
        </div>
    </div>

    <!-- Stats Row -->
    <div class="row">
        <!-- New Orders -->
        <div class="col-lg-3 col-6">
            <div class="small-box bg-gradient-info-custom">
                <div class="inner">
                    <h3>{{ $totalOrders }}</h3>
                    <p>New Orders</p>
                </div>
                <div class="icon">
                    <i class="fas fa-shopping-bag"></i>
                </div>
                <a href="{{ route('admin.orders.index') }}" class="small-box-footer">More info <i
                        class="fas fa-arrow-circle-right"></i></a>
            </div>
        </div>

        <!-- Total Revenue -->
        <div class="col-lg-3 col-6">
            <div class="small-box bg-gradient-success-custom">
                <div class="inner">
                    <h3>${{ number_format($totalRevenue, 2) }}</h3>
                    <p>Total Revenue</p>
                </div>
                <div class="icon">
                    <i class="fas fa-chart-line"></i>
                </div>
                <a href="{{ route('admin.orders.index') }}" class="small-box-footer">More info <i
                        class="fas fa-arrow-circle-right"></i></a>
            </div>
        </div>

        <!-- Low Stock -->
        <div class="col-lg-3 col-6">
            <div class="small-box {{ $lowStockCount > 0 ? 'bg-gradient-warning-custom' : 'bg-gradient-primary-custom' }}">
                <div class="inner">
                    <h3>{{ $lowStockCount }}</h3>
                    <p>Low Stock Products</p>
                </div>
                <div class="icon">
                    <i class="fas fa-exclamation-triangle"></i>
                </div>
                <a href="{{ route('admin.products.index') }}" class="small-box-footer">More info <i
                        class="fas fa-arrow-circle-right"></i></a>
            </div>
        </div>

        <!-- New Users -->
        <div class="col-lg-3 col-6">
            <div class="small-box bg-gradient-danger-custom">
                <div class="inner">
                    <h3>{{ $totalUsers }}</h3>
                    <p>User Registrations</p>
                </div>
                <div class="icon">
                    <i class="fas fa-user-plus"></i>
                </div>
                <a href="{{ route('admin.users.index') }}" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
            </div>
        </div>
    </div>

    <!-- Analysis Row -->
    <div class="row">
        <!-- Top Selling Products -->
        <div class="col-lg-8">
            <div class="card">
                <div class="card-header border-0">
                    <h3 class="card-title">Top Selling Products</h3>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table m-0">
                            <thead>
                                <tr>
                                    <th>Product</th>
                                    <th>Price</th>
                                    <th class="text-center">Sold</th>
                                    <th class="text-right">Revenue</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($topProducts as $product)
                                    <tr>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                @if($product->images->isNotEmpty())
                                                    <img src="{{ Storage::url($product->images->first()->image_path) }}" alt="Product Image" class="img-product-small mr-2">
                                                @else
                                                    <div class="img-product-small mr-2 bg-light d-flex align-items-center justify-content-center">
                                                        <i class="fas fa-box text-muted"></i>
                                                    </div>
                                                @endif
                                                <span class="font-weight-bold">{{ Str::limit($product->title, 40) }}</span>
                                            </div>
                                        </td>
                                        <td>${{ number_format($product->price, 2) }}</td>
                                        <td class="text-center">
                                            <span class="badge badge-success" style="font-size: 0.9em;">{{ $product->total_sold }}</span>
                                        </td>
                                        <td class="text-right font-weight-bold">
                                            ${{ number_format($product->price * $product->total_sold, 2) }}
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" class="text-center text-muted py-4">No sales data available yet.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <!-- Order Status Chart -->
        <div class="col-lg-4">
             <div class="card">
                <div class="card-header border-0">
                    <h3 class="card-title">Order Status</h3>
                </div>
                <div class="card-body">
                    <div class="position-relative" style="min-height: 250px;">
                         <canvas id="status-chart" height="250"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Main Charts & Activity Row -->
    <div class="row">
        <!-- Left col: Sales Chart -->
        <div class="col-lg-7">
            <div class="card">
                <div class="card-header border-0">
                    <div class="d-flex justify-content-between align-items-center">
                        <h3 class="card-title">Sales Overview</h3>
                    </div>
                </div>
                <div class="card-body">
                    <div class="position-relative mb-4">
                        <canvas id="sales-chart" height="250"></canvas>
                    </div>
                </div>
            </div>

            <!-- Recent Orders -->
            <div class="card">
                <div class="card-header border-transparent">
                    <h3 class="card-title">Recent Orders</h3>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table m-0">
                            <thead>
                                <tr>
                                    <th>Order ID</th>
                                    <th>Customer</th>
                                    <th>Status</th>
                                    <th class="text-right">Amount</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($recentOrders as $order)
                                    <tr>
                                        <td><a href="{{ route('admin.orders.show', $order) }}" class="font-weight-bold text-dark">#{{ $order->id }}</a></td>
                                        <td>{{ $order->name }}</td>
                                        <td>
                                            <span
                                                class="badge badge-{{ $order->status == 'completed' ? 'success' : ($order->status == 'pending' ? 'warning' : 'danger') }}">
                                                {{ ucfirst($order->status) }}
                                            </span>
                                        </td>
                                        <td class="text-right font-weight-bold">${{ number_format($order->total_amount, 2) }}</td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" class="text-center text-muted py-4">No recent orders found.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="card-footer clearfix bg-transparent border-top-0">
                    <a href="{{ route('admin.orders.index') }}" class="btn btn-sm btn-light float-right text-primary font-weight-bold">View All Orders</a>
                </div>
            </div>
        </div>

        <!-- Right col: New Users -->
        <div class="col-lg-5">
            <div class="card">
                <div class="card-header border-0">
                    <h3 class="card-title">New Members</h3>
                    <div class="card-tools">
                       <span class="badge badge-info">{{ $recentUsers->count() }} New</span>
                    </div>
                </div>
                <div class="card-body p-0">
                    <ul class="users-list clearfix">
                        @forelse($recentUsers as $user)
                            <li>
                                <div class="user-avatar">
                                    {{ strtoupper(substr($user->name, 0, 1)) }}
                                </div>
                                <div>
                                    <a class="users-list-name" href="#">{{ $user->name }}</a>
                                    <span class="users-list-date">{{ $user->created_at->diffForHumans() }}</span>
                                </div>
                            </li>
                        @empty
                             <li class="justify-content-center text-muted">No new users.</li>
                        @endforelse
                    </ul>
                </div>
                <div class="card-footer text-center bg-transparent border-top-0">
                    <a href="#" class="btn-link">View All Users</a>
                </div>
            </div>
        </div>
    </div>

    <!-- ChartJS -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Sales Chart
            const salesCtx = document.getElementById('sales-chart').getContext('2d');
            const salesGradient = salesCtx.createLinearGradient(0, 0, 0, 400);
            salesGradient.addColorStop(0, 'rgba(60,141,188,0.5)');
            salesGradient.addColorStop(1, 'rgba(60,141,188,0.0)');

            new Chart(salesCtx, {
                type: 'line',
                data: {
                    labels: {!! json_encode($dates) !!},
                    datasets: [{
                        label: 'Revenue',
                        data: {!! json_encode($salesData) !!},
                        backgroundColor: salesGradient,
                        borderColor: '#3c8dbc',
                        borderWidth: 2,
                        pointRadius: 4,
                        pointBackgroundColor: '#fff',
                        pointBorderColor: '#3c8dbc',
                        pointHoverRadius: 6,
                        pointHoverBackgroundColor: '#3c8dbc',
                        pointHoverBorderColor: '#fff',
                        fill: true,
                        tension: 0.4
                    }]
                },
                options: {
                    maintainAspectRatio: false,
                    responsive: true,
                    plugins: {
                        legend: { display: false },
                        tooltip: {
                            backgroundColor: 'rgba(0,0,0,0.8)',
                            callbacks: {
                                label: function(context) {
                                    return context.dataset.label + ': ' + new Intl.NumberFormat('en-US', { style: 'currency', currency: 'USD' }).format(context.parsed.y);
                                }
                            }
                        }
                    },
                    scales: {
                        x: { grid: { display: false, drawBorder: false }, ticks: { color: '#6c757d' } },
                        y: {
                            grid: { color: '#f4f6f9', borderDash: [5, 5], drawBorder: false },
                            ticks: {
                                color: '#6c757d',
                                callback: function(value) { return '$' + value; }
                            },
                            beginAtZero: true
                        }
                    }
                }
            });

            // Order Status Chart
            const statusCtx = document.getElementById('status-chart').getContext('2d');
            new Chart(statusCtx, {
                type: 'doughnut',
                data: {
                    labels: {!! json_encode(array_map('ucfirst', $allStatuses)) !!},
                    datasets: [{
                        data: {!! json_encode($pieData) !!},
                        backgroundColor: ['#f39c12', '#3c8dbc', '#00c0ef', '#00a65a', '#f56954'],
                        borderWidth: 0
                    }]
                },
                options: {
                    maintainAspectRatio: false,
                    responsive: true,
                    plugins: {
                        legend: { position: 'right' }
                    },
                    cutout: '60%'
                }
            });
        });
    </script>
@endsection