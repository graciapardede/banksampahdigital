<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Deposit;
use App\Models\Redemption;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class DashboardController extends Controller
{
    /**
     * Dashboard admin
     */
    public function index()
    {
        // Load branch relation untuk admin
        $admin = auth()->user()->load('branch');
        
        // Total statistik
        $stats = [
            'total_users' => User::where('role', User::ROLE_WARGA)->count(),
            'total_deposits' => Deposit::count(),
            'total_redemptions' => Redemption::count(),
            'pending_deposits' => Deposit::where('status', 'pending')->count(),
            'pending_redemptions' => Redemption::where('status', 'pending')->count(),
        ];

        // Total setoran per bulan (12 bulan terakhir)
        $depositsByMonth = $this->getDepositsByMonth();

        // Total penukaran per bulan (12 bulan terakhir)
        $redemptionsByMonth = $this->getRedemptionsByMonth();

        return view('admin.dashboard', compact('stats', 'depositsByMonth', 'redemptionsByMonth'));
    }

    /**
     * API endpoint untuk data dashboard
     */
    public function getData()
    {
        $adminBranchId = auth()->user()->branch_id;
        
        return response()->json([
            'stats' => [
                'total_users' => User::where('role', User::ROLE_WARGA)
                    ->when($adminBranchId, fn($q) => $q->where('branch_id', $adminBranchId))
                    ->count(),
                'total_deposits' => Deposit::when($adminBranchId, fn($q) => $q->where('branch_id', $adminBranchId))->count(),
                'total_redemptions' => Redemption::when($adminBranchId, fn($q) => $q->where('branch_id', $adminBranchId))->count(),
                'pending_deposits' => Deposit::where('status', 'pending')
                    ->when($adminBranchId, fn($q) => $q->where('branch_id', $adminBranchId))
                    ->count(),
                'pending_redemptions' => Redemption::where('status', 'pending')
                    ->when($adminBranchId, fn($q) => $q->where('branch_id', $adminBranchId))
                    ->count(),
            ],
            'deposits_by_month' => $this->getDepositsByMonth(),
            'redemptions_by_month' => $this->getRedemptionsByMonth(),
        ]);
    }

    /**
     * Get deposits grouped by month (last 12 months)
     */
    private function getDepositsByMonth()
    {
        $deposits = Deposit::select(
                DB::raw('MONTH(created_at) as month'),
                DB::raw('YEAR(created_at) as year'),
                DB::raw('COUNT(*) as total')
            )
            ->where('created_at', '>=', Carbon::now()->subMonths(12))
            ->groupBy('year', 'month')
            ->orderBy('year', 'asc')
            ->orderBy('month', 'asc')
            ->get();

        // Format untuk chart
        $result = [];
        for ($i = 11; $i >= 0; $i--) {
            $date = Carbon::now()->subMonths($i);
            $month = $date->month;
            $year = $date->year;
            
            $found = $deposits->first(function($item) use ($month, $year) {
                return $item->month == $month && $item->year == $year;
            });

            $result[] = [
                'label' => $date->format('M Y'),
                'value' => $found ? $found->total : 0,
            ];
        }

        return $result;
    }

    /**
     * Get redemptions grouped by month (last 12 months)
     */
    private function getRedemptionsByMonth()
    {
        $redemptions = Redemption::select(
                DB::raw('MONTH(created_at) as month'),
                DB::raw('YEAR(created_at) as year'),
                DB::raw('COUNT(*) as total')
            )
            ->where('created_at', '>=', Carbon::now()->subMonths(12))
            ->groupBy('year', 'month')
            ->orderBy('year', 'asc')
            ->orderBy('month', 'asc')
            ->get();

        // Format untuk chart
        $result = [];
        for ($i = 11; $i >= 0; $i--) {
            $date = Carbon::now()->subMonths($i);
            $month = $date->month;
            $year = $date->year;
            
            $found = $redemptions->first(function($item) use ($month, $year) {
                return $item->month == $month && $item->year == $year;
            });

            $result[] = [
                'label' => $date->format('M Y'),
                'value' => $found ? $found->total : 0,
            ];
        }

        return $result;
    }
}
