<?php

namespace App\Observers;

use App\Models\Product;
use Illuminate\Support\Facades\Cache;

class ProductObserver
{
    /**
     * Handle the Product "created" event.
     */
    public function created(Product $product): void
    {
        Cache::forget('new_arrivals');
        Cache::forget('shop_all_products'); // Taking proactive measure if we cache that later
    }

    /**
     * Handle the Product "updated" event.
     */
    public function updated(Product $product): void
    {
        Cache::forget('new_arrivals');
        Cache::forget('shop_all_products');
    }

    /**
     * Handle the Product "deleted" event.
     */
    public function deleted(Product $product): void
    {
        Cache::forget('new_arrivals');
        Cache::forget('shop_all_products');
    }

    /**
     * Handle the Product "restored" event.
     */
    public function restored(Product $product): void
    {
        Cache::forget('new_arrivals');
    }

    /**
     * Handle the Product "force deleted" event.
     */
    public function forceDeleted(Product $product): void
    {
        Cache::forget('new_arrivals');
    }
}
