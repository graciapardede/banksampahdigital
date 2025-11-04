<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\WasteType;

class WasteTypeSeeder extends Seeder
{
    public function run(): void
    {
        $wasteTypes = [
            [
                'name' => 'Plastik',
                'unit' => 'kg',
                'points_per_unit' => 100,
            ],
            [
                'name' => 'Kertas',
                'unit' => 'kg',
                'points_per_unit' => 80,
            ],
            [
                'name' => 'Kaleng',
                'unit' => 'kg',
                'points_per_unit' => 120,
            ],
            [
                'name' => 'Botol Kaca',
                'unit' => 'pcs',
                'points_per_unit' => 50,
            ],
            [
                'name' => 'Kardus',
                'unit' => 'kg',
                'points_per_unit' => 70,
            ],
        ];

        foreach ($wasteTypes as $wasteType) {
            WasteType::create($wasteType);
        }
    }
}