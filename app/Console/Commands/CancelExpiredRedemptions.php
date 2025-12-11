<?php

namespace App\Console\Commands;

use App\Models\Redemption;
use App\Models\PointLedger;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

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
    protected $description = 'Batalkan penukaran yang sudah melewati batas waktu 24 jam dan kembalikan poin ke user';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        try {
            $this->info('🔍 Mencari penukaran yang sudah expired...');

            // Cari redemptions yang confirmed dan sudah expired (lewat 24 jam)
            $expiredRedemptions = Redemption::where('status', 'confirmed')
                ->where('expires_at', '<=', Carbon::now())
                ->with('user')
                ->get();

            if ($expiredRedemptions->isEmpty()) {
                $this->info('✅ Tidak ada penukaran yang expired.');
                return self::SUCCESS;
            }

            $this->info('Found ' . $expiredRedemptions->count() . ' expired redemptions. Processing...');

            DB::beginTransaction();

            $totalPointsReturned = 0;

            foreach ($expiredRedemptions as $redemption) {
                try {
                    $user = $redemption->user;
                    $totalPoints = $redemption->total_points;

                    // RETURN POINTS TO USER (poin sudah dikurangi saat pending)
                    $user->increment('balance_points', $totalPoints);
                    $totalPointsReturned += $totalPoints;

                    // Record refund in point ledger
                    PointLedger::create([
                        'user_id' => $user->id,
                        'type' => 'credit',
                        'amount' => $totalPoints, // Amount = absolute value
                        'balance_after' => $user->balance_points, // Balance after refund
                        'description' => "Pengembalian poin (Expired 24 jam) - Redemption ID: {$redemption->id}",
                        'redemption_id' => $redemption->id,
                    ]);

                    // Update redemption status
                    $redemption->update([
                        'status' => 'cancelled',
                        'rejection_reason' => 'Penukaran dibatalkan otomatis karena melewati batas waktu 24 jam pengambilan barang.',
                        'processed_at' => Carbon::now(),
                    ]);

                    // SEND NOTIFICATION TO USER
                    $user->notify(new \App\Notifications\PenolakanTukarPoin($redemption));

                    $this->line("✅ Redemption #{$redemption->id} - User: {$user->name} - Poin dikembalikan: {$totalPoints}");
                } catch (\Exception $e) {
                    $this->error("❌ Error processing Redemption #{$redemption->id}: " . $e->getMessage());
                    throw $e; // Rollback transaction
                }
            }

            DB::commit();

            $this->info("✅ Total {$expiredRedemptions->count()} penukaran berhasil dibatalkan.");
            $this->info("✅ Total {$totalPointsReturned} poin berhasil dikembalikan ke user.");
            return self::SUCCESS;
        } catch (\Exception $e) {
            DB::rollBack();
            $this->error("❌ Error: " . $e->getMessage());
            return self::FAILURE;
        }
    }
}

