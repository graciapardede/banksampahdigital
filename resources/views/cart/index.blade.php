<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Keranjang Belanja - Green Saving</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css" rel="stylesheet">
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        'poppins': ['Poppins', 'sans-serif'],
                    }
                }
            }
        }
    </script>
</head>
<body class="min-h-screen bg-gradient-to-br from-green-50 to-green-100 font-poppins">

    <!-- Header -->
    <header class="bg-white shadow-sm sticky top-0 z-40">
        <div class="max-w-6xl mx-auto px-4 py-4">
            <div class="flex justify-between items-center">
                <!-- Back Button & Title -->
                <div class="flex items-center space-x-4">
                    <a href="{{ route('tukar-poin') }}" class="w-10 h-10 bg-green-100 hover:bg-green-200 rounded-xl flex items-center justify-center transition-all">
                        <i class="bi bi-arrow-left text-green-600 text-xl"></i>
                    </a>
                    <div>
                        <h1 class="font-bold text-xl text-gray-800">Keranjang Belanja</h1>
                        <p class="text-sm text-green-600">{{ Auth::user()->name }}</p>
                    </div>
                </div>

                <!-- Cart Count Badge -->
                <div class="bg-gradient-to-br from-green-500 to-green-600 rounded-xl px-4 py-2 shadow-lg">
                    <span class="text-white font-bold">{{ count($cart) }} Item</span>
                </div>
            </div>
        </div>
    </header>

    <!-- Main Content -->
    <main class="max-w-6xl mx-auto px-4 py-8">
        
        <!-- Alerts -->
        @if(session('success'))
            <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 3000)"
                 class="bg-gradient-to-r from-green-500 to-emerald-600 text-white px-6 py-4 rounded-2xl shadow-lg flex items-center justify-between mb-6">
                <div class="flex items-center gap-3">
                    <i class="bi bi-check-circle text-2xl"></i>
                    <span class="font-semibold">{{ session('success') }}</span>
                </div>
                <button @click="show = false" class="text-white hover:bg-white hover:bg-opacity-20 rounded-lg p-2">
                    <i class="bi bi-x-lg"></i>
                </button>
            </div>
        @endif

        @if(session('error'))
            <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 3000)"
                 class="bg-gradient-to-r from-red-500 to-red-600 text-white px-6 py-4 rounded-2xl shadow-lg flex items-center justify-between mb-6">
                <div class="flex items-center gap-3">
                    <i class="bi bi-exclamation-circle text-2xl"></i>
                    <span class="font-semibold">{{ session('error') }}</span>
                </div>
                <button @click="show = false" class="text-white hover:bg-white hover:bg-opacity-20 rounded-lg p-2">
                    <i class="bi bi-x-lg"></i>
                </button>
            </div>
        @endif

        @if(empty($cart))
            <!-- Empty Cart State -->
            <div class="bg-white rounded-2xl shadow-lg p-12 text-center">
                <div class="w-32 h-32 mx-auto bg-gray-100 rounded-full flex items-center justify-center mb-6">
                    <i class="bi bi-cart-x text-gray-400 text-6xl"></i>
                </div>
                <h2 class="text-2xl font-bold text-gray-800 mb-2">Keranjang Kosong</h2>
                <p class="text-gray-600 mb-6">Anda belum menambahkan item apapun ke keranjang</p>
                <a href="{{ route('tukar-poin') }}" 
                   class="inline-flex items-center gap-2 bg-gradient-to-r from-green-500 to-green-600 hover:from-green-600 hover:to-green-700 text-white font-semibold px-8 py-3 rounded-xl shadow-lg transition-all">
                    <i class="bi bi-shop"></i>
                    Mulai Belanja
                </a>
            </div>
        @else
            <div class="grid lg:grid-cols-3 gap-6">
                
                <!-- Left: Cart Items -->
                <div class="lg:col-span-2 space-y-4">
                    @foreach($cart as $item)
                        <div class="bg-white rounded-2xl shadow-md p-6 hover:shadow-lg transition-shadow">
                            <div class="flex gap-4">
                                <!-- Image -->
                                <div class="w-24 h-24 bg-gradient-to-br from-green-50 to-emerald-50 rounded-xl flex items-center justify-center flex-shrink-0">
                                    @if($item['image'])
                                        <img src="{{ asset('images/' . $item['image']) }}" alt="{{ $item['name'] }}" class="w-20 h-20 object-contain">
                                    @else
                                        <i class="bi bi-gift text-gray-300 text-4xl"></i>
                                    @endif
                                </div>

                                <!-- Info -->
                                <div class="flex-1">
                                    <h3 class="font-bold text-lg text-gray-800 mb-1">{{ $item['name'] }}</h3>
                                    <div class="flex items-center gap-2 text-green-600 font-semibold mb-3">
                                        <i class="bi bi-coin"></i>
                                        <span>{{ number_format($item['points_required'], 0, ',', '.') }} poin/item</span>
                                    </div>

                                    <!-- Quantity Controls -->
                                    <div class="flex items-center gap-4">
                                        <form action="{{ route('cart.update', $item['id']) }}" method="POST" class="flex items-center gap-3">
                                            @csrf
                                            <label class="text-sm text-gray-600 font-semibold">Qty:</label>
                                            <div class="flex items-center gap-2">
                                                <button type="button" onclick="this.nextElementSibling.stepDown(); this.form.submit();"
                                                    class="w-8 h-8 bg-gray-100 hover:bg-gray-200 rounded-lg flex items-center justify-center font-bold transition-all">
                                                    <i class="bi bi-dash"></i>
                                                </button>
                                                <input type="number" name="quantity" value="{{ $item['quantity'] }}" 
                                                    min="1" max="{{ $item['stock'] }}"
                                                    class="w-16 text-center border-2 border-gray-200 rounded-lg py-1 font-bold focus:border-green-500 focus:outline-none"
                                                    onchange="this.form.submit()">
                                                <button type="button" onclick="this.previousElementSibling.stepUp(); this.form.submit();"
                                                    class="w-8 h-8 bg-gray-100 hover:bg-gray-200 rounded-lg flex items-center justify-center font-bold transition-all">
                                                    <i class="bi bi-plus"></i>
                                                </button>
                                            </div>
                                            <span class="text-xs text-gray-500">Maks: {{ $item['stock'] }}</span>
                                        </form>
                                    </div>
                                </div>

                                <!-- Actions & Subtotal -->
                                <div class="flex flex-col items-end justify-between">
                                    <form action="{{ route('cart.remove', $item['id']) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-500 hover:text-red-700 hover:bg-red-50 p-2 rounded-lg transition-all">
                                            <i class="bi bi-trash text-xl"></i>
                                        </button>
                                    </form>

                                    <div class="text-right">
                                        <p class="text-xs text-gray-500 mb-1">Subtotal</p>
                                        <p class="text-xl font-bold text-green-600">
                                            {{ number_format($item['points_required'] * $item['quantity'], 0, ',', '.') }} poin
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach

                    <!-- Clear Cart Button -->
                    <form action="{{ route('cart.clear') }}" method="POST" class="pt-4">
                        @csrf
                        <button type="submit" 
                            onclick="return confirm('Yakin ingin mengosongkan keranjang?')"
                            class="text-red-600 hover:text-red-700 font-semibold flex items-center gap-2">
                            <i class="bi bi-trash"></i>
                            Kosongkan Keranjang
                        </button>
                    </form>
                </div>

                <!-- Right: Summary & Checkout -->
                <div class="lg:col-span-1">
                    <div class="bg-white rounded-2xl shadow-lg p-6 sticky top-24 space-y-6">
                        
                        <h3 class="text-xl font-bold text-gray-800 border-b pb-3">Ringkasan Belanja</h3>

                        <!-- User Balance -->
                        <div class="bg-gradient-to-r from-blue-50 to-indigo-50 rounded-xl p-4 border-2 border-blue-200">
                            <p class="text-xs text-gray-600 mb-2">Saldo Poin Anda</p>
                            <div class="flex items-center gap-2">
                                <i class="bi bi-wallet2 text-blue-600 text-2xl"></i>
                                <span class="text-2xl font-bold text-blue-700">{{ number_format($user->balance_points, 0, ',', '.') }}</span>
                                <span class="text-sm text-gray-600">poin</span>
                            </div>
                        </div>

                        <!-- Cart Summary -->
                        <div class="space-y-3">
                            <div class="flex justify-between text-gray-600">
                                <span>Total Item</span>
                                <span class="font-semibold">{{ count($cart) }} item</span>
                            </div>
                            <div class="flex justify-between text-gray-600">
                                <span>Total Quantity</span>
                                <span class="font-semibold">{{ array_sum(array_column($cart, 'quantity')) }} pcs</span>
                            </div>
                            <div class="pt-3 border-t-2 border-gray-200">
                                <div class="flex justify-between items-center">
                                    <span class="text-gray-700 font-semibold">Total Poin</span>
                                    <div class="text-right">
                                        <p class="text-3xl font-bold text-green-600">{{ number_format($totalPoints, 0, ',', '.') }}</p>
                                        <p class="text-xs text-gray-500">poin</p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Balance Check -->
                        @if($user->balance_points < $totalPoints)
                            <div class="bg-red-50 border-2 border-red-200 rounded-xl p-4">
                                <div class="flex items-center gap-2 text-red-700 mb-2">
                                    <i class="bi bi-exclamation-triangle text-xl"></i>
                                    <span class="font-bold">Saldo Tidak Cukup</span>
                                </div>
                                <p class="text-sm text-red-600">
                                    Kurang {{ number_format($totalPoints - $user->balance_points, 0, ',', '.') }} poin
                                </p>
                            </div>
                        @else
                            <div class="bg-green-50 border-2 border-green-200 rounded-xl p-4">
                                <div class="flex items-center gap-2 text-green-700">
                                    <i class="bi bi-check-circle text-xl"></i>
                                    <span class="font-bold">Saldo Mencukupi</span>
                                </div>
                            </div>
                        @endif

                        <!-- Checkout Form -->
                        <form action="{{ route('cart.checkout') }}" method="POST" class="space-y-4">
                            @csrf
                            
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-2">Catatan (Opsional)</label>
                                <textarea name="notes" rows="3" 
                                    class="w-full border-2 border-gray-200 rounded-xl p-3 text-sm focus:border-green-500 focus:outline-none"
                                    placeholder="Tulis catatan jika ada..."></textarea>
                            </div>

                            @if($user->balance_points >= $totalPoints)
                                <button type="submit" 
                                    class="w-full bg-gradient-to-r from-green-500 to-green-600 hover:from-green-600 hover:to-green-700 text-white font-bold py-4 rounded-xl shadow-lg hover:shadow-xl transition-all">
                                    <i class="bi bi-cart-check mr-2"></i>
                                    Checkout Sekarang
                                </button>
                            @else
                                <button type="button" disabled
                                    class="w-full bg-gray-300 text-gray-500 font-bold py-4 rounded-xl cursor-not-allowed">
                                    <i class="bi bi-x-circle mr-2"></i>
                                    Saldo Tidak Cukup
                                </button>
                            @endif
                        </form>

                        <!-- Info -->
                        <div class="bg-blue-50 rounded-xl p-4 border-l-4 border-blue-500">
                            <h4 class="font-bold text-blue-800 text-sm mb-2">
                                <i class="bi bi-info-circle mr-1"></i>
                                Informasi
                            </h4>
                            <ul class="text-xs text-blue-900 space-y-1">
                                <li>• Penukaran akan diproses oleh admin</li>
                                <li>• Poin akan langsung terpotong</li>
                                <li>• Ambil barang setelah disetujui</li>
                            </ul>
                        </div>

                    </div>
                </div>

            </div>
        @endif

    </main>

    <!-- Footer -->
    <footer class="bg-white py-6 mt-12 border-t">
        <div class="max-w-6xl mx-auto px-4 text-center">
            <p class="text-sm text-gray-600">© 2025 Green Saving. Sistem Bank Sampah Digital</p>
        </div>
    </footer>

</body>
</html>
