<?php
require 'bootstrap/app.php';

$app = require_once 'bootstrap/app.php';
$kernel = $app->make('Illuminate\Contracts\Console\Kernel');
$kernel->bootstrap();

use App\Models\Admin;

try {
    $admin = Admin::create([
        'name' => 'REJ Admin',
        'email' => 'rejadmin',
        'password' => 'rejadmin123',
        'role' => 'super_admin',
        'is_active' => true,
    ]);
    
    echo "✓ Admin account created successfully!\n";
    echo "Email: rejadmin\n";
    echo "Password: rejadmin123\n";
    echo "Name: REJ Admin\n";
    echo "Role: super_admin\n";
} catch (\Exception $e) {
    echo "✗ Error creating admin: " . $e->getMessage() . "\n";
}
