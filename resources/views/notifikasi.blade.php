<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Notifikasi - Green Saving</title>
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
                        <p class="text-sm text-green-600">Halo, Budi Santoso</p>
                    </div>
                </div>

                <!-- Points & Actions -->
                <div class="flex items-center space-x-4">
                    <!-- Points Display -->
                    <div class="bg-gradient-to-r from-green-100 to-green-50 px-6 py-3 rounded-full border-2 border-green-300 shadow-md">
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
                    <a href="/dashboard" class="bg-white text-gray-700 px-4 lg:px-6 py-3 rounded-2xl text-xs lg:text-sm font-semibold hover:bg-green-50 transition-colors shadow-sm flex items-center justify-center space-x-2 w-full cursor-pointer">
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
                    <a href="/notifikasi" class="bg-green-500 text-white px-4 lg:px-6 py-3 rounded-2xl text-xs lg:text-sm font-semibold shadow-md flex items-center justify-center space-x-2 w-full cursor-default">
                        <i class="bi bi-bell pointer-events-none"></i>
                        <span class="truncate pointer-events-none">Notifikasi</span>
                    </a>
                </div>
            </div>
        </div>
    </header>

    <!-- Main Content -->
    <main class="max-w-6xl mx-auto px-4 py-8">
        
        <!-- Page Title -->
        <div class="mb-6">
            <h2 class="text-2xl font-bold text-gray-800 mb-2">Notifikasi</h2>
            <p class="text-gray-600">Kelola notifikasi dan pengaturan pemberitahuan</p>
        </div>

        <!-- Notification List -->
        <div class="space-y-4">

            <!-- Notification Item 1 - Setoran Sampah Diverifikasi -->
            <div class="bg-white rounded-2xl p-5 shadow-sm border-l-4 border-green-500 hover:shadow-md transition-all">
                <div class="flex items-start space-x-4">
                    <!-- Icon -->
                    <div class="w-3 h-3 bg-green-500 rounded-full mt-2 flex-shrink-0"></div>
                    
                    <!-- Content -->
                    <div class="flex-1">
                        <h3 class="font-bold text-gray-800 text-base mb-1">Setoran Sampah Diverifikasi</h3>
                        <p class="text-sm text-gray-600 mb-2">Setoran plastik 2.5kg Anda telah diverifikasi. +250 telah ditambahkan ke akun Anda.</p>
                        <span class="text-xs text-gray-400">2 jam yang lalu</span>
                    </div>
                </div>
            </div>

            <!-- Notification Item 2 - Penukaran Poin Berhasil -->
            <div class="bg-white rounded-2xl p-5 shadow-sm border-l-4 border-blue-500 hover:shadow-md transition-all">
                <div class="flex items-start space-x-4">
                    <!-- Icon -->
                    <div class="w-3 h-3 bg-blue-500 rounded-full mt-2 flex-shrink-0"></div>
                    
                    <!-- Content -->
                    <div class="flex-1">
                        <h3 class="font-bold text-gray-800 text-base mb-1">Penukaran Poin Berhasil</h3>
                        <p class="text-sm text-gray-600 mb-2">Penukaran 1500 poin telah diproses. Mohon ambil dalam waktu h+2jam sebelum ditutup.</p>
                        <span class="text-xs text-gray-400">5 jam yang lalu</span>
                    </div>
                </div>
            </div>

            <!-- Notification Item 3 - Setoran Sampah Diverifikasi -->
            <div class="bg-white rounded-2xl p-5 shadow-sm border-l-4 border-green-500 hover:shadow-md transition-all">
                <div class="flex items-start space-x-4">
                    <!-- Icon -->
                    <div class="w-3 h-3 bg-green-500 rounded-full mt-2 flex-shrink-0"></div>
                    
                    <!-- Content -->
                    <div class="flex-1">
                        <h3 class="font-bold text-gray-800 text-base mb-1">Setoran Sampah Diverifikasi</h3>
                        <p class="text-sm text-gray-600 mb-2">Setoran plastik 2.5kg Anda telah diverifikasi. +250 telah ditambahkan ke akun Anda.</p>
                        <span class="text-xs text-gray-400">1 hari yang lalu</span>
                    </div>
                </div>
            </div>

            <!-- Notification Item 4 - Promosi -->
            <div class="bg-white rounded-2xl p-5 shadow-sm border-l-4 border-purple-500 hover:shadow-md transition-all">
                <div class="flex items-start space-x-4">
                    <!-- Icon -->
                    <div class="w-3 h-3 bg-purple-500 rounded-full mt-2 flex-shrink-0"></div>
                    
                    <!-- Content -->
                    <div class="flex-1">
                        <h3 class="font-bold text-gray-800 text-base mb-1">Promo Spesial!</h3>
                        <p class="text-sm text-gray-600 mb-2">Dapatkan bonus 50 poin untuk setiap setoran sampah organik minggu ini!</p>
                        <span class="text-xs text-gray-400">2 hari yang lalu</span>
                    </div>
                </div>
            </div>

            <!-- Notification Item 5 - Reminder -->
            <div class="bg-white rounded-2xl p-5 shadow-sm border-l-4 border-orange-500 hover:shadow-md transition-all">
                <div class="flex items-start space-x-4">
                    <!-- Icon -->
                    <div class="w-3 h-3 bg-orange-500 rounded-full mt-2 flex-shrink-0"></div>
                    
                    <!-- Content -->
                    <div class="flex-1">
                        <h3 class="font-bold text-gray-800 text-base mb-1">Pengingat Setoran</h3>
                        <p class="text-sm text-gray-600 mb-2">Sudah waktunya untuk menyetor sampah! Jangan lupa untuk memisahkan sampah Anda.</p>
                        <span class="text-xs text-gray-400">3 hari yang lalu</span>
                    </div>
                </div>
            </div>

            <!-- Notification Item 6 - Info -->
            <div class="bg-white rounded-2xl p-5 shadow-sm border-l-4 border-gray-300 hover:shadow-md transition-all">
                <div class="flex items-start space-x-4">
                    <!-- Icon -->
                    <div class="w-3 h-3 bg-gray-400 rounded-full mt-2 flex-shrink-0"></div>
                    
                    <!-- Content -->
                    <div class="flex-1">
                        <h3 class="font-bold text-gray-700 text-base mb-1">Selamat Datang!</h3>
                        <p class="text-sm text-gray-500 mb-2">Terima kasih telah bergabung dengan Green Saving. Mari bersama menjaga lingkungan!</p>
                        <span class="text-xs text-gray-400">1 minggu yang lalu</span>
                    </div>
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

</body>
</html>
