<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Tukar Poin - Green Saving</title>
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
                        <p class="text-sm text-green-600">Halo, {{ Auth::user()->full_name ?? Auth::user()->name ?? 'lisbeth' }}</p>
                    </div>
                </div>

                <!-- Points & Actions -->
                <div class="flex items-center space-x-4">
                    <!-- Points Display -->
                    <div class="bg-gradient-to-r from-green-100 to-green-50 px-6 py-3 rounded-full border-2 border-green-300 shadow-md">
                        <div class="flex items-center space-x-2">
                            <i class="bi bi-coin text-green-600 text-xl"></i>
                            <span id="user-points" class="font-bold text-green-700 text-lg">{{ Auth::user()->balance_points ?? 0 }} poin</span>
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
                    <a href="/tukar-poin" class="bg-green-500 text-white px-4 lg:px-6 py-3 rounded-2xl text-xs lg:text-sm font-semibold shadow-md flex items-center justify-center space-x-2 w-full cursor-default">
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
        
        <!-- Page Header -->
        <div class="bg-white rounded-2xl p-6 mb-6 shadow-sm">
            <h2 class="text-xl font-bold text-gray-800 mb-2">Tukar Poin Hadiah</h2>
            <p class="text-sm text-gray-500">Tukarkan poin Anda dengan hadiah menarik yang tersedia</p>
        </div>

        <!-- Loading State -->
        <div id="loading-rewards" class="flex justify-center py-12">
            <div class="animate-spin rounded-full h-12 w-12 border-b-2 border-green-500"></div>
        </div>

        <!-- Empty State -->
        <div id="empty-rewards" class="hidden text-center py-12 bg-white rounded-2xl">
            <i class="bi bi-gift text-gray-300 text-6xl mb-4"></i>
            <p class="text-gray-500 text-lg font-semibold">Belum ada hadiah tersedia</p>
            <p class="text-gray-400 text-sm">Silakan cek kembali nanti</p>
        </div>

        <!-- Rewards Grid -->
        <div id="rewards-grid" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 hidden">
            <!-- Items will be loaded dynamically via JavaScript -->
            <div class="bg-white rounded-2xl overflow-hidden shadow-sm hover:shadow-lg transition-shadow reward-card" 
                 data-name="Minyak Goreng" 
                 data-desc="1 Liter - Minyak goreng berkualitas" 
                 data-price="7500"
                 data-image="{{ asset('images/minyak goreng.png') }}">
                <div class="p-5">
                    <!-- Image -->
                    <div class="bg-gradient-to-br from-amber-50 to-orange-50 rounded-xl p-4 mb-4 flex items-center justify-center h-48">
                        <img src="{{ asset('images/minyak goreng.png') }}" alt="Minyak Goreng" class="h-40 w-auto object-contain">
                    </div>
                    
                    <!-- Content -->
                    <div class="space-y-3">
                        <div>
                            <h3 class="font-bold text-gray-800 text-lg mb-1">Minyak Goreng</h3>
                            <p class="text-sm text-gray-500">1 Liter - Minyak goreng berkualitas</p>
                        </div>
                        
                        <div class="flex items-center justify-between pt-2 border-t border-gray-100">
                            <div>
                                <p class="text-xs text-gray-500 mb-1">Harga</p>
                                <p class="text-lg font-bold text-green-600">
                                    <i class="bi bi-coin text-green-500 mr-1"></i>
                                    7500 poin
                                </p>
                            </div>
                        </div>
                        
                        <button class="exchange-btn w-full bg-gradient-to-r from-green-500 to-green-600 text-white py-3 rounded-xl font-semibold hover:from-green-600 hover:to-green-700 transition-all shadow-md hover:shadow-lg">
                            <i class="bi bi-cart-plus mr-2"></i>
                            Tukar Sekarang
                        </button>
                    </div>
                </div>
            </div>

            <!-- Reward Item 2: Gula Pasir -->
            <div class="bg-white rounded-2xl overflow-hidden shadow-sm hover:shadow-lg transition-shadow">
                <div class="p-5">
                    <!-- Image -->
                    <div class="bg-gradient-to-br from-blue-50 to-cyan-50 rounded-xl p-4 mb-4 flex items-center justify-center h-48">
                        <img src="{{ asset('images/gula.png') }}" alt="Gula Pasir" class="h-40 w-auto object-contain">
                    </div>
                    
                    <!-- Content -->
                    <div class="space-y-3">
                        <div>
                            <h3 class="font-bold text-gray-800 text-lg mb-1">Gula Pasir</h3>
                            <p class="text-sm text-gray-500">1 Kg - Gula pasir kristal putih</p>
                        </div>
                        
                        <div class="flex items-center justify-between pt-2 border-t border-gray-100">
                            <div>
                                <p class="text-xs text-gray-500 mb-1">Harga</p>
                                <p class="text-lg font-bold text-green-600">
                                    <i class="bi bi-coin text-green-500 mr-1"></i>
                                    6000 poin
                                </p>
                            </div>
                        </div>
                        
                        <button class="w-full bg-gradient-to-r from-green-500 to-green-600 text-white py-3 rounded-xl font-semibold hover:from-green-600 hover:to-green-700 transition-all shadow-md hover:shadow-lg">
                            <i class="bi bi-cart-plus mr-2"></i>
                            Tukar Sekarang
                        </button>
                    </div>
                </div>
            </div>

            <!-- Reward Item 3: Beras -->
            <div class="bg-white rounded-2xl overflow-hidden shadow-sm hover:shadow-lg transition-shadow">
                <div class="p-5">
                    <!-- Image -->
                    <div class="bg-gradient-to-br from-green-50 to-emerald-50 rounded-xl p-4 mb-4 flex items-center justify-center h-48">
                        <img src="{{ asset('images/beras.png') }}" alt="Beras" class="h-40 w-auto object-contain">
                    </div>
                    
                    <!-- Content -->
                    <div class="space-y-3">
                        <div>
                            <h3 class="font-bold text-gray-800 text-lg mb-1">Beras</h3>
                            <p class="text-sm text-gray-500">5 Kg - Beras premium kualitas terbaik</p>
                        </div>
                        
                        <div class="flex items-center justify-between pt-2 border-t border-gray-100">
                            <div>
                                <p class="text-xs text-gray-500 mb-1">Harga</p>
                                <p class="text-lg font-bold text-green-600">
                                    <i class="bi bi-coin text-green-500 mr-1"></i>
                                    25000 poin
                                </p>
                            </div>
                        </div>
                        
                        <button class="w-full bg-gradient-to-r from-green-500 to-green-600 text-white py-3 rounded-xl font-semibold hover:from-green-600 hover:to-green-700 transition-all shadow-md hover:shadow-lg">
                            <i class="bi bi-cart-plus mr-2"></i>
                            Tukar Sekarang
                        </button>
                    </div>
                </div>
            </div>

            <!-- Reward Item 4: Tepung Terigu -->
            <div class="bg-white rounded-2xl overflow-hidden shadow-sm hover:shadow-lg transition-shadow">
                <div class="p-5">
                    <!-- Image -->
                    <div class="bg-gradient-to-br from-purple-50 to-pink-50 rounded-xl p-4 mb-4 flex items-center justify-center h-48">
                        <img src="{{ asset('images/tepung.png') }}" alt="Tepung Terigu" class="h-40 w-auto object-contain">
                    </div>
                    
                    <!-- Content -->
                    <div class="space-y-3">
                        <div>
                            <h3 class="font-bold text-gray-800 text-lg mb-1">Tepung Terigu</h3>
                            <p class="text-sm text-gray-500">1 Kg - Tepung terigu serbaguna</p>
                        </div>
                        
                        <div class="flex items-center justify-between pt-2 border-t border-gray-100">
                            <div>
                                <p class="text-xs text-gray-500 mb-1">Harga</p>
                                <p class="text-lg font-bold text-green-600">
                                    <i class="bi bi-coin text-green-500 mr-1"></i>
                                    5000 poin
                                </p>
                            </div>
                        </div>
                        
                        <button class="w-full bg-gradient-to-r from-green-500 to-green-600 text-white py-3 rounded-xl font-semibold hover:from-green-600 hover:to-green-700 transition-all shadow-md hover:shadow-lg">
                            <i class="bi bi-cart-plus mr-2"></i>
                            Tukar Sekarang
                        </button>
                    </div>
                </div>
            </div>

            <!-- Reward Item 5: Kacang -->
            <div class="bg-white rounded-2xl overflow-hidden shadow-sm hover:shadow-lg transition-shadow">
                <div class="p-5">
                    <!-- Image -->
                    <div class="bg-gradient-to-br from-yellow-50 to-amber-50 rounded-xl p-4 mb-4 flex items-center justify-center h-48">
                        <img src="{{ asset('images/kacang.png') }}" alt="Kacang" class="h-40 w-auto object-contain">
                    </div>
                    
                    <!-- Content -->
                    <div class="space-y-3">
                        <div>
                            <h3 class="font-bold text-gray-800 text-lg mb-1">Kacang Kedelai</h3>
                            <p class="text-sm text-gray-500">1 Kg - Kacang kedelai pilihan</p>
                        </div>
                        
                        <div class="flex items-center justify-between pt-2 border-t border-gray-100">
                            <div>
                                <p class="text-xs text-gray-500 mb-1">Harga</p>
                                <p class="text-lg font-bold text-green-600">
                                    <i class="bi bi-coin text-green-500 mr-1"></i>
                                    8000 poin
                                </p>
                            </div>
                        </div>
                        
                        <button class="w-full bg-gradient-to-r from-green-500 to-green-600 text-white py-3 rounded-xl font-semibold hover:from-green-600 hover:to-green-700 transition-all shadow-md hover:shadow-lg">
                            <i class="bi bi-cart-plus mr-2"></i>
                            Tukar Sekarang
                        </button>
                    </div>
                </div>
            </div>

            <!-- Reward Item 6: Susu -->
            <div class="bg-white rounded-2xl overflow-hidden shadow-sm hover:shadow-lg transition-shadow">
                <div class="p-5">
                    <!-- Image -->
                    <div class="bg-gradient-to-br from-red-50 to-pink-50 rounded-xl p-4 mb-4 flex items-center justify-center h-48">
                        <img src="{{ asset('images/susu.png') }}" alt="Susu" class="h-40 w-auto object-contain">
                    </div>
                    
                    <!-- Content -->
                    <div class="space-y-3">
                        <div>
                            <h3 class="font-bold text-gray-800 text-lg mb-1">Susu</h3>
                            <p class="text-sm text-gray-500">1 Liter - Susu segar berkualitas</p>
                        </div>
                        
                        <div class="flex items-center justify-between pt-2 border-t border-gray-100">
                            <div>
                                <p class="text-xs text-gray-500 mb-1">Harga</p>
                                <p class="text-lg font-bold text-green-600">
                                    <i class="bi bi-coin text-green-500 mr-1"></i>
                                    9000 poin
                                </p>
                            </div>
                        </div>
                        
                        <button class="w-full bg-gradient-to-r from-green-500 to-green-600 text-white py-3 rounded-xl font-semibold hover:from-green-600 hover:to-green-700 transition-all shadow-md hover:shadow-lg">
                            <i class="bi bi-cart-plus mr-2"></i>
                            Tukar Sekarang
                        </button>
                    </div>
                </div>
            </div>

            <!-- Reward Item 7: Telur -->
            <div class="bg-white rounded-2xl overflow-hidden shadow-sm hover:shadow-lg transition-shadow">
                <div class="p-5">
                    <!-- Image -->
                    <div class="bg-gradient-to-br from-orange-50 to-yellow-50 rounded-xl p-4 mb-4 flex items-center justify-center h-48">
                        <img src="{{ asset('images/telur.png') }}" alt="Telur" class="h-40 w-auto object-contain">
                    </div>
                    
                    <!-- Content -->
                    <div class="space-y-3">
                        <div>
                            <h3 class="font-bold text-gray-800 text-lg mb-1">Telur Ayam</h3>
                            <p class="text-sm text-gray-500">1 Kg - Telur ayam segar</p>
                        </div>
                        
                        <div class="flex items-center justify-between pt-2 border-t border-gray-100">
                            <div>
                                <p class="text-xs text-gray-500 mb-1">Harga</p>
                                <p class="text-lg font-bold text-green-600">
                                    <i class="bi bi-coin text-green-500 mr-1"></i>
                                    10000 poin
                                </p>
                            </div>
                        </div>
                        
                        <button class="w-full bg-gradient-to-r from-green-500 to-green-600 text-white py-3 rounded-xl font-semibold hover:from-green-600 hover:to-green-700 transition-all shadow-md hover:shadow-lg">
                            <i class="bi bi-cart-plus mr-2"></i>
                            Tukar Sekarang
                        </button>
                    </div>
                </div>
            </div>

            <!-- Reward Item 8: Minyak Goreng (variant) -->
            <div class="bg-white rounded-2xl overflow-hidden shadow-sm hover:shadow-lg transition-shadow">
                <div class="p-5">
                    <!-- Image -->
                    <div class="bg-gradient-to-br from-amber-50 to-orange-50 rounded-xl p-4 mb-4 flex items-center justify-center h-48">
                        <img src="{{ asset('images/minyak goreng.png') }}" alt="Minyak Goreng" class="h-40 w-auto object-contain">
                    </div>
                    
                    <!-- Content -->
                    <div class="space-y-3">
                        <div>
                            <h3 class="font-bold text-gray-800 text-lg mb-1">Minyak Goreng Premium</h3>
                            <p class="text-sm text-gray-500">2 Liter - Minyak goreng premium</p>
                        </div>
                        
                        <div class="flex items-center justify-between pt-2 border-t border-gray-100">
                            <div>
                                <p class="text-xs text-gray-500 mb-1">Harga</p>
                                <p class="text-lg font-bold text-green-600">
                                    <i class="bi bi-coin text-green-500 mr-1"></i>
                                    14000 poin
                                </p>
                            </div>
                        </div>
                        
                        <button class="w-full bg-gradient-to-r from-green-500 to-green-600 text-white py-3 rounded-xl font-semibold hover:from-green-600 hover:to-green-700 transition-all shadow-md hover:shadow-lg">
                            <i class="bi bi-cart-plus mr-2"></i>
                            Tukar Sekarang
                        </button>
                    </div>
                </div>
            </div>

            <!-- Reward Item 9: Gula (variant) -->
            <div class="bg-white rounded-2xl overflow-hidden shadow-sm hover:shadow-lg transition-shadow">
                <div class="p-5">
                    <!-- Image -->
                    <div class="bg-gradient-to-br from-blue-50 to-cyan-50 rounded-xl p-4 mb-4 flex items-center justify-center h-48">
                        <img src="{{ asset('images/gula.png') }}" alt="Gula Pasir" class="h-40 w-auto object-contain">
                    </div>
                    
                    <!-- Content -->
                    <div class="space-y-3">
                        <div>
                            <h3 class="font-bold text-gray-800 text-lg mb-1">Gula Pasir Premium</h3>
                            <p class="text-sm text-gray-500">2 Kg - Gula pasir premium</p>
                        </div>
                        
                        <div class="flex items-center justify-between pt-2 border-t border-gray-100">
                            <div>
                                <p class="text-xs text-gray-500 mb-1">Harga</p>
                                <p class="text-lg font-bold text-green-600">
                                    <i class="bi bi-coin text-green-500 mr-1"></i>
                                    11000 poin
                                </p>
                            </div>
                        </div>
                        
                        <button class="w-full bg-gradient-to-r from-green-500 to-green-600 text-white py-3 rounded-xl font-semibold hover:from-green-600 hover:to-green-700 transition-all shadow-md hover:shadow-lg">
                            <i class="bi bi-cart-plus mr-2"></i>
                            Tukar Sekarang
                        </button>
                    </div>
                </div>
            </div>

            <!-- Reward Item 10: Beras (variant) -->
            <div class="bg-white rounded-2xl overflow-hidden shadow-sm hover:shadow-lg transition-shadow">
                <div class="p-5">
                    <!-- Image -->
                    <div class="bg-gradient-to-br from-green-50 to-emerald-50 rounded-xl p-4 mb-4 flex items-center justify-center h-48">
                        <img src="{{ asset('images/beras.png') }}" alt="Beras" class="h-40 w-auto object-contain">
                    </div>
                    
                    <!-- Content -->
                    <div class="space-y-3">
                        <div>
                            <h3 class="font-bold text-gray-800 text-lg mb-1">Beras Premium</h3>
                            <p class="text-sm text-gray-500">10 Kg - Beras premium organik</p>
                        </div>
                        
                        <div class="flex items-center justify-between pt-2 border-t border-gray-100">
                            <div>
                                <p class="text-xs text-gray-500 mb-1">Harga</p>
                                <p class="text-lg font-bold text-green-600">
                                    <i class="bi bi-coin text-green-500 mr-1"></i>
                                    48000 poin
                                </p>
                            </div>
                        </div>
                        
                        <button class="w-full bg-gradient-to-r from-green-500 to-green-600 text-white py-3 rounded-xl font-semibold hover:from-green-600 hover:to-green-700 transition-all shadow-md hover:shadow-lg">
                            <i class="bi bi-cart-plus mr-2"></i>
                            Tukar Sekarang
                        </button>
                    </div>
                </div>
            </div>

            <!-- Reward Item 11: Tepung (variant) -->
            <div class="bg-white rounded-2xl overflow-hidden shadow-sm hover:shadow-lg transition-shadow">
                <div class="p-5">
                    <!-- Image -->
                    <div class="bg-gradient-to-br from-purple-50 to-pink-50 rounded-xl p-4 mb-4 flex items-center justify-center h-48">
                        <img src="{{ asset('images/tepung.png') }}" alt="Tepung" class="h-40 w-auto object-contain">
                    </div>
                    
                    <!-- Content -->
                    <div class="space-y-3">
                        <div>
                            <h3 class="font-bold text-gray-800 text-lg mb-1">Tepung Terigu Premium</h3>
                            <p class="text-sm text-gray-500">2 Kg - Tepung premium protein tinggi</p>
                        </div>
                        
                        <div class="flex items-center justify-between pt-2 border-t border-gray-100">
                            <div>
                                <p class="text-xs text-gray-500 mb-1">Harga</p>
                                <p class="text-lg font-bold text-green-600">
                                    <i class="bi bi-coin text-green-500 mr-1"></i>
                                    9500 poin
                                </p>
                            </div>
                        </div>
                        
                        <button class="w-full bg-gradient-to-r from-green-500 to-green-600 text-white py-3 rounded-xl font-semibold hover:from-green-600 hover:to-green-700 transition-all shadow-md hover:shadow-lg">
                            <i class="bi bi-cart-plus mr-2"></i>
                            Tukar Sekarang
                        </button>
                    </div>
                </div>
            </div>

            <!-- Reward Item 12: Kacang (variant) -->
            <div class="bg-white rounded-2xl overflow-hidden shadow-sm hover:shadow-lg transition-shadow">
                <div class="p-5">
                    <!-- Image -->
                    <div class="bg-gradient-to-br from-yellow-50 to-amber-50 rounded-xl p-4 mb-4 flex items-center justify-center h-48">
                        <img src="{{ asset('images/kacang.png') }}" alt="Kacang" class="h-40 w-auto object-contain">
                    </div>
                    
                    <!-- Content -->
                    <div class="space-y-3">
                        <div>
                            <h3 class="font-bold text-gray-800 text-lg mb-1">Kacang Hijau</h3>
                            <p class="text-sm text-gray-500">2 Kg - Kacang hijau organik</p>
                        </div>
                        
                        <div class="flex items-center justify-between pt-2 border-t border-gray-100">
                            <div>
                                <p class="text-xs text-gray-500 mb-1">Harga</p>
                                <p class="text-lg font-bold text-green-600">
                                    <i class="bi bi-coin text-green-500 mr-1"></i>
                                    15000 poin
                                </p>
                            </div>
                        </div>
                        
                        <button class="w-full bg-gradient-to-r from-green-500 to-green-600 text-white py-3 rounded-xl font-semibold hover:from-green-600 hover:to-green-700 transition-all shadow-md hover:shadow-lg">
                            <i class="bi bi-cart-plus mr-2"></i>
                            Tukar Sekarang
                        </button>
                    </div>
                </div>
            </div>

        </div>

        <!-- Hidden Additional Rewards (akan muncul ketika "Muat Lebih Banyak" diklik) -->
        <div id="moreRewards" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mt-6 hidden">
            
            <!-- Reward Item 13: Sabun Cuci -->
            <div class="bg-white rounded-2xl overflow-hidden shadow-sm hover:shadow-lg transition-shadow">
                <div class="p-5">
                    <div class="bg-gradient-to-br from-blue-50 to-cyan-50 rounded-xl p-4 mb-4 flex items-center justify-center h-48">
                        <img src="{{ asset('images/sabun.png') }}" alt="Sabun Cuci" class="h-40 w-auto object-contain">
                    </div>
                    
                    <div class="space-y-3">
                        <div>
                            <h3 class="font-bold text-gray-800 text-lg mb-1">Sabun Cuci Piring</h3>
                            <p class="text-sm text-gray-500">800 ml - Sabun cuci berkualitas</p>
                        </div>
                        
                        <div class="flex items-center justify-between pt-2 border-t border-gray-100">
                            <div>
                                <p class="text-xs text-gray-500 mb-1">Harga</p>
                                <p class="text-lg font-bold text-green-600">
                                    <i class="bi bi-coin text-green-500 mr-1"></i>
                                    4500 poin
                                </p>
                            </div>
                        </div>
                        
                        <button class="w-full bg-gradient-to-r from-green-500 to-green-600 text-white py-3 rounded-xl font-semibold hover:from-green-600 hover:to-green-700 transition-all shadow-md hover:shadow-lg">
                            <i class="bi bi-cart-plus mr-2"></i>
                            Tukar Sekarang
                        </button>
                    </div>
                </div>
            </div>

            <!-- Reward Item 14: Deterjen -->
            <div class="bg-white rounded-2xl overflow-hidden shadow-sm hover:shadow-lg transition-shadow">
                <div class="p-5">
                    <div class="bg-gradient-to-br from-indigo-50 to-purple-50 rounded-xl p-4 mb-4 flex items-center justify-center h-48">
                        <img src="{{ asset('images/detergen.png') }}" alt="Deterjen" class="h-40 w-auto object-contain">
                    </div>
                    
                    <div class="space-y-3">
                        <div>
                            <h3 class="font-bold text-gray-800 text-lg mb-1">Deterjen Bubuk</h3>
                            <p class="text-sm text-gray-500">1 Kg - Deterjen wangi tahan lama</p>
                        </div>
                        
                        <div class="flex items-center justify-between pt-2 border-t border-gray-100">
                            <div>
                                <p class="text-xs text-gray-500 mb-1">Harga</p>
                                <p class="text-lg font-bold text-green-600">
                                    <i class="bi bi-coin text-green-500 mr-1"></i>
                                    8500 poin
                                </p>
                            </div>
                        </div>
                        
                        <button class="w-full bg-gradient-to-r from-green-500 to-green-600 text-white py-3 rounded-xl font-semibold hover:from-green-600 hover:to-green-700 transition-all shadow-md hover:shadow-lg">
                            <i class="bi bi-cart-plus mr-2"></i>
                            Tukar Sekarang
                        </button>
                    </div>
                </div>
            </div>

            <!-- Reward Item 15: Shampo -->
            <div class="bg-white rounded-2xl overflow-hidden shadow-sm hover:shadow-lg transition-shadow">
                <div class="p-5">
                    <div class="bg-gradient-to-br from-pink-50 to-rose-50 rounded-xl p-4 mb-4 flex items-center justify-center h-48">
                        <img src="{{ asset('images/shampo.png') }}" alt="Shampo" class="h-40 w-auto object-contain">
                    </div>
                    
                    <div class="space-y-3">
                        <div>
                            <h3 class="font-bold text-gray-800 text-lg mb-1">Shampo Anti Ketombe</h3>
                            <p class="text-sm text-gray-500">300 ml - Shampo untuk rambut sehat</p>
                        </div>
                        
                        <div class="flex items-center justify-between pt-2 border-t border-gray-100">
                            <div>
                                <p class="text-xs text-gray-500 mb-1">Harga</p>
                                <p class="text-lg font-bold text-green-600">
                                    <i class="bi bi-coin text-green-500 mr-1"></i>
                                    6500 poin
                                </p>
                            </div>
                        </div>
                        
                        <button class="w-full bg-gradient-to-r from-green-500 to-green-600 text-white py-3 rounded-xl font-semibold hover:from-green-600 hover:to-green-700 transition-all shadow-md hover:shadow-lg">
                            <i class="bi bi-cart-plus mr-2"></i>
                            Tukar Sekarang
                        </button>
                    </div>
                </div>
            </div>

            <!-- Reward Item 16: Pasta Gigi -->
            <div class="bg-white rounded-2xl overflow-hidden shadow-sm hover:shadow-lg transition-shadow">
                <div class="p-5">
                    <div class="bg-gradient-to-br from-cyan-50 to-teal-50 rounded-xl p-4 mb-4 flex items-center justify-center h-48">
                        <img src="{{ asset('images/pasta.png') }}" alt="Pasta Gigi" class="h-40 w-auto object-contain">
                    </div>
                    
                    <div class="space-y-3">
                        <div>
                            <h3 class="font-bold text-gray-800 text-lg mb-1">Pasta Gigi Keluarga</h3>
                            <p class="text-sm text-gray-500">150 gram - Pasta gigi pemutih</p>
                        </div>
                        
                        <div class="flex items-center justify-between pt-2 border-t border-gray-100">
                            <div>
                                <p class="text-xs text-gray-500 mb-1">Harga</p>
                                <p class="text-lg font-bold text-green-600">
                                    <i class="bi bi-coin text-green-500 mr-1"></i>
                                    3500 poin
                                </p>
                            </div>
                        </div>
                        
                        <button class="w-full bg-gradient-to-r from-green-500 to-green-600 text-white py-3 rounded-xl font-semibold hover:from-green-600 hover:to-green-700 transition-all shadow-md hover:shadow-lg">
                            <i class="bi bi-cart-plus mr-2"></i>
                            Tukar Sekarang
                        </button>
                    </div>
                </div>
            </div>

            <!-- Reward Item 17: Sabun Mandi -->
            <div class="bg-white rounded-2xl overflow-hidden shadow-sm hover:shadow-lg transition-shadow">
                <div class="p-5">
                    <div class="bg-gradient-to-br from-orange-50 to-amber-50 rounded-xl p-4 mb-4 flex items-center justify-center h-48">
                        <img src="{{ asset('images/sabuncair.png') }}" alt="Sabun Mandi" class="h-40 w-auto object-contain">
                    </div>
                    
                    <div class="space-y-3">
                        <div>
                            <h3 class="font-bold text-gray-800 text-lg mb-1">Sabun Mandi Cair</h3>
                            <p class="text-sm text-gray-500">500 ml - Sabun mandi aroma segar</p>
                        </div>
                        
                        <div class="flex items-center justify-between pt-2 border-t border-gray-100">
                            <div>
                                <p class="text-xs text-gray-500 mb-1">Harga</p>
                                <p class="text-lg font-bold text-green-600">
                                    <i class="bi bi-coin text-green-500 mr-1"></i>
                                    5500 poin
                                </p>
                            </div>
                        </div>
                        
                        <button class="w-full bg-gradient-to-r from-green-500 to-green-600 text-white py-3 rounded-xl font-semibold hover:from-green-600 hover:to-green-700 transition-all shadow-md hover:shadow-lg">
                            <i class="bi bi-cart-plus mr-2"></i>
                            Tukar Sekarang
                        </button>
                    </div>
                </div>
            </div>

            <!-- Reward Item 18: Sikat Gigi -->
            <div class="bg-white rounded-2xl overflow-hidden shadow-sm hover:shadow-lg transition-shadow">
                <div class="p-5">
                    <div class="bg-gradient-to-br from-lime-50 to-green-50 rounded-xl p-4 mb-4 flex items-center justify-center h-48">
                        <img src="{{ asset('images/sikat gigi.png') }}" alt="Sikat Gigi" class="h-40 w-auto object-contain">
                    </div>
                    
                    <div class="space-y-3">
                        <div>
                            <h3 class="font-bold text-gray-800 text-lg mb-1">Sikat Gigi Premium</h3>
                            <p class="text-sm text-gray-500">1 Set (4 pcs) - Sikat gigi lembut</p>
                        </div>
                        
                        <div class="flex items-center justify-between pt-2 border-t border-gray-100">
                            <div>
                                <p class="text-xs text-gray-500 mb-1">Harga</p>
                                <p class="text-lg font-bold text-green-600">
                                    <i class="bi bi-coin text-green-500 mr-1"></i>
                                    4000 poin
                                </p>
                            </div>
                        </div>
                        
                        <button class="w-full bg-gradient-to-r from-green-500 to-green-600 text-white py-3 rounded-xl font-semibold hover:from-green-600 hover:to-green-700 transition-all shadow-md hover:shadow-lg">
                            <i class="bi bi-cart-plus mr-2"></i>
                            Tukar Sekarang
                        </button>
                    </div>
                </div>
            </div>

        </div>

        <!-- Pagination or Load More -->
        <div class="mt-8 text-center">
            <button id="loadMoreBtn" onclick="loadMoreRewards()" class="px-8 py-3 bg-white text-gray-700 rounded-xl font-semibold hover:bg-gray-50 transition-colors shadow-sm border border-gray-200">
                <i class="bi bi-arrow-clockwise mr-2"></i>
                Muat Lebih Banyak Hadiah
            </button>
        </div>

    </main>

    <script>
        function loadMoreRewards() {
            const moreRewards = document.getElementById('moreRewards');
            const loadMoreBtn = document.getElementById('loadMoreBtn');
            
            if (moreRewards.classList.contains('hidden')) {
                // Tampilkan lebih banyak hadiah
                moreRewards.classList.remove('hidden');
                
                // Ubah tombol
                loadMoreBtn.innerHTML = '<i class="bi bi-arrow-up mr-2"></i>Tampilkan Lebih Sedikit';
                
                // Scroll smooth ke hadiah tambahan
                setTimeout(() => {
                    moreRewards.scrollIntoView({ behavior: 'smooth', block: 'nearest' });
                }, 100);
            } else {
                // Sembunyikan hadiah tambahan
                moreRewards.classList.add('hidden');
                
                // Ubah tombol kembali
                loadMoreBtn.innerHTML = '<i class="bi bi-arrow-clockwise mr-2"></i>Muat Lebih Banyak Hadiah';
                
                // Scroll kembali ke atas grid
                window.scrollTo({ top: 0, behavior: 'smooth' });
            }
        }
    </script>

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

    <!-- Modal Konfirmasi Penukaran -->
    <div id="confirmModal" class="fixed inset-0 bg-black bg-opacity-50 hidden items-center justify-center z-50 p-4">
        <div class="bg-white rounded-3xl max-w-md w-full shadow-2xl transform transition-all">
            <!-- Modal Header -->
            <div class="bg-gradient-to-r from-green-500 to-green-600 rounded-t-3xl p-6 text-center">
                <div class="w-20 h-20 bg-white rounded-full mx-auto flex items-center justify-center shadow-lg mb-4">
                    <i class="bi bi-cart-check-fill text-green-500 text-4xl"></i>
                </div>
                <h2 class="text-2xl font-bold text-white mb-2">Konfirmasi Penukaran</h2>
                <p class="text-green-50 text-sm">Apakah Anda yakin ingin menukar poin dengan reward ini?</p>
            </div>

            <!-- Modal Body -->
            <div class="p-6">
                <!-- Product Info -->
                <div class="bg-gradient-to-br from-green-50 to-emerald-50 rounded-2xl p-4 mb-6 flex items-center space-x-4">
                    <div class="w-20 h-20 bg-white rounded-xl flex items-center justify-center shadow-sm">
                        <img id="modalProductImage" src="" alt="" class="h-16 w-auto object-contain">
                    </div>
                    <div class="flex-1">
                        <h3 id="modalProductName" class="font-bold text-gray-800 text-lg mb-1"></h3>
                        <p id="modalProductDesc" class="text-sm text-gray-600"></p>
                    </div>
                </div>

                <!-- Point Details -->
                <div class="space-y-3 mb-6">
                    <div class="flex justify-between items-center pb-3 border-b border-gray-200">
                        <span class="text-gray-600 text-sm">Harga:</span>
                        <span id="modalProductPrice" class="font-bold text-lg text-gray-800"></span>
                    </div>
                    <div class="flex justify-between items-center pb-3 border-b border-gray-200">
                        <span class="text-gray-600 text-sm">Saldo Anda:</span>
                        <span class="font-bold text-lg text-green-600">
                            <i class="bi bi-coin text-green-500 mr-1"></i>
                            15420 poin
                        </span>
                    </div>
                    <div class="flex justify-between items-center pt-2">
                        <span class="text-gray-700 font-semibold">Sisa Setelah Tukar:</span>
                        <span id="modalRemainingPoints" class="font-bold text-xl text-green-600">
                            <i class="bi bi-coin text-green-500 mr-1"></i>
                        </span>
                    </div>
                </div>

                <!-- Warning Message (if insufficient points) -->
                <div id="insufficientPointsWarning" class="hidden bg-red-50 border-l-4 border-red-500 p-4 mb-4 rounded-lg">
                    <div class="flex items-center">
                        <i class="bi bi-exclamation-triangle-fill text-red-500 text-xl mr-3"></i>
                        <div>
                            <p class="font-semibold text-red-800 text-sm">Poin Anda Tidak Mencukupi!</p>
                            <p class="text-red-700 text-xs mt-1">Poin anda kurang <span id="pointsShortage" class="font-bold"></span></p>
                            <p class="text-red-600 text-xs mt-1">Pilih barang lain atau tukarkan sampah Anda untuk menambah poin.</p>
                        </div>
                    </div>
                </div>

                <!-- Action Buttons -->
                <div class="flex gap-3">
                    <button onclick="closeConfirmModal()" class="flex-1 bg-gray-100 hover:bg-gray-200 text-gray-700 font-semibold py-3.5 rounded-xl transition-all">
                        <i class="bi bi-x-circle mr-2"></i>
                        Batal
                    </button>
                    <button id="confirmExchangeBtn" onclick="confirmExchange()" class="flex-1 bg-gradient-to-r from-green-500 to-green-600 hover:from-green-600 hover:to-green-700 text-white font-semibold py-3.5 rounded-xl transition-all shadow-md hover:shadow-lg">
                        <i class="bi bi-check-circle-fill mr-2"></i>
                        Konfirmasi Tukar
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Success -->
    <div id="successModal" class="fixed inset-0 bg-black bg-opacity-50 hidden items-center justify-center z-50 p-4">
        <div class="bg-white rounded-3xl max-w-md w-full shadow-2xl transform transition-all">
            <!-- Success Animation -->
            <div class="p-8 text-center">
                <div class="w-24 h-24 bg-gradient-to-br from-green-400 to-green-600 rounded-full mx-auto flex items-center justify-center shadow-lg mb-6 animate-bounce">
                    <i class="bi bi-check-lg text-white text-5xl"></i>
                </div>
                
                <h2 class="text-2xl font-bold text-gray-800 mb-3">Penukaran Poin Berhasil!</h2>
                <div class="w-16 h-1 bg-gradient-to-r from-green-400 to-green-600 mx-auto rounded-full mb-4"></div>
                
                <p class="text-gray-600 mb-6 leading-relaxed">
                    Segera ambil barang Anda sesuai lokasi yang dipilih dalam waktu 
                    <span class="font-bold text-green-600">1 x 24 jam</span>
                </p>

                <!-- Pickup Location Info -->
                <div class="bg-gradient-to-br from-green-50 to-emerald-50 rounded-2xl p-4 mb-6">
                    <div class="flex items-start space-x-3">
                        <i class="bi bi-geo-alt-fill text-green-600 text-2xl mt-1"></i>
                        <div class="text-left flex-1">
                            <p class="font-semibold text-gray-800 mb-1">Lokasi Pengambilan:</p>
                            <p class="text-sm text-gray-600">Bank Sampah Sitolusna</p>
                            <p class="text-sm text-gray-600">Jl. Sitolusna, Kec. Balige, Toba, Sumatera Utara</p>
                        </div>
                    </div>
                </div>

                <!-- New Balance -->
                <div class="bg-white border-2 border-green-200 rounded-xl p-4 mb-6">
                    <p class="text-sm text-gray-600 mb-2">Saldo Poin Anda Sekarang:</p>
                    <p class="text-3xl font-bold text-green-600">
                        <i class="bi bi-coin text-green-500 mr-2"></i>
                        <span id="newBalance">15420</span> poin
                    </p>
                </div>

                <button onclick="closeSuccessModal()" class="w-full bg-gradient-to-r from-green-500 to-green-600 hover:from-green-600 hover:to-green-700 text-white font-semibold py-4 rounded-xl transition-all shadow-md hover:shadow-lg">
                    <i class="bi bi-check-circle mr-2"></i>
                    Mengerti
                </button>
            </div>
        </div>
    </div>

    <script>
        let selectedReward = null;
        let allRewards = [];
        const currentPoints = {{ Auth::user()->balance_points ?? 0 }};

        // === FETCH DATA ===
        async function fetchRewards() {
            const loading = document.getElementById('loading-rewards');
            const empty = document.getElementById('empty-rewards');
            const grid = document.getElementById('rewards-grid');

            loading.classList.remove('hidden');
            empty.classList.add('hidden');
            grid.classList.add('hidden');

            try {
                const response = await fetch('/api/reward-items');
                allRewards = await response.json();
                
                renderRewards();
            } catch (error) {
                console.error('Error fetching rewards:', error);
                loading.classList.add('hidden');
                empty.classList.remove('hidden');
            }
        }

        function renderRewards() {
            const loading = document.getElementById('loading-rewards');
            const empty = document.getElementById('empty-rewards');
            const grid = document.getElementById('rewards-grid');

            loading.classList.add('hidden');

            if (allRewards.length === 0) {
                empty.classList.remove('hidden');
                grid.classList.add('hidden');
                return;
            }

            empty.classList.add('hidden');
            grid.classList.remove('hidden');

            const colors = [
                'from-amber-50 to-orange-50',
                'from-blue-50 to-cyan-50',
                'from-green-50 to-emerald-50',
                'from-purple-50 to-pink-50',
                'from-yellow-50 to-amber-50',
                'from-red-50 to-pink-50'
            ];

            grid.innerHTML = allRewards.map((reward, index) => {
                const colorClass = colors[index % colors.length];
                const imagePath = reward.image ? `/storage/${reward.image}` : '/images/default-reward.png';
                const canAfford = currentPoints >= reward.points_cost;

                return `
                    <div class="bg-white rounded-2xl overflow-hidden shadow-sm hover:shadow-lg transition-shadow">
                        <div class="p-5">
                            <div class="bg-gradient-to-br ${colorClass} rounded-xl p-4 mb-4 flex items-center justify-center h-48">
                                <img src="${imagePath}" alt="${reward.name}" class="h-40 w-auto object-contain" onerror="this.src='/images/default-reward.png'">
                            </div>
                            
                            <div class="space-y-3">
                                <div>
                                    <h3 class="font-bold text-gray-800 text-lg mb-1">${reward.name}</h3>
                                    <p class="text-sm text-gray-500">${reward.description || 'Hadiah menarik'}</p>
                                </div>
                                
                                <div class="flex items-center justify-between pt-2 border-t border-gray-100">
                                    <div>
                                        <p class="text-xs text-gray-500 mb-1">Harga</p>
                                        <p class="text-lg font-bold text-green-600">
                                            <i class="bi bi-coin text-green-500 mr-1"></i>
                                            ${reward.points_cost.toLocaleString('id-ID')} poin
                                        </p>
                                    </div>
                                    <div class="text-right">
                                        <p class="text-xs text-gray-500 mb-1">Stok</p>
                                        <p class="text-sm font-semibold ${reward.stock < 5 ? 'text-red-600' : 'text-gray-700'}">
                                            ${reward.stock} tersedia
                                        </p>
                                    </div>
                                </div>
                                
                                <button onclick="selectReward(${reward.id})" 
                                        class="w-full ${canAfford ? 'bg-gradient-to-r from-green-500 to-green-600 hover:from-green-600 hover:to-green-700 text-white' : 'bg-gray-300 text-gray-500 cursor-not-allowed'} py-3 rounded-xl font-semibold transition-all shadow-md hover:shadow-lg"
                                        ${!canAfford ? 'disabled' : ''}>
                                    <i class="bi bi-cart-plus mr-2"></i>
                                    ${canAfford ? 'Tukar Sekarang' : 'Poin Tidak Cukup'}
                                </button>
                            </div>
                        </div>
                    </div>
                `;
            }).join('');
        }

        function selectReward(rewardId) {
            selectedReward = allRewards.find(r => r.id === rewardId);
            if (!selectedReward) return;

            openConfirmModal();
        }

        function openConfirmModal() {
            document.getElementById('modalProductName').textContent = selectedReward.name;
            document.getElementById('modalProductDesc').textContent = selectedReward.description || 'Hadiah menarik';
            document.getElementById('modalProductPrice').innerHTML = `<i class="bi bi-coin text-green-500 mr-1"></i>${selectedReward.points_cost.toLocaleString('id-ID')} poin`;
            
            const imagePath = selectedReward.image ? `/storage/${selectedReward.image}` : '/images/default-reward.png';
            document.getElementById('modalProductImage').src = imagePath;
            document.getElementById('modalProductImage').alt = selectedReward.name;

            const remaining = currentPoints - selectedReward.points_cost;
            const remainingEl = document.getElementById('modalRemainingPoints');
            
            if (remaining >= 0) {
                remainingEl.innerHTML = `<i class="bi bi-coin text-green-500 mr-1"></i>${remaining.toLocaleString('id-ID')} poin`;
                remainingEl.classList.remove('text-red-600');
                remainingEl.classList.add('text-green-600');
                document.getElementById('insufficientPointsWarning').classList.add('hidden');
                document.getElementById('confirmExchangeBtn').disabled = false;
                document.getElementById('confirmExchangeBtn').classList.remove('opacity-50', 'cursor-not-allowed');
            } else {
                remainingEl.innerHTML = `<i class="bi bi-coin text-red-500 mr-1"></i>${remaining.toLocaleString('id-ID')} poin`;
                remainingEl.classList.add('text-red-600');
                remainingEl.classList.remove('text-green-600');
                document.getElementById('pointsShortage').textContent = Math.abs(remaining).toLocaleString('id-ID') + ' poin';
                document.getElementById('insufficientPointsWarning').classList.remove('hidden');
                document.getElementById('confirmExchangeBtn').disabled = true;
                document.getElementById('confirmExchangeBtn').classList.add('opacity-50', 'cursor-not-allowed');
            }

            document.getElementById('confirmModal').classList.remove('hidden');
            document.getElementById('confirmModal').classList.add('flex');
        }

        function closeConfirmModal() {
            document.getElementById('confirmModal').classList.add('hidden');
        }

        async function confirmExchange() {
            if (currentPoints < selectedReward.points_cost) return;

            try {
                const response = await fetch('/api/redemptions', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content || '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({
                        items: [{
                            reward_item_id: selectedReward.id,
                            quantity: 1
                        }]
                    })
                });

                const result = await response.json();

                if (response.ok) {
                    closeConfirmModal();
                    const newBalance = currentPoints - selectedReward.points_cost;
                    document.getElementById('newBalance').textContent = newBalance.toLocaleString('id-ID');
                    
                    // Show success modal
                    setTimeout(() => {
                        document.getElementById('successModal').classList.remove('hidden');
                        document.getElementById('successModal').classList.add('flex');
                    }, 300);
                } else {
                    alert(result.message || 'Terjadi kesalahan');
                    closeConfirmModal();
                }
            } catch (error) {
                console.error('Error:', error);
                alert('Terjadi kesalahan saat mengirim data');
                closeConfirmModal();
            }
        }

        function closeSuccessModal() {
            document.getElementById('successModal').classList.add('hidden');
            window.location.href = '/riwayat';
        }

        // Initialize
        document.addEventListener('DOMContentLoaded', function() {
            fetchRewards();
        });
    </script>
            const exchangeButtons = document.querySelectorAll('.exchange-btn, button:not(#loadMoreBtn):not(#confirmExchangeBtn):not([onclick*="close"])');
            
            exchangeButtons.forEach(button => {
                const buttonText = button.textContent.trim();
                if (buttonText.includes('Tukar Sekarang')) {
                    button.addEventListener('click', function(e) {
                        e.preventDefault();
                        
                        // Find parent card
                        const card = this.closest('.bg-white.rounded-2xl');
                        if (!card) return;
                        
                        // Extract product data from card
                        const productNameEl = card.querySelector('h3');
                        const productDescEl = card.querySelector('h3 + p');
                        const productPriceEl = card.querySelector('.text-lg.font-bold.text-green-600');
                        const productImageEl = card.querySelector('img');
                        
                        if (!productNameEl || !productPriceEl || !productImageEl) return;
                        
                        const productName = productNameEl.textContent.trim();
                        const productDesc = productDescEl ? productDescEl.textContent.trim() : '';
                        const priceText = productPriceEl.textContent.trim();
                        const productPrice = parseInt(priceText.replace(/[^\d]/g, ''));
                        const productImage = productImageEl.src;
                        
                        openConfirmModal(productName, productDesc, productPrice, productImage);
                    });
                }
            });
        });

        function openConfirmModal(productName, productDesc, productPrice, productImage) {
            selectedProduct = {
                name: productName,
                description: productDesc,
                price: productPrice,
                image: productImage
            };

            // Update modal content
            document.getElementById('modalProductName').textContent = productName;
            document.getElementById('modalProductDesc').textContent = productDesc;
            document.getElementById('modalProductPrice').innerHTML = '<i class="bi bi-coin text-green-500 mr-1"></i>' + productPrice.toLocaleString('id-ID') + ' poin';
            document.getElementById('modalProductImage').src = productImage;
            document.getElementById('modalProductImage').alt = productName;

            // Calculate remaining points
            const remaining = currentPoints - productPrice;
            const remainingElement = document.getElementById('modalRemainingPoints');
            
            if (remaining >= 0) {
                remainingElement.innerHTML = remaining.toLocaleString('id-ID') + ' poin';
                remainingElement.classList.remove('text-red-600');
                remainingElement.classList.add('text-green-600');
                document.getElementById('insufficientPointsWarning').classList.add('hidden');
                document.getElementById('confirmExchangeBtn').disabled = false;
                document.getElementById('confirmExchangeBtn').classList.remove('opacity-50', 'cursor-not-allowed');
            } else {
                remainingElement.innerHTML = remaining.toLocaleString('id-ID') + ' poin';
                remainingElement.classList.remove('text-green-600');
                remainingElement.classList.add('text-red-600');
                document.getElementById('pointsShortage').textContent = Math.abs(remaining).toLocaleString('id-ID') + ' poin';
                document.getElementById('insufficientPointsWarning').classList.remove('hidden');
                document.getElementById('confirmExchangeBtn').disabled = true;
                document.getElementById('confirmExchangeBtn').classList.add('opacity-50', 'cursor-not-allowed');
            }

            // Show modal with animation
            const modal = document.getElementById('confirmModal');
            modal.classList.remove('hidden');
            modal.classList.add('flex');
            setTimeout(() => {
                modal.querySelector('.bg-white').classList.add('scale-100');
            }, 10);
        }

        function closeConfirmModal() {
            document.getElementById('confirmModal').classList.add('hidden');
            document.getElementById('confirmModal').classList.remove('flex');
        }

        function confirmExchange() {
            const remaining = currentPoints - selectedProduct.price;
            
            if (remaining < 0) {
                return; // Prevent exchange if insufficient points
            }

            // Close confirm modal
            closeConfirmModal();

            // Update new balance
            document.getElementById('newBalance').textContent = remaining.toLocaleString('id-ID');

            // Show success modal
            setTimeout(() => {
                document.getElementById('successModal').classList.remove('hidden');
                document.getElementById('successModal').classList.add('flex');
            }, 300);
        }

        function closeSuccessModal() {
            document.getElementById('successModal').classList.add('hidden');
            document.getElementById('successModal').classList.remove('flex');
            
            // Refresh page or update UI here
            // location.reload();
        }

        // Close modal when clicking outside
        document.getElementById('confirmModal').addEventListener('click', function(e) {
            if (e.target === this) {
                closeConfirmModal();
            }
        });

        document.getElementById('successModal').addEventListener('click', function(e) {
            if (e.target === this) {
                closeSuccessModal();
            }
        });
    </script>

</body>
</html>
