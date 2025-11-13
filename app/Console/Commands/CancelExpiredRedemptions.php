<?php

namespace App\Console\Commands;

use App\Models\Redemption;
use Carbon\Carbon;
use Illuminate\Console\Command;

class CancelExpiredRedemptions extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'redemptions:cancel-expired';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Batalkan penukaran yang sudah melewati batas waktu 24 jam';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Mencari penukaran yang sudah expired...');

        // Cari redemptions yang pending dan sudah expired
        $expiredRedemptions = Redemption::where('status', 'pending')
            ->where('expires_at', '<', Carbon::now())
            ->get();

        if ($expiredRedemptions->isEmpty()) {
            $this->info('Tidak ada penukaran yang expired.');
            return 0;
        }

        $count = 0;
        foreach ($expiredRedemptions as $redemption) {
            $redemption->update([
                'status' => 'cancelled',
                'rejection_reason' => 'Penukaran dibatalkan otomatis karena melewati batas waktu 24 jam.',
                'processed_at' => Carbon::now(),
            ]);
            
            $count++;
            $this->line("- Redemption #{$redemption->id} (User: {$redemption->user->full_name}) dibatalkan");
        }

        $this->info("✓ Total {$count} penukaran berhasil dibatalkan.");
        return 0;
    }
}
