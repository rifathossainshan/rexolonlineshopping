<?php

namespace App\Repositories;

use App\Models\Product;

class ProductRepository implements ProductRepositoryInterface
{
    public function all()
    {
        return Product::with(['category', 'images', 'sizes'])->latest()->get();
    }

    public function find($id)
    {
        return Product::with(['category', 'images', 'sizes'])->findOrFail($id);
    }

    public function findBySlug($slug)
    {
        return Product::with(['category', 'images', 'sizes'])->where('slug', $slug)->firstOrFail();
    }

    public function getFeatured($limit = 6)
    {
        return Product::with(['category', 'images'])->inRandomOrder()->take($limit)->get();
    }

    public function getRecent($limit = 8)
    {
        return Product::with(['category', 'images'])->latest()->take($limit)->get();
    }

    public function filter(array $filters)
    {
        $query = Product::with(['category', 'images', 'sizes']);

        if (isset($filters['sort'])) {
            if ($filters['sort'] == 'price_asc') {
                $query->orderBy('price', 'asc');
            } elseif ($filters['sort'] == 'price_desc') {
                $query->orderBy('price', 'desc');
            } else {
                $query->latest();
            }
        } else {
            $query->latest();
        }

        return $query->paginate(12);
    }
}
