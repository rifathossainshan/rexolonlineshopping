<?php
require __DIR__ . '/vendor/autoload.php';
$app = require __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

$categories = \App\Models\Category::all();
$output = "";
foreach ($categories as $c) {
    $output .= "ID: {$c->id} | Name: {$c->name} | Type: {$c->type} | Slug: {$c->slug}" . PHP_EOL;
}
file_put_contents('cats_dump.txt', $output);
echo "Dumped to cats_dump.txt";
