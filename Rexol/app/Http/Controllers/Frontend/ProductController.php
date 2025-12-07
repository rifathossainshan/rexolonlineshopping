<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;

use App\Services\ProductService;

class ProductController extends Controller
{
    protected $productService;

    public function __construct(ProductService $productService)
    {
        $this->productService = $productService;
    }

    public function index(Request $request)
    {
        $filters = $request->all();
        $products = $this->productService->filterProducts($filters);
        $categories = Category::where('status', true)->get();

        return view('frontend.products.index', compact('products', 'categories'));
    }

    public function show($slug)
    {
        $product = $this->productService->getProductBySlug($slug);
        return view('frontend.products.show', compact('product'));
    }
}
