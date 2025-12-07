<?php

use App\Models\Product;
use App\Models\Category;
use App\Models\User;
use App\Models\Order;

require __DIR__ . '/vendor/autoload.php';

$app = require_once __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

echo "Verifying Database Relationships...\n";

// Check Categories
$categories = Category::all();
echo "Categories Count: " . $categories->count() . "\n";

// Check Products with Relations
$product = Product::with('category', 'images')->first();
if ($product) {
    echo "First Product: " . $product->title . "\n";
    echo "Category: " . ($product->category ? $product->category->name : 'None') . "\n";
    echo "Images Count: " . $product->images->count() . "\n";
    echo "Sizes: " . json_encode($product->sizes) . "\n";
} else {
    echo "No products found!\n";
}

// Check Users
$user = User::where('email', 'admin@gmail.com')->first();
echo "Admin User: " . ($user ? 'Found' : 'Not Found') . "\n";

// Check Payments
try {
    $paymentCount = \Illuminate\Support\Facades\DB::table('payments')->count();
    echo "Payments Table: Found (Count: $paymentCount)\n";
} catch (\Exception $e) {
    echo "Payments Table: Not Found Error: " . $e->getMessage() . "\n";
}

echo "Verification Complete.\n";
