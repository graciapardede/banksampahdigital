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
        }

        if ($user->balance_points < $totalPoints) {
            return response()->json(['message' => 'Poin tidak cukup'], 400);
        }

        $redemption = Redemption::create([
            'user_id' => $user->id,
            'branch_id' => $request->branch_id,
            'status' => 'pending',
            'total_points' => $totalPoints,
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
            'message' => 'Penukaran berhasil diajukan. Menunggu konfirmasi admin.',
            'redemption_id' => $redemption->id,
        ], 201);
    }

    public function show($id)
    {
        $redemption = Redemption::with('items.rewardItem')->findOrFail($id);
        return response()->json($redemption);
    }
}
