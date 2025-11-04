<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Deposit;
use App\Models\DepositItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DepositController extends Controller
{
    public function index()
    {
        $deposits = Deposit::with('items.wasteType')
            ->where('user_id', Auth::id())
            ->latest()
            ->get();

        return response()->json($deposits);
    }

    // Simpan setoran baru
    public function store(Request $request)
    {
        $request->validate([
            'branch_id' => 'required|exists:branches,id',
            'items' => 'required|array|min:1',
            'items.*.waste_type_id' => 'required|exists:waste_types,id',
            'items.*.weight' => 'required|numeric|min:0.1',
        ]);

        $totalPoints = 0;

        $deposit = Deposit::create([
            'user_id' => Auth::id(),
            'branch_id' => $request->branch_id,
            'status' => 'pending',
        ]);

        foreach ($request->items as $item) {
            $points = $item['weight'] * wastePoints($item['waste_type_id']); // helper function
            $totalPoints += $points;

            DepositItem::create([
                'deposit_id' => $deposit->id,
                'waste_type_id' => $item['waste_type_id'],
                'weight' => $item['weight'],
                'points' => $points,
            ]);
        }

        $deposit->update(['total_points' => $totalPoints]);

        return response()->json([
            'message' => 'Setoran berhasil dibuat, menunggu verifikasi admin.',
            'deposit_id' => $deposit->id,
        ], 201);
    }

    public function show($id)
    {
        $deposit = Deposit::with('items.wasteType')->findOrFail($id);
        return response()->json($deposit);
    }
}
