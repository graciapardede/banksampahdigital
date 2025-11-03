<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    public function run(): void
    {
        User::create([
            'name' => 'Admin Pusat',
            'email' => 'admin@banksampah.com',
            'phone' => '08123456789',
            'password' => Hash::make('password'),
            'role' => 'super_admin',
            'branch_id' => 1,
        ]);

        User::create([
            'name' => 'Admin Cabang A',
            'email' => 'admin.cabang@banksampah.com',
            'phone' => '082233445566',
            'password' => Hash::make('password'),
            'role' => 'admin_cabang',
            'branch_id' => 2,
        ]);
    }
}
