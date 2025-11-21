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
                            <span class="font-bold text-green-700 text-base">{{ number_format(Auth::user()->balance_points ?? 0, 0, ',', '.') }}</span>
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

                    <!-- Notification Bell -->
                    <a href="/notifikasi" class="relative w-11 h-11 bg-gradient-to-br from-blue-500 to-blue-600 rounded-xl flex items-center justify-center shadow-lg">
                        <i class="bi bi-bell-fill text-white text-lg lg:text-xl"></i>
                        @if(isset($unreadNotifications) && $unreadNotifications > 0)
                        <span class="absolute -top-1.5 -right-1.5 bg-gradient-to-br from-red-500 to-red-600 text-white text-xs font-bold rounded-full w-5 h-5 lg:w-6 lg:h-6 flex items-center justify-center ring-2 ring-white shadow-md">
                            {{ $unreadNotifications > 9 ? '9+' : $unreadNotifications }}
                        </span>
                        @endif
                    </a>

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
                    <a href="/riwayat" class="bg-white text-gray-700 px-3 lg:px-6 py-3 rounded-2xl text-xs lg:text-sm font-semibold hover:bg-green-50 transition-all shadow-sm flex items-center justify-center space-x-2">
                        <i class="bi bi-clock-history"></i>
                        <span class="truncate hidden sm:inline">Riwayat</span>
                    </a>
                    <a href="/notifikasi" class="relative bg-gradient-to-r from-blue-500 to-blue-600 text-white px-3 lg:px-6 py-3 rounded-2xl text-xs lg:text-sm font-bold shadow-lg flex items-center justify-center space-x-2">
                        <i class="bi bi-bell-fill"></i>
                        <span class="truncate hidden sm:inline">Notifikasi</span>
                        @if(isset($unreadNotifications) && $unreadNotifications > 0)
                        <span class="absolute -top-1 -right-1 bg-gradient-to-br from-red-500 to-red-600 text-white text-xs font-bold rounded-full w-5 h-5 flex items-center justify-center ring-2 ring-white shadow-md">
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
        
        <!-- Page Title -->
        <div class="mb-6 lg:mb-8">
            <div class="flex items-center justify-between mb-4">
                <div class="flex items-center gap-3">
                    <div class="w-12 h-12 bg-gradient-to-br from-blue-100 to-blue-50 rounded-2xl flex items-center justify-center border-2 border-blue-200">
                        <i class="bi bi-bell-fill text-blue-600 text-2xl"></i>
                    </div>
                    <div>
                        <h2 class="text-2xl lg:text-3xl font-bold text-gray-800">Notifikasi</h2>
                        <p class="text-sm lg:text-base text-gray-600">Pantau aktivitas dan pembaruan akun Anda</p>
                    </div>
                </div>
                @if(!$notifications->isEmpty() && $unreadNotifications > 0)
                <div class="hidden sm:flex items-center gap-2 bg-blue-50 px-4 py-2 rounded-xl border border-blue-200">
                    <div class="w-2 h-2 bg-blue-500 rounded-full animate-pulse"></div>
                    <span class="text-sm font-bold text-blue-700">{{ $unreadNotifications }} Baru</span>
                </div>
                @endif
            </div>
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
                <div class="bg-white rounded-3xl p-5 lg:p-6 shadow-lg hover:shadow-xl border border-gray-100 transition-all duration-200 group {{ $notif->read_at ? 'opacity-70' : '' }}">
                    <div class="flex items-start gap-4">
                        <!-- Icon Badge -->
                        <div class="w-12 h-12 lg:w-14 lg:h-14 rounded-2xl flex items-center justify-center flex-shrink-0 border-2 group-hover:scale-110 transition-transform
                            @if($notif->data['type'] == 'success') bg-gradient-to-br from-green-100 to-green-50 border-green-200
                            @elseif($notif->data['type'] == 'info') bg-gradient-to-br from-blue-100 to-blue-50 border-blue-200
                            @elseif($notif->data['type'] == 'warning') bg-gradient-to-br from-yellow-100 to-yellow-50 border-yellow-200
                            @else bg-gradient-to-br from-gray-100 to-gray-50 border-gray-200
                            @endif">
                            @if(isset($notif->data['icon']))
                                <i class="bi bi-{{ $notif->data['icon'] }} text-2xl
                                    @if($notif->data['type'] == 'success') text-green-600
                                    @elseif($notif->data['type'] == 'info') text-blue-600
                                    @elseif($notif->data['type'] == 'warning') text-yellow-600
                                    @else text-gray-600
                                    @endif"></i>
                            @else
                                <i class="bi bi-bell-fill text-2xl text-gray-600"></i>
                            @endif
                        </div>
                        
                        <!-- Content -->
                        <div class="flex-1">
                            <div class="flex items-start justify-between mb-2 gap-3">
                                <h3 class="font-bold text-gray-800 text-base lg:text-lg">
                                    {{ $notif->data['title'] ?? 'Notifikasi' }}
                                </h3>
                                @if(!$notif->read_at)
                                <span class="bg-gradient-to-r from-blue-100 to-blue-50 text-blue-700 text-xs font-bold px-3 py-1.5 rounded-lg border border-blue-200 flex items-center gap-1">
                                    <div class="w-1.5 h-1.5 bg-blue-500 rounded-full"></div>
                                    Baru
                                </span>
                                @endif
                            </div>
                            <p class="text-sm lg:text-base text-gray-600 mb-3 leading-relaxed">{{ $notif->data['message'] ?? 'Pesan notifikasi' }}</p>
                            <div class="flex items-center gap-2 text-xs lg:text-sm text-gray-500 bg-gray-50 px-3 py-2 rounded-lg w-fit">
                                <i class="bi bi-clock"></i>
                                <span>{{ $notif->created_at->diffForHumans() }}</span>
                            </div>
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
