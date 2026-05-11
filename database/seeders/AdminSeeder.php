<?php

namespace Database\Seeders;

use App\Models\Admin;
use Illuminate\Database\Seeder;

class AdminSeeder extends Seeder
{
    /**
     * Seed the admins table.
     */
    public function run(): void
    {
        Admin::updateOrCreate(
            ['email' => 'rejadmin@mrjr.edu'],
            [
                'name' => 'REJ Admin',
                'email' => 'rejadmin@mrjr.edu',
                'password' => 'rejadmin123',
                'role' => 'super_admin',
                'is_active' => true,
            ]
        );
    }
}
