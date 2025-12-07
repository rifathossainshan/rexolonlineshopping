<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = [
        'category_id',
        'title',
        'slug',
        'price',
        'discount_price',
        'description',
        'stock',
        'status',
        // 'sizes' removed
    ];

    // Removed sizes casting

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function images()
    {
        return $this->hasMany(ProductImage::class);
    }

    public function sizes()
    {
        return $this->belongsToMany(Size::class, 'product_size');
    }
}
