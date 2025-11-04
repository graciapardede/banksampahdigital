<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // create default admin if not exists
        $email = env('ADMIN_EMAIL', 'admin@example.com');
        if (! User::where('email', $email)->exists()) {
            User::create([
                'full_name' => env('ADMIN_NAME', 'Admin Cabang'),
                'email' => $email,
                'phone' => env('ADMIN_PHONE', null),
                'address' => env('ADMIN_ADDRESS', 'Head Office'),
                'password' => Hash::make(env('ADMIN_PASSWORD', 'password123')),
                'role' => User::ROLE_ADMIN,
                'balance_points' => 0,
            ]);
        }
    }
}
