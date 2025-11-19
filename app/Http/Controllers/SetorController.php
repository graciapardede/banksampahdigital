<?php

namespace App\Http\Controllers;

use App\Models\WasteType;
use App\Models\Deposit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SetorController extends Controller
{
    /**
     * Tampilkan halaman setor sampah (informasi & panduan untuk warga)
     * Warga TIDAK BISA setor sendiri, hanya lihat info harga & riwayat
     */
    public function index()
    {
        // Ambil semua jenis sampah dari database
        $wasteTypes = WasteType::orderBy('points_per_unit', 'desc')->get();
        
        // Ambil riwayat setoran user yang sedang login
        $deposits = Deposit::with(['depositItems.wasteType', 'branch'])
            ->where('user_id', Auth::id())
            ->latest()
            ->take(10)
            ->get();
        
        return view('setor', compact('wasteTypes', 'deposits'));
    }
}
