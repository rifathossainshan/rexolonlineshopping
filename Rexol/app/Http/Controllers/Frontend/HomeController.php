<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use App\Models\OrderItem;
use App\Models\HeroSlide;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        // Categories for Filter Sidebar
        $categories = Category::where('status', true)->get();

        // Separate Gender Categories for "Shop By Gender" section
        $genderNames = ['Men', 'Women', 'Boys', 'Girls', 'Kids', 'Unisex'];
        $genderCategories = $categories->whereIn('name', $genderNames);

        // Brand Categories (if needed for ticker)
        $brandCategories = $categories->whereNotIn('name', $genderNames);

        // Shop All Products (simulating the main grid)
        $shopAllProducts = Product::where('status', true)->inRandomOrder()->take(12)->get();

        // Fresh Drops
        $newArrivals = Product::where('status', true)->latest()->take(4)->get();

        // Active Hero Slides
        $heroSlides = HeroSlide::where('status', true)->latest()->get();

        return view('frontend.home', compact('categories', 'genderCategories', 'brandCategories', 'shopAllProducts', 'newArrivals', 'heroSlides'));
    }
}
