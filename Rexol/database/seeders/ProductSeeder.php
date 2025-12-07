<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Category;
use App\Models\Product;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Admin User creation moved to DatabaseSeeder or handled by firstOrCreate
        // \App\Models\User::firstOrCreate([
        //     'email' => 'admin@gmail.com',
        // ], [
        //     'name' => 'Admin User',
        //     'password' => 'password',
        //     'role' => 'admin',
        // ]);

        // Create Categories
        // Create Categories
        $nike = Category::firstOrCreate(['slug' => 'nike'], ['name' => 'Nike', 'status' => true]);
        $adidas = Category::firstOrCreate(['slug' => 'adidas'], ['name' => 'Adidas', 'status' => true]);
        $jordan = Category::firstOrCreate(['slug' => 'air-jordan'], ['name' => 'Air Jordan', 'status' => true]);
        $puma = Category::firstOrCreate(['slug' => 'puma'], ['name' => 'Puma', 'status' => true]);

        // Create Sizes
        $sizes = ['US 6', 'US 7', 'US 8', 'US 9', 'US 10', 'US 11'];
        $sizeModels = [];
        foreach ($sizes as $size) {
            $sizeModels[$size] = \App\Models\Size::firstOrCreate(['slug' => \Illuminate\Support\Str::slug($size)], [
                'name' => $size,
            ]);
        }

        // Create Products
        $p1 = Product::firstOrCreate(['slug' => 'air-jordan-1-retro-high-og'], [
            'category_id' => $jordan->id,
            'title' => 'Air Jordan 1 Retro High OG',
            'price' => 18500,
            'description' => 'The Air Jordan 1 Retro High OG is a work of nostalgia, modernizing the 1985 icon\'s distinctive elements to honor Michael Jordan\'s off-court style.',
            'stock' => 10,
        ]);
        $p1->sizes()->attach([$sizeModels['US 7']->id, $sizeModels['US 8']->id, $sizeModels['US 9']->id, $sizeModels['US 10']->id, $sizeModels['US 11']->id]);

        $p2 = Product::firstOrCreate(['slug' => 'nike-air-force-1-07'], [
            'category_id' => $nike->id,
            'title' => 'Nike Air Force 1 \'07',
            'price' => 12500,
            'description' => 'The radiance lives on in the Nike Air Force 1 \'07, the b-ball icon that puts a fresh spin on what you know best: crisp leather, bold colors and the perfect amount of flash to make you shine.',
            'stock' => 25,
        ]);
        $p2->sizes()->attach([$sizeModels['US 6']->id, $sizeModels['US 7']->id, $sizeModels['US 8']->id, $sizeModels['US 9']->id]);

        $p3 = Product::firstOrCreate(['slug' => 'adidas-yeezy-boost-350-v2'], [
            'category_id' => $adidas->id,
            'title' => 'Adidas Yeezy Boost 350 V2',
            'price' => 25000,
            'description' => 'Designed by Kanye West, the Yeezy Boost 350 V2 typically features a Primeknit upper and Boost cushioning.',
            'stock' => 5,
        ]);
        $p3->sizes()->attach([$sizeModels['US 8']->id, $sizeModels['US 9']->id, $sizeModels['US 10']->id]);

        $p4 = Product::firstOrCreate(['slug' => 'puma-rs-x3-puzzle'], [
            'category_id' => $puma->id,
            'title' => 'Puma RS-X³ Puzzle',
            'price' => 10500,
            'description' => 'X marks extreme. Exaggerated. Remixed. X³ takes things to a new level: cubed, enhanced, extra.',
            'stock' => 15,
        ]);
        $p4->sizes()->attach([$sizeModels['US 7']->id, $sizeModels['US 8']->id, $sizeModels['US 9']->id, $sizeModels['US 10']->id]);
    }
}
