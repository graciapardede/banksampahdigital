<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Green Saving - Bank Sampah Digital</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        body { font-family: 'Poppins', sans-serif; }
        .hover-lift { transition: transform 0.3s ease, box-shadow 0.3s ease; }
        .hover-lift:hover { transform: translateY(-8px); box-shadow: 0 20px 40px rgba(46, 204, 113, 0.2); }
    </style>
</head>
<body class="bg-white">
    <nav class="fixed w-full top-0 z-50 bg-white/95 backdrop-blur-sm shadow-sm">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-20">
                <div class="flex items-center space-x-3">
                    <div class="w-12 h-12 bg-gradient-to-br from-[#2ECC71] to-green-600 rounded-xl flex items-center justify-center shadow-lg">
                        <i class="bi bi-recycle text-white text-2xl"></i>
                    </div>
                    <div>
                        <h1 class="text-xl font-bold text-gray-800">Green Saving</h1>
                        <p class="text-xs text-gray-500">Bank Sampah Digital</p>
                    </div>
                </div>
                <div class="hidden md:flex items-center space-x-8">
                    <a href="#features" class="text-gray-600 hover:text-[#2ECC71] font-medium transition">Fitur</a>
                    <a href="#stats" class="text-gray-600 hover:text-[#2ECC71] font-medium transition">Statistik</a>
                    <a href="#contact" class="text-gray-600 hover:text-[#2ECC71] font-medium transition">Kontak</a>
                    @auth
                        <a href="{{ route('dashboard') }}" class="px-6 py-2.5 bg-[#2ECC71] text-white font-semibold rounded-xl hover:bg-green-600 transition shadow-md">Dashboard</a>
                    @else
                        <a href="{{ route('login') }}" class="text-gray-600 hover:text-[#2ECC71] font-medium transition">Masuk</a>
                        <a href="{{ route('register') }}" class="px-6 py-2.5 bg-[#2ECC71] text-white font-semibold rounded-xl hover:bg-green-600 transition shadow-md">Daftar Sekarang</a>
                    @endauth
                </div>
            </div>
        </div>
    </nav>
    <section class="relative min-h-screen flex items-center justify-center overflow-hidden pt-20">
        <div class="absolute inset-0 z-0">
            <img src="https://images.unsplash.com/photo-1532996122724-e3c354a0b15b?q=80&w=2070" alt="Recycling" class="w-full h-full object-cover">
            <div class="absolute inset-0 bg-gradient-to-br from-[#2ECC71]/90 to-green-600/85"></div>
        </div>
        <div class="relative z-10 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <div class="space-y-8">
                <div class="inline-flex items-center px-4 py-2 bg-white/20 backdrop-blur-sm rounded-full text-white text-sm font-medium">
                    <i class="bi bi-lightning-charge-fill mr-2"></i>Platform Terpercaya & Ramah Lingkungan
                </div>
                <h1 class="text-5xl md:text-7xl font-bold text-white leading-tight">
                    Kelola Sampah,<br><span class="text-[#FFC947]">Dapatkan Reward</span>
                </h1>
                <p class="text-xl md:text-2xl text-white/90 max-w-3xl mx-auto leading-relaxed">
                    Platform digital untuk setor sampah, kumpulkan poin, dan tukarkan menjadi kebutuhan rumah tangga secara mudah.
                </p>
                <div class="flex flex-col sm:flex-row items-center justify-center gap-4 pt-4">
                    <a href="{{ route('register') }}" class="w-full sm:w-auto px-8 py-4 bg-white text-[#2ECC71] font-bold text-lg rounded-xl hover:bg-gray-50 transition-all shadow-2xl hover:scale-105 flex items-center justify-center">
                        <i class="bi bi-person-plus-fill mr-2"></i>Daftar Sekarang
                    </a>
                    <a href="#features" class="w-full sm:w-auto px-8 py-4 bg-transparent border-2 border-white text-white font-bold text-lg rounded-xl hover:bg-white/10 transition-all flex items-center justify-center">
                        <i class="bi bi-play-circle-fill mr-2"></i>Pelajari Cara Kerja
                    </a>
                </div>
                <div class="pt-12 grid grid-cols-3 gap-6 max-w-2xl mx-auto">
                    <div class="text-center">
                        <div class="text-3xl md:text-4xl font-bold text-white">100+</div>
                        <div class="text-sm text-white/80 mt-1">Pengguna Aktif</div>
                    </div>
                    <div class="text-center">
                        <div class="text-3xl md:text-4xl font-bold text-white">1000+</div>
                        <div class="text-sm text-white/80 mt-1">Kg Sampah</div>
                    </div>
                    <div class="text-center">
                        <div class="text-3xl md:text-4xl font-bold text-white">500+</div>
                        <div class="text-sm text-white/80 mt-1">Reward Ditukar</div>
                    </div>
                </div>
            </div>
        </div>
        <div class="absolute bottom-8 left-1/2 transform -translate-x-1/2 animate-bounce">
            <a href="#features" class="text-white/80 hover:text-white">
                <i class="bi bi-chevron-down text-3xl"></i>
            </a>
        </div>
    </section>
    <section id="features" class="py-20 md:py-32 bg-gradient-to-b from-white to-[#F0FFF4]">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-16">
                <div class="inline-flex items-center px-4 py-2 bg-[#2ECC71]/10 rounded-full text-[#2ECC71] text-sm font-semibold mb-4">
                    <i class="bi bi-stars mr-2"></i>Fitur Unggulan
                </div>
                <h2 class="text-4xl md:text-5xl font-bold text-gray-800 mb-4">
                    Kenapa Pilih <span class="text-[#2ECC71]">Green Saving</span>?
                </h2>
                <p class="text-lg text-gray-600 max-w-2xl mx-auto">
                    Solusi lengkap untuk mengelola sampah Anda dengan cara yang modern, mudah, dan menguntungkan.
                </p>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                <div class="group bg-white rounded-2xl p-8 shadow-lg hover-lift border border-gray-100">
                    <div class="w-16 h-16 bg-gradient-to-br from-[#2ECC71] to-green-600 rounded-2xl flex items-center justify-center mb-6 group-hover:scale-110 transition-transform">
                        <i class="bi bi-recycle text-white text-3xl"></i>
                    </div>
                    <h3 class="text-2xl font-bold text-gray-800 mb-3">Setor Sampah</h3>
                    <p class="text-gray-600 leading-relaxed mb-4">Setorkan sampah Anda ke cabang terdekat dan dapatkan poin secara otomatis.</p>
                    <ul class="space-y-2">
                        <li class="flex items-start text-gray-600"><i class="bi bi-check-circle-fill text-[#2ECC71] mr-2 mt-1"></i><span>Timbangan digital akurat</span></li>
                        <li class="flex items-start text-gray-600"><i class="bi bi-check-circle-fill text-[#2ECC71] mr-2 mt-1"></i><span>Konversi poin real-time</span></li>
                    </ul>
                </div>
                <div class="group bg-white rounded-2xl p-8 shadow-lg hover-lift border border-gray-100">
                    <div class="w-16 h-16 bg-gradient-to-br from-purple-500 to-purple-600 rounded-2xl flex items-center justify-center mb-6 group-hover:scale-110 transition-transform">
                        <i class="bi bi-gift text-white text-3xl"></i>
                    </div>
                    <h3 class="text-2xl font-bold text-gray-800 mb-3">Tukar Reward</h3>
                    <p class="text-gray-600 leading-relaxed mb-4">Tukarkan poin dengan kebutuhan rumah tangga seperti minyak, sabun, beras.</p>
                    <ul class="space-y-2">
                        <li class="flex items-start text-gray-600"><i class="bi bi-check-circle-fill text-[#2ECC71] mr-2 mt-1"></i><span>Katalog produk lengkap</span></li>
                        <li class="flex items-start text-gray-600"><i class="bi bi-check-circle-fill text-[#2ECC71] mr-2 mt-1"></i><span>Proses penukaran mudah</span></li>
                    </ul>
                </div>
                <div class="group bg-white rounded-2xl p-8 shadow-lg hover-lift border border-gray-100">
                    <div class="w-16 h-16 bg-gradient-to-br from-blue-500 to-blue-600 rounded-2xl flex items-center justify-center mb-6 group-hover:scale-110 transition-transform">
                        <i class="bi bi-globe-asia-australia text-white text-3xl"></i>
                    </div>
                    <h3 class="text-2xl font-bold text-gray-800 mb-3">Ramah Lingkungan</h3>
                    <p class="text-gray-600 leading-relaxed mb-4">Berkontribusi untuk lingkungan yang lebih bersih dan hijau.</p>
                    <ul class="space-y-2">
                        <li class="flex items-start text-gray-600"><i class="bi bi-check-circle-fill text-[#2ECC71] mr-2 mt-1"></i><span>Daur ulang profesional</span></li>
                        <li class="flex items-start text-gray-600"><i class="bi bi-check-circle-fill text-[#2ECC71] mr-2 mt-1"></i><span>Kurangi limbah TPA</span></li>
                    </ul>
                </div>
                <div class="group bg-white rounded-2xl p-8 shadow-lg hover-lift border border-gray-100">
                    <div class="w-16 h-16 bg-gradient-to-br from-orange-500 to-orange-600 rounded-2xl flex items-center justify-center mb-6 group-hover:scale-110 transition-transform">
                        <i class="bi bi-graph-up-arrow text-white text-3xl"></i>
                    </div>
                    <h3 class="text-2xl font-bold text-gray-800 mb-3">Tracking Lengkap</h3>
                    <p class="text-gray-600 leading-relaxed mb-4">Pantau seluruh aktivitas dalam satu dashboard.</p>
                    <ul class="space-y-2">
                        <li class="flex items-start text-gray-600"><i class="bi bi-check-circle-fill text-[#2ECC71] mr-2 mt-1"></i><span>Dashboard interaktif</span></li>
                        <li class="flex items-start text-gray-600"><i class="bi bi-check-circle-fill text-[#2ECC71] mr-2 mt-1"></i><span>Laporan detail</span></li>
                    </ul>
                </div>
            </div>
        </div>
    </section>
    <section id="stats" class="py-20 md:py-32 bg-gradient-to-br from-[#2ECC71] to-green-600 relative overflow-hidden">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
            <div class="text-center mb-16">
                <div class="inline-flex items-center px-4 py-2 bg-white/20 backdrop-blur-sm rounded-full text-white text-sm font-semibold mb-4">
                    <i class="bi bi-bar-chart-fill mr-2"></i>Statistik Real-Time
                </div>
                <h2 class="text-4xl md:text-5xl font-bold text-white mb-4">Dampak Positif Bersama</h2>
                <p class="text-lg text-white/90 max-w-2xl mx-auto">Bergabunglah dengan ribuan warga yang telah merasakan manfaat Bank Sampah Digital</p>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <div class="bg-white/10 backdrop-blur-md rounded-2xl p-8 text-center border border-white/20 hover:bg-white/15 transition-all hover-lift">
                    <div class="w-20 h-20 bg-white/20 rounded-full flex items-center justify-center mx-auto mb-6">
                        <i class="bi bi-trash3 text-white text-4xl"></i>
                    </div>
                    <div class="text-5xl font-bold text-white mb-2">1,250</div>
                    <div class="text-xl text-white/80 font-medium mb-2">Kilogram</div>
                    <div class="text-sm text-white/70">Total Sampah Terkumpul</div>
                </div>
                <div class="bg-white/10 backdrop-blur-md rounded-2xl p-8 text-center border border-white/20 hover:bg-white/15 transition-all hover-lift">
                    <div class="w-20 h-20 bg-white/20 rounded-full flex items-center justify-center mx-auto mb-6">
                        <i class="bi bi-people-fill text-white text-4xl"></i>
                    </div>
                    <div class="text-5xl font-bold text-white mb-2">250+</div>
                    <div class="text-xl text-white/80 font-medium mb-2">Pengguna</div>
                    <div class="text-sm text-white/70">Jumlah Pengguna Terdaftar</div>
                </div>
                <div class="bg-white/10 backdrop-blur-md rounded-2xl p-8 text-center border border-white/20 hover:bg-white/15 transition-all hover-lift">
                    <div class="w-20 h-20 bg-white/20 rounded-full flex items-center justify-center mx-auto mb-6">
                        <i class="bi bi-gift-fill text-white text-4xl"></i>
                    </div>
                    <div class="text-5xl font-bold text-white mb-2">580</div>
                    <div class="text-xl text-white/80 font-medium mb-2">Produk</div>
                    <div class="text-sm text-white/70">Barang Reward Ditukarkan</div>
                </div>
            </div>
            <div class="mt-16 bg-white/10 backdrop-blur-md rounded-2xl p-8 md:p-12 text-center border border-white/20">
                <h3 class="text-3xl md:text-4xl font-bold text-white mb-4">Siap Berkontribusi untuk Lingkungan?</h3>
                <p class="text-lg text-white/90 mb-8 max-w-2xl mx-auto">Daftar sekarang dan mulai perjalanan Anda menuju gaya hidup yang lebih hijau.</p>
                <a href="{{ route('register') }}" class="inline-flex items-center px-8 py-4 bg-white text-[#2ECC71] font-bold text-lg rounded-xl hover:bg-gray-50 transition-all shadow-2xl hover:scale-105">
                    <i class="bi bi-rocket-takeoff-fill mr-2"></i>Mulai Sekarang Gratis
                </a>
            </div>
        </div>
    </section>
    <footer id="contact" class="bg-gray-900 text-white pt-16 pb-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-12 mb-12">
                <div>
                    <div class="flex items-center space-x-3 mb-4">
                        <div class="w-12 h-12 bg-gradient-to-br from-[#2ECC71] to-green-600 rounded-xl flex items-center justify-center">
                            <i class="bi bi-recycle text-white text-2xl"></i>
                        </div>
                        <div>
                            <h3 class="text-xl font-bold">Green Saving</h3>
                            <p class="text-sm text-gray-400">Bank Sampah Digital</p>
                        </div>
                    </div>
                    <p class="text-gray-400 text-sm mb-4">Platform digital untuk mengelola sampah dengan cara yang modern.</p>
                </div>
                <div>
                    <h4 class="text-lg font-bold mb-4">Menu Cepat</h4>
                    <ul class="space-y-3">
                        <li><a href="#features" class="text-gray-400 hover:text-[#2ECC71] transition">Fitur</a></li>
                        <li><a href="#" class="text-gray-400 hover:text-[#2ECC71] transition">FAQ</a></li>
                        <li><a href="#" class="text-gray-400 hover:text-[#2ECC71] transition">Kebijakan Privasi</a></li>
                    </ul>
                </div>
                <div>
                    <h4 class="text-lg font-bold mb-4">Layanan</h4>
                    <ul class="space-y-3">
                        <li><a href="{{ route('login') }}" class="text-gray-400 hover:text-[#2ECC71] transition">Setor Sampah</a></li>
                        <li><a href="{{ route('login') }}" class="text-gray-400 hover:text-[#2ECC71] transition">Tukar Reward</a></li>
                        <li><a href="{{ route('register') }}" class="text-gray-400 hover:text-[#2ECC71] transition">Daftar Sekarang</a></li>
                    </ul>
                </div>
                <div>
                    <h4 class="text-lg font-bold mb-4">Hubungi Kami</h4>
                    <ul class="space-y-4">
                        <li class="flex items-start">
                            <i class="bi bi-whatsapp text-[#2ECC71] text-xl mr-3"></i>
                            <div>
                                <div class="text-sm text-gray-400">WhatsApp</div>
                                <a href="https://wa.me/628123456789" class="text-white hover:text-[#2ECC71]">+62 812-3456-7890</a>
                            </div>
                        </li>
                        <li class="flex items-start">
                            <i class="bi bi-envelope-fill text-[#2ECC71] text-xl mr-3"></i>
                            <div>
                                <div class="text-sm text-gray-400">Email</div>
                                <a href="mailto:info@greensaving.id" class="text-white hover:text-[#2ECC71]">info@greensaving.id</a>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="border-t border-gray-800 pt-8 text-center">
                <p class="text-gray-400 text-sm"> 2025 Green Saving  Bank Sampah Digital. All rights reserved.</p>
            </div>
        </div>
    </footer>
    <a href="https://wa.me/628123456789" target="_blank" class="fixed bottom-6 right-6 w-14 h-14 bg-green-500 hover:bg-green-600 text-white rounded-full flex items-center justify-center shadow-2xl hover:scale-110 transition-all z-50">
        <i class="bi bi-whatsapp text-2xl"></i>
    </a>
    <script>
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function (e) {
                e.preventDefault();
                const target = document.querySelector(this.getAttribute('href'));
                if (target) target.scrollIntoView({ behavior: 'smooth' });
            });
        });
    </script>
</body>
</html>
