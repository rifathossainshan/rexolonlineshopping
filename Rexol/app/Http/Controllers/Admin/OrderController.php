<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;

use App\Notifications\OrderStatusUpdated;

class OrderController extends Controller
{
    public function index()
    {
        $orders = Order::latest()->get();
        return view('admin.orders.index', compact('orders'));
    }

    public function show(Order $order)
    {
        return view('admin.orders.show', compact('order'));
    }

    public function updateStatus(Request $request, Order $order)
    {
        $order->update(['status' => $request->status]);

        // Notify the user
        if ($order->user) {
            $order->user->notify(new OrderStatusUpdated($order));
        }

        return redirect()->back()->with('success', 'Order status updated');
    }
}
