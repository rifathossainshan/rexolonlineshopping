<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Order;
use App\Models\Product;
use App\Models\User;

class AdminController extends Controller
{
    public function dashboard()
    {
        $totalOrders = Order::count();
        $totalProducts = Product::count();
        $totalUsers = User::where('role', 'user')->count();
        $pendingOrders = Order::where('status', 'pending')->count();

        return view('admin.dashboard', compact('totalOrders', 'totalProducts', 'totalUsers', 'pendingOrders'));
    }
}
