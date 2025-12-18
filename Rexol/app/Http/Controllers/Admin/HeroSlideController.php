<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\HeroSlide;

class HeroSlideController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $slides = HeroSlide::latest()->get();
        return view('admin.hero_slides.index', compact('slides'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.hero_slides.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'title' => 'nullable|string|max:255',
            'sub_title' => 'nullable|string|max:255',
            'link' => 'nullable|url',
        ]);

        $input = $request->all();

        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $name = time() . '.' . $image->getClientOriginalExtension();
            $destinationPath = public_path('/uploads/hero-slides');
            $image->move($destinationPath, $name);
            $input['image'] = '/uploads/hero-slides/' . $name;
        }

        $input['status'] = $request->has('status');

        HeroSlide::create($input);

        return redirect()->route('admin.hero-slides.index')
            ->with('success', 'Slide created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(HeroSlide $heroSlide)
    {
        return view('admin.hero_slides.edit', compact('heroSlide'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, HeroSlide $heroSlide)
    {
        $request->validate([
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'title' => 'nullable|string|max:255',
            'sub_title' => 'nullable|string|max:255',
            'link' => 'nullable|url',
        ]);

        $input = $request->all();

        if ($request->hasFile('image')) {
            // Delete old image if exists
            if (file_exists(public_path($heroSlide->image))) {
                @unlink(public_path($heroSlide->image));
            }

            $image = $request->file('image');
            $name = time() . '.' . $image->getClientOriginalExtension();
            $destinationPath = public_path('/uploads/hero-slides');
            $image->move($destinationPath, $name);
            $input['image'] = '/uploads/hero-slides/' . $name;
        } else {
            unset($input['image']);
        }

        $input['status'] = $request->has('status');

        $heroSlide->update($input);

        return redirect()->route('admin.hero-slides.index')
            ->with('success', 'Slide updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(HeroSlide $heroSlide)
    {
        if (file_exists(public_path($heroSlide->image))) {
            @unlink(public_path($heroSlide->image));
        }

        $heroSlide->delete();

        return redirect()->route('admin.hero-slides.index')
            ->with('success', 'Slide deleted successfully');
    }
}
