<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\WasteType;

class WasteTypeSeeder extends Seeder
{
    /**
     * Seed data awal jenis sampah untuk Bank Sampah Indonesia
     * Data dirancang dengan sistem harga fleksibel:
     * - Harga tinggi = sampah terpilah dengan baik
     * - Harga rendah = sampah campur (mendorong warga untuk memilah)
     */
    public function run(): void
    {
        // Kosongkan tabel terlebih dahulu
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        WasteType::truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        $wasteTypes = [
            // ========================================
            // KATEGORI 1: PLASTIK
            // ========================================
            [
                'category' => 'Plastik',
                'name' => 'Botol Plastik Bening (PET) - Bersih',
                'unit' => 'kg',
                'points_per_unit' => 4000,
                'description' => 'Botol air mineral, botol teh, botol kecap yang sudah dicuci bersih. Harga premium untuk barang pilihan.',
            ],
            [
                'category' => 'Plastik',
                'name' => 'Gelas Plastik (Cup) - Bersih',
                'unit' => 'kg',
                'points_per_unit' => 2500,
                'description' => 'Gelas plastik bekas minuman, cup pudding, wadah makanan plastik yang bersih.',
            ],
            [
                'category' => 'Plastik',
                'name' => 'Tutup Botol (HDPE)',
                'unit' => 'kg',
                'points_per_unit' => 2500,
                'description' => 'Tutup botol plastik berbagai ukuran, bahan HDPE berkualitas baik.',
            ],
            [
                'category' => 'Plastik',
                'name' => 'Plastik Campur / Kresek / Ember',
                'unit' => 'kg',
                'points_per_unit' => 1000,
                'description' => 'Plastik tidak terpilah, kantong kresek, ember rusak, plastik berbagai jenis. Harga rendah untuk mendorong pemilahan.',
            ],

            // ========================================
            // KATEGORI 2: KERTAS
            // ========================================
            [
                'category' => 'Kertas',
                'name' => 'Kertas HVS / Buku Tulis (Putih)',
                'unit' => 'kg',
                'points_per_unit' => 2500,
                'description' => 'Kertas putih bekas fotokopi, buku tulis, kertas kantor. Kondisi kering dan bersih.',
            ],
            [
                'category' => 'Kertas',
                'name' => 'Kardus / Box (Kering)',
                'unit' => 'kg',
                'points_per_unit' => 1500,
                'description' => 'Kardus bekas kemasan, box paket, kardus tebal dalam kondisi kering (tidak basah).',
            ],
            [
                'category' => 'Kertas',
                'name' => 'Kertas Koran / Buram',
                'unit' => 'kg',
                'points_per_unit' => 1000,
                'description' => 'Koran bekas, kertas buram, majalah lama, kertas berwarna.',
            ],
            [
                'category' => 'Kertas',
                'name' => 'Kertas Campur / Nasi',
                'unit' => 'kg',
                'points_per_unit' => 500,
                'description' => 'Kertas campur berbagai jenis, kertas berminyak, kertas nasi. Harga terendah karena kualitas rendah.',
            ],

            // ========================================
            // KATEGORI 3: LOGAM
            // ========================================
            [
                'category' => 'Logam',
                'name' => 'Kaleng Aluminium (Minuman)',
                'unit' => 'kg',
                'points_per_unit' => 13000,
                'description' => 'Kaleng bekas minuman bersoda, bir, minuman energi. Aluminium berkualitas tinggi - HARGA TERTINGGI!',
            ],
            [
                'category' => 'Logam',
                'name' => 'Besi Tua / Padu',
                'unit' => 'kg',
                'points_per_unit' => 4000,
                'description' => 'Besi tua, paku, baut, rangka besi, logam tebal. Cocok untuk daur ulang konstruksi.',
            ],
            [
                'category' => 'Logam',
                'name' => 'Seng / Logam Tipis',
                'unit' => 'kg',
                'points_per_unit' => 1500,
                'description' => 'Seng bekas atap, kaleng cat, kaleng susu, logam tipis campur.',
            ],

            // ========================================
            // KATEGORI 4: KACA
            // ========================================
            [
                'category' => 'Kaca',
                'name' => 'Botol Kaca Bening (Kecap/Sirup)',
                'unit' => 'kg',
                'points_per_unit' => 400,
                'description' => 'Botol kaca bekas kecap, sirup, saus, minuman. Kondisi utuh lebih baik.',
            ],
            [
                'category' => 'Kaca',
                'name' => 'Pecahan Kaca Campur',
                'unit' => 'kg',
                'points_per_unit' => 100,
                'description' => 'Pecahan kaca berbagai jenis, kaca jendela rusak. Hati-hati saat menyetor!',
            ],

            // ========================================
            // KATEGORI 5: LAINNYA
            // ========================================
            [
                'category' => 'Lainnya',
                'name' => 'Minyak Jelantah',
                'unit' => 'liter',
                'points_per_unit' => 3000,
                'description' => 'Minyak goreng bekas yang sudah disaring. Bisa diolah menjadi sabun atau biodiesel.',
            ],
            [
                'category' => 'Lainnya',
                'name' => 'Elektronik Kecil (Rusak)',
                'unit' => 'pcs',
                'points_per_unit' => 5000,
                'description' => 'HP rusak, charger, kabel, mouse, keyboard rusak. Mengandung logam berharga yang bisa didaur ulang.',
            ],
        ];

        // Insert semua data sekaligus
        foreach ($wasteTypes as $wasteType) {
            WasteType::create($wasteType);
        }

        $this->command->info('✅ Berhasil memasukkan ' . count($wasteTypes) . ' jenis sampah ke database!');
        $this->command->info('📊 Kategori: Plastik (4), Kertas (4), Logam (3), Kaca (2), Lainnya (2)');
        $this->command->info('💰 Range harga: 100 - 13.000 poin per unit');
    }
}