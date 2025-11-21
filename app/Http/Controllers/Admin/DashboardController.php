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
        $branchId = $admin->branch_id;
        
        // Total statistik
        $stats = [
            'total_users' => User::where('role', 'warga')
                ->when($branchId, fn($q) => $q->where(function($query) use ($branchId) {
                    $query->where('branch_id', $branchId)
                          ->orWhereNull('branch_id');
                }))
                ->count(),
            'total_deposits' => Deposit::when($branchId, fn($q) => $q->where(function($query) use ($branchId) {
                $query->where('branch_id', $branchId)
                      ->orWhereNull('branch_id');
            }))->count(),
            'total_redemptions' => Redemption::when($branchId, fn($q) => $q->where(function($query) use ($branchId) {
                $query->where('branch_id', $branchId)
                      ->orWhereNull('branch_id');
            }))->count(),
            'pending_deposits' => Deposit::where('status', 'pending')
                ->when($branchId, fn($q) => $q->where(function($query) use ($branchId) {
                    $query->where('branch_id', $branchId)
                          ->orWhereNull('branch_id');
                }))
                ->count(),
            'pending_redemptions' => Redemption::where('status', 'pending')
                ->when($branchId, fn($q) => $q->where(function($query) use ($branchId) {
                    $query->where('branch_id', $branchId)
                          ->orWhereNull('branch_id');
                }))
                ->count(),
        ];

        // Total setoran per bulan (12 bulan terakhir)
        $depositsByMonth = $this->getDepositsByMonth();

        // Total penukaran per bulan (12 bulan terakhir)
        $redemptionsByMonth = $this->getRedemptionsByMonth();

        // Aktivitas terbaru (gabungan deposits, redemptions, users baru)
        $recentActivities = $this->getRecentActivities();

        // Status sistem real
        $systemStatus = $this->getSystemStatus();

        return view('admin.dashboard', compact('stats', 'depositsByMonth', 'redemptionsByMonth', 'recentActivities', 'systemStatus'));
    }

    /**
     * API endpoint untuk data dashboard
     */
    public function getData()
    {
        $adminBranchId = auth()->user()->branch_id;
        
        return response()->json([
            'stats' => [
                'total_users' => User::where('role', 'warga')
                    ->when($adminBranchId, fn($q) => $q->where(function($query) use ($adminBranchId) {
                        $query->where('branch_id', $adminBranchId)
                              ->orWhereNull('branch_id');
                    }))
                    ->count(),
                'total_deposits' => Deposit::when($adminBranchId, fn($q) => $q->where(function($query) use ($adminBranchId) {
                    $query->where('branch_id', $adminBranchId)
                          ->orWhereNull('branch_id');
                }))->count(),
                'total_redemptions' => Redemption::when($adminBranchId, fn($q) => $q->where(function($query) use ($adminBranchId) {
                    $query->where('branch_id', $adminBranchId)
                          ->orWhereNull('branch_id');
                }))->count(),
                'pending_deposits' => Deposit::where('status', 'pending')
                    ->when($adminBranchId, fn($q) => $q->where(function($query) use ($adminBranchId) {
                        $query->where('branch_id', $adminBranchId)
                              ->orWhereNull('branch_id');
                    }))
                    ->count(),
                'pending_redemptions' => Redemption::where('status', 'pending')
                    ->when($adminBranchId, fn($q) => $q->where(function($query) use ($adminBranchId) {
                        $query->where('branch_id', $adminBranchId)
                              ->orWhereNull('branch_id');
                    }))
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
        $branchId = auth()->user()->branch_id;
        $dbDriver = DB::connection()->getDriverName();
        
        if ($dbDriver === 'sqlite') {
            $deposits = Deposit::select(
                    DB::raw("CAST(strftime('%m', created_at) as INTEGER) as month"),
                    DB::raw("CAST(strftime('%Y', created_at) as INTEGER) as year"),
                    DB::raw('COUNT(*) as total')
                )
                ->when($branchId, fn($q) => $q->where('branch_id', $branchId))
                ->where('created_at', '>=', Carbon::now()->subMonths(12))
                ->groupBy('year', 'month')
                ->orderBy('year', 'asc')
                ->orderBy('month', 'asc')
                ->get();
        } else {
            $deposits = Deposit::select(
                    DB::raw('MONTH(created_at) as month'),
                    DB::raw('YEAR(created_at) as year'),
                    DB::raw('COUNT(*) as total')
                )
                ->when($branchId, fn($q) => $q->where('branch_id', $branchId))
                ->where('created_at', '>=', Carbon::now()->subMonths(12))
                ->groupBy('year', 'month')
                ->orderBy('year', 'asc')
                ->orderBy('month', 'asc')
                ->get();
        }

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
        $branchId = auth()->user()->branch_id;
        $dbDriver = DB::connection()->getDriverName();
        
        if ($dbDriver === 'sqlite') {
            $redemptions = Redemption::select(
                    DB::raw("CAST(strftime('%m', created_at) as INTEGER) as month"),
                    DB::raw("CAST(strftime('%Y', created_at) as INTEGER) as year"),
                    DB::raw('COUNT(*) as total')
                )
                ->when($branchId, fn($q) => $q->where('branch_id', $branchId))
                ->where('created_at', '>=', Carbon::now()->subMonths(12))
                ->groupBy('year', 'month')
                ->orderBy('year', 'asc')
                ->orderBy('month', 'asc')
                ->get();
        } else {
            $redemptions = Redemption::select(
                    DB::raw('MONTH(created_at) as month'),
                    DB::raw('YEAR(created_at) as year'),
                    DB::raw('COUNT(*) as total')
                )
                ->when($branchId, fn($q) => $q->where('branch_id', $branchId))
                ->where('created_at', '>=', Carbon::now()->subMonths(12))
                ->groupBy('year', 'month')
                ->orderBy('year', 'asc')
                ->orderBy('month', 'asc')
                ->get();
        }

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

    /**
     * Get recent activities (deposits, redemptions, new users)
     */
    private function getRecentActivities()
    {
        $branchId = auth()->user()->branch_id;
        $activities = collect();

        // Deposits terbaru (5 terakhir)
        $deposits = Deposit::with(['user', 'branch'])
            ->when($branchId, fn($q) => $q->where('branch_id', $branchId))
            ->latest()
            ->take(5)
            ->get()
            ->map(function($deposit) {
                return [
                    'type' => 'deposit',
                    'icon' => 'bi-arrow-up',
                    'color' => 'green',
                    'title' => 'Setoran baru dari ' . ($deposit->user->full_name ?? $deposit->user->name ?? 'User'),
                    'time' => $deposit->created_at,
                    'time_human' => $deposit->created_at->diffForHumans(),
                ];
            });

        // Redemptions terbaru (5 terakhir)
        $redemptions = Redemption::with(['user', 'branch'])
            ->when($branchId, fn($q) => $q->where('branch_id', $branchId))
            ->latest()
            ->take(5)
            ->get()
            ->map(function($redemption) {
                $status = $redemption->status;
                $title = 'Penukaran ';
                if ($status === 'pending') {
                    $title .= 'menunggu konfirmasi';
                } elseif ($status === 'confirmed') {
                    $title .= 'dikonfirmasi';
                } elseif ($status === 'completed') {
                    $title .= 'selesai';
                } else {
                    $title .= 'dibatalkan';
                }
                
                return [
                    'type' => 'redemption',
                    'icon' => $status === 'confirmed' || $status === 'completed' ? 'bi-check' : 'bi-clock',
                    'color' => $status === 'confirmed' || $status === 'completed' ? 'emerald' : 'yellow',
                    'title' => $title,
                    'time' => $redemption->created_at,
                    'time_human' => $redemption->created_at->diffForHumans(),
                ];
            });

        // Users baru terdaftar (5 terakhir)
        $newUsers = User::where('role', 'warga')
            ->latest()
            ->take(5)
            ->get()
            ->map(function($user) {
                return [
                    'type' => 'user',
                    'icon' => 'bi-person-plus',
                    'color' => 'teal',
                    'title' => 'Pengguna baru terdaftar: ' . ($user->full_name ?? $user->name ?? 'User'),
                    'time' => $user->created_at,
                    'time_human' => $user->created_at->diffForHumans(),
                ];
            });

        // Gabungkan semua aktivitas dan sort by time
        $activities = $activities
            ->merge($deposits)
            ->merge($redemptions)
            ->merge($newUsers)
            ->sortByDesc('time')
            ->take(10)
            ->values();

        return $activities;
    }

    /**
     * Get real system status
     */
    private function getSystemStatus()
    {
        try {
            // Check database connection
            DB::connection()->getPdo();
            $dbStatus = 'online';
        } catch (\Exception $e) {
            $dbStatus = 'offline';
        }

        // Check storage
        $storagePath = storage_path('app');
        $totalSpace = disk_total_space($storagePath);
        $freeSpace = disk_free_space($storagePath);
        $usedSpace = $totalSpace - $freeSpace;
        $usedPercentage = round(($usedSpace / $totalSpace) * 100);

        return [
            'database' => [
                'status' => $dbStatus,
                'label' => $dbStatus === 'online' ? 'Online' : 'Offline',
                'color' => $dbStatus === 'online' ? 'green' : 'red',
            ],
            'server' => [
                'status' => 'running',
                'label' => 'Running',
                'color' => 'green',
            ],
            'cache' => [
                'status' => 'active',
                'label' => 'Active',
                'color' => 'green',
            ],
            'storage' => [
                'status' => 'ok',
                'label' => $usedPercentage . '% Used',
                'color' => $usedPercentage > 80 ? 'red' : ($usedPercentage > 60 ? 'yellow' : 'lime'),
                'percentage' => $usedPercentage,
            ],
        ];
    }
}
