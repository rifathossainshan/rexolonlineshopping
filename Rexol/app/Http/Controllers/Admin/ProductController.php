<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use App\Models\ProductImage;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

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
        return view('admin.products.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required',
            'category_id' => 'required',
            'price' => 'required|numeric',
            'image' => 'required|image',
        ]);

        $product = Product::create([
            'category_id' => $request->category_id,
            'title' => $request->title,
            'slug' => Str::slug($request->title) . '-' . Str::random(5),
            'price' => $request->price,
            'discount_price' => $request->discount_price,
            'stock' => $request->stock ?? 0,
            'status' => $request->has('status'),
        ]);

        if ($request->sizes) {
            $sizeNames = explode(',', $request->sizes);
            $sizeIds = [];
            foreach ($sizeNames as $name) {
                $name = trim($name);
                $size = \App\Models\Size::firstOrCreate(
                    ['name' => $name],
                    ['slug' => \Illuminate\Support\Str::slug($name)]
                );
                $sizeIds[] = $size->id;
            }
            $product->sizes()->sync($sizeIds);
        }

        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('products', 'public');
            ProductImage::create([
                'product_id' => $product->id,
                'image' => '/storage/' . $path,
            ]);
        }

        return redirect()->route('admin.products.index')->with('success', 'Product created successfully');
    }

    // Edit, Update, Destroy methods
    public function edit(Product $product)
    {
        $categories = Category::where('status', true)->get();
        return view('admin.products.edit', compact('product', 'categories'));
    }

    public function update(Request $request, Product $product)
    {
        $request->validate([
            'title' => 'required',
            'category_id' => 'required',
            'price' => 'required|numeric',
        ]);

        $product->update([
            'category_id' => $request->category_id,
            'title' => $request->title,
            'slug' => Str::slug($request->title) . '-' . Str::random(5),
            'price' => $request->price,
            'discount_price' => $request->discount_price,
            'stock' => $request->stock ?? 0,
            'status' => $request->has('status'),
        ]);

        if ($request->sizes) {
            $sizeNames = explode(',', $request->sizes);
            $sizeIds = [];
            foreach ($sizeNames as $name) {
                $name = trim($name);
                $size = \App\Models\Size::firstOrCreate(
                    ['name' => $name],
                    ['slug' => \Illuminate\Support\Str::slug($name)]
                );
                $sizeIds[] = $size->id;
            }
            $product->sizes()->sync($sizeIds);
        } else {
            $product->sizes()->detach();
        }

        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('products', 'public');
            // Remove old image logic could be here
            ProductImage::create([
                'product_id' => $product->id,
                'image' => '/storage/' . $path,
            ]);
        }

        return redirect()->route('admin.products.index')->with('success', 'Product updated successfully');
    }

    public function destroy(Product $product)
    {
        $product->delete();
        return redirect()->route('admin.products.index')->with('success', 'Product deleted successfully');
    }
}
