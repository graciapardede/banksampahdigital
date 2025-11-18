<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Deposit;
use App\Models\DepositItem;
use App\Models\User;
use App\Models\Branch;
use App\Models\WasteType;
use App\Models\PointLedger;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DepositController extends Controller
{
    /**
     * Tampilkan semua setoran (dari semua user)
     */
    public function index(Request $request)
    {
        $query = Deposit::with(['user', 'branch', 'items.wasteType'])
            ->latest();

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

        $deposits = $query->paginate(20);

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

        $users = User::where('role', User::ROLE_WARGA)
            ->orderBy('name')
            ->get();
        $wasteTypes = WasteType::orderBy('name')->get();

        return view('admin.setoran.create', compact('users', 'wasteTypes', 'adminBranch', 'adminBranchId'));
    }

    /**
     * Simpan setoran baru (admin membuat untuk user tertentu)
     */
    public function store(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'items' => 'required|array|min:1',
            'items.*.waste_type_id' => 'required|exists:waste_types,id',
            'items.*.weight' => 'required|numeric|min:0.1',
        ]);

        // Ambil branch_id dari admin yang sedang login
        $adminBranchId = auth()->user()->branch_id;

        DB::beginTransaction();
        try {
            // Buat deposit dengan status verified langsung (admin yang input)
            $deposit = Deposit::create([
                'user_id' => $request->user_id,
                'branch_id' => $adminBranchId, // Otomatis dari admin
                'status' => 'verified', // Langsung verified karena admin yang input
                'total_points' => 0, // akan dihitung
            ]);

            // Simpan items dan hitung poin langsung
            $totalPoints = 0;
            foreach ($request->items as $item) {
                $wasteType = WasteType::find($item['waste_type_id']);
                $points = $wasteType->points_per_kg * $item['weight'];
                $totalPoints += $points;

                DepositItem::create([
                    'deposit_id' => $deposit->id,
                    'waste_type_id' => $item['waste_type_id'],
                    'weight' => $item['weight'],
                    'points' => $points,
                ]);
            }

            // Update total points di deposit
            $deposit->update(['total_points' => $totalPoints]);

            // Tambahkan poin ke user
            $user = User::find($request->user_id);
            $user->increment('balance_points', $totalPoints);

            // Catat di point ledger
            PointLedger::create([
                'user_id' => $request->user_id,
                'deposit_id' => $deposit->id,
                'type' => 'credit',
                'amount' => $totalPoints,
                'balance_after' => $user->balance_points,
                'description' => 'Poin dari setoran sampah',
            ]);

            DB::commit();

            return redirect()->route('admin.setoran.index')
                ->with('success', "Setoran berhasil disimpan! Warga mendapatkan {$totalPoints} poin.");
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withInput()
                ->with('error', 'Gagal membuat setoran: ' . $e->getMessage());
        }
    }

    /**
     * Konfirmasi setoran -> hitung poin dan tambahkan ke saldo user
     */
    public function confirm(Request $request, $id)
    {
        $deposit = Deposit::with('items.wasteType', 'user')->findOrFail($id);

        if ($deposit->status !== 'pending') {
            return back()->with('error', 'Setoran sudah dikonfirmasi sebelumnya.');
        }

        DB::beginTransaction();
        try {
            $totalPoints = 0;

            // Hitung poin untuk setiap item
            foreach ($deposit->items as $item) {
                $wasteType = $item->wasteType;
                $points = wastePoints($item->weight, $wasteType->points_per_kg);
                
                // Update poin di deposit item
                $item->update(['points' => $points]);
                $totalPoints += $points;
            }

            // Update total poin deposit
            $deposit->update([
                'status' => 'confirmed',
                'total_points' => $totalPoints,
            ]);

            // Tambahkan poin ke saldo user
            $user = $deposit->user;
            $user->increment('balance_points', $totalPoints);

            // Catat di point ledger
            PointLedger::create([
                'user_id' => $user->id,
                'deposit_id' => $deposit->id,
                'type' => 'credit',
                'amount' => $totalPoints,
                'balance_after' => $user->balance_points,
                'description' => 'Poin dari setoran sampah',
            ]);

            DB::commit();

            return back()->with('success', "Setoran berhasil dikonfirmasi! {$totalPoints} poin telah ditambahkan ke {$user->full_name}.");
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Gagal mengkonfirmasi setoran: ' . $e->getMessage());
        }
    }

    /**
     * Tampilkan detail setoran
     */
    public function show($id)
    {
        $deposit = Deposit::with(['user', 'branch', 'items.wasteType'])
            ->findOrFail($id);

        return view('admin.setoran.show', compact('deposit'));
    }

    /**
     * Hapus setoran (hanya jika status masih pending)
     */
    public function destroy($id)
    {
        $deposit = Deposit::findOrFail($id);

        if ($deposit->status !== 'pending') {
            return back()->with('error', 'Tidak bisa menghapus setoran yang sudah dikonfirmasi.');
        }

        $deposit->delete();

        return redirect()->route('admin.setoran.index')
            ->with('success', 'Setoran berhasil dihapus.');
    }
}
