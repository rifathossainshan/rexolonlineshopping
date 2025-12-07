<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Order;
use App\Models\Product;
use App\Models\User;

use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class AdminController extends Controller
{
    public function dashboard()
    {
        // 1. Key Metrics
        $totalOrders = Order::count();
        $totalProducts = Product::count();
        $totalUsers = User::where('role', 'user')->count();

        // Revenue: Sum of total_amount where status is not 'cancelled' (adjust status logic as needed)
        // Assuming 'delivered' or 'processing' implies money in. For simplicity, any non-cancelled.
        $totalRevenue = Order::where('status', '!=', 'cancelled')->sum('total_amount');

        $pendingOrders = Order::where('status', 'pending')->count();

        // Low Stock: Products with stock below 5
        $lowStockCount = Product::where('stock', '<', 5)->count();

        // 2. Recent Activity
        $recentOrders = Order::with('user')->latest()->take(5)->get();
        $recentUsers = User::where('role', 'user')->latest()->take(5)->get();

        // 3. Chart Data (Last 7 Days Sales)
        $dates = collect();
        $salesData = collect();

        for ($i = 6; $i >= 0; $i--) {
            $date = Carbon::now()->subDays($i);
            $dates->push($date->format('M d'));

            $daySales = Order::whereDate('created_at', $date->format('Y-m-d'))
                ->where('status', '!=', 'cancelled')
                ->sum('total_amount');
            $salesData->push($daySales);
        }

        // 4. Top Selling Products (Top 5)
        // Group order_items by product_id, sum quantity
        $topProducts = \App\Models\OrderItem::select('product_id', DB::raw('sum(quantity) as total_sold'))
            ->groupBy('product_id')
            ->orderByDesc('total_sold')
            ->with([
                'product' => function ($q) {
                    // Ensure we get images too if needed for display
                    $q->with('images');
                }
            ])
            ->take(5)
            ->get()
            ->map(function ($item) {
                if ($item->product) {
                    $item->product->total_sold = $item->total_sold;
                    return $item->product;
                }
                return null;
            })
            ->filter();

        // 5. Order Status Distribution
        $statusCounts = Order::select('status', DB::raw('count(*) as count'))
            ->groupBy('status')
            ->pluck('count', 'status');

        // Ensure all statuses have a value for the chart
        $allStatuses = ['pending', 'processing', 'shipped', 'completed', 'cancelled'];
        $pieData = [];
        foreach ($allStatuses as $status) {
            $pieData[] = $statusCounts->get($status, 0);
        }

        return view('admin.dashboard', compact(
            'totalOrders',
            'totalProducts',
            'totalUsers',
            'totalRevenue',
            'pendingOrders',
            'lowStockCount',
            'recentOrders',
            'recentUsers',
            'dates',
            'salesData',
            'topProducts',
            'pieData',
            'allStatuses'
        ));
    }
}
