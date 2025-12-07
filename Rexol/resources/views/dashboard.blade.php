<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('My Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h3 class="text-lg font-bold mb-4">My Orders</h3>

                    @if($orders->count() > 0)
                        <div class="overflow-x-auto">
                            <table class="min-w-full table-auto">
                                <thead class="bg-gray-100">
                                    <tr>
                                        <th class="px-4 py-2 text-left">Order ID</th>
                                        <th class="px-4 py-2 text-left">Date</th>
                                        <th class="px-4 py-2 text-left">Total Amount</th>
                                        <th class="px-4 py-2 text-left">Status</th>
                                        <th class="px-4 py-2 text-left">Items</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($orders as $order)
                                        <tr class="border-b">
                                            <td class="px-4 py-2">#{{ $order->id }}</td>
                                            <td class="px-4 py-2">{{ $order->created_at->format('d M Y') }}</td>
                                            <td class="px-4 py-2">৳{{ $order->total_amount }}</td>
                                            <td class="px-4 py-2">
                                                <span
                                                    class="px-2 py-1 rounded text-white {{ $order->status == 'completed' ? 'bg-green-500' : 'bg-yellow-500' }}">
                                                    {{ ucfirst($order->status) }}
                                                </span>
                                            </td>
                                            <td class="px-4 py-2">
                                                {{ $order->items->count() }} items
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <p>No orders found.</p>
                        <a href="{{ route('products.index') }}" class="text-blue-500 hover:underline">Start Shopping</a>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>