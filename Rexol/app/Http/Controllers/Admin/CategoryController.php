<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class CategoryController extends Controller
{
    public function index()
    {
        $type = request('type', 'standard');
        $categories = Category::where('type', $type)->latest()->get();
        return view('admin.categories.index', compact('categories', 'type'));
    }

    public function create()
    {
        $type = request('type', 'standard');
        return view('admin.categories.create', compact('type'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|unique:categories',
            'type' => 'required|in:standard,gender',
            'slug' => 'nullable|unique:categories,slug',
        ]);

        Category::create([
            'name' => $request->name,
            'slug' => $request->slug ? Str::slug($request->slug) : Str::slug($request->name),
            'status' => $request->has('status'),
            'type' => $request->type,
        ]);

        return redirect()->route('admin.categories.index', ['type' => $request->type])
            ->with('success', ucfirst($request->type) . ' created successfully');
    }

    public function edit(Category $category)
    {
        return view('admin.categories.edit', compact('category'));
    }

    public function update(Request $request, Category $category)
    {
        $request->validate([
            'name' => 'required|unique:categories,name,' . $category->id,
            'type' => 'required|in:standard,gender',
            'slug' => 'nullable|unique:categories,slug,' . $category->id,
        ]);

        $category->update([
            'name' => $request->name,
            'slug' => $request->slug ? Str::slug($request->slug) : Str::slug($request->name),
            'status' => $request->has('status'),
            'type' => $request->type,
        ]);

        return redirect()->route('admin.categories.index', ['type' => $request->type])
            ->with('success', ucfirst($request->type) . ' updated successfully');
    }

    public function destroy(Category $category)
    {
        $category->delete();
        return redirect()->route('admin.categories.index')->with('success', 'Category deleted successfully');
    }
}
