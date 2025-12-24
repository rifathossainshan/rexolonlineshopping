@extends('layouts.frontend')

@section('content')
    <div class="bg-gray-50 min-h-screen py-10">
        <div class="container mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Dashboard Header -->
            <div class="mb-10 flex flex-col md:flex-row md:items-center md:justify-between gap-4">
                <div>
                    <h1 class="text-3xl font-extrabold text-gray-900 tracking-tight">My Account</h1>
                    <p class="mt-2 text-sm text-gray-500">Manage your orders and account details.</p>
                </div>
                <div class="flex gap-3">
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit"
                            class="inline-flex items-center px-4 py-2 border border-gray-300 shadow-sm text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition">
                            Sign Out
                        </button>
                    </form>
                </div>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-4 gap-8">
                <!-- Sidebar Navigation -->
                <div class="lg:col-span-1">
                    <nav class="space-y-1">
                        <a href="{{ route('dashboard') }}"
                            class="bg-indigo-50 border-indigo-600 text-indigo-700 group border-l-4 px-3 py-2 flex items-center text-sm font-medium"
                            aria-current="page">
                            <svg class="text-indigo-500 flex-shrink-0 -ml-1 mr-3 h-6 w-6" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                            </svg>
                            <span class="truncate">Overview</span>
                        </a>

                        <a href="{{ route('dashboard.orders') }}"
                            class="border-transparent text-gray-900 hover:bg-gray-50 hover:text-gray-900 group border-l-4 px-3 py-2 flex items-center text-sm font-medium">
                            <svg class="text-gray-400 group-hover:text-gray-500 flex-shrink-0 -ml-1 mr-3 h-6 w-6"
                                fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
                            </svg>
                            <span class="truncate">My Orders</span>
                        </a>

                        <a href="{{ route('profile.edit') }}"
                            class="border-transparent text-gray-900 hover:bg-gray-50 hover:text-gray-900 group border-l-4 px-3 py-2 flex items-center text-sm font-medium">
                            <svg class="text-gray-400 group-hover:text-gray-500 flex-shrink-0 -ml-1 mr-3 h-6 w-6"
                                fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                            </svg>
                            <span class="truncate">Profile Settings</span>
                        </a>
                    </nav>
                </div>

                <!-- Main Content Area -->
                <div class="lg:col-span-3 space-y-6">
                    <!-- Stats Cards -->
                    <div class="grid grid-cols-1 gap-5 sm:grid-cols-3">
                        <div class="bg-white overflow-hidden shadow rounded-lg">
                            <div class="p-5">
                                <div class="flex items-center">
                                    <div class="flex-shrink-0">
                                        <svg class="h-6 w-6 text-gray-400" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10">
                                            </path>
                                        </svg>
                                    </div>
                                    <div class="ml-5 w-0 flex-1">
                                        <dl>
                                            <dt class="text-sm font-medium text-gray-500 truncate">Total Orders</dt>
                                            <dd class="text-lg font-medium text-gray-900">{{ $totalOrders }}</dd>
                                        </dl>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="bg-white overflow-hidden shadow rounded-lg">
                            <div class="p-5">
                                <div class="flex items-center">
                                    <div class="flex-shrink-0">
                                        <svg class="h-6 w-6 text-gray-400" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z">
                                            </path>
                                        </svg>
                                    </div>
                                    <div class="ml-5 w-0 flex-1">
                                        <dl>
                                            <dt class="text-sm font-medium text-gray-500 truncate">Total Spent</dt>
                                            <dd class="text-lg font-medium text-gray-900">
                                                ৳{{ number_format($totalSpent, 2) }}</dd>
                                        </dl>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="bg-white overflow-hidden shadow rounded-lg">
                            <div class="p-5">
                                <div class="flex items-center">
                                    <div class="flex-shrink-0">
                                        <svg class="h-6 w-6 text-gray-400" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                        </svg>
                                    </div>
                                    <div class="ml-5 w-0 flex-1">
                                        <dl>
                                            <dt class="text-sm font-medium text-gray-500 truncate">Active Orders</dt>
                                            <dd class="text-lg font-medium text-gray-900">{{ $activeOrders }}</dd>
                                        </dl>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Recent Activity -->
                    <div class="bg-white shadow rounded-lg overflow-hidden">
                        <div
                            class="px-4 py-5 sm:px-6 flex justify-between items-center bg-gray-50 border-b border-gray-100">
                            <h3 class="text-lg leading-6 font-medium text-gray-900">Recent Orders</h3>
                            <a href="{{ route('dashboard.orders') }}"
                                class="text-sm font-medium text-indigo-600 hover:text-indigo-500">View all</a>
                        </div>
                        @if($orders->count() > 0)
                            <ul class="divide-y divide-gray-200">
                                @foreach($orders->take(5) as $order)
                                    <li class="p-4 hover:bg-gray-50 transition">
                                        <div class="flex items-center space-x-4">
                                            <div class="flex-shrink-0">
                                                <span
                                                    class="inline-flex items-center justify-center h-10 w-10 rounded-full bg-indigo-100">
                                                    <span class="text-indigo-600 font-medium leading-none">#{{ $order->id }}</span>
                                                </span>
                                            </div>
                                            <div class="flex-1 min-w-0">
                                                <p class="text-sm font-medium text-gray-900 truncate">
                                                    Order #{{ $order->id }}
                                                </p>
                                                <p class="text-sm text-gray-500 truncate">
                                                    Placed on {{ $order->created_at->format('M d, Y') }}
                                                </p>
                                            </div>
                                            <div class="inline-flex items-center text-sm font-semibold text-gray-900">
                                                ৳{{ number_format($order->total_amount, 2) }}
                                            </div>
                                            <div>
                                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                                    {{ $order->status == 'completed' ? 'bg-green-100 text-green-800' : '' }}
                                                    {{ $order->status == 'pending' ? 'bg-yellow-100 text-yellow-800' : '' }}
                                                    {{ $order->status == 'processing' ? 'bg-blue-100 text-blue-800' : '' }}
                                                    {{ $order->status == 'cancelled' ? 'bg-red-100 text-red-800' : '' }}">
                                                    {{ ucfirst($order->status) }}
                                                </span>
                                            </div>
                                        </div>
                                    </li>
                                @endforeach
                            </ul>
                        @else
                            <div class="p-8 text-center text-gray-500">
                                No recent orders found.
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection