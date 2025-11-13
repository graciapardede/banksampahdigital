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
     */
    public function history()
    {
        return view('riwayat');
    }
}
