<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Daftar Permintaan Penukaran - Green Saving</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css" rel="stylesheet">
    <!-- SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
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

                    <!-- Notification Bell with Dropdown -->
                    <div class="relative" x-data="{ open: false }" @click.away="open = false">
                        <button @click="open = !open; markNotificationsAsRead()" class="relative w-12 h-12 bg-gray-100 hover:bg-gray-200 rounded-full flex items-center justify-center transition-all">
                            <i class="bi bi-bell text-gray-700 text-xl"></i>
                            @if(isset($unreadNotifications) && $unreadNotifications > 0)
                            <span data-notif-badge class="absolute -top-2 -right-2 bg-red-500 text-white text-xs font-bold rounded-full w-6 h-6 flex items-center justify-center animate-pulse">
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
                    <a href="{{ route('admin.dashboard') }}" class="bg-white text-gray-700 px-4 lg:px-6 py-3 rounded-2xl text-xs lg:text-sm font-semibold hover:bg-green-50 transition-colors shadow-sm flex items-center justify-center space-x-2 w-full">
                        <i class="bi bi-house-door"></i>
                        <span class="truncate">Dashboard</span>
                    </a>
                    <a href="{{ route('admin.setoran.index') }}" class="bg-white text-gray-700 px-4 lg:px-6 py-3 rounded-2xl text-xs lg:text-sm font-semibold hover:bg-green-50 transition-colors shadow-sm flex items-center justify-center space-x-2 w-full">
                        <i class="bi bi-graph-up"></i>
                        <span class="truncate">Setoran</span>
                    </a>
                    <a href="{{ route('admin.penukaran.index') }}" class="bg-green-500 text-white px-4 lg:px-6 py-3 rounded-2xl text-xs lg:text-sm font-semibold shadow-md flex items-center justify-center space-x-2 w-full">
                        <i class="bi bi-arrow-left-right"></i>
                        <span class="truncate">Penukaran</span>
                    </a>
                    <a href="{{ route('admin.reward-items.index') }}" class="bg-white text-gray-700 px-4 lg:px-6 py-3 rounded-2xl text-xs lg:text-sm font-semibold hover:bg-green-50 transition-colors shadow-sm flex items-center justify-center space-x-2 w-full">
                        <i class="bi bi-gift"></i>
                        <span class="truncate">Tukar Barang</span>
                    </a>
                    <a href="{{ route('admin.waste-types.index') }}" class="bg-white text-gray-700 px-4 lg:px-6 py-3 rounded-2xl text-xs lg:text-sm font-semibold hover:bg-green-50 transition-colors shadow-sm flex items-center justify-center space-x-2 w-full">
                        <i class="bi bi-recycle"></i>
                        <span class="truncate">Jenis Sampah</span>
                    </a>
                    <a href="{{ route('admin.laporan.index') }}" class="bg-white text-gray-700 px-4 lg:px-6 py-3 rounded-2xl text-xs lg:text-sm font-semibold hover:bg-green-50 transition-colors shadow-sm flex items-center justify-center space-x-2 w-full">
                        <i class="bi bi-file-earmark-text"></i>
                        <span class="truncate">Laporan</span>
                    </a>
                </div>
            </div>
        </div>
    </header>

    <!-- Main Content -->
    <main class="max-w-6xl mx-auto px-4 py-8">
        <div class="space-y-6">
            @if(session('success'))
                <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 3000)"
                     class="bg-gradient-to-r from-green-500 to-emerald-600 text-white px-6 py-4 rounded-2xl shadow-lg flex items-center justify-between">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 bg-white bg-opacity-20 rounded-full flex items-center justify-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>
                        <span class="font-semibold">{{ session('success') }}</span>
                    </div>
                    <button @click="show = false" class="text-white hover:bg-white hover:bg-opacity-20 rounded-lg p-2 transition-all">
                        <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd" />
                        </svg>
                    </button>
                </div>
            @endif

            {{-- Stats Summary - Bulan Ini --}}
            <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                <div class="bg-gradient-to-br from-amber-200 to-yellow-200 rounded-2xl p-6 shadow-md border border-amber-300">
                    <div class="flex items-center justify-between mb-3">
                        <div class="w-12 h-12 bg-white bg-opacity-60 backdrop-blur-sm rounded-xl flex items-center justify-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-amber-700" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>
                        @if($pending > 0)
                            <span class="w-6 h-6 bg-amber-600 text-white rounded-full flex items-center justify-center text-xs font-bold animate-pulse">{{ $pending }}</span>
                        @endif
                    </div>
                    <div class="text-sm font-medium text-amber-800">Menunggu</div>
                    <div class="text-3xl font-bold mt-1 text-amber-950">{{ $pending }}</div>
                    <div class="text-xs text-amber-700 mt-1">Bulan {{ now()->format('F Y') }}</div>
                </div>

                <div class="bg-gradient-to-br from-emerald-200 to-teal-200 rounded-2xl p-6 shadow-md border border-emerald-300">
                    <div class="flex items-center justify-between mb-3">
                        <div class="w-12 h-12 bg-white bg-opacity-60 backdrop-blur-sm rounded-xl flex items-center justify-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-emerald-700" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>
                    </div>
                    <div class="text-sm font-medium text-emerald-800">Dikonfirmasi</div>
                    <div class="text-3xl font-bold mt-1 text-emerald-950">{{ $confirmed }}</div>
                    <div class="text-xs text-emerald-700 mt-1">Bulan {{ now()->format('F Y') }}</div>
                </div>

                <div class="bg-gradient-to-br from-lime-200 to-green-200 rounded-2xl p-6 shadow-md border border-lime-300">
                    <div class="flex items-center justify-between mb-3">
                        <div class="w-12 h-12 bg-white bg-opacity-60 backdrop-blur-sm rounded-xl flex items-center justify-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-green-700" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>
                    </div>
                    <div class="text-sm font-medium text-green-800">Total Poin</div>
                    <div class="text-3xl font-bold mt-1 text-green-950">{{ number_format($totalPoints, 0, ',', '.') }}</div>
                    <div class="text-xs text-green-700 mt-1">Bulan {{ now()->format('F Y') }}</div>
                </div>
            </div>

            <div class="bg-white shadow-lg rounded-2xl overflow-hidden">
                <div class="bg-gradient-to-r from-emerald-50 to-teal-50 px-6 py-4 border-b-2 border-emerald-200">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 bg-gradient-to-br from-emerald-500 to-teal-600 rounded-xl flex items-center justify-center shadow-md">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                                </svg>
                            </div>
                            <div>
                                <h3 class="text-lg font-bold text-gray-800">Daftar Permintaan</h3>
                                <p class="text-sm text-gray-600">Kelola permintaan penukaran poin</p>
                            </div>
                        </div>
                        <div class="flex gap-2">
                            <button onclick="toggleFilter()" id="filterBtn" class="px-4 py-2 bg-white border-2 border-emerald-300 text-emerald-600 rounded-xl font-semibold hover:bg-emerald-50 transition-all">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 inline mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z" />
                                </svg>
                                Filter
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Filter Form (Toggle Show/Hide) -->
                <div id="filterForm" class="hidden bg-gradient-to-br from-emerald-50 to-teal-50 px-6 py-4 border-b-2 border-emerald-200">
                    <form method="GET" action="{{ route('admin.penukaran.index') }}" class="space-y-4">
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                            <!-- Filter Status -->
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-2">
                                    <i class="bi bi-funnel mr-1"></i>Status
                                </label>
                                <select name="status" class="w-full px-4 py-2 border-2 border-emerald-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-emerald-500 bg-white">
                                    <option value="semua" {{ request('status') == 'semua' ? 'selected' : '' }}>Semua Status</option>
                                    <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Menunggu</option>
                                    <option value="confirmed" {{ request('status') == 'confirmed' ? 'selected' : '' }}>Dikonfirmasi</option>
                                    <option value="completed" {{ request('status') == 'completed' ? 'selected' : '' }}>Selesai</option>
                                    <option value="cancelled" {{ request('status') == 'cancelled' ? 'selected' : '' }}>Dibatalkan</option>
                                </select>
                            </div>

                            <!-- Filter Bulan -->
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-2">
                                    <i class="bi bi-calendar-month mr-1"></i>Bulan
                                </label>
                                <input type="month" name="bulan" value="{{ request('bulan') }}" 
                                       class="w-full px-4 py-2 border-2 border-emerald-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-emerald-500 bg-white">
                            </div>

                            <!-- Action Buttons -->
                            <div class="flex items-end gap-2">
                                <button type="submit" class="flex-1 px-4 py-2 bg-gradient-to-r from-emerald-500 to-teal-600 text-white rounded-xl font-semibold hover:from-emerald-600 hover:to-teal-700 transition-all shadow-md">
                                    <i class="bi bi-check-circle mr-1"></i>Terapkan Filter
                                </button>
                                <a href="{{ route('admin.penukaran.index') }}" class="px-4 py-2 bg-gray-200 hover:bg-gray-300 text-gray-700 rounded-xl font-semibold transition-all">
                                    <i class="bi bi-arrow-clockwise"></i>
                                </a>
                            </div>
                        </div>

                        <!-- Active Filters Info -->
                        @if(request('status') && request('status') != 'semua' || request('bulan'))
                        <div class="flex items-center gap-2 text-sm">
                            <i class="bi bi-info-circle text-emerald-600"></i>
                            <span class="text-gray-700 font-medium">Filter aktif:</span>
                            @if(request('status') && request('status') != 'semua')
                                <span class="px-3 py-1 bg-emerald-100 text-emerald-700 rounded-full text-xs font-semibold">
                                    Status: {{ ucfirst(request('status')) }}
                                </span>
                            @endif
                            @if(request('bulan'))
                                <span class="px-3 py-1 bg-emerald-100 text-emerald-700 rounded-full text-xs font-semibold">
                                    Bulan: {{ \Carbon\Carbon::parse(request('bulan'))->format('F Y') }}
                                </span>
                            @endif
                        </div>
                        @endif
                    </form>
                </div>

                <div class="p-6">
                    @if($redemptions->count() > 0)
                        <div class="overflow-x-auto">
                            <table class="w-full">
                                <thead class="bg-gray-50 border-b-2 border-gray-200">
                                    <tr>
                                        <th class="px-6 py-3 text-left text-xs font-bold text-gray-700 uppercase tracking-wider">ID</th>
                                        <th class="px-6 py-3 text-left text-xs font-bold text-gray-700 uppercase tracking-wider">WARGA</th>
                                        <th class="px-6 py-3 text-left text-xs font-bold text-gray-700 uppercase tracking-wider">BARANG</th>
                                        <th class="px-6 py-3 text-left text-xs font-bold text-gray-700 uppercase tracking-wider">TOTAL POIN</th>
                                        <th class="px-6 py-3 text-left text-xs font-bold text-gray-700 uppercase tracking-wider">STATUS</th>
                                        <th class="px-6 py-3 text-left text-xs font-bold text-gray-700 uppercase tracking-wider">TANGGAL</th>
                                        <th class="px-6 py-3 text-center text-xs font-bold text-gray-700 uppercase tracking-wider">AKSI</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                    @foreach($redemptions as $redemption)
                                        <tr class="hover:bg-gray-50 transition-colors">
                                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                                {{ $redemption->id }}
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <div class="text-sm font-medium text-gray-900">{{ $redemption->user->name }}</div>
                                                <div class="text-sm text-gray-500">{{ $redemption->user->email }}</div>
                                            </td>
                                            <td class="px-6 py-4">
                                                <div class="text-sm text-gray-900">
                                                    @foreach($redemption->items as $item)
                                                        <div>{{ $item->rewardItem->name }} (x{{ $item->quantity }})</div>
                                                    @endforeach
                                                </div>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-bold bg-green-100 text-green-800">
                                                    <i class="bi bi-coin mr-1"></i>
                                                    {{ number_format($redemption->total_points, 0, ',', '.') }} poin
                                                </span>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                @if($redemption->status === 'pending')
                                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold bg-yellow-100 text-yellow-800">
                                                        <i class="bi bi-clock mr-1"></i>
                                                        Menunggu
                                                    </span>
                                                @elseif($redemption->status === 'confirmed')
                                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold bg-emerald-100 text-emerald-800">
                                                        <i class="bi bi-check-circle mr-1"></i>
                                                        Dikonfirmasi
                                                    </span>
                                                @elseif($redemption->status === 'completed')
                                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold bg-blue-100 text-blue-800">
                                                        <i class="bi bi-check-all mr-1"></i>
                                                        Selesai
                                                    </span>
                                                @elseif($redemption->status === 'rejected')
                                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold bg-red-100 text-red-800">
                                                        <i class="bi bi-x-circle mr-1"></i>
                                                        Ditolak
                                                    </span>
                                                @endif
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                                {{ $redemption->created_at->format('d M Y, H:i') }}
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                                <div class="flex items-center justify-end flex-col gap-1">
                                                    <a href="{{ route('admin.penukaran.show', $redemption->id) }}" 
                                                        class="w-full inline-flex items-center justify-center px-2 py-1 bg-blue-500 hover:bg-blue-600 text-white rounded text-xs font-semibold transition-colors">
                                                        <i class="bi bi-eye mr-1"></i>Detail
                                                    </a>
                                                    
                                                    @if($redemption->status === 'pending')
                                                        <form action="{{ route('admin.penukaran.approve', $redemption->id) }}" method="POST" class="w-full">
                                                            @csrf
                                                            <button type="button" onclick="confirmApprove(this)" class="w-full inline-flex items-center justify-center px-2 py-1 bg-green-500 hover:bg-green-600 text-white rounded text-xs font-semibold transition-colors">
                                                                <i class="bi bi-check-circle mr-1"></i>Konfirmasi
                                                            </button>
                                                        </form>
                                                    @elseif($redemption->status === 'confirmed')
                                                        <form action="{{ route('admin.penukaran.complete', $redemption->id) }}" method="POST" class="w-full">
                                                            @csrf
                                                            <button type="button" onclick="confirmComplete(this)" class="w-full inline-flex items-center justify-center px-2 py-1 bg-blue-500 hover:bg-blue-600 text-white rounded text-xs font-semibold transition-colors">
                                                                <i class="bi bi-check-all mr-1"></i>Diserahkan
                                                            </button>
                                                        </form>
                                                    @endif
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="text-center py-12">
                            <i class="bi bi-inbox text-gray-300 text-6xl mb-4"></i>
                            <p class="text-gray-500 text-lg font-semibold">Belum ada permintaan penukaran</p>
                            <p class="text-gray-400 text-sm">Data akan muncul di sini setelah warga mengajukan penukaran poin</p>
                        </div>
                    @endif

                    @if($pendingCount > 0)
                        <div class="mt-6 bg-gradient-to-r from-yellow-50 to-orange-50 border-l-4 border-yellow-400 rounded-xl p-4 shadow-sm">
                            <div class="flex items-center gap-3">
                                <div class="w-10 h-10 bg-yellow-400 rounded-full flex items-center justify-center text-white flex-shrink-0">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                                    </svg>
                                </div>
                                <div>
                                    <div class="font-bold text-yellow-800">Perhatian!</div>
                                    <div class="text-sm text-yellow-700">Ada <span class="font-bold">{{ $pendingCount }}</span> permintaan yang menunggu konfirmasi Anda</div>
                                </div>
                            </div>
                        </div>
                    @endif
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


    <script>
        // Toggle Filter Form
        function toggleFilter() {
            const filterForm = document.getElementById('filterForm');
            filterForm.classList.toggle('hidden');
        }

        // Fungsi konfirmasi untuk tombol "Konfirmasi" (Approve)
        function confirmApprove(button) {
            const form = button.closest('form');
            
            Swal.fire({
                title: 'Setujui Penukaran?',
                text: 'Pastikan Anda telah memeriksa detail penukaran ini.',
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#10b981',
                cancelButtonColor: '#ef4444',
                confirmButtonText: 'Ya, Setujui!',
                cancelButtonText: 'Batal',
                reverseButtons: true,
                customClass: {
                    popup: 'rounded-2xl',
                    confirmButton: 'rounded-xl px-6 py-2 font-semibold',
                    cancelButton: 'rounded-xl px-6 py-2 font-semibold'
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    form.submit();
                    Swal.fire({
                        title: 'Memproses...',
                        text: 'Mohon tunggu sebentar',
                        allowOutsideClick: false,
                        allowEscapeKey: false,
                        showConfirmButton: false,
                        didOpen: () => { Swal.showLoading(); }
                    });
                }
            });
        }

        // Fungsi konfirmasi untuk tombol "Diserahkan" (Complete)
        function confirmComplete(button) {
            const form = button.closest('form');
            
            Swal.fire({
                title: 'Serahkan Barang?',
                text: 'Pastikan barang sudah diterima oleh warga.',
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#06b6d4',
                cancelButtonColor: '#ef4444',
                confirmButtonText: 'Ya, Sudah Diserahkan!',
                cancelButtonText: 'Belum',
                reverseButtons: true,
                customClass: {
                    popup: 'rounded-2xl',
                    confirmButton: 'rounded-xl px-6 py-2 font-semibold',
                    cancelButton: 'rounded-xl px-6 py-2 font-semibold'
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    form.submit();
                    Swal.fire({
                        title: 'Memproses...',
                        text: 'Mohon tunggu sebentar',
                        allowOutsideClick: false,
                        allowEscapeKey: false,
                        showConfirmButton: false,
                        didOpen: () => { Swal.showLoading(); }
                    });
                }
            });
        }

        // Function to mark all notifications as read
        async function markNotificationsAsRead() {
            const csrfToken = document.querySelector('meta[name="csrf-token"]').content;
            const badgeElement = document.querySelector('[data-notif-badge]');
            
            try {
                const response = await fetch('{{ route('notifikasi.read-all') }}', {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': csrfToken,
                        'Content-Type': 'application/json'
                    }
                });
                
                if (response.ok && badgeElement) {
                    badgeElement.style.display = 'none';
                }
            } catch (error) {
                console.error('Error marking notifications as read:', error);
            }
        }
    </script>
</body>
</html>
