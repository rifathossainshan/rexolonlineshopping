<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class WishlistController extends Controller
{
    public function index()
    {
        $wishlist = Session::get('wishlist', []);
        return view('frontend.wishlist.index', compact('wishlist'));
    }

    public function add($id)
    {
        $product = Product::findOrFail($id);
        $wishlist = Session::get('wishlist', []);

        if (isset($wishlist[$id])) {
            if (request()->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Product is already in your wishlist!',
                    'count' => count($wishlist),
                    'status' => 'exists'
                ]);
            }
            return redirect()->back()->with('info', 'Product is already in your wishlist!');
        }

        $wishlist[$id] = [
            'name' => $product->title,
            'price' => $product->discount_price && $product->discount_price > 0 ? $product->discount_price : $product->price,
            'original_price' => $product->price,
            'image' => $product->images->first()->image ?? 'https://via.placeholder.com/100',
            'slug' => $product->slug,
            'id' => $product->id,
        ];

        Session::put('wishlist', $wishlist);

        if (request()->ajax()) {
            return response()->json([
                'success' => true,
                'message' => 'Product added to wishlist!',
                'count' => count($wishlist),
                'status' => 'added'
            ]);
        }

        return redirect()->back()->with('success', 'Product added to wishlist!');
    }

    public function remove($id)
    {
        $wishlist = Session::get('wishlist', []);

        if (isset($wishlist[$id])) {
            unset($wishlist[$id]);
            Session::put('wishlist', $wishlist);
        }

        if (request()->ajax()) {
            return response()->json([
                'success' => true,
                'message' => 'Product removed from wishlist!',
                'count' => count($wishlist),
                'status' => 'removed'
            ]);
        }

        return redirect()->back()->with('success', 'Product removed from wishlist!');
    }
}
