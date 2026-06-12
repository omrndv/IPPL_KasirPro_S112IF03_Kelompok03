<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Create a default outlet
        $outlet = \App\Models\Outlet::create([
            'name' => 'Outlet Utama',
            'address' => 'Jl. Raya Utama No. 1, Bandung',
            'phone' => '022-123456',
        ]);

        // 1. Super Admin
        User::create([
            'name' => 'Super Admin',
            'username' => 'superadmin',
            'email' => 'superadmin@kasirpro.com',
            'password' => \Illuminate\Support\Facades\Hash::make('password'),
            'role' => 'superadmin',
            'outlet_id' => null,
            'email_verified_at' => now(),
        ]);

        // 2. Owner
        User::create([
            'name' => 'Owner KasirPro',
            'username' => 'owner',
            'email' => 'owner@kasirpro.com',
            'password' => \Illuminate\Support\Facades\Hash::make('password'),
            'role' => 'owner',
            'outlet_id' => $outlet->id,
            'email_verified_at' => now(),
        ]);

        // 3. Admin
        User::create([
            'name' => 'Admin KasirPro',
            'username' => 'admin',
            'email' => 'admin@kasirpro.com',
            'password' => \Illuminate\Support\Facades\Hash::make('password'),
            'role' => 'admin',
            'outlet_id' => $outlet->id,
            'email_verified_at' => now(),
        ]);

        // 4. Cashier
        User::create([
            'name' => 'Kasir Utama',
            'username' => 'kasir',
            'email' => 'kasir@kasirpro.com',
            'password' => \Illuminate\Support\Facades\Hash::make('password'),
            'role' => 'cashier',
            'outlet_id' => $outlet->id,
            'email_verified_at' => now(),
        ]);
    }
}
