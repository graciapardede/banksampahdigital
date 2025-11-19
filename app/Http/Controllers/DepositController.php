<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Deposit;
use App\Models\DepositItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DepositController extends Controller
{
    /**
     * Tampilkan riwayat setoran user (read-only)
     * User TIDAK bisa submit setoran sendiri - hanya admin yang bisa
     */
    public function index(Request $request)
    {
        $query = Deposit::with(['items.wasteType', 'branch'])
            ->where('user_id', Auth::id())
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

        $deposits = $query->get();

        return response()->json($deposits);
    }

    /**
     * Tampilkan detail setoran
     */
    public function show($id)
    {
        $deposit = Deposit::with(['items.wasteType', 'branch'])
            ->where('user_id', Auth::id())
            ->findOrFail($id);
            
        return response()->json($deposit);
    }
    
    /**
     * Tampilkan halaman riwayat (view)
     * 
     * CRITICAL: Data riwayat harus SELALU fresh dari database
     * untuk menampilkan status terbaru setelah Admin melakukan verifikasi.
     * 
     * Middleware 'no.cache' sudah diterapkan di route.
     * Query TIDAK menggunakan ->remember() atau Cache::get().
     */
    public function history(Request $request)
    {
        // Ambil user fresh dari database
        $user = Auth::user()->fresh();
        
        // Ambil semua transaksi (deposits + redemptions) - LANGSUNG dari database
        $deposits = Deposit::with(['depositItems.wasteType', 'branch'])
            ->where('user_id', $user->id);
        
        $redemptions = \App\Models\Redemption::with(['items.rewardItem', 'branch'])
            ->where('user_id', $user->id);
        
        // Filter by type
        $type = $request->get('type');
        
        // Filter by status
        if ($request->has('status') && $request->status != '') {
            $deposits->where('status', $request->status);
            $redemptions->where('status', $request->status);
        }
        
        // Filter by month
        if ($request->has('month') && $request->month != '') {
            $month = $request->month; // Format: YYYY-MM
            $deposits->whereYear('created_at', substr($month, 0, 4))
                     ->whereMonth('created_at', substr($month, 5, 2));
            $redemptions->whereYear('created_at', substr($month, 0, 4))
                        ->whereMonth('created_at', substr($month, 5, 2));
        }
        
        // Ambil data berdasarkan type filter
        $transactions = collect();
        
        if (!$type || $type === 'deposit') {
            $depositData = $deposits->get()->map(function ($deposit) {
                return [
                    'id' => $deposit->id,
                    'type' => 'deposit',
                    'title' => 'Setor Sampah',
                    'description' => $deposit->depositItems->map(function ($item) {
                        return $item->wasteType->name . ' (' . $item->weight . ' kg)';
                    })->join(', '),
                    'date' => $deposit->created_at,
                    'points' => $deposit->total_points,
                    'status' => $deposit->status,
                    'weight' => $deposit->total_weight,
                ];
            });
            $transactions = $transactions->merge($depositData);
        }
        
        if (!$type || $type === 'redemption') {
            $redemptionData = $redemptions->get()->map(function ($redemption) {
                return [
                    'id' => $redemption->id,
                    'type' => 'redemption',
                    'title' => 'Tukar Poin',
                    'description' => $redemption->items->map(function ($item) {
                        return $item->rewardItem->name . ' (x' . $item->quantity . ')';
                    })->join(', '),
                    'date' => $redemption->created_at,
                    'points' => -$redemption->total_points,
                    'status' => $redemption->status,
                ];
            });
            $transactions = $transactions->merge($redemptionData);
        }
        
        // Sort by date descending
        $transactions = $transactions->sortByDesc('date')->take(50);
        
        return view('riwayat', [
            'transactions' => $transactions,
            'userBalance' => $user->balance_points ?? 0,
        ]);
    }

    /**
     * Tampilkan detail transaksi (deposit atau redemption)
     */
    public function showDetail($id, $type)
    {
        $user = Auth::user();

        if ($type === 'deposit') {
            $transaction = Deposit::with(['depositItems.wasteType', 'branch', 'user'])
                ->where('user_id', $user->id)
                ->findOrFail($id);
        } elseif ($type === 'redemption') {
            $transaction = \App\Models\Redemption::with(['items.rewardItem', 'redemptionItems.rewardItem', 'branch', 'user'])
                ->where('user_id', $user->id)
                ->findOrFail($id);
        } else {
            abort(404);
        }

        return view('riwayat-detail', [
            'transaction' => $transaction,
            'type' => $type,
        ]);
    }
}
