<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use App\Models\Branch;
use App\Models\User;
use App\Models\WasteType;
use App\Models\RewardItem;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->command->info('Starting Master Seeder...');
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        DB::table('redemption_items')->truncate();
        DB::table('redemptions')->truncate();
        DB::table('deposit_items')->truncate();
        DB::table('deposits')->truncate();
        DB::table('point_ledgers')->truncate();
        DB::table('reward_items')->truncate();
        DB::table('waste_types')->truncate();
        DB::table('users')->truncate();
        DB::table('branches')->truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        $sitoluama = Branch::create(['name' => 'Cabang Sitoluama', 'address' => 'Jl. Raya Sitoluama No. 123', 'phone' => '0812-3456-7890']);
        $balige = Branch::create(['name' => 'Cabang Balige', 'address' => 'Jl. Balige Pusat No. 456', 'phone' => '0813-9876-5432']);

        User::create(['name' => 'Admin Sitoluama', 'email' => 'admin.sitoluama@greensaving.com', 'password' => Hash::make('password'), 'role' => 'admin', 'branch_id' => $sitoluama->id, 'balance_points' => 0, 'phone' => '0812-1111-1111', 'address' => 'Kantor Cabang Sitoluama']);
        User::create(['name' => 'Admin Balige', 'email' => 'admin.balige@greensaving.com', 'password' => Hash::make('password'), 'role' => 'admin', 'branch_id' => $balige->id, 'balance_points' => 0, 'phone' => '0813-2222-2222', 'address' => 'Kantor Cabang Balige']);

        $wargaSitoluama = [
            ['Martua Sitorus', 'martua.sitorus@gmail.com', 15000, '0812-3001-0001'],
            ['Rospita Siagian', 'rospita@gmail.com', 12500, '0812-3001-0002'],
            ['Jonatan Simbolon', 'jonatan@yahoo.com', 9075, '0812-3001-0003'],
            ['Tiurma Lumban Tobing', 'tiurma@gmail.com', 7800, '0812-3001-0004'],
            ['Parulian Situmorang', 'parulian@gmail.com', 6500, '0812-3001-0005'],
            ['Rostina Pangaribuan', 'rostina@yahoo.com', 5200, '0812-3001-0006'],
            ['Binsar Hutabarat', 'binsar@gmail.com', 4100, '0812-3001-0007'],
            ['Lenny Siahaan', 'lenny@gmail.com', 3500, '0812-3001-0008'],
            ['Mangasi Gultom', 'mangasi@yahoo.com', 2800, '0812-3001-0009'],
            ['Sondang Nainggolan', 'sondang@gmail.com', 1500, '0812-3001-0010']
        ];
        foreach ($wargaSitoluama as $w) {
            User::create(['name' => $w[0], 'email' => $w[1], 'password' => Hash::make('password'), 'role' => 'warga', 'branch_id' => $sitoluama->id, 'balance_points' => $w[2], 'phone' => $w[3], 'address' => 'Sitoluama, Toba']);
        }

        $wargaBalige = [
            ['Hotman Sinaga', 'hotman@gmail.com', 18000, '0813-4001-0001'],
            ['Roida Manurung', 'roida@gmail.com', 14000, '0813-4001-0002'],
            ['Sahala Sihombing', 'sahala@yahoo.com', 11500, '0813-4001-0003'],
            ['Rina Hutapea', 'rina@gmail.com', 9200, '0813-4001-0004'],
            ['Bonar Simanjuntak', 'bonar@gmail.com', 7600, '0813-4001-0005'],
            ['Juliana Pardede', 'juliana@yahoo.com', 6100, '0813-4001-0006'],
            ['Poltak Sirait', 'poltak@gmail.com', 4800, '0813-4001-0007'],
            ['Ernita Pandiangan', 'ernita@gmail.com', 3900, '0813-4001-0008'],
            ['Tongam Marpaung', 'tongam@yahoo.com', 2600, '0813-4001-0009'],
            ['Mertua Pasaribu', 'mertua@gmail.com', 1800, '0813-4001-0010']
        ];
        foreach ($wargaBalige as $w) {
            User::create(['name' => $w[0], 'email' => $w[1], 'password' => Hash::make('password'), 'role' => 'warga', 'branch_id' => $balige->id, 'balance_points' => $w[2], 'phone' => $w[3], 'address' => 'Balige, Toba']);
        }

        $wasteTypes = [
            ['Plastik PET', 'kg', 3000, 'Plastik'], ['Plastik HDPE', 'kg', 2500, 'Plastik'],
            ['Kertas HVS', 'kg', 2000, 'Kertas'], ['Kardus', 'kg', 1800, 'Kertas'],
            ['Botol Kaca', 'kg', 1500, 'Kaca'], ['Kaleng Aluminium', 'kg', 5000, 'Logam'], ['Besi/Logam', 'kg', 4000, 'Logam']
        ];
        foreach ($wasteTypes as $w) {
            WasteType::create(['name' => $w[0], 'unit' => $w[1], 'points_per_unit' => $w[2], 'category' => $w[3]]);
        }

        $rewardsSitoluama = [
            ['Beras 5kg Premium', 5000, 15, 'beras.png'], ['Minyak Goreng 2L', 15000, 25, 'minyak.png'],
            ['Pulsa Rp 10.000', 10000, 50, 'pulsa.png'], ['Tas Belanja Eco', 12000, 30, 'tas.png'],
            ['Tumbler Stainless', 20000, 10, 'tumbler.png'], ['Sabun Cuci 800ml', 9000, 40, 'sabun.png']
        ];
        foreach ($rewardsSitoluama as $r) {
            RewardItem::create(['branch_id' => $sitoluama->id, 'name' => $r[0], 'description' => 'Produk berkualitas - ' . $r[0], 'points_cost' => $r[1], 'stock' => $r[2], 'image' => $r[3]]);
        }

        $rewardsBalige = [
            ['Beras 5kg Premium', 5000, 20, 'beras.png'], ['Minyak Goreng 2L', 15000, 18, 'minyak.png'],
            ['Pulsa Rp 10.000', 10000, 60, 'pulsa.png'], ['Tas Belanja Eco', 12000, 25, 'tas.png'],
            ['Tumbler Stainless', 20000, 15, 'tumbler.png'], ['Sabun Cuci 800ml', 9000, 35, 'sabun.png'], ['Gula Pasir 1kg', 11000, 22, 'gula.png']
        ];
        foreach ($rewardsBalige as $r) {
            RewardItem::create(['branch_id' => $balige->id, 'name' => $r[0], 'description' => 'Produk berkualitas - ' . $r[0], 'points_cost' => $r[1], 'stock' => $r[2], 'image' => $r[3]]);
        }

        $this->command->info('Seeding completed! Login: admin.sitoluama@greensaving.com / password');
    }
}