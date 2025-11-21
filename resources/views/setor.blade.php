<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Setor Sampah - Green Saving</title>
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
                    <div class="w-11 h-11 lg:w-12 lg:h-12 bg-gradient-to-br from-green-500 to-green-600 rounded-xl flex items-center justify-center shadow-lg hover:scale-105 transition-transform">
                        <i class="bi bi-recycle text-white text-xl lg:text-2xl"></i>
                    </div>
                    <div>
                        <h1 class="font-bold text-lg lg:text-xl text-gray-800">Green Saving</h1>
                        <p class="text-xs lg:text-sm text-green-600 hidden sm:block">Halo, {{ $namaUser }}</p>
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
                            <span id="user-points" class="font-bold text-green-700 text-base">{{ number_format($saldoPoin, 0, ',', '.') }}</span>
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
                        <button @click="open = !open" class="relative w-11 h-11 bg-gray-100 hover:bg-gray-200 rounded-xl flex items-center justify-center transition-all hover:scale-105">
                            <i class="bi bi-bell text-gray-700 text-lg lg:text-xl"></i>
                            @if(isset($unreadNotifications) && $unreadNotifications > 0)
                            <span class="absolute -top-1.5 -right-1.5 bg-gradient-to-br from-red-500 to-red-600 text-white text-xs font-bold rounded-full w-5 h-5 lg:w-6 lg:h-6 flex items-center justify-center ring-2 ring-white shadow-md">
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
                                    Lihat Semua Notifikasi ?
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
                        <button type="submit" class="w-11 h-11 bg-red-100 hover:bg-red-200 rounded-xl flex items-center justify-center hover:scale-105 transition-all shadow-sm">
                            <i class="bi bi-box-arrow-right text-red-600 text-lg lg:text-xl"></i>
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
                    <a href="/notifikasi" class="relative bg-white text-gray-700 px-4 lg:px-6 py-3 rounded-2xl text-xs lg:text-sm font-semibold hover:bg-green-50 transition-colors shadow-sm flex items-center justify-center space-x-2 w-full cursor-pointer">
                        <i class="bi bi-bell pointer-events-none"></i>
                        <span class="truncate pointer-events-none">Notifikasi</span>
                        @if(isset($unreadNotifications) && $unreadNotifications > 0)
                        <span class="absolute -top-1 -right-1 bg-red-500 text-white text-xs font-bold rounded-full w-5 h-5 flex items-center justify-center pointer-events-none">
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
        
        <!-- Page Header with Tabs -->
        <div class="bg-white rounded-3xl shadow-lg border border-gray-100 overflow-hidden mb-6">
            <div class="p-6 lg:p-8 pb-0">
                <div class="flex items-center gap-3 mb-3">
                    <div class="w-12 h-12 bg-gradient-to-br from-green-500 to-green-600 rounded-2xl flex items-center justify-center shadow-md">
                        <i class="bi bi-recycle text-white text-2xl"></i>
                    </div>
                    <div>
                        <h2 class="text-2xl font-bold text-gray-800 leading-tight">Setor Sampah</h2>
                        <p class="text-sm text-gray-500">Kelola setoran sampah dan dapatkan poin</p>
                    </div>
                </div>
            </div>

            <!-- Tabs -->
            <div class="flex border-b border-gray-200 px-4 lg:px-6 mt-6">
                <button id="panduan-tab" onclick="switchTab('panduan')" class="tab-button flex-1 sm:flex-none px-5 lg:px-8 py-3.5 text-sm font-semibold text-green-600 border-b-3 border-green-600 flex items-center justify-center gap-2 transition-all duration-200 bg-green-50">
                    <i class="bi bi-compass text-lg"></i>
                    <span>Panduan</span>
                </button>
                <button id="riwayat-tab" onclick="switchTab('riwayat')" class="tab-button flex-1 sm:flex-none px-5 lg:px-8 py-3.5 text-sm font-semibold text-gray-500 hover:bg-gray-50 hover:text-gray-700 flex items-center justify-center gap-2 transition-all duration-200">
                    <i class="bi bi-clock-history text-lg"></i>
                    <span>Riwayat</span>
                </button>
            </div>
        </div>

        <!-- Tab Content: Panduan -->
        <div id="panduan-content" class="tab-content">`
        <!-- Jenis Sampah yang Diterima Section -->
        <div class="bg-white rounded-3xl p-6 lg:p-8 mb-6 shadow-lg border border-gray-100">
            <div class="flex items-start gap-3 mb-6">
                <div class="w-10 h-10 bg-gradient-to-br from-green-100 to-green-50 rounded-xl flex items-center justify-center border border-green-200">
                    <i class="bi bi-list-check text-green-600 text-xl"></i>
                </div>
                <div>
                    <h2 class="text-xl lg:text-2xl font-bold text-gray-800 mb-1.5">Jenis Sampah yang Diterima</h2>
                    <p class="text-sm text-gray-500">Lihat daftar jenis sampah dan poin yang bisa Anda dapatkan</p>
                </div>
            </div>

            <div class="space-y-4">
                @forelse($wasteTypes as $index => $waste)
                    @php
                        // Icon dan warna berdasarkan kategori atau index
                        $colors = [
                            ['bg' => 'bg-green-100', 'text' => 'text-green-600', 'badge' => 'bg-green-100 text-green-700', 'icon' => 'bi-recycle'],
                            ['bg' => 'bg-amber-100', 'text' => 'text-amber-600', 'badge' => 'bg-amber-100 text-amber-700', 'icon' => 'bi-box-seam'],
                            ['bg' => 'bg-gray-200', 'text' => 'text-gray-600', 'badge' => 'bg-gray-200 text-gray-700', 'icon' => 'bi-cup-straw'],
                            ['bg' => 'bg-blue-100', 'text' => 'text-blue-600', 'badge' => 'bg-blue-100 text-blue-700', 'icon' => 'bi-droplet'],
                            ['bg' => 'bg-orange-100', 'text' => 'text-orange-600', 'badge' => 'bg-orange-100 text-orange-700', 'icon' => 'bi-basket'],
                            ['bg' => 'bg-purple-100', 'text' => 'text-purple-600', 'badge' => 'bg-purple-100 text-purple-700', 'icon' => 'bi-gem'],
                        ];
                        $color = $colors[$index % count($colors)];
                    @endphp
                    
                    <div class="flex items-center justify-between p-4 lg:p-5 bg-gradient-to-br from-gray-50 to-white rounded-2xl hover:shadow-md transition-all duration-200 border border-gray-100 hover:border-green-200 group">
                        <div class="flex items-center space-x-4">
                            @if($waste->image)
                                <img src="{{ asset('images/' . $waste->image) }}" alt="{{ $waste->name }}" class="w-14 h-14 lg:w-16 lg:h-16 object-cover rounded-2xl flex-shrink-0 shadow-sm border-2 border-white group-hover:scale-105 transition-transform duration-200">
                            @else
                                <div class="w-14 h-14 lg:w-16 lg:h-16 {{ $color['bg'] }} rounded-2xl flex items-center justify-center flex-shrink-0 shadow-sm border-2 border-white group-hover:scale-105 transition-transform duration-200">
                                    <i class="bi {{ $color['icon'] }} {{ $color['text'] }} text-2xl"></i>
                                </div>
                            @endif
                            <div>
                                <h4 class="font-bold text-gray-800 text-base lg:text-lg mb-1">{{ $waste->name }}</h4>
                                <p class="text-sm text-gray-600 mb-2">{{ $waste->description ?? 'Sampah jenis ' . strtolower($waste->name) }}</p>
                                <span class="inline-block px-3 py-1 {{ $color['badge'] }} text-xs font-semibold rounded-lg">
                                    <i class="bi bi-box text-xs mr-1"></i>{{ $waste->unit }}
                                </span>
                            </div>
                        </div>
                        <div class="text-right">
                            <div class="bg-gradient-to-br from-green-50 to-emerald-50 px-4 py-3 rounded-xl border border-green-200">
                                <p class="text-xs text-green-600 font-medium mb-1">Harga</p>
                                <p class="text-green-600 font-bold text-lg lg:text-xl">{{ number_format($waste->points_per_unit, 0, ',', '.') }}</p>
                                <p class="text-xs text-green-600 font-medium">poin/{{ strtolower($waste->unit) }}</p>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="text-center py-8 text-gray-500">
                        <i class="bi bi-inbox text-4xl mb-2"></i>
                        <p>Belum ada jenis sampah yang terdaftar</p>
                    </div>
                @endforelse
            </div>
        </div>

        <!-- Cara Setor Sampah Section -->
        <div class="bg-white rounded-3xl p-6 lg:p-8 shadow-lg border border-gray-100">
            <div class="flex items-start gap-3 mb-8">
                <div class="w-10 h-10 bg-gradient-to-br from-blue-100 to-blue-50 rounded-xl flex items-center justify-center border border-blue-200">
                    <i class="bi bi-info-circle text-blue-600 text-xl"></i>
                </div>
                <div>
                    <h2 class="text-xl lg:text-2xl font-bold text-gray-800 mb-1.5">Cara Setor Sampah</h2>
                    <p class="text-sm text-gray-500">Panduan lengkap untuk menyetor sampah dan mendapatkan poin</p>
                </div>
            </div>

            <!-- Tahap 1: Persiapan -->
            <div class="mb-8">
                <div class="flex items-center space-x-3 mb-5">
                    <div class="w-10 h-10 bg-gradient-to-br from-green-500 to-green-600 rounded-xl flex items-center justify-center shadow-md">
                        <span class="text-white font-bold text-base">1</span>
                    </div>
                    <h3 class="font-bold text-gray-800 text-lg">Tahap 1: Persiapan (Warga)</h3>
                </div>
                <div class="ml-13 space-y-3">
                    <div class="flex items-start space-x-3 p-4 bg-gradient-to-br from-green-50 to-white rounded-xl border border-green-100 hover:shadow-md transition-shadow duration-200">
                        <div class="w-7 h-7 bg-gradient-to-br from-green-500 to-green-600 text-white rounded-lg flex items-center justify-center flex-shrink-0 text-sm font-bold mt-0.5 shadow-sm">
                            1
                        </div>
                        <div>
                            <p class="font-semibold text-gray-800 mb-1">Pilah dan Bersihkan Sampah</p>
                            <p class="text-sm text-gray-600">Pastikan sampah sudah dibersihkan dari sisa makanan dan dipisahkan berdasarkan jenisnya.</p>
                        </div>
                    </div>
                    <div class="flex items-start space-x-3 p-4 bg-gradient-to-br from-green-50 to-white rounded-xl border border-green-100 hover:shadow-md transition-shadow duration-200">
                        <div class="w-7 h-7 bg-gradient-to-br from-green-500 to-green-600 text-white rounded-lg flex items-center justify-center flex-shrink-0 text-sm font-bold mt-0.5 shadow-sm">
                            2
                        </div>
                        <div>
                            <p class="font-semibold text-gray-800 mb-1.5">Kunjungi Cabang</p>
                            <p class="text-sm text-gray-600 leading-relaxed">Bawa sampah yang telah dipilah dan dibersihkan ke bank sampah terdekat dari lokasi Anda.</p>
                        </div>
                    </div>
                    <div class="flex items-start space-x-3 p-4 bg-gradient-to-br from-green-50 to-white rounded-xl border border-green-100 hover:shadow-md transition-shadow duration-200">
                        <div class="w-7 h-7 bg-gradient-to-br from-green-500 to-green-600 text-white rounded-lg flex items-center justify-center flex-shrink-0 text-sm font-bold mt-0.5 shadow-sm">
                            3
                        </div>
                        <div>
                            <p class="font-semibold text-gray-800 mb-1.5">Datang ke Bank Sampah Terdekat</p>
                            <p class="text-sm text-gray-600 leading-relaxed">Bawa sampah yang sudah dipilah dan dibersihkan ke bank sampah terdekat dari lokasi Anda.</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Tahap 2: Transaksi -->
            <div class="mb-8">
                <div class="flex items-center space-x-3 mb-5">
                    <div class="w-10 h-10 bg-gradient-to-br from-blue-500 to-blue-600 rounded-xl flex items-center justify-center shadow-md">
                        <span class="text-white font-bold text-base">2</span>
                    </div>
                    <h3 class="font-bold text-gray-800 text-lg">Tahap 2: Transaksi di Lokasi (Peran Admin & Sistem)</h3>
                </div>
                <div class="ml-13 space-y-3">
                    <div class="flex items-start space-x-3 p-4 bg-gradient-to-br from-blue-50 to-white rounded-xl border border-blue-100 hover:shadow-md transition-shadow duration-200">
                        <div class="w-7 h-7 bg-gradient-to-br from-blue-500 to-blue-600 text-white rounded-lg flex items-center justify-center flex-shrink-0 text-sm font-bold mt-0.5 shadow-sm">
                            1
                        </div>
                        <div>
                            <p class="font-semibold text-gray-800 mb-1.5">Serahkan ID akun Warga Anda</p>
                            <p class="text-sm text-gray-600 leading-relaxed">Atau tunjukkan kode ID di aplikasi/website kepada Admin Cabang yang bertugas.</p>
                        </div>
                    </div>
                    <div class="flex items-start space-x-3 p-4 bg-gradient-to-br from-blue-50 to-white rounded-xl border border-blue-100 hover:shadow-md transition-shadow duration-200">
                        <div class="w-7 h-7 bg-gradient-to-br from-blue-500 to-blue-600 text-white rounded-lg flex items-center justify-center flex-shrink-0 text-sm font-bold mt-0.5 shadow-sm">
                            2
                        </div>
                        <div>
                            <p class="font-semibold text-gray-800 mb-1.5">Penimbangan dan Pencatatan</p>
                            <p class="text-sm text-gray-600 leading-relaxed">Admin akan menimbang sampah Anda dan menginput jenis serta beratnya ke dalam sistem.</p>
                        </div>
                    </div>
                    <div class="flex items-start space-x-3 p-4 bg-gradient-to-br from-blue-50 to-white rounded-xl border border-blue-100 hover:shadow-md transition-shadow duration-200">
                        <div class="w-7 h-7 bg-gradient-to-br from-blue-500 to-blue-600 text-white rounded-lg flex items-center justify-center flex-shrink-0 text-sm font-bold mt-0.5 shadow-sm">
                            3
                        </div>
                        <div>
                            <p class="font-semibold text-gray-800 mb-1.5">Verifikasi Lokasi</p>
                            <p class="text-sm text-gray-600 leading-relaxed">Sistem secara otomatis mencatat setoran ini di cabang Bank Sampah tempat Anda berada.</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Tahap 3: Poin Masuk -->
            <div class="mb-2">
                <div class="flex items-center space-x-3 mb-5">
                    <div class="w-10 h-10 bg-gradient-to-br from-purple-500 to-purple-600 rounded-xl flex items-center justify-center shadow-md">
                        <span class="text-white font-bold text-base">3</span>
                    </div>
                    <h3 class="font-bold text-gray-800 text-lg">Tahap 3: Poin Masuk (Peran Sistem)</h3>
                </div>
                <div class="ml-13 space-y-3">
                    <div class="flex items-start space-x-3 p-4 bg-gradient-to-br from-purple-50 to-white rounded-xl border border-purple-100 hover:shadow-md transition-shadow duration-200">
                        <div class="w-7 h-7 bg-gradient-to-br from-purple-500 to-purple-600 text-white rounded-lg flex items-center justify-center flex-shrink-0 text-sm font-bold mt-0.5 shadow-sm">
                            1
                        </div>
                        <div>
                            <p class="font-semibold text-gray-800 mb-1.5">Poin Dihitung</p>
                            <p class="text-sm text-gray-600 leading-relaxed">Sistem secara otomatis menghitung total poin Anda.</p>
                        </div>
                    </div>
                    <div class="flex items-start space-x-3 p-4 bg-gradient-to-br from-purple-50 to-white rounded-xl border border-purple-100 hover:shadow-md transition-shadow duration-200">
                        <div class="w-7 h-7 bg-gradient-to-br from-purple-500 to-purple-600 text-white rounded-lg flex items-center justify-center flex-shrink-0 text-sm font-bold mt-0.5 shadow-sm">
                            2
                        </div>
                        <div>
                            <p class="font-semibold text-gray-800 mb-1.5">Verifikasi Admin</p>
                            <p class="text-sm text-gray-600 leading-relaxed">Admin akan mengkonfirmasi transaksi di sistem. Setelah dikonfirmasi, poin Anda langsung dimasukkan ke saldo.</p>
                        </div>
                    </div>
                    <div class="flex items-start space-x-3 p-4 bg-gradient-to-br from-purple-50 to-white rounded-xl border border-purple-100 hover:shadow-md transition-shadow duration-200">
                        <div class="w-7 h-7 bg-gradient-to-br from-purple-500 to-purple-600 text-white rounded-lg flex items-center justify-center flex-shrink-0 text-sm font-bold mt-0.5 shadow-sm">
                            3
                        </div>
                        <div>
                            <p class="font-semibold text-gray-800 mb-1.5">Cek Saldo</p>
                            <p class="text-sm text-gray-600 leading-relaxed">Anda akan menerima notifikasi bahwa setoran sudah diverifikasi dan poin berhasil ditambahkan. Cek Dashboard Anda untuk melihat saldo terbaru.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        </div>
        <!-- End Tab Content: Panduan -->

        <!-- Tab Content: Riwayat -->
        <div id="riwayat-content" class="tab-content hidden">
            <div class="bg-white rounded-3xl p-6 lg:p-8 shadow-lg border border-gray-100">
                <div class="flex items-start gap-3 mb-8">
                    <div class="w-10 h-10 bg-gradient-to-br from-green-100 to-green-50 rounded-xl flex items-center justify-center border border-green-200">
                        <i class="bi bi-clock-history text-green-600 text-xl"></i>
                    </div>
                    <div>
                        <h2 class="text-xl lg:text-2xl font-bold text-gray-800 mb-1.5">Riwayat Setoran Sampah</h2>
                        <p class="text-sm text-gray-500">Lihat semua transaksi setoran sampah Anda</p>
                    </div>
                </div>

                <!-- Deposits List -->
                <div class="space-y-4">
                    @forelse($deposits as $deposit)
                        <div class="bg-white border border-gray-200 rounded-2xl p-5 hover:shadow-lg hover:border-green-300 transition-all">
                            <div class="flex items-start gap-4">
                                <!-- Icon -->
                                <div class="w-14 h-14 {{ $deposit->status == 'verified' ? 'bg-green-100' : 'bg-amber-100' }} rounded-xl flex items-center justify-center flex-shrink-0">
                                    <i class="bi bi-recycle {{ $deposit->status == 'verified' ? 'text-green-600' : 'text-amber-600' }} text-2xl"></i>
                                </div>
                                
                                <!-- Content -->
                                <div class="flex-1">
                                    <div class="flex items-start justify-between mb-3">
                                        <div>
                                            <h4 class="font-bold text-gray-800 mb-1">
                                                @foreach($deposit->depositItems as $item)
                                                    {{ $item->wasteType->name }}{{ !$loop->last ? ', ' : '' }}
                                                @endforeach
                                            </h4>
                                            <p class="text-sm font-medium text-gray-600 mb-1">{{ number_format($deposit->total_weight, 1) }}kg</p>
                                            <div class="flex items-center text-sm text-gray-500">
                                                <i class="bi bi-geo-alt text-xs mr-1"></i>
                                                <span>{{ $deposit->branch->name ?? 'Bank Sampah' }}</span>
                                            </div>
                                        </div>
                                        <div class="flex items-center {{ $deposit->status == 'verified' ? 'bg-green-50' : 'bg-amber-50' }} px-3 py-1 rounded-full">
                                            <i class="bi {{ $deposit->status == 'verified' ? 'bi-check-circle-fill text-green-600' : 'bi-clock-fill text-amber-600' }} text-sm mr-1"></i>
                                            <span class="text-xs font-semibold {{ $deposit->status == 'verified' ? 'text-green-700' : 'text-amber-700' }}">
                                                {{ $deposit->status == 'verified' ? 'Terverifikasi' : 'Pending' }}
                                            </span>
                                        </div>
                                    </div>
                                    
                                    <!-- Details Grid -->
                                    <div class="grid grid-cols-1 sm:grid-cols-3 gap-3 pt-3 border-t border-gray-100">
                                        <div>
                                            <p class="text-xs text-gray-500 mb-1">Tanggal & Waktu</p>
                                            <p class="text-sm font-semibold text-gray-700">
                                                <i class="bi bi-calendar3 text-gray-400 text-xs mr-1"></i>
                                                {{ $deposit->created_at->format('d M Y � H:i') }}
                                            </p>
                                        </div>
                                        <div>
                                            <p class="text-xs text-gray-500 mb-1">Poin</p>
                                            <p class="text-sm font-bold text-green-600">
                                                <i class="bi bi-coin text-green-500 mr-1"></i>
                                                {{ number_format($deposit->total_points, 0, ',', '.') }} poin
                                            </p>
                                        </div>
                                        <div>
                                            <p class="text-xs text-gray-500 mb-1">Status</p>
                                            <p class="text-sm font-semibold {{ $deposit->status == 'verified' ? 'text-green-600' : 'text-amber-600' }}">
                                                <i class="bi {{ $deposit->status == 'verified' ? 'bi-check-circle' : 'bi-clock' }} mr-1"></i>
                                                {{ $deposit->status == 'verified' ? 'Terverifikasi' : 'Menunggu Verifikasi' }}
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="text-center py-12">
                            <i class="bi bi-inbox text-gray-300 text-6xl mb-4"></i>
                            <p class="text-gray-500 font-semibold">Belum ada riwayat setoran</p>
                            <p class="text-sm text-gray-400 mt-2">Hubungi admin untuk menyetor sampah</p>
                        </div>
                    @endforelse
                </div>

                @if($deposits->count() > 0)
                    <div class="mt-6 text-center">
                        <a href="/riwayat" class="inline-flex items-center px-6 py-3 bg-gray-100 text-gray-700 rounded-xl font-semibold hover:bg-gray-200 transition-colors">
                            <i class="bi bi-clock-history mr-2"></i>
                            Lihat Semua Riwayat
                        </a>
                    </div>
                @endif
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
                <p class="text-sm text-gray-500">� 2025 Green Saving. All rights reserved.</p>
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
        function showTransactionDetail(kode, status, lokasi, tanggal, waktu, admin, poinDiperoleh, poinSebelum, poinSetelah, wasteTypes, itemsHTML) {
            // Update modal content
            document.getElementById('modalStatus').textContent = status;
            document.getElementById('modalLokasi').textContent = lokasi;
            document.getElementById('modalTanggalWaktu').textContent = tanggal + ' � ' + waktu;
            document.getElementById('modalAdmin').textContent = admin;
            document.getElementById('modalPoinDiperoleh').innerHTML = '<i class="bi bi-coin text-green-500 mr-1"></i>' + poinDiperoleh.toLocaleString('id-ID') + ' poin';
            document.getElementById('modalPoinSebelum').textContent = poinSebelum.toLocaleString('id-ID') + ' poin';
            document.getElementById('modalPoinSetelah').textContent = poinSetelah.toLocaleString('id-ID') + ' poin';
            
            // Update status badge
            const badge = document.getElementById('modalStatusBadge');
            if (status === 'Selesai' || status === 'Completed') {
                badge.className = 'inline-block px-4 py-2 bg-green-100 text-green-700 rounded-full text-sm font-semibold';
                badge.innerHTML = '<i class="bi bi-check-circle-fill mr-1"></i>Selesai';
            } else {
                badge.className = 'inline-block px-4 py-2 bg-yellow-100 text-yellow-700 rounded-full text-sm font-semibold';
                badge.innerHTML = '<i class="bi bi-clock-fill mr-1"></i>Pending';
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

        // Fetch deposits from API
        let deposits = [];

        async function fetchDeposits() {
            try {
                const response = await fetch('/api/deposits', {
                    headers: {
                        'Accept': 'application/json'
                    }
                });

                if (!response.ok) throw new Error('Failed to fetch');

                deposits = await response.json();
                renderDeposits();
            } catch (error) {
                console.error('Error fetching deposits:', error);
                document.getElementById('loading-deposits').classList.add('hidden');
                document.getElementById('empty-deposits').classList.remove('hidden');
            }
        }

        function renderDeposits() {
            const container = document.getElementById('deposits-container');
            const loading = document.getElementById('loading-deposits');
            const empty = document.getElementById('empty-deposits');

            loading.classList.add('hidden');

            if (deposits.length === 0) {
                empty.classList.remove('hidden');
                return;
            }

            container.classList.remove('hidden');

            const statusConfig = {
                pending: {
                    bg: 'bg-yellow-50',
                    icon: 'bi-clock-fill',
                    iconColor: 'text-yellow-600',
                    textColor: 'text-yellow-700',
                    label: 'Pending'
                },
                confirmed: {
                    bg: 'bg-green-50',
                    icon: 'bi-check-circle-fill',
                    iconColor: 'text-green-600',
                    textColor: 'text-green-700',
                    label: 'Selesai'
                }
            };

            container.innerHTML = deposits.map(deposit => {
                const status = statusConfig[deposit.status] || statusConfig.pending;
                const date = new Date(deposit.created_at);
                const dateStr = date.toLocaleDateString('id-ID', { year: 'numeric', month: 'short', day: 'numeric' });
                const timeStr = date.toLocaleTimeString('id-ID', { hour: '2-digit', minute: '2-digit' });
                
                const totalWeight = deposit.items?.reduce((sum, item) => sum + parseFloat(item.weight || 0), 0) || 0;
                const wasteTypes = deposit.items?.map(item => item.waste_type?.name).filter(Boolean).join(', ') || 'Sampah';

                return `
                    <div onclick="showDepositDetail(${deposit.id})" 
                         class="bg-white border border-gray-200 rounded-2xl p-5 hover:shadow-lg hover:border-green-300 transition-all cursor-pointer">
                        <div class="flex items-start gap-4">
                            <div class="w-14 h-14 bg-green-100 rounded-xl flex items-center justify-center flex-shrink-0">
                                <i class="bi bi-recycle text-green-600 text-2xl"></i>
                            </div>
                            
                            <div class="flex-1">
                                <div class="flex items-start justify-between mb-3">
                                    <div>
                                        <h4 class="font-bold text-gray-800 mb-1">${wasteTypes}</h4>
                                        <p class="text-sm font-medium text-gray-600 mb-1">${totalWeight.toFixed(1)}kg</p>
                                        ${deposit.branch ? `
                                            <div class="flex items-center text-sm text-gray-500">
                                                <i class="bi bi-geo-alt text-xs mr-1"></i>
                                                <span>${deposit.branch.name}</span>
                                            </div>
                                        ` : ''}
                                    </div>
                                    <div class="flex items-center ${status.bg} px-3 py-1 rounded-full">
                                        <i class="bi ${status.icon} ${status.iconColor} text-sm mr-1"></i>
                                        <span class="text-xs font-semibold ${status.textColor}">${status.label}</span>
                                    </div>
                                </div>
                                
                                <div class="grid grid-cols-1 sm:grid-cols-3 gap-3 pt-3 border-t border-gray-100">
                                    <div>
                                        <p class="text-xs text-gray-500 mb-1">Tanggal & Waktu</p>
                                        <p class="text-sm font-semibold text-gray-700">
                                            <i class="bi bi-calendar3 text-gray-400 text-xs mr-1"></i>
                                            ${dateStr} � ${timeStr}
                                        </p>
                                    </div>
                                    <div>
                                        <p class="text-xs text-gray-500 mb-1">Poin</p>
                                        <p class="text-sm font-bold text-green-600">
                                            <i class="bi bi-coin text-green-500 mr-1"></i>
                                            ${(deposit.total_points || 0).toLocaleString('id-ID')} poin
                                        </p>
                                    </div>
                                    <div>
                                        <p class="text-xs text-gray-500 mb-1">Status</p>
                                        <p class="text-sm font-semibold ${status.textColor}">
                                            <i class="bi ${status.icon === 'bi-clock-fill' ? 'bi-clock' : 'bi-check-circle'} ${status.iconColor} mr-1"></i>
                                            ${status.label}
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                `;
            }).join('');
        }

        // Show deposit detail modal
        async function showDepositDetail(depositId) {
            const deposit = deposits.find(d => d.id === depositId);
            if (!deposit) return;

            // Fetch full detail
            try {
                const response = await fetch(`/api/deposits/${depositId}`);
                const fullDeposit = await response.json();

                const date = new Date(fullDeposit.created_at);
                const dateStr = date.toLocaleDateString('id-ID', { 
                    weekday: 'long',
                    year: 'numeric', 
                    month: 'long', 
                    day: 'numeric',
                    hour: '2-digit',
                    minute: '2-digit'
                });

                const totalWeight = fullDeposit.items?.reduce((sum, item) => sum + parseFloat(item.weight || 0), 0) || 0;
                const wasteTypes = fullDeposit.items?.map(item => item.waste_type?.name).filter(Boolean).join(', ') || 'Sampah';

                const statusLabel = fullDeposit.status === 'confirmed' ? 'Selesai' : 'Pending';
                const statusColor = fullDeposit.status === 'confirmed' ? 'text-green-600' : 'text-yellow-600';

                // Build items HTML
                const itemsHTML = fullDeposit.items?.map(item => `
                    <div class="flex items-center justify-between bg-gray-50 p-4 rounded-xl">
                        <div class="flex items-center space-x-3">
                            <div class="w-10 h-10 bg-green-100 rounded-lg flex items-center justify-center">
                                <i class="bi bi-recycle text-green-600"></i>
                            </div>
                            <div>
                                <p class="font-semibold text-gray-800">${item.waste_type?.name || 'Sampah'}</p>
                                <p class="text-sm text-gray-500">${item.weight} kg � ${item.points_per_kg || 0} poin/kg</p>
                            </div>
                        </div>
                        <div class="text-right">
                            <p class="font-bold text-green-600">+${(item.points || 0).toLocaleString('id-ID')}</p>
                            <p class="text-xs text-gray-500">poin</p>
                        </div>
                    </div>
                `).join('') || '<p class="text-gray-500 text-center py-4">Tidak ada item</p>';

                showTransactionDetail(
                    `#${fullDeposit.id}`,
                    statusLabel,
                    fullDeposit.branch?.name || 'Bank Sampah',
                    dateStr.split(',')[0],
                    date.toLocaleTimeString('id-ID', { hour: '2-digit', minute: '2-digit' }),
                    'Admin',
                    totalWeight,
                    fullDeposit.total_points || 0,
                    fullDeposit.total_points || 0,
                    wasteTypes,
                    itemsHTML
                );
            } catch (error) {
                console.error('Error fetching deposit detail:', error);
            }
        }

        // Load deposits when riwayat tab is opened
        const riwayatTab = document.getElementById('riwayat-tab');
        if (riwayatTab) {
            riwayatTab.addEventListener('click', function() {
                if (deposits.length === 0) {
                    fetchDeposits();
                }
            });
        }
    </script>

</body>
</html>
