<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Deposit;
use App\Models\Redemption;
use App\Models\User;
use App\Models\DepositItem;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class ReportController extends Controller
{
    /**
     * Display the report page
     */
    public function index(Request $request)
    {
        $admin = auth()->user();
        $branchId = $admin->branch_id;

        // Default period: bulan ini
        $period = $request->input('period', 'bulan_ini');
        
        // Calculate date range based on period
        $dateRange = $this->getDateRange($period, $request);
        $startDate = $dateRange['start'];
        $endDate = $dateRange['end'];

        // Get statistics for the period
        $stats = $this->getStatistics($branchId, $startDate, $endDate);
        
        // Get waste composition
        $wasteComposition = $this->getWasteComposition($branchId, $startDate, $endDate);
        
        // Get top users
        $topUsers = $this->getTopUsers($branchId, $startDate, $endDate);

        return view('admin.laporan.index', compact(
            'stats',
            'wasteComposition',
            'topUsers',
            'period',
            'startDate',
            'endDate'
        ));
    }

    /**
     * Show detail deposits
     */
    public function detailDeposits(Request $request)
    {
        $admin = auth()->user();
        $branchId = $admin->branch_id;

        $period = $request->input('period', 'bulan_ini');
        $dateRange = $this->getDateRange($period, $request);
        $startDate = $dateRange['start'];
        $endDate = $dateRange['end'];

        $deposits = Deposit::with(['user', 'depositItems.wasteType'])
            ->where('branch_id', $branchId)
            ->where('status', 'verified')
            ->whereBetween('created_at', [$startDate, $endDate])
            ->orderByDesc('created_at')
            ->paginate(20);

        return view('admin.laporan.detail-deposits', compact(
            'deposits',
            'period',
            'startDate',
            'endDate'
        ));
    }

    /**
     * Show detail redemptions
     */
    public function detailRedemptions(Request $request)
    {
        $admin = auth()->user();
        $branchId = $admin->branch_id;

        $period = $request->input('period', 'bulan_ini');
        $dateRange = $this->getDateRange($period, $request);
        $startDate = $dateRange['start'];
        $endDate = $dateRange['end'];

        $redemptions = Redemption::with(['user', 'redemptionItems.rewardItem'])
            ->where('branch_id', $branchId)
            ->whereIn('status', ['approved', 'completed'])
            ->whereBetween('created_at', [$startDate, $endDate])
            ->orderByDesc('created_at')
            ->paginate(20);

        return view('admin.laporan.detail-redemptions', compact(
            'redemptions',
            'period',
            'startDate',
            'endDate'
        ));
    }

    /**
     * Export report to PDF
     */
    public function exportPdf(Request $request)
    {
        $admin = auth()->user();
        $branchId = $admin->branch_id;

        $period = $request->input('period', 'bulan_ini');
        $dateRange = $this->getDateRange($period, $request);
        $startDate = $dateRange['start'];
        $endDate = $dateRange['end'];

        $stats = $this->getStatistics($branchId, $startDate, $endDate);
        $wasteComposition = $this->getWasteComposition($branchId, $startDate, $endDate);
        $topUsers = $this->getTopUsers($branchId, $startDate, $endDate);
        $branch = \App\Models\Branch::find($branchId);

        // Get detail data
        $deposits = Deposit::with(['user', 'depositItems.wasteType'])
            ->where('branch_id', $branchId)
            ->where('status', 'verified')
            ->whereBetween('created_at', [$startDate, $endDate])
            ->orderByDesc('created_at')
            ->get();

        $redemptions = Redemption::with(['user', 'redemptionItems.rewardItem'])
            ->where('branch_id', $branchId)
            ->whereIn('status', ['approved', 'completed'])
            ->whereBetween('created_at', [$startDate, $endDate])
            ->orderByDesc('created_at')
            ->get();

        $pdf = \PDF::loadView('admin.laporan.pdf', compact(
            'stats',
            'wasteComposition',
            'topUsers',
            'period',
            'startDate',
            'endDate',
            'branch',
            'deposits',
            'redemptions'
        ));

        $filename = 'Laporan_' . $branch->name . '_' . $startDate->format('d-M-Y') . '_sampai_' . $endDate->format('d-M-Y') . '.pdf';

        return $pdf->download($filename);
    }

    /**
     * Get date range based on period
     */
    private function getDateRange($period, $request)
    {
        $now = Carbon::now();

        switch ($period) {
            case 'hari_ini':
                return [
                    'start' => $now->startOfDay(),
                    'end' => $now->copy()->endOfDay()
                ];
            
            case 'minggu_ini':
                return [
                    'start' => $now->startOfWeek(),
                    'end' => $now->copy()->endOfWeek()
                ];
            
            case 'bulan_ini':
                return [
                    'start' => $now->startOfMonth(),
                    'end' => $now->copy()->endOfMonth()
                ];
            
            case 'tahun_ini':
                return [
                    'start' => $now->startOfYear(),
                    'end' => $now->copy()->endOfYear()
                ];
            
            case 'custom':
                return [
                    'start' => Carbon::parse($request->input('start_date', $now->startOfMonth())),
                    'end' => Carbon::parse($request->input('end_date', $now->endOfMonth()))
                ];
            
            default:
                return [
                    'start' => $now->startOfMonth(),
                    'end' => $now->copy()->endOfMonth()
                ];
        }
    }

    /**
     * Get statistics for the period
     */
    private function getStatistics($branchId, $startDate, $endDate)
    {
        // Total setoran (verified deposits)
        $totalDeposits = Deposit::where('branch_id', $branchId)
            ->where('status', 'verified')
            ->whereBetween('created_at', [$startDate, $endDate])
            ->count();

        // Total berat sampah terkumpul
        $totalWasteWeight = DepositItem::whereHas('deposit', function($q) use ($branchId, $startDate, $endDate) {
                $q->where('branch_id', $branchId)
                  ->where('status', 'verified')
                  ->whereBetween('created_at', [$startDate, $endDate]);
            })
            ->sum('weight');

        // Total penukaran
        $totalRedemptions = Redemption::where('branch_id', $branchId)
            ->whereIn('status', ['approved', 'completed'])
            ->whereBetween('created_at', [$startDate, $endDate])
            ->count();

        // Total poin ditukar (hitung dari redemption_items)
        $redemptions = Redemption::where('branch_id', $branchId)
            ->whereIn('status', ['approved', 'completed'])
            ->whereBetween('created_at', [$startDate, $endDate])
            ->with('redemptionItems.rewardItem')
            ->get();
        
        $totalPointsRedeemed = $redemptions->sum(function($redemption) {
            return $redemption->redemptionItems->sum(function($item) {
                return $item->quantity * $item->rewardItem->points_required;
            });
        });

        // Pengguna aktif (yang melakukan setoran atau penukaran)
        $activeUsers = User::where('role', 'warga')
            ->where('branch_id', $branchId)
            ->where(function($q) use ($startDate, $endDate) {
                $q->whereHas('deposits', function($q2) use ($startDate, $endDate) {
                    $q2->whereBetween('created_at', [$startDate, $endDate]);
                })
                ->orWhereHas('redemptions', function($q2) use ($startDate, $endDate) {
                    $q2->whereBetween('created_at', [$startDate, $endDate]);
                });
            })
            ->count();

        // Net poin (poin diberikan - poin ditukar)
        $totalPointsGiven = Deposit::where('branch_id', $branchId)
            ->where('status', 'verified')
            ->whereBetween('created_at', [$startDate, $endDate])
            ->sum('total_points');

        $netPoints = $totalPointsGiven - $totalPointsRedeemed;

        return [
            'total_deposits' => $totalDeposits,
            'total_waste_weight' => round($totalWasteWeight, 2),
            'total_redemptions' => $totalRedemptions,
            'total_points_redeemed' => $totalPointsRedeemed,
            'active_users' => $activeUsers,
            'net_points' => $netPoints,
            'total_points_given' => $totalPointsGiven,
        ];
    }

    /**
     * Get waste composition breakdown
     */
    private function getWasteComposition($branchId, $startDate, $endDate)
    {
        return DepositItem::select('waste_types.name', DB::raw('SUM(deposit_items.weight) as total_weight'))
            ->join('waste_types', 'deposit_items.waste_type_id', '=', 'waste_types.id')
            ->join('deposits', 'deposit_items.deposit_id', '=', 'deposits.id')
            ->where('deposits.branch_id', $branchId)
            ->where('deposits.status', 'verified')
            ->whereBetween('deposits.created_at', [$startDate, $endDate])
            ->groupBy('waste_types.id', 'waste_types.name')
            ->orderByDesc('total_weight')
            ->get();
    }

    /**
     * Get top users by total deposits
     */
    private function getTopUsers($branchId, $startDate, $endDate, $limit = 5)
    {
        return User::select('users.id', 'users.name', 'users.phone')
            ->where('users.role', 'warga')
            ->where('users.branch_id', $branchId)
            ->withCount(['deposits as total_deposits' => function($q) use ($startDate, $endDate) {
                $q->where('status', 'verified')
                  ->whereBetween('created_at', [$startDate, $endDate]);
            }])
            ->having('total_deposits', '>', 0)
            ->orderByDesc('total_deposits')
            ->limit($limit)
            ->get();
    }
}
