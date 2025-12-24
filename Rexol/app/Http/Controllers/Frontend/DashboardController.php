<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $orders = Auth::user()->orders()->latest()->get();
        // Calculate stats
        $totalOrders = $orders->count();
        $totalSpent = $orders->sum('total_amount');
        $activeOrders = $orders->whereNotIn('status', ['completed', 'cancelled'])->count();

        return view('frontend.dashboard.index', compact('orders', 'totalOrders', 'totalSpent', 'activeOrders'));
    }

    public function orders()
    {
        $orders = Auth::user()->orders()->latest()->paginate(10);
        return view('frontend.dashboard.orders', compact('orders'));
    }
}
