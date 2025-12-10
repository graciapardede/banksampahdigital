<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reset Password - Green Saving</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css" rel="stylesheet">
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
</head>
<body class="min-h-screen bg-gradient-to-br from-green-50 to-green-100 font-poppins flex items-center justify-center px-4">

    <div class="w-full max-w-md">
        <!-- Logo Card -->
        <div class="text-center mb-8">
            <div class="w-20 h-20 bg-gradient-to-br from-green-500 to-green-600 rounded-2xl flex items-center justify-center mx-auto mb-4 shadow-lg">
                <i class="bi bi-lock text-white text-4xl"></i>
            </div>
            <h1 class="text-3xl font-bold text-gray-800">Password Baru</h1>
            <p class="text-gray-600 mt-2">Buat password yang kuat dan aman</p>
        </div>

        <!-- Error Message -->
        @if ($errors->any())
            <div class="mb-6 bg-red-50 border-l-4 border-red-500 rounded-lg p-4">
                <div class="flex">
                    <div class="flex-shrink-0">
                        <i class="bi bi-exclamation-circle text-red-600 text-xl"></i>
                    </div>
                    <div class="ml-3">
                        @foreach ($errors->all() as $error)
                            <p class="text-sm text-red-700 font-medium">{{ $error }}</p>
                        @endforeach
                    </div>
                </div>
            </div>
        @endif

        <!-- Success Message -->
        @if (session('success'))
            <div class="mb-6 bg-green-50 border-l-4 border-green-500 rounded-lg p-4">
                <div class="flex">
                    <div class="flex-shrink-0">
                        <i class="bi bi-check-circle text-green-600 text-xl"></i>
                    </div>
                    <div class="ml-3">
                        <p class="text-sm text-green-700 font-medium">{{ session('success') }}</p>
                    </div>
                </div>
            </div>
        @endif

        <!-- Form Card -->
        <div class="bg-white rounded-2xl shadow-xl p-8 mb-6" x-data="{ showPassword: false, showPasswordConfirm: false }">
            <form method="POST" action="{{ route('password.reset') }}" class="space-y-4">
                @csrf

                <input type="hidden" name="email" value="{{ $email ?? request()->query('email') }}">
                <input type="hidden" name="reset_code" value="{{ $reset_code ?? request()->query('reset_code') }}">

                <!-- Email (Read Only) -->
                <div>
                    <label for="email_display" class="block text-sm font-semibold text-gray-700 mb-2">
                        <i class="bi bi-envelope mr-1"></i>Email
                    </label>
                    <input 
                        id="email_display"
                        type="email"
                        value="{{ $email ?? request()->query('email') }}"
                        disabled
                        class="w-full px-4 py-3 bg-gray-100 border-2 border-gray-200 rounded-xl text-gray-600 cursor-not-allowed"
                    >
                </div>

                <!-- Password -->
                <div>
                    <label for="password" class="block text-sm font-semibold text-gray-700 mb-2">
                        <i class="bi bi-lock mr-1"></i>Password Baru
                    </label>
                    <div class="relative">
                        <input 
                            :type="showPassword ? 'text' : 'password'"
                            id="password"
                            name="password"
                            required
                            autofocus
                            class="w-full px-4 py-3 pr-12 bg-white border-2 border-gray-200 rounded-xl focus:border-green-500 focus:ring-2 focus:ring-green-200 transition-all outline-none text-gray-700 placeholder-gray-400"
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
                        <p class="mt-2 text-xs text-red-600 flex items-center">
                            <i class="bi bi-exclamation-circle mr-1"></i>{{ $message }}
                        </p>
                    @enderror
                    <p class="mt-2 text-xs text-gray-500">
                        <i class="bi bi-info-circle mr-1"></i>Minimal 8 karakter, gunakan kombinasi huruf dan angka
                    </p>
                </div>

                <!-- Confirm Password -->
                <div>
                    <label for="password_confirmation" class="block text-sm font-semibold text-gray-700 mb-2">
                        <i class="bi bi-lock-check mr-1"></i>Konfirmasi Password
                    </label>
                    <div class="relative">
                        <input 
                            :type="showPasswordConfirm ? 'text' : 'password'"
                            id="password_confirmation"
                            name="password_confirmation"
                            required
                            class="w-full px-4 py-3 pr-12 bg-white border-2 border-gray-200 rounded-xl focus:border-green-500 focus:ring-2 focus:ring-green-200 transition-all outline-none text-gray-700 placeholder-gray-400"
                            placeholder="Ketik ulang password"
                        >
                        <button 
                            type="button"
                            @click="showPasswordConfirm = !showPasswordConfirm"
                            class="absolute right-4 top-1/2 -translate-y-1/2 text-gray-400 hover:text-gray-600 transition-colors"
                        >
                            <i :class="showPasswordConfirm ? 'bi-eye-slash' : 'bi-eye'" class="text-lg"></i>
                        </button>
                    </div>
                    @error('password_confirmation')
                        <p class="mt-2 text-xs text-red-600 flex items-center">
                            <i class="bi bi-exclamation-circle mr-1"></i>{{ $message }}
                        </p>
                    @enderror
                </div>

                <button 
                    type="submit"
                    class="w-full bg-gradient-to-r from-green-500 to-green-600 hover:from-green-600 hover:to-green-700 text-white font-bold py-3 px-4 rounded-xl shadow-lg hover:shadow-xl transition-all duration-200 flex items-center justify-center gap-2"
                >
                    <i class="bi bi-check-circle"></i>
                    Simpan Password Baru
                </button>
            </form>
        </div>

        <!-- Info Box -->
        <div class="bg-green-50 border-l-4 border-green-500 rounded-lg p-4">
            <p class="text-xs text-green-700">
                <i class="bi bi-shield-check mr-2"></i>
                Password Anda akan dienkripsi dan disimpan dengan aman.
            </p>
        </div>
    </div>

</body>
</html>
