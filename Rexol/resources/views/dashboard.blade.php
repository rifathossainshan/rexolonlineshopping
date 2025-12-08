<x-app-layout>
    @php
        $totalOrders = $orders->count();
        $totalSpent = $orders->sum('total_amount');
        $activeOrders = $orders->whereNotIn('status', ['completed', 'cancelled'])->count();
        $user = Auth::user();
    @endphp

    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12 bg-gray-50 min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-8">

            <!-- Welcome Banner -->
            <!-- Welcome Banner -->
            <div class="relative overflow-hidden bg-indigo-600 rounded-2xl shadow-xl">
                <div class="absolute inset-0 bg-gradient-to-r from-indigo-600 to-purple-600"
                    style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);"></div>
                <div class="absolute inset-0 bg-white opacity-10"
                    style="background-image: radial-gradient(#ffffff 1px, transparent 1px); background-size: 20px 20px;">
                </div>
                <div class="relative p-8 md:p-12 text-white">
                    <h1 class="text-3xl md:text-4xl font-extrabold tracking-tight mb-2">
                        Welcome back, {{ $user->name }}!
                    </h1>
                    <p class="text-indigo-100 text-lg md:w-2/3">
                        Track your orders, manage your account details, and explore our latest collections.
                    </p>
                    <div class="mt-8 flex flex-wrap gap-4">
                        <a href="{{ route('products.index') }}"
                            class="px-6 py-3 bg-white text-indigo-700 font-bold rounded-full shadow-lg hover:bg-gray-50 hover:scale-105 transition transform duration-200 inline-flex items-center">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path>
                            </svg>
                            Start Shopping
                        </a>
                        <a href="{{ route('profile.edit') }}"
                            class="px-6 py-3 bg-indigo-800 text-white font-medium rounded-full hover:bg-indigo-900 transition duration-200 border border-indigo-400 inline-flex items-center">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                            </svg>
                            Edit Profile
                        </a>
                    </div>
                </div>
                <!-- Decorative Elements -->
                <div class="absolute -bottom-24 -right-24 w-64 h-64 bg-white opacity-10 rounded-full blur-3xl"></div>
                <div class="absolute -top-24 -left-24 w-64 h-64 bg-purple-500 opacity-20 rounded-full blur-3xl"></div>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                <!-- Stats Column (Span 2) -->
                <div class="lg:col-span-2 space-y-8">
                    <!-- Stats Grid -->
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                        <!-- Total Orders -->
                        <div
                            class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 flex flex-col items-center justify-center text-center hover:shadow-lg transition-shadow duration-300 relative overflow-hidden group">
                            <div
                                class="relative z-10 p-4 bg-blue-100 text-blue-600 rounded-full mb-3 group-hover:scale-110 transition-transform duration-300">
                                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10">
                                    </path>
                                </svg>
                            </div>
                            <h3 class="text-gray-500 font-medium">Total Orders</h3>
                            <p class="text-3xl font-bold text-gray-800 mt-1">{{ $totalOrders }}</p>
                        </div>

                        <!-- Total Spent -->
                        <div
                            class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 flex flex-col items-center justify-center text-center hover:shadow-lg transition-shadow duration-300 relative overflow-hidden group">
                            <div
                                class="relative z-10 p-4 bg-green-100 text-green-600 rounded-full mb-3 group-hover:scale-110 transition-transform duration-300">
                                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z">
                                    </path>
                                </svg>
                            </div>
                            <h3 class="text-gray-500 font-medium">Total Spent</h3>
                            <p class="text-3xl font-bold text-gray-800 mt-1">৳{{ number_format($totalSpent, 2) }}</p>
                        </div>

                        <!-- Active Orders -->
                        <div
                            class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 flex flex-col items-center justify-center text-center hover:shadow-lg transition-shadow duration-300 relative overflow-hidden group">
                            <div
                                class="relative z-10 p-4 bg-orange-100 text-orange-600 rounded-full mb-3 group-hover:scale-110 transition-transform duration-300">
                                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                            </div>
                            <h3 class="text-gray-500 font-medium">Active Orders</h3>
                            <p class="text-3xl font-bold text-gray-800 mt-1">{{ $activeOrders }}</p>
                        </div>
                    </div>

                    <!-- Recent Orders Section -->
                    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
                        <div
                            class="p-6 border-b border-gray-100 flex flex-col md:flex-row justify-between items-center gap-4">
                            <h3 class="text-xl font-bold text-gray-800 flex items-center gap-2">
                                <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01">
                                    </path>
                                </svg>
                                Recent Orders
                            </h3>
                            @if($orders->count() > 0)
                                <a href="{{ route('products.index') }}"
                                    class="text-sm font-semibold text-indigo-600 hover:text-indigo-800 transition">
                                    Browse Products &rarr;
                                </a>
                            @endif
                        </div>

                        <div class="bg-white">
                            @if($orders->count() > 0)
                                <div class="overflow-x-auto">
                                    <table class="min-w-full divide-y divide-gray-100">
                                        <thead class="bg-gray-50/50">
                                            <tr>
                                                <th
                                                    class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">
                                                    Order</th>
                                                <th
                                                    class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">
                                                    Date</th>
                                                <th
                                                    class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">
                                                    Total</th>
                                                <th
                                                    class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">
                                                    Status</th>
                                                <th
                                                    class="px-6 py-4 text-right text-xs font-semibold text-gray-500 uppercase tracking-wider">
                                                    Action</th>
                                            </tr>
                                        </thead>
                                        <tbody class="divide-y divide-gray-100">
                                            @foreach($orders as $order)
                                                <tr class="hover:bg-gray-50/80 transition duration-150 group">
                                                    <td class="px-6 py-4 whitespace-nowrap">
                                                        <div class="flex items-center">
                                                            <div
                                                                class="p-2 bg-indigo-50 text-indigo-600 rounded-lg mr-3 group-hover:bg-indigo-100 transition">
                                                                <svg class="w-4 h-4" fill="none" stroke="currentColor"
                                                                    viewBox="0 0 24 24">
                                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                                        stroke-width="2"
                                                                        d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path>
                                                                </svg>
                                                            </div>
                                                            <span class="font-bold text-gray-900">#{{ $order->id }}</span>
                                                        </div>
                                                    </td>
                                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                                        {{ $order->created_at->format('M d, Y') }}
                                                        <span
                                                            class="block text-xs text-gray-400">{{ $order->created_at->format('h:i A') }}</span>
                                                    </td>
                                                    <td class="px-6 py-4 whitespace-nowrap">
                                                        <span
                                                            class="text-sm font-bold text-gray-900">৳{{ number_format($order->total_amount, 2) }}</span>
                                                    </td>
                                                    <td class="px-6 py-4 whitespace-nowrap">
                                                        @php
                                                            $statusClasses = [
                                                                'completed' => 'bg-emerald-100 text-emerald-700 border-emerald-200',
                                                                'pending' => 'bg-amber-100 text-amber-700 border-amber-200',
                                                                'processing' => 'bg-sky-100 text-sky-700 border-sky-200',
                                                                'cancelled' => 'bg-rose-100 text-rose-700 border-rose-200',
                                                            ];
                                                            $statusClass = $statusClasses[$order->status] ?? 'bg-gray-100 text-gray-700 border-gray-200';
                                                        @endphp
                                                        <span
                                                            class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full border {{ $statusClass }}">
                                                            {{ ucfirst($order->status) }}
                                                        </span>
                                                    </td>
                                                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                                        <a href="{{ route('invoice.download', $order->id) }}"
                                                            class="text-gray-400 hover:text-indigo-600 transition-colors inline-flex items-center gap-1">
                                                            <svg class="w-4 h-4" fill="none" stroke="currentColor"
                                                                viewBox="0 0 24 24">
                                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                                    stroke-width="2"
                                                                    d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4">
                                                                </path>
                                                            </svg>
                                                            Download
                                                        </a>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            @else
                                <!-- Empty State -->
                                <div class="flex flex-col items-center justify-center py-16 px-4 text-center">
                                    <div class="bg-gray-50 p-4 rounded-full mb-4">
                                        <svg class="w-12 h-12 text-gray-300" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10">
                                            </path>
                                        </svg>
                                    </div>
                                    <h3 class="text-lg font-medium text-gray-900 mb-1">No orders placed yet</h3>
                                    <p class="text-gray-500 max-w-sm mb-8">It looks like you haven't made any purchases yet.
                                        Explore our collection and find something you love!</p>
                                    <a href="{{ route('products.index') }}"
                                        class="inline-flex items-center justify-center px-6 py-3 border border-transparent text-base font-medium rounded-full text-white shadow-md hover:scale-105 transition-transform duration-200"
                                        style="background: linear-gradient(90deg, #4f46e5 0%, #7c3aed 100%);">
                                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                                        </svg>
                                        Start Shopping
                                    </a>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- Sidebar Column (Span 1) -->
                <div class="space-y-6">
                    <!-- Account Details Card -->
                    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
                        <div class="flex items-center justify-between mb-4">
                            <h3 class="text-lg font-bold text-gray-800">Account Details</h3>
                            <a href="{{ route('profile.edit') }}"
                                class="text-sm text-indigo-600 hover:text-indigo-800">Edit</a>
                        </div>
                        <div class="space-y-4">
                            <div class="flex items-start">
                                <div class="flex-shrink-0 mt-1">
                                    <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z">
                                        </path>
                                    </svg>
                                </div>
                                <div class="ml-3">
                                    <p class="text-sm font-medium text-gray-900">{{ $user->name }}</p>
                                    <p class="text-xs text-gray-500">Full Name</p>
                                </div>
                            </div>
                            <div class="flex items-start">
                                <div class="flex-shrink-0 mt-1">
                                    <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z">
                                        </path>
                                    </svg>
                                </div>
                                <div class="ml-3">
                                    <p class="text-sm font-medium text-gray-900">{{ $user->email }}</p>
                                    <p class="text-xs text-gray-500">Email Address</p>
                                </div>
                            </div>
                            @if($user->phone)
                                <div class="flex items-start">
                                    <div class="flex-shrink-0 mt-1">
                                        <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z">
                                            </path>
                                        </svg>
                                    </div>
                                    <div class="ml-3">
                                        <p class="text-sm font-medium text-gray-900">{{ $user->phone }}</p>
                                        <p class="text-xs text-gray-500">Phone Number</p>
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>

                    <!-- Address Placeholder Card -->
                    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
                        <div class="flex items-center justify-between mb-4">
                            <h3 class="text-lg font-bold text-gray-800">Shipping Address</h3>
                            <!-- <a href="#" class="text-sm text-indigo-600 hover:text-indigo-800">Manage</a> -->
                        </div>
                        <div class="bg-gray-50 rounded-lg p-4 text-center border border-dashed border-gray-300">
                            <svg class="w-8 h-8 text-gray-400 mx-auto mb-2" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z">
                                </path>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                            </svg>
                            <p class="text-sm text-gray-500 mb-3">You haven't added a default shipping address yet.</p>
                            <button
                                class="text-xs font-semibold text-indigo-600 hover:text-indigo-800 bg-white border border-indigo-200 px-3 py-1.5 rounded-md hover:bg-indigo-50 transition">
                                + Add Address
                            </button>
                        </div>
                    </div>

                    <!-- Quick Support -->
                    <div class="bg-indigo-900 rounded-2xl p-6 text-white relative overflow-hidden">
                        <div
                            class="absolute top-0 right-0 -mr-4 -mt-4 w-24 h-24 bg-indigo-700 rounded-full opacity-50 blur-xl">
                        </div>
                        <h3 class="text-lg font-bold relative z-10">Need Help?</h3>
                        <p class="text-indigo-200 text-sm mt-1 relative z-10 mb-4">Have questions about your order?</p>
                        <a href="mailto:support@rexol.com"
                            class="inline-flex items-center justify-center w-full px-4 py-2 bg-white text-indigo-900 text-sm font-bold rounded-lg hover:bg-indigo-50 transition relative z-10">
                            Contact Support
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>