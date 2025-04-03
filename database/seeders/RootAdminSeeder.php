<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class RootAdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $adminEmail = env('ROOT_ADMIN_EMAIL', 'admin@example.com');
        $adminPassword = env('ROOT_ADMIN_PASSWORD', 'secret');

        User::updateOrCreate(
            ['email' => $adminEmail],
            [
                'name' => 'Root Admin',
                'username' => 'rootadmin',
                'age' => 30,
                'country' => 'Unknown',
                'password' => Hash::make($adminPassword),
                'role' => 'admin'
            ]
        );
    }
}