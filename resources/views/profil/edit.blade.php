<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Profil - Green Saving</title>
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
            <div class="flex items-center gap-4">
                <a href="{{ route('profil.index') }}" class="w-10 h-10 bg-gray-100 hover:bg-gray-200 rounded-xl flex items-center justify-center transition-colors">
                    <i class="bi bi-arrow-left text-gray-700 text-xl"></i>
                </a>
                <div class="flex items-center space-x-3">
                    <div class="w-12 h-12 bg-gradient-to-br from-green-500 to-green-600 rounded-xl flex items-center justify-center shadow-lg">
                        <i class="bi bi-recycle text-white text-2xl"></i>
                    </div>
                    <div>
                        <h1 class="font-bold text-xl text-gray-800">Edit Profil</h1>
                        <p class="text-sm text-green-600">Perbarui informasi pribadi Anda</p>
                    </div>
                </div>
            </div>
        </div>
    </header>

    <!-- Main Content -->
    <main class="max-w-3xl mx-auto px-4 py-8">
        
        <div class="bg-white rounded-2xl shadow-lg overflow-hidden">
            <!-- Form Header -->
            <div class="bg-gradient-to-r from-green-500 to-emerald-600 px-6 py-6 text-white">
                <h2 class="text-xl font-bold flex items-center gap-2">
                    <i class="bi bi-pencil-square"></i>
                    Edit Data Diri
                </h2>
                <p class="text-green-50 text-sm mt-1">Lengkapi informasi profil Anda dengan benar</p>
            </div>

            <!-- Form -->
            <form action="{{ route('profil.update') }}" method="POST" enctype="multipart/form-data" class="p-6">
                @csrf
                @method('PUT')

                <div class="space-y-6">
                    <!-- Profile Photo -->
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">
                            Foto Profil
                        </label>
                        <div class="flex items-center gap-4">
                            <div class="relative">
                                @if($user->profile_photo)
                                    <img src="/{{ $user->profile_photo }}" alt="Profile" id="previewImage" class="w-24 h-24 rounded-full object-cover border-4 border-gray-200">
                                @else
                                    <div id="previewImage" class="w-24 h-24 bg-gray-100 rounded-full flex items-center justify-center border-4 border-gray-200">
                                        <i class="bi bi-person text-gray-400 text-4xl"></i>
                                    </div>
                                @endif
                            </div>
                            <div class="flex-1">
                                <label for="profile_photo" class="cursor-pointer inline-flex items-center gap-2 px-4 py-2 bg-green-500 hover:bg-green-600 text-white rounded-xl font-semibold transition-colors">
                                    <i class="bi bi-camera-fill"></i>
                                    <span>Pilih Foto</span>
                                </label>
                                <input 
                                    type="file" 
                                    id="profile_photo"
                                    name="profile_photo" 
                                    accept="image/jpeg,image/jpg,image/png"
                                    class="hidden"
                                    onchange="previewPhoto(event)"
                                >
                                <p class="text-xs text-gray-500 mt-2">
                                    <i class="bi bi-info-circle"></i>
                                    Format: JPG, JPEG, PNG. Maksimal 2MB
                                </p>
                                @error('profile_photo')
                                    <p class="text-red-500 text-sm mt-1 flex items-center gap-1">
                                        <i class="bi bi-exclamation-circle"></i>
                                        {{ $message }}
                                    </p>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <!-- Nama Lengkap -->
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">
                            Nama Lengkap <span class="text-red-500">*</span>
                        </label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                <i class="bi bi-person-fill text-gray-400"></i>
                            </div>
                            <input 
                                type="text" 
                                name="full_name" 
                                value="{{ old('full_name', $user->full_name ?? $user->name) }}"
                                class="w-full pl-12 pr-4 py-3 bg-white border border-gray-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent @error('full_name') border-red-500 @enderror"
                                placeholder="Masukkan nama lengkap Anda"
                                required
                            >
                        </div>
                        @error('full_name')
                            <p class="text-red-500 text-sm mt-1 flex items-center gap-1">
                                <i class="bi bi-exclamation-circle"></i>
                                {{ $message }}
                            </p>
                        @enderror
                    </div>

                    <!-- Email (Read-only) -->
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2 flex items-center gap-2">
                            Email
                            <i class="bi bi-lock-fill text-gray-400 text-xs" title="Email tidak dapat diubah"></i>
                        </label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                <i class="bi bi-envelope-fill text-gray-400"></i>
                            </div>
                            <input 
                                type="email" 
                                value="{{ $user->email }}"
                                class="w-full pl-12 pr-4 py-3 bg-gray-50 border border-gray-200 rounded-xl text-gray-600 cursor-not-allowed"
                                readonly
                            >
                        </div>
                        <p class="text-xs text-gray-500 mt-1 flex items-center gap-1">
                            <i class="bi bi-info-circle"></i>
                            Email tidak dapat diubah untuk keamanan akun
                        </p>
                    </div>

                    <!-- No Handphone -->
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">
                            No Handphone
                        </label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                <i class="bi bi-telephone-fill text-gray-400"></i>
                            </div>
                            <input 
                                type="tel" 
                                name="phone" 
                                value="{{ old('phone', $user->phone) }}"
                                class="w-full pl-12 pr-4 py-3 bg-white border border-gray-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent @error('phone') border-red-500 @enderror"
                                placeholder="Contoh: 08123456789"
                            >
                        </div>
                        @error('phone')
                            <p class="text-red-500 text-sm mt-1 flex items-center gap-1">
                                <i class="bi bi-exclamation-circle"></i>
                                {{ $message }}
                            </p>
                        @enderror
                    </div>

                    <!-- Alamat -->
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">
                            Alamat
                        </label>
                        <div class="relative">
                            <div class="absolute top-3 left-0 pl-4 flex items-start pointer-events-none">
                                <i class="bi bi-geo-alt-fill text-gray-400"></i>
                            </div>
                            <textarea 
                                name="address" 
                                rows="4"
                                class="w-full pl-12 pr-4 py-3 bg-white border border-gray-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent resize-none @error('address') border-red-500 @enderror"
                                placeholder="Masukkan alamat lengkap Anda"
                            >{{ old('address', $user->address) }}</textarea>
                        </div>
                        @error('address')
                            <p class="text-red-500 text-sm mt-1 flex items-center gap-1">
                                <i class="bi bi-exclamation-circle"></i>
                                {{ $message }}
                            </p>
                        @enderror
                    </div>
                </div>

                <!-- Action Buttons -->
                <div class="mt-8 flex flex-col sm:flex-row gap-3">
                    <button 
                        type="submit"
                        class="flex-1 bg-gradient-to-r from-green-600 to-emerald-600 hover:from-green-700 hover:to-emerald-700 text-white font-semibold py-3 px-6 rounded-xl transition-all duration-200 shadow-lg shadow-green-500/30 flex items-center justify-center gap-2"
                    >
                        <i class="bi bi-check-circle-fill text-xl"></i>
                        Simpan Perubahan
                    </button>

                    <a 
                        href="{{ route('profil.index') }}"
                        class="flex-1 bg-gray-100 hover:bg-gray-200 text-gray-700 font-semibold py-3 px-6 rounded-xl transition-colors flex items-center justify-center gap-2"
                    >
                        <i class="bi bi-x-circle text-xl"></i>
                        Batal
                    </a>
                </div>
            </form>
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

    <script>
        function previewPhoto(event) {
            const file = event.target.files[0];
            const preview = document.getElementById('previewImage');
            
            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    // Replace the preview with an img tag
                    preview.outerHTML = '<img src="' + e.target.result + '" alt="Preview" id="previewImage" class="w-24 h-24 rounded-full object-cover border-4 border-gray-200">';
                }
                reader.readAsDataURL(file);
            }
        }
    </script>

</body>
</html>
