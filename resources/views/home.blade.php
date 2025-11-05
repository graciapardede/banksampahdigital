<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Green Saving - Bank Sampah Digital</title>
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
<body class="m-0 font-poppins bg-green-50/30 overflow-x-hidden">

    <!-- Hero Section -->
    <section class="relative h-[55vh] flex flex-col items-center justify-center text-center text-white mb-0"
             style="background: linear-gradient(rgba(0, 100, 0, 0.55), rgba(0, 100, 0, 0.55)), url('{{ asset('images/background.png') }}') center/cover no-repeat;">
        <img src="{{ asset('images/logo user.png') }}" alt="Logo Green Saving" class="w-20 mb-4">
        <h2 class="font-bold text-3xl">Welcome to <span class="text-green-100">Green Saving</span></h2>
        <p class="font-medium text-green-100">Bank Sampah Digital</p>
    </section>

    <!-- Main Content -->
    <div class="relative z-10 bg-white w-full shadow-lg px-8 py-20 lg:px-32 text-center">
        <h3 class="font-bold text-2xl text-gray-900 mb-3">Kelola Sampah, Dapatkan Reward</h3>
        <p class="text-gray-600 mb-12 max-w-3xl mx-auto leading-relaxed">
            Platform Digital untuk mengelola sampah dengan sistem reward yang menguntungkan dan ramah lingkungan
        </p>

        <!-- Feature Cards Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 max-w-4xl mx-auto mb-12">
            <!-- Setor Sampah -->
            <div class="bg-white rounded-2xl shadow-md p-5 flex items-center gap-4 h-24 hover:shadow-lg transition-shadow">
                <img src="{{ asset('images/setor sampah.png') }}" alt="Setor Sampah" class="w-9">
                <div class="text-left">
                    <h5 class="text-green-primary font-semibold text-lg mb-0">Setor Sampah</h5>
                    <small class="text-gray-500 text-sm">Mudah dan Praktis</small>
                </div>
            </div>

            <!-- Tukar Reward -->
            <div class="bg-white rounded-2xl shadow-md p-5 flex items-center gap-4 h-24 hover:shadow-lg transition-shadow">
                <img src="{{ asset('images/tukar reward.png') }}" alt="Tukar Reward" class="w-9">
                <div class="text-left">
                    <h5 class="text-green-primary font-semibold text-lg mb-0">Tukar Reward</h5>
                    <small class="text-gray-500 text-sm">Poin jadi barang</small>
                </div>
            </div>

            <!-- Ramah Lingkungan -->
            <div class="bg-white rounded-2xl shadow-md p-5 flex items-center gap-4 h-24 hover:shadow-lg transition-shadow">
                <img src="{{ asset('images/ramah lingkungan.png') }}" alt="Ramah Lingkungan" class="w-9">
                <div class="text-left">
                    <h5 class="text-green-primary font-semibold text-lg mb-0">Ramah Lingkungan</h5>
                    <small class="text-gray-500 text-sm">Kurangi emisi CO₂</small>
                </div>
            </div>

            <!-- Tracking Lengkap -->
            <div class="bg-white rounded-2xl shadow-md p-5 flex items-center gap-4 h-24 hover:shadow-lg transition-shadow">
                <img src="{{ asset('images/tracking lengkap.png') }}" alt="Tracking Lengkap" class="w-9">
                <div class="text-left">
                    <h5 class="text-green-primary font-semibold text-lg mb-0">Tracking Lengkap</h5>
                    <small class="text-gray-500 text-sm">Monitor Progress</small>
                </div>
            </div>
        </div>

        <!-- Action Buttons -->
        <h5 class="font-semibold text-xl text-gray-900 mb-6">Jelajahi Platform:</h5>
        <div class="flex justify-center gap-4 mb-12">
            <a href="/login" 
               class="bg-green-secondary hover:bg-green-primary text-white font-semibold px-8 py-3 rounded-lg w-32 transition-all duration-300 hover:shadow-lg">
                Masuk
            </a>
            <a href="/register" 
               class="border-2 border-green-secondary text-green-secondary hover:bg-green-secondary hover:text-white font-semibold px-8 py-3 rounded-lg w-32 transition-all duration-300">
                Daftar
            </a>
        </div>

        <!-- Footer Note -->
        <div class="inline-flex items-center justify-center gap-2 bg-green-bg text-green-primary font-medium rounded-xl py-3 px-6">
            <img src="{{ asset('images/daun.png') }}" alt="Daun" class="w-5">
            <span>Bersama menjaga lingkungan untuk masa depan lebih baik</span>
        </div>
    </div>

</body> 
</html>