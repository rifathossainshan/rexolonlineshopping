<?php

use App\Models\User;
use Illuminate\Support\Facades\Hash;

require __DIR__ . '/vendor/autoload.php';

$app = require_once __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

$user = User::where('email', 'admin@gmail.com')->first();

if ($user) {
    echo "User found: " . $user->name . "\n";
    echo "Current Role: " . $user->role . "\n";

    // Force update password
    $user->password = 'password'; // Model cast should handle hashing
    $user->save();

    echo "Password reset to 'password'.\n";
    echo "New Hash: " . $user->password . "\n";

    // Verify hash
    if (Hash::check('password', $user->password)) {
        echo "Hash verification SUCCESS.\n";
    } else {
        echo "Hash verification FAILED.\n";
    }
} else {
    echo "User admin@gmail.com NOT FOUND.\n";
}
