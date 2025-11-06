<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class TestUserSeeder extends Seeder
{
    public function run(): void
    {
        $email = 'test@example.com';
        $password = 'password123';

        User::updateOrCreate(
            ['email' => $email],
            [
                'name' => 'Test User',
                'full_name' => 'Test User',
                'email' => $email,
                'password' => Hash::make($password),
                'role' => User::ROLE_WARGA,
                'balance_points' => 0,
            ]
        );

        $this->command->info("Test user ensured: {$email} / {$password}");
    }
}
