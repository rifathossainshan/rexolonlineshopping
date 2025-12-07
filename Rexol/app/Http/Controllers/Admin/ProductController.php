<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use App\Models\ProductImage;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

use App\Models\Size;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::with('category')->latest()->get();
        return view('admin.products.index', compact('products'));
    }

    public function create()
    {
        $categories = Category::where('status', true)->get();
        $sizes = Size::all();
        // dd($categories, $sizes); // Uncomment to debug
        return view('admin.products.create', compact('categories', 'sizes'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required',
            'category_id' => 'required',
            'price' => 'required|numeric',
            'images.*' => 'image|mimes:jpeg,png,jpg,webp|max:2048',
            'sizes' => 'nullable|array',
            'sizes.*' => 'exists:sizes,id',
        ]);

        $product = Product::create([
            'category_id' => $request->category_id,
            'title' => $request->title,
            'slug' => Str::slug($request->title) . '-' . Str::random(5),
            'price' => $request->price,
            'discount_price' => $request->discount_price,
            'description' => $request->description,
            'stock' => $request->stock ?? 0,
            'status' => $request->has('status'),
            'featured' => $request->has('featured'),
        ]);

        if ($request->has('sizes')) {
            $product->sizes()->sync($request->sizes);
        }

        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                $path = $image->store('products', 'public');
                ProductImage::create([
                    'product_id' => $product->id,
                    'image' => '/storage/' . $path,
                ]);
            }
        }

        return redirect()->route('admin.products.index')->with('success', 'Product created successfully');
    }

    // Edit, Update, Destroy methods
    public function edit(Product $product)
    {
        $categories = Category::where('status', true)->get();
        $sizes = Size::all();
        return view('admin.products.edit', compact('product', 'categories', 'sizes'));
    }

    public function update(Request $request, Product $product)
    {
        $request->validate([
            'title' => 'required',
            'category_id' => 'required',
            'price' => 'required|numeric',
            'images.*' => 'image|mimes:jpeg,png,jpg,webp|max:2048',
            'sizes' => 'nullable|array',
            'sizes.*' => 'exists:sizes,id',
        ]);

        $product->update([
            'category_id' => $request->category_id,
            'title' => $request->title,
            'slug' => Str::slug($request->title) . '-' . Str::random(5),
            'price' => $request->price,
            'discount_price' => $request->discount_price,
            'description' => $request->description,
            'stock' => $request->stock ?? 0,
            'status' => $request->has('status'),
            'featured' => $request->has('featured'),
        ]);

        if ($request->has('sizes')) {
            $product->sizes()->sync($request->sizes);
        } else {
            $product->sizes()->detach();
        }

        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                $path = $image->store('products', 'public');
                ProductImage::create([
                    'product_id' => $product->id,
                    'image' => '/storage/' . $path,
                ]);
            }
        }

        return redirect()->route('admin.products.index')->with('success', 'Product updated successfully');
    }

    public function destroy(Product $product)
    {
        $product->delete();
        return redirect()->route('admin.products.index')->with('success', 'Product deleted successfully');
    }
}
