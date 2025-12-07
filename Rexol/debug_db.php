<?php

use App\Models\Category;
use App\Models\Size;

require __DIR__ . '/vendor/autoload.php';

$app = require_once __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

echo "Checking Categories...\n";
$categories = Category::all();
echo "Total Categories: " . $categories->count() . "\n";
foreach ($categories as $cat) {
    echo "ID: {$cat->id}, Name: {$cat->name}, Status: " . ($cat->status ? 'TRUE' : 'FALSE') . " (" . var_export($cat->status, true) . ")\n";
}

echo "\nChecking Sizes...\n";
$sizes = Size::all();
echo "Total Sizes: " . $sizes->count() . "\n";
foreach ($sizes as $size) {
    echo "ID: {$size->id}, Name: {$size->name}\n";
}
