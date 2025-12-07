<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;
use Illuminate\Support\Str;

class GenderCategorySeeder extends Seeder
{
    public function run()
    {
        $categories = ['Men', 'Women', 'Boys', 'Girls', 'Kids'];

        foreach ($categories as $category) {
            Category::firstOrCreate(
                ['name' => $category],
                [
                    'slug' => Str::slug($category),
                    'status' => true
                ]
            );
        }
    }
}
