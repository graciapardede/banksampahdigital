<x-auth-layout :title="'Masuk - Green Saving'">
    <x-auth-card maxWidth="md">
        
        <!-- Header dengan Logo dan Tagline -->
        <div class="text-center mb-8">
            <div class="inline-flex items-center justify-center w-16 h-16 bg-gradient-to-br from-green-500 to-green-600 rounded-2xl shadow-lg mb-4">
                <i class="bi bi-recycle text-white text-3xl"></i>
            </div>
            <h1 class="text-3xl font-bold text-gray-800 mb-2">Selamat Datang Kembali!</h1>
            <p class="text-gray-600">Masuk untuk mulai mengelola sampah dan mendapatkan reward</p>
        </div>

        <!-- Tab Navigation -->
        <div class="flex gap-2 mb-6 p-1 bg-gray-100 rounded-xl">
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
        <form method="POST" action="{{ route('login') }}" class="space-y-5">
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

                @if (Route::has('password.request'))
                    <a href="{{ route('password.request') }}" class="text-sm text-green-600 hover:text-green-700 font-medium hover:underline transition-colors">
                        Lupa password?
                    </a>
                @endif
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
