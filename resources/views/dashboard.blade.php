<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Dashboard - Green Saving</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
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
    <header class="bg-white shadow-md sticky top-0 z-40">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-4">
            <div class="flex justify-between items-center gap-4">
                <!-- Logo -->
                <div class="flex items-center space-x-3">
                    <div class="w-12 h-12 bg-gradient-to-br from-green-500 to-green-600 rounded-2xl flex items-center justify-center shadow-lg transform hover:scale-105 transition-transform duration-200">
                        <i class="bi bi-recycle text-white text-2xl"></i>
                    </div>
                    <div class="hidden sm:block">
                        <h1 class="font-bold text-xl text-gray-800 leading-tight">Green Saving</h1>
                        <p class="text-xs text-green-600 font-medium">Halo, {{ $namaUser }}</p>
                    </div>
                </div>

                <!-- Points & Actions -->
                <div class="flex items-center space-x-2 lg:space-x-4">
                    <!-- Points Display -->
                    <div class="hidden lg:flex bg-gradient-to-r from-green-100 to-green-50 px-5 py-2.5 rounded-full border-2 border-green-300 shadow-md hover:shadow-lg transition-shadow">
                        <div class="flex items-center space-x-2">
                            <div class="w-7 h-7 bg-gradient-to-br from-green-500 to-green-600 rounded-full flex items-center justify-center">
                                <i class="bi bi-coin text-white text-sm"></i>
                            </div>
                            <span id="balance-points" class="font-bold text-green-700 text-base">{{ number_format($saldoPoin, 0, ',', '.') }}</span>
                        </div>
                    </div>

                    <!-- Cart Button with Badge -->
                    <a href="{{ route('cart.index') }}" class="relative w-11 h-11 bg-gradient-to-br from-green-500 to-green-600 rounded-xl flex items-center justify-center shadow-md hover:shadow-lg hover:scale-105 transition-all duration-200">
                        <i class="bi bi-cart3 text-white text-lg"></i>
                        @if(session('cart') && count(session('cart')) > 0)
                            <span class="absolute -top-1.5 -right-1.5 bg-gradient-to-br from-red-500 to-red-600 text-white text-xs font-bold rounded-full w-5 h-5 flex items-center justify-center shadow-md ring-2 ring-white">
                                {{ count(session('cart')) }}
                            </span>
                        @endif
                    </a>

                    <!-- Notification Bell with Dropdown -->
                    <div class="relative" x-data="{ open: false }" @click.away="open = false">
                        <button @click="open = !open" class="relative w-11 h-11 bg-gray-100 hover:bg-gray-200 rounded-xl flex items-center justify-center transition-all duration-200 hover:scale-105">
                            <i class="bi bi-bell text-gray-700 text-lg"></i>
                            @if(isset($unreadNotifications) && $unreadNotifications > 0)
                            <span class="absolute -top-1.5 -right-1.5 bg-gradient-to-br from-red-500 to-red-600 text-white text-xs font-bold rounded-full w-5 h-5 flex items-center justify-center shadow-md ring-2 ring-white">
                                {{ $unreadNotifications > 9 ? '9+' : $unreadNotifications }}
                            </span>
                            @endif
                        </button>

                        <!-- Dropdown Notifikasi -->
                        <div x-show="open" 
                             x-transition:enter="transition ease-out duration-200"
                             x-transition:enter-start="opacity-0 transform scale-95"
                             x-transition:enter-end="opacity-100 transform scale-100"
                             x-transition:leave="transition ease-in duration-150"
                             x-transition:leave-start="opacity-100 transform scale-100"
                             x-transition:leave-end="opacity-0 transform scale-95"
                             class="absolute right-0 mt-2 w-80 bg-white rounded-2xl shadow-2xl border-2 border-gray-100 overflow-hidden z-50"
                             style="display: none;">
                            
                            <!-- Header Dropdown -->
                            <div class="bg-gradient-to-r from-green-500 to-emerald-600 px-4 py-3">
                                <h3 class="text-white font-bold text-sm flex items-center gap-2">
                                    <i class="bi bi-bell-fill"></i>
                                    Notifikasi Terbaru
                                </h3>
                            </div>

                            <!-- Notifikasi List -->
                            <div class="max-h-96 overflow-y-auto">
                                @php
                                    $notifications = Auth::user()->notifications->take(5);
                                @endphp

                                @forelse($notifications as $notification)
                                    <a href="{{ route('notifikasi.read', $notification->id) }}" 
                                       class="block px-4 py-3 hover:bg-gray-50 transition-colors border-b border-gray-100 {{ $notification->read_at ? 'bg-white' : 'bg-blue-50' }}">
                                        <div class="flex items-start gap-3">
                                            <!-- Icon -->
                                            <div class="flex-shrink-0 w-10 h-10 rounded-full flex items-center justify-center bg-green-100">
                                                <i class="bi bi-bell-fill text-green-600"></i>
                                            </div>

                                            <!-- Content -->
                                            <div class="flex-1 min-w-0">
                                                <p class="text-sm font-semibold text-gray-800 line-clamp-2">
                                                    {{ $notification->data['title'] ?? 'Notifikasi Baru' }}
                                                </p>
                                                @if(isset($notification->data['message']))
                                                    <p class="text-xs text-gray-600 mt-1 line-clamp-1">
                                                        {{ $notification->data['message'] }}
                                                    </p>
                                                @endif
                                                <p class="text-xs text-gray-400 mt-1 flex items-center gap-1">
                                                    <i class="bi bi-clock"></i>
                                                    {{ $notification->created_at->diffForHumans() }}
                                                </p>
                                            </div>

                                            <!-- Unread Indicator -->
                                            @if(!$notification->read_at)
                                                <div class="flex-shrink-0 w-2 h-2 bg-blue-500 rounded-full"></div>
                                            @endif
                                        </div>
                                    </a>
                                @empty
                                    <div class="px-4 py-8 text-center">
                                        <div class="w-16 h-16 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-3">
                                            <i class="bi bi-bell-slash text-gray-400 text-2xl"></i>
                                        </div>
                                        <p class="text-gray-500 text-sm font-medium">Tidak ada notifikasi baru</p>
                                    </div>
                                @endforelse
                            </div>

                            <!-- Footer - Link ke halaman notifikasi lengkap -->
                            @if($notifications->count() > 0)
                            <div class="bg-gray-50 px-4 py-2 border-t border-gray-200">
                                <a href="/notifikasi" class="text-sm text-green-600 hover:text-green-700 font-semibold block text-center">
                                    Lihat Semua Notifikasi →
                                </a>
                            </div>
                            @endif
                        </div>
                    </div>

                    <!-- Profile Button -->
                    <a href="/profil" class="relative w-11 h-11 rounded-xl overflow-hidden border-2 border-green-500 hover:border-green-600 transition-all duration-200 hover:scale-105 shadow-lg group">
                        @if(Auth::user()->profile_photo)
                            <img src="{{ asset('storage/profile_photos/' . Auth::user()->profile_photo) }}" alt="Profile" class="w-full h-full object-cover">
                        @else
                            <div class="w-full h-full bg-green-500 group-hover:bg-green-600 flex items-center justify-center transition-colors">
                                <i class="bi bi-person-fill text-white text-lg"></i>
                            </div>
                        @endif
                    </a>

                    <!-- Logout Button -->
                    <form method="POST" action="/logout" class="inline">
                        @csrf
                        <button type="submit" class="w-11 h-11 bg-red-50 hover:bg-red-100 rounded-xl flex items-center justify-center transition-all duration-200 hover:scale-105 border border-red-200">
                            <i class="bi bi-box-arrow-right text-red-600 text-lg"></i>
                        </button>
                    </form>
                </div>
            </div>
        </div>

        <!-- Navigation Tabs -->
        <div class="bg-gradient-to-br from-green-50 via-green-100 to-emerald-100 px-4 py-5 border-t border-green-200/50">
            <div class="max-w-7xl mx-auto">
                <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-6 gap-2.5">
                    <a href="/dashboard" class="bg-gradient-to-br from-green-500 to-green-600 text-white px-3 lg:px-5 py-3 rounded-xl text-xs lg:text-sm font-semibold shadow-md flex items-center justify-center space-x-2 w-full cursor-default">
                        <i class="bi bi-house-door-fill pointer-events-none"></i>
                        <span class="truncate pointer-events-none hidden sm:inline">Dashboard</span>
                    </a>
                    <a href="/profil" class="bg-white text-gray-700 px-3 lg:px-5 py-3 rounded-xl text-xs lg:text-sm font-semibold hover:bg-green-50 hover:text-green-600 transition-all duration-200 shadow-sm hover:shadow flex items-center justify-center space-x-2 w-full cursor-pointer">
                        <i class="bi bi-person pointer-events-none"></i>
                        <span class="truncate pointer-events-none hidden sm:inline">Profil</span>
                    </a>
                    <a href="/setor" class="bg-white text-gray-700 px-3 lg:px-5 py-3 rounded-xl text-xs lg:text-sm font-semibold hover:bg-green-50 hover:text-green-600 transition-all duration-200 shadow-sm hover:shadow flex items-center justify-center space-x-2 w-full cursor-pointer">
                        <i class="bi bi-recycle pointer-events-none"></i>
                        <span class="truncate pointer-events-none hidden sm:inline">Setor</span>
                    </a>
                    <a href="/tukar-poin" class="bg-white text-gray-700 px-3 lg:px-5 py-3 rounded-xl text-xs lg:text-sm font-semibold hover:bg-green-50 hover:text-green-600 transition-all duration-200 shadow-sm hover:shadow flex items-center justify-center space-x-2 w-full cursor-pointer">
                        <i class="bi bi-gift pointer-events-none"></i>
                        <span class="truncate pointer-events-none hidden sm:inline">Tukar Poin</span>
                    </a>
                    <a href="/riwayat" class="bg-white text-gray-700 px-3 lg:px-5 py-3 rounded-xl text-xs lg:text-sm font-semibold hover:bg-green-50 hover:text-green-600 transition-all duration-200 shadow-sm hover:shadow flex items-center justify-center space-x-2 w-full cursor-pointer">
                        <i class="bi bi-clock-history pointer-events-none"></i>
                        <span class="truncate pointer-events-none hidden sm:inline">Riwayat</span>
                    </a>
                    <a href="/notifikasi" class="relative bg-white text-gray-700 px-3 lg:px-5 py-3 rounded-xl text-xs lg:text-sm font-semibold hover:bg-green-50 hover:text-green-600 transition-all duration-200 shadow-sm hover:shadow flex items-center justify-center space-x-2 w-full cursor-pointer">
                        <i class="bi bi-bell pointer-events-none"></i>
                        <span class="truncate pointer-events-none hidden sm:inline">Notifikasi</span>
                        @if(isset($unreadNotifications) && $unreadNotifications > 0)
                        <span class="absolute -top-1 -right-1 bg-gradient-to-br from-red-500 to-red-600 text-white text-xs font-bold rounded-full w-5 h-5 flex items-center justify-center pointer-events-none shadow-md ring-2 ring-white">
                            {{ $unreadNotifications > 9 ? '9+' : $unreadNotifications }}
                        </span>
                        @endif
                    </a>
                </div>
            </div>
        </div>
    </header>

    <!-- Main Content -->
    <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6 lg:py-10">
        
        <!-- Welcome Card -->
        <div class="bg-gradient-to-br from-green-500 via-green-600 to-emerald-600 rounded-3xl p-6 lg:p-10 mb-6 lg:mb-10 text-white shadow-xl overflow-hidden relative">
            <!-- Decorative Elements -->
            <div class="absolute top-0 right-0 w-64 h-64 bg-white opacity-5 rounded-full -mr-32 -mt-32"></div>
            <div class="absolute bottom-0 left-0 w-48 h-48 bg-white opacity-5 rounded-full -ml-24 -mb-24"></div>
            
            <div class="relative z-10 flex flex-col md:flex-row items-start md:items-center justify-between gap-6">
                <div class="flex-1">
                    <h2 class="text-2xl lg:text-3xl font-bold mb-3 leading-tight">Selamat Datang, <span id="user-name">{{ $namaUser }}</span> 👋</h2>
                    <p class="text-green-50 mb-5 text-sm lg:text-base">Mari kelola sampahmu dan dapatkan reward menarik</p>
                    <div class="flex flex-wrap items-start gap-4">
                        <!-- Member Badge -->
                        <div class="bg-white bg-opacity-20 backdrop-blur-md text-white px-5 py-3 rounded-xl border border-white border-opacity-20 shadow-lg">
                            <div class="flex items-center gap-2 mb-2">
                                <i class="bi {{ $memberLevel['icon'] }} {{ $memberLevel['text_color'] }} text-lg"></i>
                                <span class="font-bold text-base" id="user-member-level">{{ $memberLevel['name'] }}</span>
                            </div>
                            
                            @if($memberLevel['next_tier'])
                                <!-- Progress Bar -->
                                <div class="mb-1.5">
                                    <div class="w-48 h-2 bg-white bg-opacity-20 rounded-full overflow-hidden">
                                        <div class="h-full bg-gradient-to-r {{ $memberLevel['color'] }} rounded-full transition-all duration-500" 
                                             style="width: {{ $memberLevel['progress'] }}%">
                                        </div>
                                    </div>
                                </div>
                                <p class="text-xs text-green-100">
                                    {{ number_format($memberLevel['points_to_next'], 0, ',', '.') }} poin lagi ke tier berikutnya
                                </p>
                            @else
                                <p class="text-xs text-green-100 mt-1">
                                    <i class="bi bi-check-circle-fill"></i> Tier Tertinggi!
                                </p>
                            @endif
                        </div>

                        <!-- Member Since -->
                        <div class="bg-white bg-opacity-15 backdrop-blur-md text-white px-4 py-3 rounded-xl border border-white border-opacity-20 shadow-lg">
                            <div class="text-xs text-green-100 font-medium mb-1">
                                <i class="bi bi-calendar-check"></i> Member Sejak
                            </div>
                            <div class="font-bold text-base" id="member-since">
                                {{ $authUser->created_at ? $authUser->created_at->format('M Y') : 'Nov 2025' }}
                            </div>
                        </div>
                    </div>
                </div>
                <div class="text-center md:text-right">
                    <div class="bg-white bg-opacity-15 backdrop-blur-xl rounded-2xl px-8 py-5 mb-4 border border-white border-opacity-20 shadow-xl">
                        <div class="text-xs text-green-100 font-semibold mb-1 uppercase tracking-wider">Total Poin</div>
                        <div id="balance-points-large" class="text-3xl lg:text-4xl font-bold mb-1">{{ number_format($saldoPoin, 0, ',', '.') }}</div>
                        <div class="text-sm text-green-50 font-medium">ECO Coin</div>
                    </div>
                    <a href="/tukar-poin" class="inline-flex items-center gap-2 bg-white bg-opacity-20 backdrop-blur-md hover:bg-opacity-30 text-white px-6 py-2.5 rounded-xl text-sm font-semibold transition-all duration-200 border border-white border-opacity-20 shadow-lg hover:shadow-xl hover:scale-105">
                        <i class="bi bi-shop"></i>
                        Jelajahi Marketplace
                    </a>
                </div>
            </div>
        </div>

        <!-- Quick Actions -->
        <div class="grid grid-cols-2 lg:grid-cols-4 gap-4 mb-6 lg:mb-10">
            <!-- Setor Sampah -->
            <a href="/setor" class="group bg-gradient-to-br from-green-500 to-green-600 hover:from-green-600 hover:to-green-700 rounded-2xl p-6 text-white shadow-lg hover:shadow-xl transition-all duration-300 hover:scale-105">
                <div class="w-14 h-14 bg-white bg-opacity-20 rounded-xl flex items-center justify-center mb-4 group-hover:scale-110 transition-transform">
                    <i class="bi bi-recycle text-3xl"></i>
                </div>
                <h4 class="font-bold text-base mb-1">Setor Sampah</h4>
                <p class="text-xs text-green-100">Lihat harga & setor sekarang</p>
            </a>

            <!-- Tukar Poin -->
            <a href="/tukar-poin" class="group bg-gradient-to-br from-blue-500 to-blue-600 hover:from-blue-600 hover:to-blue-700 rounded-2xl p-6 text-white shadow-lg hover:shadow-xl transition-all duration-300 hover:scale-105">
                <div class="w-14 h-14 bg-white bg-opacity-20 rounded-xl flex items-center justify-center mb-4 group-hover:scale-110 transition-transform">
                    <i class="bi bi-gift text-3xl"></i>
                </div>
                <h4 class="font-bold text-base mb-1">Tukar Poin</h4>
                <p class="text-xs text-blue-100">Dapatkan reward menarik</p>
            </a>

            <!-- Riwayat -->
            <a href="/riwayat" class="group bg-gradient-to-br from-purple-500 to-purple-600 hover:from-purple-600 hover:to-purple-700 rounded-2xl p-6 text-white shadow-lg hover:shadow-xl transition-all duration-300 hover:scale-105">
                <div class="w-14 h-14 bg-white bg-opacity-20 rounded-xl flex items-center justify-center mb-4 group-hover:scale-110 transition-transform">
                    <i class="bi bi-clock-history text-3xl"></i>
                </div>
                <h4 class="font-bold text-base mb-1">Riwayat</h4>
                <p class="text-xs text-purple-100">Lihat semua transaksi</p>
            </a>

            <!-- Profil -->
            <a href="/profil" class="group bg-gradient-to-br from-orange-500 to-orange-600 hover:from-orange-600 hover:to-orange-700 rounded-2xl p-6 text-white shadow-lg hover:shadow-xl transition-all duration-300 hover:scale-105">
                <div class="w-14 h-14 bg-white bg-opacity-20 rounded-xl flex items-center justify-center mb-4 group-hover:scale-110 transition-transform">
                    <i class="bi bi-person text-3xl"></i>
                </div>
                <h4 class="font-bold text-base mb-1">Profil Saya</h4>
                <p class="text-xs text-orange-100">Kelola akun Anda</p>
            </a>
        </div>

        <!-- Statistics Section -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6 lg:mb-10">
            <!-- Total Setor -->
            <div class="bg-white rounded-2xl p-6 shadow-lg border border-gray-100 hover:shadow-xl transition-shadow">
                <div class="flex items-start justify-between mb-4">
                    <div class="w-12 h-12 bg-gradient-to-br from-green-500 to-green-600 rounded-xl flex items-center justify-center">
                        <i class="bi bi-arrow-up-circle-fill text-white text-2xl"></i>
                    </div>
                    <span class="text-xs bg-green-100 text-green-700 px-3 py-1 rounded-full font-semibold">Bulan Ini</span>
                </div>
                <h4 class="text-gray-500 text-sm font-medium mb-1">Total Setor</h4>
                <p id="stats-total-deposits" class="text-3xl font-bold text-gray-800 mb-1">-</p>
                <p class="text-xs text-gray-400">transaksi setor sampah</p>
            </div>

            <!-- Total Tukar -->
            <div class="bg-white rounded-2xl p-6 shadow-lg border border-gray-100 hover:shadow-xl transition-shadow">
                <div class="flex items-start justify-between mb-4">
                    <div class="w-12 h-12 bg-gradient-to-br from-blue-500 to-blue-600 rounded-xl flex items-center justify-center">
                        <i class="bi bi-arrow-down-circle-fill text-white text-2xl"></i>
                    </div>
                    <span class="text-xs bg-blue-100 text-blue-700 px-3 py-1 rounded-full font-semibold">Bulan Ini</span>
                </div>
                <h4 class="text-gray-500 text-sm font-medium mb-1">Total Tukar</h4>
                <p id="stats-total-redemptions" class="text-3xl font-bold text-gray-800 mb-1">-</p>
                <p class="text-xs text-gray-400">transaksi penukaran</p>
            </div>

            <!-- Poin Didapat -->
            <div class="bg-white rounded-2xl p-6 shadow-lg border border-gray-100 hover:shadow-xl transition-shadow">
                <div class="flex items-start justify-between mb-4">
                    <div class="w-12 h-12 bg-gradient-to-br from-yellow-500 to-orange-500 rounded-xl flex items-center justify-center">
                        <i class="bi bi-coin text-white text-2xl"></i>
                    </div>
                    <span class="text-xs bg-yellow-100 text-yellow-700 px-3 py-1 rounded-full font-semibold">Bulan Ini</span>
                </div>
                <h4 class="text-gray-500 text-sm font-medium mb-1">Poin Didapat</h4>
                <p id="stats-points-earned" class="text-3xl font-bold text-gray-800 mb-1">-</p>
                <p class="text-xs text-gray-400">dari setoran sampah</p>
            </div>
        </div>

        <!-- Member Tier Explanation -->
        <div class="bg-gradient-to-br from-indigo-50 to-purple-50 rounded-3xl p-6 lg:p-8 mb-6 lg:mb-10 border-2 border-indigo-200 shadow-lg">
            <div class="flex items-center justify-between mb-6">
                <div>
                    <h3 class="text-xl lg:text-2xl font-bold text-gray-800 mb-1.5 flex items-center gap-2">
                        <i class="bi bi-trophy-fill text-indigo-600"></i>
                        Sistem Tier Member
                    </h3>
                    <p class="text-sm text-gray-500">Kumpulkan poin dan naik ke tier lebih tinggi!</p>
                </div>
            </div>

            <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                <!-- Bronze -->
                <div class="bg-white rounded-2xl p-5 border-2 {{ $saldoPoin < 5000 ? 'border-orange-400 shadow-lg' : 'border-gray-200' }}">
                    <div class="w-14 h-14 mx-auto mb-3 bg-gradient-to-br from-orange-400 to-orange-600 rounded-full flex items-center justify-center shadow-md">
                        <i class="bi bi-trophy text-white text-2xl"></i>
                    </div>
                    <h5 class="font-bold text-gray-800 text-center mb-1">Bronze</h5>
                    <p class="text-xs text-gray-500 text-center mb-2">0 - 4,999 poin</p>
                    @if($saldoPoin < 5000)
                        <div class="text-center">
                            <span class="inline-block bg-orange-100 text-orange-700 text-xs font-bold px-3 py-1 rounded-full">
                                <i class="bi bi-check-circle-fill"></i> Anda di sini
                            </span>
                        </div>
                    @endif
                </div>

                <!-- Silver -->
                <div class="bg-white rounded-2xl p-5 border-2 {{ $saldoPoin >= 5000 && $saldoPoin < 10000 ? 'border-gray-400 shadow-lg' : 'border-gray-200' }}">
                    <div class="w-14 h-14 mx-auto mb-3 bg-gradient-to-br from-gray-300 to-gray-500 rounded-full flex items-center justify-center shadow-md">
                        <i class="bi bi-award-fill text-white text-2xl"></i>
                    </div>
                    <h5 class="font-bold text-gray-800 text-center mb-1">Silver</h5>
                    <p class="text-xs text-gray-500 text-center mb-2">5,000 - 9,999 poin</p>
                    @if($saldoPoin >= 5000 && $saldoPoin < 10000)
                        <div class="text-center">
                            <span class="inline-block bg-gray-200 text-gray-700 text-xs font-bold px-3 py-1 rounded-full">
                                <i class="bi bi-check-circle-fill"></i> Anda di sini
                            </span>
                        </div>
                    @endif
                </div>

                <!-- Gold -->
                <div class="bg-white rounded-2xl p-5 border-2 {{ $saldoPoin >= 10000 && $saldoPoin < 20000 ? 'border-yellow-400 shadow-lg' : 'border-gray-200' }}">
                    <div class="w-14 h-14 mx-auto mb-3 bg-gradient-to-br from-yellow-400 to-orange-500 rounded-full flex items-center justify-center shadow-md">
                        <i class="bi bi-star-fill text-white text-2xl"></i>
                    </div>
                    <h5 class="font-bold text-gray-800 text-center mb-1">Gold</h5>
                    <p class="text-xs text-gray-500 text-center mb-2">10,000 - 19,999 poin</p>
                    @if($saldoPoin >= 10000 && $saldoPoin < 20000)
                        <div class="text-center">
                            <span class="inline-block bg-yellow-100 text-yellow-700 text-xs font-bold px-3 py-1 rounded-full">
                                <i class="bi bi-check-circle-fill"></i> Anda di sini
                            </span>
                        </div>
                    @endif
                </div>

                <!-- Platinum -->
                <div class="bg-white rounded-2xl p-5 border-2 {{ $saldoPoin >= 20000 ? 'border-cyan-400 shadow-lg' : 'border-gray-200' }}">
                    <div class="w-14 h-14 mx-auto mb-3 bg-gradient-to-br from-cyan-400 to-blue-500 rounded-full flex items-center justify-center shadow-md">
                        <i class="bi bi-gem text-white text-2xl"></i>
                    </div>
                    <h5 class="font-bold text-gray-800 text-center mb-1">Platinum</h5>
                    <p class="text-xs text-gray-500 text-center mb-2">20,000+ poin</p>
                    @if($saldoPoin >= 20000)
                        <div class="text-center">
                            <span class="inline-block bg-cyan-100 text-cyan-700 text-xs font-bold px-3 py-1 rounded-full">
                                <i class="bi bi-check-circle-fill"></i> Anda di sini
                            </span>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Achievement Section -->
        <div class="bg-gradient-to-br from-yellow-50 via-orange-50 to-yellow-50 rounded-3xl p-6 lg:p-8 mb-6 lg:mb-10 border-2 border-yellow-200 shadow-lg">
            <div class="flex items-center justify-between mb-6">
                <div>
                    <h3 class="text-xl lg:text-2xl font-bold text-gray-800 mb-1.5 flex items-center gap-2">
                        <i class="bi bi-trophy-fill text-yellow-500"></i>
                        Badge Pencapaian
                    </h3>
                    <p class="text-sm text-gray-500">Kumpulkan badge dengan menyelesaikan misi!</p>
                </div>
            </div>

            <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                <!-- Badge 1: First Deposit -->
                <div class="bg-white rounded-2xl p-5 text-center shadow-md hover:shadow-lg transition-all hover:scale-105">
                    <div class="w-16 h-16 mx-auto mb-3 bg-gradient-to-br from-green-400 to-green-600 rounded-full flex items-center justify-center">
                        <i class="bi bi-check-circle-fill text-white text-3xl"></i>
                    </div>
                    <h5 class="font-bold text-gray-800 text-sm mb-1">Setor Pertama</h5>
                    <p class="text-xs text-gray-500">Setor sampah pertama kali</p>
                </div>

                <!-- Badge 2: 10 Deposits -->
                <div id="badge-10-deposits" class="bg-white rounded-2xl p-5 text-center shadow-md opacity-50">
                    <div class="w-16 h-16 mx-auto mb-3 bg-gradient-to-br from-blue-400 to-blue-600 rounded-full flex items-center justify-center">
                        <i class="bi bi-recycle text-white text-3xl"></i>
                    </div>
                    <h5 class="font-bold text-gray-800 text-sm mb-1">Eco Warrior</h5>
                    <p class="text-xs text-gray-500">10x setor sampah</p>
                </div>

                <!-- Badge 3: 1000 Points -->
                <div id="badge-1000-points" class="bg-white rounded-2xl p-5 text-center shadow-md opacity-50">
                    <div class="w-16 h-16 mx-auto mb-3 bg-gradient-to-br from-yellow-400 to-orange-500 rounded-full flex items-center justify-center">
                        <i class="bi bi-coin text-white text-3xl"></i>
                    </div>
                    <h5 class="font-bold text-gray-800 text-sm mb-1">Pengumpul Poin</h5>
                    <p class="text-xs text-gray-500">Kumpulkan 1000 poin</p>
                </div>

                <!-- Badge 4: Redemption -->
                <div id="badge-redemption" class="bg-white rounded-2xl p-5 text-center shadow-md opacity-50">
                    <div class="w-16 h-16 mx-auto mb-3 bg-gradient-to-br from-purple-400 to-purple-600 rounded-full flex items-center justify-center">
                        <i class="bi bi-gift-fill text-white text-3xl"></i>
                    </div>
                    <h5 class="font-bold text-gray-800 text-sm mb-1">Shopaholic</h5>
                    <p class="text-xs text-gray-500">Tukar poin pertama</p>
                </div>
            </div>
        </div>

        <!-- Tips Section -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-6 lg:mb-10">
            <!-- Tips Card -->
            <div class="bg-gradient-to-br from-teal-500 to-teal-600 rounded-3xl p-6 lg:p-8 text-white shadow-xl relative overflow-hidden">
                <div class="absolute top-0 right-0 w-32 h-32 bg-white opacity-10 rounded-full -mr-16 -mt-16"></div>
                <div class="relative z-10">
                    <div class="w-14 h-14 bg-white bg-opacity-20 rounded-2xl flex items-center justify-center mb-4">
                        <i class="bi bi-lightbulb-fill text-3xl"></i>
                    </div>
                    <h3 class="text-xl font-bold mb-3">Tips Hari Ini 💡</h3>
                    <p class="text-teal-50 text-sm leading-relaxed mb-4">
                        Pisahkan sampah organik dan anorganik di rumah untuk mempermudah proses daur ulang. 
                        Sampah yang bersih dan terpisah memiliki nilai jual lebih tinggi!
                    </p>
                    <div class="flex items-center gap-2 text-teal-100 text-xs">
                        <i class="bi bi-info-circle"></i>
                        <span>Tips dari Tim Green Saving</span>
                    </div>
                </div>
            </div>

            <!-- Promo/Info Card -->
            <div class="bg-gradient-to-br from-pink-500 to-rose-600 rounded-3xl p-6 lg:p-8 text-white shadow-xl relative overflow-hidden">
                <div class="absolute bottom-0 left-0 w-32 h-32 bg-white opacity-10 rounded-full -ml-16 -mb-16"></div>
                <div class="relative z-10">
                    <div class="w-14 h-14 bg-white bg-opacity-20 rounded-2xl flex items-center justify-center mb-4">
                        <i class="bi bi-megaphone-fill text-3xl"></i>
                    </div>
                    <h3 class="text-xl font-bold mb-3">Promo Special! 🎉</h3>
                    <p class="text-pink-50 text-sm leading-relaxed mb-4">
                        Dapatkan <span class="font-bold text-white">bonus 50 poin</span> untuk setiap setoran minimal 5kg sampah plastik! 
                        Promo berlaku hingga akhir bulan.
                    </p>
                    <a href="/tukar-poin" class="inline-flex items-center gap-2 bg-white text-pink-600 px-4 py-2 rounded-xl text-sm font-bold hover:bg-pink-50 transition-all">
                        <span>Lihat Reward</span>
                        <i class="bi bi-arrow-right"></i>
                    </a>
                </div>
            </div>
        </div>

        <!-- Aktivitas Section -->
        <div class="bg-white rounded-3xl p-6 lg:p-8 mb-6 shadow-lg border border-gray-100">
            <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 mb-8">
                <div>
                    <h3 class="text-xl lg:text-2xl font-bold text-gray-800 mb-1.5">Aktivitas Terbaru</h3>
                    <p class="text-sm text-gray-500 flex items-center gap-1.5">
                        <i class="bi bi-clock-history"></i>
                        Transaksi dan setoran terbaru Anda
                    </p>
                </div>
                <a href="/riwayat" class="inline-flex items-center gap-2 bg-green-50 hover:bg-green-100 text-green-600 px-5 py-2.5 rounded-xl text-sm font-semibold transition-all duration-200 border border-green-200 hover:shadow-md">
                    <span>Lihat Semua</span>
                    <i class="bi bi-arrow-right"></i>
                </a>
            </div>

            <!-- Activity Items -->
            <div id="activity-container" class="space-y-4">
                <!-- Loading State -->
                <div class="flex items-center justify-center py-8">
                    <div class="animate-spin rounded-full h-12 w-12 border-b-2 border-green-500"></div>
                </div>
            </div>
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

    <!-- Modal Detail -->
    <div id="detail-modal" class="hidden fixed inset-0 bg-black bg-opacity-50 z-50 flex items-center justify-center p-4">
        <div class="bg-white rounded-2xl max-w-2xl w-full max-h-[90vh] overflow-y-auto shadow-2xl">
            <div class="p-6">
                <!-- Modal Header -->
                <div class="flex justify-between items-start mb-6">
                    <div>
                        <h3 id="modal-title" class="text-2xl font-bold text-gray-800">Detail Transaksi</h3>
                        <p id="modal-date" class="text-sm text-gray-500 mt-1"></p>
                    </div>
                    <button onclick="closeModal()" class="text-gray-400 hover:text-gray-600 transition-colors">
                        <i class="bi bi-x-lg text-2xl"></i>
                    </button>
                </div>

                <!-- Modal Content -->
                <div id="modal-content" class="space-y-4">
                    <!-- Content will be loaded here -->
                </div>
            </div>
        </div>
    </div>

    <script>
        let dashboardData = null;
        let activities = [];

        // Fetch dashboard data
        async function fetchDashboardData() {
            try {
                const response = await fetch('/api/dashboard', {
                    headers: {
                        'Accept': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                    }
                });

                if (!response.ok) throw new Error('Failed to fetch');

                dashboardData = await response.json();
                updateDashboard();
                await fetchActivities();
            } catch (error) {
                console.error('Error fetching dashboard data:', error);
            }
        }

        // Update dashboard UI
        function updateDashboard() {
            if (!dashboardData) return;

            // Update balance points
            const balancePoints = dashboardData.balance_points || 0;
            document.getElementById('balance-points').textContent = `${balancePoints.toLocaleString('id-ID')} poin`;
            document.getElementById('balance-points-large').textContent = balancePoints.toLocaleString('id-ID');

            // Update user info if available
            if (dashboardData.user_name) {
                document.getElementById('user-name').textContent = dashboardData.user_name;
            }

            if (dashboardData.member_since) {
                document.getElementById('member-since').textContent = `Member sejak ${dashboardData.member_since}`;
            }
        }

        // Fetch recent activities (deposits + redemptions)
        async function fetchActivities() {
            try {
                // Fetch both deposits and redemptions
                const [depositsRes, redemptionsRes] = await Promise.all([
                    fetch('/api/deposits'),
                    fetch('/api/redemptions')
                ]);

                const deposits = await depositsRes.json();
                const redemptions = await redemptionsRes.json();

                // Calculate statistics for current month
                calculateStatistics(deposits, redemptions);
                
                // Update badges based on achievements
                updateBadges(deposits, redemptions);

                // Combine and sort by date
                activities = [
                    ...deposits.map(d => ({ ...d, type: 'deposit' })),
                    ...redemptions.map(r => ({ ...r, type: 'redemption' }))
                ].sort((a, b) => new Date(b.created_at) - new Date(a.created_at))
                 .slice(0, 5); // Take only 5 most recent

                renderActivities();
            } catch (error) {
                console.error('Error fetching activities:', error);
                document.getElementById('activity-container').innerHTML = `
                    <div class="text-center py-8 text-gray-500">
                        <i class="bi bi-exclamation-circle text-4xl mb-2"></i>
                        <p>Gagal memuat aktivitas</p>
                    </div>
                `;
            }
        }

        // Calculate statistics for current month
        function calculateStatistics(deposits, redemptions) {
            const now = new Date();
            const currentMonth = now.getMonth();
            const currentYear = now.getFullYear();

            // Filter this month's transactions
            const thisMonthDeposits = deposits.filter(d => {
                const date = new Date(d.created_at);
                return date.getMonth() === currentMonth && date.getFullYear() === currentYear;
            });

            const thisMonthRedemptions = redemptions.filter(r => {
                const date = new Date(r.created_at);
                return date.getMonth() === currentMonth && date.getFullYear() === currentYear;
            });

            // Calculate totals
            const totalDeposits = thisMonthDeposits.length;
            const totalRedemptions = thisMonthRedemptions.length;
            const pointsEarned = thisMonthDeposits.reduce((sum, d) => sum + (d.total_points || 0), 0);

            // Update UI
            document.getElementById('stats-total-deposits').textContent = totalDeposits;
            document.getElementById('stats-total-redemptions').textContent = totalRedemptions;
            document.getElementById('stats-points-earned').textContent = pointsEarned.toLocaleString('id-ID');
        }

        // Update achievement badges
        function updateBadges(deposits, redemptions) {
            // Badge: 10+ deposits (Eco Warrior)
            if (deposits.length >= 10) {
                const badge = document.getElementById('badge-10-deposits');
                if (badge) {
                    badge.classList.remove('opacity-50');
                    badge.classList.add('hover:shadow-lg', 'hover:scale-105', 'transition-all');
                }
            }

            // Badge: 1000+ total points (Pengumpul Poin)
            const totalPoints = deposits.reduce((sum, d) => sum + (d.total_points || 0), 0);
            if (totalPoints >= 1000) {
                const badge = document.getElementById('badge-1000-points');
                if (badge) {
                    badge.classList.remove('opacity-50');
                    badge.classList.add('hover:shadow-lg', 'hover:scale-105', 'transition-all');
                }
            }

            // Badge: First redemption (Shopaholic)
            if (redemptions.length > 0) {
                const badge = document.getElementById('badge-redemption');
                if (badge) {
                    badge.classList.remove('opacity-50');
                    badge.classList.add('hover:shadow-lg', 'hover:scale-105', 'transition-all');
                }
            }
        }

        // Render activities
        function renderActivities() {
            const container = document.getElementById('activity-container');

            if (activities.length === 0) {
                container.innerHTML = `
                    <div class="text-center py-8 text-gray-500">
                        <i class="bi bi-inbox text-4xl mb-2"></i>
                        <p>Belum ada aktivitas</p>
                    </div>
                `;
                return;
            }

            container.innerHTML = activities.map(activity => {
                const isDeposit = activity.type === 'deposit';
                const date = new Date(activity.created_at).toLocaleDateString('id-ID', {
                    year: 'numeric',
                    month: 'short',
                    day: 'numeric'
                });

                const statusConfig = {
                    pending: { bg: 'bg-yellow-200', text: 'text-yellow-800', label: 'Menunggu' },
                    verified: { bg: 'bg-green-200', text: 'text-green-800', label: 'Selesai' },
                    confirmed: { bg: 'bg-blue-200', text: 'text-blue-800', label: 'Siap Ambil' },
                    completed: { bg: 'bg-green-200', text: 'text-green-800', label: 'Selesai' },
                    approved: { bg: 'bg-green-200', text: 'text-green-800', label: 'Selesai' },
                    rejected: { bg: 'bg-red-200', text: 'text-red-800', label: 'Ditolak' },
                    cancelled: { bg: 'bg-gray-200', text: 'text-gray-800', label: 'Dibatalkan' }
                };

                const status = statusConfig[activity.status] || statusConfig.pending;

                if (isDeposit) {
                    const totalWeight = activity.items?.reduce((sum, item) => sum + parseFloat(item.weight || 0), 0) || 0;
                    const totalPoints = activity.total_points || 0;

                    return `
                        <div onclick="showDetail('deposit', ${activity.id})" 
                             class="flex items-center justify-between p-4 bg-gradient-to-r from-green-50 to-green-100 rounded-xl border-l-4 border-green-500 cursor-pointer hover:shadow-md transition-shadow">
                            <div class="flex items-center space-x-4">
                                <div class="w-12 h-12 bg-green-500 rounded-xl flex items-center justify-center shadow-sm">
                                    <i class="bi bi-arrow-up text-white text-xl"></i>
                                </div>
                                <div>
                                    <div class="flex items-center space-x-2 mb-1">
                                        <span class="font-semibold text-gray-800">Setor Sampah</span>
                                    </div>
                                    <div class="flex items-center space-x-4 text-sm text-gray-500">
                                        <span>${date}</span>
                                        <span class="flex items-center space-x-1">
                                            <i class="bi bi-box text-gray-500"></i>
                                            <span>${totalWeight.toFixed(1)} kg</span>
                                        </span>
                                        <span class="${status.bg} ${status.text} px-3 py-1 rounded-full text-xs font-semibold">${status.label}</span>
                                    </div>
                                </div>
                            </div>
                            <div class="text-right">
                                <div class="font-bold text-green-600 text-lg">+ ${totalPoints.toLocaleString('id-ID')} <i class="bi bi-currency-dollar"></i></div>
                            </div>
                        </div>
                    `;
                } else {
                    const totalPoints = activity.total_points || 0;
                    // Hanya tampilkan minus poin jika sudah dikonfirmasi/selesai
                    const showDeduction = ['confirmed', 'completed'].includes(activity.status);
                    const pointsDisplay = showDeduction 
                        ? `- ${totalPoints.toLocaleString('id-ID')}` 
                        : `${totalPoints.toLocaleString('id-ID')}`;
                    const pointsColor = showDeduction ? 'text-blue-600' : 'text-gray-500';

                    return `
                        <div onclick="showDetail('redemption', ${activity.id})" 
                             class="flex items-center justify-between p-4 bg-gradient-to-r from-blue-50 to-blue-100 rounded-xl border-l-4 border-blue-500 cursor-pointer hover:shadow-md transition-shadow">
                            <div class="flex items-center space-x-4">
                                <div class="w-12 h-12 bg-blue-500 rounded-xl flex items-center justify-center shadow-sm">
                                    <i class="bi bi-arrow-down text-white text-xl"></i>
                                </div>
                                <div>
                                    <div class="flex items-center space-x-2 mb-1">
                                        <span class="font-semibold text-gray-800">Tukar Poin</span>
                                    </div>
                                    <div class="flex items-center space-x-4 text-sm text-gray-500">
                                        <span>${date}</span>
                                        <span class="${status.bg} ${status.text} px-3 py-1 rounded-full text-xs font-semibold">${status.label}</span>
                                    </div>
                                </div>
                            </div>
                            <div class="text-right">
                                <div class="font-bold ${pointsColor} text-lg">${pointsDisplay} <i class="bi bi-currency-dollar"></i></div>
                            </div>
                        </div>
                    `;
                }
            }).join('');
        }

        // Show detail modal
        async function showDetail(type, id) {
            const modal = document.getElementById('detail-modal');
            const modalContent = document.getElementById('modal-content');
            
            modal.classList.remove('hidden');
            modalContent.innerHTML = `
                <div class="flex justify-center py-8">
                    <div class="animate-spin rounded-full h-12 w-12 border-b-2 border-green-500"></div>
                </div>
            `;

            try {
                const endpoint = type === 'deposit' ? `/api/deposits/${id}` : `/api/redemptions/${id}`;
                const response = await fetch(endpoint);
                const data = await response.json();

                const date = new Date(data.created_at).toLocaleDateString('id-ID', {
                    weekday: 'long',
                    year: 'numeric',
                    month: 'long',
                    day: 'numeric',
                    hour: '2-digit',
                    minute: '2-digit'
                });

                document.getElementById('modal-date').textContent = date;

                if (type === 'deposit') {
                    renderDepositDetail(data);
                } else {
                    renderRedemptionDetail(data);
                }
            } catch (error) {
                console.error('Error fetching detail:', error);
                modalContent.innerHTML = `
                    <div class="text-center py-8 text-red-500">
                        <i class="bi bi-exclamation-circle text-4xl mb-2"></i>
                        <p>Gagal memuat detail</p>
                    </div>
                `;
            }
        }

        // Render deposit detail
        function renderDepositDetail(data) {
            document.getElementById('modal-title').textContent = 'Detail Setoran Sampah';
            
            const statusConfig = {
                pending: { bg: 'bg-yellow-100', border: 'border-yellow-500', text: 'text-yellow-800', label: 'Menunggu Konfirmasi' },
                verified: { bg: 'bg-green-100', border: 'border-green-500', text: 'text-green-800', label: 'Selesai' },
                confirmed: { bg: 'bg-blue-100', border: 'border-blue-500', text: 'text-blue-800', label: 'Siap Ambil' },
                completed: { bg: 'bg-green-100', border: 'border-green-500', text: 'text-green-800', label: 'Selesai' }
            };

            const status = statusConfig[data.status] || statusConfig.pending;

            const content = `
                <div class="${status.bg} ${status.border} border-l-4 p-4 rounded-lg mb-4">
                    <div class="flex items-center space-x-2">
                        <i class="bi bi-info-circle ${status.text}"></i>
                        <span class="${status.text} font-semibold">Status: ${status.label}</span>
                    </div>
                </div>

                <div class="grid grid-cols-2 gap-4 mb-6">
                    <div class="bg-gray-50 p-4 rounded-xl">
                        <p class="text-sm text-gray-500 mb-1">Total Berat</p>
                        <p class="text-xl font-bold text-gray-800">${data.items.reduce((sum, item) => sum + parseFloat(item.weight), 0).toFixed(2)} kg</p>
                    </div>
                    <div class="bg-green-50 p-4 rounded-xl">
                        <p class="text-sm text-gray-500 mb-1">Total Poin</p>
                        <p class="text-xl font-bold text-green-600">${(data.total_points || 0).toLocaleString('id-ID')}</p>
                    </div>
                </div>

                ${data.branch ? `
                    <div class="mb-6">
                        <h4 class="font-semibold text-gray-700 mb-2">Cabang</h4>
                        <div class="bg-gray-50 p-3 rounded-lg">
                            <i class="bi bi-geo-alt text-gray-500"></i>
                            <span class="text-gray-800">${data.branch.name}</span>
                        </div>
                    </div>
                ` : ''}

                <div>
                    <h4 class="font-semibold text-gray-700 mb-3">Detail Item</h4>
                    <div class="space-y-3">
                        ${data.items.map(item => `
                            <div class="flex items-center justify-between bg-gray-50 p-4 rounded-xl">
                                <div class="flex items-center space-x-3">
                                    <div class="w-10 h-10 bg-green-100 rounded-lg flex items-center justify-center">
                                        <i class="bi bi-recycle text-green-600"></i>
                                    </div>
                                    <div>
                                        <p class="font-semibold text-gray-800">${item.waste_type?.name || 'Sampah'}</p>
                                        <p class="text-sm text-gray-500">${item.weight} kg × ${item.points_per_kg || 0} poin/kg</p>
                                    </div>
                                </div>
                                <div class="text-right">
                                    <p class="font-bold text-green-600">+${(item.points || 0).toLocaleString('id-ID')}</p>
                                    <p class="text-xs text-gray-500">poin</p>
                                </div>
                            </div>
                        `).join('')}
                    </div>
                </div>

                ${data.notes ? `
                    <div class="mt-4 bg-blue-50 p-4 rounded-lg">
                        <p class="text-sm font-semibold text-blue-800 mb-1">Catatan:</p>
                        <p class="text-sm text-blue-700">${data.notes}</p>
                    </div>
                ` : ''}
            `;

            document.getElementById('modal-content').innerHTML = content;
        }

        // Render redemption detail
        function renderRedemptionDetail(data) {
            document.getElementById('modal-title').textContent = 'Detail Penukaran Poin';
            
            const statusConfig = {
                pending: { bg: 'bg-yellow-100', border: 'border-yellow-500', text: 'text-yellow-800', label: 'Menunggu Persetujuan' },
                confirmed: { bg: 'bg-blue-100', border: 'border-blue-500', text: 'text-blue-800', label: 'Siap Ambil' },
                completed: { bg: 'bg-green-100', border: 'border-green-500', text: 'text-green-800', label: 'Selesai' },
                approved: { bg: 'bg-green-100', border: 'border-green-500', text: 'text-green-800', label: 'Disetujui' },
                rejected: { bg: 'bg-red-100', border: 'border-red-500', text: 'text-red-800', label: 'Ditolak' },
                cancelled: { bg: 'bg-gray-100', border: 'border-gray-500', text: 'text-gray-800', label: 'Dibatalkan' }
            };

            const status = statusConfig[data.status] || statusConfig.pending;

            const expiresAt = data.expires_at ? new Date(data.expires_at) : null;
            const now = new Date();
            const isExpiringSoon = expiresAt && (expiresAt - now) < 24 * 60 * 60 * 1000 && data.status === 'pending';

            const content = `
                <div class="${status.bg} ${status.border} border-l-4 p-4 rounded-lg mb-4">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center space-x-2">
                            <i class="bi bi-info-circle ${status.text}"></i>
                            <span class="${status.text} font-semibold">Status: ${status.label}</span>
                        </div>
                        ${isExpiringSoon ? `
                            <span class="text-xs bg-orange-200 text-orange-800 px-2 py-1 rounded-full">
                                <i class="bi bi-clock"></i> Kadaluarsa ${expiresAt.toLocaleString('id-ID')}
                            </span>
                        ` : ''}
                    </div>
                </div>

                ${data.rejection_reason ? `
                    <div class="bg-red-50 border-l-4 border-red-500 p-4 rounded-lg mb-4">
                        <p class="text-sm font-semibold text-red-800 mb-1">Alasan Penolakan:</p>
                        <p class="text-sm text-red-700">${data.rejection_reason}</p>
                    </div>
                ` : ''}

                <div class="bg-blue-50 p-4 rounded-xl mb-6">
                    <p class="text-sm text-gray-500 mb-1">Total Poin Digunakan</p>
                    <p class="text-2xl font-bold text-blue-600">${(data.total_points || 0).toLocaleString('id-ID')} poin</p>
                </div>

                <div>
                    <h4 class="font-semibold text-gray-700 mb-3">Item yang Ditukar</h4>
                    <div class="space-y-3">
                        ${data.items?.map(item => `
                            <div class="flex items-center justify-between bg-gray-50 p-4 rounded-xl">
                                <div class="flex items-center space-x-3">
                                    <div class="w-10 h-10 bg-blue-100 rounded-lg flex items-center justify-center">
                                        <i class="bi bi-gift text-blue-600"></i>
                                    </div>
                                    <div>
                                        <p class="font-semibold text-gray-800">${item.reward_item?.name || 'Reward'}</p>
                                        <p class="text-sm text-gray-500">${item.quantity} item × ${(item.points || 0).toLocaleString('id-ID')} poin</p>
                                    </div>
                                </div>
                                <div class="text-right">
                                    <p class="font-bold text-blue-600">${((item.quantity * item.points) || 0).toLocaleString('id-ID')}</p>
                                    <p class="text-xs text-gray-500">poin</p>
                                </div>
                            </div>
                        `).join('') || '<p class="text-gray-500 text-center py-4">Tidak ada item</p>'}
                    </div>
                </div>
            `;

            document.getElementById('modal-content').innerHTML = content;
        }

        // Close modal
        function closeModal() {
            document.getElementById('detail-modal').classList.add('hidden');
        }

        // Close modal when clicking outside
        document.getElementById('detail-modal').addEventListener('click', function(e) {
            if (e.target === this) {
                closeModal();
            }
        });

        // Initial load
        document.addEventListener('DOMContentLoaded', function() {
            fetchDashboardData();
            
            // Auto refresh every 30 seconds
            setInterval(fetchDashboardData, 30000);
        });
    </script>

</body>
</html>