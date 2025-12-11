<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Tukar Poin - Green Saving</title>
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
                    <div class="w-12 h-12 bg-gradient-to-br from-green-500 to-green-600 rounded-xl flex items-center justify-center shadow-lg">
                        <i class="bi bi-recycle text-white text-2xl"></i>
                    </div>
                    <div>
                        <h1 class="font-bold text-xl text-gray-800">Green Saving</h1>
                        <p class="text-sm text-green-600">Halo, {{ Auth::user()->full_name ?? Auth::user()->name ?? 'lisbeth' }}</p>
                    </div>
                </div>

                <!-- Points & Actions -->
                <div class="flex items-center space-x-4">
                    <!-- Points Display -->
                    <div class="bg-gradient-to-r from-green-100 to-green-50 px-6 py-3 rounded-full border-2 border-green-300 shadow-md">
                        <div class="flex items-center space-x-2">
                            <i class="bi bi-coin text-green-600 text-xl"></i>
                            <span id="user-points" class="font-bold text-green-700 text-lg">{{ number_format(Auth::user()->balance_points ?? 0, 0, ',', '.') }} poin</span>
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

                    <!-- Notification Bell with Dropdown -->
                    <div class="relative" x-data="{ open: false }" @click.away="open = false">
                        <button @click="open = !open; markNotificationsAsRead()" class="relative w-12 h-12 bg-gray-100 hover:bg-gray-200 rounded-full flex items-center justify-center transition-all">
                            <i class="bi bi-bell text-gray-700 text-xl"></i>
                            @if(isset($unreadNotifications) && $unreadNotifications > 0)
                            <span data-notif-badge class="absolute -top-2 -right-2 bg-red-500 text-white text-xs font-bold rounded-full w-6 h-6 flex items-center justify-center animate-pulse">
                                {{ $unreadNotifications > 9 ? '9+' : $unreadNotifications }}
                            </span>
                            @endif
                        </button>

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
                                    Lihat Semua Notifikasi →
                                </a>
                            </div>
                            @endif
                        </div>
                    </div>

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
                    <a href="/tukar-poin" class="bg-green-500 text-white px-4 py-3 rounded-2xl text-xs lg:text-sm font-semibold shadow-md flex items-center justify-center gap-2 cursor-default whitespace-nowrap">
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
        
        <!-- Page Header -->
        <div class="bg-white rounded-2xl p-6 mb-6 shadow-sm">
            <h2 class="text-xl font-bold text-gray-800 mb-2">Tukar Poin Hadiah</h2>
            <p class="text-sm text-gray-500">Tukarkan poin Anda dengan hadiah menarik yang tersedia</p>
        </div>

        <!-- Filter Cabang -->
        <div class="bg-white rounded-2xl p-6 mb-6 shadow-sm">
            <form method="GET" action="{{ route('tukar-poin') }}" id="branch-filter-form">
                <div class="flex flex-col md:flex-row md:items-center gap-4">
                    <div class="flex items-center gap-2 text-gray-700">
                        <i class="bi bi-geo-alt-fill text-green-600 text-xl"></i>
                        <label for="branch_id" class="font-semibold">Pilih Lokasi Penukaran:</label>
                    </div>
                    <div class="flex-1 max-w-md">
                        <select 
                            name="branch_id" 
                            id="branch_id"
                            onchange="this.form.submit()"
                            class="w-full px-4 py-3 bg-white border-2 border-gray-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent font-medium text-gray-800 cursor-pointer"
                        >
                            <option value="">-- Pilih Cabang --</option>
                            @foreach($branches as $cabang)
                                <option value="{{ $cabang->id }}" {{ $selectedBranch == $cabang->id ? 'selected' : '' }}>
                                    {{ $cabang->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="flex items-center gap-2 text-sm text-gray-500">
                        <i class="bi bi-info-circle"></i>
                        <span>{{ $rewardItems->count() }} barang tersedia</span>
                    </div>
                </div>
            </form>
        </div>

        <!-- Loading State -->
        <div id="loading-rewards" class="hidden flex justify-center py-12">
            <div class="animate-spin rounded-full h-12 w-12 border-b-2 border-green-500"></div>
        </div>

        <!-- Empty State -->
        @if($rewardItems->count() === 0)
        <div class="text-center py-12 bg-white rounded-2xl shadow-sm">
            <i class="bi bi-gift text-gray-300 text-6xl mb-4"></i>
            <p class="text-gray-500 text-lg font-semibold">Belum ada hadiah tersedia</p>
            <p class="text-gray-400 text-sm">Silakan pilih cabang lain atau cek kembali nanti</p>
        </div>
        @endif

        <!-- Rewards Grid -->
        @if($rewardItems->count() > 0)
        <div id="rewards-grid" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach($rewardItems as $reward)
                @include('components.reward-card', ['reward' => $reward])
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

    <!-- Modal Konfirmasi Penukaran -->
    <div id="confirmModal" class="fixed inset-0 bg-black bg-opacity-50 hidden items-center justify-center z-50 p-4">
        <div class="bg-white rounded-3xl max-w-md w-full shadow-2xl transform transition-all">
            <!-- Modal Header -->
            <div class="bg-gradient-to-r from-green-500 to-green-600 rounded-t-3xl p-6 text-center">
                <div class="w-20 h-20 bg-white rounded-full mx-auto flex items-center justify-center shadow-lg mb-4">
                    <i class="bi bi-cart-check-fill text-green-500 text-4xl"></i>
                </div>
                <h2 class="text-2xl font-bold text-white mb-2">Konfirmasi Penukaran</h2>
                <p class="text-green-50 text-sm">Apakah Anda yakin ingin menukar poin dengan reward ini?</p>
            </div>

            <!-- Modal Body -->
            <div class="p-6">
                <!-- Product Info -->
                <div class="bg-gradient-to-br from-green-50 to-emerald-50 rounded-2xl p-4 mb-6 flex items-center space-x-4">
                    <div class="w-20 h-20 bg-white rounded-xl flex items-center justify-center shadow-sm">
                        <img id="modalProductImage" src="" alt="" class="h-16 w-auto object-contain">
                    </div>
                    <div class="flex-1">
                        <h3 id="modalProductName" class="font-bold text-gray-800 text-lg mb-1"></h3>
                        <p id="modalProductDesc" class="text-sm text-gray-600"></p>
                    </div>
                </div>

                <!-- Point Details -->
                <div class="space-y-3 mb-6">
                    <div class="flex justify-between items-center pb-3 border-b border-gray-200">
                        <span class="text-gray-600 text-sm">Harga:</span>
                        <span id="modalProductPrice" class="font-bold text-lg text-gray-800"></span>
                    </div>
                    <div class="flex justify-between items-center pb-3 border-b border-gray-200">
                        <span class="text-gray-600 text-sm">Saldo Anda:</span>
                        <span class="font-bold text-lg text-green-600">
                            <i class="bi bi-coin text-green-500 mr-1"></i>
                            15420 poin
                        </span>
                    </div>
                    <div class="flex justify-between items-center pt-2">
                        <span class="text-gray-700 font-semibold">Sisa Setelah Tukar:</span>
                        <span id="modalRemainingPoints" class="font-bold text-xl text-green-600">
                            <i class="bi bi-coin text-green-500 mr-1"></i>
                        </span>
                    </div>
                </div>

                <!-- Warning Message (if insufficient points) -->
                <div id="insufficientPointsWarning" class="hidden bg-red-50 border-l-4 border-red-500 p-4 mb-4 rounded-lg">
                    <div class="flex items-center">
                        <i class="bi bi-exclamation-triangle-fill text-red-500 text-xl mr-3"></i>
                        <div>
                            <p class="font-semibold text-red-800 text-sm">Poin Anda Tidak Mencukupi!</p>
                            <p class="text-red-700 text-xs mt-1">Poin anda kurang <span id="pointsShortage" class="font-bold"></span></p>
                            <p class="text-red-600 text-xs mt-1">Pilih barang lain atau tukarkan sampah Anda untuk menambah poin.</p>
                        </div>
                    </div>
                </div>

                <!-- Action Buttons -->
                <div class="flex gap-3">
                    <button onclick="closeConfirmModal()" class="flex-1 bg-gray-100 hover:bg-gray-200 text-gray-700 font-semibold py-3.5 rounded-xl transition-all">
                        <i class="bi bi-x-circle mr-2"></i>
                        Batal
                    </button>
                    <button id="confirmExchangeBtn" onclick="confirmExchange()" class="flex-1 bg-gradient-to-r from-green-500 to-green-600 hover:from-green-600 hover:to-green-700 text-white font-semibold py-3.5 rounded-xl transition-all shadow-md hover:shadow-lg">
                        <i class="bi bi-check-circle-fill mr-2"></i>
                        Konfirmasi Tukar
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Success -->
    <div id="successModal" class="fixed inset-0 bg-black bg-opacity-50 hidden items-center justify-center z-50 p-4">
        <div class="bg-white rounded-3xl max-w-md w-full shadow-2xl transform transition-all">
            <!-- Success Animation -->
            <div class="p-8 text-center">
                <div class="w-24 h-24 bg-gradient-to-br from-green-400 to-green-600 rounded-full mx-auto flex items-center justify-center shadow-lg mb-6 animate-bounce">
                    <i class="bi bi-check-lg text-white text-5xl"></i>
                </div>
                
                <h2 class="text-2xl font-bold text-gray-800 mb-3">Penukaran Poin Berhasil!</h2>
                <div class="w-16 h-1 bg-gradient-to-r from-green-400 to-green-600 mx-auto rounded-full mb-4"></div>
                
                <p class="text-gray-600 mb-6 leading-relaxed">
                    Segera ambil barang Anda sesuai lokasi yang dipilih dalam waktu 
                    <span class="font-bold text-green-600">1 x 24 jam</span>
                </p>

                <!-- Pickup Location Info -->
                <div class="bg-gradient-to-br from-green-50 to-emerald-50 rounded-2xl p-4 mb-6">
                    <div class="flex items-start space-x-3">
                        <i class="bi bi-geo-alt-fill text-green-600 text-2xl mt-1"></i>
                        <div class="text-left flex-1">
                            <p class="font-semibold text-gray-800 mb-1">Lokasi Pengambilan:</p>
                            <p class="text-sm text-gray-600">Bank Sampah Sitolusna</p>
                            <p class="text-sm text-gray-600">Jl. Sitolusna, Kec. Balige, Toba, Sumatera Utara</p>
                        </div>
                    </div>
                </div>

                <!-- New Balance -->
                <div class="bg-white border-2 border-green-200 rounded-xl p-4 mb-6">
                    <p class="text-sm text-gray-600 mb-2">Saldo Poin Anda Sekarang:</p>
                    <p class="text-3xl font-bold text-green-600">
                        <i class="bi bi-coin text-green-500 mr-2"></i>
                        <span id="newBalance">15420</span> poin
                    </p>
                </div>

                <button onclick="closeSuccessModal()" class="w-full bg-gradient-to-r from-green-500 to-green-600 hover:from-green-600 hover:to-green-700 text-white font-semibold py-4 rounded-xl transition-all shadow-md hover:shadow-lg">
                    <i class="bi bi-check-circle mr-2"></i>
                    Mengerti
                </button>
            </div>
        </div>
    </div>

    <script>
        let selectedReward = null;
        const currentPoints = {{ Auth::user()->balance_points ?? 0 }};
        const selectedBranchId = {{ $selectedBranch }};

        // Data rewards dari backend (sudah filtered by branch)
        const allRewards = @json($rewardItems);

        // Rewards sudah di-render dari backend via Blade
        // Tidak perlu renderRewards() lagi

        function selectReward(rewardId) {
            selectedReward = allRewards.find(r => r.id === rewardId);
            if (!selectedReward) return;

            openConfirmModal();
        }

        function openConfirmModal() {
            document.getElementById('modalProductName').textContent = selectedReward.name;
            document.getElementById('modalProductDesc').textContent = selectedReward.description || 'Hadiah menarik';
            document.getElementById('modalProductPrice').innerHTML = `<i class="bi bi-coin text-green-500 mr-1"></i>${selectedReward.points_cost.toLocaleString('id-ID')} poin`;
            
            const imagePath = selectedReward.image ? `/images/${selectedReward.image}` : '/images/tukar reward.png';
            document.getElementById('modalProductImage').src = imagePath;
            document.getElementById('modalProductImage').alt = selectedReward.name;

            const remaining = currentPoints - selectedReward.points_cost;
            const remainingEl = document.getElementById('modalRemainingPoints');
            
            if (remaining >= 0) {
                remainingEl.innerHTML = `<i class="bi bi-coin text-green-500 mr-1"></i>${remaining.toLocaleString('id-ID')} poin`;
                remainingEl.classList.remove('text-red-600');
                remainingEl.classList.add('text-green-600');
                document.getElementById('insufficientPointsWarning').classList.add('hidden');
                document.getElementById('confirmExchangeBtn').disabled = false;
                document.getElementById('confirmExchangeBtn').classList.remove('opacity-50', 'cursor-not-allowed');
            } else {
                remainingEl.innerHTML = `<i class="bi bi-coin text-red-500 mr-1"></i>${remaining.toLocaleString('id-ID')} poin`;
                remainingEl.classList.add('text-red-600');
                remainingEl.classList.remove('text-green-600');
                document.getElementById('pointsShortage').textContent = Math.abs(remaining).toLocaleString('id-ID') + ' poin';
                document.getElementById('insufficientPointsWarning').classList.remove('hidden');
                document.getElementById('confirmExchangeBtn').disabled = true;
                document.getElementById('confirmExchangeBtn').classList.add('opacity-50', 'cursor-not-allowed');
            }

            document.getElementById('confirmModal').classList.remove('hidden');
            document.getElementById('confirmModal').classList.add('flex');
        }

        function closeConfirmModal() {
            document.getElementById('confirmModal').classList.add('hidden');
        }

        /**
         * Fungsi untuk konfirmasi penukaran poin
         * Mengirim request POST ke backend dengan CSRF token dan data lengkap
         */
        async function confirmExchange() {
            // Validasi saldo poin mencukupi
            if (currentPoints < selectedReward.points_cost) {
                alert('❌ Poin Anda tidak mencukupi untuk menukar reward ini!');
                return;
            }

            // Validasi reward terpilih
            if (!selectedReward || !selectedReward.id) {
                alert('❌ Reward tidak valid. Silakan pilih reward kembali.');
                closeConfirmModal();
                return;
            }

            // Validasi branch_id
            if (!selectedBranchId) {
                alert('❌ Lokasi penukaran tidak valid. Silakan pilih lokasi terlebih dahulu.');
                closeConfirmModal();
                return;
            }

            // Disable tombol untuk mencegah double click
            const confirmBtn = document.getElementById('confirmExchangeBtn');
            const originalBtnText = confirmBtn.innerHTML;
            confirmBtn.disabled = true;
            confirmBtn.innerHTML = '<i class="bi bi-hourglass-split mr-2"></i>Memproses...';

            try {
                // Ambil CSRF token dari meta tag
                const csrfToken = document.querySelector('meta[name="csrf-token"]');
                if (!csrfToken || !csrfToken.getAttribute('content')) {
                    throw new Error('CSRF token tidak ditemukan. Silakan refresh halaman.');
                }

                // Ambil lokasi dari dropdown (untuk memastikan data terbaru)
                const branchDropdown = document.getElementById('branch_id');
                const currentBranchId = branchDropdown ? parseInt(branchDropdown.value) : selectedBranchId;

                console.log('Sending redemption request:', {
                    branch_id: currentBranchId,
                    reward_item_id: selectedReward.id,
                    quantity: 1
                });

                // Kirim request ke backend API
                const response = await fetch('/api/redemptions', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'Accept': 'application/json',
                        'X-CSRF-TOKEN': csrfToken.getAttribute('content')
                    },
                    body: JSON.stringify({
                        branch_id: currentBranchId,
                        items: [{
                            reward_item_id: selectedReward.id,
                            quantity: 1
                        }]
                    })
                });

                // Parse response JSON
                const result = await response.json();

                // Handle response berdasarkan status code
                if (response.ok) {
                    // ✅ SUCCESS (200-299)
                    console.log('Redemption success:', result);
                    
                    closeConfirmModal();
                    
                    // Update saldo poin di UI
                    const newBalance = currentPoints - selectedReward.points_cost;
                    document.getElementById('newBalance').textContent = newBalance.toLocaleString('id-ID');
                    document.getElementById('user-points').textContent = newBalance.toLocaleString('id-ID') + ' poin';
                    
                    // Tampilkan modal sukses setelah delay
                    setTimeout(() => {
                        document.getElementById('successModal').classList.remove('hidden');
                        document.getElementById('successModal').classList.add('flex');
                    }, 300);
                    
                } else if (response.status === 422) {
                    // ❌ VALIDATION ERROR (422 Unprocessable Entity)
                    console.error('Validation error:', result);
                    
                    // Tampilkan pesan error spesifik dari backend
                    let errorMessage = result.message || 'Validasi gagal. Silakan cek kembali data Anda.';
                    
                    // Jika ada detail error validasi
                    if (result.errors) {
                        const errorDetails = Object.values(result.errors).flat().join('\n');
                        errorMessage += '\n\n' + errorDetails;
                    }
                    
                    // Pesan error umum berdasarkan kondisi
                    if (errorMessage.includes('stock') || errorMessage.includes('stok')) {
                        errorMessage = '❌ Stok barang habis!\n\nMaaf, stok reward ini sudah habis. Silakan pilih reward lain atau cek kembali nanti.';
                    } else if (errorMessage.includes('poin') || errorMessage.includes('point')) {
                        errorMessage = '❌ Poin tidak mencukupi!\n\nSaldo poin Anda tidak cukup untuk menukar reward ini. Silakan tukarkan sampah untuk menambah poin.';
                    } else if (errorMessage.includes('branch') || errorMessage.includes('cabang')) {
                        errorMessage = '❌ Lokasi tidak valid!\n\nReward tidak tersedia di lokasi yang dipilih. Silakan pilih lokasi lain.';
                    }
                    
                    alert(errorMessage);
                    closeConfirmModal();
                    
                } else if (response.status === 419) {
                    // ❌ CSRF TOKEN MISMATCH (419)
                    console.error('CSRF token mismatch');
                    alert('❌ Session expired!\n\nToken keamanan telah kadaluarsa. Halaman akan di-refresh otomatis.');
                    
                    // Refresh halaman untuk mendapatkan CSRF token baru
                    setTimeout(() => {
                        window.location.reload();
                    }, 2000);
                    
                } else if (response.status === 401) {
                    // ❌ UNAUTHORIZED (401)
                    alert('❌ Sesi login Anda telah berakhir!\n\nSilakan login kembali.');
                    window.location.href = '/login';
                    
                } else if (response.status === 500) {
                    // ❌ SERVER ERROR (500)
                    console.error('Server error:', result);
                    alert('❌ Terjadi kesalahan server!\n\n' + (result.message || 'Silakan coba lagi atau hubungi administrator.'));
                    closeConfirmModal();
                    
                } else {
                    // ❌ OTHER ERRORS
                    console.error('Unexpected error:', result);
                    alert('❌ Terjadi kesalahan!\n\n' + (result.message || 'Kode error: ' + response.status));
                    closeConfirmModal();
                }
                
            } catch (error) {
                // ❌ NETWORK ERROR atau ERROR LAINNYA
                console.error('Error during redemption:', error);
                
                let errorMsg = '❌ Terjadi kesalahan saat mengirim data!\n\n';
                
                if (error.message.includes('CSRF')) {
                    errorMsg += 'Token keamanan tidak valid. Halaman akan di-refresh.';
                    alert(errorMsg);
                    setTimeout(() => window.location.reload(), 2000);
                } else if (error.name === 'TypeError' && error.message.includes('fetch')) {
                    errorMsg += 'Tidak dapat terhubung ke server. Periksa koneksi internet Anda.';
                    alert(errorMsg);
                } else {
                    errorMsg += error.message || 'Silakan coba lagi atau hubungi administrator.';
                    alert(errorMsg);
                }
                
                closeConfirmModal();
                
            } finally {
                // Re-enable tombol konfirmasi
                confirmBtn.disabled = false;
                confirmBtn.innerHTML = originalBtnText;
            }
        }

        function closeSuccessModal() {
            document.getElementById('successModal').classList.add('hidden');
            
            // Redirect ke halaman riwayat untuk melihat penukaran yang baru dibuat
            setTimeout(() => {
                window.location.href = '/riwayat';
            }, 500);
        }

        // Data rewards sudah tersedia dari backend, tidak perlu fetch
        
        // Log untuk debugging
        console.log('Page loaded with:');
        console.log('- Current Points:', currentPoints);
        console.log('- Selected Branch ID:', selectedBranchId);
        console.log('- Available Rewards:', allRewards.length);

        // Function to mark all notifications as read
        async function markNotificationsAsRead() {
            const csrfToken = document.querySelector('meta[name=csrf-token]').content;
            const badgeElement = document.querySelector('[data-notif-badge]');
            
            try {
                const response = await fetch('{{ route('notifikasi.read-all') }}', {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': csrfToken,
                        'Content-Type': 'application/json'
                    }
                });
                
                if (response.ok && badgeElement) {
                    badgeElement.style.display = 'none';
                }
            } catch (error) {
                console.error('Error marking notifications as read:', error);
            }
        }
    </script>

</body>
</html>
