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
                'name' => 'Cabang Sitoluama',
                'address' => 'Jl. Raya Sitoluama, Laguboti, Toba Samosir',
                'phone' => '0632-331001',
            ],
            [
                'name' => 'Cabang Balige',
                'address' => 'Jl. Sisingamangaraja No. 45, Balige, Toba Samosir',
                'phone' => '0632-321002',
            ],
        ];

        foreach ($branches as $branch) {
            Branch::create($branch);
        }
    }
}