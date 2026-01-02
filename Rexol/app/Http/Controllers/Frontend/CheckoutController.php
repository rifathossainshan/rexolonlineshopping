<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class CheckoutController extends Controller
{
    protected $paymentGateway;

    public function __construct(\App\Services\Payment\PaymentGatewayInterface $paymentGateway)
    {
        $this->paymentGateway = $paymentGateway;
    }
    public function index()
    {
        $cart = Session::get('cart', []);
        if (count($cart) == 0) {
            return redirect()->route('products.index');
        }
        return view('frontend.checkout.index', compact('cart'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'phone' => 'required',
            'address' => 'required',
            'payment_method' => 'required',
            'stripeToken' => 'required_if:payment_method,stripe',
        ]);

        $cart = Session::get('cart', []);
        $totalAmount = 0;
        foreach ($cart as $details) {
            $totalAmount += $details['price'] * $details['quantity'];
        }

        // Apply Coupon Discount
        if (Session::has('coupon')) {
            $coupon = Session::get('coupon');
            if ($coupon['type'] == 'fixed') {
                $totalAmount -= $coupon['value'];
            } else {
                $totalAmount -= ($totalAmount * $coupon['value']) / 100;
            }
        }
        $totalAmount = max(0, $totalAmount);

        // 1. Validate Stock
        foreach ($cart as $details) {
            $product = \App\Models\Product::find($details['id']);
            if (!$product || !$product->hasStock($details['quantity'])) {
                return redirect()->back()->with('error', "Product {$details['name']} is out of stock or requested quantity unavailable.");
            }
        }

        // 2. Process Payment
        if ($request->payment_method === 'stripe') {
            try {
                $charge = $this->paymentGateway->charge($totalAmount, [
                    'source' => $request->stripeToken,
                    'description' => "Order from " . $request->name,
                    'currency' => 'usd', // Should be dynamic
                ]);
                // Payment Successful
            } catch (\Exception $e) {
                return redirect()->back()->with('error', $e->getMessage());
            }
        }

        $order = Order::create([
            'user_id' => Auth::id(), // Nullable allowed in schema
            'name' => $request->name,
            'phone' => $request->phone,
            'address' => $request->address,
            'total_amount' => $totalAmount,
            'payment_method' => $request->payment_method,
            'status' => ($request->payment_method === 'stripe') ? 'processing' : 'pending',
        ]);

        foreach ($cart as $cartKey => $details) {
            OrderItem::create([
                'order_id' => $order->id,
                'product_id' => $details['id'], // Use the stored ID, not the key
                'price' => $details['price'],
                'quantity' => $details['quantity'],
                'size' => $details['size'] ?? null,
            ]);

            // 3. Decrement Stock
            $product = \App\Models\Product::find($details['id']);
            if ($product) {
                $product->decrementStock($details['quantity']);
            }
        }

        Session::forget('cart');
        Session::forget('coupon');

        return redirect()->route('checkout.pending', $order->id)->with('success', 'Order placed successfully! Order ID: ' . $order->id);
    }

    public function pending(Order $order)
    {
        // Security check: ensure user owns order or is admin? (Simplifying for now, assuming public link or logged in)
        if (Auth::check() && $order->user_id !== Auth::id()) {
            // Optional: Handle unauthorized access check
            // return redirect()->route('home');
        }

        return view('frontend.checkout.pending', compact('order'));
    }

    public function downloadInvoice(Order $order)
    {
        $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('invoices.order', compact('order'));
        return $pdf->download('invoice-' . $order->id . '.pdf');
    }
}
