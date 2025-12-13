<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manajemen Jenis Sampah - Green Saving</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css" rel="stylesheet">
    <!-- CSS untuk line-clamp dan dropdown -->
    <style>
        .line-clamp-1 {
            display: -webkit-box;
            -webkit-line-clamp: 1;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }
        .line-clamp-2 {
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }
        
        /* Ensure notification dropdown appears on top */
        .notification-dropdown {
            position: fixed !important;
            z-index: 9999 !important;
        }
        
        /* Alpine.js transitions */
        [x-cloak] { display: none !important; }
    </style>
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
    <!-- Ensure Alpine.js is loaded for notifications -->
    <script>
        // Alpine.js notification functionality
        window.Alpine = window.Alpine || {};
        document.addEventListener('alpine:init', () => {
            console.log('Alpine.js initialized for notifications - Waste Types page');
        });
        
        // Additional debug for notification bell
        document.addEventListener('DOMContentLoaded', function() {
            console.log('DOM loaded - checking for notification bell...');
            setTimeout(() => {
                const bellButton = document.querySelector('[x-data*="open"]');
                if (bellButton) {
                    console.log('✅ Notification bell found!');
                } else {
                    console.log('❌ Notification bell not found!');
                }
            }, 1000);
            
            // Handle notification read events
            document.addEventListener('notification-read', function(event) {
                const notificationId = event.detail;
                console.log('Notification clicked:', notificationId);
                
                // Mark as read via AJAX (optional)
                fetch(`/admin/notifikasi/${notificationId}/read`, {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                        'Accept': 'application/json',
                        'Content-Type': 'application/json'
                    }
                }).then(response => {
                    if (response.ok) {
                        console.log('Notification marked as read');
                    }
                }).catch(error => {
                    console.log('Error marking notification as read:', error);
                });
                
                // Don't close popup immediately, let user see the content
            });
        });
    </script>
</head>
<body class="min-h-screen bg-gradient-to-br from-green-50 to-green-100 font-poppins">

    <!-- Header with Notification Popup -->
    @include('admin.partials.header', ['activePage' => 'waste-types'])

    <!-- Page Header with Actions -->
    <div class="max-w-6xl mx-auto px-4 py-6">
        <div class="bg-gradient-to-r from-lime-500 to-green-600 rounded-2xl shadow-lg p-6">
            <div class="flex flex-col md:flex-row md:justify-between md:items-center gap-4">
                <div class="text-white">
                    <div class="flex items-center gap-3 mb-2">
                        <div class="w-12 h-12 bg-white bg-opacity-20 backdrop-blur-sm rounded-xl flex items-center justify-center">
                            <i class="bi bi-recycle text-2xl"></i>
                        </div>
                        <div>
                            <h2 class="font-bold text-2xl">Manajemen Jenis Sampah</h2>
                            <p class="text-sm text-lime-100">Kelola kategori dan harga sampah</p>
                        </div>
                    </div>
                </div>
                <div class="flex flex-wrap items-center gap-3">
                    <a href="{{ route('admin.waste-types.create') }}" class="inline-flex items-center gap-2 bg-white text-lime-600 px-6 py-2 rounded-xl font-semibold shadow-lg hover:shadow-xl hover:scale-105 transition-all">
                        <i class="bi bi-plus-circle text-lg"></i>
                        <span>Tambah Jenis Sampah</span>
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Main Content -->
    <main class="max-w-6xl mx-auto px-4 pb-8">
        <div class="space-y-6">
            {{-- Success Message --}}
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

            {{-- Stats Summary --}}
            <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                <div class="bg-gradient-to-br from-lime-500 to-green-600 rounded-2xl p-6 text-white shadow-lg">
                    <div class="flex items-center justify-between mb-3">
                        <div class="w-12 h-12 bg-white bg-opacity-20 backdrop-blur-sm rounded-xl flex items-center justify-center">
                            <i class="bi bi-recycle text-2xl"></i>
                        </div>
                    </div>
                    <div class="text-sm font-medium opacity-90">Total Jenis Sampah</div>
                    <div class="text-3xl font-bold mt-1">{{ $wasteTypes->total() }}</div>
                    <div class="text-xs opacity-80 mt-1">Kategori terdaftar</div>
                </div>

                <div class="bg-gradient-to-br from-green-500 to-emerald-600 rounded-2xl p-6 text-white shadow-lg">
                    <div class="flex items-center justify-between mb-3">
                        <div class="w-12 h-12 bg-white bg-opacity-20 backdrop-blur-sm rounded-xl flex items-center justify-center">
                            <i class="bi bi-coin text-2xl"></i>
                        </div>
                    </div>
                    <div class="text-sm font-medium opacity-90">Rata-rata Harga</div>
                    <div class="text-3xl font-bold mt-1">{{ number_format($wasteTypes->avg('price_per_kg') ?? 0, 0) }}</div>
                    <div class="text-xs opacity-80 mt-1">Per kilogram</div>
                </div>

                <div class="bg-gradient-to-br from-teal-500 to-cyan-600 rounded-2xl p-6 text-white shadow-lg">
                    <div class="flex items-center justify-between mb-3">
                        <div class="w-12 h-12 bg-white bg-opacity-20 backdrop-blur-sm rounded-xl flex items-center justify-center">
                            <i class="bi bi-check-circle text-2xl"></i>
                        </div> 
                    </div>
                    <div class="text-sm font-medium opacity-90">Status Aktif</div>
                    <div class="text-3xl font-bold mt-1">{{ $wasteTypes->where('is_active', true)->count() }}</div>
                    <div class="text-xs opacity-80 mt-1">Dari total {{ $wasteTypes->total() }} jenis</div>
                </div>
            </div>

            {{-- Waste Types Table --}}
            <div class="bg-white rounded-2xl shadow-lg overflow-hidden">
                <div class="bg-gradient-to-r from-lime-50 to-green-50 px-6 py-4 border-b-2 border-lime-200">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 bg-gradient-to-br from-lime-500 to-green-600 rounded-xl flex items-center justify-center shadow-md">
                                <i class="bi bi-list-ul text-white text-lg"></i>
                            </div>
                            <div>
                                <h3 class="text-lg font-bold text-gray-800">Daftar Jenis Sampah</h3>
                                <p class="text-sm text-gray-600">Kelola kategori dan harga sampah</p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="p-6">
                    @if($wasteTypes->count() > 0)
                        <div class="space-y-4">
                            @foreach($wasteTypes as $waste)
                                <div class="bg-gradient-to-br from-white to-gray-50 rounded-2xl border-2 border-lime-200 p-6 hover:shadow-lg transition-all">
                                    <div class="flex flex-col lg:flex-row lg:items-center justify-between gap-4">
                                        <!-- Waste Type Info -->
                                        <div class="flex items-start gap-4 flex-1">
                                            <div class="w-16 h-16 bg-gradient-to-br from-lime-400 to-green-500 rounded-xl flex items-center justify-center text-white font-bold text-2xl shadow-md flex-shrink-0">
                                                <i class="bi bi-trash3"></i>
                                            </div>
                                            <div class="flex-1 min-w-0">
                                                <div class="flex items-center gap-2 mb-2">
                                                    <h4 class="font-bold text-gray-800 text-xl">{{ $waste->name }}</h4>
                                                    @if($waste->is_active)
                                                        <span class="inline-flex items-center gap-1 px-3 py-1 rounded-full text-xs font-bold bg-gradient-to-r from-green-400 to-emerald-400 text-white shadow-sm">
                                                            <i class="bi bi-check-circle"></i>
                                                            Aktif
                                                        </span>
                                                    @else
                                                        <span class="inline-flex items-center gap-1 px-3 py-1 rounded-full text-xs font-bold bg-gradient-to-r from-gray-400 to-gray-500 text-white shadow-sm">
                                                            <i class="bi bi-x-circle"></i>
                                                            Nonaktif
                                                        </span>
                                                    @endif
                                                </div>
                                                
                                                @if($waste->description)
                                                    <p class="text-sm text-gray-600 mb-3">{{ $waste->description }}</p>
                                                @endif

                                                <div class="grid grid-cols-1 md:grid-cols-2 gap-2">
                                                    <div class="flex items-center gap-2 text-sm">
                                                        <i class="bi bi-coin text-lime-600"></i>
                                                        <span class="text-gray-600">Harga:</span>
                                                        <span class="font-bold text-lime-600">Rp {{ number_format($waste->price_per_kg, 0, ',', '.') }}/kg</span>
                                                    </div>
                                                    <div class="flex items-center gap-2 text-sm">
                                                        <i class="bi bi-coin text-emerald-600"></i>
                                                        <span class="text-gray-600">Poin:</span>
                                                        <span class="font-bold text-emerald-600">{{ $waste->points_per_kg }} poin/kg</span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Actions -->
                                        <div class="flex flex-col gap-2 lg:flex-shrink-0">
                                            <a href="{{ route('admin.waste-types.edit', $waste->id) }}" class="inline-flex items-center justify-center gap-2 px-4 py-2 bg-gradient-to-r from-blue-500 to-cyan-600 hover:from-blue-600 hover:to-cyan-700 rounded-xl text-white font-semibold text-sm shadow-md hover:shadow-lg transition-all">
                                                <i class="bi bi-pencil-square"></i>
                                                Edit
                                            </a>
                                            
                                            <form action="{{ route('admin.waste-types.destroy', $waste->id) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus jenis sampah ini?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="w-full inline-flex items-center justify-center gap-2 px-4 py-2 bg-gradient-to-r from-red-500 to-pink-600 hover:from-red-600 hover:to-pink-700 rounded-xl text-white font-semibold text-sm shadow-md hover:shadow-lg transition-all">
                                                    <i class="bi bi-trash3"></i>
                                                    Hapus
                                                </button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>

                        {{-- Pagination --}}
                        <div class="mt-6">
                            {{ $wasteTypes->links() }}
                        </div>
                    @else
                        <div class="text-center py-12">
                            <div class="w-24 h-24 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-4">
                                <i class="bi bi-inbox text-gray-400 text-4xl"></i>
                            </div>
                            <h3 class="text-lg font-semibold text-gray-800 mb-2">Belum ada data</h3>
                            <p class="text-gray-600 mb-4">Belum ada jenis sampah yang terdaftar</p>
                            <a href="{{ route('admin.waste-types.create') }}" class="inline-flex items-center gap-2 bg-gradient-to-r from-lime-500 to-green-600 text-white px-6 py-3 rounded-xl font-semibold shadow-lg hover:shadow-xl hover:scale-105 transition-all">
                                <i class="bi bi-plus-circle"></i>
                                Tambah Jenis Sampah Pertama
                            </a>
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

</body>
</html>
