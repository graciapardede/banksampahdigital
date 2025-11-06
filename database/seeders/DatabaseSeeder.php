<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            BranchSeeder::class,
            WasteTypeSeeder::class,
            AdminSeeder::class,      
            UserSeeder::class,
            TestUserSeeder::class,
            RewardItemSeeder::class,
        ]);
    }
}