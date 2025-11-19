<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Deposit;
use App\Models\DepositItem;
use App\Models\User;
use App\Models\Branch;
use App\Models\WasteType;
use App\Models\PointLedger;
use App\Notifications\SetoranDiverifikasi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DepositController extends Controller
{
    /**
     * Tampilkan semua setoran (filter by branch untuk admin cabang)
     */
    public function index(Request $request)
    {
        $user = auth()->user();
        
        // Start query dengan eager loading
        $query = Deposit::with(['user', 'branch', 'depositItems.wasteType']);
        
        // FILTER BY BRANCH: Admin cabang hanya lihat setoran di cabangnya
        // Superadmin atau admin tanpa branch_id bisa lihat semua
        if ($user->branch_id) {
            $query->where('branch_id', $user->branch_id);
        }
        
        // Filter by status
        if ($request->has('status') && $request->status != '') {
            $query->where('status', $request->status);
        }

        // Filter by date range
        if ($request->has('date_from') && $request->date_from != '') {
            $query->whereDate('created_at', '>=', $request->date_from);
        }
        if ($request->has('date_to') && $request->date_to != '') {
            $query->whereDate('created_at', '<=', $request->date_to);
        }

        $deposits = $query->latest()->paginate(20);

        return view('admin.setoran.index', compact('deposits'));
    }

    /**
     * Form untuk membuat setoran untuk user
     */
    public function create()
    {
        // Ambil branch_id dari admin yang sedang login
        $adminBranchId = auth()->user()->branch_id;
        $adminBranch = auth()->user()->branch;

        // Ambil semua user dengan role 'user' atau 'warga' (tanpa filter branch_id)
        // Warga bebas menyetor di cabang mana saja
        $users = User::whereIn('role', ['user', 'warga'])
            ->orderBy('name', 'asc')
            ->get(['id', 'name', 'phone', 'email']);
        
        $wasteTypes = WasteType::orderBy('name')->get();

        return view('admin.setoran.create', compact('users', 'wasteTypes', 'adminBranch', 'adminBranchId'));
    }

    /**
     * Simpan setoran baru (admin membuat untuk user tertentu)
     * 
     * ✅ ONE-CLICK VERIFICATION FLOW:
     * Saat Admin menekan "Simpan Setoran", transaksi langsung:
     * 1. Dihitung total poinnya
     * 2. Disimpan ke database dengan status 'verified'
     * 3. Poin langsung masuk ke saldo warga
     * 4. Point ledger dicatat
     * 5. Notifikasi dikirim ke warga
     * 
     * TIDAK ADA ANTRIAN "Pending Review" - Admin UX lebih cepat!
     */
    public function store(Request $request)
    {
        // Validasi input
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'items' => 'required|array|min:1',
            'items.*.waste_type_id' => 'required|exists:waste_types,id',
            'items.*.weight' => 'required|numeric|min:0.1',
        ], [
            'user_id.required' => 'Pilih warga terlebih dahulu',
            'items.required' => 'Tambahkan minimal 1 jenis sampah',
            'items.*.weight.min' => 'Berat minimal 0.1 kg',
        ]);

        // Ambil branch_id dari admin yang sedang login
        $adminBranchId = auth()->user()->branch_id;

        // ATOMIC TRANSACTION: Semua berhasil atau semua gagal
        DB::beginTransaction();
        try {
            // ============================================================
            // STEP 1: BUAT DEPOSIT HEADER
            // Status langsung 'verified' (bukan 'pending')
            // ============================================================
            $deposit = Deposit::create([
                'user_id' => $request->user_id,
                'branch_id' => $adminBranchId,
                'status' => 'verified', // ✅ ONE-CLICK: Langsung verified!
                'total_points' => 0, // Akan diupdate setelah loop
            ]);

            // ============================================================
            // STEP 2: LOOPING ITEMS & HITUNG GRAND TOTAL
            // ============================================================
            $grandTotal = 0;
            
            foreach ($request->items as $item) {
                // Ambil data waste type untuk mendapatkan points_per_unit
                $wasteType = WasteType::findOrFail($item['waste_type_id']);
                
                // Hitung subtotal: berat × poin per unit
                $weight = floatval($item['weight']);
                $pointsPerUnit = floatval($wasteType->points_per_unit);
                $subtotal = $weight * $pointsPerUnit;
                
                // Tambahkan ke grand total
                $grandTotal += $subtotal;

                // Simpan deposit item dengan poin yang sudah dihitung
                DepositItem::create([
                    'deposit_id' => $deposit->id,
                    'waste_type_id' => $item['waste_type_id'],
                    'weight' => $weight,
                    'points' => $subtotal, // Poin per item
                ]);
            }

            // ============================================================
            // STEP 3: UPDATE TOTAL POINTS DI DEPOSIT HEADER
            // ============================================================
            $deposit->update(['total_points' => $grandTotal]);

            // ============================================================
            // STEP 4: UPDATE SALDO USER (TAMBAH POIN)
            // ✅ ONE-CLICK: Poin langsung masuk ke saldo warga!
            // ============================================================
            $user = User::findOrFail($request->user_id);
            $user->increment('balance_points', $grandTotal);
            
            // Refresh untuk mendapatkan balance_points terbaru setelah increment
            $user->refresh();

            // ============================================================
            // STEP 5: CATAT DI POINT LEDGER (AUDIT TRAIL)
            // ✅ Type 'credit' = Penambahan poin
            // ============================================================
            PointLedger::create([
                'user_id' => $request->user_id,
                'deposit_id' => $deposit->id,
                'type' => 'credit',
                'amount' => $grandTotal,
                'balance_after' => $user->balance_points,
                'description' => 'Poin dari setoran sampah (verified by admin)',
            ]);

            // ============================================================
            // STEP 6: KIRIM NOTIFIKASI KE USER
            // ✅ Warga langsung dapat notif "Setoran Diverifikasi"
            // ============================================================
            $user->notify(new SetoranDiverifikasi($deposit));

            // Commit transaksi jika semua berhasil
            DB::commit();

            // Redirect ke index dengan pesan sukses
            return redirect()->route('admin.setoran.index')
                ->with('success', "✅ Setoran berhasil disimpan dan diverifikasi! Warga {$user->name} mendapatkan " . number_format($grandTotal, 0, ',', '.') . " poin.");
                
        } catch (\Exception $e) {
            // Rollback jika ada error
            DB::rollBack();
            
            // Log error untuk debugging
            \Log::error('Error saat menyimpan setoran: ' . $e->getMessage(), [
                'user_id' => $request->user_id,
                'items' => $request->items,
                'trace' => $e->getTraceAsString()
            ]);
            
            return back()->withInput()
                ->with('error', '❌ Gagal menyimpan setoran: ' . $e->getMessage());
        }
    }

    // ============================================================
    // ❌ METHOD confirm() REMOVED (LEGACY CODE)
    // ============================================================
    //
    // CONTEXT: Sebelum One-Click Verification, workflow lama adalah:
    // 1. Admin create deposit → status 'pending'
    // 2. Admin review & klik "Verifikasi" → status 'confirmed'
    // 3. Poin baru masuk setelah step 2
    //
    // ✅ SEKARANG ONE-CLICK VERIFICATION (Store Method):
    // 1. Admin create deposit → langsung status 'verified'
    // 2. Poin langsung masuk ke saldo warga
    // 3. Notification langsung terkirim
    // 4. TIDAK ADA pending review queue lagi
    //
    // Method confirm() tidak diperlukan lagi karena:
    // - Semua deposits langsung verified saat dibuat
    // - Tidak ada button "Verifikasi" di UI
    // - Route confirm sudah di-comment di routes/web.php
    //
    // Jika di masa depan perlu workflow "pending review",
    // bisa restore method ini dari git history.
    // ============================================================

    /**
     * Tampilkan detail setoran
     */
    public function show($id)
    {
        $deposit = Deposit::with(['user', 'branch', 'depositItems.wasteType'])
            ->findOrFail($id);

        return view('admin.setoran.show', compact('deposit'));
    }

    /**
     * Hapus setoran
     * 
     * ⚠️ CATATAN ONE-CLICK VERIFICATION:
     * Karena semua deposits langsung verified (tidak ada pending),
     * maka penghapusan deposits perlu extra hati-hati karena:
     * - Poin sudah masuk ke saldo warga
     * - Point ledger sudah tercatat
     * - Notification sudah terkirim
     * 
     * REKOMENDASI: Jangan hapus deposit verified, gunakan "soft delete" atau
     * buat fitur "Cancel" yang melakukan rollback (debit poin, reverse ledger)
     */
    public function destroy($id)
    {
        $deposit = Deposit::findOrFail($id);

        // Cek apakah deposit sudah verified
        if ($deposit->status === 'verified') {
            return back()->with('error', '⚠️ Tidak bisa menghapus setoran yang sudah diverifikasi. Poin sudah masuk ke saldo warga. Gunakan fitur Cancel/Rollback jika ingin membatalkan transaksi.');
        }

        // Jika pending (seharusnya tidak ada dengan One-Click Verification)
        $deposit->delete();

        return redirect()->route('admin.setoran.index')
            ->with('success', 'Setoran berhasil dihapus.');
    }
}
