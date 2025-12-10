<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Verifikasi Kode Reset - Green Saving</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css" rel="stylesheet">
</head>
<body class="min-h-screen bg-gradient-to-br from-green-50 to-green-100 font-poppins flex items-center justify-center px-4">

    <div class="w-full max-w-md">
        <!-- Logo Card -->
        <div class="text-center mb-8">
            <div class="w-20 h-20 bg-gradient-to-br from-green-500 to-green-600 rounded-2xl flex items-center justify-center mx-auto mb-4 shadow-lg">
                <i class="bi bi-shield-check text-white text-4xl"></i>
            </div>
            <h1 class="text-3xl font-bold text-gray-800">Verifikasi Kode</h1>
            <p class="text-gray-600 mt-2">Masukkan kode 6 digit yang Anda terima</p>
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
            <form method="POST" action="{{ route('password.verify-code') }}" class="space-y-4">
                @csrf

                <input type="hidden" name="email" value="{{ $email ?? request()->query('email') }}">

                <div>
                    <label for="reset_code" class="block text-sm font-semibold text-gray-700 mb-2">
                        <i class="bi bi-key mr-1"></i>Kode Reset (6 Digit)
                    </label>
                    <input 
                        id="reset_code"
                        type="text"
                        name="reset_code"
                        inputmode="numeric"
                        maxlength="6"
                        value="{{ old('reset_code') }}"
                        required
                        autofocus
                        class="w-full px-4 py-3 bg-white border-2 border-gray-200 rounded-xl focus:border-green-500 focus:ring-2 focus:ring-green-200 transition-all outline-none text-gray-700 placeholder-gray-400 text-center text-2xl tracking-widest font-mono"
                        placeholder="000000"
                    >
                    @error('reset_code')
                        <p class="mt-2 text-xs text-red-600 flex items-center">
                            <i class="bi bi-exclamation-circle mr-1"></i>{{ $message }}
                        </p>
                    @enderror
                </div>

                <p class="text-xs text-gray-500 text-center">
                    <i class="bi bi-info-circle mr-1"></i>
                    Kode berlaku selama 15 menit
                </p>

                <button 
                    type="submit"
                    class="w-full bg-gradient-to-r from-green-500 to-green-600 hover:from-green-600 hover:to-green-700 text-white font-bold py-3 px-4 rounded-xl shadow-lg hover:shadow-xl transition-all duration-200 flex items-center justify-center gap-2"
                >
                    <i class="bi bi-check-circle"></i>
                    Verifikasi Kode
                </button>
            </form>

            <hr class="my-6">

            <p class="text-center text-sm text-gray-600">
                <a href="{{ route('password.forgot') }}" class="text-green-600 hover:text-green-700 font-semibold transition-colors">
                    <i class="bi bi-arrow-left mr-1"></i>Mulai Ulang
                </a>
            </p>
        </div>

        <!-- Info Box -->
        <div class="bg-yellow-50 border-l-4 border-yellow-500 rounded-lg p-4">
            <p class="text-xs text-yellow-700">
                <i class="bi bi-lightbulb mr-2"></i>
                Belum menerima kode? Cek folder spam Anda atau refresh halaman.
            </p>
        </div>
    </div>

    <script>
        // Auto-format input ke angka saja
        document.getElementById('reset_code').addEventListener('input', function(e) {
            e.target.value = e.target.value.replace(/[^0-9]/g, '');
        });
    </script>

</body>
</html>
