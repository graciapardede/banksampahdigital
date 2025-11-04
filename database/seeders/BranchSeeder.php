<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Branch;

class BranchSeeder extends Seeder
{
    public function run(): void
    {
        $branches = [
            [
                'name' => 'Cabang Medan Utara',
                'address' => 'Jl. Gatot Subroto No. 123, Medan',
                'phone' => '061-1234567',
            ],
            [
                'name' => 'Cabang Medan Timur',
                'address' => 'Jl. Jend. Sudirman No. 456, Medan',
                'phone' => '061-7654321',
            ],
            [
                'name' => 'Cabang Medan Barat',
                'address' => 'Jl. Asia No. 789, Medan',
                'phone' => '061-9876543',
            ],
        ];

        foreach ($branches as $branch) {
            Branch::create($branch);
        }
    }
}