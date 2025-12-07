<?php

use App\Models\Product;
use App\Models\Size;
use App\Services\ProductService;
use Illuminate\Support\Facades\App;

require __DIR__ . '/vendor/autoload.php';

$app = require_once __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

echo "Verifying Phase 3: Models & Services\n";
echo "------------------------------------\n";

// 1. Verify Size Model
$sizeCount = Size::count();
echo "Size Count: $sizeCount (Expected > 0)\n";

// 2. Verify Product Size Relationship
$product = Product::with('sizes')->first();
if ($product) {
    echo "Product Found: " . $product->title . "\n";
    echo "Sizes Attached: " . $product->sizes->count() . "\n";
    foreach ($product->sizes as $size) {
        echo " - " . $size->name . "\n";
    }
} else {
    echo "No Products found!\n";
}

// 3. Verify Product Service
echo "\nTesting ProductService...\n";
$service = App::make(ProductService::class);
$products = $service->getAllProducts();
echo "Service returned " . $products->count() . " products.\n";

$featured = $service->getFeaturedProducts();
echo "Featured returned " . $featured->count() . " products.\n";

echo "\nVerification Complete.\n";
