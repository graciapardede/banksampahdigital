<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profil - Green Saving</title>
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
                    <div class="w-12 h-12 bg-green-500 rounded-xl flex items-center justify-center shadow-md">
                        @if(file_exists(public_path('images/logo user.png')))
                            <img src="{{ asset('images/logo user.png') }}" alt="Green Saving Logo" class="w-8 h-8 object-contain">
                        @else
                            <div class="w-7 h-7 bg-white rounded-lg flex items-center justify-center">
                                <div class="w-4 h-4 bg-green-500 rounded-sm"></div>
                            </div>
                        @endif
                    </div>
                    <div>
                        <h1 class="text-xl font-bold text-gray-800">Green Saving</h1>
                        <p class="text-sm text-gray-500">Halo, {{ Auth::user()->full_name ?? Auth::user()->name ?? 'Budi Santoso' }}</p>
                    </div>
                </div>

                <!-- Points and Actions -->
                <div class="flex items-center space-x-4">
                    <div class="bg-green-100 px-6 py-2 rounded-full">
                        <span class="text-lg font-bold text-green-700">15420 poin</span>
                    </div>
                    <button class="w-10 h-10 bg-gray-100 rounded-xl flex items-center justify-center hover:bg-gray-200 transition-colors">
                        <i class="bi bi-bell text-gray-600"></i>
                    </button>
                    <a href="/profil" class="w-10 h-10 bg-green-100 rounded-xl flex items-center justify-center hover:bg-green-200 transition-colors">
                        <i class="bi bi-person-circle text-green-600"></i>
                    </a>
                    <form method="POST" action="/logout" class="inline">
                        @csrf
                        <button type="submit" class="w-10 h-10 bg-gray-100 rounded-xl flex items-center justify-center hover:bg-gray-200 transition-colors">
                            <i class="bi bi-box-arrow-right text-gray-600"></i>
                        </button>
                    </form>
                </div>
            </div>
        </div>

        <!-- Navigation Tabs -->
        <div class="bg-green-100 px-4 py-4">
            <div class="max-w-6xl mx-auto">
                <!-- Navigation grid for consistent spacing -->
                <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-6 gap-3">
                    <a href="/dashboard" class="bg-white text-gray-700 px-4 lg:px-6 py-3 rounded-2xl text-xs lg:text-sm font-semibold hover:bg-green-50 transition-colors shadow-sm flex items-center justify-center space-x-2 w-full cursor-pointer">
                        <i class="bi bi-house-door pointer-events-none"></i>
                        <span class="truncate pointer-events-none">Dashboard</span>
                    </a>
                    <a href="/profil" class="bg-green-500 text-white px-4 lg:px-6 py-3 rounded-2xl text-xs lg:text-sm font-semibold shadow-md flex items-center justify-center space-x-2 w-full cursor-default">
                        <i class="bi bi-person pointer-events-none"></i>
                        <span class="truncate pointer-events-none">Profil</span>
                    </a>
                    <a href="/setor" class="bg-white text-gray-700 px-4 lg:px-6 py-3 rounded-2xl text-xs lg:text-sm font-semibold hover:bg-green-50 transition-colors shadow-sm flex items-center justify-center space-x-2 w-full cursor-pointer">
                        <i class="bi bi-recycle pointer-events-none"></i>
                        <span class="truncate pointer-events-none">Setor</span>
                    </a>
                    <button class="bg-white text-gray-700 px-4 lg:px-6 py-3 rounded-2xl text-xs lg:text-sm font-semibold hover:bg-green-50 transition-colors shadow-sm flex items-center justify-center space-x-2 w-full cursor-not-allowed opacity-60">
                        <i class="bi bi-gift pointer-events-none"></i>
                        <span class="truncate pointer-events-none">Tukar Poin</span>
                    </button>
                    <button class="bg-white text-gray-700 px-4 lg:px-6 py-3 rounded-2xl text-xs lg:text-sm font-semibold hover:bg-green-50 transition-colors shadow-sm flex items-center justify-center space-x-2 w-full cursor-not-allowed opacity-60">
                        <i class="bi bi-bar-chart pointer-events-none"></i>
                        <span class="truncate pointer-events-none">Riwayat</span>
                    </button>
                    <button class="bg-white text-gray-700 px-4 lg:px-6 py-3 rounded-2xl text-xs lg:text-sm font-semibold hover:bg-green-50 transition-colors shadow-sm flex items-center justify-center space-x-2 w-full cursor-not-allowed opacity-60">
                        <i class="bi bi-bell pointer-events-none"></i>
                        <span class="truncate pointer-events-none">Notifikasi</span>
                    </button>
                </div>
            </div>
        </div>
    </header>

    <!-- Main Content -->
    <main class="max-w-6xl mx-auto px-4 py-8">
        
        <!-- Informasi Personal Section -->
        <div class="bg-white rounded-2xl p-6 mb-6 shadow-sm">
            <h2 class="text-xl font-bold text-gray-800 mb-2">Informasi Personal</h2>
            <p class="text-sm text-gray-500 mb-6">Data pribadi dan kontak Anda</p>

            <!-- Profile Picture -->
            <div class="flex items-center space-x-4 mb-8 pb-6 border-b border-gray-200">
                <div class="relative">
                    <div class="w-20 h-20 bg-green-100 rounded-full flex items-center justify-center">
                        <i class="bi bi-person text-green-600 text-4xl"></i>
                    </div>
                    <div class="absolute bottom-0 right-0 w-6 h-6 bg-green-500 rounded-full flex items-center justify-center border-2 border-white">
                        <i class="bi bi-check text-white text-xs"></i>
                    </div>
                </div>
                <div>
                    <h3 class="font-bold text-gray-800">{{ Auth::user()->full_name ?? Auth::user()->name ?? 'Budi Santoso' }}</h3>
                    <p class="text-sm text-gray-500">Bergabung sejak {{ Auth::user()->created_at ? Auth::user()->created_at->format('F Y') : 'Januari 2024' }}</p>
                </div>
            </div>

            <!-- Form Fields -->
            <div class="space-y-4">
                <!-- Nama Lengkap -->
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Nama Lengkap</label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                            <i class="bi bi-person text-gray-400"></i>
                        </div>
                        <input type="text" value="{{ Auth::user()->full_name ?? Auth::user()->name ?? 'Budi Santoso' }}" 
                               class="w-full pl-12 pr-4 py-3 bg-gray-50 border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent" 
                               readonly>
                    </div>
                </div>

                <!-- Email -->
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Email</label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                            <i class="bi bi-envelope text-gray-400"></i>
                        </div>
                        <input type="email" value="{{ Auth::user()->email ?? 'budi@email.com' }}" 
                               class="w-full pl-12 pr-4 py-3 bg-gray-50 border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent" 
                               readonly>
                    </div>
                </div>

                <!-- Nomor Telepon -->
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Nomor Telepon</label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                            <i class="bi bi-telephone text-gray-400"></i>
                        </div>
                        <input type="tel" value="{{ Auth::user()->phone ?? '081 234 567' }}" 
                               class="w-full pl-12 pr-4 py-3 bg-gray-50 border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent" 
                               readonly>
                    </div>
                </div>

                <!-- Alamat -->
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Alamat</label>
                    <div class="relative">
                        <div class="absolute top-3 left-0 pl-4 flex items-start pointer-events-none">
                            <i class="bi bi-geo-alt text-gray-400"></i>
                        </div>
                        <input type="text" value="{{ Auth::user()->address ?? 'Jl. Hijau No. 123' }}" 
                               class="w-full pl-12 pr-4 py-3 bg-gray-50 border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent" 
                               readonly>
                    </div>
                </div>
            </div>
        </div>

        <!-- Keamanan Akun Section -->
        <div class="bg-white rounded-2xl p-6 shadow-sm">
            <h2 class="text-xl font-bold text-gray-800 mb-2">Keamanan Akun</h2>
            <p class="text-sm text-gray-500 mb-6">Kelola password dan keamanan akun</p>

            <div class="space-y-4">
                <!-- Password -->
                <div class="flex items-center justify-between p-4 bg-gray-50 rounded-xl">
                    <div class="flex items-center space-x-3">
                        <div class="w-10 h-10 bg-white rounded-xl flex items-center justify-center">
                            <i class="bi bi-lock text-gray-600"></i>
                        </div>
                        <span class="font-medium text-gray-700">Password</span>
                    </div>
                    <button class="px-6 py-2 bg-white border border-gray-200 rounded-xl text-sm font-semibold text-gray-700 hover:bg-gray-50 transition-colors">
                        Ubah
                    </button>
                </div>

                <!-- Verifikasi Email -->
                <div class="flex items-center justify-between p-4 bg-gray-50 rounded-xl">
                    <div class="flex items-center space-x-3">
                        <div class="w-10 h-10 bg-white rounded-xl flex items-center justify-center">
                            <i class="bi bi-shield-check text-gray-600"></i>
                        </div>
                        <span class="font-medium text-gray-700">Verifikasi Email</span>
                    </div>
                    <button class="px-6 py-2 bg-green-500 text-white rounded-xl text-sm font-semibold hover:bg-green-600 transition-colors">
                        Terverifikasi
                    </button>
                </div>

                <!-- Verifikasi No Telepon -->
                <div class="flex items-center justify-between p-4 bg-gray-50 rounded-xl">
                    <div class="flex items-center space-x-3">
                        <div class="w-10 h-10 bg-white rounded-xl flex items-center justify-center">
                            <i class="bi bi-phone-vibrate text-gray-600"></i>
                        </div>
                        <span class="font-medium text-gray-700">Verifikasi No Telepon</span>
                    </div>
                    <button class="px-6 py-2 bg-white border border-gray-200 rounded-xl text-sm font-semibold text-gray-700 hover:bg-gray-50 transition-colors">
                        Belum
                    </button>
                </div>
            </div>
        </div>

    </main>

    <!-- Footer -->
    <div class="bg-white border-t mt-8 py-6">
        <div class="max-w-6xl mx-auto px-4">
            <div class="flex items-center justify-center space-x-4">
                <!-- Green Saving Logo -->
                <div class="w-12 h-12 bg-green-500 rounded-2xl flex items-center justify-center shadow-md">
                    @if(file_exists(public_path('images/logo user.png')))
                        <img src="{{ asset('images/logo user.png') }}" alt="Green Saving Logo" class="w-8 h-8 object-contain">
                    @else
                        <div class="w-7 h-7 bg-white rounded-lg flex items-center justify-center">
                            <div class="w-4 h-4 bg-green-500 rounded-sm"></div>
                        </div>
                    @endif
                </div>
                <div class="text-center">
                    <h3 class="text-xl font-bold text-green-600">Green Saving</h3>
                    <p class="text-sm text-gray-500 mt-1">Bersama menjaga lingkungan untuk masa depan lebih baik</p>
                </div>
            </div>
        </div>
    </div>

    <footer class="bg-green-50 py-4">
        <div class="max-w-6xl mx-auto px-4">
            <div class="text-center text-xs text-gray-500">
                © 2025 Green Saving. All rights reserved.
            </div>
        </div>
    </footer>

</body>
</html>
