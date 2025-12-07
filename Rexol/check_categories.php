<?php

use App\Models\Category;

require __DIR__ . '/vendor/autoload.php';

$app = require_once __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Http\Kernel::class);
$response = $kernel->handle(
    $request = Illuminate\Http\Request::capture()
);

$categories = Category::pluck('name');
echo "Categories: " . implode(', ', $categories->toArray()) . "\n";
