<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
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
                        <p class="text-sm text-green-600">Halo, {{ Auth::user()->full_name ?? Auth::user()->name ?? 'lisbeth' }}</p>
                    </div>
                </div>

                <!-- Points & Actions -->
                <div class="flex items-center space-x-4">
                    <!-- Points Display -->
                    <div class="bg-gradient-to-r from-green-100 to-green-50 px-6 py-3 rounded-full border-2 border-green-200 shadow-sm">
                        <div class="flex items-center space-x-2">
                            <i class="bi bi-coin text-green-600 text-xl"></i>
                            <span class="font-bold text-green-700 text-lg">15420 poin</span>
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
                        <div class="text-3xl font-bold">15,420</div>
                        <div class="text-sm opacity-90">ECO coin</div>
                    </div>
                    <button class="bg-white bg-opacity-20 backdrop-blur-sm hover:bg-opacity-30 text-white px-6 py-2 rounded-xl text-sm font-semibold transition-all duration-200">
                        Jelajahi marketplace
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
                            <i class="bi bi-arrow-up text-white text-xl"></i>
                        </div>
                        <div>
                            <div class="flex items-center space-x-2 mb-1">
                                <span class="font-semibold text-gray-800">Setor Plastik PET</span>
                            </div>
                            <div class="flex items-center space-x-4 text-sm text-gray-500">
                                <span>2024 - 1 - 11</span>
                                <span class="flex items-center space-x-1">
                                    <i class="bi bi-box text-gray-500"></i>
                                    <span>2.5 kg</span>
                                </span>
                                <span class="bg-green-200 text-green-800 px-3 py-1 rounded-full text-xs font-semibold">Selesai</span>
                            </div>
                        </div>
                    </div>
                    <div class="text-right">
                        <div class="font-bold text-green-600 text-lg">+ 500 <i class="bi bi-currency-dollar"></i></div>
                    </div>
                </div>

                <!-- Tukar Point -->
                <div class="flex items-center justify-between p-4 bg-gradient-to-r from-blue-50 to-blue-100 rounded-xl border-l-4 border-blue-500">
                    <div class="flex items-center space-x-4">
                        <div class="w-12 h-12 bg-blue-500 rounded-xl flex items-center justify-center shadow-sm">
                            <i class="bi bi-arrow-down text-white text-xl"></i>
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
                        <div class="font-bold text-blue-600 text-lg">- 500 <i class="bi bi-currency-dollar"></i></div>
                    </div>
                </div>

                <!-- Setor Plastik PET 2 -->
                <div class="flex items-center justify-between p-4 bg-gradient-to-r from-green-50 to-green-100 rounded-xl border-l-4 border-green-500">
                    <div class="flex items-center space-x-4">
                        <div class="w-12 h-12 bg-green-500 rounded-xl flex items-center justify-center shadow-sm">
                            <i class="bi bi-arrow-up text-white text-xl"></i>
                        </div>
                        <div>
                            <div class="flex items-center space-x-2 mb-1">
                                <span class="font-semibold text-gray-800">Setor Plastik PET</span>
                            </div>
                            <div class="flex items-center space-x-4 text-sm text-gray-500">
                                <span>2024 - 1 - 11</span>
                                <span class="flex items-center space-x-1">
                                    <i class="bi bi-box text-gray-500"></i>
                                    <span>2.5 kg</span>
                                </span>
                                <span class="bg-green-200 text-green-800 px-3 py-1 rounded-full text-xs font-semibold">Selesai</span>
                            </div>
                        </div>
                    </div>
                    <div class="text-right">
                        <div class="font-bold text-green-600 text-lg">+ 500 <i class="bi bi-currency-dollar"></i></div>
                    </div>
                </div>

                <!-- Tukar Point 1000 -->
                <div class="flex items-center justify-between p-4 bg-gradient-to-r from-blue-50 to-blue-100 rounded-xl border-l-4 border-blue-500">
                    <div class="flex items-center space-x-4">
                        <div class="w-12 h-12 bg-blue-500 rounded-xl flex items-center justify-center shadow-sm">
                            <i class="bi bi-arrow-down text-white text-xl"></i>
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
                        <div class="font-bold text-blue-600 text-lg">- 500 <i class="bi bi-currency-dollar"></i></div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Achievement Section -->
        <div class="bg-white rounded-2xl p-6 shadow-sm">
            <div class="flex items-center space-x-3 mb-6">
                <div class="w-8 h-8 bg-yellow-100 rounded-xl flex items-center justify-center">
                    <i class="bi bi-trophy text-yellow-600"></i>
                </div>
                <h3 class="text-xl font-bold text-gray-800">Achievement</h3>
            </div>
            
            <div class="space-y-4">
                <!-- First Deposit -->
                <div class="flex items-center justify-between p-5 bg-gradient-to-r from-green-50 to-green-100 rounded-2xl border border-green-200">
                    <div class="flex items-center space-x-4">
                        <div class="w-12 h-12 bg-green-500 rounded-2xl flex items-center justify-center shadow-sm">
                            <i class="bi bi-check-lg text-white text-xl"></i>
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
                            <i class="bi bi-check text-white"></i>
                        </div>
                    </div>
                </div>

                <!-- Eco Warrior -->
                <div class="flex items-center justify-between p-5 bg-gradient-to-r from-green-50 to-green-100 rounded-2xl border border-green-200">
                    <div class="flex items-center space-x-4">
                        <div class="w-12 h-12 bg-green-500 rounded-2xl flex items-center justify-center shadow-sm">
                            <i class="bi bi-check-lg text-white text-xl"></i>
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
                            <i class="bi bi-check text-white"></i>
                        </div>
                    </div>
                </div>

                <!-- Green Champion -->
                <div class="flex items-center justify-between p-5 bg-gradient-to-r from-gray-50 to-gray-100 rounded-2xl border border-gray-200">
                    <div class="flex items-center space-x-4">
                        <div class="w-12 h-12 bg-gray-400 rounded-2xl flex items-center justify-center shadow-sm">
                            <i class="bi bi-lock text-white text-xl"></i>
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