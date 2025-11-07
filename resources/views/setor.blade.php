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
                    <div class="w-12 h-12 bg-gradient-to-br from-green-500 to-green-600 rounded-xl flex items-center justify-center shadow-lg">
                        <i class="bi bi-recycle text-white text-2xl"></i>
                    </div>
                    <div>
                        <h1 class="font-bold text-xl text-gray-800">Green Saving</h1>
                        <p class="text-sm text-green-600">Halo, {{ Auth::user()->full_name ?? Auth::user()->name ?? 'lisbeth' }}</p>
                    </div>
                </div>

                <!-- Points & Actions -->
                <div class="flex items-center space-x-4">
                    <!-- Points Display -->
                    <div class="bg-gradient-to-r from-green-100 to-green-50 px-6 py-3 rounded-full border-2 border-green-300 shadow-md">
                        <div class="flex items-center space-x-2">
                            <i class="bi bi-coin text-green-600 text-xl"></i>
                            <span class="font-bold text-green-700 text-lg">15420 poin</span>
                        </div>
                    </div>

                    <!-- Notification Bell -->
                    <a href="/notifikasi" class="w-12 h-12 bg-gray-100 hover:bg-gray-200 rounded-xl flex items-center justify-center transition-all">
                        <i class="bi bi-bell text-gray-700 text-xl"></i>
                    </a>

                    <!-- Profile Button -->
                    <a href="/profil" class="w-12 h-12 bg-green-500 hover:bg-green-600 rounded-xl flex items-center justify-center transition-all">
                        <i class="bi bi-person-fill text-white text-xl"></i>
                    </a>

                    <!-- Logout Button -->
                    <form method="POST" action="/logout" class="inline">
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
                    <a href="/riwayat" class="bg-white text-gray-700 px-4 lg:px-6 py-3 rounded-2xl text-xs lg:text-sm font-semibold hover:bg-green-50 transition-colors shadow-sm flex items-center justify-center space-x-2 w-full cursor-pointer">
                        <i class="bi bi-clock-history pointer-events-none"></i>
                        <span class="truncate pointer-events-none">Riwayat</span>
                    </a>
                    <a href="/notifikasi" class="bg-white text-gray-700 px-4 lg:px-6 py-3 rounded-2xl text-xs lg:text-sm font-semibold hover:bg-green-50 transition-colors shadow-sm flex items-center justify-center space-x-2 w-full cursor-pointer">
                        <i class="bi bi-bell pointer-events-none"></i>
                        <span class="truncate pointer-events-none">Notifikasi</span>
                    </a>
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
                    <!-- Riwayat Item 1 - Clickable -->
                    <div onclick="showTransactionDetail('TRX001', 'Completed', 'Bank Sampah Sitolusna', '2025-2-10', '10:15', 'Admin Verifikator', 750, 2000, 2750)" 
                         class="bg-white border border-gray-200 rounded-2xl p-5 hover:shadow-lg hover:border-green-300 transition-all cursor-pointer">
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
                                            <span>Bank Sampah Sitolusna</span>
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
                                            2025-2-10 · 10:15
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
                    <div onclick="showTransactionDetail('TRX-20250309-002', 'Completed', 'Bank Sampah Laguboti', '2025-3-9', '10:15', 'Joko Susanto', 750, 1500, 2250)" 
                         class="bg-white border border-gray-200 rounded-2xl p-5 hover:shadow-lg hover:border-green-300 transition-all cursor-pointer">
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
                    <div onclick="showTransactionDetail('TRX-20250308-003', 'Completed', 'Bank Sampah Balige', '2025-3-8', '14:30', 'Siti Aminah', 750, 1000, 1750)" 
                         class="bg-white border border-gray-200 rounded-2xl p-5 hover:shadow-lg hover:border-green-300 transition-all cursor-pointer">
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
                    <div onclick="showTransactionDetail('TRX-20250307-004', 'Completed', 'Bank Sampah Sitolusna', '2025-3-7', '09:00', 'Ahmad Rizki', 900, 500, 1400)" 
                         class="bg-white border border-gray-200 rounded-2xl p-5 hover:shadow-lg hover:border-green-300 transition-all cursor-pointer">
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
    <footer class="bg-gradient-to-r from-green-50 to-emerald-50 py-8 mt-12 border-t border-green-200">
        <div class="max-w-6xl mx-auto px-4">
            <div class="flex flex-col items-center gap-4">
                <!-- Logo -->
                <div class="w-16 h-16 bg-gradient-to-br from-green-500 to-green-600 rounded-2xl flex items-center justify-center shadow-lg">
                    <i class="bi bi-recycle text-white text-3xl"></i>
                </div>
                
                <!-- Title -->
                <h3 class="text-xl font-bold text-green-600">Green Saving</h3>
                
                <!-- Tagline -->
                <p class="text-sm text-gray-600 text-center">
                    Bersama menjaga lingkungan untuk masa depan lebih baik
                </p>
                
                <!-- Copyright -->
                <p class="text-sm text-gray-500">© 2025 Green Saving. All rights reserved.</p>
            </div>
        </div>
    </footer>

    <!-- Modal Detail Transaksi -->
    <div id="transactionDetailModal" class="fixed inset-0 bg-black bg-opacity-50 hidden items-center justify-center z-50 p-4">
        <div class="bg-white rounded-3xl max-w-4xl w-full shadow-2xl transform transition-all max-h-[90vh] overflow-y-auto">
            <!-- Modal Header -->
            <div class="bg-gradient-to-r from-green-500 to-green-600 rounded-t-3xl p-6 sticky top-0 z-10">
                <div class="flex items-center justify-between">
                    <div class="flex items-center space-x-4">
                        <div class="w-16 h-16 bg-white rounded-2xl flex items-center justify-center shadow-lg">
                            <i class="bi bi-file-text-fill text-green-600 text-3xl"></i>
                        </div>
                        <div>
                            <h2 class="text-2xl font-bold text-white">Detail Transaksi</h2>
                            <p class="text-green-50 text-sm">Riwayat Setoran Sampah</p>
                        </div>
                    </div>
                    <button onclick="closeTransactionDetail()" class="w-10 h-10 bg-white bg-opacity-20 hover:bg-opacity-30 rounded-xl flex items-center justify-center transition-all">
                        <i class="bi bi-x-lg text-white text-xl"></i>
                    </button>
                </div>
            </div>

            <!-- Modal Body -->
            <div class="p-6">
                
                <!-- Transaction Info Grid -->
                <div class="bg-gradient-to-br from-green-50 to-emerald-50 rounded-2xl p-6 mb-6">
                    <div class="grid grid-cols-2 gap-x-8 gap-y-4">
                        <div>
                            <p class="text-sm text-gray-500 mb-1 flex items-center">
                                <i class="bi bi-info-circle text-gray-400 mr-2"></i>
                                Status
                            </p>
                            <p id="modalStatus" class="font-semibold text-gray-800">Completed</p>
                        </div>
                        <div class="text-right">
                            <span id="modalStatusBadge" class="inline-block px-4 py-2 bg-green-100 text-green-700 rounded-full text-sm font-semibold">
                                Completed
                            </span>
                        </div>

                        <div>
                            <p class="text-sm text-gray-500 mb-1 flex items-center">
                                <i class="bi bi-geo-alt-fill text-gray-400 mr-2"></i>
                                Lokasi
                            </p>
                            <p id="modalLokasi" class="font-semibold text-gray-800">-</p>
                        </div>
                        <div class="text-right">
                            <p class="text-sm text-gray-500 mb-1"></p>
                        </div>

                        <div>
                            <p class="text-sm text-gray-500 mb-1 flex items-center">
                                <i class="bi bi-calendar-event text-gray-400 mr-2"></i>
                                Tanggal & Waktu
                            </p>
                            <p id="modalTanggalWaktu" class="font-semibold text-gray-800">-</p>
                        </div>
                        <div class="text-right">
                            <p class="text-sm text-gray-500 mb-1"></p>
                        </div>

                        <div>
                            <p class="text-sm text-gray-500 mb-1 flex items-center">
                                <i class="bi bi-person-check text-gray-400 mr-2"></i>
                                Admin Verifikator
                            </p>
                            <p id="modalAdmin" class="font-semibold text-gray-800">-</p>
                        </div>
                        <div class="text-right">
                            <p class="text-sm text-gray-500 mb-1"></p>
                        </div>

                        <div class="col-span-2 border-t border-green-200 pt-4 mt-2">
                            <div class="grid grid-cols-3 gap-4">
                                <div class="bg-white rounded-xl p-4 shadow-sm">
                                    <p class="text-xs text-gray-500 mb-2">Poin Diperoleh</p>
                                    <p id="modalPoinDiperoleh" class="font-bold text-green-600 text-2xl">
                                        <i class="bi bi-coin text-green-500 mr-1"></i>
                                        750 poin
                                    </p>
                                </div>
                                <div class="bg-white rounded-xl p-4 shadow-sm">
                                    <p class="text-xs text-gray-500 mb-2">Poin Sebelum</p>
                                    <p id="modalPoinSebelum" class="font-semibold text-gray-800 text-lg">2000 poin</p>
                                </div>
                                <div class="bg-white rounded-xl p-4 shadow-sm">
                                    <p class="text-xs text-gray-500 mb-2">Poin Setelah</p>
                                    <p id="modalPoinSetelah" class="font-semibold text-gray-800 text-lg">2750 poin</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Detail Item Sampah Section -->
                <div class="border-t border-gray-200 pt-6">
                    <h3 class="font-bold text-gray-800 mb-4 text-xl flex items-center">
                        <i class="bi bi-list-ul text-green-600 mr-2"></i>
                        Detail Item Sampah
                    </h3>
                    
                    <!-- Table -->
                    <div class="overflow-x-auto rounded-xl border border-gray-200 shadow-sm">
                        <table class="w-full">
                            <thead class="bg-gradient-to-r from-green-500 to-green-600">
                                <tr>
                                    <th class="px-4 py-3 text-left text-sm font-semibold text-white border-r border-green-400">Jenis Sampah</th>
                                    <th class="px-4 py-3 text-center text-sm font-semibold text-white border-r border-green-400">Berat (kg)</th>
                                    <th class="px-4 py-3 text-center text-sm font-semibold text-white border-r border-green-400">Poin per Unit</th>
                                    <th class="px-4 py-3 text-right text-sm font-semibold text-white">Poin Diperoleh</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr class="hover:bg-gray-50 border-b border-gray-200">
                                    <td class="px-4 py-3 text-gray-800 border-r border-gray-200">
                                        <div class="flex items-center">
                                            <div class="w-8 h-8 bg-blue-100 rounded-lg flex items-center justify-center mr-2">
                                                <i class="bi bi-recycle text-blue-600"></i>
                                            </div>
                                            Plastik
                                        </div>
                                    </td>
                                    <td class="px-4 py-3 text-center text-gray-800 border-r border-gray-200 font-medium">1.0 kg</td>
                                    <td class="px-4 py-3 text-center text-gray-800 border-r border-gray-200">300 poin/kg</td>
                                    <td class="px-4 py-3 text-right font-semibold text-gray-800">300 poin</td>
                                </tr>
                                <tr class="hover:bg-gray-50 border-b border-gray-200">
                                    <td class="px-4 py-3 text-gray-800 border-r border-gray-200">
                                        <div class="flex items-center">
                                            <div class="w-8 h-8 bg-amber-100 rounded-lg flex items-center justify-center mr-2">
                                                <i class="bi bi-box-seam text-amber-600"></i>
                                            </div>
                                            Kardus
                                        </div>
                                    </td>
                                    <td class="px-4 py-3 text-center text-gray-800 border-r border-gray-200 font-medium">1.5 kg</td>
                                    <td class="px-4 py-3 text-center text-gray-800 border-r border-gray-200">50 poin/kg</td>
                                    <td class="px-4 py-3 text-right font-semibold text-gray-800">75 poin</td>
                                </tr>
                                <tr class="bg-gradient-to-r from-green-50 to-emerald-50 font-semibold">
                                    <td class="px-4 py-3 text-gray-800 border-r border-gray-200 text-lg">
                                        <i class="bi bi-calculator text-green-600 mr-2"></i>
                                        Sub Total
                                    </td>
                                    <td class="px-4 py-3 text-center text-gray-800 border-r border-gray-200 text-lg">2.5 kg</td>
                                    <td class="px-4 py-3 text-center border-r border-gray-200"></td>
                                    <td class="px-4 py-3 text-right text-green-700 text-xl">
                                        <i class="bi bi-coin text-green-500 mr-1"></i>
                                        375 poin
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- Footer Info -->
                <div class="border-t border-gray-200 mt-6 pt-6">
                    <div class="bg-gradient-to-br from-gray-50 to-gray-100 rounded-2xl p-5">
                        <div class="flex items-center justify-between flex-wrap gap-4">
                            <div class="flex items-center space-x-3">
                                <div class="w-14 h-14 bg-green-500 rounded-full flex items-center justify-center shadow-md">
                                    <i class="bi bi-recycle text-white text-2xl"></i>
                                </div>
                                <div>
                                    <p class="text-sm text-gray-500">Total Sampah</p>
                                    <p class="font-bold text-gray-800 text-lg">Plastik & Kardus</p>
                                    <p class="text-sm font-semibold text-green-600">2.5kg</p>
                                </div>
                            </div>
                            
                            <div class="text-center hidden sm:block">
                                <p class="text-sm text-gray-500 mb-1">
                                    <i class="bi bi-geo-alt-fill text-green-600 mr-1"></i>
                                    Lokasi Penyetoran
                                </p>
                                <p class="font-semibold text-gray-800">Bank Sampah Sitolusna</p>
                            </div>
                            
                            <div class="text-right">
                                <div class="flex flex-col gap-2">
                                    <div class="flex items-center justify-end gap-2">
                                        <i class="bi bi-clock text-gray-400"></i>
                                        <span class="text-sm text-gray-600">2025-2-10 10:15</span>
                                    </div>
                                    <div class="flex items-center justify-end gap-2">
                                        <i class="bi bi-weight text-gray-400"></i>
                                        <span class="text-sm font-medium text-gray-800">2.5kg</span>
                                    </div>
                                    <span class="inline-block px-3 py-1.5 bg-green-100 text-green-700 rounded-full text-xs font-semibold">
                                        <i class="bi bi-check-circle-fill mr-1"></i>
                                        Completed
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Action Button -->
                <div class="mt-6 flex gap-3">
                    <button onclick="closeTransactionDetail()" class="flex-1 bg-gray-100 hover:bg-gray-200 text-gray-700 font-semibold py-4 rounded-xl transition-all">
                        <i class="bi bi-x-circle mr-2"></i>
                        Tutup
                    </button>
                    <button class="flex-1 bg-gradient-to-r from-green-500 to-green-600 hover:from-green-600 hover:to-green-700 text-white font-semibold py-4 rounded-xl transition-all shadow-md hover:shadow-lg">
                        <i class="bi bi-printer mr-2"></i>
                        Cetak Bukti
                    </button>
                </div>
            </div>
        </div>
    </div>

    <script>
        function showTransactionDetail(kode, status, lokasi, tanggal, waktu, admin, poinDiperoleh, poinSebelum, poinSetelah) {
            // Update modal content
            document.getElementById('modalStatus').textContent = status;
            document.getElementById('modalLokasi').textContent = lokasi;
            document.getElementById('modalTanggalWaktu').textContent = tanggal + ' · ' + waktu;
            document.getElementById('modalAdmin').textContent = admin;
            document.getElementById('modalPoinDiperoleh').innerHTML = '<i class="bi bi-coin text-green-500 mr-1"></i>' + poinDiperoleh.toLocaleString('id-ID') + ' poin';
            document.getElementById('modalPoinSebelum').textContent = poinSebelum.toLocaleString('id-ID') + ' poin';
            document.getElementById('modalPoinSetelah').textContent = poinSetelah.toLocaleString('id-ID') + ' poin';
            
            // Update status badge
            const badge = document.getElementById('modalStatusBadge');
            if (status === 'Completed') {
                badge.className = 'inline-block px-4 py-2 bg-green-100 text-green-700 rounded-full text-sm font-semibold';
                badge.innerHTML = '<i class="bi bi-check-circle-fill mr-1"></i>Completed';
            }
            
            // Show modal
            const modal = document.getElementById('transactionDetailModal');
            modal.classList.remove('hidden');
            modal.classList.add('flex');
            
            // Prevent body scroll
            document.body.style.overflow = 'hidden';
        }

        function closeTransactionDetail() {
            const modal = document.getElementById('transactionDetailModal');
            modal.classList.add('hidden');
            modal.classList.remove('flex');
            
            // Restore body scroll
            document.body.style.overflow = 'auto';
        }

        // Close modal when clicking outside
        document.getElementById('transactionDetailModal').addEventListener('click', function(e) {
            if (e.target === this) {
                closeTransactionDetail();
            }
        });

        // Close modal with ESC key
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') {
                closeTransactionDetail();
            }
        });
    </script>

</body>
</html>
