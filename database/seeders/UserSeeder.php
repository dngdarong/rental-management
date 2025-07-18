<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create a Super Admin user
        User::firstOrCreate(
            ['email' => 'superadmin@gmail.com'],
            [
                'name' => 'Super Admin',
                'password' => Hash::make('superadmin123'), // Choose a strong password
                'email_verified_at' => now(),
                'role' => 'super_admin', // Set role to super_admin
            ]
        );

        // Create a default Admin Tenant user (if not already created by previous logic)
        User::firstOrCreate(
            ['email' => 'admin@example.com'],
            [
                'name' => 'Admin User',
                'password' => Hash::make('admin123'), // Choose a strong password
                'email_verified_at' => now(),
                'role' => 'admin_tenant', // Set role to admin_tenant
            ]
        );

        // You can also keep your personal admin user if you prefer
        User::firstOrCreate(
            ['email' => 'tenant@example.com'],
            [
                'name' => 'tenant',
                'password' => Hash::make('tenant123'), 
                'email_verified_at' => now(),
                'role' => 'admin_tenant', // Assign your personal user as admin_tenant
            ]
        );
    }
}

