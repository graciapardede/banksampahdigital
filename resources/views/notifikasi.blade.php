<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Notifikasi - Green Saving</title>
    <script src="https://cdn.tailwindcss.com"></script>
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
<body class="min-h-screen bg-green-50 font-poppins">

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
                            <span class="font-bold text-green-700 text-lg">{{ number_format(Auth::user()->balance_points ?? 0, 0, ',', '.') }} poin</span>
                        </div>
                    </div>

                    <!-- Cart Button with Badge -->
                    <a href="{{ route('cart.index') }}" class="relative w-12 h-12 bg-gradient-to-br from-green-500 to-green-600 rounded-full flex items-center justify-center shadow-lg hover:shadow-xl transition-all">
                        <i class="bi bi-cart3 text-white text-xl"></i>
                        @if(session('cart') && count(session('cart')) > 0)
                            <span class="absolute -top-2 -right-2 bg-red-500 text-white text-xs font-bold rounded-full w-6 h-6 flex items-center justify-center animate-pulse">
                                {{ count(session('cart')) }}
                            </span>
                        @endif
                    </a>

                    <!-- Notification Bell -->
                    <a href="/notifikasi" class="relative w-12 h-12 bg-gray-100 hover:bg-gray-200 rounded-xl flex items-center justify-center transition-all">
                        <i class="bi bi-bell text-gray-700 text-xl"></i>
                        @if(isset($unreadNotifications) && $unreadNotifications > 0)
                        <span class="absolute -top-2 -right-2 bg-red-500 text-white text-xs font-bold rounded-full w-6 h-6 flex items-center justify-center animate-pulse">
                            {{ $unreadNotifications > 9 ? '9+' : $unreadNotifications }}
                        </span>
                        @endif
                    </a>

                    <!-- Profile Button -->
                    <a href="/profil" class="w-12 h-12 bg-green-500 hover:bg-green-600 rounded-full flex items-center justify-center transition-all overflow-hidden">
                        @if(Auth::user()->profile_photo)
                            <img src="/{{ Auth::user()->profile_photo }}" alt="Profile" class="w-full h-full object-cover">
                        @else
                            <i class="bi bi-person-fill text-white text-xl"></i>
                        @endif
                    </a>

                    <!-- Logout Button -->
                    <form method="POST" action="/logout" class="inline">
                        @csrf
                        <button type="submit" class="w-12 h-12 bg-red-100 hover:bg-red-200 rounded-full flex items-center justify-center transition-all">
                            <i class="bi bi-box-arrow-right text-red-600 text-xl"></i>
                        </button>
                    </form>
                </div>
            </div>
        </div>

        <!-- Navigation Tabs -->
        <div class="bg-green-100 px-4 py-4">
            <div class="max-w-6xl mx-auto flex justify-center">
                <div class="flex flex-wrap gap-3 justify-center">
                    <a href="/dashboard" class="bg-white text-gray-700 px-4 py-3 rounded-2xl text-xs lg:text-sm font-semibold hover:bg-green-50 transition-colors shadow-sm flex items-center justify-center gap-2 cursor-pointer whitespace-nowrap">
                        <i class="bi bi-house-door pointer-events-none text-base"></i>
                        <span class="pointer-events-none">Dashboard</span>
                    </a>
                    <a href="/profil" class="bg-white text-gray-700 px-4 py-3 rounded-2xl text-xs lg:text-sm font-semibold hover:bg-green-50 transition-colors shadow-sm flex items-center justify-center gap-2 cursor-pointer whitespace-nowrap">
                        <i class="bi bi-person pointer-events-none text-base"></i>
                        <span class="pointer-events-none">Profil</span>
                    </a>
                    <a href="/setor" class="bg-white text-gray-700 px-4 py-3 rounded-2xl text-xs lg:text-sm font-semibold hover:bg-green-50 transition-colors shadow-sm flex items-center justify-center gap-2 cursor-pointer whitespace-nowrap">
                        <i class="bi bi-recycle pointer-events-none text-base"></i>
                        <span class="pointer-events-none">Setor</span>
                    </a>
                    <a href="/tukar-poin" class="bg-white text-gray-700 px-4 py-3 rounded-2xl text-xs lg:text-sm font-semibold hover:bg-green-50 transition-colors shadow-sm flex items-center justify-center gap-2 cursor-pointer whitespace-nowrap">
                        <i class="bi bi-gift pointer-events-none text-base"></i>
                        <span class="pointer-events-none">Tukar Poin</span>
                    </a>
                    <a href="/eco-news" class="bg-white text-gray-700 px-4 py-3 rounded-2xl text-xs lg:text-sm font-semibold hover:bg-green-50 transition-colors shadow-sm flex items-center justify-center gap-2 cursor-pointer whitespace-nowrap">
                        <i class="bi bi-newspaper pointer-events-none text-base"></i>
                        <span class="pointer-events-none">Eco News</span>
                    </a>
                    <a href="/lokasi" class="bg-white text-gray-700 px-4 py-3 rounded-2xl text-xs lg:text-sm font-semibold hover:bg-green-50 transition-colors shadow-sm flex items-center justify-center gap-2 cursor-pointer whitespace-nowrap">
                        <i class="bi bi-geo-alt-fill pointer-events-none text-base"></i>
                        <span class="pointer-events-none">Lokasi</span>
                    </a>
                    <a href="/riwayat" class="bg-white text-gray-700 px-4 py-3 rounded-2xl text-xs lg:text-sm font-semibold hover:bg-green-50 transition-colors shadow-sm flex items-center justify-center gap-2 cursor-pointer whitespace-nowrap">
                        <i class="bi bi-clock-history pointer-events-none text-base"></i>
                        <span class="pointer-events-none">Riwayat</span>
                    </a>
                </div>
            </div>
        </div>
    </header>

    <!-- Main Content -->
    <main class="max-w-6xl mx-auto px-4 py-8">
        
        <!-- Page Title -->
        <div class="mb-6">
            <h2 class="text-2xl font-bold text-gray-800 mb-2">Notifikasi</h2>
            <p class="text-gray-600">Pantau aktivitas dan pembaruan akun Anda</p>
        </div>

        <!-- Empty State or Notification List -->
        @if($notifications->isEmpty())
            <!-- Empty State -->
            <div class="flex flex-col items-center justify-center py-16 min-h-[400px]">
                <div class="w-32 h-32 bg-gray-100 rounded-full flex items-center justify-center mb-6">
                    <i class="bi bi-bell-slash text-gray-300 text-6xl"></i>
                </div>
                <h3 class="text-xl font-bold text-gray-700 mb-2">Belum ada notifikasi</h3>
                <p class="text-gray-500 text-center max-w-md mb-6">
                    Notifikasi tentang setoran sampah dan penukaran poin akan muncul di sini
                </p>
            </div>
        @else
            <!-- Notification List -->
            <div class="space-y-4">
                @foreach($notifications as $notif)
                <div class="bg-white rounded-xl p-4 shadow-md border-l-4 
                    @if($notif->data['type'] == 'success') border-green-500
                    @elseif($notif->data['type'] == 'info') border-blue-500
                    @elseif($notif->data['type'] == 'warning') border-yellow-500
                    @else border-gray-400
                    @endif
                    hover:shadow-lg transition-all">
                    <div class="flex items-start space-x-4">
                        <!-- Content -->
                        <div class="flex-1">
                            <div class="flex items-start justify-between mb-2">
                                <h3 class="font-bold text-gray-800 text-base">
                                    {{ $notif->data['title'] ?? 'Notifikasi' }}
                                </h3>
                                @if(!$notif->read_at)
                                <span class="bg-gradient-to-r from-green-400 to-green-500 text-white text-xs font-bold px-3 py-1 rounded-full shadow-sm">Baru</span>
                                @endif
                            </div>
                            <p class="text-gray-700 text-sm font-medium mb-2">{{ $notif->data['message'] ?? 'Pesan notifikasi' }}</p>
                            <span class="text-xs text-gray-500 font-medium">
                                <i class="bi bi-clock mr-1"></i>
                                {{ $notif->created_at->diffForHumans() }}
                            </span>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
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



</body>
</html>
