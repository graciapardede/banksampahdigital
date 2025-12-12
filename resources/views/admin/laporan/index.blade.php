<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Cabang - Green Saving Admin</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css" rel="stylesheet">
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        'poppins': ['Poppins', 'sans-serif'],
                    }
                }
            }
        }
    </script>
</head>
<body class="min-h-screen bg-gradient-to-br from-green-50 to-green-100 font-poppins">

    <!-- Header -->
    <x-admin-header :activePage="'laporan'" />

    <!-- Main Content -->
    <main class="max-w-7xl mx-auto px-4 py-8">
        <!-- Header with Filter -->
        <div class="mb-8">
            <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-4">
                <div>
                    <h1 class="text-3xl font-bold text-gray-800 flex items-center">
                        <i class="bi bi-file-earmark-bar-graph mr-3 text-green-600"></i>
                        Laporan Cabang
                    </h1>
                    <p class="text-gray-600 mt-1">Statistik dan laporan aktivitas cabang</p>
                </div>
                
                <!-- Export Button -->
                <a href="{{ route('admin.laporan.export-pdf', ['period' => $period, 'start_date' => request('start_date'), 'end_date' => request('end_date')]) }}" 
                   class="inline-flex items-center px-6 py-3 bg-red-600 hover:bg-red-700 text-white font-semibold rounded-xl shadow-lg transition-all duration-200 transform hover:scale-105">
                    <i class="bi bi-file-pdf mr-2"></i>
                    Export PDF
                </a>
            </div>
        </div>

        <!-- Filter Periode -->
        <div class="bg-white rounded-2xl shadow-lg p-6 mb-6">
            <form method="GET" action="{{ route('admin.laporan.index') }}" class="flex flex-col lg:flex-row gap-4">
                <div class="flex-1">
                    <label class="block text-sm font-semibold text-gray-700 mb-2">
                        <i class="bi bi-calendar-range mr-1"></i> Periode
                    </label>
                    <select name="period" id="periodSelect" class="w-full px-4 py-3 border-2 border-gray-300 rounded-xl focus:ring-2 focus:ring-green-500 focus:border-green-500 transition-all">
                        <option value="hari_ini" {{ $period == 'hari_ini' ? 'selected' : '' }}>Hari Ini</option>
                        <option value="minggu_ini" {{ $period == 'minggu_ini' ? 'selected' : '' }}>Minggu Ini</option>
                        <option value="bulan_ini" {{ $period == 'bulan_ini' ? 'selected' : '' }}>Bulan Ini</option>
                        <option value="tahun_ini" {{ $period == 'tahun_ini' ? 'selected' : '' }}>Tahun Ini</option>
                        <option value="custom" {{ $period == 'custom' ? 'selected' : '' }}>Custom Range</option>
                    </select>
                </div>

                <!-- Custom Date Range (Hidden by default) -->
                <div id="customDateRange" class="flex-1 {{ $period != 'custom' ? 'hidden' : '' }}">
                    <label class="block text-sm font-semibold text-gray-700 mb-2">
                        <i class="bi bi-calendar-check mr-1"></i> Tanggal Mulai
                    </label>
                    <input type="date" name="start_date" value="{{ request('start_date', $startDate->format('Y-m-d')) }}" class="w-full px-4 py-3 border-2 border-gray-300 rounded-xl focus:ring-2 focus:ring-green-500 focus:border-green-500 transition-all">
                </div>

                <div id="customDateRange2" class="flex-1 {{ $period != 'custom' ? 'hidden' : '' }}">
                    <label class="block text-sm font-semibold text-gray-700 mb-2">
                        <i class="bi bi-calendar-check mr-1"></i> Tanggal Akhir
                    </label>
                    <input type="date" name="end_date" value="{{ request('end_date', $endDate->format('Y-m-d')) }}" class="w-full px-4 py-3 border-2 border-gray-300 rounded-xl focus:ring-2 focus:ring-green-500 focus:border-green-500 transition-all">
                </div>

                <div class="flex items-end">
                    <button type="submit" class="w-full lg:w-auto px-8 py-3 bg-green-600 hover:bg-green-700 text-white font-semibold rounded-xl shadow-lg transition-all duration-200 transform hover:scale-105">
                        <i class="bi bi-search mr-2"></i> Tampilkan
                    </button>
                </div>
            </form>
        </div>

        <!-- Periode Info -->
        <div class="bg-blue-50 border-2 border-blue-200 rounded-xl p-4 mb-6">
            <div class="flex items-center">
                <i class="bi bi-info-circle-fill text-blue-600 text-xl mr-3"></i>
                <div>
                    <p class="font-semibold text-blue-800">Periode Laporan</p>
                    <p class="text-blue-700">{{ $startDate->format('d M Y') }} - {{ $endDate->format('d M Y') }}</p>
                </div>
            </div>
        </div>

        <!-- Statistics Cards -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-6">
            <!-- Total Setoran -->
            <a href="{{ route('admin.laporan.detail-deposits', ['period' => $period, 'start_date' => request('start_date'), 'end_date' => request('end_date')]) }}" class="bg-gradient-to-br from-green-500 to-green-600 rounded-2xl shadow-lg p-6 text-white transform hover:scale-105 transition-all duration-200 cursor-pointer">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-green-100 text-sm font-medium mb-1">Total Setoran</p>
                        <h3 class="text-4xl font-bold">{{ $stats['total_deposits'] }}</h3>
                        <p class="text-green-100 text-xs mt-2">transaksi</p>
                        <p class="text-green-100 text-xs mt-2 font-semibold"><i class="bi bi-hand-pointer mr-1"></i>Klik untuk detail</p>
                    </div>
                    <div class="bg-white bg-opacity-20 rounded-full p-4">
                        <i class="bi bi-recycle text-4xl"></i>
                    </div>
                </div>
            </a>

            <!-- Total Penukaran -->
            <a href="{{ route('admin.laporan.detail-redemptions', ['period' => $period, 'start_date' => request('start_date'), 'end_date' => request('end_date')]) }}" class="bg-gradient-to-br from-purple-500 to-purple-600 rounded-2xl shadow-lg p-6 text-white transform hover:scale-105 transition-all duration-200 cursor-pointer">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-purple-100 text-sm font-medium mb-1">Total Penukaran</p>
                        <h3 class="text-4xl font-bold">{{ $stats['total_redemptions'] }}</h3>
                        <p class="text-purple-100 text-xs mt-2">transaksi</p>
                        <p class="text-purple-100 text-xs mt-2 font-semibold"><i class="bi bi-hand-pointer mr-1"></i>Klik untuk detail</p>
                    </div>
                    <div class="bg-white bg-opacity-20 rounded-full p-4">
                        <i class="bi bi-gift text-4xl"></i>
                    </div>
                </div>
            </a>

            <!-- Pengguna Aktif -->
            <div class="bg-gradient-to-br from-blue-500 to-blue-600 rounded-2xl shadow-lg p-6 text-white transform hover:scale-105 transition-all duration-200">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-blue-100 text-sm font-medium mb-1">Pengguna Aktif</p>
                        <h3 class="text-4xl font-bold">{{ $stats['active_users'] }}</h3>
                        <p class="text-blue-100 text-xs mt-2">warga</p>
                    </div>
                    <div class="bg-white bg-opacity-20 rounded-full p-4">
                        <i class="bi bi-people text-4xl"></i>
                    </div>
                </div>
            </div>
        </div>

        <!-- Detail Statistics -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-6">
            <!-- Komposisi Jenis Sampah -->
            <div class="bg-white rounded-2xl shadow-lg p-6">
                <h3 class="text-xl font-bold text-gray-800 mb-4 flex items-center">
                    <i class="bi bi-pie-chart-fill text-green-600 mr-2"></i>
                    Komposisi Jenis Sampah
                </h3>
                <div class="space-y-3">
                    @forelse($wasteComposition as $waste)
                    <div class="flex items-center justify-between p-3 bg-gray-50 rounded-xl hover:bg-gray-100 transition-all">
                        <div class="flex items-center space-x-3">
                            <div class="w-3 h-3 rounded-full bg-green-500"></div>
                            <span class="font-medium text-gray-700">{{ $waste->name }}</span>
                        </div>
                        <span class="font-bold text-green-600">{{ number_format($waste->total_weight, 2) }} kg</span>
                    </div>
                    @empty
                    <div class="text-center py-8 text-gray-500">
                        <i class="bi bi-inbox text-4xl mb-2"></i>
                        <p>Belum ada data sampah</p>
                    </div>
                    @endforelse
                </div>
                
                @if($wasteComposition->count() > 0)
                <div class="mt-4 pt-4 border-t-2 border-gray-200">
                    <div class="flex justify-between items-center">
                        <span class="font-bold text-gray-700">Total Berat</span>
                        <span class="font-bold text-green-600 text-lg">{{ number_format($stats['total_waste_weight'], 2) }} kg</span>
                    </div>
                </div>
                @endif
            </div>
        </div>

        <!-- Additional Info -->
        <div class="bg-white rounded-2xl shadow-lg p-6">
            <h3 class="text-xl font-bold text-gray-800 mb-4 flex items-center">
                <i class="bi bi-info-circle-fill text-blue-600 mr-2"></i>
                Informasi Detail
            </h3>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div class="p-4 bg-green-50 rounded-xl">
                    <p class="text-sm text-gray-600 mb-1">Total Poin Diberikan</p>
                    <p class="text-2xl font-bold text-green-600">{{ number_format($stats['total_points_given']) }} poin</p>
                </div>
                <div class="p-4 bg-purple-50 rounded-xl">
                    <p class="text-sm text-gray-600 mb-1">Total Poin Ditukar</p>
                    <p class="text-2xl font-bold text-purple-600">{{ number_format($stats['total_points_redeemed']) }} poin</p>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    // Toggle custom date range
    document.getElementById('periodSelect').addEventListener('change', function() {
        const customRange = document.getElementById('customDateRange');
        const customRange2 = document.getElementById('customDateRange2');
        
        if (this.value === 'custom') {
            customRange.classList.remove('hidden');
            customRange2.classList.remove('hidden');
        } else {
            customRange.classList.add('hidden');
            customRange2.classList.add('hidden');
        }
    });
</script>

    </main>

</body>
</html>
