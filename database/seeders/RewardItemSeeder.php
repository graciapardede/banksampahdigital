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
                'name' => 'Beras Premium 5kg',
                'description' => 'Beras berkualitas tinggi untuk kebutuhan sehari-hari',
                'image' => 'beras.png',
                'stock' => 25,
                'points_cost' => 2000,
            ],
            [
                'branch_id' => 1,
                'name' => 'Minyak Goreng 2L',
                'description' => 'Minyak goreng kemasan 2 liter untuk memasak',
                'image' => 'minyak goreng.png',
                'stock' => 30,
                'points_cost' => 1500,
            ],
            [
                'branch_id' => 1,
                'name' => 'Gula Pasir 1kg',
                'description' => 'Gula pasir murni kemasan 1 kilogram',
                'image' => 'gula.png',
                'stock' => 40,
                'points_cost' => 800,
            ],
            [
                'branch_id' => 1,
                'name' => 'Detergen 1kg',
                'description' => 'Detergen bubuk untuk mencuci pakaian',
                'image' => 'detergen.png',
                'stock' => 35,
                'points_cost' => 1000,
            ],
            [
                'branch_id' => 1,
                'name' => 'Sabun Mandi',
                'description' => 'Sabun mandi batangan wangi dan lembut',
                'image' => 'sabun.png',
                'stock' => 50,
                'points_cost' => 300,
            ],
            [
                'branch_id' => 1,
                'name' => 'Shampo 170ml',
                'description' => 'Shampo rambut untuk perawatan sehari-hari',
                'image' => 'shampo.png',
                'stock' => 45,
                'points_cost' => 500,
            ],
            [
                'branch_id' => 1,
                'name' => 'Pasta Gigi',
                'description' => 'Pasta gigi untuk kesehatan mulut',
                'image' => 'pasta.png',
                'stock' => 60,
                'points_cost' => 200,
            ],
            [
                'branch_id' => 1,
                'name' => 'Sikat Gigi',
                'description' => 'Sikat gigi berkualitas untuk membersihkan gigi',
                'image' => 'sikat gigi.png',
                'stock' => 70,
                'points_cost' => 150,
            ],
            [
                'branch_id' => 1,
                'name' => 'Susu Bubuk 400g',
                'description' => 'Susu bubuk kemasan 400 gram',
                'image' => 'susu.png',
                'stock' => 20,
                'points_cost' => 2500,
            ],
            [
                'branch_id' => 1,
                'name' => 'Telur 1kg',
                'description' => 'Telur ayam segar 1 kilogram',
                'image' => 'telur.png',
                'stock' => 15,
                'points_cost' => 1200,
            ],
            [
                'branch_id' => 1,
                'name' => 'Tepung Terigu 1kg',
                'description' => 'Tepung terigu untuk keperluan membuat kue',
                'image' => 'tepung.png',
                'stock' => 30,
                'points_cost' => 600,
            ],
            [
                'branch_id' => 1,
                'name' => 'Kacang Tanah 500g',
                'description' => 'Kacang tanah kemasan 500 gram',
                'image' => 'kacang.png',
                'stock' => 25,
                'points_cost' => 700,
            ],
        ];

        foreach ($rewardItems as $item) {
            RewardItem::create($item);
        }
    }
}