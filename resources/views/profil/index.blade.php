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
    <style>
        @keyframes slideDown {
            from { transform: translateY(-100%); opacity: 0; }
            to { transform: translateY(0); opacity: 1; }
        }
        .alert-animate {
            animation: slideDown 0.5s ease-out;
        }
    </style>
</head>
<body class="min-h-screen bg-gradient-to-br from-green-50 to-green-100 font-poppins">

    <!-- Success Alert -->
    @if(session('success'))
    <div id="successAlert" class="fixed top-4 right-4 z-50 alert-animate">
        <div class="bg-green-500 text-white px-6 py-4 rounded-xl shadow-2xl flex items-center gap-3 max-w-md">
            <div class="w-10 h-10 bg-white/20 rounded-full flex items-center justify-center flex-shrink-0">
                <i class="bi bi-check-circle-fill text-2xl"></i>
            </div>
            <div class="flex-1">
                <p class="font-semibold">Berhasil!</p>
                <p class="text-sm text-green-50">{{ session('success') }}</p>
            </div>
            <button onclick="document.getElementById('successAlert').remove()" class="text-white/80 hover:text-white transition-colors">
                <i class="bi bi-x-lg text-xl"></i>
            </button>
        </div>
    </div>
    <script>
        setTimeout(() => {
            const alert = document.getElementById('successAlert');
            if (alert) {
                alert.style.opacity = '0';
                alert.style.transition = 'opacity 0.5s ease-out';
                setTimeout(() => alert.remove(), 500);
            }
        }, 5000);
    </script>
    @endif

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

                <!-- User Info -->
                <div class="flex items-center space-x-4">
                    <div class="text-right hidden md:block">
                        <p class="text-sm text-gray-600">Saldo Poin</p>
                        <p class="text-xl font-bold text-green-600">{{ number_format($saldoPoin, 0, ',', '.') }}</p>
                    </div>
                    <div class="w-10 h-10 bg-green-100 rounded-full flex items-center justify-center">
                        <i class="bi bi-person text-green-600 text-xl"></i>
                    </div>
                </div>
            </div>

            <!-- Navigation Tabs -->
            <div class="mt-6">
                <div class="flex flex-wrap gap-2 lg:gap-3">
                    <a href="/profil" class="bg-gradient-to-r from-green-500 to-green-600 text-white px-4 lg:px-6 py-3 rounded-2xl text-xs lg:text-sm font-semibold shadow-lg flex items-center justify-center space-x-2 w-full sm:w-auto cursor-pointer">
                        <i class="bi bi-person-circle pointer-events-none"></i>
                        <span class="truncate pointer-events-none">Profil</span>
                    </a>
                    <a href="/setor" class="bg-white text-gray-700 px-4 lg:px-6 py-3 rounded-2xl text-xs lg:text-sm font-semibold hover:bg-green-50 transition-colors shadow-sm flex items-center justify-center space-x-2 w-full sm:w-auto cursor-pointer">
                        <i class="bi bi-recycle pointer-events-none"></i>
                        <span class="truncate pointer-events-none">Setor</span>
                    </a>
                    <a href="/tukar-poin" class="bg-white text-gray-700 px-4 lg:px-6 py-3 rounded-2xl text-xs lg:text-sm font-semibold hover:bg-green-50 transition-colors shadow-sm flex items-center justify-center space-x-2 w-full sm:w-auto cursor-pointer">
                        <i class="bi bi-gift pointer-events-none"></i>
                        <span class="truncate pointer-events-none">Tukar Poin</span>
                    </a>
                    <a href="/riwayat" class="bg-white text-gray-700 px-4 lg:px-6 py-3 rounded-2xl text-xs lg:text-sm font-semibold hover:bg-green-50 transition-colors shadow-sm flex items-center justify-center space-x-2 w-full sm:w-auto cursor-pointer">
                        <i class="bi bi-clock-history pointer-events-none"></i>
                        <span class="truncate pointer-events-none">Riwayat</span>
                    </a>
                    <a href="/notifikasi" class="bg-white text-gray-700 px-4 lg:px-6 py-3 rounded-2xl text-xs lg:text-sm font-semibold hover:bg-green-50 transition-colors shadow-sm flex items-center justify-center space-x-2 w-full sm:w-auto cursor-pointer">
                        <i class="bi bi-bell pointer-events-none"></i>
                        <span class="truncate pointer-events-none">Notifikasi</span>
                    </a>
                </div>
            </div>
        </div>
    </header>

    <!-- Main Content -->
    <main class="max-w-4xl mx-auto px-4 py-8">
        
        <!-- Profile Card -->
        <div class="bg-white rounded-2xl shadow-lg overflow-hidden">
            <!-- Header Card -->
            <div class="bg-gradient-to-r from-green-500 to-emerald-600 px-6 py-8 text-white">
                <div class="flex items-center gap-4">
                    <div class="relative">
                        <div class="w-20 h-20 bg-white/20 rounded-full flex items-center justify-center border-4 border-white/30">
                            <i class="bi bi-person text-white text-4xl"></i>
                        </div>
                        <div class="absolute bottom-0 right-0 w-6 h-6 bg-green-400 rounded-full flex items-center justify-center border-2 border-white">
                            <i class="bi bi-check text-white text-xs font-bold"></i>
                        </div>
                    </div>
                    <div>
                        <h2 class="text-2xl font-bold">{{ $user->full_name ?? $user->name }}</h2>
                        <p class="text-green-50 text-sm mt-1">
                            <i class="bi bi-calendar-check"></i>
                            Member sejak {{ $user->created_at->format('d F Y') }}
                        </p>
                    </div>
                </div>
            </div>

            <!-- Profile Information -->
            <div class="p-6 space-y-4">
                <h3 class="text-lg font-bold text-gray-800 mb-4 flex items-center gap-2">
                    <i class="bi bi-info-circle-fill text-green-600"></i>
                    Informasi Personal
                </h3>

                <!-- Nama Lengkap -->
                <div class="flex items-start gap-4 p-4 bg-gray-50 rounded-xl">
                    <div class="w-10 h-10 bg-green-100 rounded-xl flex items-center justify-center flex-shrink-0">
                        <i class="bi bi-person-fill text-green-600"></i>
                    </div>
                    <div class="flex-1">
                        <p class="text-sm text-gray-600 mb-1">Nama Lengkap</p>
                        <p class="font-semibold text-gray-900">{{ $user->full_name ?? $user->name ?? '-' }}</p>
                    </div>
                </div>

                <!-- Email -->
                <div class="flex items-start gap-4 p-4 bg-gray-50 rounded-xl">
                    <div class="w-10 h-10 bg-blue-100 rounded-xl flex items-center justify-center flex-shrink-0">
                        <i class="bi bi-envelope-fill text-blue-600"></i>
                    </div>
                    <div class="flex-1">
                        <p class="text-sm text-gray-600 mb-1">Email</p>
                        <p class="font-semibold text-gray-900">{{ $user->email }}</p>
                        
                        <!-- Email Verification Status -->
                        <div class="mt-2">
                            @if($user->hasVerifiedEmail())
                                <span class="inline-flex items-center gap-1 px-3 py-1 bg-green-100 text-green-700 rounded-lg text-xs font-semibold">
                                    <i class="bi bi-check-circle-fill"></i>
                                    Terverifikasi
                                </span>
                            @else
                                <div class="flex items-center gap-2 flex-wrap">
                                    <span class="inline-flex items-center gap-1 px-3 py-1 bg-yellow-100 text-yellow-700 rounded-lg text-xs font-semibold">
                                        <i class="bi bi-exclamation-triangle-fill"></i>
                                        Belum Verifikasi
                                    </span>
                                    <form method="POST" action="{{ route('verification.send') }}" class="inline">
                                        @csrf
                                        <button type="submit" class="inline-flex items-center gap-1 px-3 py-1 bg-blue-100 text-blue-700 hover:bg-blue-200 rounded-lg text-xs font-semibold transition-colors">
                                            <i class="bi bi-send-fill"></i>
                                            Kirim Ulang Link
                                        </button>
                                    </form>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- No Handphone -->
                <div class="flex items-start gap-4 p-4 bg-gray-50 rounded-xl">
                    <div class="w-10 h-10 bg-purple-100 rounded-xl flex items-center justify-center flex-shrink-0">
                        <i class="bi bi-telephone-fill text-purple-600"></i>
                    </div>
                    <div class="flex-1">
                        <p class="text-sm text-gray-600 mb-1">No Handphone</p>
                        <p class="font-semibold text-gray-900">{{ $user->phone ?? 'Belum diisi' }}</p>
                    </div>
                </div>

                <!-- Alamat -->
                <div class="flex items-start gap-4 p-4 bg-gray-50 rounded-xl">
                    <div class="w-10 h-10 bg-orange-100 rounded-xl flex items-center justify-center flex-shrink-0">
                        <i class="bi bi-geo-alt-fill text-orange-600"></i>
                    </div>
                    <div class="flex-1">
                        <p class="text-sm text-gray-600 mb-1">Alamat</p>
                        <p class="font-semibold text-gray-900">{{ $user->address ?? 'Belum diisi' }}</p>
                    </div>
                </div>
            </div>

            <!-- Action Buttons -->
            <div class="p-6 bg-gray-50 border-t border-gray-200">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <!-- Edit Profil Button -->
                    <a href="{{ route('profil.edit') }}" class="flex items-center justify-center gap-2 bg-gradient-to-r from-green-600 to-emerald-600 hover:from-green-700 hover:to-emerald-700 text-white font-semibold py-4 px-6 rounded-xl transition-all duration-200 shadow-lg shadow-green-500/30">
                        <i class="bi bi-pencil-square text-xl"></i>
                        <span>Edit Profil</span>
                    </a>

                    <!-- Ganti Password Button -->
                    <a href="{{ route('profil.password') }}" class="flex items-center justify-center gap-2 bg-gradient-to-r from-blue-600 to-indigo-600 hover:from-blue-700 hover:to-indigo-700 text-white font-semibold py-4 px-6 rounded-xl transition-all duration-200 shadow-lg shadow-blue-500/30">
                        <i class="bi bi-shield-lock text-xl"></i>
                        <span>Ganti Password</span>
                    </a>
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
                <h3 class="text-xl font-bold text-green-600">Green Saving</h3>
                <p class="text-sm text-gray-600 text-center">
                    Bersama menjaga lingkungan untuk masa depan lebih baik
                </p>
                <p class="text-sm text-gray-500">© 2025 Green Saving. All rights reserved.</p>
            </div>
        </div>
    </footer>

</body>
</html>
