<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center gap-3">
            <a href="{{ route('eco.news.index') }}" class="text-gray-600 hover:text-gray-800 transition-colors">
                <i class="bi bi-arrow-left-circle text-2xl"></i>
            </a>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                <i class="bi bi-newspaper text-green-600 mr-2"></i>
                {{ __('Detail Berita') }}
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
            </div>
        </div>
    </div>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            
            <div class="bg-white rounded-xl shadow-lg overflow-hidden">
                
                <!-- Featured Image -->
                @if(isset($news['thumbnail_url']) && !empty($news['thumbnail_url']))
                    @php
                        // Build full URL for thumbnail
                        $thumbnailUrl = $news['thumbnail_url'];
                        // If not already a full URL, prepend EcoProvider storage URL
                        if (!str_starts_with($thumbnailUrl, 'http')) {
                            $thumbnailUrl = 'http://localhost:8001/storage/' . $thumbnailUrl;
                        }
                    @endphp
                    <div class="h-96 bg-gradient-to-r from-green-400 to-green-600 overflow-hidden">
                        <img src="{{ $thumbnailUrl }}" 
                             alt="{{ $news['title'] ?? 'News' }}" 
                             class="w-full h-full object-cover"
                             onerror="this.onerror=null; this.src='data:image/svg+xml,%3Csvg xmlns=%22http://www.w3.org/2000/svg%22 width=%22800%22 height=%22400%22%3E%3Crect fill=%2310b981%22 width=%22800%22 height=%22400%22/%3E%3Ctext fill=%22white%22 font-size=%2232%22 x=%2250%25%22 y=%2250%25%22 text-anchor=%22middle%22 dy=%22.3em%22%3EEco News%3C/text%3E%3C/svg%3E';">
                    </div>
                @endif

                <!-- Article Content -->
                <div class="p-8">
                    
                    <!-- Category Badge -->
                    @if(isset($news['category']))
                        <span class="inline-block bg-green-100 text-green-800 text-sm px-3 py-1 rounded-full mb-4 font-semibold">
                            {{ $news['category'] }}
                        </span>
                    @endif

                    <!-- Title -->
                    <h1 class="text-4xl font-bold text-gray-900 mb-4 leading-tight">
                        {{ $news['title'] ?? 'Untitled' }}
                    </h1>

                    <!-- Meta Information -->
                    <div class="flex flex-wrap items-center gap-4 text-sm text-gray-600 pb-6 mb-6 border-b border-gray-200">
                        @if(isset($news['author']))
                            <div class="flex items-center gap-2">
                                <i class="bi bi-person-circle text-lg"></i>
                                <span class="font-medium">{{ $news['author'] }}</span>
                            </div>
                        @endif
                        
                        @if(isset($news['published_at']))
                            <div class="flex items-center gap-2">
                                <i class="bi bi-calendar3 text-lg"></i>
                                <span>{{ \Carbon\Carbon::parse($news['published_at'])->format('d F Y, H:i') }}</span>
                            </div>
                        @endif

                        @if(isset($news['source']))
                            <div class="flex items-center gap-2">
                                <i class="bi bi-link-45deg text-lg"></i>
                                <span>{{ $news['source'] }}</span>
                            </div>
                        @endif
                    </div>

                    <!-- Summary/Lead -->
                    @if(isset($news['summary']))
                        <div class="bg-green-50 border-l-4 border-green-500 p-4 mb-6 rounded">
                            <p class="text-lg text-gray-700 italic leading-relaxed">
                                {{ $news['summary'] }}
                            </p>
                        </div>
                    @endif

                    <!-- Main Content -->
                    <div class="prose prose-lg max-w-none">
                        @if(isset($news['content']))
                            <div class="text-gray-800 leading-relaxed whitespace-pre-line">
                                {{ $news['content'] }}
                            </div>
                        @else
                            <p class="text-gray-500 italic">Konten tidak tersedia.</p>
                        @endif
                    </div>

                    <!-- Tags -->
                    @if(isset($news['tags']) && is_array($news['tags']) && count($news['tags']) > 0)
                        <div class="mt-8 pt-6 border-t border-gray-200">
                            <h3 class="text-sm font-semibold text-gray-700 mb-3">Tags:</h3>
                            <div class="flex flex-wrap gap-2">
                                @foreach($news['tags'] as $tag)
                                    <span class="bg-gray-100 text-gray-700 px-3 py-1 rounded-full text-sm">
                                        #{{ $tag }}
                                    </span>
                                @endforeach
                            </div>
                        </div>
                    @endif

                    <!-- Source URL -->
                    @if(isset($news['source_url']) && !empty($news['source_url']))
                        <div class="mt-6 p-4 bg-gray-50 rounded-lg">
                            <p class="text-sm text-gray-600 mb-2">Sumber Berita:</p>
                            <a href="{{ $news['source_url'] }}" 
                               target="_blank" 
                               rel="noopener noreferrer"
                               class="text-green-600 hover:text-green-700 font-medium flex items-center gap-2">
                                {{ $news['source_url'] }}
                                <i class="bi bi-box-arrow-up-right"></i>
                            </a>
                        </div>
                    @endif

                    <!-- Action Buttons -->
                    <div class="mt-8 flex gap-3">
                        <a href="{{ route('eco.news.index') }}" 
                           class="bg-gray-100 hover:bg-gray-200 text-gray-700 px-6 py-3 rounded-lg font-semibold transition-colors flex items-center gap-2">
                            <i class="bi bi-arrow-left"></i>
                            Kembali ke Daftar Berita
                        </a>
                        
                        <button onclick="window.print()" 
                                class="bg-green-600 hover:bg-green-700 text-white px-6 py-3 rounded-lg font-semibold transition-colors flex items-center gap-2">
                            <i class="bi bi-printer"></i>
                            Cetak
                        </button>
                    </div>

                </div>
            </div>

        </div>
    </div>

    <!-- Bootstrap Icons CDN -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
</x-app-layout>
