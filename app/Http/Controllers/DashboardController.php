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
     */
    public function index()
    {
        $user = Auth::user();

        // Total poin
        $totalPoints = $user->balance_points;

        // Recent deposits (5 terakhir)
        $recentDeposits = Deposit::with(['items.wasteType', 'branch'])
            ->where('user_id', $user->id)
            ->latest()
            ->take(5)
            ->get();

        // Recent redemptions (5 terakhir)
        $recentRedemptions = Redemption::with(['items.rewardItem', 'branch'])
            ->where('user_id', $user->id)
            ->latest()
            ->take(5)
            ->get();

        // Count statistik
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
     */
    public function getData()
    {
        $user = Auth::user();

        return response()->json([
            'balance_points' => $user->balance_points,
            'user_name' => $user->full_name ?? $user->name,
            'member_since' => $user->created_at ? $user->created_at->format('M Y') : 'Jan 2024',
            'recent_deposits' => Deposit::with(['items.wasteType', 'branch'])
                ->where('user_id', $user->id)
                ->latest()
                ->take(5)
                ->get(),
            'recent_redemptions' => Redemption::with(['items.rewardItem', 'branch'])
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
        ]);
    }
}
