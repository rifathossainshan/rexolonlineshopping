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
        'gender',
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
    public function hasStock(int $quantity): bool
    {
        return $this->stock >= $quantity;
    }

    public function decrementStock(int $quantity)
    {
        if ($this->hasStock($quantity)) {
            $this->stock -= $quantity;
            $this->save();
        }
    }
}
