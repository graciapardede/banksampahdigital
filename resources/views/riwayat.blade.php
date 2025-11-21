<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Riwayat Transaksi - Green Saving</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css" rel="stylesheet">
    <meta name="csrf-token" content="{{ csrf_token() }}">
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
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-5">
            <div class="flex justify-between items-center">
                <!-- Logo -->
                <div class="flex items-center space-x-3">
                    <div class="w-11 h-11 lg:w-12 lg:h-12 bg-gradient-to-br from-green-500 to-green-600 rounded-xl flex items-center justify-center shadow-lg hover:scale-105 transition-transform">
                        <i class="bi bi-recycle text-white text-xl lg:text-2xl"></i>
                    </div>
                    <div>
                        <h1 class="font-bold text-lg lg:text-xl text-gray-800">Green Saving</h1>
                        <p class="text-xs lg:text-sm text-green-600 hidden sm:block">Halo, {{ Auth::user()->full_name ?? Auth::user()->name ?? 'Warga' }}</p>
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
                            <span class="font-bold text-green-700 text-base">{{ number_format($userBalance ?? 0, 0, ',', '.') }}</span>
                        </div>
                    </div>

                    <!-- Cart Button with Badge -->
                    <a href="{{ route('cart.index') }}" class="relative w-11 h-11 bg-gradient-to-br from-green-500 to-green-600 rounded-xl flex items-center justify-center shadow-lg hover:shadow-xl hover:scale-105 transition-all">
                        <i class="bi bi-cart3 text-white text-lg lg:text-xl"></i>
                        @if(session('cart') && count(session('cart')) > 0)
                            <span class="absolute -top-1.5 -right-1.5 bg-gradient-to-br from-red-500 to-red-600 text-white text-xs font-bold rounded-full w-5 h-5 lg:w-6 lg:h-6 flex items-center justify-center ring-2 ring-white shadow-md">
                                {{ count(session('cart')) }}
                            </span>
                        @endif
                    </a>

                    <!-- Notification Bell with Dropdown -->
                    <div class="relative" x-data="{ open: false }" @click.away="open = false">
                        <button @click="open = !open" class="relative w-12 h-12 bg-gray-100 hover:bg-gray-200 rounded-xl flex items-center justify-center transition-all">
                            <i class="bi bi-bell text-gray-700 text-xl"></i>
                            @if(isset($unreadNotifications) && $unreadNotifications > 0)
                            <span class="absolute -top-2 -right-2 bg-red-500 text-white text-xs font-bold rounded-full w-6 h-6 flex items-center justify-center animate-pulse">
                                {{ $unreadNotifications > 9 ? '9+' : $unreadNotifications }}
                            </span>
                            @endif
                        </button>

                        <div x-show="open" 
                             x-transition:enter="transition ease-out duration-200"
                             x-transition:enter-start="opacity-0 transform scale-95"
                             x-transition:enter-end="opacity-100 transform scale-100"
                             x-transition:leave="transition ease-in duration-150"
                             x-transition:leave-start="opacity-100 transform scale-100"
                             x-transition:leave-end="opacity-0 transform scale-95"
                             class="absolute right-0 mt-2 w-80 bg-white rounded-2xl shadow-2xl border-2 border-gray-100 overflow-hidden z-50"
                             style="display: none;">
                            
                            <div class="bg-gradient-to-r from-green-500 to-emerald-600 px-4 py-3">
                                <h3 class="text-white font-bold text-sm flex items-center gap-2">
                                    <i class="bi bi-bell-fill"></i>
                                    Notifikasi Terbaru
                                </h3>
                            </div>

                            <div class="max-h-96 overflow-y-auto">
                                @php
                                    $notifications = Auth::user()->notifications->take(5);
                                @endphp

                                @forelse($notifications as $notification)
                                    <a href="{{ route('notifikasi.read', $notification->id) }}" 
                                       class="block px-4 py-3 hover:bg-gray-50 transition-colors border-b border-gray-100 {{ $notification->read_at ? 'bg-white' : 'bg-blue-50' }}">
                                        <div class="flex items-start gap-3">
                                            <div class="flex-shrink-0 w-10 h-10 rounded-full flex items-center justify-center bg-green-100">
                                                <i class="bi bi-bell-fill text-green-600"></i>
                                            </div>

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
                    <a href="/profil" class="relative w-11 h-11 rounded-xl overflow-hidden border-2 border-green-500 hover:border-green-600 transition-all hover:scale-105 shadow-lg group">
                        @if(Auth::user()->profile_photo)
                            <img src="{{ asset('storage/profile_photos/' . Auth::user()->profile_photo) }}" alt="Profile" class="w-full h-full object-cover">
                        @else
                            <div class="w-full h-full bg-green-500 group-hover:bg-green-600 flex items-center justify-center transition-colors">
                                <i class="bi bi-person-fill text-white text-lg lg:text-xl"></i>
                            </div>
                        @endif
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
        <div class="bg-gradient-to-r from-green-100 via-green-50 to-emerald-100 px-4 py-4">
            <div class="max-w-7xl mx-auto">
                <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-6 gap-2 lg:gap-3">
                    <a href="/dashboard" class="bg-white text-gray-700 px-3 lg:px-6 py-3 rounded-2xl text-xs lg:text-sm font-semibold hover:bg-green-50 transition-all shadow-sm flex items-center justify-center space-x-2">
                        <i class="bi bi-house-door"></i>
                        <span class="truncate hidden sm:inline">Dashboard</span>
                    </a>
                    <a href="/profil" class="bg-white text-gray-700 px-3 lg:px-6 py-3 rounded-2xl text-xs lg:text-sm font-semibold hover:bg-green-50 transition-all shadow-sm flex items-center justify-center space-x-2">
                        <i class="bi bi-person"></i>
                        <span class="truncate hidden sm:inline">Profil</span>
                    </a>
                    <a href="/setor" class="bg-white text-gray-700 px-3 lg:px-6 py-3 rounded-2xl text-xs lg:text-sm font-semibold hover:bg-green-50 transition-all shadow-sm flex items-center justify-center space-x-2">
                        <i class="bi bi-recycle"></i>
                        <span class="truncate hidden sm:inline">Setor</span>
                    </a>
                    <a href="/tukar-poin" class="bg-white text-gray-700 px-3 lg:px-6 py-3 rounded-2xl text-xs lg:text-sm font-semibold hover:bg-green-50 transition-all shadow-sm flex items-center justify-center space-x-2">
                        <i class="bi bi-gift"></i>
                        <span class="truncate hidden sm:inline">Tukar Poin</span>
                    </a>
                    <a href="/riwayat" class="bg-gradient-to-r from-green-500 to-green-600 text-white px-3 lg:px-6 py-3 rounded-2xl text-xs lg:text-sm font-bold shadow-lg flex items-center justify-center space-x-2">
                        <i class="bi bi-clock-history"></i>
                        <span class="truncate hidden sm:inline">Riwayat</span>
                    </a>
                    <a href="/notifikasi" class="relative bg-white text-gray-700 px-4 lg:px-6 py-3 rounded-2xl text-xs lg:text-sm font-semibold hover:bg-green-50 transition-colors shadow-sm flex items-center justify-center space-x-2">
                        <i class="bi bi-bell"></i>
                        <span class="truncate">Notifikasi</span>
                        @if(isset($unreadNotifications) && $unreadNotifications > 0)
                        <span class="absolute -top-1 -right-1 bg-red-500 text-white text-xs font-bold rounded-full w-5 h-5 flex items-center justify-center">
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
        
        <!-- Flash Messages -->
        @if(session('success'))
            <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 5000)"
                 class="bg-gradient-to-r from-green-500 to-emerald-600 text-white px-6 py-4 rounded-2xl shadow-lg flex items-center justify-between mb-6">
                <div class="flex items-center gap-3">
                    <i class="bi bi-check-circle-fill text-2xl"></i>
                    <span class="font-semibold">{{ session('success') }}</span>
                </div>
                <button @click="show = false" class="text-white hover:bg-white hover:bg-opacity-20 rounded-lg p-2 transition-colors">
                    <i class="bi bi-x-lg"></i>
                </button>
            </div>
        @endif

        @if(session('error'))
            <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 5000)"
                 class="bg-gradient-to-r from-red-500 to-red-600 text-white px-6 py-4 rounded-2xl shadow-lg flex items-center justify-between mb-6">
                <div class="flex items-center gap-3">
                    <i class="bi bi-exclamation-circle-fill text-2xl"></i>
                    <span class="font-semibold">{{ session('error') }}</span>
                </div>
                <button @click="show = false" class="text-white hover:bg-white hover:bg-opacity-20 rounded-lg p-2 transition-colors">
                    <i class="bi bi-x-lg"></i>
                </button>
            </div>
        @endif

        @if(session('info'))
            <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 5000)"
                 class="bg-gradient-to-r from-blue-500 to-blue-600 text-white px-6 py-4 rounded-2xl shadow-lg flex items-center justify-between mb-6">
                <div class="flex items-center gap-3">
                    <i class="bi bi-info-circle-fill text-2xl"></i>
                    <span class="font-semibold">{{ session('info') }}</span>
                </div>
                <button @click="show = false" class="text-white hover:bg-white hover:bg-opacity-20 rounded-lg p-2 transition-colors">
                    <i class="bi bi-x-lg"></i>
                </button>
            </div>
        @endif

        <!-- Page Title -->
        <div class="mb-6 lg:mb-8">
            <div class="flex items-center gap-3 mb-3">
                <div class="w-12 h-12 bg-gradient-to-br from-green-100 to-green-50 rounded-2xl flex items-center justify-center border-2 border-green-200">
                    <i class="bi bi-clock-history text-green-600 text-2xl"></i>
                </div>
                <div>
                    <h2 class="text-2xl lg:text-3xl font-bold text-gray-800">Riwayat Transaksi</h2>
                    <p class="text-sm lg:text-base text-gray-600">Semua aktivitas setoran dan penukaran Anda</p>
                </div>
            </div>
        </div>

        <!-- Filter Section -->
        <div class="bg-white rounded-3xl p-6 lg:p-8 shadow-lg border border-gray-100 mb-6">
            <div class="flex items-center gap-3 mb-6">
                <div class="w-10 h-10 bg-gradient-to-br from-blue-100 to-blue-50 rounded-xl flex items-center justify-center border border-blue-200">
                    <i class="bi bi-funnel text-blue-600 text-lg"></i>
                </div>
                <h3 class="text-lg font-bold text-gray-800">Filter Transaksi</h3>
            </div>
            <form method="GET" action="{{ route('riwayat') }}">
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4 lg:gap-5">
                    <!-- Filter by Type -->
                    <div>
                        <label class="block text-sm font-bold text-gray-700 mb-2.5 flex items-center gap-2">
                            <i class="bi bi-tag text-gray-500"></i>
                            Jenis Transaksi
                        </label>
                        <select name="type" class="w-full px-4 py-3 bg-gradient-to-r from-gray-50 to-white border-2 border-gray-200 rounded-xl focus:border-green-400 focus:ring-2 focus:ring-green-200 focus:outline-none transition-all">
                            <option value="">Semua</option>
                            <option value="deposit" {{ request('type') === 'deposit' ? 'selected' : '' }}>Setoran</option>
                            <option value="redemption" {{ request('type') === 'redemption' ? 'selected' : '' }}>Penukaran</option>
                        </select>
                    </div>

                    <!-- Filter by Status -->
                    <div>
                        <label class="block text-sm font-bold text-gray-700 mb-2.5 flex items-center gap-2">
                            <i class="bi bi-check-circle text-gray-500"></i>
                            Status
                        </label>
                        <select name="status" class="w-full px-4 py-3 bg-gradient-to-r from-gray-50 to-white border-2 border-gray-200 rounded-xl focus:border-green-400 focus:ring-2 focus:ring-green-200 focus:outline-none transition-all">
                            <option value="">Semua Status</option>
                            <option value="pending" {{ request('status') === 'pending' ? 'selected' : '' }}>Pending</option>
                            <option value="confirmed" {{ request('status') === 'confirmed' ? 'selected' : '' }}>Selesai</option>
                            <option value="approved" {{ request('status') === 'approved' ? 'selected' : '' }}>Disetujui</option>
                            <option value="rejected" {{ request('status') === 'rejected' ? 'selected' : '' }}>Ditolak</option>
                            <option value="cancelled" {{ request('status') === 'cancelled' ? 'selected' : '' }}>Dibatalkan</option>
                        </select>
                    </div>

                    <!-- Filter by Date Range -->
                    <div>
                        <label class="block text-sm font-bold text-gray-700 mb-2.5 flex items-center gap-2">
                            <i class="bi bi-calendar3 text-gray-500"></i>
                            Bulan
                        </label>
                        <input type="month" name="month" value="{{ request('month') }}" class="w-full px-4 py-3 bg-gradient-to-r from-gray-50 to-white border-2 border-gray-200 rounded-xl focus:border-green-400 focus:ring-2 focus:ring-green-200 focus:outline-none transition-all">
                    </div>
                </div>

                <div class="mt-6 flex flex-col sm:flex-row justify-end gap-3">
                    <a href="{{ route('riwayat') }}" class="px-6 py-3 bg-gray-100 hover:bg-gray-200 text-gray-700 rounded-xl font-bold transition-all shadow-sm hover:shadow-md flex items-center justify-center gap-2">
                        <i class="bi bi-arrow-counterclockwise"></i>
                        Reset
                    </a>
                    <button type="submit" class="px-6 py-3 bg-gradient-to-r from-green-500 to-green-600 hover:from-green-600 hover:to-green-700 text-white rounded-xl font-bold transition-all shadow-md hover:shadow-lg flex items-center justify-center gap-2">
                        <i class="bi bi-search"></i>
                        Terapkan Filter
                    </button>
                </div>
            </form>
        </div>

        <!-- Empty State or Transaction List -->
        @if($transactions->isEmpty())
            <!-- Empty State -->
            <div class="flex flex-col items-center justify-center py-16 min-h-[400px]">
                <div class="w-32 h-32 bg-gray-100 rounded-full flex items-center justify-center mb-6">
                    <i class="bi bi-inbox text-gray-300 text-6xl"></i>
                </div>
                <h3 class="text-xl font-bold text-gray-700 mb-2">Belum ada riwayat transaksi</h3>
                <p class="text-gray-500 text-center max-w-md mb-6">
                    Transaksi setoran dan penukaran poin Anda akan muncul di sini
                </p>
                <div class="flex space-x-3">
                    <a href="/setor" class="px-6 py-3 bg-green-500 hover:bg-green-600 text-white rounded-xl font-semibold transition-colors flex items-center space-x-2">
                        <i class="bi bi-recycle"></i>
                        <span>Setor Sampah</span>
                    </a>
                    <a href="/tukar-poin" class="px-6 py-3 bg-blue-500 hover:bg-blue-600 text-white rounded-xl font-semibold transition-colors flex items-center space-x-2">
                        <i class="bi bi-gift"></i>
                        <span>Tukar Poin</span>
                    </a>
                </div>
            </div>
        @else
            <!-- Transaction List -->
            <div class="space-y-4">
                @foreach($transactions as $transaction)
                <a href="{{ route('riwayat.detail', ['id' => $transaction['id'], 'type' => $transaction['type']]) }}" class="block bg-white rounded-3xl p-5 lg:p-6 shadow-lg hover:shadow-xl border border-gray-100 hover:border-{{ $transaction['type'] === 'deposit' ? 'green' : 'blue' }}-300 transition-all duration-200 cursor-pointer group">
                    <div class="flex items-center justify-between">
                        <!-- Left: Icon and Details -->
                        <div class="flex items-center space-x-4 flex-1">
                            <!-- Icon with Direction -->
                            <div class="w-14 h-14 lg:w-16 lg:h-16 bg-gradient-to-br from-{{ $transaction['type'] === 'deposit' ? 'green' : 'blue' }}-100 to-{{ $transaction['type'] === 'deposit' ? 'green' : 'blue' }}-50 rounded-2xl flex items-center justify-center flex-shrink-0 border-2 border-{{ $transaction['type'] === 'deposit' ? 'green' : 'blue' }}-200 group-hover:scale-110 transition-transform">
                                @if($transaction['type'] === 'deposit')
                                    <i class="bi bi-arrow-up-right text-green-600 text-2xl lg:text-3xl font-bold"></i>
                                @else
                                    <i class="bi bi-arrow-down-left text-blue-600 text-2xl lg:text-3xl font-bold"></i>
                                @endif
                            </div>
                            
                            <!-- Transaction Details -->
                            <div class="flex-1">
                                <h3 class="font-bold text-gray-800 text-base lg:text-lg mb-2 flex items-center gap-2">
                                    <i class="bi bi-{{ $transaction['type'] === 'deposit' ? 'recycle' : 'gift' }} text-{{ $transaction['type'] === 'deposit' ? 'green' : 'blue' }}-600"></i>
                                    {{ $transaction['title'] }}
                                </h3>
                                <p class="text-sm text-gray-600 mb-3">{{ $transaction['description'] }}</p>
                                <div class="flex flex-wrap items-center gap-3 text-xs lg:text-sm text-gray-500">
                                    <span class="flex items-center gap-1.5 bg-gray-50 px-3 py-1.5 rounded-lg">
                                        <i class="bi bi-calendar3"></i>
                                        {{ $transaction['date']->format('d M Y, H:i') }}
                                    </span>
                                    @if(isset($transaction['weight']))
                                    <span class="flex items-center gap-1.5 bg-gray-50 px-3 py-1.5 rounded-lg">
                                        <i class="bi bi-box-seam"></i>
                                        {{ $transaction['weight'] }} kg
                                    </span>
                                    @endif
                                    
                                    <!-- Status Badge -->
                                    @if($transaction['status'] === 'verified' || $transaction['status'] === 'completed')
                                        <span class="px-3 py-1.5 bg-gradient-to-r from-green-100 to-green-50 text-green-700 rounded-lg text-xs font-bold flex items-center gap-1.5 border border-green-200">
                                            <i class="bi bi-check-circle-fill"></i>
                                            Selesai
                                        </span>
                                    @elseif($transaction['status'] === 'confirmed')
                                        <span class="px-3 py-1.5 bg-gradient-to-r from-blue-100 to-blue-50 text-blue-700 rounded-lg text-xs font-bold flex items-center gap-1.5 border border-blue-200">
                                            <i class="bi bi-check-circle"></i>
                                            Siap Ambil
                                        </span>
                                    @elseif($transaction['status'] === 'pending')
                                        <span class="px-3 py-1.5 bg-gradient-to-r from-yellow-100 to-yellow-50 text-yellow-700 rounded-lg text-xs font-bold flex items-center gap-1.5 border border-yellow-200">
                                            <i class="bi bi-clock"></i>
                                            Menunggu
                                        </span>
                                    @elseif($transaction['status'] === 'rejected')
                                        <span class="px-3 py-1.5 bg-gradient-to-r from-red-100 to-red-50 text-red-700 rounded-lg text-xs font-bold flex items-center gap-1.5 border border-red-200">
                                            <i class="bi bi-x-circle"></i>
                                            Ditolak
                                        </span>
                                    @elseif($transaction['status'] === 'cancelled')
                                        <span class="px-3 py-1.5 bg-gradient-to-r from-gray-100 to-gray-50 text-gray-700 rounded-lg text-xs font-bold flex items-center gap-1.5 border border-gray-200">
                                            <i class="bi bi-slash-circle"></i>
                                            Dibatalkan
                                        </span>
                                    @else
                                        <span class="px-3 py-1.5 bg-gray-100 text-gray-700 rounded-lg text-xs font-bold border border-gray-200">
                                            Unknown
                                        </span>
                                    @endif
                                </div>
                            </div>
                        </div>

                        <!-- Right: Points -->
                        <div class="text-right ml-4">
                            <div class="bg-{{ $transaction['points'] > 0 ? 'green' : 'red' }}-50 px-4 py-3 rounded-2xl border-2 border-{{ $transaction['points'] > 0 ? 'green' : 'red' }}-200">
                                <p class="text-xl lg:text-2xl font-bold {{ $transaction['points'] > 0 ? 'text-green-600' : 'text-red-600' }} flex items-center justify-center gap-1.5 mb-0.5">
                                    {{ $transaction['points'] > 0 ? '+' : '' }}{{ number_format($transaction['points'], 0, ',', '.') }}
                                    <i class="bi bi-coin text-{{ $transaction['points'] > 0 ? 'green' : 'red' }}-500"></i>
                                </p>
                                <p class="text-xs text-gray-600 font-semibold">Poin</p>
                            </div>
                        </div>
                    </div>
                </a>
                @endforeach
            </div>

            <!-- Load More Button -->
            @if($transactions->count() >= 50)
            <div class="mt-8 text-center">
                <button onclick="loadMore()" class="px-8 py-3 bg-white hover:bg-gray-50 text-gray-700 rounded-xl font-semibold border-2 border-gray-200 hover:border-green-500 transition-all inline-flex items-center space-x-2">
                    <i class="bi bi-arrow-clockwise"></i>
                    <span>Muat Lebih Banyak</span>
                </button>
            </div>
            @endif
        @endif

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

    <script>
        function loadMore() {
            // Implement pagination logic here
            alert('Fitur pagination akan segera ditambahkan');
        }
    </script>

</body>
</html>
