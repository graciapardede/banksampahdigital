<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar - Green Saving</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        'poppins': ['Poppins', 'sans-serif'],
                    },
                    colors: {
                        'green-primary': '#2e7d32',
                        'green-secondary': '#66bb6a',
                        'green-light': '#c8e6c9',
                        'green-bg': '#e8f5e9',
                    }
                }
            }
        }
    </script>
</head>
<body class="min-h-screen bg-gradient-to-b from-green-bg to-green-50 font-poppins flex items-center justify-center p-4">

    <div class="bg-white w-full max-w-xl rounded-3xl shadow-2xl p-10 text-center">
        <!-- Logo Section -->
        <div class="mb-6">
            <div class="w-20 h-20 mx-auto mb-4 bg-gradient-to-br from-green-100 to-green-200 rounded-2xl flex items-center justify-center shadow-lg">
                <img src="{{ asset('images/logouser1.png') }}" alt="Logo Green Saving" class="w-12 h-12 object-contain">
            </div>
            <h1 class="text-3xl font-bold text-green-primary mb-1">Green Saving</h1>
            <p class="text-gray-600 font-medium">Bank Sampah Digital</p>
        </div>

        <!-- Description -->
        <p class="text-green-primary font-semibold mb-6 leading-relaxed">
            Daftar dan Masuk untuk memulai petualangan<br>
            ramah lingkungan Anda!
        </p>

        <!-- Tab Buttons -->
        <div class="flex bg-green-light/50 rounded-full p-1 mb-8 max-w-xs mx-auto">
            <a href="/login" class="flex-1 py-2 px-4 rounded-full text-green-primary font-semibold text-sm transition-all duration-300 hover:bg-white/70">
                Masuk
            </a>
            <a href="/register" class="flex-1 py-2 px-4 rounded-full bg-green-secondary text-white font-semibold text-sm transition-all duration-300 shadow-md">
                Daftar
            </a>
        </div>

        <!-- Register Form -->
        <form method="POST" action="/register" class="space-y-4">
            @csrf
            
            <!-- Error Messages -->
            @if ($errors->any())
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded-xl">
                    <ul class="list-disc list-inside text-sm">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
            
            <div class="text-left">
                <label for="full_name" class="block text-sm font-semibold text-gray-800 mb-2">Nama Lengkap</label>
                <input 
                    type="text" 
                    id="full_name" 
                    name="full_name"
                    value="{{ old('full_name') }}"
                    class="w-full px-4 py-3 bg-gray-50 border-0 rounded-xl text-gray-800 placeholder-gray-500 focus:ring-3 focus:ring-green-secondary/30 focus:bg-white transition-all duration-200" 
                    placeholder="Masukkan nama lengkap" 
                    required
                >
            </div>

            <div class="text-left">
                <label for="email" class="block text-sm font-semibold text-gray-800 mb-2">Email</label>
                <input 
                    type="email" 
                    id="email" 
                    name="email"
                    value="{{ old('email') }}"
                    class="w-full px-4 py-3 bg-gray-50 border-0 rounded-xl text-gray-800 placeholder-gray-500 focus:ring-3 focus:ring-green-secondary/30 focus:bg-white transition-all duration-200" 
                    placeholder="Masukkan email" 
                    required
                >
            </div>

            <div class="text-left">
                <label for="phone" class="block text-sm font-semibold text-gray-800 mb-2">Nomor Telepon</label>
                <input 
                    type="tel" 
                    id="phone" 
                    name="phone"
                    value="{{ old('phone') }}"
                    class="w-full px-4 py-3 bg-gray-50 border-0 rounded-xl text-gray-800 placeholder-gray-500 focus:ring-3 focus:ring-green-secondary/30 focus:bg-white transition-all duration-200" 
                    placeholder="Masukkan nomor telepon" 
                >
            </div>

            <div class="grid grid-cols-2 gap-4">
                <div class="text-left">
                    <label for="password" class="block text-sm font-semibold text-gray-800 mb-2">Password</label>
                    <input 
                        type="password" 
                        id="password" 
                        name="password"
                        class="w-full px-4 py-3 bg-gray-50 border-0 rounded-xl text-gray-800 placeholder-gray-500 focus:ring-3 focus:ring-green-secondary/30 focus:bg-white transition-all duration-200" 
                        placeholder="Password" 
                        required
                    >
                </div>
                <div class="text-left">
                    <label for="password_confirmation" class="block text-sm font-semibold text-gray-800 mb-2">Konfirmasi</label>
                    <input 
                        type="password" 
                        id="password_confirmation" 
                        name="password_confirmation"
                        class="w-full px-4 py-3 bg-gray-50 border-0 rounded-xl text-gray-800 placeholder-gray-500 focus:ring-3 focus:ring-green-secondary/30 focus:bg-white transition-all duration-200" 
                        placeholder="Konfirmasi" 
                        required
                    >
                </div>
            </div>

            <div class="text-left">
                <label for="address" class="block text-sm font-semibold text-gray-800 mb-2">Alamat</label>
                <input 
                    type="text" 
                    id="address" 
                    name="address"
                    value="{{ old('address') }}"
                    class="w-full px-4 py-3 bg-gray-50 border-0 rounded-xl text-gray-800 placeholder-gray-500 focus:ring-3 focus:ring-green-secondary/30 focus:bg-white transition-all duration-200" 
                    placeholder="Masukkan alamat" 
                >
            </div>

            <button 
                type="submit" 
                class="w-full bg-gradient-to-r from-green-secondary to-green-primary text-white font-bold py-3 px-6 rounded-xl hover:shadow-lg hover:scale-[1.02] transition-all duration-200 mt-6"
            >
                Daftar Sekarang
            </button>
        </form>

        <!-- Footer -->
        <p class="mt-6 text-gray-600 text-sm">
            Sudah punya akun? 
            <a href="/login" class="text-green-primary font-semibold hover:underline">Masuk sekarang</a>
        </p>
    </div>

</body>
</html> 
