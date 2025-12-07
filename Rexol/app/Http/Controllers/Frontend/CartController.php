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
                'price' => $product->price,
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
}
