<?php

namespace Database\Seeders;

use App\Models\WasteType;
use Illuminate\Database\Seeder;

class WasteTypeSeeder extends Seeder
{
    public function run(): void
    {
        WasteType::create([
            'name' => 'Plastik',
            'unit' => 'kg',
            'points_per_unit' => 10,
        ]);

        WasteType::create([
            'name' => 'Kertas',
            'unit' => 'kg',
            'points_per_unit' => 5,
        ]);

        WasteType::create([
            'name' => 'Logam',
            'unit' => 'kg',
            'points_per_unit' => 15,
        ]);
    }
}
