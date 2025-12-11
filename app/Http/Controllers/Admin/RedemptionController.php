<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Redemption;
use App\Models\RedemptionItem;
use App\Models\RewardItem;
use App\Models\PointLedger;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use App\Notifications\BarangSiapDiambil;
use App\Notifications\PenukaranBerhasil;
use App\Notifications\RedemptionRejected;

class RedemptionController extends Controller
{
    /**
     * Tampilkan semua penukaran (dari semua user)
     */
    public function index(Request $request)
    {
        // Get authenticated user's branch
        $user = auth()->user();
        $branchId = $user->branch_id;

        // Build main query with branch filter
        // Jika admin punya branch_id, filter sesuai branch
        // Jika tidak punya branch_id (superadmin), tampilkan semua
        $query = Redemption::with(['user', 'branch', 'redemptionItems.rewardItem'])
            ->when($branchId, function($q) use ($branchId) {
                // Tampilkan redemption yang branch_id-nya sama ATAU NULL (untuk backward compatibility)
                $q->where(function($query) use ($branchId) {
                    $query->where('branch_id', $branchId)
                          ->orWhereNull('branch_id');
                });
            });

        // Filter by status - jangan filter jika 'semua' atau kosong
        if ($request->has('status') && $request->status != '' && $request->status != 'semua') {
            $query->where('status', $request->status);
        }

        // Filter by month (format: Y-m, contoh: 2025-11)
        if ($request->has('bulan') && $request->bulan != '') {
            $bulanData = explode('-', $request->bulan); // ['2025', '11']
            if (count($bulanData) == 2) {
                $tahun = $bulanData[0];
                $bulan = $bulanData[1];
                $query->whereYear('created_at', $tahun)
                      ->whereMonth('created_at', $bulan);
            }
        }

        // Apply sorting and pagination
        $redemptions = $query->latest()->paginate(10)->appends($request->all());

        // Current month and year
        $currentMonth = now()->month;
        $currentYear = now()->year;

        // Calculate statistics for current month with branch filter
        // 1. Pending Count - transaksi menunggu konfirmasi
        $pendingCount = Redemption::when($branchId, function($q) use ($branchId) {
                $q->where(function($query) use ($branchId) {
                    $query->where('branch_id', $branchId)
                          ->orWhereNull('branch_id');
                });
            })
            ->where('status', 'pending')
            ->whereMonth('created_at', $currentMonth)
            ->whereYear('created_at', $currentYear)
            ->count();

        // 2. Confirmed Count - transaksi sudah dikonfirmasi, siap diambil
        $confirmedCount = Redemption::when($branchId, function($q) use ($branchId) {
                $q->where(function($query) use ($branchId) {
                    $query->where('branch_id', $branchId)
                          ->orWhereNull('branch_id');
                });
            })
            ->where('status', 'confirmed')
            ->whereMonth('created_at', $currentMonth)
            ->whereYear('created_at', $currentYear)
            ->count();

        // 3. Total Points - hanya transaksi yang sudah selesai (completed)
        $totalPoints = Redemption::when($branchId, function($q) use ($branchId) {
                $q->where(function($query) use ($branchId) {
                    $query->where('branch_id', $branchId)
                          ->orWhereNull('branch_id');
                });
            })
            ->where('status', 'completed')
            ->whereMonth('created_at', $currentMonth)
            ->whereYear('created_at', $currentYear)
            ->sum('total_points');

        // Backward compatibility variables
        $pending = $pendingCount;
        $confirmed = $confirmedCount;

        return view('admin.penukaran.index', compact('redemptions', 'pending', 'confirmed', 'totalPoints', 'pendingCount', 'confirmedCount'));
    }

    /**
     * Approve penukaran -> set expires_at 24 jam
     * Poin sudah dikurangi saat warga melakukan tukar poin (pending status)
     */
    public function approve(Request $request, $id)
    {
        $redemption = Redemption::with('items.rewardItem', 'user')->findOrFail($id);

        if ($redemption->status !== 'pending') {
            return back()->with('error', 'Penukaran sudah diproses sebelumnya.');
        }

        DB::beginTransaction();
        try {
            $user = $redemption->user;
            $totalPoints = $redemption->total_points;

            // Update status redemption ke 'confirmed' (barang siap diambil)
            // Set expires_at ke 24 jam dari sekarang untuk pengambilan
            $redemption->update([
                'status' => 'confirmed',
                'processed_at' => Carbon::now(),
                'expires_at' => Carbon::now()->addHours(24),
            ]);

            // KIRIM NOTIFIKASI KE USER: Barang siap diambil (dalam 24 jam)
            $user->notify(new BarangSiapDiambil($redemption));

            DB::commit();

            return back()->with('success', "Penukaran berhasil dikonfirmasi! Barang siap diambil dalam 24 jam. Poin {$user->full_name} telah dipotong {$totalPoints}.");
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Gagal menyetujui penukaran: ' . $e->getMessage());
        }
    }

    /**
     * Reject penukaran -> kembalikan stok + poin
     */
    public function reject(Request $request, $id)
    {
        $request->validate([
            'rejection_reason' => 'required|string|min:10',
        ], [
            'rejection_reason.required' => 'Alasan penolakan wajib diisi!',
            'rejection_reason.min' => 'Alasan penolakan minimal 10 karakter.',
        ]);

        $redemption = Redemption::with(['user', 'redemptionItems.rewardItem'])->findOrFail($id);

        if ($redemption->status !== 'pending') {
            return back()->with('error', 'Penukaran sudah diproses sebelumnya.');
        }

        DB::beginTransaction();
        try {
            $user = $redemption->user;
            $totalPoints = $redemption->total_points;

            // Kembalikan stok semua items
            foreach ($redemption->redemptionItems as $item) {
                $item->rewardItem->increment('stock', $item->quantity);
            }

            // KEMBALIKAN POIN KE USER (poin sudah dikurangi saat pending)
            $user->increment('balance_points', $totalPoints);

            // Catat reversal di point ledger
            \App\Models\PointLedger::create([
                'user_id' => $user->id,
                'type' => 'credit',
                'amount' => $totalPoints, // Amount = absolute value
                'balance_after' => $user->balance_points, // Balance setelah dikembalikan
                'description' => "Pengembalian poin (Penolakan) - Redemption ID: {$redemption->id}",
                'redemption_id' => $redemption->id,
            ]);

            // Update status redemption dengan alasan
            $redemption->update([
                'status' => 'rejected',
                'rejection_reason' => $request->rejection_reason,
                'processed_at' => Carbon::now(),
            ]);

            // Kirim notifikasi ke user tentang rejection
            $redemption->user->notify(new RedemptionRejected($redemption, $request->rejection_reason));

            // Poin tidak dikurangi saat pending, jadi tidak perlu dikembalikan
            // (Sesuai requirement: poin baru dikurangi saat approve)

            DB::commit();

            return back()->with('success', "Penukaran berhasil ditolak. Stok barang dan poin ({$totalPoints}) sudah dikembalikan ke user.");
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Gagal menolak penukaran: ' . $e->getMessage());
        }
    }

    /**
<<<<<<< HEAD
     * Batalkan/Tolak penukaran (sama-sama set status jadi rejected)
     * Bisa dipanggil dari cancel button atau reject form
=======
     * Batalkan penukaran yang sudah expired (lewat 24 jam setelah confirm)
>>>>>>> 276701dbcde6517b1b66e8631f27fb3d900290d9
     */
    public function cancel($id)
    {
        $redemption = Redemption::with('user')->findOrFail($id);

        if ($redemption->status !== 'confirmed') {
            return back()->with('error', 'Hanya penukaran yang sudah dikonfirmasi dan expired yang bisa dibatalkan.');
        }

        DB::beginTransaction();
        try {
<<<<<<< HEAD
            // Update status redemption ke rejected (sama seperti reject)
            $redemption->update([
                'status' => 'rejected',
                'rejection_reason' => 'Penukaran dibatalkan karena melewati batas waktu 24 jam.',
=======
            $user = $redemption->user;
            $totalPoints = $redemption->total_points;

            // KEMBALIKAN POIN KE USER (poin sudah dikurangi saat pending)
            $user->increment('balance_points', $totalPoints);

            // Catat reversal di point ledger
            \App\Models\PointLedger::create([
                'user_id' => $user->id,
                'type' => 'credit',
                'amount' => $totalPoints, // Amount = absolute value
                'balance_after' => $user->balance_points, // Balance setelah dikembalikan
                'description' => "Pengembalian poin (Expired 24 jam) - Redemption ID: {$redemption->id}",
                'redemption_id' => $redemption->id,
            ]);

            // Update status redemption
            $redemption->update([
                'status' => 'cancelled',
                'rejection_reason' => 'Penukaran dibatalkan karena melewati batas waktu 24 jam pengambilan barang.',
>>>>>>> 276701dbcde6517b1b66e8631f27fb3d900290d9
                'processed_at' => Carbon::now(),
            ]);

            // Kirim notifikasi ke user
<<<<<<< HEAD
            $redemption->user->notify(new RedemptionRejected($redemption, 'Penukaran dibatalkan karena melewati batas waktu 24 jam.'));

            // Poin tidak dikurangi saat pending, jadi tidak perlu dikembalikan

            DB::commit();

            return back()->with('success', 'Penukaran berhasil dibatalkan.');
=======
            $user->notify(new \App\Notifications\PenolakanTukarPoin($redemption));

            DB::commit();

            return back()->with('success', "Penukaran expired berhasil dibatalkan. Poin ({$totalPoints}) sudah dikembalikan ke user.");
>>>>>>> 276701dbcde6517b1b66e8631f27fb3d900290d9
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Gagal membatalkan penukaran: ' . $e->getMessage());
        }
    }

    /**
     * Tampilkan detail penukaran
     */
    public function show($id)
    {
        $redemption = Redemption::with(['user', 'branch', 'redemptionItems.rewardItem'])
            ->findOrFail($id);

        return view('admin.penukaran.show', compact('redemption'));
    }
    /**
     * Mark redemption as completed (barang sudah diserahkan ke user)
     */
    public function complete($id)
    {
        $redemption = Redemption::with('user', 'items')->findOrFail($id);

        if ($redemption->status !== 'confirmed') {
            return back()->with('error', 'Hanya penukaran dengan status "Dikonfirmasi" yang bisa diserahkan.');
        }

        DB::beginTransaction();
        try {
            // Update status ke completed
            $redemption->update([
                'status' => 'completed',
            ]);

            // KIRIM NOTIFIKASI KE USER: Penukaran selesai (barang sudah diserahkan)
            $redemption->user->notify(new PenukaranBerhasil($redemption));

            DB::commit();

            return back()->with('success', 'Penukaran berhasil diserahkan! Status diubah menjadi Selesai.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Gagal menandai penukaran sebagai selesai: ' . $e->getMessage());
        }
    }
}