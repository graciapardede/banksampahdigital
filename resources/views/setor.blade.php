<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Setor Sampah - Bank Sampah Digital</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
</head>
<body class="bg-gradient-to-b from-green-50 via-green-50/30 to-white min-h-screen antialiased">
    <!-- Header -->
    <div class="bg-white shadow-sm sticky top-0 z-50">
        <div class="max-w-6xl mx-auto px-4 py-4">
            <div class="flex items-center justify-between">
                <!-- Logo & Greeting -->
                <div class="flex items-center gap-3">
                    <div class="w-12 h-12 bg-gradient-to-br from-green-500 to-green-600 rounded-xl flex items-center justify-center shadow-md">
                        <i class="bi bi-recycle text-white text-2xl"></i>
                    </div>
                    <div>
                        <h1 class="text-lg font-bold text-gray-800">Green Saving</h1>
                        <p class="text-sm text-gray-500">Halo, {{ Auth::user()->full_name ?? Auth::user()->name ?? 'lisbeth' }}</p>
                    </div>
                </div>

                <!-- Points & Actions -->
                <div class="flex items-center gap-2">
                    <div class="bg-green-100 px-4 py-2 rounded-full">
                        <span class="text-sm font-bold text-green-700">15420 poin</span>
                    </div>
                    <button class="w-10 h-10 bg-gray-100 rounded-full flex items-center justify-center hover:bg-gray-200 transition-colors">
                        <i class="bi bi-bell text-gray-600 text-lg"></i>
                    </button>
                    <a href="/profil" class="w-10 h-10 bg-green-100 rounded-full flex items-center justify-center hover:bg-green-200 transition-colors">
                        <i class="bi bi-person text-green-600 text-lg"></i>
                    </a>
                    <form method="POST" action="/logout" class="inline">
                        @csrf
                        <button type="submit" class="w-10 h-10 bg-gray-100 rounded-full flex items-center justify-center hover:bg-gray-200 transition-colors">
                            <i class="bi bi-box-arrow-right text-gray-600 text-lg"></i>
                        </button>
                    </form>
                </div>
            </div>
        </div>

        <!-- Main Navigation -->
        <div class="bg-white px-4 py-3 border-t border-gray-100">
            <div class="max-w-6xl mx-auto">
                <div class="flex items-center justify-center gap-2 flex-wrap">
                    <a href="/dashboard" class="px-6 py-2.5 rounded-full text-sm font-semibold text-gray-700 bg-white border border-gray-200 hover:bg-gray-50 transition-colors flex items-center gap-2 cursor-pointer">
                        <i class="bi bi-house-door text-base"></i>
                        <span>Dashboard</span>
                    </a>
                    <a href="/profil" class="px-6 py-2.5 rounded-full text-sm font-semibold text-gray-700 bg-white border border-gray-200 hover:bg-gray-50 transition-colors flex items-center gap-2 cursor-pointer">
                        <i class="bi bi-person text-base"></i>
                        <span>Profil</span>
                    </a>
                    <a href="/setor" class="px-6 py-2.5 rounded-full text-sm font-semibold text-white bg-gradient-to-r from-green-500 to-green-600 shadow-md flex items-center gap-2 cursor-default">
                        <i class="bi bi-recycle text-base"></i>
                        <span>Setor</span>
                    </a>
                    <button class="px-6 py-2.5 rounded-full text-sm font-semibold text-gray-600 bg-white border border-gray-200 hover:bg-gray-50 transition-colors flex items-center gap-2 cursor-pointer">
                        <i class="bi bi-gift text-base"></i>
                        <span>Tukar Point</span>
                    </button>
                    <button class="px-5 py-2.5 rounded-full text-sm font-semibold text-gray-600 bg-white border border-gray-200 hover:bg-gray-50 transition-colors flex items-center gap-2 cursor-pointer">
                        <i class="bi bi-bar-chart text-base"></i>
                        <span>Riwayat</span>
                    </button>
                    <button class="px-5 py-2.5 rounded-full text-sm font-semibold text-gray-600 bg-white border border-gray-200 hover:bg-gray-50 transition-colors flex items-center gap-2 cursor-pointer">
                        <i class="bi bi-bell text-base"></i>
                        <span>Notifikasi</span>
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Main Content -->
    <div class="max-w-4xl mx-auto px-4 py-6">
        <!-- Page Title -->
        <div class="mb-6">
            <h2 class="text-2xl font-bold text-gray-800 mb-2">Setor Sampah</h2>
            <p class="text-gray-600">Kelola setoran sampah Anda dan dapatkan poin</p>
        </div>

        <!-- Tabs -->
        <div class="bg-white rounded-2xl shadow-sm overflow-hidden">
            <div class="flex border-b border-gray-200">
                <button class="flex-1 px-6 py-4 text-sm font-semibold text-green-600 border-b-2 border-green-600 bg-white flex items-center justify-center gap-2">
                    <i class="bi bi-compass text-base"></i>
                    <span>Panduan</span>
                </button>
                <button class="flex-1 px-6 py-4 text-sm font-semibold text-gray-500 hover:bg-gray-50 transition-colors flex items-center justify-center gap-2">
                    <i class="bi bi-clock-history text-base"></i>
                    <span>Riwayat</span>
                </button>
            </div>

            <!-- Content -->
            <div class="p-6">
                <!-- Jenis Sampah yang Diterima -->
                <h3 class="text-lg font-bold text-gray-800 mb-4">Jenis Sampah yang Diterima</h3>
                
                <div class="space-y-3">
                    <!-- Plastik -->
                    <div class="bg-gray-50 rounded-xl p-4 hover:bg-gray-100 transition-colors border border-gray-200">
                        <div class="flex items-center gap-4">
                            <div class="w-16 h-16 bg-white rounded-lg flex items-center justify-center flex-shrink-0 border-2 border-green-200">
                                <i class="bi bi-recycle text-green-600 text-3xl"></i>
                            </div>
                            <div class="flex-1">
                                <h4 class="font-bold text-gray-800 mb-1">Plastik</h4>
                                <p class="text-sm text-gray-600 mb-1">Botol plastik, kemasan plastik</p>
                                <span class="inline-block px-2 py-1 bg-green-100 text-green-700 text-xs font-medium rounded">Plastik</span>
                            </div>
                            <div class="text-right flex-shrink-0">
                                <p class="text-green-600 font-bold text-lg">300 poin/kg</p>
                            </div>
                        </div>
                    </div>

                    <!-- Kertas/Kardus -->
                    <div class="bg-gray-50 rounded-xl p-4 hover:bg-gray-100 transition-colors border border-gray-200">
                        <div class="flex items-center gap-4">
                            <div class="w-16 h-16 bg-white rounded-lg flex items-center justify-center flex-shrink-0 border-2 border-amber-200">
                                <i class="bi bi-box-seam text-amber-600 text-3xl"></i>
                            </div>
                            <div class="flex-1">
                                <h4 class="font-bold text-gray-800 mb-1">Kertas/Kardus</h4>
                                <p class="text-sm text-gray-600 mb-1">Kertas bekas, kardus, majalah, koran</p>
                                <span class="inline-block px-2 py-1 bg-amber-100 text-amber-700 text-xs font-medium rounded">Kertas</span>
                            </div>
                            <div class="text-right flex-shrink-0">
                                <p class="text-green-600 font-bold text-lg">150 poin/kg</p>
                            </div>
                        </div>
                    </div>

                    <!-- Kaleng Alumunium -->
                    <div class="bg-gray-50 rounded-xl p-4 hover:bg-gray-100 transition-colors border border-gray-200">
                        <div class="flex items-center gap-4">
                            <div class="w-16 h-16 bg-white rounded-lg flex items-center justify-center flex-shrink-0 border-2 border-gray-300">
                                <i class="bi bi-cup-straw text-gray-600 text-3xl"></i>
                            </div>
                            <div class="flex-1">
                                <h4 class="font-bold text-gray-800 mb-1">Kaleng Alumunium</h4>
                                <p class="text-sm text-gray-600 mb-1">Kaleng minuman, kemasan makanan kaleng</p>
                                <span class="inline-block px-2 py-1 bg-gray-200 text-gray-700 text-xs font-medium rounded">Logam</span>
                            </div>
                            <div class="text-right flex-shrink-0">
                                <p class="text-green-600 font-bold text-lg">1200 poin/kg</p>
                            </div>
                        </div>
                    </div>

                    <!-- Kaca -->
                    <div class="bg-gray-50 rounded-xl p-4 hover:bg-gray-100 transition-colors border border-gray-200">
                        <div class="flex items-center gap-4">
                            <div class="w-16 h-16 bg-white rounded-lg flex items-center justify-center flex-shrink-0 border-2 border-blue-200">
                                <i class="bi bi-droplet text-blue-600 text-3xl"></i>
                            </div>
                            <div class="flex-1">
                                <h4 class="font-bold text-gray-800 mb-1">Kaca</h4>
                                <p class="text-sm text-gray-600 mb-1">Botol kaca, pecahan kaca bersih</p>
                                <span class="inline-block px-2 py-1 bg-blue-100 text-blue-700 text-xs font-medium rounded">Kaca</span>
                            </div>
                            <div class="text-right flex-shrink-0">
                                <p class="text-green-600 font-bold text-lg">100 poin/kg</p>
                            </div>
                        </div>
                    </div>

                    <!-- Logam Lainnya -->
                    <div class="bg-gray-50 rounded-xl p-4 hover:bg-gray-100 transition-colors border border-gray-200">
                        <div class="flex items-center gap-4">
                            <div class="w-16 h-16 bg-white rounded-lg flex items-center justify-center flex-shrink-0 border-2 border-orange-200">
                                <i class="bi bi-basket text-orange-600 text-3xl"></i>
                            </div>
                            <div class="flex-1">
                                <h4 class="font-bold text-gray-800 mb-1">Logam Lainnya</h4>
                                <p class="text-sm text-gray-600 mb-1">Besi bekas, tembaga, kuningan</p>
                                <span class="inline-block px-2 py-1 bg-orange-100 text-orange-700 text-xs font-medium rounded">Logam</span>
                            </div>
                            <div class="text-right flex-shrink-0">
                                <p class="text-green-600 font-bold text-lg">1000 poin/kg</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Cara Setor Sampah -->
                <div class="mt-8">
                    <h3 class="text-lg font-bold text-gray-800 mb-4">Cara Setor Sampah:</h3>
                    
                    <!-- Tahap 1 -->
                    <div class="mb-6">
                        <h4 class="font-bold text-gray-700 mb-3">Tahap 1: Persiapan (Warga)</h4>
                        <div class="space-y-2 ml-4">
                            <div class="flex gap-3">
                                <span class="flex-shrink-0 w-6 h-6 bg-green-500 text-white rounded-full flex items-center justify-center text-xs font-bold">1</span>
                                <div>
                                    <p class="font-semibold text-gray-800">Pilah dan Bersihkan Sampah</p>
                                    <p class="text-sm text-gray-600">Pastikan sampah sudah dibersihkan dari sisa makanan dan dipisahkan berdasarkan jenisnya.</p>
                                </div>
                            </div>
                            <div class="flex gap-3">
                                <span class="flex-shrink-0 w-6 h-6 bg-green-500 text-white rounded-full flex items-center justify-center text-xs font-bold">2</span>
                                <div>
                                    <p class="font-semibold text-gray-800">Kunjungi Cabang</p>
                                    <p class="text-sm text-gray-600">Bawa sampah yang telah di pilah dan dibersihkan ke bank sampah terdekat dari lokasi Anda.</p>
                                </div>
                            </div>
                            <div class="flex gap-3">
                                <span class="flex-shrink-0 w-6 h-6 bg-green-500 text-white rounded-full flex items-center justify-center text-xs font-bold">3</span>
                                <div>
                                    <p class="font-semibold text-gray-800">Datang ke Bank Sampah Terdekat</p>
                                    <p class="text-sm text-gray-600">Bawa sampah yang sudah di pilah dan dibersihkan ke bank sampah terdekat dari lokasi Anda.</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Tahap 2 -->
                    <div class="mb-6">
                        <h4 class="font-bold text-gray-700 mb-3">Tahap 2: Transaksi di Lokasi (Peran Admin & Sistem)</h4>
                        <div class="space-y-2 ml-4">
                            <div class="flex gap-3">
                                <span class="flex-shrink-0 w-6 h-6 bg-blue-500 text-white rounded-full flex items-center justify-center text-xs font-bold">1</span>
                                <div>
                                    <p class="font-semibold text-gray-800">Serahkan ID akun Warga Anda</p>
                                    <p class="text-sm text-gray-600">Atau tunjukkan kode ID di aplikasi/website kepada Admin Cabang yang bertugas.</p>
                                </div>
                            </div>
                            <div class="flex gap-3">
                                <span class="flex-shrink-0 w-6 h-6 bg-blue-500 text-white rounded-full flex items-center justify-center text-xs font-bold">2</span>
                                <div>
                                    <p class="font-semibold text-gray-800">Penimbangan dan Pencatatan</p>
                                    <p class="text-sm text-gray-600">Admin akan menimbang sampah Anda dan menginput jenis serta beratnya ke dalam sistem.</p>
                                </div>
                            </div>
                            <div class="flex gap-3">
                                <span class="flex-shrink-0 w-6 h-6 bg-blue-500 text-white rounded-full flex items-center justify-center text-xs font-bold">3</span>
                                <div>
                                    <p class="font-semibold text-gray-800">Verifikasi Lokasi</p>
                                    <p class="text-sm text-gray-600">Sistem secara otomatis mencatat setoran ini di cabang Bank Sampah tempat Anda berada.</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Tahap 3 -->
                    <div class="mb-6">
                        <h4 class="font-bold text-gray-700 mb-3">Tahap 3: Poin Masuk (Peran Sistem)</h4>
                        <div class="space-y-2 ml-4">
                            <div class="flex gap-3">
                                <span class="flex-shrink-0 w-6 h-6 bg-purple-500 text-white rounded-full flex items-center justify-center text-xs font-bold">1</span>
                                <div>
                                    <p class="font-semibold text-gray-800">Poin Dihitung</p>
                                    <p class="text-sm text-gray-600">Sistem secara otomatis menghitung total poin Anda.</p>
                                </div>
                            </div>
                            <div class="flex gap-3">
                                <span class="flex-shrink-0 w-6 h-6 bg-purple-500 text-white rounded-full flex items-center justify-center text-xs font-bold">2</span>
                                <div>
                                    <p class="font-semibold text-gray-800">Verifikasi Admin</p>
                                    <p class="text-sm text-gray-600">Admin akan mengkonfirmasi transaksi di sistem. Setelah dikonfirmasi, poin Anda langsung dimasukkan ke saldo.</p>
                                </div>
                            </div>
                            <div class="flex gap-3">
                                <span class="flex-shrink-0 w-6 h-6 bg-purple-500 text-white rounded-full flex items-center justify-center text-xs font-bold">3</span>
                                <div>
                                    <p class="font-semibold text-gray-800">Cek Saldo</p>
                                    <p class="text-sm text-gray-600">Anda akan menerima notifikasi bahwa setoran sudah diverifikasi dan poin berhasil ditambahkan. Cek Dashboard Anda untuk melihat saldo terbaru.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Footer Spacing -->
    <div class="h-20"></div>
</body>
</html>
