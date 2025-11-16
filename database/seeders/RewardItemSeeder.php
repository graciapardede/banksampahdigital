<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\RewardItem;

class RewardItemSeeder extends Seeder
{
    public function run(): void
    {
        $rewardItems = [
            // Kategori: Sembako & Kebutuhan Pokok
            ['name' => 'Beras Premium 5 kg', 'stock' => 20, 'points_cost' => 10000, 'branch_id' => 1],
            ['name' => 'Minyak Goreng 2 L', 'stock' => 30, 'points_cost' => 6000, 'branch_id' => 1],
            ['name' => 'Gula Pasir 1 kg', 'stock' => 25, 'points_cost' => 4000, 'branch_id' => 1],
            ['name' => 'Tepung Terigu 1 kg', 'stock' => 20, 'points_cost' => 3000, 'branch_id' => 1],
            ['name' => 'Telur 1 kg', 'stock' => 15, 'points_cost' => 5000, 'branch_id' => 1],
            
            // Kategori: Pulsa & Token Listrik
            ['name' => 'Pulsa Rp 10.000', 'stock' => 100, 'points_cost' => 1000, 'branch_id' => 1],
            ['name' => 'Pulsa Rp 25.000', 'stock' => 80, 'points_cost' => 2500, 'branch_id' => 1],
            ['name' => 'Pulsa Rp 50.000', 'stock' => 50, 'points_cost' => 5000, 'branch_id' => 1],
            ['name' => 'Token Listrik Rp 20.000', 'stock' => 60, 'points_cost' => 2000, 'branch_id' => 1],
            ['name' => 'Token Listrik Rp 50.000', 'stock' => 40, 'points_cost' => 5000, 'branch_id' => 1],
            
            // Kategori: Voucher Belanja
            ['name' => 'Voucher Alfamart Rp 25.000', 'stock' => 30, 'points_cost' => 2500, 'branch_id' => 1],
            ['name' => 'Voucher Alfamart Rp 50.000', 'stock' => 25, 'points_cost' => 5000, 'branch_id' => 1],
            ['name' => 'Voucher Indomaret Rp 25.000', 'stock' => 30, 'points_cost' => 2500, 'branch_id' => 1],
            ['name' => 'Voucher Indomaret Rp 50.000', 'stock' => 25, 'points_cost' => 5000, 'branch_id' => 1],
            
            // Kategori: Alat Kebersihan
            ['name' => 'Sabun Cuci Piring', 'stock' => 40, 'points_cost' => 2000, 'branch_id' => 1],
            ['name' => 'Detergen 1 kg', 'stock' => 30, 'points_cost' => 3500, 'branch_id' => 1],
            ['name' => 'Sabun Mandi', 'stock' => 50, 'points_cost' => 1500, 'branch_id' => 1],
            ['name' => 'Shampo Sachet (10 pcs)', 'stock' => 40, 'points_cost' => 2000, 'branch_id' => 1],
            ['name' => 'Pasta Gigi', 'stock' => 35, 'points_cost' => 1800, 'branch_id' => 1],
            
            // Kategori: Barang Ramah Lingkungan
            ['name' => 'Tas Belanja Kain', 'stock' => 50, 'points_cost' => 1500, 'branch_id' => 1],
            ['name' => 'Tumbler Stainless', 'stock' => 25, 'points_cost' => 4000, 'branch_id' => 1],
            ['name' => 'Sedotan Stainless (set 4)', 'stock' => 30, 'points_cost' => 2500, 'branch_id' => 1],
            ['name' => 'Lunch Box Ramah Lingkungan', 'stock' => 20, 'points_cost' => 5000, 'branch_id' => 1],
            
            // Kategori: Makanan & Minuman
            ['name' => 'Mie Instan (1 dus)', 'stock' => 30, 'points_cost' => 7000, 'branch_id' => 1],
            ['name' => 'Kopi Sachet (1 box)', 'stock' => 40, 'points_cost' => 2500, 'branch_id' => 1],
            ['name' => 'Teh Celup (1 box)', 'stock' => 40, 'points_cost' => 2000, 'branch_id' => 1],
            ['name' => 'Susu Kotak (1 dus)', 'stock' => 25, 'points_cost' => 8000, 'branch_id' => 1],
            ['name' => 'Biskuit Kaleng', 'stock' => 30, 'points_cost' => 4500, 'branch_id' => 1],
            
            // Kategori: Perlengkapan Sekolah
            ['name' => 'Buku Tulis (10 pcs)', 'stock' => 50, 'points_cost' => 3000, 'branch_id' => 1],
            ['name' => 'Pensil 2B (1 lusin)', 'stock' => 40, 'points_cost' => 2000, 'branch_id' => 1],
            ['name' => 'Bolpoin (1 pak)', 'stock' => 45, 'points_cost' => 1500, 'branch_id' => 1],
            ['name' => 'Crayon 12 warna', 'stock' => 30, 'points_cost' => 2500, 'branch_id' => 1],
            ['name' => 'Tas Sekolah', 'stock' => 15, 'points_cost' => 12000, 'branch_id' => 1],
        ];

        foreach ($rewardItems as $item) {
            RewardItem::create($item);
        }
    }
}