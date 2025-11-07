<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Riwayat Transaksi - Green Saving</title>
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
                        <p class="text-sm text-green-600">Halo, {{ Auth::user()->full_name ?? Auth::user()->name ?? 'Budi Santoso' }}</p>
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
                    <a href="/setor" class="bg-white text-gray-700 px-4 lg:px-6 py-3 rounded-2xl text-xs lg:text-sm font-semibold hover:bg-green-50 transition-colors shadow-sm flex items-center justify-center space-x-2 w-full cursor-pointer">
                        <i class="bi bi-recycle pointer-events-none"></i>
                        <span class="truncate pointer-events-none">Setor</span>
                    </a>
                    <a href="/tukar-poin" class="bg-white text-gray-700 px-4 lg:px-6 py-3 rounded-2xl text-xs lg:text-sm font-semibold hover:bg-green-50 transition-colors shadow-sm flex items-center justify-center space-x-2 w-full cursor-pointer">
                        <i class="bi bi-gift pointer-events-none"></i>
                        <span class="truncate pointer-events-none">Tukar Poin</span>
                    </a>
                    <a href="/riwayat" class="bg-green-500 text-white px-4 lg:px-6 py-3 rounded-2xl text-xs lg:text-sm font-semibold shadow-md flex items-center justify-center space-x-2 w-full cursor-default">
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
        
        <!-- Page Title -->
        <div class="mb-6">
            <h2 class="text-2xl font-bold text-gray-800 mb-2">Riwayat Transaksi</h2>
            <p class="text-gray-600">Semua aktivitas setoran dan penukaran Anda</p>
        </div>

        <!-- Transaction List -->
        <div id="transactionList" class="space-y-4">

            <!-- Transaction Item 1 - Setor Plastik PET -->
            <div onclick="showDetailSetor('TRX-20250210-001', 'Setor Plastik PET', '2024-3-11', '2.5 kg', 'Selesai', 500, 15420, 14920)" 
                 class="bg-white rounded-2xl p-5 shadow-sm border border-gray-200 hover:shadow-lg hover:border-green-400 transition-all duration-300 cursor-pointer">
                <div class="flex items-center justify-between">
                    <!-- Left: Icon & Info -->
                    <div class="flex items-center space-x-4 flex-1">
                        <!-- Icon with Arrow Up (Green) -->
                        <div class="w-14 h-14 bg-green-100 rounded-xl flex items-center justify-center flex-shrink-0">
                            <i class="bi bi-arrow-up-right text-green-600 text-2xl font-bold"></i>
                        </div>
                        
                        <!-- Transaction Details -->
                        <div class="flex-1">
                            <h3 class="font-bold text-gray-800 text-base mb-2 flex items-center">
                                <i class="bi bi-recycle text-green-600 mr-2"></i>
                                Setor Plastik PET
                            </h3>
                            <div class="flex items-center space-x-3 text-sm text-gray-600">
                                <span class="flex items-center">
                                    <i class="bi bi-calendar3 mr-1 text-gray-400 text-xs"></i>
                                    2024 - 3 - 11
                                </span>
                                <span class="flex items-center">
                                    <i class="bi bi-box-seam mr-1 text-gray-400 text-xs"></i>
                                    2.5 kg
                                </span>
                                <span class="px-3 py-1 bg-green-100 text-green-700 rounded-full text-xs font-semibold">
                                    Selesai
                                </span>
                            </div>
                        </div>

                        <!-- Right: Points -->
                        <div class="text-right">
                            <p class="text-xl font-bold text-green-600 flex items-center justify-end mb-1">
                                + 500
                                <i class="bi bi-coin text-green-500 ml-1 text-lg"></i>
                            </p>
                            <button class="text-xs text-gray-500 hover:text-green-600 flex items-center">
                                <i class="bi bi-eye mr-1"></i>
                                Lihat
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Transaction Item 2 - Tukar Point 1000 -->
            <div onclick="showDetailTukar('TRX-20250310-002', 'Tukar Point 1000', '2024-3-11', 'Minyak Goreng 1L', 'Menunggu Pengambilan', 500)" 
                 class="bg-white rounded-2xl p-5 shadow-sm border border-gray-200 hover:shadow-lg hover:border-blue-400 transition-all duration-300 cursor-pointer">
                <div class="flex items-center justify-between">
                    <div class="flex items-center space-x-4 flex-1">
                        <div class="w-14 h-14 bg-blue-100 rounded-xl flex items-center justify-center flex-shrink-0">
                            <i class="bi bi-arrow-down-left text-blue-600 text-2xl font-bold"></i>
                        </div>
                        <div class="flex-1">
                            <h3 class="font-bold text-gray-800 text-base mb-2 flex items-center">
                                <i class="bi bi-gift text-blue-600 mr-2"></i>
                                Tukar Point 1000
                            </h3>
                            <div class="flex items-center space-x-3 text-sm text-gray-600">
                                <span class="flex items-center">
                                    <i class="bi bi-calendar3 mr-1 text-gray-400 text-xs"></i>
                                    2024 - 3 - 11
                                </span>
                                <span class="px-3 py-1 bg-yellow-100 text-yellow-700 rounded-full text-xs font-semibold">
                                    Menunggu Pengambilan
                                </span>
                            </div>
                        </div>
                        <div class="text-right">
                            <p class="text-xl font-bold text-blue-600 flex items-center justify-end mb-1">
                                - 500
                                <i class="bi bi-coin text-blue-500 ml-1 text-lg"></i>
                            </p>
                            <button class="text-xs text-gray-500 hover:text-blue-600 flex items-center">
                                <i class="bi bi-eye mr-1"></i>
                                Lihat
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Transaction Item 3 - Setor Plastik PET -->
            <div onclick="showDetailSetor('TRX-20250308-003', 'Setor Plastik PET', '2024-3-11', '2.5 kg', 'Selesai', 500, 14920, 14420)" 
                 class="bg-white rounded-2xl p-5 shadow-sm border border-gray-200 hover:shadow-lg hover:border-green-400 transition-all duration-300 cursor-pointer">
                <div class="flex items-center justify-between">
                    <div class="flex items-center space-x-4 flex-1">
                        <div class="w-14 h-14 bg-green-100 rounded-xl flex items-center justify-center flex-shrink-0">
                            <i class="bi bi-arrow-up-right text-green-600 text-2xl font-bold"></i>
                        </div>
                        <div class="flex-1">
                            <h3 class="font-bold text-gray-800 text-base mb-2 flex items-center">
                                <i class="bi bi-recycle text-green-600 mr-2"></i>
                                Setor Plastik PET
                            </h3>
                            <div class="flex items-center space-x-3 text-sm text-gray-600">
                                <span class="flex items-center">
                                    <i class="bi bi-calendar3 mr-1 text-gray-400 text-xs"></i>
                                    2024 - 3 - 11
                                </span>
                                <span class="flex items-center">
                                    <i class="bi bi-box-seam mr-1 text-gray-400 text-xs"></i>
                                    2.5 kg
                                </span>
                                <span class="px-3 py-1 bg-green-100 text-green-700 rounded-full text-xs font-semibold">
                                    Selesai
                                </span>
                            </div>
                        </div>
                        <div class="text-right">
                            <p class="text-xl font-bold text-green-600 flex items-center justify-end mb-1">
                                + 500
                                <i class="bi bi-coin text-green-500 ml-1 text-lg"></i>
                            </p>
                            <button class="text-xs text-gray-500 hover:text-green-600 flex items-center">
                                <i class="bi bi-eye mr-1"></i>
                                Lihat
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Transaction Item 4 - Tukar Point 1000 -->
            <div onclick="showDetailTukar('TRX-20250307-004', 'Tukar Point 1000', '2024-3-11', 'Beras 5kg', 'Selesai', 500)" 
                 class="bg-white rounded-2xl p-5 shadow-sm border border-gray-200 hover:shadow-lg hover:border-blue-400 transition-all duration-300 cursor-pointer">
                <div class="flex items-center justify-between">
                    <div class="flex items-center space-x-4 flex-1">
                        <div class="w-14 h-14 bg-blue-100 rounded-xl flex items-center justify-center flex-shrink-0">
                            <i class="bi bi-arrow-down-left text-blue-600 text-2xl font-bold"></i>
                        </div>
                        <div class="flex-1">
                            <h3 class="font-bold text-gray-800 text-base mb-2 flex items-center">
                                <i class="bi bi-gift text-blue-600 mr-2"></i>
                                Tukar Point 1000
                            </h3>
                            <div class="flex items-center space-x-3 text-sm text-gray-600">
                                <span class="flex items-center">
                                    <i class="bi bi-calendar3 mr-1 text-gray-400 text-xs"></i>
                                    2024 - 3 - 11
                                </span>
                                <span class="px-3 py-1 bg-green-100 text-green-700 rounded-full text-xs font-semibold">
                                    Selesai
                                </span>
                            </div>
                        </div>
                        <div class="text-right">
                            <p class="text-xl font-bold text-blue-600 flex items-center justify-end mb-1">
                                - 500
                                <i class="bi bi-coin text-blue-500 ml-1 text-lg"></i>
                            </p>
                            <button class="text-xs text-gray-500 hover:text-blue-600 flex items-center">
                                <i class="bi bi-eye mr-1"></i>
                                Lihat
                            </button>
                        </div>
                    </div>
                </div>
            </div>

        </div>

        <!-- Hidden Additional Transactions -->
        <div id="moreTransactions" class="hidden space-y-4 mt-4">
            
            <!-- Transaction Item 5 - Setor Kardus -->
            <div onclick="showDetailSetor('TRX-20250306-005', 'Setor Kardus', '2024-3-6', '3.0 kg', 'Selesai', 450, 14420, 13970)" 
                 class="bg-white rounded-2xl p-5 shadow-sm border border-gray-200 hover:shadow-lg hover:border-green-400 transition-all duration-300 cursor-pointer">
                <div class="flex items-center justify-between">
                    <div class="flex items-center space-x-4 flex-1">
                        <div class="w-14 h-14 bg-green-100 rounded-xl flex items-center justify-center flex-shrink-0">
                            <i class="bi bi-arrow-up-right text-green-600 text-2xl font-bold"></i>
                        </div>
                        <div class="flex-1">
                            <h3 class="font-bold text-gray-800 text-base mb-2 flex items-center">
                                <i class="bi bi-recycle text-green-600 mr-2"></i>
                                Setor Kardus
                            </h3>
                            <div class="flex items-center space-x-3 text-sm text-gray-600">
                                <span class="flex items-center">
                                    <i class="bi bi-calendar3 mr-1 text-gray-400 text-xs"></i>
                                    2024 - 3 - 6
                                </span>
                                <span class="flex items-center">
                                    <i class="bi bi-box-seam mr-1 text-gray-400 text-xs"></i>
                                    3.0 kg
                                </span>
                                <span class="px-3 py-1 bg-green-100 text-green-700 rounded-full text-xs font-semibold">
                                    Selesai
                                </span>
                            </div>
                        </div>
                        <div class="text-right">
                            <p class="text-xl font-bold text-green-600 flex items-center justify-end mb-1">
                                + 450
                                <i class="bi bi-coin text-green-500 ml-1 text-lg"></i>
                            </p>
                            <button class="text-xs text-gray-500 hover:text-green-600 flex items-center">
                                <i class="bi bi-eye mr-1"></i>
                                Lihat
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Transaction Item 6 - Tukar Point Gula -->
            <div onclick="showDetailTukar('TRX-20250305-006', 'Tukar Point 800', '2024-3-5', 'Gula 1kg', 'Selesai', 800)" 
                 class="bg-white rounded-2xl p-5 shadow-sm border border-gray-200 hover:shadow-lg hover:border-blue-400 transition-all duration-300 cursor-pointer">
                <div class="flex items-center justify-between">
                    <div class="flex items-center space-x-4 flex-1">
                        <div class="w-14 h-14 bg-blue-100 rounded-xl flex items-center justify-center flex-shrink-0">
                            <i class="bi bi-arrow-down-left text-blue-600 text-2xl font-bold"></i>
                        </div>
                        <div class="flex-1">
                            <h3 class="font-bold text-gray-800 text-base mb-2 flex items-center">
                                <i class="bi bi-gift text-blue-600 mr-2"></i>
                                Tukar Point 800
                            </h3>
                            <div class="flex items-center space-x-3 text-sm text-gray-600">
                                <span class="flex items-center">
                                    <i class="bi bi-calendar3 mr-1 text-gray-400 text-xs"></i>
                                    2024 - 3 - 5
                                </span>
                                <span class="px-3 py-1 bg-green-100 text-green-700 rounded-full text-xs font-semibold">
                                    Selesai
                                </span>
                            </div>
                        </div>
                        <div class="text-right">
                            <p class="text-xl font-bold text-blue-600 flex items-center justify-end mb-1">
                                - 800
                                <i class="bi bi-coin text-blue-500 ml-1 text-lg"></i>
                            </p>
                            <button class="text-xs text-gray-500 hover:text-blue-600 flex items-center">
                                <i class="bi bi-eye mr-1"></i>
                                Lihat
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Transaction Item 7 - Setor Aluminium -->
            <div onclick="showDetailSetor('TRX-20250304-007', 'Setor Aluminium', '2024-3-4', '1.8 kg', 'Selesai', 600, 13970, 13370)" 
                 class="bg-white rounded-2xl p-5 shadow-sm border border-gray-200 hover:shadow-lg hover:border-green-400 transition-all duration-300 cursor-pointer">
                <div class="flex items-center justify-between">
                    <div class="flex items-center space-x-4 flex-1">
                        <div class="w-14 h-14 bg-green-100 rounded-xl flex items-center justify-center flex-shrink-0">
                            <i class="bi bi-arrow-up-right text-green-600 text-2xl font-bold"></i>
                        </div>
                        <div class="flex-1">
                            <h3 class="font-bold text-gray-800 text-base mb-2 flex items-center">
                                <i class="bi bi-recycle text-green-600 mr-2"></i>
                                Setor Aluminium
                            </h3>
                            <div class="flex items-center space-x-3 text-sm text-gray-600">
                                <span class="flex items-center">
                                    <i class="bi bi-calendar3 mr-1 text-gray-400 text-xs"></i>
                                    2024 - 3 - 4
                                </span>
                                <span class="flex items-center">
                                    <i class="bi bi-box-seam mr-1 text-gray-400 text-xs"></i>
                                    1.8 kg
                                </span>
                                <span class="px-3 py-1 bg-green-100 text-green-700 rounded-full text-xs font-semibold">
                                    Selesai
                                </span>
                            </div>
                        </div>
                        <div class="text-right">
                            <p class="text-xl font-bold text-green-600 flex items-center justify-end mb-1">
                                + 600
                                <i class="bi bi-coin text-green-500 ml-1 text-lg"></i>
                            </p>
                            <button class="text-xs text-gray-500 hover:text-green-600 flex items-center">
                                <i class="bi bi-eye mr-1"></i>
                                Lihat
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Transaction Item 8 - Tukar Point Sabun -->
            <div onclick="showDetailTukar('TRX-20250303-008', 'Tukar Point 600', '2024-3-3', 'Sabun Cuci 1kg', 'Selesai', 600)" 
                 class="bg-white rounded-2xl p-5 shadow-sm border border-gray-200 hover:shadow-lg hover:border-blue-400 transition-all duration-300 cursor-pointer">
                <div class="flex items-center justify-between">
                    <div class="flex items-center space-x-4 flex-1">
                        <div class="w-14 h-14 bg-blue-100 rounded-xl flex items-center justify-center flex-shrink-0">
                            <i class="bi bi-arrow-down-left text-blue-600 text-2xl font-bold"></i>
                        </div>
                        <div class="flex-1">
                            <h3 class="font-bold text-gray-800 text-base mb-2 flex items-center">
                                <i class="bi bi-gift text-blue-600 mr-2"></i>
                                Tukar Point 600
                            </h3>
                            <div class="flex items-center space-x-3 text-sm text-gray-600">
                                <span class="flex items-center">
                                    <i class="bi bi-calendar3 mr-1 text-gray-400 text-xs"></i>
                                    2024 - 3 - 3
                                </span>
                                <span class="px-3 py-1 bg-green-100 text-green-700 rounded-full text-xs font-semibold">
                                    Selesai
                                </span>
                            </div>
                        </div>
                        <div class="text-right">
                            <p class="text-xl font-bold text-blue-600 flex items-center justify-end mb-1">
                                - 600
                                <i class="bi bi-coin text-blue-500 ml-1 text-lg"></i>
                            </p>
                            <button class="text-xs text-gray-500 hover:text-blue-600 flex items-center">
                                <i class="bi bi-eye mr-1"></i>
                                Lihat
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Transaction Item 9 - Setor Kaca -->
            <div onclick="showDetailSetor('TRX-20250302-009', 'Setor Kaca', '2024-3-2', '2.2 kg', 'Selesai', 550, 13370, 12820)" 
                 class="bg-white rounded-2xl p-5 shadow-sm border border-gray-200 hover:shadow-lg hover:border-green-400 transition-all duration-300 cursor-pointer">
                <div class="flex items-center justify-between">
                    <div class="flex items-center space-x-4 flex-1">
                        <div class="w-14 h-14 bg-green-100 rounded-xl flex items-center justify-center flex-shrink-0">
                            <i class="bi bi-arrow-up-right text-green-600 text-2xl font-bold"></i>
                        </div>
                        <div class="flex-1">
                            <h3 class="font-bold text-gray-800 text-base mb-2 flex items-center">
                                <i class="bi bi-recycle text-green-600 mr-2"></i>
                                Setor Kaca
                            </h3>
                            <div class="flex items-center space-x-3 text-sm text-gray-600">
                                <span class="flex items-center">
                                    <i class="bi bi-calendar3 mr-1 text-gray-400 text-xs"></i>
                                    2024 - 3 - 2
                                </span>
                                <span class="flex items-center">
                                    <i class="bi bi-box-seam mr-1 text-gray-400 text-xs"></i>
                                    2.2 kg
                                </span>
                                <span class="px-3 py-1 bg-green-100 text-green-700 rounded-full text-xs font-semibold">
                                    Selesai
                                </span>
                            </div>
                        </div>
                        <div class="text-right">
                            <p class="text-xl font-bold text-green-600 flex items-center justify-end mb-1">
                                + 550
                                <i class="bi bi-coin text-green-500 ml-1 text-lg"></i>
                            </p>
                            <button class="text-xs text-gray-500 hover:text-green-600 flex items-center">
                                <i class="bi bi-eye mr-1"></i>
                                Lihat
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Transaction Item 10 - Tukar Point Tepung -->
            <div onclick="showDetailTukar('TRX-20250301-010', 'Tukar Point 700', '2024-3-1', 'Tepung Terigu 1kg', 'Selesai', 700)" 
                 class="bg-white rounded-2xl p-5 shadow-sm border border-gray-200 hover:shadow-lg hover:border-blue-400 transition-all duration-300 cursor-pointer">
                <div class="flex items-center justify-between">
                    <div class="flex items-center space-x-4 flex-1">
                        <div class="w-14 h-14 bg-blue-100 rounded-xl flex items-center justify-center flex-shrink-0">
                            <i class="bi bi-arrow-down-left text-blue-600 text-2xl font-bold"></i>
                        </div>
                        <div class="flex-1">
                            <h3 class="font-bold text-gray-800 text-base mb-2 flex items-center">
                                <i class="bi bi-gift text-blue-600 mr-2"></i>
                                Tukar Point 700
                            </h3>
                            <div class="flex items-center space-x-3 text-sm text-gray-600">
                                <span class="flex items-center">
                                    <i class="bi bi-calendar3 mr-1 text-gray-400 text-xs"></i>
                                    2024 - 3 - 1
                                </span>
                                <span class="px-3 py-1 bg-green-100 text-green-700 rounded-full text-xs font-semibold">
                                    Selesai
                                </span>
                            </div>
                        </div>
                        <div class="text-right">
                            <p class="text-xl font-bold text-blue-600 flex items-center justify-end mb-1">
                                - 700
                                <i class="bi bi-coin text-blue-500 ml-1 text-lg"></i>
                            </p>
                            <button class="text-xs text-gray-500 hover:text-blue-600 flex items-center">
                                <i class="bi bi-eye mr-1"></i>
                                Lihat
                            </button>
                        </div>
                    </div>
                </div>
            </div>

        </div>

        <!-- Load More Button -->
        <div class="mt-8 flex justify-center">
            <button onclick="loadMoreTransactions()" id="loadMoreBtn" class="bg-white hover:bg-green-50 text-gray-700 font-semibold py-4 px-8 rounded-2xl shadow-md hover:shadow-lg transition-all duration-300 flex items-center space-x-3 border-2 border-gray-200 hover:border-green-400">
                <i class="bi bi-arrow-clockwise text-xl text-green-600"></i>
                <span>Muat Lebih Banyak Riwayat</span>
            </button>
        </div>

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

    <!-- Modal Detail Setor Sampah -->
    <div id="modalDetailSetor" class="fixed inset-0 bg-black bg-opacity-50 hidden items-center justify-center z-50 p-4">
        <div class="bg-white rounded-3xl max-w-2xl w-full shadow-2xl transform transition-all max-h-[90vh] overflow-y-auto">
            <!-- Modal Header -->
            <div class="bg-gradient-to-r from-green-500 to-green-600 rounded-t-3xl p-6 sticky top-0 z-10">
                <div class="flex items-center justify-between">
                    <div class="flex items-center space-x-4">
                        <div class="w-16 h-16 bg-white rounded-2xl flex items-center justify-center shadow-lg">
                            <i class="bi bi-arrow-up-right text-green-600 text-3xl"></i>
                        </div>
                        <div>
                            <h2 class="text-2xl font-bold text-white">Detail Setoran</h2>
                            <p class="text-green-50 text-sm">Riwayat Setoran Sampah</p>
                        </div>
                    </div>
                    <button onclick="closeModalSetor()" class="w-10 h-10 bg-white bg-opacity-20 hover:bg-opacity-30 rounded-xl flex items-center justify-center transition-all">
                        <i class="bi bi-x-lg text-white text-xl"></i>
                    </button>
                </div>
            </div>

            <!-- Modal Body -->
            <div class="p-6">
                <div class="bg-gradient-to-br from-green-50 to-emerald-50 rounded-2xl p-6 mb-6">
                    <div class="grid grid-cols-2 gap-x-8 gap-y-4">
                        <div>
                            <p class="text-sm text-gray-500 mb-1 flex items-center">
                                <i class="bi bi-hash text-gray-400 mr-2"></i>
                                Kode Transaksi
                            </p>
                            <p id="setorKode" class="font-bold text-gray-800 text-lg">-</p>
                        </div>
                        <div class="text-right">
                            <span id="setorStatusBadge" class="inline-block px-4 py-2 bg-green-100 text-green-700 rounded-full text-sm font-semibold">
                                Selesai
                            </span>
                        </div>
                        
                        <div>
                            <p class="text-sm text-gray-500 mb-1 flex items-center">
                                <i class="bi bi-calendar-event text-gray-400 mr-2"></i>
                                Tanggal
                            </p>
                            <p id="setorTanggal" class="font-semibold text-gray-800">-</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500 mb-1 flex items-center">
                                <i class="bi bi-box-seam text-gray-400 mr-2"></i>
                                Berat
                            </p>
                            <p id="setorBerat" class="font-semibold text-gray-800">-</p>
                        </div>

                        <div class="col-span-2 border-t border-green-200 pt-4 mt-2">
                            <div class="grid grid-cols-3 gap-4">
                                <div class="bg-white rounded-xl p-4 shadow-sm">
                                    <p class="text-xs text-gray-500 mb-2">Poin Diperoleh</p>
                                    <p id="setorPoin" class="font-bold text-green-600 text-2xl">
                                        <i class="bi bi-coin text-green-500 mr-1"></i>
                                        500 poin
                                    </p>
                                </div>
                                <div class="bg-white rounded-xl p-4 shadow-sm">
                                    <p class="text-xs text-gray-500 mb-2">Poin Sebelum</p>
                                    <p id="setorPoinSebelum" class="font-semibold text-gray-800 text-lg">-</p>
                                </div>
                                <div class="bg-white rounded-xl p-4 shadow-sm">
                                    <p class="text-xs text-gray-500 mb-2">Poin Setelah</p>
                                    <p id="setorPoinSetelah" class="font-semibold text-gray-800 text-lg">-</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="mt-6 flex gap-3">
                    <button onclick="closeModalSetor()" class="flex-1 bg-gray-100 hover:bg-gray-200 text-gray-700 font-semibold py-4 rounded-xl transition-all">
                        <i class="bi bi-x-circle mr-2"></i>
                        Tutup
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Detail Tukar Poin -->
    <div id="modalDetailTukar" class="fixed inset-0 bg-black bg-opacity-50 hidden items-center justify-center z-50 p-4">
        <div class="bg-white rounded-3xl max-w-2xl w-full shadow-2xl transform transition-all max-h-[90vh] overflow-y-auto">
            <!-- Modal Header -->
            <div class="bg-gradient-to-r from-blue-500 to-blue-600 rounded-t-3xl p-6 sticky top-0 z-10">
                <div class="flex items-center justify-between">
                    <div class="flex items-center space-x-4">
                        <div class="w-16 h-16 bg-white rounded-2xl flex items-center justify-center shadow-lg">
                            <i class="bi bi-arrow-down-left text-blue-600 text-3xl"></i>
                        </div>
                        <div>
                            <h2 class="text-2xl font-bold text-white">Detail Penukaran</h2>
                            <p class="text-blue-50 text-sm">Riwayat Tukar Poin</p>
                        </div>
                    </div>
                    <button onclick="closeModalTukar()" class="w-10 h-10 bg-white bg-opacity-20 hover:bg-opacity-30 rounded-xl flex items-center justify-center transition-all">
                        <i class="bi bi-x-lg text-white text-xl"></i>
                    </button>
                </div>
            </div>

            <!-- Modal Body -->
            <div class="p-6">
                <div class="bg-gradient-to-br from-blue-50 to-indigo-50 rounded-2xl p-6 mb-6">
                    <div class="grid grid-cols-2 gap-x-8 gap-y-4">
                        <div>
                            <p class="text-sm text-gray-500 mb-1 flex items-center">
                                <i class="bi bi-hash text-gray-400 mr-2"></i>
                                Kode Transaksi
                            </p>
                            <p id="tukarKode" class="font-bold text-gray-800 text-lg">-</p>
                        </div>
                        <div class="text-right">
                            <span id="tukarStatusBadge" class="inline-block px-4 py-2 bg-yellow-100 text-yellow-700 rounded-full text-sm font-semibold">
                                Menunggu
                            </span>
                        </div>
                        
                        <div>
                            <p class="text-sm text-gray-500 mb-1 flex items-center">
                                <i class="bi bi-calendar-event text-gray-400 mr-2"></i>
                                Tanggal
                            </p>
                            <p id="tukarTanggal" class="font-semibold text-gray-800">-</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500 mb-1 flex items-center">
                                <i class="bi bi-gift text-gray-400 mr-2"></i>
                                Hadiah
                            </p>
                            <p id="tukarHadiah" class="font-semibold text-gray-800">-</p>
                        </div>

                        <div class="col-span-2 border-t border-blue-200 pt-4 mt-2">
                            <div class="bg-white rounded-xl p-4 shadow-sm">
                                <p class="text-xs text-gray-500 mb-2">Poin Digunakan</p>
                                <p id="tukarPoin" class="font-bold text-blue-600 text-2xl">
                                    <i class="bi bi-coin text-blue-500 mr-1"></i>
                                    - 500 poin
                                </p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="mt-6 flex gap-3">
                    <button onclick="closeModalTukar()" class="flex-1 bg-gray-100 hover:bg-gray-200 text-gray-700 font-semibold py-4 rounded-xl transition-all">
                        <i class="bi bi-x-circle mr-2"></i>
                        Tutup
                    </button>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Load More Transactions
        function loadMoreTransactions() {
            const moreTransactions = document.getElementById('moreTransactions');
            const btn = document.getElementById('loadMoreBtn');
            
            if (moreTransactions.classList.contains('hidden')) {
                // Show loading state
                const originalHTML = btn.innerHTML;
                btn.innerHTML = '<i class="bi bi-arrow-clockwise text-xl text-green-600 animate-spin"></i><span>Memuat...</span>';
                btn.disabled = true;
                
                // Simulate loading
                setTimeout(() => {
                    // Show hidden transactions
                    moreTransactions.classList.remove('hidden');
                    
                    // Change button text
                    btn.innerHTML = '<i class="bi bi-arrow-up text-xl text-green-600"></i><span>Sembunyikan Riwayat</span>';
                    btn.disabled = false;
                    
                    // Smooth scroll to new content
                    setTimeout(() => {
                        moreTransactions.scrollIntoView({ behavior: 'smooth', block: 'nearest' });
                    }, 100);
                }, 800);
            } else {
                // Hide transactions
                moreTransactions.classList.add('hidden');
                
                // Change button back
                btn.innerHTML = '<i class="bi bi-arrow-clockwise text-xl text-green-600"></i><span>Muat Lebih Banyak Riwayat</span>';
                
                // Scroll back up
                document.getElementById('transactionList').scrollIntoView({ behavior: 'smooth', block: 'start' });
            }
        }

        // Modal Setor
        function showDetailSetor(kode, judul, tanggal, berat, status, poin, poinSetelah, poinSebelum) {
            document.getElementById('setorKode').textContent = kode;
            document.getElementById('setorTanggal').textContent = tanggal;
            document.getElementById('setorBerat').textContent = berat;
            document.getElementById('setorPoin').innerHTML = '<i class="bi bi-coin text-green-500 mr-1"></i>' + poin + ' poin';
            document.getElementById('setorPoinSebelum').textContent = poinSebelum + ' poin';
            document.getElementById('setorPoinSetelah').textContent = poinSetelah + ' poin';
            
            const badge = document.getElementById('setorStatusBadge');
            badge.textContent = status;
            
            const modal = document.getElementById('modalDetailSetor');
            modal.classList.remove('hidden');
            modal.classList.add('flex');
            document.body.style.overflow = 'hidden';
        }

        function closeModalSetor() {
            const modal = document.getElementById('modalDetailSetor');
            modal.classList.add('hidden');
            modal.classList.remove('flex');
            document.body.style.overflow = 'auto';
        }

        // Modal Tukar
        function showDetailTukar(kode, judul, tanggal, hadiah, status, poin) {
            document.getElementById('tukarKode').textContent = kode;
            document.getElementById('tukarTanggal').textContent = tanggal;
            document.getElementById('tukarHadiah').textContent = hadiah;
            document.getElementById('tukarPoin').innerHTML = '<i class="bi bi-coin text-blue-500 mr-1"></i>- ' + poin + ' poin';
            
            const badge = document.getElementById('tukarStatusBadge');
            if (status === 'Selesai') {
                badge.className = 'inline-block px-4 py-2 bg-green-100 text-green-700 rounded-full text-sm font-semibold';
                badge.innerHTML = '<i class="bi bi-check-circle-fill mr-1"></i>Selesai';
            } else {
                badge.className = 'inline-block px-4 py-2 bg-yellow-100 text-yellow-700 rounded-full text-sm font-semibold';
                badge.innerHTML = '<i class="bi bi-clock-fill mr-1"></i>Menunggu Pengambilan';
            }
            
            const modal = document.getElementById('modalDetailTukar');
            modal.classList.remove('hidden');
            modal.classList.add('flex');
            document.body.style.overflow = 'hidden';
        }

        function closeModalTukar() {
            const modal = document.getElementById('modalDetailTukar');
            modal.classList.add('hidden');
            modal.classList.remove('flex');
            document.body.style.overflow = 'auto';
        }

        // Close modals on outside click
        document.getElementById('modalDetailSetor').addEventListener('click', function(e) {
            if (e.target === this) closeModalSetor();
        });

        document.getElementById('modalDetailTukar').addEventListener('click', function(e) {
            if (e.target === this) closeModalTukar();
        });

        // Close modals with ESC key
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') {
                closeModalSetor();
                closeModalTukar();
            }
        });
    </script>

</body>
</html>
