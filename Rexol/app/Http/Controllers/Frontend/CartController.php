<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class CartController extends Controller
{
    public function index()
    {
        $cart = Session::get('cart', []);
        return view('frontend.cart.index', compact('cart'));
    }

    public function add(Request $request, $id)
    {
        $product = Product::findOrFail($id);
        $cart = Session::get('cart', []);

        $size = $request->size;
        // Create a unique ID for cart item based on product ID and size
        $cartId = $product->id . '-' . ($size ?? 'default');

        if (isset($cart[$cartId])) {
            $cart[$cartId]['quantity'] += $request->quantity;
        } else {
            $cart[$cartId] = [
                'name' => $product->title,
                'price' => ($product->discount_price && $product->discount_price < $product->price) ? $product->discount_price : $product->price,
                'quantity' => $request->quantity,
                'image' => $product->images->first()->image ?? 'https://via.placeholder.com/100',
                'id' => $product->id,
                'size' => $size,
            ];
        }

        Session::put('cart', $cart);

        if ($request->has('buy_now')) {
            return redirect()->route('checkout.index');
        }

        return redirect()->back()->with('success', 'Product added to cart!');
    }

    public function update(Request $request, $id)
    {
        $cart = Session::get('cart', []);

        if (isset($cart[$id])) {
            $cart[$id]['quantity'] = $request->quantity;
            Session::put('cart', $cart);
        }

        return redirect()->back()->with('success', 'Cart updated!');
    }

    public function remove($id)
    {
        $cart = Session::get('cart', []);

        if (isset($cart[$id])) {
            unset($cart[$id]);
            Session::put('cart', $cart);
        }

        return redirect()->back()->with('success', 'Product removed from cart!');
    }

    public function applyCoupon(Request $request)
    {
        $code = $request->code;
        $coupon = \App\Models\Coupon::where('code', $code)->where('status', true)->first();

        if (!$coupon) {
            return redirect()->back()->with('error', 'Invalid or inactive coupon code.');
        }

        // Calculate total cart value
        $cart = Session::get('cart', []);
        $total = 0;
        foreach ($cart as $details) {
            $total += $details['price'] * $details['quantity'];
        }

        if ($coupon->min_amount && $total < $coupon->min_amount) {
            return redirect()->back()->with('error', 'Minimum order amount for this coupon is ' . $coupon->min_amount);
        }

        Session::put('coupon', [
            'code' => $coupon->code,
            'type' => $coupon->discount_type,
            'value' => $coupon->discount_value,
        ]);

        return redirect()->back()->with('success', 'Coupon applied successfully!');
    }

    public function removeCoupon()
    {
        Session::forget('coupon');
        return redirect()->back()->with('success', 'Coupon removed successfully!');
    }
}
