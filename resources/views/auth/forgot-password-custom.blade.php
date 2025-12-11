<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lupa Password - Green Saving</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css" rel="stylesheet">
</head>
<body class="min-h-screen bg-gradient-to-br from-green-50 to-green-100 font-poppins flex items-center justify-center px-4">

    <div class="w-full max-w-md">
        <!-- Logo Card -->
        <div class="text-center mb-8">
            <div class="w-20 h-20 bg-gradient-to-br from-green-500 to-green-600 rounded-2xl flex items-center justify-center mx-auto mb-4 shadow-lg">
                <i class="bi bi-recycle text-white text-4xl"></i>
            </div>
            <h1 class="text-3xl font-bold text-gray-800">Green Saving</h1>
            <p class="text-gray-600 mt-2">Reset Password Anda</p>
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
        <div class="bg-white rounded-2xl shadow-xl p-8 mb-6">
            <h2 class="text-xl font-bold text-gray-800 mb-2">Lupa Password?</h2>
            <p class="text-sm text-gray-600 mb-6">Masukkan email Anda untuk mendapatkan kode reset password.</p>

            <form method="POST" action="{{ route('password.send-reset') }}" class="space-y-4">
                @csrf

                <div>
                    <label for="email" class="block text-sm font-semibold text-gray-700 mb-2">
                        <i class="bi bi-envelope mr-1"></i>Email Address
                    </label>
                    <input 
                        id="email"
                        type="email"
                        name="email"
                        value="{{ old('email') }}"
                        required
                        autofocus
                        class="w-full px-4 py-3 bg-white border-2 border-gray-200 rounded-xl focus:border-green-500 focus:ring-2 focus:ring-green-200 transition-all outline-none text-gray-700 placeholder-gray-400"
                        placeholder="masukkan@email.com"
                    >
                    @error('email')
                        <p class="mt-2 text-xs text-red-600 flex items-center">
                            <i class="bi bi-exclamation-circle mr-1"></i>{{ $message }}
                        </p>
                    @enderror
                </div>

                <button 
                    type="submit"
                    class="w-full bg-gradient-to-r from-green-500 to-green-600 hover:from-green-600 hover:to-green-700 text-white font-bold py-3 px-4 rounded-xl shadow-lg hover:shadow-xl transition-all duration-200 flex items-center justify-center gap-2"
                >
                    <i class="bi bi-send"></i>
                    Kirim Kode Reset
                </button>
            </form>
        </div>

        <!-- Back to Login Link -->
        <div class="text-center">
            <p class="text-gray-600 text-sm">
                Ingat passwordnya?
                <a href="{{ route('login') }}" class="text-green-600 hover:text-green-700 font-bold transition-colors">
                    Masuk di sini
                </a>
            </p>
        </div>

        <!-- Info Box -->
        <div class="mt-8 bg-blue-50 border-l-4 border-blue-500 rounded-lg p-4">
            <p class="text-xs text-blue-700">
                <i class="bi bi-info-circle mr-2"></i>
                Kode reset akan dikirim ke email Anda dan valid selama 15 menit.
            </p>
        </div>
    </div>

</body>
</html>
