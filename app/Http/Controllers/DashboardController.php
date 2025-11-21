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

        // Calculate member level based on total points
        $memberLevel = $this->calculateMemberLevel($totalPoints);

        // Data untuk view dengan nama yang sesuai
        $saldoPoin = $totalPoints;
        $namaUser = $user->name;
        $authUser = $user;

        // Count unread notifications
        $unreadNotifications = $user->unreadNotifications()->count();

        return view('dashboard', compact(
            'user', 
            'saldoPoin', 
            'namaUser', 
            'authUser',
            'totalPoints', 
            'recentDeposits', 
            'recentRedemptions', 
            'stats',
            'memberLevel',
            'unreadNotifications'
        ));
    }

    /**
     * Calculate member level based on total points
     * 
     * Tier system:
     * - Platinum: 20000+ points
     * - Gold: 10000-19999 points
     * - Silver: 5000-9999 points
     * - Bronze: 0-4999 points
     */
    private function calculateMemberLevel($points)
    {
        if ($points >= 20000) {
            return [
                'name' => 'Platinum Member',
                'icon' => 'bi-gem',
                'color' => 'from-cyan-400 to-blue-500',
                'text_color' => 'text-cyan-300',
                'next_tier' => null,
                'progress' => 100
            ];
        } elseif ($points >= 10000) {
            $nextTier = 20000;
            $currentTier = 10000;
            $progress = (($points - $currentTier) / ($nextTier - $currentTier)) * 100;
            
            return [
                'name' => 'Gold Member',
                'icon' => 'bi-star-fill',
                'color' => 'from-yellow-400 to-orange-500',
                'text_color' => 'text-yellow-300',
                'next_tier' => $nextTier,
                'points_to_next' => $nextTier - $points,
                'progress' => $progress
            ];
        } elseif ($points >= 5000) {
            $nextTier = 10000;
            $currentTier = 5000;
            $progress = (($points - $currentTier) / ($nextTier - $currentTier)) * 100;
            
            return [
                'name' => 'Silver Member',
                'icon' => 'bi-award-fill',
                'color' => 'from-gray-300 to-gray-400',
                'text_color' => 'text-gray-300',
                'next_tier' => $nextTier,
                'points_to_next' => $nextTier - $points,
                'progress' => $progress
            ];
        } else {
            $nextTier = 5000;
            $currentTier = 0;
            $progress = ($points / $nextTier) * 100;
            
            return [
                'name' => 'Bronze Member',
                'icon' => 'bi-trophy',
                'color' => 'from-orange-400 to-orange-600',
                'text_color' => 'text-orange-300',
                'next_tier' => $nextTier,
                'points_to_next' => $nextTier - $points,
                'progress' => $progress
            ];
        }
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
