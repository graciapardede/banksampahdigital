<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\RewardItem;

class RewardItemSeeder extends Seeder
{
    public function run(): void
    {
        $rewardItems = [
            [
                'branch_id' => 1,
                'name' => 'Pulsa Rp 10.000',
                'stock' => 50,
                'points_cost' => 1000,
            ],
            [
                'branch_id' => 1,
                'name' => 'Pulsa Rp 25.000',
                'stock' => 30,
                'points_cost' => 2500,
            ],
            [
                'branch_id' => 1,
                'name' => 'Tas Belanja',
                'stock' => 20,
                'points_cost' => 1500,
            ],
            [
                'branch_id' => 2,
                'name' => 'Voucher Alfamart Rp 50.000',
                'stock' => 15,
                'points_cost' => 5000,
            ],
            [
                'branch_id' => 2,
                'name' => 'Tumbler',
                'stock' => 25,
                'points_cost' => 2000,
            ],
        ];

        foreach ($rewardItems as $item) {
            RewardItem::create($item);
        }
    }
}