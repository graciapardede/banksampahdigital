<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Dashboard - Green Saving</title>
    <script src="https://cdn.tailwindcss.com"></script>
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
                        <p class="text-sm text-green-600">Halo, {{ $namaUser }}</p>
                    </div>
                </div>

                <!-- Points & Actions -->
                <div class="flex items-center space-x-4">
                    <!-- Points Display -->
                    <div class="bg-gradient-to-r from-green-100 to-green-50 px-6 py-3 rounded-full border-2 border-green-200 shadow-sm">
                        <div class="flex items-center space-x-2">
                            <i class="bi bi-coin text-green-600 text-xl"></i>
                            <span id="balance-points" class="font-bold text-green-700 text-lg">{{ number_format($saldoPoin, 0, ',', '.') }} poin</span>
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
                    <a href="/dashboard" class="bg-green-500 text-white px-4 lg:px-6 py-3 rounded-2xl text-xs lg:text-sm font-semibold shadow-md flex items-center justify-center space-x-2 w-full cursor-default">
                        <i class="bi bi-house-door pointer-events-none"></i>
                        <span class="truncate pointer-events-none">Dashboard</span>
                    </a>
                    <a href="/profil" class="bg-white text-gray-700 px-4 lg:px-6 py-3 rounded-2xl text-xs lg:text-sm font-semibold hover:bg-green-50 transition-colors shadow-sm flex items-center justify-center space-x-2 w-full cursor-pointer">
                        <i class="bi bi-person pointer-events-none"></i>
                        <span class="truncate pointer-events-none">Profil</span>
                    </a>
                    <a href="/setor" class="bg-white text-gray-700 px-4 lg:px-6 py-3 rounded-2xl text-xs lg:text-sm font-semibold hover:bg-green-50 transition-colors shadow-sm flex items-center justify-center space-x-2 w-full cursor-pointer">
                        <i class="bi bi-recycle pointer-events-none"></i>
                        <span class="truncate pointer-events-none">Setor</span>
                    </a>
                    <a href="/tukar-poin" class="bg-white text-gray-700 px-4 lg:px-6 py-3 rounded-2xl text-xs lg:text-sm font-semibold hover:bg-green-50 transition-colors shadow-sm flex items-center justify-center space-x-2 w-full cursor-pointer">
                        <i class="bi bi-gift pointer-events-none"></i>
                        <span class="truncate pointer-events-none">Tukar Poin</span>
                    </a>
                    <a href="/riwayat" class="bg-white text-gray-700 px-4 lg:px-6 py-3 rounded-2xl text-xs lg:text-sm font-semibold hover:bg-green-50 transition-colors shadow-sm flex items-center justify-center space-x-2 w-full cursor-pointer">
                        <i class="bi bi-clock-history pointer-events-none"></i>
                        <span class="truncate pointer-events-none">Riwayat</span>
                    </a>
                    <a href="/notifikasi" class="bg-white text-gray-700 px-4 lg:px-6 py-3 rounded-2xl text-xs lg:text-sm font-semibold hover:bg-green-50 transition-colors shadow-sm flex items-center justify-center space-x-2 w-full cursor-pointer">
                        <i class="bi bi-bell pointer-events-none"></i>
                        <span class="truncate pointer-events-none">Notifikasi</span>
                    </a>
                </div>
            </div>
        </div>
    </header>

    <!-- Main Content -->
    <main class="max-w-6xl mx-auto px-4 py-8">
        
        <!-- Welcome Card -->
        <div class="bg-gradient-to-r from-green-500 to-green-600 rounded-2xl p-8 mb-8 text-white shadow-lg">
            <div class="flex flex-col md:flex-row items-start md:items-center justify-between gap-6">
                <div class="flex-1">
                    <h2 class="text-2xl font-bold mb-2">Selamat Datang, <span id="user-name">{{ $namaUser }}</span></h2>
                    <div class="flex flex-wrap items-center gap-4 mt-4">
                        <div class="bg-white bg-opacity-20 backdrop-blur-sm text-white px-4 py-2 rounded-lg text-sm font-semibold">
                            <span id="user-member-level">
                                @if($saldoPoin >= 10000)
                                    Gold Member
                                @elseif($saldoPoin >= 5000)
                                    Silver Member
                                @else
                                    Bronze Member
                                @endif
                            </span>
                        </div>
                        <span class="text-sm opacity-90" id="member-since">
                            Member sejak {{ $authUser->created_at ? $authUser->created_at->format('M Y') : 'Nov 2025' }}
                        </span>
                    </div>
                </div>
                <div class="text-center md:text-right">
                    <div class="bg-white bg-opacity-15 backdrop-blur-sm rounded-2xl px-6 py-4 mb-4">
                        <div id="balance-points-large" class="text-3xl font-bold">{{ number_format($saldoPoin, 0, ',', '.') }}</div>
                        <div class="text-sm opacity-90">ECO coin</div>
                    </div>
                    <a href="/tukar-poin" class="inline-block bg-white bg-opacity-20 backdrop-blur-sm hover:bg-opacity-30 text-white px-6 py-2 rounded-xl text-sm font-semibold transition-all duration-200">
                        Jelajahi marketplace
                    </a>
                </div>
            </div>
        </div>

        <!-- Aktivitas Section -->
        <div class="bg-white rounded-2xl p-6 mb-8 shadow-sm">
            <div class="flex justify-between items-center mb-6">
                <div>
                    <h3 class="text-xl font-bold text-gray-800">Aktivitas Terbaru</h3>
                    <p class="text-sm text-gray-500">Transaksi dan setoran terbaru Anda</p>
                </div>
                <a href="/riwayat" class="bg-gray-100 hover:bg-gray-200 px-4 py-2 rounded-xl text-sm font-semibold text-gray-700 transition-colors">
                    Lihat Semua
                </a>
            </div>

            <!-- Activity Items -->
            <div id="activity-container" class="space-y-4">
                <!-- Loading State -->
                <div class="flex items-center justify-center py-8">
                    <div class="animate-spin rounded-full h-12 w-12 border-b-2 border-green-500"></div>
                </div>
            </div>
        </div>

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

    <!-- Modal Detail -->
    <div id="detail-modal" class="hidden fixed inset-0 bg-black bg-opacity-50 z-50 flex items-center justify-center p-4">
        <div class="bg-white rounded-2xl max-w-2xl w-full max-h-[90vh] overflow-y-auto shadow-2xl">
            <div class="p-6">
                <!-- Modal Header -->
                <div class="flex justify-between items-start mb-6">
                    <div>
                        <h3 id="modal-title" class="text-2xl font-bold text-gray-800">Detail Transaksi</h3>
                        <p id="modal-date" class="text-sm text-gray-500 mt-1"></p>
                    </div>
                    <button onclick="closeModal()" class="text-gray-400 hover:text-gray-600 transition-colors">
                        <i class="bi bi-x-lg text-2xl"></i>
                    </button>
                </div>

                <!-- Modal Content -->
                <div id="modal-content" class="space-y-4">
                    <!-- Content will be loaded here -->
                </div>
            </div>
        </div>
    </div>

    <script>
        let dashboardData = null;
        let activities = [];

        // Fetch dashboard data
        async function fetchDashboardData() {
            try {
                const response = await fetch('/api/dashboard', {
                    headers: {
                        'Accept': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                    }
                });

                if (!response.ok) throw new Error('Failed to fetch');

                dashboardData = await response.json();
                updateDashboard();
                await fetchActivities();
            } catch (error) {
                console.error('Error fetching dashboard data:', error);
            }
        }

        // Update dashboard UI
        function updateDashboard() {
            if (!dashboardData) return;

            // Update balance points
            const balancePoints = dashboardData.balance_points || 0;
            document.getElementById('balance-points').textContent = `${balancePoints.toLocaleString('id-ID')} poin`;
            document.getElementById('balance-points-large').textContent = balancePoints.toLocaleString('id-ID');

            // Update user info if available
            if (dashboardData.user_name) {
                document.getElementById('user-name').textContent = dashboardData.user_name;
            }

            if (dashboardData.member_since) {
                document.getElementById('member-since').textContent = `Member sejak ${dashboardData.member_since}`;
            }
        }

        // Fetch recent activities (deposits + redemptions)
        async function fetchActivities() {
            try {
                // Fetch both deposits and redemptions
                const [depositsRes, redemptionsRes] = await Promise.all([
                    fetch('/api/deposits'),
                    fetch('/api/redemptions')
                ]);

                const deposits = await depositsRes.json();
                const redemptions = await redemptionsRes.json();

                // Combine and sort by date
                activities = [
                    ...deposits.map(d => ({ ...d, type: 'deposit' })),
                    ...redemptions.map(r => ({ ...r, type: 'redemption' }))
                ].sort((a, b) => new Date(b.created_at) - new Date(a.created_at))
                 .slice(0, 5); // Take only 5 most recent

                renderActivities();
            } catch (error) {
                console.error('Error fetching activities:', error);
                document.getElementById('activity-container').innerHTML = `
                    <div class="text-center py-8 text-gray-500">
                        <i class="bi bi-exclamation-circle text-4xl mb-2"></i>
                        <p>Gagal memuat aktivitas</p>
                    </div>
                `;
            }
        }

        // Render activities
        function renderActivities() {
            const container = document.getElementById('activity-container');

            if (activities.length === 0) {
                container.innerHTML = `
                    <div class="text-center py-8 text-gray-500">
                        <i class="bi bi-inbox text-4xl mb-2"></i>
                        <p>Belum ada aktivitas</p>
                    </div>
                `;
                return;
            }

            container.innerHTML = activities.map(activity => {
                const isDeposit = activity.type === 'deposit';
                const date = new Date(activity.created_at).toLocaleDateString('id-ID', {
                    year: 'numeric',
                    month: 'short',
                    day: 'numeric'
                });

                const statusConfig = {
                    pending: { bg: 'bg-yellow-200', text: 'text-yellow-800', label: 'Menunggu' },
                    verified: { bg: 'bg-green-200', text: 'text-green-800', label: 'Selesai' },
                    confirmed: { bg: 'bg-blue-200', text: 'text-blue-800', label: 'Siap Ambil' },
                    completed: { bg: 'bg-green-200', text: 'text-green-800', label: 'Selesai' },
                    approved: { bg: 'bg-green-200', text: 'text-green-800', label: 'Selesai' },
                    rejected: { bg: 'bg-red-200', text: 'text-red-800', label: 'Ditolak' },
                    cancelled: { bg: 'bg-gray-200', text: 'text-gray-800', label: 'Dibatalkan' }
                };

                const status = statusConfig[activity.status] || statusConfig.pending;

                if (isDeposit) {
                    const totalWeight = activity.items?.reduce((sum, item) => sum + parseFloat(item.weight || 0), 0) || 0;
                    const totalPoints = activity.total_points || 0;

                    return `
                        <div onclick="showDetail('deposit', ${activity.id})" 
                             class="flex items-center justify-between p-4 bg-gradient-to-r from-green-50 to-green-100 rounded-xl border-l-4 border-green-500 cursor-pointer hover:shadow-md transition-shadow">
                            <div class="flex items-center space-x-4">
                                <div class="w-12 h-12 bg-green-500 rounded-xl flex items-center justify-center shadow-sm">
                                    <i class="bi bi-arrow-up text-white text-xl"></i>
                                </div>
                                <div>
                                    <div class="flex items-center space-x-2 mb-1">
                                        <span class="font-semibold text-gray-800">Setor Sampah</span>
                                    </div>
                                    <div class="flex items-center space-x-4 text-sm text-gray-500">
                                        <span>${date}</span>
                                        <span class="flex items-center space-x-1">
                                            <i class="bi bi-box text-gray-500"></i>
                                            <span>${totalWeight.toFixed(1)} kg</span>
                                        </span>
                                        <span class="${status.bg} ${status.text} px-3 py-1 rounded-full text-xs font-semibold">${status.label}</span>
                                    </div>
                                </div>
                            </div>
                            <div class="text-right">
                                <div class="font-bold text-green-600 text-lg">+ ${totalPoints.toLocaleString('id-ID')} <i class="bi bi-currency-dollar"></i></div>
                            </div>
                        </div>
                    `;
                } else {
                    const totalPoints = activity.total_points || 0;
                    // Hanya tampilkan minus poin jika sudah dikonfirmasi/selesai
                    const showDeduction = ['confirmed', 'completed'].includes(activity.status);
                    const pointsDisplay = showDeduction 
                        ? `- ${totalPoints.toLocaleString('id-ID')}` 
                        : `${totalPoints.toLocaleString('id-ID')}`;
                    const pointsColor = showDeduction ? 'text-blue-600' : 'text-gray-500';

                    return `
                        <div onclick="showDetail('redemption', ${activity.id})" 
                             class="flex items-center justify-between p-4 bg-gradient-to-r from-blue-50 to-blue-100 rounded-xl border-l-4 border-blue-500 cursor-pointer hover:shadow-md transition-shadow">
                            <div class="flex items-center space-x-4">
                                <div class="w-12 h-12 bg-blue-500 rounded-xl flex items-center justify-center shadow-sm">
                                    <i class="bi bi-arrow-down text-white text-xl"></i>
                                </div>
                                <div>
                                    <div class="flex items-center space-x-2 mb-1">
                                        <span class="font-semibold text-gray-800">Tukar Poin</span>
                                    </div>
                                    <div class="flex items-center space-x-4 text-sm text-gray-500">
                                        <span>${date}</span>
                                        <span class="${status.bg} ${status.text} px-3 py-1 rounded-full text-xs font-semibold">${status.label}</span>
                                    </div>
                                </div>
                            </div>
                            <div class="text-right">
                                <div class="font-bold ${pointsColor} text-lg">${pointsDisplay} <i class="bi bi-currency-dollar"></i></div>
                            </div>
                        </div>
                    `;
                }
            }).join('');
        }

        // Show detail modal
        async function showDetail(type, id) {
            const modal = document.getElementById('detail-modal');
            const modalContent = document.getElementById('modal-content');
            
            modal.classList.remove('hidden');
            modalContent.innerHTML = `
                <div class="flex justify-center py-8">
                    <div class="animate-spin rounded-full h-12 w-12 border-b-2 border-green-500"></div>
                </div>
            `;

            try {
                const endpoint = type === 'deposit' ? `/api/deposits/${id}` : `/api/redemptions/${id}`;
                const response = await fetch(endpoint);
                const data = await response.json();

                const date = new Date(data.created_at).toLocaleDateString('id-ID', {
                    weekday: 'long',
                    year: 'numeric',
                    month: 'long',
                    day: 'numeric',
                    hour: '2-digit',
                    minute: '2-digit'
                });

                document.getElementById('modal-date').textContent = date;

                if (type === 'deposit') {
                    renderDepositDetail(data);
                } else {
                    renderRedemptionDetail(data);
                }
            } catch (error) {
                console.error('Error fetching detail:', error);
                modalContent.innerHTML = `
                    <div class="text-center py-8 text-red-500">
                        <i class="bi bi-exclamation-circle text-4xl mb-2"></i>
                        <p>Gagal memuat detail</p>
                    </div>
                `;
            }
        }

        // Render deposit detail
        function renderDepositDetail(data) {
            document.getElementById('modal-title').textContent = 'Detail Setoran Sampah';
            
            const statusConfig = {
                pending: { bg: 'bg-yellow-100', border: 'border-yellow-500', text: 'text-yellow-800', label: 'Menunggu Konfirmasi' },
                verified: { bg: 'bg-green-100', border: 'border-green-500', text: 'text-green-800', label: 'Selesai' },
                confirmed: { bg: 'bg-blue-100', border: 'border-blue-500', text: 'text-blue-800', label: 'Siap Ambil' },
                completed: { bg: 'bg-green-100', border: 'border-green-500', text: 'text-green-800', label: 'Selesai' }
            };

            const status = statusConfig[data.status] || statusConfig.pending;

            const content = `
                <div class="${status.bg} ${status.border} border-l-4 p-4 rounded-lg mb-4">
                    <div class="flex items-center space-x-2">
                        <i class="bi bi-info-circle ${status.text}"></i>
                        <span class="${status.text} font-semibold">Status: ${status.label}</span>
                    </div>
                </div>

                <div class="grid grid-cols-2 gap-4 mb-6">
                    <div class="bg-gray-50 p-4 rounded-xl">
                        <p class="text-sm text-gray-500 mb-1">Total Berat</p>
                        <p class="text-xl font-bold text-gray-800">${data.items.reduce((sum, item) => sum + parseFloat(item.weight), 0).toFixed(2)} kg</p>
                    </div>
                    <div class="bg-green-50 p-4 rounded-xl">
                        <p class="text-sm text-gray-500 mb-1">Total Poin</p>
                        <p class="text-xl font-bold text-green-600">${(data.total_points || 0).toLocaleString('id-ID')}</p>
                    </div>
                </div>

                ${data.branch ? `
                    <div class="mb-6">
                        <h4 class="font-semibold text-gray-700 mb-2">Cabang</h4>
                        <div class="bg-gray-50 p-3 rounded-lg">
                            <i class="bi bi-geo-alt text-gray-500"></i>
                            <span class="text-gray-800">${data.branch.name}</span>
                        </div>
                    </div>
                ` : ''}

                <div>
                    <h4 class="font-semibold text-gray-700 mb-3">Detail Item</h4>
                    <div class="space-y-3">
                        ${data.items.map(item => `
                            <div class="flex items-center justify-between bg-gray-50 p-4 rounded-xl">
                                <div class="flex items-center space-x-3">
                                    <div class="w-10 h-10 bg-green-100 rounded-lg flex items-center justify-center">
                                        <i class="bi bi-recycle text-green-600"></i>
                                    </div>
                                    <div>
                                        <p class="font-semibold text-gray-800">${item.waste_type?.name || 'Sampah'}</p>
                                        <p class="text-sm text-gray-500">${item.weight} kg × ${item.points_per_kg || 0} poin/kg</p>
                                    </div>
                                </div>
                                <div class="text-right">
                                    <p class="font-bold text-green-600">+${(item.points || 0).toLocaleString('id-ID')}</p>
                                    <p class="text-xs text-gray-500">poin</p>
                                </div>
                            </div>
                        `).join('')}
                    </div>
                </div>

                ${data.notes ? `
                    <div class="mt-4 bg-blue-50 p-4 rounded-lg">
                        <p class="text-sm font-semibold text-blue-800 mb-1">Catatan:</p>
                        <p class="text-sm text-blue-700">${data.notes}</p>
                    </div>
                ` : ''}
            `;

            document.getElementById('modal-content').innerHTML = content;
        }

        // Render redemption detail
        function renderRedemptionDetail(data) {
            document.getElementById('modal-title').textContent = 'Detail Penukaran Poin';
            
            const statusConfig = {
                pending: { bg: 'bg-yellow-100', border: 'border-yellow-500', text: 'text-yellow-800', label: 'Menunggu Persetujuan' },
                confirmed: { bg: 'bg-blue-100', border: 'border-blue-500', text: 'text-blue-800', label: 'Siap Ambil' },
                completed: { bg: 'bg-green-100', border: 'border-green-500', text: 'text-green-800', label: 'Selesai' },
                approved: { bg: 'bg-green-100', border: 'border-green-500', text: 'text-green-800', label: 'Disetujui' },
                rejected: { bg: 'bg-red-100', border: 'border-red-500', text: 'text-red-800', label: 'Ditolak' },
                cancelled: { bg: 'bg-gray-100', border: 'border-gray-500', text: 'text-gray-800', label: 'Dibatalkan' }
            };

            const status = statusConfig[data.status] || statusConfig.pending;

            const expiresAt = data.expires_at ? new Date(data.expires_at) : null;
            const now = new Date();
            const isExpiringSoon = expiresAt && (expiresAt - now) < 24 * 60 * 60 * 1000 && data.status === 'pending';

            const content = `
                <div class="${status.bg} ${status.border} border-l-4 p-4 rounded-lg mb-4">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center space-x-2">
                            <i class="bi bi-info-circle ${status.text}"></i>
                            <span class="${status.text} font-semibold">Status: ${status.label}</span>
                        </div>
                        ${isExpiringSoon ? `
                            <span class="text-xs bg-orange-200 text-orange-800 px-2 py-1 rounded-full">
                                <i class="bi bi-clock"></i> Kadaluarsa ${expiresAt.toLocaleString('id-ID')}
                            </span>
                        ` : ''}
                    </div>
                </div>

                ${data.rejection_reason ? `
                    <div class="bg-red-50 border-l-4 border-red-500 p-4 rounded-lg mb-4">
                        <p class="text-sm font-semibold text-red-800 mb-1">Alasan Penolakan:</p>
                        <p class="text-sm text-red-700">${data.rejection_reason}</p>
                    </div>
                ` : ''}

                <div class="bg-blue-50 p-4 rounded-xl mb-6">
                    <p class="text-sm text-gray-500 mb-1">Total Poin Digunakan</p>
                    <p class="text-2xl font-bold text-blue-600">${(data.total_points || 0).toLocaleString('id-ID')} poin</p>
                </div>

                <div>
                    <h4 class="font-semibold text-gray-700 mb-3">Item yang Ditukar</h4>
                    <div class="space-y-3">
                        ${data.items?.map(item => `
                            <div class="flex items-center justify-between bg-gray-50 p-4 rounded-xl">
                                <div class="flex items-center space-x-3">
                                    <div class="w-10 h-10 bg-blue-100 rounded-lg flex items-center justify-center">
                                        <i class="bi bi-gift text-blue-600"></i>
                                    </div>
                                    <div>
                                        <p class="font-semibold text-gray-800">${item.reward_item?.name || 'Reward'}</p>
                                        <p class="text-sm text-gray-500">${item.quantity} item × ${(item.points || 0).toLocaleString('id-ID')} poin</p>
                                    </div>
                                </div>
                                <div class="text-right">
                                    <p class="font-bold text-blue-600">${((item.quantity * item.points) || 0).toLocaleString('id-ID')}</p>
                                    <p class="text-xs text-gray-500">poin</p>
                                </div>
                            </div>
                        `).join('') || '<p class="text-gray-500 text-center py-4">Tidak ada item</p>'}
                    </div>
                </div>
            `;

            document.getElementById('modal-content').innerHTML = content;
        }

        // Close modal
        function closeModal() {
            document.getElementById('detail-modal').classList.add('hidden');
        }

        // Close modal when clicking outside
        document.getElementById('detail-modal').addEventListener('click', function(e) {
            if (e.target === this) {
                closeModal();
            }
        });

        // Initial load
        document.addEventListener('DOMContentLoaded', function() {
            fetchDashboardData();
            
            // Auto refresh every 30 seconds
            setInterval(fetchDashboardData, 30000);
        });
    </script>

</body>
</html>addEventListener('mouseenter', function() {
                    this.style.transform = 'translateY(-1px)';
                });
                button.addEventListener('mouseleave', function() {
                    this.style.transform = 'translateY(0)';
                });
            });
n closeModal() {
            document.getElementById('detail-modal').classList.add('hidden');
        }

        // Close modal when clicking outside
        document.getElementById('detail-modal').addEventListener('click', function(e) {
            if (e.target === this) {
                closeModal();
            }
        });

        // Initial load
        document.addEventListener('DOMContentLoaded', function() {
            fetchDashboardData();
            
            // Auto refresh every 30 seconds
            setInterval(fetchDashboardData, 30000);
        });
    </script>

</body>
</html>tton.addEventListener('mouseenter', function() {
                    this.style.transform = 'translateY(-1px)';
                });
                button.addEventListener('mouseleave', function() {
                    this.style.transform = 'translateY(0)';
                });
            });
        });
    </script>

</body>
</html>