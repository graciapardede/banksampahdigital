<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Redemption;
use App\Models\RedemptionItem;
use App\Models\RewardItem;
use App\Models\PointLedger;
use App\Notifications\PenukaranBerhasil;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class RedemptionController extends Controller
{
    public function index()
    {
        $redemptions = Redemption::with('items.rewardItem')
            ->where('user_id', Auth::id())
            ->latest()
            ->get();

        return response()->json($redemptions);
    }
    
    /**
     * Show the form for creating a new redemption (tukar poin page)
     */
    public function create(Request $request)
    {
        // Ambil cabang yang dipilih dari request (tidak auto-select)
        $selectedBranch = $request->input('branch_id');
        
        // Ambil daftar reward sesuai cabang terpilih
        // Jika tidak ada cabang dipilih, tampilkan semua barang yang ada stok
        if ($selectedBranch) {
            $rewardItems = RewardItem::where('branch_id', $selectedBranch)
                ->where('stock', '>', 0)
                ->orderBy('name')
                ->get();
        } else {
            $rewardItems = RewardItem::where('stock', '>', 0)
                ->orderBy('name')
                ->get();
        }
        
        // Ambil semua cabang untuk dropdown
        $branches = \App\Models\Branch::orderBy('name')->get();
        
        return view('tukar-poin', [
            'rewardItems' => $rewardItems,
            'branches' => $branches,
            'selectedBranch' => $selectedBranch
        ]);
    }

    // Simpan penukaran poin
    public function store(Request $request)
    {
        $request->validate([
            'branch_id' => 'required|exists:branches,id',
            'items' => 'required|array|min:1',
            'items.*.reward_item_id' => 'required|exists:reward_items,id',
            'items.*.quantity' => 'required|numeric|min:1',
        ]);

        $user = Auth::user();
        $totalPoints = 0;

        // Hitung total poin yang dibutuhkan dan validasi cabang
        foreach ($request->items as $item) {
            $reward = RewardItem::findOrFail($item['reward_item_id']);
            
            // VALIDASI: Pastikan barang berasal dari cabang terpilih
            if ($reward->branch_id != $request->branch_id) {
                return response()->json([
                    'message' => "Barang {$reward->name} bukan dari cabang terpilih. Silakan pilih barang dari cabang yang sesuai."
                ], 400);
            }
            
            $totalPoints += $reward->points_cost * $item['quantity'];
            
            // Cek stok
            if ($reward->stock < $item['quantity']) {
                return response()->json([
                    'message' => "Stok {$reward->name} tidak mencukupi. Stok tersedia: {$reward->stock}"
                ], 400);
            }
        }

        // VALIDASI: Cek apakah user punya poin cukup
        if ($user->balance_points < $totalPoints) {
            return response()->json([
                'message' => "Poin tidak cukup. Anda memiliki {$user->balance_points} poin, membutuhkan {$totalPoints} poin."
            ], 400);
        }

        // Buat transaksi redemption dengan status MENUNGGU
        $redemption = Redemption::create([
            'user_id' => $user->id,
            'branch_id' => $request->branch_id,
            'status' => 'MENUNGGU',
            'total_points' => $totalPoints,
            'expires_at' => now()->addHours(24), // Kadaluarsa 24 jam dari sekarang
        ]);

        DB::beginTransaction();
        try {
            // Simpan item redemption dan kurangi stok
            foreach ($request->items as $item) {
                $reward = RewardItem::find($item['reward_item_id']);
                
                RedemptionItem::create([
                    'redemption_id' => $redemption->id,
                    'reward_item_id' => $item['reward_item_id'],
                    'quantity' => $item['quantity'],
                    'points' => $reward->points_cost,
                ]);
                
                // KURANGI STOK sesuai jumlah
                $reward->decrement('stock', $item['quantity']);
            }

            // KURANGI POIN USER
            $user->decrement('balance_points', $totalPoints);

            // Catat di point ledger
            PointLedger::create([
                'user_id' => $user->id,
                'redemption_id' => $redemption->id,
                'type' => 'debit',
                'amount' => $totalPoints,
                'balance_after' => $user->balance_points,
                'description' => 'Penukaran poin untuk hadiah',
            ]);

            // Kirim notifikasi ke user
            $user->notify(new PenukaranBerhasil($redemption));

            DB::commit();

            return response()->json([
                'message' => 'Penukaran berhasil diajukan. Menunggu konfirmasi admin dalam 24 jam.',
                'redemption_id' => $redemption->id,
                'expires_at' => $redemption->expires_at->format('Y-m-d H:i:s'),
            ], 201);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'message' => 'Gagal memproses penukaran: ' . $e->getMessage()
            ], 500);
        }
    }

    public function show($id)
    {
        $redemption = Redemption::with('items.rewardItem')->findOrFail($id);
        return response()->json($redemption);
    }
    
    /**
     * Cancel a redemption (before admin approval)
     */
    public function cancel($id)
    {
        $redemption = Redemption::where('user_id', Auth::id())
            ->where('id', $id)
            ->firstOrFail();
            
        if ($redemption->status !== 'pending') {
            return response()->json([
                'message' => 'Hanya penukaran dengan status pending yang bisa dibatalkan'
            ], 400);
        }
        
        $redemption->update([
            'status' => 'cancelled'
        ]);
        
        return response()->json([
            'message' => 'Penukaran berhasil dibatalkan'
        ]);
    }
}
