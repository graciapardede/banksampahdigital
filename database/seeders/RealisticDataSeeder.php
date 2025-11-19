<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Branch;
use App\Models\WasteType;
use App\Models\RewardItem;
use App\Models\Deposit;
use App\Models\DepositItem;
use App\Models\Redemption;
use App\Models\RedemptionItem;
use App\Models\PointsLedger;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class RealisticDataSeeder extends Seeder
{
    public function run(): void
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        
        // Clear existing data
        PointsLedger::truncate();
        RedemptionItem::truncate();
        Redemption::truncate();
        DepositItem::truncate();
        Deposit::truncate();
        RewardItem::truncate();
        WasteType::truncate();
        User::where('role', '!=', 'superadmin')->delete();
        Branch::truncate();
        
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        // 1. BRANCHES
        $sitoluama = Branch::create([
            'name' => 'Cabang Sitoluama',
            'address' => 'Jl. Raya Sitoluama, Laguboti, Toba Samosir',
            'phone' => '0632-331001',
        ]);

        $balige = Branch::create([
            'name' => 'Cabang Balige',
            'address' => 'Jl. Sisingamangaraja No. 45, Balige, Toba Samosir',
            'phone' => '0632-321002',
        ]);

        // 2. ADMINS
        $adminSitoluama = User::create([
            'name' => 'Admin Sitoluama',
            'email' => 'admin.sitoluama@greensaving.com',
            'password' => Hash::make('password'),
            'role' => 'admin',
            'phone' => '082311001001',
            'branch' => 'Sitoluama',
            'branch_id' => $sitoluama->id,
        ]);

        $adminBalige = User::create([
            'name' => 'Admin Balige',
            'email' => 'admin.balige@greensaving.com',
            'password' => Hash::make('password'),
            'role' => 'admin',
            'phone' => '082311002001',
            'branch' => 'Balige',
            'branch_id' => $balige->id,
        ]);

        // 3. USERS (8 Warga)
        $warga = [];
        
        $warga[] = User::create([
            'name' => 'Budi Santoso',
            'email' => 'budi.santoso@example.com',
            'password' => Hash::make('password'),
            'role' => 'user',
            'phone' => '082345678901',
            'branch' => 'Sitoluama',
        ]);

        $warga[] = User::create([
            'name' => 'Sari Hutabarat',
            'email' => 'sari.hutabarat@example.com',
            'password' => Hash::make('password'),
            'role' => 'user',
            'phone' => '082145673210',
            'branch' => 'Sitoluama',
        ]);

        $warga[] = User::create([
            'name' => 'Martua Sitorus',
            'email' => 'martua.sitorus@example.com',
            'password' => Hash::make('password'),
            'role' => 'user',
            'phone' => '082298765432',
            'branch' => 'Sitoluama',
        ]);

        $warga[] = User::create([
            'name' => 'Rina Siahaan',
            'email' => 'rina.siahaan@example.com',
            'password' => Hash::make('password'),
            'role' => 'user',
            'phone' => '082187654321',
            'branch' => 'Sitoluama',
        ]);

        $warga[] = User::create([
            'name' => 'Jonatan Simbolon',
            'email' => 'jonatan.simbolon@example.com',
            'password' => Hash::make('password'),
            'role' => 'user',
            'phone' => '082334455667',
            'branch' => 'Balige',
        ]);

        $warga[] = User::create([
            'name' => 'Tiurma Manurung',
            'email' => 'tiurma.manurung@example.com',
            'password' => Hash::make('password'),
            'role' => 'user',
            'phone' => '082223344556',
            'branch' => 'Balige',
        ]);

        $warga[] = User::create([
            'name' => 'Parlindungan Pasaribu',
            'email' => 'parlindungan.pasaribu@example.com',
            'password' => Hash::make('password'),
            'role' => 'user',
            'phone' => '082112233445',
            'branch' => 'Balige',
        ]);

        $warga[] = User::create([
            'name' => 'Evalina Lumbantobing',
            'email' => 'evalina.lumbantobing@example.com',
            'password' => Hash::make('password'),
            'role' => 'user',
            'phone' => '082156789012',
            'branch' => 'Balige',
        ]);

        // 4. WASTE TYPES (6 jenis sampah)
        $wasteTypes = [];
        
        $wasteTypes[] = WasteType::create([
            'name' => 'Botol Plastik',
            'category' => 'Plastik',
            'unit' => 'kg',
            'points_per_unit' => 300,
            'description' => 'Botol plastik bekas minuman (PET)',
        ]);

        $wasteTypes[] = WasteType::create([
            'name' => 'Kardus/Kertas',
            'category' => 'Kertas',
            'unit' => 'kg',
            'points_per_unit' => 150,
            'description' => 'Kardus bekas dan kertas',
        ]);

        $wasteTypes[] = WasteType::create([
            'name' => 'Kaleng & Besi',
            'category' => 'Logam',
            'unit' => 'kg',
            'points_per_unit' => 250,
            'description' => 'Kaleng minuman dan besi bekas',
        ]);

        $wasteTypes[] = WasteType::create([
            'name' => 'Minyak Jelantah',
            'category' => 'Organik',
            'unit' => 'kg',
            'points_per_unit' => 120,
            'description' => 'Minyak goreng bekas',
        ]);

        $wasteTypes[] = WasteType::create([
            'name' => 'Kaca',
            'category' => 'Kaca',
            'unit' => 'kg',
            'points_per_unit' => 90,
            'description' => 'Botol kaca dan pecahan kaca',
        ]);

        $wasteTypes[] = WasteType::create([
            'name' => 'Elektronik Kecil',
            'category' => 'Elektronik',
            'unit' => 'kg',
            'points_per_unit' => 500,
            'description' => 'Handphone bekas, kabel, charger',
        ]);

        // 5. REWARD ITEMS (6 barang)
        $rewards = [];
        
        $rewards[] = RewardItem::create([
            'branch_id' => $sitoluama->id,
            'name' => 'Beras 5kg',
            'description' => 'Beras berkualitas premium 5 kilogram',
            'image' => 'beras.png',
            'stock' => 15,
            'points_cost' => 2000,
        ]);

        $rewards[] = RewardItem::create([
            'branch_id' => $sitoluama->id,
            'name' => 'Minyak Goreng 2L',
            'description' => 'Minyak goreng kemasan 2 liter',
            'image' => 'minyak.png',
            'stock' => 25,
            'points_cost' => 1500,
        ]);

        $rewards[] = RewardItem::create([
            'branch_id' => $sitoluama->id,
            'name' => 'Pulsa Rp 10.000',
            'description' => 'Voucher pulsa all operator 10 ribu',
            'image' => 'pulsa.png',
            'stock' => 50,
            'points_cost' => 1000,
        ]);

        $rewards[] = RewardItem::create([
            'branch_id' => $balige->id,
            'name' => 'Tas Belanja Eco',
            'description' => 'Tas belanja ramah lingkungan',
            'image' => 'tas.png',
            'stock' => 30,
            'points_cost' => 1200,
        ]);

        $rewards[] = RewardItem::create([
            'branch_id' => $balige->id,
            'name' => 'Tumbler Stainless',
            'description' => 'Tumbler stainless steel 500ml',
            'image' => 'tumbler.png',
            'stock' => 10,
            'points_cost' => 2000,
        ]);

        $rewards[] = RewardItem::create([
            'branch_id' => $balige->id,
            'name' => 'Sabun Cuci 800ml',
            'description' => 'Sabun cuci piring 800ml',
            'image' => 'sabun.png',
            'stock' => 40,
            'points_cost' => 900,
        ]);

        // 6. DEPOSITS (20 transaksi setoran)
        $this->info('Creating deposits...');
        
        for ($i = 0; $i < 20; $i++) {
            $user = $warga[array_rand($warga)];
            $wasteType = $wasteTypes[array_rand($wasteTypes)];
            $branch = rand(0, 1) == 0 ? $sitoluama : $balige;
            
            // Berat realistis 0.5kg - 5kg
            $weight = rand(5, 50) / 10; // 0.5 sampai 5.0
            $pointsPerUnit = $wasteType->points_per_unit;
            $totalPoints = (int)($weight * $pointsPerUnit);
            
            // 80% verified, 20% pending
            $status = rand(1, 10) <= 8 ? 'verified' : 'pending';
            
            $deposit = Deposit::create([
                'user_id' => $user->id,
                'branch_id' => $branch->id,
                'total_weight' => $weight,
                'total_points' => $totalPoints,
                'status' => $status,
                'created_at' => now()->subDays(rand(1, 30)),
                'updated_at' => $status == 'verified' ? now()->subDays(rand(1, 30)) : now()->subDays(rand(1, 30)),
            ]);

            // Buat deposit item
            DepositItem::create([
                'deposit_id' => $deposit->id,
                'waste_type_id' => $wasteType->id,
                'weight' => $weight,
                'points' => $totalPoints,
            ]);

            // Jika verified, tambah ke point ledger
            if ($status == 'verified') {
                $currentBalance = PointsLedger::where('user_id', $user->id)->sum('points');
                PointsLedger::create([
                    'user_id' => $user->id,
                    'type' => 'deposit',
                    'points' => $totalPoints,
                    'balance' => $currentBalance + $totalPoints,
                    'description' => "Setoran {$wasteType->name} - {$weight}kg",
                    'deposit_id' => $deposit->id,
                    'created_at' => $deposit->updated_at,
                    'updated_at' => $deposit->updated_at,
                ]);
            }
        }

        $this->info('Deposits created successfully!');

        // 7. REDEMPTIONS (10 penukaran)
        $this->info('Creating redemptions...');
        
        // Pilih user yang poinnya cukup
        $usersWithPoints = [];
        foreach ($warga as $user) {
            $totalPoints = PointsLedger::where('user_id', $user->id)->sum('points');
            if ($totalPoints >= 900) { // Minimal poin untuk tukar sabun
                $usersWithPoints[] = [
                    'user' => $user,
                    'points' => $totalPoints
                ];
            }
        }

        $statusOptions = ['pending', 'confirmed', 'completed'];
        
        for ($i = 0; $i < min(10, count($usersWithPoints)); $i++) {
            $userData = $usersWithPoints[$i % count($usersWithPoints)];
            $user = $userData['user'];
            
            // Cari reward yang poinnya cukup
            $availableRewards = RewardItem::where('stock', '>', 0)
                ->where('points_cost', '<=', $userData['points'])
                ->inRandomOrder()
                ->first();
            
            if (!$availableRewards) continue;
            
            $status = $statusOptions[array_rand($statusOptions)];
            $branch = $availableRewards->branch_id == $sitoluama->id ? $sitoluama : $balige;
            $admin = $branch->id == $sitoluama->id ? $adminSitoluama : $adminBalige;
            
            $redemption = Redemption::create([
                'user_id' => $user->id,
                'points_spent' => $availableRewards->points_cost,
                'status' => $status,
                'created_at' => now()->subDays(rand(1, 20)),
                'updated_at' => in_array($status, ['confirmed', 'completed']) ? now()->subDays(rand(1, 15)) : now()->subDays(rand(1, 20)),
            ]);

            // Buat redemption item
            RedemptionItem::create([
                'redemption_id' => $redemption->id,
                'reward_item_id' => $availableRewards->id,
                'quantity' => 1,
                'points' => $availableRewards->points_cost,
            ]);

            // Kurangi poin user dan stok reward jika confirmed atau completed
            if (in_array($status, ['confirmed', 'completed'])) {
                // Catat pengurangan poin
                $currentBalance = PointsLedger::where('user_id', $user->id)->sum('points');
                PointsLedger::create([
                    'user_id' => $user->id,
                    'type' => 'redemption',
                    'points' => -$availableRewards->points_cost,
                    'balance' => $currentBalance - $availableRewards->points_cost,
                    'description' => "Penukaran {$availableRewards->name}",
                    'redemption_id' => $redemption->id,
                    'created_at' => $redemption->updated_at,
                    'updated_at' => $redemption->updated_at,
                ]);

                // Kurangi stok
                $availableRewards->decrement('stock', 1);
                
                // Update points userData untuk iterasi berikutnya
                $userData['points'] -= $availableRewards->points_cost;
            }
        }

        $this->info('Redemptions created successfully!');
        
        // 8. UPDATE BALANCE_POINTS untuk semua user
        $this->info('Updating user balances...');
        
        foreach ($warga as $user) {
            // Hitung total balance dari PointsLedger
            $latestBalance = PointsLedger::where('user_id', $user->id)
                ->orderBy('created_at', 'desc')
                ->first();
            
            if ($latestBalance) {
                $user->update(['balance_points' => $latestBalance->balance]);
                $this->info("- {$user->name}: " . number_format($latestBalance->balance) . " poin");
            } else {
                $user->update(['balance_points' => 0]);
                $this->info("- {$user->name}: 0 poin");
            }
        }
        
        $this->info('=====================================================');
        $this->info('REALISTIC DATA SEEDING COMPLETED!');
        $this->info('=====================================================');
        $this->info('Branches: 2 (Sitoluama, Balige)');
        $this->info('Admins: 2');
        $this->info('Users (Warga): 8');
        $this->info('Waste Types: 6');
        $this->info('Reward Items: 6');
        $this->info('Deposits: 20');
        $this->info('Redemptions: 10');
        $this->info('=====================================================');
        $this->info('Login credentials:');
        $this->info('Admin Sitoluama: admin.sitoluama@greensaving.com / password');
        $this->info('Admin Balige: admin.balige@greensaving.com / password');
        $this->info('All users: password');
        $this->info('=====================================================');
    }

    private function info($message)
    {
        echo $message . "\n";
    }
}
