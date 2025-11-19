<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title ?? 'Green Saving' }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css" rel="stylesheet">
    <link href="{{ asset('css/auth-custom.css') }}" rel="stylesheet">
    <style>
        body { 
            font-family: 'Poppins', sans-serif; 
        }
        .glassmorphism {
            backdrop-filter: blur(16px);
            -webkit-backdrop-filter: blur(16px);
        }
        .animate-float {
            animation: float 3s ease-in-out infinite;
        }
        @keyframes float {
            0%, 100% { transform: translateY(0px); }
            50% { transform: translateY(-20px); }
        }
        .animate-fade-in {
            animation: fadeIn 0.6s ease-out;
        }
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }
    </style>
    <script>
        // Tailwind Config
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        'poppins': ['Poppins', 'sans-serif'],
                    },
                    colors: {
                        'green-saving': {
                            50: '#f0fdf4',
                            100: '#dcfce7',
                            200: '#bbf7d0',
                            300: '#86efac',
                            400: '#4ade80',
                            500: '#22c55e',
                            600: '#16a34a',
                            700: '#15803d',
                            800: '#166534',
                            900: '#14532d',
                        }
                    }
                }
            }
        }
    </script>
</head>
<body class="min-h-screen bg-gradient-to-br from-green-50 via-emerald-50 to-teal-50 flex items-center justify-center p-4 relative overflow-hidden">
    
    <!-- Decorative Background Elements -->
    <div class="absolute inset-0 overflow-hidden pointer-events-none">
        <!-- Floating circles -->
        <div class="absolute top-20 left-10 w-72 h-72 bg-green-200 rounded-full mix-blend-multiply filter blur-xl opacity-20 animate-float"></div>
        <div class="absolute bottom-20 right-10 w-72 h-72 bg-emerald-200 rounded-full mix-blend-multiply filter blur-xl opacity-20 animate-float" style="animation-delay: 2s;"></div>
        <div class="absolute top-1/2 left-1/2 w-72 h-72 bg-teal-200 rounded-full mix-blend-multiply filter blur-xl opacity-20 animate-float" style="animation-delay: 4s;"></div>
    </div>

    <!-- Main Content -->
    <div class="relative z-10 w-full max-w-6xl animate-fade-in">
        {{ $slot }}
    </div>

    <!-- Floating Icons (Decorative) -->
    <div class="absolute top-10 right-10 opacity-10 pointer-events-none hidden lg:block">
        <i class="bi bi-recycle text-green-600 text-9xl animate-float"></i>
    </div>
    <div class="absolute bottom-10 left-10 opacity-10 pointer-events-none hidden lg:block">
        <i class="bi bi-leaf text-green-600 text-8xl animate-float" style="animation-delay: 1s;"></i>
    </div>

</body>
</html>
