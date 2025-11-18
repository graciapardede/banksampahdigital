<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Admin - Green Saving</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
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
    @include('admin.partials.header')
    <header class="bg-white shadow-sm">
        <div class="max-w-6xl mx-auto px-4 py-6">
            <div class="flex justify-between items-center">
                <!-- Logo -->
                <div class="flex items-center space-x-3">
                    <div class="w-12 h-12 bg-gradient-to-br from-green-500 to-green-600 rounded-xl flex items-center justify-center shadow-lg">
                        <i class="bi bi-recycle text-white text-2xl"></i>
                    </div>
                    <div>
                        <h1 class="font-bold text-xl text-gray-800">Green Saving Admin</h1>
                        <p class="text-sm text-green-600">Halo, {{ Auth::user()->name }}</p>
                    </div>
                </div>

                <!-- Admin Actions -->
                <div class="flex items-center space-x-4">
                    <!-- Admin Badge -->
                    <div class="bg-gradient-to-r from-green-100 to-emerald-50 px-6 py-3 rounded-full border-2 border-green-300 shadow-md">
                        <div class="flex items-center space-x-2">
                            <i class="bi bi-shield-check text-green-600 text-xl"></i>
                            <span class="font-bold text-green-700 text-sm">Administrator</span>
                        </div>
                    </div>

                    <!-- Notification Bell -->
                    <a href="#" class="w-12 h-12 bg-gray-100 hover:bg-gray-200 rounded-xl flex items-center justify-center transition-all">
                        <i class="bi bi-bell text-gray-700 text-xl"></i>
                    </a>

                    <!-- Logout Button -->
                    <form method="POST" action="{{ route('logout') }}" class="inline">
                        @csrf
                        <button type="submit" class="w-12 h-12 bg-red-100 hover:bg-red-200 rounded-xl flex items-center justify-center transition-all">
                            <i class="bi bi-box-arrow-right text-red-600 text-xl"></i>
                        </button>
                    </form>
                </div>
            </div>
        </div>

        <!-- Navigation Tabs -->
        <div class="bg-green-100 px-4 py-4">
            <div class="max-w-6xl mx-auto">
                <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-6 gap-3">
                    <a href="{{ route('admin.dashboard') }}" class="bg-green-500 text-white px-4 lg:px-6 py-3 rounded-2xl text-xs lg:text-sm font-semibold shadow-md flex items-center justify-center space-x-2 w-full">
                        <i class="bi bi-house-door"></i>
                        <span class="truncate">Dashboard</span>
                    </a>
                    <a href="{{ route('admin.setoran') }}" class="bg-white text-gray-700 px-4 lg:px-6 py-3 rounded-2xl text-xs lg:text-sm font-semibold hover:bg-green-50 transition-colors shadow-sm flex items-center justify-center space-x-2 w-full">
                        <i class="bi bi-graph-up"></i>
                        <span class="truncate">Setoran</span>
                    </a>
                    <a href="{{ route('admin.penukaran') }}" class="bg-white text-gray-700 px-4 lg:px-6 py-3 rounded-2xl text-xs lg:text-sm font-semibold hover:bg-green-50 transition-colors shadow-sm flex items-center justify-center space-x-2 w-full">
                        <i class="bi bi-arrow-left-right"></i>
                        <span class="truncate">Penukaran</span>
                    </a>
                    <a href="{{ route('admin.tukar-barang') }}" class="bg-white text-gray-700 px-4 lg:px-6 py-3 rounded-2xl text-xs lg:text-sm font-semibold hover:bg-green-50 transition-colors shadow-sm flex items-center justify-center space-x-2 w-full">
                        <i class="bi bi-gift"></i>
                        <span class="truncate">Tukar Barang</span>
                    </a>
                    <a href="{{ route('admin.waste-types.index') }}" class="bg-white text-gray-700 px-4 lg:px-6 py-3 rounded-2xl text-xs lg:text-sm font-semibold hover:bg-green-50 transition-colors shadow-sm flex items-center justify-center space-x-2 w-full">
                        <i class="bi bi-recycle"></i>
                        <span class="truncate">Jenis Sampah</span>
                    </a>
                    <a href="{{ route('admin.branches.index') }}" class="bg-white text-gray-700 px-4 lg:px-6 py-3 rounded-2xl text-xs lg:text-sm font-semibold hover:bg-green-50 transition-colors shadow-sm flex items-center justify-center space-x-2 w-full">
                        <i class="bi bi-building"></i>
                        <span class="truncate">Cabang</span>
                    </a>
                </div>
            </div>
        </div>
    </header>

    <!-- Main Content -->
    <main class="max-w-6xl mx-auto px-4 py-8">
        
        <!-- Welcome Card -->
        <div class="bg-gradient-to-r from-green-500 to-emerald-600 rounded-2xl p-8 mb-8 text-white shadow-lg">
            <div class="flex flex-col md:flex-row items-start md:items-center justify-between gap-6">
                <div class="flex-1">
                    <h2 class="text-2xl font-bold mb-2">Selamat Datang, Administrator!</h2>
                    <p class="text-green-100 mb-4">Kelola Bank Sampah Digital dengan mudah</p>
                    <div class="flex flex-wrap items-center gap-4 mt-4">
                        <div class="bg-white bg-opacity-20 backdrop-blur-sm text-white px-4 py-2 rounded-lg text-sm font-semibold">
                            <i class="bi bi-shield-check mr-2"></i>Admin Cabang
                        </div>
                        @php
                            $adminBranch = Auth::user()->branch_id ? \App\Models\Branch::find(Auth::user()->branch_id) : null;
                        @endphp
                        @if($adminBranch)
                        <div class="bg-white bg-opacity-20 backdrop-blur-sm text-white px-4 py-2 rounded-lg text-sm font-semibold">
                            <i class="bi bi-geo-alt-fill mr-2"></i>
                            {{ $adminBranch->name }}
                        </div>
                        @endif
                    <p class="text-green-100 mb-4">Kelola seluruh sistem Bank Sampah Digital dengan mudah</p>
                    <div class="flex flex-wrap items-center gap-4 mt-4">
                        <div class="bg-white bg-opacity-20 backdrop-blur-sm text-white px-4 py-2 rounded-lg text-sm font-semibold">
                            Super Admin
                        </div>
                        <span class="text-sm opacity-90">Login: {{ date('d M Y, H:i') }}</span>
                    </div>
                </div>
                <div class="text-center md:text-right">
                    <div class="bg-white bg-opacity-15 backdrop-blur-sm rounded-2xl px-6 py-4">
                        <div class="text-3xl font-bold">{{ date('d') }}</div>
                        <div class="text-sm opacity-90">{{ date('M Y') }}</div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Statistics Cards -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
            <!-- Total Pengguna -->
            <div class="bg-white rounded-2xl p-6 shadow-sm border-l-4 border-teal-500">
                <div class="flex items-center justify-between mb-4">
                    <div class="w-12 h-12 bg-teal-100 rounded-xl flex items-center justify-center">
                        <i class="bi bi-people text-teal-600 text-2xl"></i>
                    </div>
                </div>
                <h3 class="text-gray-500 text-sm mb-1">Total Warga</h3>
                <p class="text-2xl font-bold text-gray-800">{{ $stats['total_users'] ?? 0 }}</p>
                <p class="text-xs text-gray-500 mt-1">Pengguna terdaftar</p>
            </div>

            <!-- Total Setoran -->
            <div class="bg-white rounded-2xl p-6 shadow-sm border-l-4 border-green-500">
                <div class="flex items-center justify-between mb-4">
                    <div class="w-12 h-12 bg-green-100 rounded-xl flex items-center justify-center">
                        <i class="bi bi-graph-up text-green-600 text-2xl"></i>
                    </div>
                </div>
                <h3 class="text-gray-500 text-sm mb-1">Total Setoran</h3>
                <p class="text-2xl font-bold text-gray-800">{{ $stats['total_deposits'] ?? 0 }}</p>
                <p class="text-xs text-gray-500 mt-1">Semua transaksi setoran</p>
            </div>

            <!-- Setoran Pending -->
            <div class="bg-white rounded-2xl p-6 shadow-sm border-l-4 border-yellow-500">
                <div class="flex items-center justify-between mb-4">
                    <div class="w-12 h-12 bg-yellow-100 rounded-xl flex items-center justify-center">
                        <i class="bi bi-clock text-yellow-600 text-2xl"></i>
                    </div>
                    @if($stats['pending_deposits'] > 0)
                    <span class="text-yellow-600 text-sm font-semibold">{{ $stats['pending_deposits'] }} Pending</span>
                    @endif
                </div>
                <h3 class="text-gray-500 text-sm mb-1">Setoran Pending</h3>
                <p class="text-2xl font-bold text-gray-800">{{ $stats['pending_deposits'] ?? 0 }}</p>
                <p class="text-xs text-gray-500 mt-1">Menunggu konfirmasi</p>
            </div>

            <!-- Penukaran Pending -->
            <div class="bg-white rounded-2xl p-6 shadow-sm border-l-4 border-orange-500">
                <div class="flex items-center justify-between mb-4">
                    <div class="w-12 h-12 bg-orange-100 rounded-xl flex items-center justify-center">
                        <i class="bi bi-arrow-left-right text-orange-600 text-2xl"></i>
                    </div>
                    @if($stats['pending_redemptions'] > 0)
                    <span class="text-orange-600 text-sm font-semibold">{{ $stats['pending_redemptions'] }} Pending</span>
                    @endif
                </div>
                <h3 class="text-gray-500 text-sm mb-1">Penukaran Pending</h3>
                <p class="text-2xl font-bold text-gray-800">{{ $stats['pending_redemptions'] ?? 0 }}</p>
                <p class="text-xs text-gray-500 mt-1">Menunggu approval</p>
            </div>
        </div>

        <!-- Charts -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-8">
            <!-- Grafik Setoran -->
            <div class="bg-white rounded-2xl p-6 shadow-sm">
                <h3 class="text-lg font-bold text-gray-800 mb-4">Grafik Setoran (12 Bulan Terakhir)</h3>
                <canvas id="depositsChart"></canvas>
            </div>

            <!-- Grafik Penukaran -->
            <div class="bg-white rounded-2xl p-6 shadow-sm">
                <h3 class="text-lg font-bold text-gray-800 mb-4">Grafik Penukaran (12 Bulan Terakhir)</h3>
                <canvas id="redemptionsChart"></canvas>
                    <span class="text-green-600 text-sm font-semibold">+12%</span>
                </div>
                <h3 class="text-gray-500 text-sm mb-1">Total Setoran</h3>
                <p class="text-2xl font-bold text-gray-800">12</p>
                <p class="text-xs text-gray-500 mt-1">45.8 kg bulan ini</p>
            </div>

            <!-- Penukaran Aktif -->
            <div class="bg-white rounded-2xl p-6 shadow-sm border-l-4 border-emerald-500">
                <div class="flex items-center justify-between mb-4">
                    <div class="w-12 h-12 bg-emerald-100 rounded-xl flex items-center justify-center">
                        <i class="bi bi-arrow-left-right text-emerald-600 text-2xl"></i>
                    </div>
                    <span class="text-emerald-600 text-sm font-semibold">3 Pending</span>
                </div>
                <h3 class="text-gray-500 text-sm mb-1">Penukaran</h3>
                <p class="text-2xl font-bold text-gray-800">8</p>
                <p class="text-xs text-gray-500 mt-1">320 poin ditukar</p>
            </div>

            <!-- Pengguna Aktif -->
            <div class="bg-white rounded-2xl p-6 shadow-sm border-l-4 border-teal-500">
                <div class="flex items-center justify-between mb-4">
                    <div class="w-12 h-12 bg-teal-100 rounded-xl flex items-center justify-center">
                        <i class="bi bi-people text-teal-600 text-2xl"></i>
                    </div>
                    <span class="text-teal-600 text-sm font-semibold">+5</span>
                </div>
                <h3 class="text-gray-500 text-sm mb-1">Pengguna Aktif</h3>
                <p class="text-2xl font-bold text-gray-800">15</p>
                <p class="text-xs text-gray-500 mt-1">Hari ini</p>
            </div>

            <!-- Stok Barang -->
            <div class="bg-white rounded-2xl p-6 shadow-sm border-l-4 border-lime-500">
                <div class="flex items-center justify-between mb-4">
                    <div class="w-12 h-12 bg-lime-100 rounded-xl flex items-center justify-center">
                        <i class="bi bi-box-seam text-lime-600 text-2xl"></i>
                    </div>
                    <span class="text-lime-600 text-sm font-semibold">6 Items</span>
                </div>
                <h3 class="text-gray-500 text-sm mb-1">Stok Barang</h3>
                <p class="text-2xl font-bold text-gray-800">120</p>
                <p class="text-xs text-gray-500 mt-1">Total item tersedia</p>
            </div>
        </div>

        <!-- Quick Actions -->
        <div class="bg-white rounded-2xl p-6 mb-8 shadow-sm">
            <h3 class="text-xl font-bold text-gray-800 mb-6">Quick Actions</h3>
            <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                <a href="{{ route('admin.setoran.index') }}" class="flex flex-col items-center justify-center p-6 bg-gradient-to-br from-green-50 to-green-100 rounded-2xl hover:shadow-md transition-all group">
                <a href="{{ route('admin.setoran') }}" class="flex flex-col items-center justify-center p-6 bg-gradient-to-br from-green-50 to-green-100 rounded-2xl hover:shadow-md transition-all group">
                    <div class="w-16 h-16 bg-green-500 rounded-2xl flex items-center justify-center mb-3 group-hover:scale-110 transition-transform shadow-lg">
                        <i class="bi bi-graph-up text-white text-2xl"></i>
                    </div>
                    <span class="text-sm font-semibold text-gray-700 text-center">Laporan Setoran</span>
                </a>

                <a href="{{ route('admin.penukaran.index') }}" class="flex flex-col items-center justify-center p-6 bg-gradient-to-br from-emerald-50 to-emerald-100 rounded-2xl hover:shadow-md transition-all group">
                <a href="{{ route('admin.penukaran') }}" class="flex flex-col items-center justify-center p-6 bg-gradient-to-br from-emerald-50 to-emerald-100 rounded-2xl hover:shadow-md transition-all group">
                    <div class="w-16 h-16 bg-emerald-500 rounded-2xl flex items-center justify-center mb-3 group-hover:scale-110 transition-transform shadow-lg">
                        <i class="bi bi-check-circle text-white text-2xl"></i>
                    </div>
                    <span class="text-sm font-semibold text-gray-700 text-center">Proses Penukaran</span>
                </a>

                <a href="{{ route('admin.reward-items.index') }}" class="flex flex-col items-center justify-center p-6 bg-gradient-to-br from-teal-50 to-teal-100 rounded-2xl hover:shadow-md transition-all group">
                <a href="{{ route('admin.tukar-barang') }}" class="flex flex-col items-center justify-center p-6 bg-gradient-to-br from-teal-50 to-teal-100 rounded-2xl hover:shadow-md transition-all group">
                    <div class="w-16 h-16 bg-teal-500 rounded-2xl flex items-center justify-center mb-3 group-hover:scale-110 transition-transform shadow-lg">
                        <i class="bi bi-plus-circle text-white text-2xl"></i>
                    </div>
                    <span class="text-sm font-semibold text-gray-700 text-center">Tambah Barang</span>
                </a>

                <a href="{{ route('admin.waste-types.index') }}" class="flex flex-col items-center justify-center p-6 bg-gradient-to-br from-lime-50 to-lime-100 rounded-2xl hover:shadow-md transition-all group">
                    <div class="w-16 h-16 bg-lime-500 rounded-2xl flex items-center justify-center mb-3 group-hover:scale-110 transition-transform shadow-lg">
                        <i class="bi bi-gear text-white text-2xl"></i>
                    </div>
                    <span class="text-sm font-semibold text-gray-700 text-center">Kelola Sampah</span>
                </a>
            </div>
        </div>

        <!-- Recent Activities & System Status -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
            <!-- Recent Activities -->
            <div class="bg-white rounded-2xl p-6 shadow-sm">
                <h3 class="text-lg font-bold text-gray-800 mb-4">Aktivitas Terbaru</h3>
                <div class="space-y-3">
                    <div class="flex items-center space-x-3 p-3 bg-green-50 rounded-xl">
                        <div class="w-10 h-10 bg-green-500 rounded-lg flex items-center justify-center flex-shrink-0">
                            <i class="bi bi-arrow-up text-white"></i>
                        </div>
                        <div class="flex-1 min-w-0">
                            <p class="text-sm font-semibold text-gray-800 truncate">Setoran baru dari Sari Simanullang</p>
                            <p class="text-xs text-gray-500">2 menit yang lalu</p>
                        </div>
                    </div>

                    <div class="flex items-center space-x-3 p-3 bg-emerald-50 rounded-xl">
                        <div class="w-10 h-10 bg-emerald-500 rounded-lg flex items-center justify-center flex-shrink-0">
                            <i class="bi bi-check text-white"></i>
                        </div>
                        <div class="flex-1 min-w-0">
                            <p class="text-sm font-semibold text-gray-800 truncate">Penukaran dikonfirmasi</p>
                            <p class="text-xs text-gray-500">15 menit yang lalu</p>
                        </div>
                    </div>

                    <div class="flex items-center space-x-3 p-3 bg-teal-50 rounded-xl">
                        <div class="w-10 h-10 bg-teal-500 rounded-lg flex items-center justify-center flex-shrink-0">
                            <i class="bi bi-person-plus text-white"></i>
                        </div>
                        <div class="flex-1 min-w-0">
                            <p class="text-sm font-semibold text-gray-800 truncate">Pengguna baru terdaftar</p>
                            <p class="text-xs text-gray-500">1 jam yang lalu</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- System Status -->
            <div class="bg-white rounded-2xl p-6 shadow-sm">
                <h3 class="text-lg font-bold text-gray-800 mb-4">Status Sistem</h3>
                <div class="space-y-4">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center space-x-3">
                            <div class="w-3 h-3 bg-green-500 rounded-full"></div>
                            <span class="text-sm text-gray-700">Database</span>
                        </div>
                        <span class="text-xs font-semibold text-green-600">Online</span>
                    </div>

                    <div class="flex items-center justify-between">
                        <div class="flex items-center space-x-3">
                            <div class="w-3 h-3 bg-green-500 rounded-full"></div>
                            <span class="text-sm text-gray-700">Server</span>
                        </div>
                        <span class="text-xs font-semibold text-green-600">Running</span>
                    </div>

                    <div class="flex items-center justify-between">
                        <div class="flex items-center space-x-3">
                            <div class="w-3 h-3 bg-green-500 rounded-full"></div>
                            <span class="text-sm text-gray-700">Cache</span>
                        </div>
                        <span class="text-xs font-semibold text-green-600">Active</span>
                    </div>

                    <div class="flex items-center justify-between">
                        <div class="flex items-center space-x-3">
                            <div class="w-3 h-3 bg-lime-500 rounded-full"></div>
                            <span class="text-sm text-gray-700">Storage</span>
                        </div>
                        <span class="text-xs font-semibold text-lime-600">75% Used</span>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <!-- Footer -->
    <footer class="bg-gradient-to-r from-green-50 to-emerald-50 py-8 mt-12 border-t border-green-200">
        <div class="max-w-6xl mx-auto px-4">
            <div class="flex flex-col items-center gap-4">
                <div class="w-16 h-16 bg-gradient-to-br from-green-500 to-green-600 rounded-2xl flex items-center justify-center shadow-lg">
                    <i class="bi bi-recycle text-white text-3xl"></i>
                </div>
                <h3 class="text-xl font-bold text-green-600">Green Saving Admin Panel</h3>
                <p class="text-sm text-gray-600 text-center">
                    Sistem Manajemen Bank Sampah Digital
                </p>
                <p class="text-sm text-gray-500">© 2025 Green Saving. All rights reserved.</p>
            </div>
        </div>
    </footer>


    <!-- Chart.js Script -->
    <script>
        // Data dari backend
        const depositsByMonth = @json($depositsByMonth);
        const redemptionsByMonth = @json($redemptionsByMonth);

        // Extract labels and values
        const depositsLabels = depositsByMonth.map(item => item.label);
        const depositsValues = depositsByMonth.map(item => item.value);
        const redemptionsLabels = redemptionsByMonth.map(item => item.label);
        const redemptionsValues = redemptionsByMonth.map(item => item.value);

        // Deposits Chart
        const depositsCtx = document.getElementById('depositsChart').getContext('2d');
        new Chart(depositsCtx, {
            type: 'line',
            data: {
                labels: depositsLabels,
                datasets: [{
                    label: 'Total Setoran',
                    data: depositsValues,
                    borderColor: 'rgb(34, 197, 94)',
                    backgroundColor: 'rgba(34, 197, 94, 0.1)',
                    borderWidth: 3,
                    tension: 0.4,
                    fill: true,
                    pointRadius: 4,
                    pointHoverRadius: 6,
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: true,
                plugins: {
                    legend: {
                        display: false
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            stepSize: 1
                        }
                    }
                }
            }
        });

        // Redemptions Chart
        const redemptionsCtx = document.getElementById('redemptionsChart').getContext('2d');
        new Chart(redemptionsCtx, {
            type: 'bar',
            data: {
                labels: redemptionsLabels,
                datasets: [{
                    label: 'Total Penukaran',
                    data: redemptionsValues,
                    backgroundColor: 'rgba(20, 184, 166, 0.7)',
                    borderColor: 'rgb(20, 184, 166)',
                    borderWidth: 2,
                    borderRadius: 8,
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: true,
                plugins: {
                    legend: {
                        display: false
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            stepSize: 1
                        }
                    }
                }
            }
        });
    </script>


</body>
</html>
