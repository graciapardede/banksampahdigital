<x-auth-layout :title="'Daftar - Green Saving'">
    <x-auth-card maxWidth="2xl">
        
        <!-- Header dengan Logo dan Tagline -->
        <div class="text-center mb-8">
            <div class="inline-flex items-center justify-center w-16 h-16 bg-gradient-to-br from-green-500 to-green-600 rounded-2xl shadow-lg mb-4">
                <i class="bi bi-leaf text-white text-3xl"></i>
            </div>
            <h1 class="text-3xl font-bold text-gray-800 mb-2">🌱 Bergabung dengan Green Saving</h1>
            <p class="text-gray-600">Mulai kontribusi untuk lingkungan dan dapatkan reward menarik</p>
        </div>

        <!-- Tab Navigation -->
        <div class="flex gap-2 mb-8 p-1 bg-gray-100 rounded-xl">
            <a href="{{ route('login') }}" class="flex-1 text-center py-3 px-4 rounded-lg text-gray-600 font-semibold hover:bg-gray-200 transition-all">
                <i class="bi bi-box-arrow-in-right mr-2"></i>Masuk
            </a>
            <a href="{{ route('register') }}" class="flex-1 text-center py-3 px-4 rounded-lg bg-gradient-to-r from-green-500 to-green-600 text-white font-semibold shadow-md transition-all">
                <i class="bi bi-person-plus mr-2"></i>Daftar
            </a>
        </div>

        <!-- Register Form -->
        <form method="POST" action="{{ route('register') }}" class="space-y-6">
            @csrf

            <!-- Grid 2 Kolom untuk Desktop -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                
                <!-- Kolom Kiri -->
                <div class="space-y-5">
                    
                    <!-- Name -->
                    <div>
                        <label for="full_name" class="block text-sm font-semibold text-gray-700 mb-2">
                            <i class="bi bi-person mr-1"></i>Nama Lengkap
                        </label>
                        <input 
                            id="full_name" 
                            type="text" 
                            name="full_name" 
                            value="{{ old('full_name') }}" 
                            required 
                            autofocus 
                            autocomplete="name"
                            class="w-full px-4 py-3 bg-white border-2 border-gray-200 rounded-xl focus:border-green-500 focus:ring-2 focus:ring-green-200 transition-all outline-none text-gray-700 placeholder-gray-400"
                            placeholder="Contoh: Budi Santoso"
                        >
                        @error('full_name')
                            <p class="mt-2 text-sm text-red-600 flex items-center">
                                <i class="bi bi-exclamation-circle mr-1"></i>{{ $message }}
                            </p>
                        @enderror
                    </div>

                    <!-- Email -->
                    <div>
                        <label for="email" class="block text-sm font-semibold text-gray-700 mb-2">
                            <i class="bi bi-envelope mr-1"></i>Email
                        </label>
                        <input 
                            id="email" 
                            type="email" 
                            name="email" 
                            value="{{ old('email') }}" 
                            required 
                            autocomplete="username"
                            class="w-full px-4 py-3 bg-white border-2 border-gray-200 rounded-xl focus:border-green-500 focus:ring-2 focus:ring-green-200 transition-all outline-none text-gray-700 placeholder-gray-400"
                            placeholder="nama@email.com"
                        >
                        @error('email')
                            <p class="mt-2 text-sm text-red-600 flex items-center">
                                <i class="bi bi-exclamation-circle mr-1"></i>{{ $message }}
                            </p>
                        @enderror
                    </div>

                    <!-- Phone (Optional) -->
                    <div>
                        <label for="phone" class="block text-sm font-semibold text-gray-700 mb-2">
                            <i class="bi bi-telephone mr-1"></i>Nomor HP <span class="text-gray-400 text-xs">(opsional)</span>
                        </label>
                        <input 
                            id="phone" 
                            type="tel" 
                            name="phone" 
                            value="{{ old('phone') }}" 
                            autocomplete="tel"
                            class="w-full px-4 py-3 bg-white border-2 border-gray-200 rounded-xl focus:border-green-500 focus:ring-2 focus:ring-green-200 transition-all outline-none text-gray-700 placeholder-gray-400"
                            placeholder="08123456789"
                        >
                        @error('phone')
                            <p class="mt-2 text-sm text-red-600 flex items-center">
                                <i class="bi bi-exclamation-circle mr-1"></i>{{ $message }}
                            </p>
                        @enderror
                    </div>

                </div>

                <!-- Kolom Kanan -->
                <div class="space-y-5">
                    
                    <!-- Password -->
                    <div>
                        <label for="password" class="block text-sm font-semibold text-gray-700 mb-2">
                            <i class="bi bi-lock mr-1"></i>Password
                        </label>
                        <div class="relative" x-data="{ showPassword: false }">
                            <input 
                                :type="showPassword ? 'text' : 'password'"
                                id="password" 
                                name="password" 
                                required 
                                autocomplete="new-password"
                                class="w-full px-4 py-3 bg-white border-2 border-gray-200 rounded-xl focus:border-green-500 focus:ring-2 focus:ring-green-200 transition-all outline-none text-gray-700 placeholder-gray-400 pr-12"
                                placeholder="Minimal 8 karakter"
                            >
                            <button 
                                type="button"
                                @click="showPassword = !showPassword"
                                class="absolute right-4 top-1/2 -translate-y-1/2 text-gray-400 hover:text-gray-600 transition-colors"
                            >
                                <i :class="showPassword ? 'bi-eye-slash' : 'bi-eye'" class="text-lg"></i>
                            </button>
                        </div>
                        @error('password')
                            <p class="mt-2 text-sm text-red-600 flex items-center">
                                <i class="bi bi-exclamation-circle mr-1"></i>{{ $message }}
                            </p>
                        @enderror
                    </div>

                    <!-- Confirm Password -->
                    <div>
                        <label for="password_confirmation" class="block text-sm font-semibold text-gray-700 mb-2">
                            <i class="bi bi-shield-check mr-1"></i>Konfirmasi Password
                        </label>
                        <div class="relative" x-data="{ showConfirmPassword: false }">
                            <input 
                                :type="showConfirmPassword ? 'text' : 'password'"
                                id="password_confirmation" 
                                name="password_confirmation" 
                                required 
                                autocomplete="new-password"
                                class="w-full px-4 py-3 bg-white border-2 border-gray-200 rounded-xl focus:border-green-500 focus:ring-2 focus:ring-green-200 transition-all outline-none text-gray-700 placeholder-gray-400 pr-12"
                                placeholder="Ketik ulang password"
                            >
                            <button 
                                type="button"
                                @click="showConfirmPassword = !showConfirmPassword"
                                class="absolute right-4 top-1/2 -translate-y-1/2 text-gray-400 hover:text-gray-600 transition-colors"
                            >
                                <i :class="showConfirmPassword ? 'bi-eye-slash' : 'bi-eye'" class="text-lg"></i>
                            </button>
                        </div>
                        @error('password_confirmation')
                            <p class="mt-2 text-sm text-red-600 flex items-center">
                                <i class="bi bi-exclamation-circle mr-1"></i>{{ $message }}
                            </p>
                        @enderror
                    </div>

                    <!-- Address (Optional) -->
                    <div>
                        <label for="address" class="block text-sm font-semibold text-gray-700 mb-2">
                            <i class="bi bi-geo-alt mr-1"></i>Alamat <span class="text-gray-400 text-xs">(opsional)</span>
                        </label>
                        <textarea 
                            id="address" 
                            name="address" 
                            rows="3"
                            autocomplete="street-address"
                            class="w-full px-4 py-3 bg-white border-2 border-gray-200 rounded-xl focus:border-green-500 focus:ring-2 focus:ring-green-200 transition-all outline-none text-gray-700 placeholder-gray-400 resize-none"
                            placeholder="Jalan, Kelurahan, Kecamatan"
                        >{{ old('address') }}</textarea>
                        @error('address')
                            <p class="mt-2 text-sm text-red-600 flex items-center">
                                <i class="bi bi-exclamation-circle mr-1"></i>{{ $message }}
                            </p>
                        @enderror
                    </div>

                </div>
            </div>

            <!-- Terms & Conditions -->
            <div class="flex items-start">
                <input 
                    id="terms" 
                    type="checkbox" 
                    required
                    class="w-4 h-4 mt-1 text-green-600 border-gray-300 rounded focus:ring-green-500 focus:ring-2"
                >
                <label for="terms" class="ml-3 text-sm text-gray-600">
                    Saya setuju dengan <a href="#" class="text-green-600 hover:text-green-700 font-medium hover:underline">Syarat & Ketentuan</a> serta <a href="#" class="text-green-600 hover:text-green-700 font-medium hover:underline">Kebijakan Privasi</a> Green Saving
                </label>
            </div>

            <!-- Submit Button -->
            <button 
                type="submit"
                class="w-full bg-gradient-to-r from-green-500 to-green-600 hover:from-green-600 hover:to-green-700 text-white font-bold py-3.5 px-6 rounded-xl shadow-lg hover:shadow-xl transform hover:scale-[1.02] transition-all duration-200 flex items-center justify-center"
            >
                <i class="bi bi-person-plus-fill mr-2 text-lg"></i>
                Daftar Sekarang
            </button>

        </form>

        <!-- Footer Links -->
        <div class="mt-6 pt-6 border-t border-gray-200 text-center">
            <p class="text-sm text-gray-600">
                Sudah punya akun? 
                <a href="{{ route('login') }}" class="text-green-600 hover:text-green-700 font-semibold hover:underline transition-colors">
                    Masuk di sini
                </a>
            </p>
        </div>

        <!-- Back to Home -->
        <div class="mt-4 text-center">
            <a href="/" class="inline-flex items-center text-sm text-gray-500 hover:text-gray-700 transition-colors">
                <i class="bi bi-arrow-left mr-1"></i>
                Kembali ke Beranda
            </a>
        </div>

    </x-auth-card>
</x-auth-layout>
