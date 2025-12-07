<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center gap-3">
            <a href="{{ route('eco.news.index') }}" class="text-gray-600 hover:text-gray-800 transition-colors">
                <i class="bi bi-arrow-left-circle text-2xl"></i>
            </a>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                <i class="bi bi-search text-green-600 mr-2"></i>
                {{ __('Cari Berita Lingkungan') }}
            </h2>
        </div>
    </x-slot>

    <!-- Navigation Tabs -->
    <div class="bg-green-100 px-4 py-4">
        <div class="max-w-6xl mx-auto">
            <div class="grid grid-cols-2 sm:grid-cols-4 lg:grid-cols-8 gap-3">
                <a href="/dashboard" class="bg-white text-gray-700 px-4 lg:px-6 py-3 rounded-2xl text-xs lg:text-sm font-semibold hover:bg-green-50 transition-colors shadow-sm flex items-center justify-center space-x-2">
                    <i class="bi bi-house-door pointer-events-none"></i>
                    <span class="truncate pointer-events-none">Dashboard</span>
                </a>
                <a href="/profil" class="bg-white text-gray-700 px-4 lg:px-6 py-3 rounded-2xl text-xs lg:text-sm font-semibold hover:bg-green-50 transition-colors shadow-sm flex items-center justify-center space-x-2">
                    <i class="bi bi-person pointer-events-none"></i>
                    <span class="truncate pointer-events-none">Profil</span>
                </a>
                <a href="/setor" class="bg-white text-gray-700 px-4 lg:px-6 py-3 rounded-2xl text-xs lg:text-sm font-semibold hover:bg-green-50 transition-colors shadow-sm flex items-center justify-center space-x-2">
                    <i class="bi bi-recycle pointer-events-none"></i>
                    <span class="truncate pointer-events-none">Setor</span>
                </a>
                <a href="/tukar-poin" class="bg-white text-gray-700 px-4 lg:px-6 py-3 rounded-2xl text-xs lg:text-sm font-semibold hover:bg-green-50 transition-colors shadow-sm flex items-center justify-center space-x-2">
                    <i class="bi bi-gift pointer-events-none"></i>
                    <span class="truncate pointer-events-none">Tukar Poin</span>
                </a>
                <a href="/eco-news" class="bg-gradient-to-r from-green-500 to-emerald-600 text-white px-4 lg:px-6 py-3 rounded-2xl text-xs lg:text-sm font-semibold shadow-lg flex items-center justify-center space-x-2">
                    <i class="bi bi-newspaper pointer-events-none"></i>
                    <span class="truncate pointer-events-none">Eco News</span>
                </a>
                <a href="/lokasi" class="bg-white text-gray-700 px-4 lg:px-6 py-3 rounded-2xl text-xs lg:text-sm font-semibold hover:bg-green-50 transition-colors shadow-sm flex items-center justify-center space-x-2">
                    <i class="bi bi-geo-alt-fill pointer-events-none"></i>
                    <span class="truncate pointer-events-none">Lokasi</span>
                </a>
                <a href="/riwayat" class="bg-white text-gray-700 px-4 lg:px-6 py-3 rounded-2xl text-xs lg:text-sm font-semibold hover:bg-green-50 transition-colors shadow-sm flex items-center justify-center space-x-2">
                    <i class="bi bi-clock-history pointer-events-none"></i>
                    <span class="truncate pointer-events-none">Riwayat</span>
                </a>
                <a href="/notifikasi" class="bg-white text-gray-700 px-4 lg:px-6 py-3 rounded-2xl text-xs lg:text-sm font-semibold hover:bg-green-50 transition-colors shadow-sm flex items-center justify-center space-x-2">
                    <i class="bi bi-bell pointer-events-none"></i>
                    <span class="truncate pointer-events-none">Notifikasi</span>
                </a>
            </div>
        </div>
    </div>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            
            <!-- Search Form -->
            <div class="bg-white rounded-xl shadow-lg p-6 mb-8">
                <form method="GET" action="{{ route('eco.news.search') }}" class="flex gap-3">
                    <div class="flex-1">
                        <input 
                            type="text" 
                            name="q" 
                            value="{{ $keyword ?? '' }}"
                            placeholder="Cari berita lingkungan, iklim, energi terbarukan..." 
                            class="w-full px-4 py-3 border-2 border-gray-300 rounded-lg focus:border-green-500 focus:ring-2 focus:ring-green-200 transition-all outline-none"
                            autofocus
                        >
                    </div>
                    <button 
                        type="submit"
                        class="bg-green-600 hover:bg-green-700 text-white px-8 py-3 rounded-lg font-semibold transition-colors flex items-center gap-2 shadow-md hover:shadow-lg"
                    >
                        <i class="bi bi-search"></i>
                        Cari
                    </button>
                </form>

                @if(!empty($keyword))
                    <div class="mt-4 flex items-center justify-between">
                        <p class="text-sm text-gray-600">
                            Hasil pencarian untuk: <span class="font-semibold text-gray-800">"{{ $keyword }}"</span>
                        </p>
                        <a href="{{ route('eco.news.search') }}" class="text-sm text-green-600 hover:text-green-700 font-medium">
                            Reset Pencarian
                        </a>
                    </div>
                @endif
            </div>

            <!-- Error Messages -->
            @if(isset($error))
                <div class="mb-6 bg-red-50 border-l-4 border-red-400 p-4 rounded-lg">
                    <p class="text-sm text-red-700">{{ $error }}</p>
                </div>
            @endif

            <!-- Search Results -->
            @if(!empty($keyword))
                @if(isset($news) && count($news) > 0)
                    <!-- Results Count -->
                    <div class="mb-4">
                        <p class="text-gray-700 font-medium">
                            Ditemukan <span class="text-green-600 font-bold">{{ count($news) }}</span> berita
                        </p>
                    </div>

                    <!-- Results List -->
                    <div class="space-y-4">
                        @foreach($news as $item)
                            <div class="bg-white rounded-xl shadow-md hover:shadow-lg transition-shadow duration-300 overflow-hidden">
                                <div class="flex flex-col sm:flex-row">
                                    
                                    <!-- Thumbnail -->
                                    <div class="sm:w-48 h-48 sm:h-auto bg-gradient-to-r from-green-400 to-green-600 flex-shrink-0 overflow-hidden">
                                        @if(isset($item['thumbnail_url']) && !empty($item['thumbnail_url']))
                                            <img src="{{ $item['thumbnail_url'] }}" 
                                                 alt="{{ $item['title'] ?? 'News' }}" 
                                                 class="w-full h-full object-cover hover:scale-105 transition-transform duration-300"
                                                 onerror="this.onerror=null; this.parentElement.innerHTML='<div class=\'w-full h-full flex items-center justify-center\'><i class=\'bi bi-image text-white text-4xl opacity-50\'></i></div>';">
                                        @else
                                            <div class="w-full h-full flex items-center justify-center">
                                                <i class="bi bi-image text-white text-4xl opacity-50"></i>
                                            </div>
                                        @endif
                                    </div>

                                    <!-- Content -->
                                    <div class="flex-1 p-5">
                                        <!-- Category Badge -->
                                        @if(isset($item['category']))
                                            <span class="inline-block bg-green-100 text-green-800 text-xs px-2 py-1 rounded-full mb-2 font-semibold">
                                                {{ $item['category'] }}
                                            </span>
                                        @endif

                                        <!-- Title -->
                                        <h3 class="font-bold text-xl text-gray-800 mb-2 hover:text-green-600 transition-colors">
                                            <a href="{{ route('eco.news.show', $item['id']) }}">
                                                {{ $item['title'] ?? 'Untitled' }}
                                            </a>
                                        </h3>

                                        <!-- Summary -->
                                        <p class="text-gray-600 text-sm mb-3 line-clamp-2">
                                            {{ $item['summary'] ?? 'Tidak ada ringkasan tersedia.' }}
                                        </p>

                                        <!-- Meta Info -->
                                        <div class="flex flex-wrap items-center gap-3 text-xs text-gray-500 mb-3">
                                            @if(isset($item['author']))
                                                <span class="flex items-center gap-1">
                                                    <i class="bi bi-person-circle"></i>
                                                    {{ $item['author'] }}
                                                </span>
                                            @endif
                                            @if(isset($item['published_at']))
                                                <span class="flex items-center gap-1">
                                                    <i class="bi bi-calendar3"></i>
                                                    {{ \Carbon\Carbon::parse($item['published_at'])->format('d M Y') }}
                                                </span>
                                            @endif
                                        </div>

                                        <!-- Read More Button -->
                                        <a href="{{ route('eco.news.show', $item['id']) }}" 
                                           class="inline-flex items-center gap-2 text-green-600 hover:text-green-700 font-semibold transition-colors group text-sm">
                                            Baca Selengkapnya 
                                            <i class="bi bi-arrow-right group-hover:translate-x-1 transition-transform"></i>
                                        </a>
                                    </div>

                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <!-- No Results -->
                    <div class="bg-white rounded-xl shadow-md p-12 text-center">
                        <i class="bi bi-search text-gray-400 text-6xl mb-4"></i>
                        <h3 class="text-xl font-semibold text-gray-700 mb-2">Tidak Ada Hasil</h3>
                        <p class="text-gray-500 mb-4">Tidak ditemukan berita dengan kata kunci "{{ $keyword }}"</p>
                        <a href="{{ route('eco.news.search') }}" 
                           class="inline-flex items-center gap-2 text-green-600 hover:text-green-700 font-semibold">
                            <i class="bi bi-arrow-left"></i>
                            Coba Kata Kunci Lain
                        </a>
                    </div>
                @endif
            @else
                <!-- Search Suggestions -->
                <div class="bg-white rounded-xl shadow-md p-8">
                    <h3 class="text-lg font-semibold text-gray-800 mb-4">
                        <i class="bi bi-lightbulb text-yellow-500 mr-2"></i>
                        Saran Pencarian
                    </h3>
                    <div class="grid grid-cols-2 md:grid-cols-4 gap-3">
                        @php
                            $suggestions = ['Perubahan Iklim', 'Energi Terbarukan', 'Daur Ulang', 'Hutan', 'Polusi', 'Konservasi', 'Sampah Plastik', 'Keberlanjutan'];
                        @endphp
                        @foreach($suggestions as $suggestion)
                            <a href="{{ route('eco.news.search', ['q' => $suggestion]) }}" 
                               class="bg-green-50 hover:bg-green-100 text-green-700 px-4 py-2 rounded-lg text-center font-medium transition-colors">
                                {{ $suggestion }}
                            </a>
                        @endforeach
                    </div>
                </div>
            @endif

        </div>
    </div>

    <!-- Bootstrap Icons CDN -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
</x-app-layout>
