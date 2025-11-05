<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - Green Saving</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
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
        <div class="max-w-6xl mx-auto px-4 py-4">
            <div class="flex justify-between items-center">
                <!-- Logo -->
                <div class="flex items-center space-x-3">
                    <div class="w-12 h-12 bg-green-500 rounded-xl flex items-center justify-center">
                        <img src="{{ asset('images/logo user.png') }}" alt="Logo" class="w-7 h-7 filter brightness-0 invert">
                    </div>
                    <div>
                        <h1 class="text-xl font-bold text-gray-800">Green Saving</h1>
                        <p class="text-sm text-gray-500">Halo, {{ Auth::user()->full_name ?? 'Budi Santoso' }}</p>
                    </div>
                </div>

                <!-- Points and Actions -->
                <div class="flex items-center space-x-4">
                    <div class="bg-green-100 px-6 py-2 rounded-full">
                        <span class="text-lg font-bold text-green-700">{{ Auth::user()->balance_points ?? 15420 }} poin</span>
                    </div>
                    <button class="w-10 h-10 bg-gray-100 rounded-xl flex items-center justify-center hover:bg-gray-200 transition-colors">
                        <svg class="w-5 h-5 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-5 5v-5zM4 19h6v2H4v-2zm0-4h10v2H4v-2zm0-4h10v2H4v-2z"></path>
                        </svg>
                    </button>
                    <button class="w-10 h-10 bg-gray-100 rounded-xl flex items-center justify-center hover:bg-gray-200 transition-colors">
                        <svg class="w-5 h-5 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                        </svg>
                    </button>
                    <form method="POST" action="/logout" class="inline">
                        @csrf
                        <button type="submit" class="w-10 h-10 bg-gray-100 rounded-xl flex items-center justify-center hover:bg-gray-200 transition-colors">
                            <svg class="w-5 h-5 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path>
                            </svg>
                        </button>
                    </form>
                </div>
            </div>
        </div>

        <!-- Navigation Tabs -->
        <div class="bg-green-100 px-4 py-3">
            <div class="max-w-6xl mx-auto">
                <!-- Main navigation row -->
                <div class="flex flex-wrap gap-2 mb-3">
                    <button class="bg-green-500 text-white px-6 py-2 rounded-xl text-sm font-semibold shadow-sm">
                        🏠 Dashboard
                    </button>
                    <button class="bg-white text-green-700 px-6 py-2 rounded-xl text-sm font-semibold hover:bg-green-50 transition-colors">
                        👤 Profil
                    </button>
                    <button class="bg-white text-green-700 px-6 py-2 rounded-xl text-sm font-semibold hover:bg-green-50 transition-colors">
                        ♻️ Setor
                    </button>
                    <button class="bg-white text-green-700 px-6 py-2 rounded-xl text-sm font-semibold hover:bg-green-50 transition-colors">
                        🎁 Tukar Point
                    </button>
                </div>
                <!-- Secondary navigation row -->
                <div class="flex flex-wrap gap-2">
                    <button class="bg-white text-green-700 px-6 py-2 rounded-xl text-sm font-semibold hover:bg-green-50 transition-colors">
                        📊 Riwayat
                    </button>
                    <button class="bg-white text-green-700 px-6 py-2 rounded-xl text-sm font-semibold hover:bg-green-50 transition-colors">
                        🔔 Notifikasi
                    </button>
                </div>
            </div>
        </div>
    </header>

    <!-- Main Content -->
    <main class="max-w-6xl mx-auto px-4 py-6">
        
        <!-- Welcome Card -->
        <div class="bg-gradient-to-r from-green-500 to-green-600 rounded-2xl p-6 mb-6 text-white shadow-lg">
            <div class="flex flex-col md:flex-row items-start md:items-center justify-between gap-6">
                <div class="flex-1">
                    <h2 class="text-2xl font-bold mb-2">Selamat Datang, {{ Auth::user()->full_name ?? 'Budi Santoso' }}</h2>
                    <div class="flex flex-wrap items-center gap-4 mt-4">
                        <div class="bg-white bg-opacity-20 backdrop-blur-sm text-white px-4 py-2 rounded-lg text-sm font-semibold">
                            Silver Member
                        </div>
                        <span class="text-sm opacity-90">Member sejak Jan 2024</span>
                    </div>
                </div>
                <div class="text-center md:text-right">
                    <div class="bg-white bg-opacity-15 backdrop-blur-sm rounded-2xl px-6 py-4 mb-4">
                        <div class="text-3xl font-bold">{{ Auth::user()->balance_points ?? '15420' }}</div>
                        <div class="text-sm opacity-90">ECO coin</div>
                    </div>
                    <button class="bg-white bg-opacity-20 backdrop-blur-sm hover:bg-opacity-30 text-white px-6 py-2 rounded-xl text-sm font-semibold transition-all duration-200">
                        Jelajah bersantaka
                    </button>
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
                <button class="bg-gray-100 hover:bg-gray-200 px-4 py-2 rounded-xl text-sm font-semibold text-gray-700 transition-colors">
                    Lihat Semua
                </button>
            </div>

            <!-- Activity Items -->
            <div class="space-y-4">
                <!-- Setor Plastik PET -->
                <div class="flex items-center justify-between p-4 bg-gradient-to-r from-green-50 to-green-100 rounded-xl border-l-4 border-green-500">
                    <div class="flex items-center space-x-4">
                        <div class="w-12 h-12 bg-green-500 rounded-xl flex items-center justify-center shadow-sm">
                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 11l5-5m0 0l5 5m-5-5v12"></path>
                            </svg>
                        </div>
                        <div>
                            <div class="flex items-center space-x-2 mb-1">
                                <span class="font-semibold text-gray-800">Setor Plastik PET</span>
                            </div>
                            <div class="flex items-center space-x-4 text-sm text-gray-500">
                                <span>2024 - 1 - 11</span>
                                <span class="flex items-center space-x-1">
                                    <span>📦 2.5 kg</span>
                                </span>
                                <span class="bg-green-200 text-green-800 px-3 py-1 rounded-full text-xs font-semibold">Selesai</span>
                            </div>
                        </div>
                    </div>
                    <div class="text-right">
                        <div class="font-bold text-green-600 text-lg">+ 500 💰</div>
                    </div>
                </div>

                <!-- Tukar Point -->
                <div class="flex items-center justify-between p-4 bg-gradient-to-r from-blue-50 to-blue-100 rounded-xl border-l-4 border-blue-500">
                    <div class="flex items-center space-x-4">
                        <div class="w-12 h-12 bg-blue-500 rounded-xl flex items-center justify-center shadow-sm">
                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2"></path>
                            </svg>
                        </div>
                        <div>
                            <div class="flex items-center space-x-2 mb-1">
                                <span class="font-semibold text-gray-800">Tukar Point 1000</span>
                            </div>
                            <div class="flex items-center space-x-4 text-sm text-gray-500">
                                <span>2024 - 1 - 11</span>
                                <span class="bg-blue-200 text-blue-800 px-3 py-1 rounded-full text-xs font-semibold">Berhasil</span>
                            </div>
                        </div>
                    </div>
                    <div class="text-right">
                        <div class="font-bold text-blue-600 text-lg">- 500 💰</div>
                    </div>
                </div>

                <!-- Setor Plastik PET 2 -->
                <div class="flex items-center justify-between p-4 bg-gradient-to-r from-green-50 to-green-100 rounded-xl border-l-4 border-green-500">
                    <div class="flex items-center space-x-4">
                        <div class="w-12 h-12 bg-green-500 rounded-xl flex items-center justify-center shadow-sm">
                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 11l5-5m0 0l5 5m-5-5v12"></path>
                            </svg>
                        </div>
                        <div>
                            <div class="flex items-center space-x-2 mb-1">
                                <span class="font-semibold text-gray-800">Setor Plastik PET</span>
                            </div>
                            <div class="flex items-center space-x-4 text-sm text-gray-500">
                                <span>2024 - 1 - 11</span>
                                <span class="flex items-center space-x-1">
                                    <span>📦 2.5 kg</span>
                                </span>
                                <span class="bg-green-200 text-green-800 px-3 py-1 rounded-full text-xs font-semibold">Selesai</span>
                            </div>
                        </div>
                    </div>
                    <div class="text-right">
                        <div class="font-bold text-green-600 text-lg">+ 500 💰</div>
                    </div>
                </div>

                <!-- Tukar Point 1000 -->
                <div class="flex items-center justify-between p-4 bg-gradient-to-r from-blue-50 to-blue-100 rounded-xl border-l-4 border-blue-500">
                    <div class="flex items-center space-x-4">
                        <div class="w-12 h-12 bg-blue-500 rounded-xl flex items-center justify-center shadow-sm">
                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2"></path>
                            </svg>
                        </div>
                        <div>
                            <div class="flex items-center space-x-2 mb-1">
                                <span class="font-semibold text-gray-800">Tukar Point 1000</span>
                            </div>
                            <div class="flex items-center space-x-4 text-sm text-gray-500">
                                <span>2024 - 1 - 11</span>
                                <span class="bg-blue-200 text-blue-800 px-3 py-1 rounded-full text-xs font-semibold">Berhasil</span>
                            </div>
                        </div>
                    </div>
                    <div class="text-right">
                        <div class="font-bold text-blue-600 text-lg">- 500 💰</div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Achievement Section -->
        <div class="bg-white rounded-2xl p-6 shadow-sm">
            <div class="flex items-center space-x-3 mb-6">
                <div class="w-8 h-8 bg-yellow-100 rounded-xl flex items-center justify-center">
                    <span class="text-xl">🏆</span>
                </div>
                <h3 class="text-xl font-bold text-gray-800">Achievement</h3>
            </div>
            
            <div class="space-y-4">
                <!-- First Deposit -->
                <div class="flex items-center justify-between p-5 bg-gradient-to-r from-green-50 to-green-100 rounded-2xl border border-green-200">
                    <div class="flex items-center space-x-4">
                        <div class="w-12 h-12 bg-green-500 rounded-2xl flex items-center justify-center shadow-sm">
                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4"></path>
                            </svg>
                        </div>
                        <div>
                            <h4 class="font-bold text-gray-800">First Deposit</h4>
                            <p class="text-sm text-gray-600 mb-2">Setor sampah pertama kali</p>
                            <span class="inline-block bg-green-200 text-green-800 px-3 py-1 rounded-full text-xs font-semibold">100 poin</span>
                        </div>
                    </div>
                    <div class="flex items-center space-x-2">
                        <span class="text-green-600 text-sm font-semibold">selesai</span>
                        <div class="w-6 h-6 bg-green-500 rounded-full flex items-center justify-center">
                            <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                            </svg>
                        </div>
                    </div>
                </div>

                <!-- Eco Warrior -->
                <div class="flex items-center justify-between p-5 bg-gradient-to-r from-green-50 to-green-100 rounded-2xl border border-green-200">
                    <div class="flex items-center space-x-4">
                        <div class="w-12 h-12 bg-green-500 rounded-2xl flex items-center justify-center shadow-sm">
                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4"></path>
                            </svg>
                        </div>
                        <div>
                            <h4 class="font-bold text-gray-800">Eco Warrior</h4>
                            <p class="text-sm text-gray-600 mb-2">Setor 50kg sampah</p>
                            <span class="inline-block bg-green-200 text-green-800 px-3 py-1 rounded-full text-xs font-semibold">500 poin</span>
                        </div>
                    </div>
                    <div class="flex items-center space-x-2">
                        <span class="text-green-600 text-sm font-semibold">selesai</span>
                        <div class="w-6 h-6 bg-green-500 rounded-full flex items-center justify-center">
                            <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                            </svg>
                        </div>
                    </div>
                </div>

                <!-- Green Champion -->
                <div class="flex items-center justify-between p-5 bg-gradient-to-r from-gray-50 to-gray-100 rounded-2xl border border-gray-200">
                    <div class="flex items-center space-x-4">
                        <div class="w-12 h-12 bg-gray-400 rounded-2xl flex items-center justify-center shadow-sm">
                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
                            </svg>
                        </div>
                        <div>
                            <h4 class="font-bold text-gray-800">Green Champion</h4>
                            <p class="text-sm text-gray-600 mb-2">Setor 100kg sampah</p>
                            <span class="inline-block bg-gray-200 text-gray-700 px-3 py-1 rounded-full text-xs font-semibold">1000 poin</span>
                        </div>
                    </div>
                    <div class="w-6 h-6 bg-gray-300 rounded-full"></div>
                </div>
            </div>
        </div>



    </main>

    <!-- Footer -->
    <footer class="bg-white border-t mt-12">
        <div class="max-w-6xl mx-auto px-6 py-6">
            <div class="flex items-center justify-center">
                <div class="flex items-center space-x-2 text-green-600">
                    <span class="text-lg">🌱</span>
                    <span class="text-sm font-medium">Bersama menjaga lingkungan untuk masa depan lebih baik</span>
                </div>
            </div>
        </div>
    </footer>

    <script>
        // Add mobile menu toggle functionality if needed
        document.addEventListener('DOMContentLoaded', function() {
            // Smooth scroll for navigation
            const buttons = document.querySelectorAll('button');
            buttons.forEach(button => {
                button.addEventListener('mouseenter', function() {
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