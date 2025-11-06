<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
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
                    <a href="/setor" class="bg-white text-gray-700 px-4 lg:px-6 py-3 rounded-2xl text-xs lg:text-sm font-semibold hover:bg-green-50 transition-colors shadow-sm flex items-center justify-center space-x-2 w-full cursor-pointer">
                        <i class="bi bi-recycle pointer-events-none"></i>
                        <span class="truncate pointer-events-none">Setor</span>
                    </a>
                    <a href="/tukar-poin" class="bg-green-500 text-white px-4 lg:px-6 py-3 rounded-2xl text-xs lg:text-sm font-semibold shadow-md flex items-center justify-center space-x-2 w-full cursor-default">
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
        
        <!-- Page Header -->
        <div class="bg-white rounded-2xl p-6 mb-6 shadow-sm">
            <h2 class="text-xl font-bold text-gray-800 mb-2">Tukar Poin Hadiah</h2>
            <p class="text-sm text-gray-500">Tukarkan poin Anda dengan berbagai hadiah menarik</p>
        </div>

        <!-- Rewards Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            
            <!-- Reward Item 1: Minyak Goreng -->
            <div class="bg-white rounded-2xl overflow-hidden shadow-sm hover:shadow-lg transition-shadow">
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
                        
                        <button class="w-full bg-gradient-to-r from-green-500 to-green-600 text-white py-3 rounded-xl font-semibold hover:from-green-600 hover:to-green-700 transition-all shadow-md hover:shadow-lg">
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
