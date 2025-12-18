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
        // Separate categories for Gender and Brands (Mocking separation by name for now as we don't have a 'type' column)
        $allCategories = Category::where('status', true)->get();

        $genderNames = ['Men', 'Women', 'Boys', 'Girls', 'Kids', 'Unisex'];
        $genderCategories = $allCategories->whereIn('name', $genderNames);
        $brandCategories = $allCategories->whereNotIn('name', $genderNames);

        $newArrivals = Product::where('status', true)->latest()->take(8)->get();

        $bestSellers = \App\Models\OrderItem::select('product_id', \Illuminate\Support\Facades\DB::raw('SUM(quantity) as total_qty'))
            ->groupBy('product_id')
            ->orderByDesc('total_qty')
            ->take(8)
            ->with('product')
            ->get()
            ->pluck('product')
            ->filter(); // remove any nulls if product was deleted

        // Active Hero Slides
        $heroSlides = HeroSlide::where('status', true)->latest()->get();

        return view('frontend.home', compact('genderCategories', 'brandCategories', 'newArrivals', 'bestSellers', 'heroSlides'));
    }
}
