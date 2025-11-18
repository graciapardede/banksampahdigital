<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Redemption;
use App\Models\RedemptionItem;
use App\Models\RewardItem;
use App\Models\PointLedger;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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
    public function create()
    {
        return view('tukar-poin');
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

        // Hitung total poin yang dibutuhkan
        foreach ($request->items as $item) {
            $reward = RewardItem::findOrFail($item['reward_item_id']);
            $totalPoints += $reward->points_cost * $item['quantity'];
            
            // Cek stok
            if ($reward->stock < $item['quantity']) {
                return response()->json([
                    'message' => "Stok {$reward->name} tidak mencukupi. Stok tersedia: {$reward->stock}"
                ], 400);
            }
        }

        if ($user->balance_points < $totalPoints) {
            return response()->json(['message' => 'Poin tidak cukup'], 400);
        }

        $redemption = Redemption::create([
            'user_id' => $user->id,
            'branch_id' => $request->branch_id,
            'status' => 'pending',
            'total_points' => $totalPoints,
            'expires_at' => now()->addHours(24), // Kadaluarsa 24 jam dari sekarang
        ]);

        foreach ($request->items as $item) {
            RedemptionItem::create([
                'redemption_id' => $redemption->id,
                'reward_item_id' => $item['reward_item_id'],
                'quantity' => $item['quantity'],
                'points' => RewardItem::find($item['reward_item_id'])->points_cost,
            ]);
        }

        return response()->json([
            'message' => 'Penukaran berhasil diajukan. Menunggu konfirmasi admin dalam 24 jam.',
            'redemption_id' => $redemption->id,
            'expires_at' => $redemption->expires_at->format('Y-m-d H:i:s'),
        ], 201);
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
