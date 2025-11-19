<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Notifikasi Admin - Green Saving</title>
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

    <!-- Header dengan Notifikasi -->
    <x-admin-header activePage="" />

    <!-- Main Content -->
    <main class="max-w-6xl mx-auto px-4 py-8">
        
        <!-- Page Header -->
        <div class="mb-8">
            <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
                <div>
                    <h1 class="text-3xl font-bold text-gray-800 mb-2">
                        <i class="bi bi-bell-fill text-green-600 mr-3"></i>Notifikasi
                    </h1>
                    <p class="text-gray-600">Pantau aktivitas dan pembaruan akun Anda</p>
                </div>
                
                @if($notifications->where('read_at', null)->count() > 0)
                <button onclick="markAllAsRead()" class="bg-gradient-to-r from-green-500 to-emerald-600 hover:from-green-600 hover:to-emerald-700 text-white px-6 py-3 rounded-xl font-semibold shadow-lg hover:shadow-xl transition-all flex items-center gap-2">
                    <i class="bi bi-check-all"></i>
                    Tandai Semua Dibaca
                </button>
                @endif
            </div>
        </div>

        <!-- Notifications List -->
        <div class="bg-white rounded-2xl shadow-sm overflow-hidden">
            @if($notifications->count() > 0)
                <div class="divide-y divide-gray-100">
                    @foreach($notifications as $notification)
                        @php
                            $data = $notification->data;
                            $isUnread = is_null($notification->read_at);
                        @endphp
                        <div class="p-6 hover:bg-gray-50 transition-colors {{ $isUnread ? 'bg-blue-50' : '' }}">
                            <div class="flex items-start gap-4">
                                <!-- Icon -->
                                <div class="flex-shrink-0">
                                    @if($data['type'] === 'success')
                                        <div class="w-12 h-12 bg-green-100 rounded-full flex items-center justify-center">
                                            <i class="bi bi-check-circle-fill text-green-600 text-xl"></i>
                                        </div>
                                    @elseif($data['type'] === 'info')
                                        <div class="w-12 h-12 bg-blue-100 rounded-full flex items-center justify-center">
                                            <i class="bi bi-info-circle-fill text-blue-600 text-xl"></i>
                                        </div>
                                    @elseif($data['type'] === 'warning')
                                        <div class="w-12 h-12 bg-yellow-100 rounded-full flex items-center justify-center">
                                            <i class="bi bi-exclamation-triangle-fill text-yellow-600 text-xl"></i>
                                        </div>
                                    @else
                                        <div class="w-12 h-12 bg-gray-100 rounded-full flex items-center justify-center">
                                            <i class="bi bi-bell-fill text-gray-600 text-xl"></i>
                                        </div>
                                    @endif
                                </div>

                                <!-- Content -->
                                <div class="flex-1 min-w-0">
                                    <div class="flex items-start justify-between gap-4 mb-2">
                                        <h3 class="font-bold text-gray-800 text-lg">
                                            {{ $data['title'] ?? 'Notifikasi' }}
                                            @if($isUnread)
                                                <span class="inline-block w-2 h-2 bg-blue-500 rounded-full ml-2"></span>
                                            @endif
                                        </h3>
                                        <span class="text-sm text-gray-500 flex-shrink-0">
                                            <i class="bi bi-clock"></i>
                                            {{ $notification->created_at->diffForHumans() }}
                                        </span>
                                    </div>
                                    
                                    <p class="text-gray-600 mb-3">{{ $data['message'] ?? '' }}</p>

                                    <div class="flex items-center gap-3">
                                        @if(isset($data['link']))
                                            <a href="{{ $data['link'] }}" class="inline-flex items-center gap-2 text-green-600 hover:text-green-700 font-semibold text-sm">
                                                <i class="bi bi-arrow-right-circle"></i>
                                                Lihat Detail
                                            </a>
                                        @endif

                                        @if($isUnread)
                                            <button onclick="markAsRead('{{ $notification->id }}')" class="inline-flex items-center gap-2 text-blue-600 hover:text-blue-700 font-semibold text-sm">
                                                <i class="bi bi-check"></i>
                                                Tandai Dibaca
                                            </button>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <!-- Empty State -->
                <div class="p-12 text-center">
                    <div class="w-24 h-24 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-4">
                        <i class="bi bi-bell-slash text-gray-400 text-4xl"></i>
                    </div>
                    <h3 class="text-xl font-bold text-gray-800 mb-2">Tidak ada notifikasi</h3>
                    <p class="text-gray-600">Notifikasi akan muncul di sini saat ada aktivitas baru</p>
                </div>
            @endif
        </div>

    </main>

    <!-- JavaScript -->
    <script>
        // Setup CSRF token untuk AJAX
        const csrfToken = document.querySelector('meta[name="csrf-token"]').content;

        /**
         * Tandai satu notifikasi sebagai sudah dibaca
         */
        function markAsRead(notificationId) {
            fetch(`/notifikasi/${notificationId}/read`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': csrfToken
                }
            })
            .then(response => response.json())
            .then(data => {
                // Reload halaman untuk update tampilan
                window.location.reload();
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Gagal menandai notifikasi sebagai dibaca');
            });
        }

        /**
         * Tandai semua notifikasi sebagai sudah dibaca
         */
        function markAllAsRead() {
            if (!confirm('Tandai semua notifikasi sebagai sudah dibaca?')) {
                return;
            }

            fetch('/notifikasi/read-all', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': csrfToken
                }
            })
            .then(response => response.json())
            .then(data => {
                // Reload halaman untuk update tampilan
                window.location.reload();
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Gagal menandai semua notifikasi sebagai dibaca');
            });
        }
    </script>

</body>
</html>
