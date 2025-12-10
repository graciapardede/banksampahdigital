<x-auth-layout :title="'Masuk - Green Saving'">
    <x-auth-card maxWidth="md">
        
        <!-- Header dengan Logo dan Tagline -->
        <div class="text-center mb-6">
            <div class="inline-flex items-center justify-center w-14 h-14 bg-gradient-to-br from-green-500 to-green-600 rounded-2xl shadow-lg mb-3">
                <i class="bi bi-recycle text-white text-2xl"></i>
            </div>
            <h1 class="text-2xl font-bold text-gray-800 mb-1">Selamat Datang Kembali!</h1>
            <p class="text-sm text-gray-600">Masuk untuk mulai mengelola sampah dan mendapatkan reward</p>
        </div>

        <!-- Tab Navigation -->
        <div class="flex gap-2 mb-5 p-1 bg-gray-100 rounded-xl">
            <a href="{{ route('login') }}" class="flex-1 text-center py-3 px-4 rounded-lg bg-gradient-to-r from-green-500 to-green-600 text-white font-semibold shadow-md transition-all">
                <i class="bi bi-box-arrow-in-right mr-2"></i>Masuk
            </a>
            <a href="{{ route('register') }}" class="flex-1 text-center py-3 px-4 rounded-lg text-gray-600 font-semibold hover:bg-gray-200 transition-all">
                <i class="bi bi-person-plus mr-2"></i>Daftar
            </a>
        </div>

        <!-- Session Status -->
        @if (session('status'))
            <div class="mb-4 p-4 bg-green-50 border border-green-200 text-green-700 rounded-xl text-sm">
                {{ session('status') }}
            </div>
        @endif

        <!-- Login Form -->
        <form method="POST" action="{{ route('login') }}" class="space-y-4">
            @csrf

            <!-- Email Address -->
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
                    autofocus 
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
                        autocomplete="current-password"
                        class="w-full px-4 py-3 bg-white border-2 border-gray-200 rounded-xl focus:border-green-500 focus:ring-2 focus:ring-green-200 transition-all outline-none text-gray-700 placeholder-gray-400 pr-12"
                        placeholder="Masukkan password"
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

            <!-- Remember Me & Forgot Password -->
            <div class="flex items-center justify-between">
                <label for="remember_me" class="flex items-center cursor-pointer group">
                    <input 
                        id="remember_me" 
                        type="checkbox" 
                        name="remember"
                        class="w-4 h-4 text-green-600 border-gray-300 rounded focus:ring-green-500 focus:ring-2 cursor-pointer"
                    >
                    <span class="ml-2 text-sm text-gray-600 group-hover:text-gray-800 transition-colors">Ingat saya</span>
                </label>

                <a href="{{ route('password.forgot') }}" class="text-sm text-green-600 hover:text-green-700 font-medium hover:underline transition-colors">
                    Lupa password?
                </a>
            </div>

            <!-- Submit Button -->
            <button 
                type="submit"
                class="w-full bg-gradient-to-r from-green-500 to-green-600 hover:from-green-600 hover:to-green-700 text-white font-bold py-3.5 px-6 rounded-xl shadow-lg hover:shadow-xl transform hover:scale-[1.02] transition-all duration-200 flex items-center justify-center"
            >
                <i class="bi bi-box-arrow-in-right mr-2 text-lg"></i>
                Masuk Sekarang
            </button>

        </form>

        <!-- Divider -->
        <div class="relative my-6">
            <div class="absolute inset-0 flex items-center">
                <div class="w-full border-t border-gray-300"></div>
            </div>
            <div class="relative flex justify-center text-sm">
                <span class="px-4 bg-white text-gray-500 font-medium">Atau masuk dengan</span>
            </div>
        </div>

        <!-- Google Login Button -->
        <a 
            href="{{ route('auth.google') }}"
            class="w-full flex items-center justify-center gap-3 bg-white hover:bg-gray-50 border-2 border-gray-300 hover:border-gray-400 text-gray-700 font-semibold py-3.5 px-6 rounded-xl shadow-md hover:shadow-lg transform hover:scale-[1.02] transition-all duration-200"
        >
            <svg class="w-5 h-5" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                <path d="M22.56 12.25c0-.78-.07-1.53-.2-2.25H12v4.26h5.92c-.26 1.37-1.04 2.53-2.21 3.31v2.77h3.57c2.08-1.92 3.28-4.74 3.28-8.09z" fill="#4285F4"/>
                <path d="M12 23c2.97 0 5.46-.98 7.28-2.66l-3.57-2.77c-.98.66-2.23 1.06-3.71 1.06-2.86 0-5.29-1.93-6.16-4.53H2.18v2.84C3.99 20.53 7.7 23 12 23z" fill="#34A853"/>
                <path d="M5.84 14.09c-.22-.66-.35-1.36-.35-2.09s.13-1.43.35-2.09V7.07H2.18C1.43 8.55 1 10.22 1 12s.43 3.45 1.18 4.93l2.85-2.22.81-.62z" fill="#FBBC05"/>
                <path d="M12 5.38c1.62 0 3.06.56 4.21 1.64l3.15-3.15C17.45 2.09 14.97 1 12 1 7.7 1 3.99 3.47 2.18 7.07l3.66 2.84c.87-2.6 3.3-4.53 6.16-4.53z" fill="#EA4335"/>
            </svg>
            <span>Masuk dengan Google</span>
        </a>

        <!-- Footer Links -->
        <div class="mt-6 pt-6 border-t border-gray-200 text-center">
            <p class="text-sm text-gray-600">
                Belum punya akun? 
                <a href="{{ route('register') }}" class="text-green-600 hover:text-green-700 font-semibold hover:underline transition-colors">
                    Daftar sekarang
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
