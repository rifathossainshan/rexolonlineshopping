<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Database\Seeders\ProductSeeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Create Admin
        User::create([
            'name' => 'Admin User',
            'email' => 'admin@gmail.com',
            'password' => 'password',
            'role' => 'admin',
        ]);

        // Create User
        User::create([
            'name' => 'Sneaker Head',
            'email' => 'user@gmail.com',
            'password' => 'password',
            'role' => 'user',
        ]);

        $this->call([
            ProductSeeder::class,
        ]);
    }
}
