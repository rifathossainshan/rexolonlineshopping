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
            <div
                class="relative overflow-hidden bg-gradient-to-r from-purple-600 via-blue-600 to-indigo-700 rounded-2xl shadow-xl">
                <div class="absolute inset-0 bg-white/10 opacity-30 pattern-grid-lg"></div>
                <div class="relative p-8 md:p-12 text-white">
                    <h1 class="text-3xl md:text-4xl font-extrabold tracking-tight mb-2">
                        Welcome back, {{ $user->name }}!
                    </h1>
                    <p class="text-blue-100 text-lg md:w-2/3">
                        Track your orders, manage your account, and discover new favorites all in one place.
                    </p>
                    <div class="mt-8 flex gap-4">
                        <a href="{{ route('products.index') }}"
                            class="px-6 py-3 bg-white text-indigo-600 font-bold rounded-full shadow-lg hover:bg-gray-50 hover:scale-105 transition transform duration-200">
                            Start Shopping
                        </a>
                        <a href="{{ route('profile.edit') }}"
                            class="px-6 py-3 bg-indigo-800/50 text-white font-medium rounded-full hover:bg-indigo-800/70 backdrop-blur-sm transition duration-200">
                            Edit Profile
                        </a>
                    </div>
                </div>
                <!-- Decorative Circle -->
                <div class="absolute -bottom-24 -right-24 w-64 h-64 bg-white/10 rounded-full blur-3xl"></div>
            </div>

            <!-- Stats Grid -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <!-- Total Orders -->
                <div
                    class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 flex flex-col items-center justify-center text-center hover:shadow-lg transition-shadow duration-300 relative overflow-hidden group">
                    <div
                        class="absolute inset-0 bg-blue-50 opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                    </div>
                    <div
                        class="relative z-10 p-4 bg-blue-100 text-blue-600 rounded-full mb-3 group-hover:scale-110 transition-transform duration-300">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10">
                            </path>
                        </svg>
                    </div>
                    <h3 class="relative z-10 text-gray-500 font-medium">Total Orders</h3>
                    <p class="relative z-10 text-3xl font-bold text-gray-800 mt-1">{{ $totalOrders }}</p>
                </div>

                <!-- Total Spent -->
                <div
                    class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 flex flex-col items-center justify-center text-center hover:shadow-lg transition-shadow duration-300 relative overflow-hidden group">
                    <div
                        class="absolute inset-0 bg-green-50 opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                    </div>
                    <div
                        class="relative z-10 p-4 bg-green-100 text-green-600 rounded-full mb-3 group-hover:scale-110 transition-transform duration-300">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z">
                            </path>
                        </svg>
                    </div>
                    <h3 class="relative z-10 text-gray-500 font-medium">Total Spent</h3>
                    <p class="relative z-10 text-3xl font-bold text-gray-800 mt-1">৳{{ number_format($totalSpent, 2) }}
                    </p>
                </div>

                <!-- Active Orders -->
                <div
                    class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 flex flex-col items-center justify-center text-center hover:shadow-lg transition-shadow duration-300 relative overflow-hidden group">
                    <div
                        class="absolute inset-0 bg-orange-50 opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                    </div>
                    <div
                        class="relative z-10 p-4 bg-orange-100 text-orange-600 rounded-full mb-3 group-hover:scale-110 transition-transform duration-300">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                    <h3 class="relative z-10 text-gray-500 font-medium">Active Orders</h3>
                    <p class="relative z-10 text-3xl font-bold text-gray-800 mt-1">{{ $activeOrders }}</p>
                </div>
            </div>

            <!-- Recent Orders Section -->
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
                <div class="p-6 border-b border-gray-100 flex flex-col md:flex-row justify-between items-center gap-4">
                    <h3 class="text-xl font-bold text-gray-800 flex items-center gap-2">
                        <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01">
                            </path>
                        </svg>
                        Order History
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
                                                                                            stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z">
                                                                                        </path>
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
                                                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
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
                                <svg class="w-12 h-12 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10">
                                    </path>
                                </svg>
                            </div>
                            <h3 class="text-lg font-medium text-gray-900 mb-1">No orders placed yet</h3>
                            <p class="text-gray-500 max-w-sm mb-8">It looks like you haven't made any purchases yet. Explore
                                our collection and find something you love!</p>
                            <a href="{{ route('products.index') }}"
                                class="inline-flex items-center justify-center px-6 py-3 border border-transparent text-base font-medium rounded-full text-indigo-700 bg-indigo-100 hover:bg-indigo-200 transition duration-150 ease-in-out">
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
    </div>
</x-app-layout>