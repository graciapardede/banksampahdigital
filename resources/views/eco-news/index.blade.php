<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Eco News - Green Saving</title>
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
    <header class="bg-white shadow-sm">
        <div class="max-w-6xl mx-auto px-4 py-6">
            <div class="flex justify-between items-center">
                <!-- Logo -->
                <div class="flex items-center space-x-3">
                    <div class="w-16 h-16 bg-gradient-to-br from-green-500 to-green-600 rounded-2xl flex items-center justify-center shadow-lg">
                        <i class="bi bi-recycle text-white text-3xl"></i>
                    </div>
                    <div>
                        <h1 class="font-bold text-2xl text-gray-800">Green Saving</h1>
                        <p class="text-sm text-green-600">Halo, {{ Auth::check() ? Auth::user()->name : 'Guest' }}</p>
                    </div>
                </div>

                <!-- Points & Actions -->
                <div class="flex items-center space-x-3">
                    @auth
                    <!-- Points Display -->
                    <div class="bg-gradient-to-r from-green-100 to-green-50 px-8 py-3 rounded-full border-2 border-green-200 shadow-sm">
                        <div class="flex items-center space-x-2">
                            <i class="bi bi-coin text-green-600 text-2xl"></i>
                            <span class="font-bold text-green-700 text-xl">{{ number_format($saldoPoin ?? 0, 0, ',', '.') }} poin</span>
                        </div>
                    </div>

                    <!-- Cart Button -->
                    <a href="{{ route('cart.index') }}" class="relative w-14 h-14 bg-gradient-to-br from-green-500 to-green-600 rounded-full flex items-center justify-center shadow-lg hover:shadow-xl transition-all hover:scale-105">
                        <i class="bi bi-cart3 text-white text-xl"></i>
                        @if(session('cart') && count(session('cart')) > 0)
                            <span class="absolute -top-2 -right-2 bg-red-500 text-white text-xs font-bold rounded-full w-6 h-6 flex items-center justify-center animate-pulse">
                                {{ count(session('cart')) }}
                            </span>
                        @endif
                    </a>

                    <!-- Profile Button -->
                    <a href="/profil" class="w-14 h-14 bg-gradient-to-br from-green-500 to-green-600 rounded-full flex items-center justify-center transition-all hover:scale-105 overflow-hidden shadow-lg">
                        @if(Auth::user()->profile_photo)
                            <img src="/{{ Auth::user()->profile_photo }}" alt="Profile" class="w-full h-full object-cover">
                        @else
                            <i class="bi bi-person-fill text-white text-2xl"></i>
                        @endif
                    </a>

                    <!-- Logout Button -->
                    <form method="POST" action="/logout" class="inline">
                        @csrf
                        <button type="submit" class="w-14 h-14 bg-red-100 hover:bg-red-200 rounded-full flex items-center justify-center transition-all hover:scale-105 shadow-lg">
                            <i class="bi bi-box-arrow-right text-red-600 text-2xl"></i>
                        </button>
                    </form>
                    @else
                    <!-- Guest Actions -->
                    <a href="{{ route('login') }}" class="bg-white border-2 border-green-600 text-green-600 hover:bg-green-50 px-6 py-2 rounded-full font-semibold transition-all">
                        Masuk
                    </a>
                    <a href="{{ route('register') }}" class="bg-gradient-to-r from-green-500 to-green-600 hover:from-green-600 hover:to-green-700 text-white px-6 py-2 rounded-full font-semibold transition-all shadow-md">
                        Daftar
                    </a>
                    @endauth
                </div>
            </div>
        </div>

        <!-- Navigation Tabs -->
        <div class="bg-green-100 px-4 py-4">
            <div class="max-w-6xl mx-auto">
                <div class="grid grid-cols-2 sm:grid-cols-4 lg:grid-cols-8 gap-3">
                    <a href="/dashboard" class="bg-white text-gray-700 px-2 lg:px-4 py-3 rounded-2xl text-xs lg:text-sm font-semibold hover:bg-green-50 transition-colors shadow-sm flex items-center justify-center gap-1 lg:gap-2 w-full cursor-pointer">
                        <i class="bi bi-house-door pointer-events-none text-sm lg:text-base"></i>
                        <span class="hidden lg:inline pointer-events-none">Dashboard</span>
                        <span class="lg:hidden pointer-events-none">Dashb</span>
                    </a>
                    <a href="/profil" class="bg-white text-gray-700 px-2 lg:px-4 py-3 rounded-2xl text-xs lg:text-sm font-semibold hover:bg-green-50 transition-colors shadow-sm flex items-center justify-center gap-1 lg:gap-2 w-full cursor-pointer">
                        <i class="bi bi-person pointer-events-none text-sm lg:text-base"></i>
                        <span class="pointer-events-none">Profil</span>
                    </a>
                    <a href="/setor" class="bg-white text-gray-700 px-2 lg:px-4 py-3 rounded-2xl text-xs lg:text-sm font-semibold hover:bg-green-50 transition-colors shadow-sm flex items-center justify-center gap-1 lg:gap-2 w-full cursor-pointer">
                        <i class="bi bi-recycle pointer-events-none text-sm lg:text-base"></i>
                        <span class="pointer-events-none">Setor</span>
                    </a>
                    <a href="/tukar-poin" class="bg-white text-gray-700 px-2 lg:px-4 py-3 rounded-2xl text-xs lg:text-sm font-semibold hover:bg-green-50 transition-colors shadow-sm flex items-center justify-center gap-1 lg:gap-2 w-full cursor-pointer">
                        <i class="bi bi-gift pointer-events-none text-sm lg:text-base"></i>
                        <span class="hidden lg:inline pointer-events-none">Tukar Poin</span>
                        <span class="lg:hidden pointer-events-none">Tukar</span>
                    </a>
                    <a href="/eco-news" class="bg-green-500 text-white px-2 lg:px-4 py-3 rounded-2xl text-xs lg:text-sm font-semibold shadow-md flex items-center justify-center gap-1 lg:gap-2 w-full cursor-default">
                        <i class="bi bi-newspaper pointer-events-none text-sm lg:text-base"></i>
                        <span class="hidden lg:inline pointer-events-none">Eco News</span>
                        <span class="lg:hidden pointer-events-none">Eco</span>
                    </a>
                    <a href="/lokasi" class="bg-white text-gray-700 px-2 lg:px-4 py-3 rounded-2xl text-xs lg:text-sm font-semibold hover:bg-green-50 transition-colors shadow-sm flex items-center justify-center gap-1 lg:gap-2 w-full cursor-pointer">
                        <i class="bi bi-geo-alt-fill pointer-events-none text-sm lg:text-base"></i>
                        <span class="pointer-events-none">Lokasi</span>
                    </a>
                    <a href="/riwayat" class="bg-white text-gray-700 px-2 lg:px-4 py-3 rounded-2xl text-xs lg:text-sm font-semibold hover:bg-green-50 transition-colors shadow-sm flex items-center justify-center gap-1 lg:gap-2 w-full cursor-pointer">
                        <i class="bi bi-clock-history pointer-events-none text-sm lg:text-base"></i>
                        <span class="pointer-events-none">Riwayat</span>
                    </a>
                    <a href="/notifikasi" class="bg-white text-gray-700 px-2 lg:px-4 py-3 rounded-2xl text-xs lg:text-sm font-semibold hover:bg-green-50 transition-colors shadow-sm flex items-center justify-center gap-1 lg:gap-2 w-full cursor-pointer">
                        <i class="bi bi-bell pointer-events-none text-sm lg:text-base"></i>
                        <span class="hidden lg:inline pointer-events-none">Notifikasi</span>
                        <span class="lg:hidden pointer-events-none">Notif</span>
                    </a>
                </div>
            </div>
        </div>
    </header>

    <!-- Main Content -->
    <div class="py-8">
        <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
            
            <!-- Page Title & Search Button -->
            <div class="mb-8 flex justify-between items-center">
                <div>
                    <h2 class="text-2xl font-bold text-gray-800">Berita Lingkungan Terkini</h2>
                    <p class="text-gray-600 mt-1">Baca informasi seputar lingkungan hidup dan keberlanjutan</p>
                </div>
                <a href="{{ route('eco.news.search') }}" class="bg-gradient-to-r from-green-500 to-green-600 hover:from-green-600 hover:to-green-700 text-white px-6 py-3 rounded-2xl font-semibold transition-all shadow-lg hover:shadow-xl flex items-center gap-2">
                    <i class="bi bi-search"></i>
                    Cari Berita
                </a>
            </div>
            
            <!-- Alert jika provider down -->
            @if(!$isAvailable)
                <div class="mb-6 bg-yellow-50 border-l-4 border-yellow-400 p-5 rounded-2xl shadow-md">
                    <div class="flex">
                        <div class="flex-shrink-0">
                            <i class="bi bi-exclamation-triangle-fill text-yellow-500 text-2xl"></i>
                        </div>
                        <div class="ml-4">
                            <p class="text-sm text-yellow-800">
                                <strong class="font-bold">Perhatian!</strong> Layanan EcoProvider sedang tidak tersedia. Silakan coba lagi nanti.
                            </p>
                        </div>
                    </div>
                </div>
            @endif

            <!-- Success/Error Messages -->
            @if(session('success'))
                <div class="mb-6 bg-green-50 border-l-4 border-green-400 p-5 rounded-2xl shadow-md">
                    <p class="text-sm text-green-800 font-medium">{{ session('success') }}</p>
                </div>
            @endif

            @if(session('error'))
                <div class="mb-6 bg-red-50 border-l-4 border-red-400 p-5 rounded-2xl shadow-md">
                    <p class="text-sm text-red-800 font-medium">{{ session('error') }}</p>
                </div>
            @endif

            <!-- News Grid -->
            @if($isAvailable && count($news) > 0)
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    @foreach($news as $item)
                        <div class="bg-white rounded-2xl shadow-lg hover:shadow-xl transition-all duration-300 overflow-hidden group">
                            <!-- Thumbnail -->
                            <div class="h-52 bg-gradient-to-br from-green-400 to-green-600 overflow-hidden relative">
                                @if(isset($item['thumbnail_url']) && !empty($item['thumbnail_url']))
                                    @php
                                        // Clean URL - remove double prefix if exists
                                        $imageUrl = $item['thumbnail_url'];
                                        $imageUrl = str_replace('http://localhost:8001/storage/https://', 'https://', $imageUrl);
                                        $imageUrl = str_replace('http://localhost:8001/storage/http://', 'http://', $imageUrl);
                                    @endphp
                                    <img src="{{ $imageUrl }}" 
                                         alt="{{ $item['title'] ?? 'News' }}" 
                                         class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500"
                                         onerror="this.onerror=null; this.src='data:image/svg+xml,%3Csvg xmlns=%22http://www.w3.org/2000/svg%22 width=%22400%22 height=%22300%22%3E%3Crect fill=%2310b981%22 width=%22400%22 height=%22300%22/%3E%3Ctext fill=%22white%22 font-size=%2224%22 x=%2250%25%22 y=%2250%25%22 text-anchor=%22middle%22 dy=%22.3em%22%3EEco News%3C/text%3E%3C/svg%3E';">
                                @else
                                    <div class="w-full h-full flex items-center justify-center">
                                        <i class="bi bi-image text-white text-6xl opacity-40"></i>
                                    </div>
                                @endif
                                
                                <!-- Category Badge Overlay -->
                                @if(isset($item['category']))
                                    <div class="absolute top-3 left-3">
                                        <span class="bg-white/90 backdrop-blur-sm text-green-700 text-xs px-3 py-1.5 rounded-full font-bold shadow-md">
                                            {{ $item['category'] }}
                                        </span>
                                    </div>
                                @endif
                            </div>

                            <!-- Content -->
                            <div class="p-6">

                                <!-- Title -->
                                <h3 class="font-bold text-lg text-gray-800 mb-3 line-clamp-2 group-hover:text-green-600 transition-colors">
                                    {{ $item['title'] ?? 'Untitled' }}
                                </h3>

                                <!-- Excerpt/Summary -->
                                <p class="text-gray-600 text-sm mb-4 line-clamp-3 leading-relaxed">
                                    {{ $item['excerpt'] ?? $item['summary'] ?? 'Tidak ada ringkasan tersedia.' }}
                                </p>

                                <!-- Meta Info -->
                                <div class="flex items-center justify-between text-xs text-gray-500 mb-5 pt-4 border-t border-gray-100">
                                    @if(isset($item['author']))
                                        <span class="flex items-center gap-1.5">
                                            <i class="bi bi-person-circle text-green-600"></i>
                                            <span class="font-medium">{{ $item['author'] }}</span>
                                        </span>
                                    @endif
                                    @if(isset($item['published_at']))
                                        <span class="flex items-center gap-1.5">
                                            <i class="bi bi-calendar3 text-green-600"></i>
                                            <span>{{ \Carbon\Carbon::parse($item['published_at'])->format('d M Y') }}</span>
                                        </span>
                                    @endif
                                </div>

                                <!-- Read More Button -->
                                <a href="{{ route('eco.news.show', $item['id']) }}" 
                                   class="w-full inline-flex items-center justify-center gap-2 bg-gradient-to-r from-green-500 to-green-600 hover:from-green-600 hover:to-green-700 text-white px-4 py-2.5 rounded-xl font-semibold transition-all shadow-md hover:shadow-lg group/btn">
                                    Baca Selengkapnya 
                                    <i class="bi bi-arrow-right group-hover/btn:translate-x-1 transition-transform"></i>
                                </a>
                            </div>
                        </div>
                    @endforeach
                </div>
            @elseif($isAvailable && count($news) == 0)
                <!-- Empty State -->
                <div class="bg-white rounded-2xl shadow-lg p-16 text-center">
                    <div class="w-24 h-24 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-6">
                        <i class="bi bi-inbox text-gray-400 text-5xl"></i>
                    </div>
                    <h3 class="text-2xl font-bold text-gray-700 mb-3">Belum Ada Berita</h3>
                    <p class="text-gray-500 max-w-md mx-auto">Tidak ada berita yang tersedia saat ini. Silakan cek kembali nanti.</p>
                </div>
            @endif

        </div>
    </div>

</body>
</html>
