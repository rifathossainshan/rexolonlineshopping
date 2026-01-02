<?php
require __DIR__ . '/vendor/autoload.php';
$app = require __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\Category;

// 1. Ensure Standard Categories
$standards = ['Nike', 'Adidas', 'Air Jordan', 'Puma'];
foreach ($standards as $name) {
    Category::where('name', $name)->update(['type' => 'standard']);
    echo "Set $name to standard.\n";
}

// 2. Ensure Gender Categories
$genders = ['Men', 'Women', 'Boys', 'Girls', 'Kids', 'Unisex'];
foreach ($genders as $name) {
    // Check if exists
    $exists = Category::where('name', $name)->exists();
    if ($exists) {
        Category::where('name', $name)->update(['type' => 'gender']);
        echo "Set $name to gender.\n";
    } else {
        // Create if missing? The user wants DYNAMIC list, so maybe don't create?
        // But if they are missing, the UI won't show them. 
        // Let's create them if they are missing, as they seem to be expected "defaults".
        Category::create([
            'name' => $name,
            'slug' => \Illuminate\Support\Str::slug($name),
            'type' => 'gender',
            'status' => true
        ]);
        echo "Created $name as gender.\n";
    }
}

// 3. Remove Test Data
Category::where('name', 'TestGen')->delete();
Category::where('name', 'Test Category')->delete();
echo "Removed test data.\n";

// 4. Remove 'gender' types that are somehow marked as 'standard'? 
// No, step 2 handled the exact names.

// 5. Check for duplicates (same name, multiple entries)
$all = Category::all();
$seen = [];
foreach ($all as $c) {
    if (isset($seen[$c->name])) {
        echo "Duplicate found: {$c->name} (ID: {$c->id}). Deleting.\n";
        $c->delete();
    } else {
        $seen[$c->name] = true;
    }
}

echo "Cleanup complete.\n";
