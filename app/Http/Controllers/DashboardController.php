<?php

namespace App\Http\Controllers;

use App\Models\Deposit;
use App\Models\Redemption;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    /**
     * Dashboard untuk user warga
     * 
     * CRITICAL: Data ini harus SELALU fresh dari database (NO CACHING)
     * untuk menghindari bug "Stale Data" dimana Admin sudah verifikasi setoran
     * tapi Warga masih melihat status lama.
     * 
     * Middleware 'no.cache' sudah diterapkan di route untuk mencegah browser caching.
     * Query di sini TIDAK menggunakan ->remember() atau Cache::get().
     */
    public function index()
    {
        // Ambil user fresh dari database (bypass model cache jika ada)
        $user = Auth::user()->fresh();

        // Total poin - ambil langsung dari DB, bukan dari cache
        $totalPoints = $user->balance_points;

        // Recent deposits (5 terakhir) - LANGSUNG dari database
        // TIDAK menggunakan ->remember() atau ->cache()
        $recentDeposits = Deposit::with(['depositItems.wasteType', 'branch'])
            ->where('user_id', $user->id)
            ->latest()
            ->take(5)
            ->get();

        // Recent redemptions (5 terakhir) - LANGSUNG dari database
        $recentRedemptions = Redemption::with(['redemptionItems.rewardItem', 'branch'])
            ->where('user_id', $user->id)
            ->latest()
            ->take(5)
            ->get();

        // Count statistik - LANGSUNG dari database
        $stats = [
            'total_deposits' => Deposit::where('user_id', $user->id)->count(),
            'total_redemptions' => Redemption::where('user_id', $user->id)->count(),
            'pending_redemptions' => Redemption::where('user_id', $user->id)
                ->where('status', 'pending')
                ->count(),
        ];

        return view('dashboard', compact('user', 'totalPoints', 'recentDeposits', 'recentRedemptions', 'stats'));
    }

    /**
     * API endpoint untuk dashboard data
     * 
     * CRITICAL: API ini harus return data FRESH dari database
     * Digunakan untuk AJAX refresh tanpa reload halaman
     */
    public function getData()
    {
        // Ambil user fresh dari database
        $user = Auth::user()->fresh();

        return response()->json([
            'balance_points' => $user->balance_points,
            'user_name' => $user->full_name ?? $user->name,
            'member_since' => $user->created_at ? $user->created_at->format('M Y') : 'Jan 2024',
            'recent_deposits' => Deposit::with(['depositItems.wasteType', 'branch'])
                ->where('user_id', $user->id)
                ->latest()
                ->take(5)
                ->get(),
            'recent_redemptions' => Redemption::with(['redemptionItems.rewardItem', 'branch'])
                ->where('user_id', $user->id)
                ->latest()
                ->take(5)
                ->get(),
            'stats' => [
                'total_deposits' => Deposit::where('user_id', $user->id)->count(),
                'total_redemptions' => Redemption::where('user_id', $user->id)->count(),
                'pending_redemptions' => Redemption::where('user_id', $user->id)
                    ->where('status', 'pending')
                    ->count(),
            ],
        ])
        ->header('Cache-Control', 'no-store, no-cache, must-revalidate, max-age=0')
        ->header('Pragma', 'no-cache'); // Extra headers untuk API response
    }
}
