<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Setor Sampah - Green Saving</title>
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

        // Tab switching functionality
        function switchTab(tabName) {
            // Hide all tab contents
            document.querySelectorAll('.tab-content').forEach(content => {
                content.classList.add('hidden');
            });
            
            // Remove active state from all tabs
            document.querySelectorAll('.tab-button').forEach(tab => {
                tab.classList.remove('text-green-600', 'border-green-600', 'border-b-2');
                tab.classList.add('text-gray-500');
            });
            
            // Show selected tab content
            document.getElementById(tabName + '-content').classList.remove('hidden');
            
            // Add active state to selected tab
            const activeTab = document.getElementById(tabName + '-tab');
            activeTab.classList.remove('text-gray-500');
            activeTab.classList.add('text-green-600', 'border-green-600', 'border-b-2');
        }
    </script>
</head>
<body class="min-h-screen bg-gradient-to-br from-green-50 to-green-100 font-poppins">

    <!-- Header -->
    <header class="bg-white shadow-sm">
        <div class="max-w-6xl mx-auto px-4 py-6">
            <div class="flex justify-between items-center">
                <!-- Logo -->
                <div class="flex items-center space-x-3">
                    <div class="w-12 h-12 bg-green-500 rounded-xl flex items-center justify-center shadow-md">
                        @if(file_exists(public_path('images/logo user.png')))
                            <img src="{{ asset('images/logo user.png') }}" alt="Green Saving Logo" class="w-8 h-8 object-contain">
                        @else
                            <div class="w-7 h-7 bg-white rounded-lg flex items-center justify-center">
                                <div class="w-4 h-4 bg-green-500 rounded-sm"></div>
                            </div>
                        @endif
                    </div>
                    <div>
                        <h1 class="text-xl font-bold text-gray-800">Green Saving</h1>
                        <p class="text-sm text-gray-500">Halo, {{ Auth::user()->full_name ?? Auth::user()->name ?? 'Budi Santoso' }}</p>
                    </div>
                </div>

                <!-- Points and Actions -->
                <div class="flex items-center space-x-4">
                    <div class="bg-green-100 px-6 py-2 rounded-full">
                        <span class="text-lg font-bold text-green-700">15420 poin</span>
                    </div>
                    <button class="w-10 h-10 bg-gray-100 rounded-xl flex items-center justify-center hover:bg-gray-200 transition-colors">
                        <i class="bi bi-bell text-gray-600"></i>
                    </button>
                    <a href="/profil" class="w-10 h-10 bg-gray-100 rounded-xl flex items-center justify-center hover:bg-gray-200 transition-colors">
                        <i class="bi bi-person-circle text-gray-600"></i>
                    </a>
                    <form method="POST" action="/logout" class="inline">
                        @csrf
                        <button type="submit" class="w-10 h-10 bg-gray-100 rounded-xl flex items-center justify-center hover:bg-gray-200 transition-colors">
                            <i class="bi bi-box-arrow-right text-gray-600"></i>
                        </button>
                    </form>
                </div>
            </div>
        </div>

        <!-- Navigation Tabs -->
        <div class="bg-green-100 px-4 py-4">
            <div class="max-w-6xl mx-auto">
                <!-- Navigation grid for consistent spacing -->
                <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-6 gap-3">
                    <a href="/dashboard" class="bg-white text-gray-700 px-4 lg:px-6 py-3 rounded-2xl text-xs lg:text-sm font-semibold hover:bg-green-50 transition-colors shadow-sm flex items-center justify-center space-x-2 w-full cursor-pointer">
                        <i class="bi bi-house-door pointer-events-none"></i>
                        <span class="truncate pointer-events-none">Dashboard</span>
                    </a>
                    <a href="/profil" class="bg-white text-gray-700 px-4 lg:px-6 py-3 rounded-2xl text-xs lg:text-sm font-semibold hover:bg-green-50 transition-colors shadow-sm flex items-center justify-center space-x-2 w-full cursor-pointer">
                        <i class="bi bi-person pointer-events-none"></i>
                        <span class="truncate pointer-events-none">Profil</span>
                    </a>
                    <a href="/setor" class="bg-green-500 text-white px-4 lg:px-6 py-3 rounded-2xl text-xs lg:text-sm font-semibold shadow-md flex items-center justify-center space-x-2 w-full cursor-default">
                        <i class="bi bi-recycle pointer-events-none"></i>
                        <span class="truncate pointer-events-none">Setor</span>
                    </a>
                    <a href="/tukar-poin" class="bg-white text-gray-700 px-4 lg:px-6 py-3 rounded-2xl text-xs lg:text-sm font-semibold hover:bg-green-50 transition-colors shadow-sm flex items-center justify-center space-x-2 w-full cursor-pointer">
                        <i class="bi bi-gift pointer-events-none"></i>
                        <span class="truncate pointer-events-none">Tukar Poin</span>
                    </a>
                    <button class="bg-white text-gray-700 px-4 lg:px-6 py-3 rounded-2xl text-xs lg:text-sm font-semibold hover:bg-green-50 transition-colors shadow-sm flex items-center justify-center space-x-2 w-full cursor-not-allowed opacity-60">
                        <i class="bi bi-bar-chart pointer-events-none"></i>
                        <span class="truncate pointer-events-none">Riwayat</span>
                    </button>
                    <button class="bg-white text-gray-700 px-4 lg:px-6 py-3 rounded-2xl text-xs lg:text-sm font-semibold hover:bg-green-50 transition-colors shadow-sm flex items-center justify-center space-x-2 w-full cursor-not-allowed opacity-60">
                        <i class="bi bi-bell pointer-events-none"></i>
                        <span class="truncate pointer-events-none">Notifikasi</span>
                    </button>
                </div>
            </div>
        </div>
    </header>

    <!-- Main Content -->
    <main class="max-w-6xl mx-auto px-4 py-8">
        
        <!-- Page Header with Tabs -->
        <div class="bg-white rounded-2xl shadow-sm overflow-hidden mb-6">
            <div class="p-6 pb-0">
                <h2 class="text-xl font-bold text-gray-800 mb-2">Setor Sampah</h2>
                <p class="text-sm text-gray-500 mb-6">Kelola setoran sampah Anda dan dapatkan poin</p>
            </div>

            <!-- Tabs -->
            <div class="flex border-b border-gray-200 px-6">
                <button id="panduan-tab" onclick="switchTab('panduan')" class="tab-button flex-1 sm:flex-none px-6 py-4 text-sm font-semibold text-green-600 border-b-2 border-green-600 flex items-center justify-center gap-2 transition-colors">
                    <i class="bi bi-compass"></i>
                    <span>Panduan</span>
                </button>
                <button id="riwayat-tab" onclick="switchTab('riwayat')" class="tab-button flex-1 sm:flex-none px-6 py-4 text-sm font-semibold text-gray-500 hover:bg-gray-50 flex items-center justify-center gap-2 transition-colors">
                    <i class="bi bi-clock-history"></i>
                    <span>Riwayat</span>
                </button>
            </div>
        </div>

        <!-- Tab Content: Panduan -->
        <div id="panduan-content" class="tab-content">`
        <!-- Jenis Sampah yang Diterima Section -->
        <div class="bg-white rounded-2xl p-6 mb-6 shadow-sm">
            <h2 class="text-xl font-bold text-gray-800 mb-2">Jenis Sampah yang Diterima</h2>
            <p class="text-sm text-gray-500 mb-6">Lihat daftar jenis sampah dan poin yang bisa Anda dapatkan</p>

            <div class="space-y-4">
                <!-- Plastik -->
                <div class="flex items-center justify-between p-4 bg-gray-50 rounded-xl hover:bg-gray-100 transition-colors">
                    <div class="flex items-center space-x-3">
                        <div class="w-12 h-12 bg-green-100 rounded-xl flex items-center justify-center flex-shrink-0">
                            <i class="bi bi-recycle text-green-600 text-2xl"></i>
                        </div>
                        <div>
                            <h4 class="font-bold text-gray-800">Plastik</h4>
                            <p class="text-sm text-gray-600">Botol plastik, kemasan plastik</p>
                            <span class="inline-block px-2 py-1 bg-green-100 text-green-700 text-xs font-medium rounded mt-1">Plastik</span>
                        </div>
                    </div>
                    <div class="text-right">
                        <p class="text-green-600 font-bold text-lg">300 poin/kg</p>
                    </div>
                </div>

                <!-- Kertas/Kardus -->
                <div class="flex items-center justify-between p-4 bg-gray-50 rounded-xl hover:bg-gray-100 transition-colors">
                    <div class="flex items-center space-x-3">
                        <div class="w-12 h-12 bg-amber-100 rounded-xl flex items-center justify-center flex-shrink-0">
                            <i class="bi bi-box-seam text-amber-600 text-2xl"></i>
                        </div>
                        <div>
                            <h4 class="font-bold text-gray-800">Kertas/Kardus</h4>
                            <p class="text-sm text-gray-600">Kertas bekas, kardus, majalah, koran</p>
                            <span class="inline-block px-2 py-1 bg-amber-100 text-amber-700 text-xs font-medium rounded mt-1">Kertas</span>
                        </div>
                    </div>
                    <div class="text-right">
                        <p class="text-green-600 font-bold text-lg">150 poin/kg</p>
                    </div>
                </div>

                <!-- Kaleng Alumunium -->
                <div class="flex items-center justify-between p-4 bg-gray-50 rounded-xl hover:bg-gray-100 transition-colors">
                    <div class="flex items-center space-x-3">
                        <div class="w-12 h-12 bg-gray-200 rounded-xl flex items-center justify-center flex-shrink-0">
                            <i class="bi bi-cup-straw text-gray-600 text-2xl"></i>
                        </div>
                        <div>
                            <h4 class="font-bold text-gray-800">Kaleng Alumunium</h4>
                            <p class="text-sm text-gray-600">Kaleng minuman, kemasan makanan kaleng</p>
                            <span class="inline-block px-2 py-1 bg-gray-200 text-gray-700 text-xs font-medium rounded mt-1">Logam</span>
                        </div>
                    </div>
                    <div class="text-right">
                        <p class="text-green-600 font-bold text-lg">1200 poin/kg</p>
                    </div>
                </div>

                <!-- Kaca -->
                <div class="flex items-center justify-between p-4 bg-gray-50 rounded-xl hover:bg-gray-100 transition-colors">
                    <div class="flex items-center space-x-3">
                        <div class="w-12 h-12 bg-blue-100 rounded-xl flex items-center justify-center flex-shrink-0">
                            <i class="bi bi-droplet text-blue-600 text-2xl"></i>
                        </div>
                        <div>
                            <h4 class="font-bold text-gray-800">Kaca</h4>
                            <p class="text-sm text-gray-600">Botol kaca, pecahan kaca bersih</p>
                            <span class="inline-block px-2 py-1 bg-blue-100 text-blue-700 text-xs font-medium rounded mt-1">Kaca</span>
                        </div>
                    </div>
                    <div class="text-right">
                        <p class="text-green-600 font-bold text-lg">100 poin/kg</p>
                    </div>
                </div>

                <!-- Logam Lainnya -->
                <div class="flex items-center justify-between p-4 bg-gray-50 rounded-xl hover:bg-gray-100 transition-colors">
                    <div class="flex items-center space-x-3">
                        <div class="w-12 h-12 bg-orange-100 rounded-xl flex items-center justify-center flex-shrink-0">
                            <i class="bi bi-basket text-orange-600 text-2xl"></i>
                        </div>
                        <div>
                            <h4 class="font-bold text-gray-800">Logam Lainnya</h4>
                            <p class="text-sm text-gray-600">Besi bekas, tembaga, kuningan</p>
                            <span class="inline-block px-2 py-1 bg-orange-100 text-orange-700 text-xs font-medium rounded mt-1">Logam</span>
                        </div>
                    </div>
                    <div class="text-right">
                        <p class="text-green-600 font-bold text-lg">1000 poin/kg</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Cara Setor Sampah Section -->
        <div class="bg-white rounded-2xl p-6 shadow-sm">
            <h2 class="text-xl font-bold text-gray-800 mb-2">Cara Setor Sampah</h2>
            <p class="text-sm text-gray-500 mb-6">Panduan lengkap untuk menyetor sampah dan mendapatkan poin</p>

            <!-- Tahap 1: Persiapan -->
            <div class="mb-6">
                <div class="flex items-center space-x-2 mb-4">
                    <div class="w-8 h-8 bg-green-500 rounded-lg flex items-center justify-center">
                        <span class="text-white font-bold text-sm">1</span>
                    </div>
                    <h3 class="font-bold text-gray-800">Tahap 1: Persiapan (Warga)</h3>
                </div>
                <div class="ml-10 space-y-3">
                    <div class="flex items-start space-x-3 p-3 bg-gray-50 rounded-lg">
                        <div class="w-6 h-6 bg-green-500 text-white rounded-full flex items-center justify-center flex-shrink-0 text-xs font-bold mt-0.5">
                            1
                        </div>
                        <div>
                            <p class="font-semibold text-gray-800 mb-1">Pilah dan Bersihkan Sampah</p>
                            <p class="text-sm text-gray-600">Pastikan sampah sudah dibersihkan dari sisa makanan dan dipisahkan berdasarkan jenisnya.</p>
                        </div>
                    </div>
                    <div class="flex items-start space-x-3 p-3 bg-gray-50 rounded-lg">
                        <div class="w-6 h-6 bg-green-500 text-white rounded-full flex items-center justify-center flex-shrink-0 text-xs font-bold mt-0.5">
                            2
                        </div>
                        <div>
                            <p class="font-semibold text-gray-800 mb-1">Kunjungi Cabang</p>
                            <p class="text-sm text-gray-600">Bawa sampah yang telah di pilah dan dibersihkan ke bank sampah terdekat dari lokasi Anda.</p>
                        </div>
                    </div>
                    <div class="flex items-start space-x-3 p-3 bg-gray-50 rounded-lg">
                        <div class="w-6 h-6 bg-green-500 text-white rounded-full flex items-center justify-center flex-shrink-0 text-xs font-bold mt-0.5">
                            3
                        </div>
                        <div>
                            <p class="font-semibold text-gray-800 mb-1">Datang ke Bank Sampah Terdekat</p>
                            <p class="text-sm text-gray-600">Bawa sampah yang sudah di pilah dan dibersihkan ke bank sampah terdekat dari lokasi Anda.</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Tahap 2: Transaksi -->
            <div class="mb-6">
                <div class="flex items-center space-x-2 mb-4">
                    <div class="w-8 h-8 bg-blue-500 rounded-lg flex items-center justify-center">
                        <span class="text-white font-bold text-sm">2</span>
                    </div>
                    <h3 class="font-bold text-gray-800">Tahap 2: Transaksi di Lokasi (Peran Admin & Sistem)</h3>
                </div>
                <div class="ml-10 space-y-3">
                    <div class="flex items-start space-x-3 p-3 bg-gray-50 rounded-lg">
                        <div class="w-6 h-6 bg-blue-500 text-white rounded-full flex items-center justify-center flex-shrink-0 text-xs font-bold mt-0.5">
                            1
                        </div>
                        <div>
                            <p class="font-semibold text-gray-800 mb-1">Serahkan ID akun Warga Anda</p>
                            <p class="text-sm text-gray-600">Atau tunjukkan kode ID di aplikasi/website kepada Admin Cabang yang bertugas.</p>
                        </div>
                    </div>
                    <div class="flex items-start space-x-3 p-3 bg-gray-50 rounded-lg">
                        <div class="w-6 h-6 bg-blue-500 text-white rounded-full flex items-center justify-center flex-shrink-0 text-xs font-bold mt-0.5">
                            2
                        </div>
                        <div>
                            <p class="font-semibold text-gray-800 mb-1">Penimbangan dan Pencatatan</p>
                            <p class="text-sm text-gray-600">Admin akan menimbang sampah Anda dan menginput jenis serta beratnya ke dalam sistem.</p>
                        </div>
                    </div>
                    <div class="flex items-start space-x-3 p-3 bg-gray-50 rounded-lg">
                        <div class="w-6 h-6 bg-blue-500 text-white rounded-full flex items-center justify-center flex-shrink-0 text-xs font-bold mt-0.5">
                            3
                        </div>
                        <div>
                            <p class="font-semibold text-gray-800 mb-1">Verifikasi Lokasi</p>
                            <p class="text-sm text-gray-600">Sistem secara otomatis mencatat setoran ini di cabang Bank Sampah tempat Anda berada.</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Tahap 3: Poin Masuk -->
            <div class="mb-2">
                <div class="flex items-center space-x-2 mb-4">
                    <div class="w-8 h-8 bg-purple-500 rounded-lg flex items-center justify-center">
                        <span class="text-white font-bold text-sm">3</span>
                    </div>
                    <h3 class="font-bold text-gray-800">Tahap 3: Poin Masuk (Peran Sistem)</h3>
                </div>
                <div class="ml-10 space-y-3">
                    <div class="flex items-start space-x-3 p-3 bg-gray-50 rounded-lg">
                        <div class="w-6 h-6 bg-purple-500 text-white rounded-full flex items-center justify-center flex-shrink-0 text-xs font-bold mt-0.5">
                            1
                        </div>
                        <div>
                            <p class="font-semibold text-gray-800 mb-1">Poin Dihitung</p>
                            <p class="text-sm text-gray-600">Sistem secara otomatis menghitung total poin Anda.</p>
                        </div>
                    </div>
                    <div class="flex items-start space-x-3 p-3 bg-gray-50 rounded-lg">
                        <div class="w-6 h-6 bg-purple-500 text-white rounded-full flex items-center justify-center flex-shrink-0 text-xs font-bold mt-0.5">
                            2
                        </div>
                        <div>
                            <p class="font-semibold text-gray-800 mb-1">Verifikasi Admin</p>
                            <p class="text-sm text-gray-600">Admin akan mengkonfirmasi transaksi di sistem. Setelah dikonfirmasi, poin Anda langsung dimasukkan ke saldo.</p>
                        </div>
                    </div>
                    <div class="flex items-start space-x-3 p-3 bg-gray-50 rounded-lg">
                        <div class="w-6 h-6 bg-purple-500 text-white rounded-full flex items-center justify-center flex-shrink-0 text-xs font-bold mt-0.5">
                            3
                        </div>
                        <div>
                            <p class="font-semibold text-gray-800 mb-1">Cek Saldo</p>
                            <p class="text-sm text-gray-600">Anda akan menerima notifikasi bahwa setoran sudah diverifikasi dan poin berhasil ditambahkan. Cek Dashboard Anda untuk melihat saldo terbaru.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        </div>
        <!-- End Tab Content: Panduan -->

        <!-- Tab Content: Riwayat -->
        <div id="riwayat-content" class="tab-content hidden">
            <div class="bg-white rounded-2xl p-6 shadow-sm">
                <h2 class="text-xl font-bold text-gray-800 mb-2">Riwayat Setoran Sampah</h2>
                <p class="text-sm text-gray-500 mb-6">Lihat semua transaksi setoran sampah Anda</p>

                <div class="space-y-4">
                    <!-- Riwayat Item 1 -->
                    <div class="bg-white border border-gray-200 rounded-2xl p-5 hover:shadow-md transition-shadow">
                        <div class="flex items-start gap-4">
                            <!-- Icon -->
                            <div class="w-14 h-14 bg-green-100 rounded-xl flex items-center justify-center flex-shrink-0">
                                <i class="bi bi-recycle text-green-600 text-2xl"></i>
                            </div>
                            
                            <!-- Content -->
                            <div class="flex-1">
                                <div class="flex items-start justify-between mb-3">
                                    <div>
                                        <h4 class="font-bold text-gray-800 mb-1">Plastik, Kardus</h4>
                                        <p class="text-sm font-medium text-gray-600 mb-1">2.5kg</p>
                                        <div class="flex items-center text-sm text-gray-500">
                                            <i class="bi bi-geo-alt text-xs mr-1"></i>
                                            <span>Bank Sampah Sitoluama</span>
                                        </div>
                                    </div>
                                    <div class="flex items-center bg-green-50 px-3 py-1 rounded-full">
                                        <i class="bi bi-check-circle-fill text-green-600 text-sm mr-1"></i>
                                        <span class="text-xs font-semibold text-green-700">Completed</span>
                                    </div>
                                </div>
                                
                                <!-- Details Grid -->
                                <div class="grid grid-cols-1 sm:grid-cols-3 gap-3 pt-3 border-t border-gray-100">
                                    <div>
                                        <p class="text-xs text-gray-500 mb-1">Tanggal & Waktu</p>
                                        <p class="text-sm font-semibold text-gray-700">
                                            <i class="bi bi-calendar3 text-gray-400 text-xs mr-1"></i>
                                            2025-3-9 · 10:15
                                        </p>
                                    </div>
                                    <div>
                                        <p class="text-xs text-gray-500 mb-1">Point</p>
                                        <p class="text-sm font-bold text-green-600">
                                            <i class="bi bi-coin text-green-500 mr-1"></i>
                                            750 poin
                                        </p>
                                    </div>
                                    <div>
                                        <p class="text-xs text-gray-500 mb-1">Status</p>
                                        <p class="text-sm font-semibold text-green-600">
                                            <i class="bi bi-check-circle text-green-500 mr-1"></i>
                                            Completed
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Riwayat Item 2 -->
                    <div class="bg-white border border-gray-200 rounded-2xl p-5 hover:shadow-md transition-shadow">
                        <div class="flex items-start gap-4">
                            <!-- Icon -->
                            <div class="w-14 h-14 bg-green-100 rounded-xl flex items-center justify-center flex-shrink-0">
                                <i class="bi bi-recycle text-green-600 text-2xl"></i>
                            </div>
                            
                            <!-- Content -->
                            <div class="flex-1">
                                <div class="flex items-start justify-between mb-3">
                                    <div>
                                        <h4 class="font-bold text-gray-800 mb-1">Plastik</h4>
                                        <p class="text-sm font-medium text-gray-600 mb-1">2.5kg</p>
                                        <div class="flex items-center text-sm text-gray-500">
                                            <i class="bi bi-geo-alt text-xs mr-1"></i>
                                            <span>Bank Sampah Laguboti</span>
                                        </div>
                                    </div>
                                    <div class="flex items-center bg-green-50 px-3 py-1 rounded-full">
                                        <i class="bi bi-check-circle-fill text-green-600 text-sm mr-1"></i>
                                        <span class="text-xs font-semibold text-green-700">Completed</span>
                                    </div>
                                </div>
                                
                                <!-- Details Grid -->
                                <div class="grid grid-cols-1 sm:grid-cols-3 gap-3 pt-3 border-t border-gray-100">
                                    <div>
                                        <p class="text-xs text-gray-500 mb-1">Tanggal & Waktu</p>
                                        <p class="text-sm font-semibold text-gray-700">
                                            <i class="bi bi-calendar3 text-gray-400 text-xs mr-1"></i>
                                            2025-3-9 · 10:15
                                        </p>
                                    </div>
                                    <div>
                                        <p class="text-xs text-gray-500 mb-1">Point</p>
                                        <p class="text-sm font-bold text-green-600">
                                            <i class="bi bi-coin text-green-500 mr-1"></i>
                                            750 poin
                                        </p>
                                    </div>
                                    <div>
                                        <p class="text-xs text-gray-500 mb-1">Status</p>
                                        <p class="text-sm font-semibold text-green-600">
                                            <i class="bi bi-check-circle text-green-500 mr-1"></i>
                                            Completed
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Riwayat Item 3 -->
                    <div class="bg-white border border-gray-200 rounded-2xl p-5 hover:shadow-md transition-shadow">
                        <div class="flex items-start gap-4">
                            <!-- Icon -->
                            <div class="w-14 h-14 bg-green-100 rounded-xl flex items-center justify-center flex-shrink-0">
                                <i class="bi bi-recycle text-green-600 text-2xl"></i>
                            </div>
                            
                            <!-- Content -->
                            <div class="flex-1">
                                <div class="flex items-start justify-between mb-3">
                                    <div>
                                        <h4 class="font-bold text-gray-800 mb-1">Plastik</h4>
                                        <p class="text-sm font-medium text-gray-600 mb-1">2.5kg</p>
                                        <div class="flex items-center text-sm text-gray-500">
                                            <i class="bi bi-geo-alt text-xs mr-1"></i>
                                            <span>Bank Sampah Balige</span>
                                        </div>
                                    </div>
                                    <div class="flex items-center bg-green-50 px-3 py-1 rounded-full">
                                        <i class="bi bi-check-circle-fill text-green-600 text-sm mr-1"></i>
                                        <span class="text-xs font-semibold text-green-700">Completed</span>
                                    </div>
                                </div>
                                
                                <!-- Details Grid -->
                                <div class="grid grid-cols-1 sm:grid-cols-3 gap-3 pt-3 border-t border-gray-100">
                                    <div>
                                        <p class="text-xs text-gray-500 mb-1">Tanggal & Waktu</p>
                                        <p class="text-sm font-semibold text-gray-700">
                                            <i class="bi bi-calendar3 text-gray-400 text-xs mr-1"></i>
                                            2025-3-9 · 10:15
                                        </p>
                                    </div>
                                    <div>
                                        <p class="text-xs text-gray-500 mb-1">Point</p>
                                        <p class="text-sm font-bold text-green-600">
                                            <i class="bi bi-coin text-green-500 mr-1"></i>
                                            750 poin
                                        </p>
                                    </div>
                                    <div>
                                        <p class="text-xs text-gray-500 mb-1">Status</p>
                                        <p class="text-sm font-semibold text-green-600">
                                            <i class="bi bi-check-circle text-green-500 mr-1"></i>
                                            Completed
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Riwayat Item 4 -->
                    <div class="bg-white border border-gray-200 rounded-2xl p-5 hover:shadow-md transition-shadow">
                        <div class="flex items-start gap-4">
                            <!-- Icon -->
                            <div class="w-14 h-14 bg-green-100 rounded-xl flex items-center justify-center flex-shrink-0">
                                <i class="bi bi-recycle text-green-600 text-2xl"></i>
                            </div>
                            
                            <!-- Content -->
                            <div class="flex-1">
                                <div class="flex items-start justify-between mb-3">
                                    <div>
                                        <h4 class="font-bold text-gray-800 mb-1">Plastik</h4>
                                        <p class="text-sm font-medium text-gray-600 mb-1">2.5kg</p>
                                        <div class="flex items-center text-sm text-gray-500">
                                            <i class="bi bi-geo-alt text-xs mr-1"></i>
                                            <span>Bank Sampah Sitoluama</span>
                                        </div>
                                    </div>
                                    <div class="flex items-center bg-green-50 px-3 py-1 rounded-full">
                                        <i class="bi bi-check-circle-fill text-green-600 text-sm mr-1"></i>
                                        <span class="text-xs font-semibold text-green-700">Completed</span>
                                    </div>
                                </div>
                                
                                <!-- Details Grid -->
                                <div class="grid grid-cols-1 sm:grid-cols-3 gap-3 pt-3 border-t border-gray-100">
                                    <div>
                                        <p class="text-xs text-gray-500 mb-1">Tanggal & Waktu</p>
                                        <p class="text-sm font-semibold text-gray-700">
                                            <i class="bi bi-calendar3 text-gray-400 text-xs mr-1"></i>
                                            2025-3-9 · 10:15
                                        </p>
                                    </div>
                                    <div>
                                        <p class="text-xs text-gray-500 mb-1">Point</p>
                                        <p class="text-sm font-bold text-green-600">
                                            <i class="bi bi-coin text-green-500 mr-1"></i>
                                            750 poin
                                        </p>
                                    </div>
                                    <div>
                                        <p class="text-xs text-gray-500 mb-1">Status</p>
                                        <p class="text-sm font-semibold text-green-600">
                                            <i class="bi bi-check-circle text-green-500 mr-1"></i>
                                            Completed
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Pagination atau Load More bisa ditambahkan di sini -->
                <div class="mt-6 text-center">
                    <button class="px-6 py-3 bg-gray-100 text-gray-700 rounded-xl font-semibold hover:bg-gray-200 transition-colors">
                        <i class="bi bi-arrow-clockwise mr-2"></i>
                        Muat Lebih Banyak
                    </button>
                </div>
            </div>
        </div>
        <!-- End Tab Content: Riwayat -->

    </main>

    <!-- Footer -->
    <div class="bg-white border-t mt-8 py-6">
        <div class="max-w-6xl mx-auto px-4">
            <div class="flex items-center justify-center space-x-4">
                <!-- Green Saving Logo -->
                <div class="w-12 h-12 bg-green-500 rounded-2xl flex items-center justify-center shadow-md">
                    @if(file_exists(public_path('images/logo user.png')))
                        <img src="{{ asset('images/logo user.png') }}" alt="Green Saving Logo" class="w-8 h-8 object-contain">
                    @else
                        <div class="w-7 h-7 bg-white rounded-lg flex items-center justify-center">
                            <div class="w-4 h-4 bg-green-500 rounded-sm"></div>
                        </div>
                    @endif
                </div>
                <div class="text-center">
                    <h3 class="text-xl font-bold text-green-600">Green Saving</h3>
                    <p class="text-sm text-gray-500 mt-1">Bersama menjaga lingkungan untuk masa depan lebih baik</p>
                </div>
            </div>
        </div>
    </div>

    <footer class="bg-green-50 py-4">
        <div class="max-w-6xl mx-auto px-4">
            <div class="text-center text-xs text-gray-500">
                © 2025 Green Saving. All rights reserved.
            </div>
        </div>
    </footer>

</body>
</html>
