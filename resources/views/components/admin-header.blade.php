@props(['activePage' => ''])

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
                    <button @click="open = !open; console.log('Bell clicked, open:', open)" class="relative w-12 h-12 bg-gray-100 hover:bg-gray-200 rounded-xl flex items-center justify-center transition-all">
                        <i class="bi bi-bell text-gray-700 text-xl"></i>
                        
                        @php
                            $unreadCount = Auth::user()->unreadNotifications->count();
                        @endphp
                        
                        @if($unreadCount > 0)
                        <span class="absolute -top-1 -right-1 w-6 h-6 bg-red-500 text-white text-xs font-bold rounded-full flex items-center justify-center shadow-lg animate-pulse">
                            {{ $unreadCount > 9 ? '9+' : $unreadCount }}
                        </span>
                        @endif
                    </button>

                    <!-- Dropdown Notifikasi - Fixed z-index -->
                    <div x-show="open" 
                         x-transition:enter="transition ease-out duration-200"
                         x-transition:enter-start="opacity-0 transform scale-95"
                         x-transition:enter-end="opacity-100 transform scale-100"
                         x-transition:leave="transition ease-in duration-150"
                         x-transition:leave-start="opacity-100 transform scale-100"
                         x-transition:leave-end="opacity-0 transform scale-95"
                         class="absolute right-0 mt-2 w-80 bg-white rounded-2xl shadow-2xl border-2 border-gray-100 overflow-hidden z-[9999]"
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
                                <div @click="$dispatch('notification-read', '{{ $notification->id }}')" 
                                   class="block px-4 py-3 hover:bg-gray-50 transition-colors border-b border-gray-100 cursor-pointer {{ $notification->read_at ? 'bg-white' : 'bg-blue-50' }}">
                                    <div class="flex items-start gap-3">
                                        <!-- Icon -->
                                        <div class="flex-shrink-0 w-10 h-10 rounded-full flex items-center justify-center
                                            {{ isset($notification->data['type']) && $notification->data['type'] == 'deposit' ? 'bg-blue-100' : (isset($notification->data['type']) && $notification->data['type'] == 'redemption' ? 'bg-teal-100' : 'bg-green-100') }}">
                                            @if(isset($notification->data['type']) && $notification->data['type'] == 'deposit')
                                                <i class="bi bi-box-seam text-blue-600"></i>
                                            @elseif(isset($notification->data['type']) && $notification->data['type'] == 'redemption')
                                                <i class="bi bi-gift text-teal-600"></i>
                                            @else
                                                <i class="bi bi-bell text-gray-600"></i>
                                            @endif
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
                                </div>
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
                            <a href="{{ route('notifikasi') }}" class="text-sm text-green-600 hover:text-green-700 font-semibold block text-center">
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
                <a href="{{ route('admin.dashboard') }}" 
                   class="{{ $activePage == 'dashboard' ? 'bg-green-500 text-white shadow-md' : 'bg-white text-gray-700 hover:bg-green-50 shadow-sm' }} px-4 lg:px-6 py-3 rounded-2xl text-xs lg:text-sm font-semibold transition-colors flex items-center justify-center space-x-2 w-full">
                    <i class="bi bi-house-door"></i>
                    <span class="truncate">Dashboard</span>
                </a>
                <a href="{{ route('admin.setoran.index') }}" 
                   class="{{ $activePage == 'setoran' ? 'bg-green-500 text-white shadow-md' : 'bg-white text-gray-700 hover:bg-green-50 shadow-sm' }} px-4 lg:px-6 py-3 rounded-2xl text-xs lg:text-sm font-semibold transition-colors flex items-center justify-center space-x-2 w-full">
                    <i class="bi bi-graph-up"></i>
                    <span class="truncate">Setoran</span>
                </a>
                <a href="{{ route('admin.penukaran.index') }}" 
                   class="{{ $activePage == 'penukaran' ? 'bg-green-500 text-white shadow-md' : 'bg-white text-gray-700 hover:bg-green-50 shadow-sm' }} px-4 lg:px-6 py-3 rounded-2xl text-xs lg:text-sm font-semibold transition-colors flex items-center justify-center space-x-2 w-full">
                    <i class="bi bi-arrow-left-right"></i>
                    <span class="truncate">Penukaran</span>
                </a>
                <a href="{{ route('admin.reward-items.index') }}" 
                   class="{{ $activePage == 'reward-items' ? 'bg-green-500 text-white shadow-md' : 'bg-white text-gray-700 hover:bg-green-50 shadow-sm' }} px-4 lg:px-6 py-3 rounded-2xl text-xs lg:text-sm font-semibold transition-colors flex items-center justify-center space-x-2 w-full">
                    <i class="bi bi-gift"></i>
                    <span class="truncate">Tukar Barang</span>
                </a>
                <a href="{{ route('admin.waste-types.index') }}" 
                   class="{{ $activePage == 'waste-types' ? 'bg-green-500 text-white shadow-md' : 'bg-white text-gray-700 hover:bg-green-50 shadow-sm' }} px-4 lg:px-6 py-3 rounded-2xl text-xs lg:text-sm font-semibold transition-colors flex items-center justify-center space-x-2 w-full">
                    <i class="bi bi-recycle"></i>
                    <span class="truncate">Jenis Sampah</span>
                </a>
                <a href="{{ route('admin.laporan.index') }}" 
                   class="{{ $activePage == 'laporan' ? 'bg-green-500 text-white shadow-md' : 'bg-white text-gray-700 hover:bg-green-50 shadow-sm' }} px-4 lg:px-6 py-3 rounded-2xl text-xs lg:text-sm font-semibold transition-colors flex items-center justify-center space-x-2 w-full">
                    <i class="bi bi-file-earmark-text"></i>
                    <span class="truncate">Laporan</span>
                </a>
            </div>
        </div>
    </div>
</header>
