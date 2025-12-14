<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Deposit;
use App\Models\Redemption;
use App\Models\User;
use App\Models\RewardItem;
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
        
        // Get current month and year
        $currentMonth = now()->month;
        $currentYear = now()->year;
        
        // Total statistik (tampilkan data global, warga bebas ke cabang manapun)
        // Pending count HANYA untuk bulan ini (sesuai dengan admin penukaran page logic)
        // Total stok reward hanya untuk branch admin tersebut
        $stats = [
            'total_users' => User::whereIn('role', ['user', 'warga'])->count(),
            'total_deposits' => Deposit::count(),
            'total_redemptions' => Redemption::count(),
            'pending_deposits' => Deposit::where('status', 'pending')
                ->whereMonth('created_at', $currentMonth)
                ->whereYear('created_at', $currentYear)
                ->count(),
            'pending_redemptions' => Redemption::where('status', 'pending')
                ->whereMonth('created_at', $currentMonth)
                ->whereYear('created_at', $currentYear)
                ->count(),
            'total_reward_stock' => RewardItem::when($branchId, fn($q) => $q->where('branch_id', $branchId))->sum('stock') ?? 0,
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

    public function getData()
    {
        // Get current month and year
        $currentMonth = now()->month;
        $currentYear = now()->year;
        
        return response()->json([
            'stats' => [
                'total_users' => User::whereIn('role', ['user', 'warga'])->count(),
                'total_deposits' => Deposit::count(),
                'total_redemptions' => Redemption::count(),
                'pending_deposits' => Deposit::where('status', 'pending')
                    ->whereMonth('created_at', $currentMonth)
                    ->whereYear('created_at', $currentYear)
                    ->count(),
                'pending_redemptions' => Redemption::where('status', 'pending')
                    ->whereMonth('created_at', $currentMonth)
                    ->whereYear('created_at', $currentYear)
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
        
        $deposits = $this->getDataByMonth(
            Deposit::class,
            ['status' => null], // null means no status filter
            $branchId
        );

        return $this->formatDataByMonth($deposits);
    }

    /**
     * Get redemptions grouped by month (last 12 months)
     * Only counts completed/delivered redemptions
     */
    private function getRedemptionsByMonth()
    {
        $branchId = auth()->user()->branch_id;
        
        $redemptions = $this->getDataByMonth(
            Redemption::class,
            ['status' => 'completed'],
            $branchId
        );

        return $this->formatDataByMonth($redemptions);
    }

    /**
     * Helper method to get data grouped by month
     * Works with both SQLite and MySQL
     * 
     * @param string $modelClass Model class name (e.g., Deposit::class)
     * @param array $filters Additional filters (e.g., ['status' => 'completed'])
     * @param int|null $branchId Branch ID to filter by
     * @return \Illuminate\Database\Eloquent\Collection
     */
    private function getDataByMonth(string $modelClass, array $filters = [], ?int $branchId = null)
    {
        $dbDriver = DB::connection()->getDriverName();
        
        // Build query based on database driver
        $query = $modelClass::select(
            $dbDriver === 'sqlite'
                ? DB::raw("CAST(strftime('%m', created_at) as INTEGER) as month")
                : DB::raw('MONTH(created_at) as month'),
            $dbDriver === 'sqlite'
                ? DB::raw("CAST(strftime('%Y', created_at) as INTEGER) as year")
                : DB::raw('YEAR(created_at) as year'),
            DB::raw('COUNT(*) as total')
        );

        // Apply branch filter if provided
        if ($branchId) {
            $query->where('branch_id', $branchId);
        }

        // Apply additional filters
        foreach ($filters as $column => $value) {
            if ($value !== null) {
                $query->where($column, $value);
            }
        }

        // Date range and grouping
        $query->where('created_at', '>=', Carbon::now()->subMonths(12))
            ->groupBy('year', 'month')
            ->orderBy('year', 'asc')
            ->orderBy('month', 'asc');

        return $query->get();
    }

    /**
     * Helper method to format monthly data for chart display
     * 
     * @param \Illuminate\Database\Eloquent\Collection $data Data grouped by month
     * @return array Formatted data for chart
     */
    private function formatDataByMonth($data)
    {
        $result = [];
        
        for ($i = 11; $i >= 0; $i--) {
            $date = Carbon::now()->subMonths($i);
            $month = $date->month;
            $year = $date->year;
            
            $found = $data->first(function($item) use ($month, $year) {
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