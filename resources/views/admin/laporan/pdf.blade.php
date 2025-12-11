<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Cabang</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: 'Arial', sans-serif;
            font-size: 10px;
            line-height: 1.4;
            color: #333;
        }
        
        .header {
            text-align: center;
            margin-bottom: 20px;
            padding-bottom: 15px;
            border-bottom: 3px solid #10b981;
        }
        
        .header h1 {
            font-size: 20px;
            color: #10b981;
            margin-bottom: 5px;
        }
        
        .header h2 {
            font-size: 16px;
            color: #333;
            margin-bottom: 8px;
        }
        
        .header p {
            font-size: 11px;
            color: #666;
        }
        
        .info-box {
            background: #f0fdf4;
            padding: 12px;
            margin-bottom: 15px;
            border-left: 4px solid #10b981;
        }
        
        .info-box p {
            margin: 3px 0;
            font-size: 10px;
        }
        
        .info-box strong {
            color: #10b981;
        }
        
        .stats-grid {
            display: table;
            width: 100%;
            margin-bottom: 20px;
        }
        
        .stat-card {
            display: table-cell;
            width: 25%;
            padding: 10px;
            text-align: center;
            background: #f9fafb;
            border: 1px solid #e5e7eb;
        }
        
        .stat-card h3 {
            font-size: 22px;
            color: #10b981;
            margin-bottom: 3px;
        }
        
        .stat-card p {
            font-size: 9px;
            color: #666;
            text-transform: uppercase;
        }
        
        .section-title {
            font-size: 14px;
            font-weight: bold;
            color: #10b981;
            margin-top: 20px;
            margin-bottom: 10px;
            padding-bottom: 5px;
            border-bottom: 2px solid #10b981;
        }
        
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
            font-size: 9px;
        }
        
        table thead {
            background: #10b981;
            color: white;
        }
        
        table th {
            padding: 8px 6px;
            text-align: left;
            font-weight: bold;
            font-size: 9px;
        }
        
        table td {
            padding: 6px;
            border-bottom: 1px solid #e5e7eb;
        }
        
        table tbody tr:nth-child(even) {
            background: #f9fafb;
        }
        
        table tfoot {
            background: #f3f4f6;
            font-weight: bold;
        }
        
        table tfoot td {
            padding: 10px 6px;
            border-top: 2px solid #10b981;
        }
        
        .text-right {
            text-align: right;
        }
        
        .text-center {
            text-align: center;
        }
        
        .badge {
            display: inline-block;
            padding: 3px 8px;
            background: #dcfce7;
            color: #166534;
            border-radius: 4px;
            font-size: 8px;
            font-weight: bold;
        }
        
        .badge-purple {
            background: #f3e8ff;
            color: #6b21a8;
        }
        
        .footer {
            margin-top: 30px;
            padding-top: 15px;
            border-top: 2px solid #e5e7eb;
            text-align: center;
            font-size: 9px;
            color: #666;
        }
        
        .page-break {
            page-break-after: always;
        }
    </style>
</head>
<body>
    <!-- Header -->
    <div class="header">
        <h1>LAPORAN BANK SAMPAH DIGITAL</h1>
        <h2>{{ $branch->name }}</h2>
        <p>{{ $branch->address }}</p>
        <p>Periode: {{ $startDate->format('d F Y') }} - {{ $endDate->format('d F Y') }}</p>
    </div>

    <!-- Info Box -->
    <div class="info-box">
        <p><strong>Cabang:</strong> {{ $branch->name }}</p>
        <p><strong>Alamat:</strong> {{ $branch->address }}</p>
        <p><strong>Kontak:</strong> {{ $branch->phone ?? '-' }}</p>
        <p><strong>Tanggal Cetak:</strong> {{ now()->format('d F Y H:i') }} WIB</p>
    </div>

    <!-- Statistics -->
    <h3 class="section-title">RINGKASAN STATISTIK</h3>
    <div class="stats-grid">
        <div class="stat-card">
            <h3>{{ $stats['total_deposits'] }}</h3>
            <p>Total Setoran</p>
        </div>
        <div class="stat-card">
            <h3>{{ $stats['total_redemptions'] }}</h3>
            <p>Total Penukaran</p>
        </div>
        <div class="stat-card">
            <h3>{{ $stats['active_users'] }}</h3>
            <p>Pengguna Aktif</p>
        </div>
    </div>

    <!-- Waste Composition -->
    <h3 class="section-title">KOMPOSISI JENIS SAMPAH</h3>
    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Jenis Sampah</th>
                <th class="text-right">Total Berat (kg)</th>
                <th class="text-right">Persentase</th>
            </tr>
        </thead>
        <tbody>
            @php $totalWeight = $wasteComposition->sum('total_weight'); @endphp
            @forelse($wasteComposition as $index => $waste)
            <tr>
                <td>{{ $index + 1 }}</td>
                <td>{{ $waste->name }}</td>
                <td class="text-right">{{ number_format($waste->total_weight, 2) }}</td>
                <td class="text-right">{{ $totalWeight > 0 ? number_format(($waste->total_weight / $totalWeight) * 100, 1) : 0 }}%</td>
            </tr>
            @empty
            <tr>
                <td colspan="4" class="text-center">Tidak ada data</td>
            </tr>
            @endforelse
        </tbody>
        @if($wasteComposition->count() > 0)
        <tfoot>
            <tr>
                <td colspan="2" class="text-right">TOTAL:</td>
                <td class="text-right">{{ number_format($stats['total_waste_weight'], 2) }} kg</td>
                <td class="text-right">100%</td>
            </tr>
        </tfoot>
        @endif
    </table>

    <!-- Page Break -->
    <div class="page-break"></div>

    <!-- Detail Deposits -->
    <h3 class="section-title">DETAIL TRANSAKSI SETORAN</h3>
    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Tanggal</th>
                <th>Nama Warga</th>
                <th>Item Sampah</th>
                <th class="text-right">Total Berat</th>
                <th class="text-right">Total Poin</th>
            </tr>
        </thead>
        <tbody>
            @forelse($deposits as $index => $deposit)
            <tr>
                <td>{{ $index + 1 }}</td>
                <td>{{ $deposit->created_at->format('d/m/Y H:i') }}</td>
                <td>{{ $deposit->user->name }}</td>
                <td>
                    @foreach($deposit->depositItems as $item)
                        <span class="badge">{{ $item->wasteType->name }}: {{ $item->weight }}kg</span>
                    @endforeach
                </td>
                <td class="text-right">{{ number_format($deposit->depositItems->sum('weight'), 2) }}</td>
                <td class="text-right">{{ number_format($deposit->total_points) }}</td>
            </tr>
            @empty
            <tr>
                <td colspan="6" class="text-center">Tidak ada transaksi setoran</td>
            </tr>
            @endforelse
        </tbody>
        @if($deposits->count() > 0)
        <tfoot>
            <tr>
                <td colspan="4" class="text-right">TOTAL:</td>
                <td class="text-right">{{ number_format($deposits->sum(function($d) { return $d->depositItems->sum('weight'); }), 2) }} kg</td>
                <td class="text-right">{{ number_format($deposits->sum('total_points')) }} poin</td>
            </tr>
        </tfoot>
        @endif
    </table>

    <!-- Page Break -->
    <div class="page-break"></div>

    <!-- Detail Redemptions -->
    <h3 class="section-title">DETAIL TRANSAKSI PENUKARAN</h3>
    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Tanggal</th>
                <th>Nama Warga</th>
                <th>Barang Ditukar</th>
                <th class="text-center">Status</th>
                <th class="text-right">Total Poin</th>
            </tr>
        </thead>
        <tbody>
            @forelse($redemptions as $index => $redemption)
            <tr>
                <td>{{ $index + 1 }}</td>
                <td>{{ $redemption->created_at->format('d/m/Y H:i') }}</td>
                <td>{{ $redemption->user->name }}</td>
                <td>
                    @foreach($redemption->redemptionItems as $item)
                        <span class="badge badge-purple">{{ $item->rewardItem->name }} x{{ $item->quantity }}</span>
                    @endforeach
                </td>
                <td class="text-center">
                    @if($redemption->status === 'approved')
                        Disetujui
                    @elseif($redemption->status === 'completed')
                        Selesai
                    @endif
                </td>
                <td class="text-right">{{ number_format($redemption->total_points) }}</td>
            </tr>
            @empty
            <tr>
                <td colspan="6" class="text-center">Tidak ada transaksi penukaran</td>
            </tr>
            @endforelse
        </tbody>
        @if($redemptions->count() > 0)
        <tfoot>
            <tr>
                <td colspan="5" class="text-right">TOTAL POIN DITUKAR:</td>
                <td class="text-right">{{ number_format($redemptions->sum(function($r) { return $r->total_points; })) }} poin</td>
            </tr>
        </tfoot>
        @endif
    </table>

    <!-- Summary Info -->
    <div class="info-box" style="margin-top: 20px;">
        <p><strong>Total Poin Diberikan:</strong> {{ number_format($stats['total_points_given']) }} poin</p>
        <p><strong>Total Poin Ditukar:</strong> {{ number_format($stats['total_points_redeemed']) }} poin</p>
        <p><strong>Total Berat Sampah:</strong> {{ number_format($stats['total_waste_weight'], 2) }} kg</p>
    </div>

    <!-- Footer -->
    <div class="footer">
        <p>Dokumen ini dicetak secara otomatis dari sistem Bank Sampah Digital</p>
        <p>{{ $branch->name }} - {{ now()->format('d F Y H:i') }} WIB</p>
    </div>
</body>
</html>
