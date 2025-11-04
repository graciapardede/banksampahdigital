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
                    },
                    colors: {
                        'green-primary': '#2e7d32',
                        'green-secondary': '#66bb6a',
                        'green-light': '#c8e6c9',
                        'green-bg': '#e8f5e9',
                    }
                }
            }
        }
    </script>
</head>

<body class="bg-gradient-to-br from-green-50 to-green-100 min-h-screen font-poppins">
    
    <!-- Header -->
    <header class="bg-white shadow-sm px-6 py-4">
        <div class="flex items-center justify-between max-w-7xl mx-auto">
            <!-- Logo and Title -->
            <div class="flex items-center gap-3">
                <div class="w-12 h-12 bg-green-secondary rounded-xl flex items-center justify-center">
                    <svg class="w-6 h-6 text-white" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M12 2C13.1 2 14 2.9 14 4C14 5.1 13.1 6 12 6C10.9 6 10 5.1 10 4C10 2.9 10.9 2 12 2ZM21 9V7L15 1H5C3.89 1 3 1.89 3 3V19C3 20.1 3.9 21 5 21H11V19H5V3H13V9H21Z"/>
                    </svg>
                </div>
                <div>
                    <h1 class="text-xl font-bold text-green-primary">Green Saving</h1>
                    <p class="text-sm text-gray-600">Halo, Budi Santoso</p>
                </div>
            </div>

            <!-- Header Right -->
            <div class="flex items-center gap-4">
                <!-- Points -->
                <div class="bg-green-light/30 px-4 py-2 rounded-full">
                    <span class="text-green-primary font-semibold">15420 poin</span>
                </div>
                
                <!-- Notification -->
                <button class="p-2 hover:bg-gray-100 rounded-full transition-colors">
                    <svg class="w-6 h-6 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-5 5v-5zM4 19h7v-7H4v7zM4 5h16v7H4V5z"/>
                    </svg>
                </button>

                <!-- Profile -->
                <button class="p-2 hover:bg-gray-100 rounded-full transition-colors">
                    <svg class="w-6 h-6 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                    </svg>
                </button>

                <!-- Logout -->
                <a href="/login" class="p-2 hover:bg-gray-100 rounded-full transition-colors">
                    <svg class="w-6 h-6 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>
                    </svg>
                </a>
            </div>
        </div>
    </header>

    <!-- Main Content -->
    <main class="max-w-7xl mx-auto px-6 py-8">
        
        <!-- Navigation Tabs -->
        <div class="bg-white rounded-2xl p-2 mb-6 shadow-sm">
            <div class="flex flex-wrap gap-2">
                <button class="px-6 py-3 bg-green-light/50 text-green-primary font-semibold rounded-xl flex items-center gap-2">
                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M10 20v-6h4v6h5v-8h3L12 3 2 12h3v8z"/>
                    </svg>
                    Dashboard
                </button>
                <button class="px-6 py-3 text-gray-600 font-medium rounded-xl hover:bg-gray-50 flex items-center gap-2 transition-colors">
                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z"/>
                    </svg>
                    Profil
                </button>
                <button class="px-6 py-3 text-gray-600 font-medium rounded-xl hover:bg-gray-50 flex items-center gap-2 transition-colors">
                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/>
                    </svg>
                    Setor
                </button>
                <button class="px-6 py-3 text-gray-600 font-medium rounded-xl hover:bg-gray-50 flex items-center gap-2 transition-colors">
                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-2 15l-5-5 1.41-1.41L10 14.17l7.59-7.59L19 8l-9 9z"/>
                    </svg>
                    Tukar Point
                </button>
            </div>
            
            <!-- Secondary Tabs -->
            <div class="flex gap-2 mt-3">
                <button class="px-6 py-2 bg-green-secondary text-white font-medium rounded-xl">
                    Riwayat
                </button>
                <button class="px-6 py-2 text-gray-600 font-medium rounded-xl hover:bg-gray-50 transition-colors">
                    Notifikasi
                </button>
            </div>
        </div>

        <!-- Welcome Card -->
        <div class="bg-gradient-to-r from-green-secondary to-green-primary rounded-2xl p-8 mb-8 text-white">
            <div class="flex justify-between items-center">
                <div>
                    <h2 class="text-2xl font-bold mb-2">Selamat Datang, Budi Santoso</h2>
                    <div class="flex items-center gap-4 mb-4">
                        <span class="bg-white/20 px-3 py-1 rounded-full text-sm font-medium">Silver Member</span>
                        <span class="text-sm opacity-90">Member sejak Jan 2024</span>
                    </div>
                </div>
                <div class="text-right">
                    <div class="text-3xl font-bold">15420</div>
                    <div class="text-sm opacity-90">ECO Point</div>
                    <button class="bg-white/20 hover:bg-white/30 px-4 py-2 rounded-lg text-sm font-medium mt-2 transition-colors">
                        Jelajahi Marketplace
                    </button>
                </div>
            </div>
        </div>

        <!-- Activities Section -->
        <div class="bg-white rounded-2xl p-6 mb-8 shadow-sm">
            <div class="flex justify-between items-center mb-6">
                <h3 class="text-xl font-bold text-gray-900">Aktivitas Terbaru</h3>
                <p class="text-gray-600">Transaksi dan setoran terbaru Anda</p>
                <button class="text-green-primary font-medium hover:underline">Lihat Semua</button>
            </div>

            <!-- Activity Items -->
            <div class="space-y-4">
                <!-- Activity Item 1 -->
                <div class="flex items-center justify-between p-4 bg-gray-50 rounded-xl">
                    <div class="flex items-center gap-4">
                        <div class="w-12 h-12 bg-green-100 rounded-xl flex items-center justify-center">
                            <svg class="w-6 h-6 text-green-primary transform rotate-45" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 11l5-5m0 0l5 5m-5-5v12"/>
                            </svg>
                        </div>
                        <div>
                            <h4 class="font-semibold text-gray-900">Setor Plastik PET</h4>
                            <div class="flex items-center gap-4 text-sm text-gray-600">
                                <span>📅 2024 - 3 - 11</span>
                                <span>⚖️ 2.5 kg</span>
                                <span class="bg-green-100 text-green-primary px-2 py-1 rounded">Selesai</span>
                            </div>
                        </div>
                    </div>
                    <div class="text-green-primary font-bold">+ 500 💰</div>
                </div>

                <!-- Activity Item 2 -->
                <div class="flex items-center justify-between p-4 bg-gray-50 rounded-xl">
                    <div class="flex items-center gap-4">
                        <div class="w-12 h-12 bg-blue-100 rounded-xl flex items-center justify-center">
                            <svg class="w-6 h-6 text-blue-600 transform -rotate-45" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 11l5-5m0 0l5 5m-5-5v12"/>
                            </svg>
                        </div>
                        <div>
                            <h4 class="font-semibold text-gray-900">Tukar Point 1000</h4>
                            <div class="flex items-center gap-4 text-sm text-gray-600">
                                <span>📅 2024 - 3 - 11</span>
                                <span class="bg-blue-100 text-blue-600 px-2 py-1 rounded">Selesai</span>
                            </div>
                        </div>
                    </div>
                    <div class="text-blue-600 font-bold">- 500 💰</div>
                </div>

                <!-- Activity Item 3 -->
                <div class="flex items-center justify-between p-4 bg-gray-50 rounded-xl">
                    <div class="flex items-center gap-4">
                        <div class="w-12 h-12 bg-green-100 rounded-xl flex items-center justify-center">
                            <svg class="w-6 h-6 text-green-primary transform rotate-45" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 11l5-5m0 0l5 5m-5-5v12"/>
                            </svg>
                        </div>
                        <div>
                            <h4 class="font-semibold text-gray-900">Setor Plastik PET</h4>
                            <div class="flex items-center gap-4 text-sm text-gray-600">
                                <span>📅 2024 - 3 - 11</span>
                                <span>⚖️ 2.5 kg</span>
                                <span class="bg-green-100 text-green-primary px-2 py-1 rounded">Selesai</span>
                            </div>
                        </div>
                    </div>
                    <div class="text-green-primary font-bold">+ 500 💰</div>
                </div>

                <!-- Activity Item 4 -->
                <div class="flex items-center justify-between p-4 bg-gray-50 rounded-xl">
                    <div class="flex items-center gap-4">
                        <div class="w-12 h-12 bg-blue-100 rounded-xl flex items-center justify-center">
                            <svg class="w-6 h-6 text-blue-600 transform -rotate-45" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 11l5-5m0 0l5 5m-5-5v12"/>
                            </svg>
                        </div>
                        <div>
                            <h4 class="font-semibold text-gray-900">Tukar Point 1000</h4>
                            <div class="flex items-center gap-4 text-sm text-gray-600">
                                <span>📅 2024 - 3 - 11</span>
                                <span class="bg-blue-100 text-blue-600 px-2 py-1 rounded">Selesai</span>
                            </div>
                        </div>
                    </div>
                    <div class="text-blue-600 font-bold">- 500 💰</div>
                </div>
            </div>
        </div>

        <!-- Achievement Section -->
        <div class="bg-white rounded-2xl p-6 shadow-sm">
            <div class="flex items-center gap-3 mb-6">
                <svg class="w-6 h-6 text-yellow-500" fill="currentColor" viewBox="0 0 24 24">
                    <path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/>
                </svg>
                <h3 class="text-xl font-bold text-gray-900">Achievement</h3>
            </div>

            <div class="space-y-4">
                <!-- Achievement 1 -->
                <div class="flex items-center justify-between p-4 border border-green-200 rounded-xl bg-green-50/50">
                    <div>
                        <h4 class="font-semibold text-gray-900">First Deposit</h4>
                        <p class="text-sm text-gray-600">Setor sampah pertama kali</p>
                        <span class="inline-block bg-green-100 text-green-primary text-xs px-2 py-1 rounded-full mt-1">100 poin</span>
                    </div>
                    <div class="flex items-center gap-2">
                        <span class="text-green-primary text-sm font-medium">selesai ✓</span>
                        <div class="w-8 h-8 bg-green-primary rounded-full flex items-center justify-center">
                            <svg class="w-5 h-5 text-white" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M9 16.17L4.83 12l-1.42 1.41L9 19 21 7l-1.41-1.41z"/>
                            </svg>
                        </div>
                    </div>
                </div>

                <!-- Achievement 2 -->
                <div class="flex items-center justify-between p-4 border border-green-200 rounded-xl bg-green-50/50">
                    <div>
                        <h4 class="font-semibold text-gray-900">Eco Warrior</h4>
                        <p class="text-sm text-gray-600">Setor 50kg sampah</p>
                        <span class="inline-block bg-green-100 text-green-primary text-xs px-2 py-1 rounded-full mt-1">500 poin</span>
                    </div>
                    <div class="flex items-center gap-2">
                        <span class="text-green-primary text-sm font-medium">selesai ✓</span>
                        <div class="w-8 h-8 bg-green-primary rounded-full flex items-center justify-center">
                            <svg class="w-5 h-5 text-white" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M9 16.17L4.83 12l-1.42 1.41L9 19 21 7l-1.41-1.41z"/>
                            </svg>
                        </div>
                    </div>
                </div>

                <!-- Achievement 3 -->
                <div class="flex items-center justify-between p-4 border border-gray-200 rounded-xl bg-gray-50">
                    <div>
                        <h4 class="font-semibold text-gray-900">Green Champion</h4>
                        <p class="text-sm text-gray-600">Setor 100kg sampah</p>
                        <span class="inline-block bg-gray-100 text-gray-600 text-xs px-2 py-1 rounded-full mt-1">1000 poin</span>
                    </div>
                    <div class="w-8 h-8 bg-gray-300 rounded-full flex items-center justify-center">
                        <svg class="w-5 h-5 text-white" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-2 15l-5-5 1.41-1.41L10 14.17l7.59-7.59L19 8l-9 9z"/>
                        </svg>
                    </div>
                </div>
            </div>
        </div>

    </main>

</body>
</html>