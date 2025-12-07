<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        $categories = Category::where('status', true)->get();
        $newArrivals = Product::where('status', true)->latest()->take(8)->get();

        return view('frontend.home', compact('categories', 'newArrivals'));
    }
}
