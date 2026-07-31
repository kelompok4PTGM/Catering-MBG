<?php
require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

$user = App\Models\User::create([
    'username' => 'testuser' . time(),
    'email' => 'test' . time() . '@test.com',
    'password' => 'password123',
    'role' => 'Superadmin',
    'status' => 'Aktif'
]);

$attempt = Auth::attempt(['username' => $user->username, 'password' => 'password123']);
echo "Attempt result: " . ($attempt ? "Success" : "Failed") . "\n";
