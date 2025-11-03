<?php

namespace Database\Seeders;

use App\Models\Branch;
use Illuminate\Database\Seeder;

class BranchSeeder extends Seeder
{
    public function run(): void
    {
        Branch::create([
            'name' => 'Bank Sampah Pusat',
            'address' => 'Jl. Merdeka No. 1, Jakarta',
            'phone' => '021-555-111',
        ]);

        Branch::create([
            'name' => 'Bank Sampah Cabang A',
            'address' => 'Jl. Melati No. 55, Bandung',
            'phone' => '022-777-333',
        ]);
    }
}
