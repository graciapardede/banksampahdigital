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
                        <p class="text-sm text-green-600">Halo, {{ Auth::user()->full_name ?? Auth::user()->name ?? 'Warga' }}</p>
                    </div>
                </div>

                <!-- Points & Actions -->
                <div class="flex items-center space-x-4">
                    <!-- Points Display -->
                    <div class="bg-gradient-to-r from-green-100 to-green-50 px-6 py-3 rounded-full border-2 border-green-300 shadow-md">
                        <div class="flex items-center space-x-2">
                            <i class="bi bi-coin text-green-600 text-xl"></i>
                            <span class="font-bold text-green-700 text-lg">{{ number_format($userBalance ?? 0, 0, ',', '.') }} poin</span>
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
                    <a href="/dashboard" class="bg-white text-gray-700 px-4 lg:px-6 py-3 rounded-2xl text-xs lg:text-sm font-semibold hover:bg-green-50 transition-colors shadow-sm flex items-center justify-center space-x-2">
                        <i class="bi bi-house-door"></i>
                        <span class="truncate">Dashboard</span>
                    </a>
                    <a href="/profil" class="bg-white text-gray-700 px-4 lg:px-6 py-3 rounded-2xl text-xs lg:text-sm font-semibold hover:bg-green-50 transition-colors shadow-sm flex items-center justify-center space-x-2">
                        <i class="bi bi-person"></i>
                        <span class="truncate">Profil</span>
                    </a>
                    <a href="/setor" class="bg-white text-gray-700 px-4 lg:px-6 py-3 rounded-2xl text-xs lg:text-sm font-semibold hover:bg-green-50 transition-colors shadow-sm flex items-center justify-center space-x-2">
                        <i class="bi bi-recycle"></i>
                        <span class="truncate">Setor</span>
                    </a>
                    <a href="/tukar-poin" class="bg-white text-gray-700 px-4 lg:px-6 py-3 rounded-2xl text-xs lg:text-sm font-semibold hover:bg-green-50 transition-colors shadow-sm flex items-center justify-center space-x-2">
                        <i class="bi bi-gift"></i>
                        <span class="truncate">Tukar Poin</span>
                    </a>
                    <a href="/riwayat" class="bg-green-500 text-white px-4 lg:px-6 py-3 rounded-2xl text-xs lg:text-sm font-semibold shadow-md flex items-center justify-center space-x-2">
                        <i class="bi bi-clock-history"></i>
                        <span class="truncate">Riwayat</span>
                    </a>
                    <a href="/notifikasi" class="bg-white text-gray-700 px-4 lg:px-6 py-3 rounded-2xl text-xs lg:text-sm font-semibold hover:bg-green-50 transition-colors shadow-sm flex items-center justify-center space-x-2">
                        <i class="bi bi-bell"></i>
                        <span class="truncate">Notifikasi</span>
                    </a>
                </div>
            </div>
        </div>
    </header>

    <!-- Main Content -->
    <main class="max-w-6xl mx-auto px-4 py-8">
        
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
        <div class="mb-6">
            <h2 class="text-2xl font-bold text-gray-800 mb-2">Riwayat Transaksi</h2>
            <p class="text-gray-600">Semua aktivitas setoran dan penukaran Anda</p>
        </div>

        <!-- Filter Section -->
        <div class="bg-white rounded-2xl p-6 shadow-sm mb-6">
            <form method="GET" action="{{ route('riwayat') }}">
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <!-- Filter by Type -->
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Jenis Transaksi</label>
                        <select name="type" class="w-full px-4 py-2 border-2 border-gray-200 rounded-lg focus:border-green-500 focus:outline-none">
                            <option value="">Semua</option>
                            <option value="deposit" {{ request('type') === 'deposit' ? 'selected' : '' }}>Setoran</option>
                            <option value="redemption" {{ request('type') === 'redemption' ? 'selected' : '' }}>Penukaran</option>
                        </select>
                    </div>

                    <!-- Filter by Status -->
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Status</label>
                        <select name="status" class="w-full px-4 py-2 border-2 border-gray-200 rounded-lg focus:border-green-500 focus:outline-none">
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
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Bulan</label>
                        <input type="month" name="month" value="{{ request('month') }}" class="w-full px-4 py-2 border-2 border-gray-200 rounded-lg focus:border-green-500 focus:outline-none">
                    </div>
                </div>

                <div class="mt-4 flex justify-end space-x-2">
                    <a href="{{ route('riwayat') }}" class="px-6 py-2 bg-gray-100 hover:bg-gray-200 text-gray-700 rounded-lg font-semibold transition-colors">
                        Reset
                    </a>
                    <button type="submit" class="px-6 py-2 bg-green-500 hover:bg-green-600 text-white rounded-lg font-semibold transition-colors">
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
                <a href="{{ route('riwayat.detail', ['id' => $transaction['id'], 'type' => $transaction['type']]) }}" class="block bg-white rounded-2xl p-5 shadow-sm border-2 border-gray-100 hover:shadow-lg hover:border-{{ $transaction['type'] === 'deposit' ? 'green' : 'blue' }}-300 transition-all duration-300 cursor-pointer">
                    <div class="flex items-center justify-between">
                        <!-- Left: Icon and Details -->
                        <div class="flex items-center space-x-4 flex-1">
                            <!-- Icon with Direction -->
                            <div class="w-14 h-14 bg-{{ $transaction['type'] === 'deposit' ? 'green' : 'blue' }}-100 rounded-xl flex items-center justify-center flex-shrink-0">
                                @if($transaction['type'] === 'deposit')
                                    <i class="bi bi-arrow-up-right text-green-600 text-2xl font-bold"></i>
                                @else
                                    <i class="bi bi-arrow-down-left text-blue-600 text-2xl font-bold"></i>
                                @endif
                            </div>
                            
                            <!-- Transaction Details -->
                            <div class="flex-1">
                                <h3 class="font-bold text-gray-800 text-base mb-2 flex items-center">
                                    <i class="bi bi-{{ $transaction['type'] === 'deposit' ? 'recycle' : 'gift' }} text-{{ $transaction['type'] === 'deposit' ? 'green' : 'blue' }}-600 mr-2"></i>
                                    {{ $transaction['title'] }}
                                </h3>
                                <p class="text-sm text-gray-600 mb-2">{{ $transaction['description'] }}</p>
                                <div class="flex items-center space-x-3 text-sm text-gray-500">
                                    <span class="flex items-center">
                                        <i class="bi bi-calendar3 mr-1 text-xs"></i>
                                        {{ $transaction['date']->format('d M Y, H:i') }}
                                    </span>
                                    @if(isset($transaction['weight']))
                                    <span class="flex items-center">
                                        <i class="bi bi-box-seam mr-1 text-xs"></i>
                                        {{ $transaction['weight'] }} kg
                                    </span>
                                    @endif
                                    
                                    <!-- Status Badge -->
                                    @if($transaction['status'] === 'verified' || $transaction['status'] === 'completed')
                                        <span class="px-3 py-1 bg-green-100 text-green-700 rounded-full text-xs font-semibold flex items-center gap-1">
                                            <i class="bi bi-check-circle-fill"></i>
                                            Selesai
                                        </span>
                                    @elseif($transaction['status'] === 'confirmed')
                                        <span class="px-3 py-1 bg-blue-100 text-blue-700 rounded-full text-xs font-semibold flex items-center gap-1">
                                            <i class="bi bi-check-circle"></i>
                                            Siap Ambil
                                        </span>
                                    @elseif($transaction['status'] === 'pending')
                                        <span class="px-3 py-1 bg-yellow-100 text-yellow-700 rounded-full text-xs font-semibold flex items-center gap-1">
                                            <i class="bi bi-clock"></i>
                                            Menunggu
                                        </span>
                                    @elseif($transaction['status'] === 'rejected')
                                        <span class="px-3 py-1 bg-red-100 text-red-700 rounded-full text-xs font-semibold flex items-center gap-1">
                                            <i class="bi bi-x-circle"></i>
                                            Ditolak
                                        </span>
                                    @elseif($transaction['status'] === 'cancelled')
                                        <span class="px-3 py-1 bg-gray-100 text-gray-700 rounded-full text-xs font-semibold flex items-center gap-1">
                                            <i class="bi bi-slash-circle"></i>
                                            Dibatalkan
                                        </span>
                                    @else
                                        <span class="px-3 py-1 bg-gray-100 text-gray-700 rounded-full text-xs font-semibold">
                                            Unknown
                                        </span>
                                    @endif
                                </div>
                            </div>
                        </div>

                        <!-- Right: Points -->
                        <div class="text-right ml-4">
                            <p class="text-xl font-bold {{ $transaction['points'] > 0 ? 'text-green-600' : 'text-red-600' }} flex items-center justify-end mb-1">
                                {{ $transaction['points'] > 0 ? '+' : '' }}{{ number_format($transaction['points'], 0, ',', '.') }}
                                <i class="bi bi-coin text-{{ $transaction['points'] > 0 ? 'green' : 'red' }}-500 ml-1 text-lg"></i>
                            </p>
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
