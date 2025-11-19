<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ $rewardItem->name }} - Detail Produk</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css" rel="stylesheet">
    
    <!-- SweetAlert2 CSS & JS -->
    <link href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    
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
                        <h1 class="font-bold text-xl text-gray-800">Detail Produk</h1>
                        <p class="text-sm text-green-600">{{ Auth::user()->name }}</p>
                    </div>
                </div>

                <!-- Cart Icon -->
                <a href="{{ route('cart.index') }}" class="relative w-12 h-12 bg-gradient-to-br from-green-500 to-green-600 rounded-xl flex items-center justify-center shadow-lg hover:shadow-xl transition-all">
                    <i class="bi bi-cart3 text-white text-xl"></i>
                    @if(session('cart') && count(session('cart')) > 0)
                        <span class="absolute -top-2 -right-2 bg-red-500 text-white text-xs font-bold rounded-full w-6 h-6 flex items-center justify-center">
                            {{ count(session('cart')) }}
                        </span>
                    @endif
                </a>
            </div>
        </div>
    </header>

    <!-- Main Content -->
    <main class="max-w-6xl mx-auto px-4 py-8">
        
        <!-- Success/Error Alert -->
        @if(session('success'))
            <div class="bg-gradient-to-r from-green-500 to-emerald-600 text-white px-6 py-4 rounded-2xl shadow-lg flex items-center justify-between mb-6">
                <div class="flex items-center gap-3">
                    <i class="bi bi-check-circle text-2xl"></i>
                    <span class="font-semibold">{{ session('success') }}</span>
                </div>
            </div>
        @endif

        @if(session('error'))
            <div class="bg-gradient-to-r from-red-500 to-red-600 text-white px-6 py-4 rounded-2xl shadow-lg flex items-center justify-between mb-6">
                <div class="flex items-center gap-3">
                    <i class="bi bi-exclamation-circle text-2xl"></i>
                    <span class="font-semibold">{{ session('error') }}</span>
                </div>
            </div>
        @endif

        <!-- Product Detail -->
        <div class="grid lg:grid-cols-2 gap-8">
            
            <!-- Left: Image Section -->
            <div class="bg-white rounded-2xl shadow-lg p-6 lg:sticky lg:top-24 h-fit">
                <div class="bg-gradient-to-br from-green-50 to-emerald-50 rounded-xl p-8 mb-4 flex items-center justify-center" style="min-height: 400px;">
                    @if($rewardItem->image)
                        <img src="{{ asset('images/' . $rewardItem->image) }}" 
                             alt="{{ $rewardItem->name }}" 
                             class="max-h-96 w-auto object-contain">
                    @else
                        <i class="bi bi-gift text-gray-300 text-9xl"></i>
                    @endif
                </div>
                
                <!-- Stock Badge -->
                <div class="flex items-center justify-between">
                    <div class="flex items-center gap-2">
                        <i class="bi bi-box-seam text-green-600 text-xl"></i>
                        <span class="text-sm text-gray-600">Stok Tersedia:</span>
                    </div>
                    <span class="px-4 py-2 {{ $rewardItem->stock > 10 ? 'bg-green-100 text-green-700' : 'bg-orange-100 text-orange-700' }} rounded-full font-bold text-sm">
                        {{ $rewardItem->stock }} item
                    </span>
                </div>
            </div>

            <!-- Right: Product Info & Form -->
            <div class="space-y-6">
                
                <!-- Product Info Card -->
                <div class="bg-white rounded-2xl shadow-lg p-6 space-y-4">
                    <div>
                        <h2 class="text-3xl font-bold text-gray-800 mb-2">{{ $rewardItem->name }}</h2>
                        <p class="text-gray-600 leading-relaxed">{{ $rewardItem->description ?? 'Produk berkualitas tinggi dari Green Saving' }}</p>
                    </div>

                    <!-- Price -->
                    <div class="pt-4 border-t border-gray-100">
                        <p class="text-sm text-gray-500 mb-1">Harga Penukaran</p>
                        <div class="flex items-center gap-2">
                            <i class="bi bi-coin text-green-500 text-3xl"></i>
                            <span class="text-4xl font-bold text-green-600" id="item-price-display">{{ number_format($rewardItem->points_cost, 0, ',', '.') }}</span>
                            <span class="text-xl text-gray-500">poin</span>
                        </div>
                        <!-- Hidden raw price for JavaScript -->
                        <input type="hidden" id="raw-item-price" value="{{ $rewardItem->points_cost }}">
                        <input type="hidden" id="raw-item-stock" value="{{ $rewardItem->stock }}">
                    </div>

                    <!-- Branch Info -->
                    @if($rewardItem->branch)
                    <div class="pt-4 border-t border-gray-100">
                        <p class="text-sm text-gray-500 mb-2">Tersedia di:</p>
                        <div class="flex items-center gap-2 text-gray-700">
                            <i class="bi bi-shop text-green-600"></i>
                            <span class="font-semibold">{{ $rewardItem->branch->name }}</span>
                        </div>
                    </div>
                    @endif
                </div>

                <!-- User Balance Card - TUGAS 3: PERCANTIK -->
                <div class="bg-gradient-to-r from-blue-50 to-blue-100 rounded-2xl shadow-lg p-6 border-l-4 border-blue-500" 
                     data-user-balance="{{ $user->balance_points }}">
                    <p class="text-sm font-semibold text-gray-600 mb-3 uppercase tracking-wide">💰 Saldo Poin Anda</p>
                    <div class="flex items-center justify-between">
                        <div class="flex items-center gap-3">
                            <div class="bg-blue-500 p-3 rounded-xl">
                                <i class="bi bi-wallet2 text-white text-2xl"></i>
                            </div>
                            <div>
                                <span class="text-4xl font-extrabold text-blue-700 block" id="user-balance-display">{{ number_format($user->balance_points, 0, ',', '.') }}</span>
                                <span class="text-sm text-gray-600 font-medium">Poin Tersedia</span>
                            </div>
                        </div>
                        <!-- Dynamic Badge - Will be updated by JavaScript -->
                        <span id="balance-status-badge" class="px-5 py-2.5 bg-green-100 text-green-700 rounded-full font-bold text-sm shadow-md">
                            <i class="bi bi-check-circle mr-1"></i>
                            <span id="balance-status-text">Saldo Cukup</span>
                        </span>
                    </div>
                </div>

                <!-- Add to Cart Form -->
                <form action="{{ route('cart.add', $rewardItem->id) }}" method="POST" class="bg-white rounded-2xl shadow-lg p-6 space-y-6">
                    @csrf
                    
                    <div class="quantity-container" 
                         data-item-price="{{ $rewardItem->points_cost }}" 
                         data-item-stock="{{ $rewardItem->stock }}"
                         data-max-stock="{{ $rewardItem->stock }}"
                         data-item-name="{{ $rewardItem->name }}">
                        <label class="block text-sm font-semibold text-gray-700 mb-3">
                            <i class="bi bi-hash mr-2 text-green-600"></i>
                            Jumlah / Kuantitas
                        </label>
                        
                        <!-- TUGAS 2: PERCANTIK INPUT QUANTITY (Gaya E-Commerce) -->
                        <div class="flex items-center justify-center">
                            <div class="inline-flex items-center border-2 border-gray-300 rounded-lg overflow-hidden shadow-sm hover:border-green-500 transition-all">
                                <!-- Tombol Minus -->
                                <button type="button" 
                                    id="btnDecrease"
                                    class="px-4 py-3 bg-gray-50 hover:bg-gray-100 active:bg-gray-200 transition-colors disabled:opacity-50 disabled:cursor-not-allowed border-r border-gray-300">
                                    <i class="bi bi-dash text-xl font-bold text-gray-700"></i>
                                </button>
                                
                                <!-- Input Angka -->
                                <input type="number" 
                                    name="quantity" 
                                    id="quantity" 
                                    value="1" 
                                    min="1" 
                                    max="{{ $rewardItem->stock }}"
                                    data-price="{{ $rewardItem->points_cost }}"
                                    class="w-20 text-center text-2xl font-bold border-0 focus:ring-0 focus:outline-none bg-white"
                                    readonly>
                                
                                <!-- Tombol Plus -->
                                <button type="button" 
                                    id="btnIncrease"
                                    class="px-4 py-3 bg-gray-50 hover:bg-gray-100 active:bg-gray-200 transition-colors disabled:opacity-50 disabled:cursor-not-allowed border-l border-gray-300">
                                    <i class="bi bi-plus text-xl font-bold text-gray-700"></i>
                                </button>
                            </div>
                        </div>
                        
                        <p class="text-xs text-gray-500 mt-3 text-center">
                            <i class="bi bi-info-circle mr-1"></i>
                            Stok tersedia: <span class="font-bold text-green-600">{{ $rewardItem->stock }}</span> item
                        </p>
                    </div>

                    <!-- Subtotal Preview -->
                    <div class="bg-gradient-to-r from-gray-50 to-slate-50 rounded-xl p-4 border-2 border-gray-200">
                        <div class="flex items-center justify-between">
                            <span class="text-sm text-gray-600 font-semibold">Subtotal:</span>
                            <div class="flex items-center gap-2">
                                <i class="bi bi-coin text-green-500 text-xl"></i>
                                <span id="subtotal" class="text-2xl font-bold text-gray-800">0</span>
                                <span class="text-sm text-gray-600">poin</span>
                            </div>
                        </div>
                        <!-- Info qty x price -->
                        <p class="text-xs text-gray-500 mt-2 text-right">
                            <span id="qty-display">1</span> item × 
                            <span id="price-display">{{ number_format($rewardItem->points_cost, 0, ',', '.') }}</span> poin
                        </p>
                    </div>

                    @error('quantity')
                        <p class="text-red-600 text-sm"><i class="bi bi-exclamation-circle mr-1"></i>{{ $message }}</p>
                    @enderror

                    <!-- Action Buttons -->
                    <div class="space-y-3 pt-4">
                        <!-- Row 1: Back Button -->
                        <a href="{{ route('tukar-poin') }}" 
                            class="block w-full py-3 bg-gray-100 hover:bg-gray-200 text-gray-700 font-semibold rounded-xl transition-all text-center">
                            <i class="bi bi-arrow-left mr-2"></i>
                            Kembali ke Katalog
                        </a>

                        @if($rewardItem->stock > 0)
                            <!-- Row 2: Add to Cart Button -->
                            <button type="submit"
                                id="btnAddToCart"
                                class="w-full py-4 bg-gradient-to-r from-green-500 to-green-600 hover:from-green-600 hover:to-green-700 text-white font-bold rounded-xl transition-all shadow-lg hover:shadow-xl disabled:opacity-50 disabled:cursor-not-allowed">
                                <i class="bi bi-cart-plus mr-2"></i>
                                Masukkan Keranjang
                            </button>

                            <!-- Row 3: Instant Redeem Button -->
                            <button type="button" 
                                id="btnInstantRedeem"
                                onclick="instantRedeem()"
                                class="w-full py-4 bg-gradient-to-r from-blue-500 to-blue-600 hover:from-blue-600 hover:to-blue-700 text-white font-bold rounded-xl transition-all shadow-lg hover:shadow-xl border-2 border-blue-400 disabled:opacity-50 disabled:cursor-not-allowed">
                                <i class="bi bi-lightning-charge-fill mr-2"></i>
                                Tukar Langsung
                            </button>
                        @else
                            <button type="button" disabled
                                class="w-full py-4 bg-gray-300 text-gray-500 font-bold rounded-xl cursor-not-allowed">
                                <i class="bi bi-x-circle mr-2"></i>
                                Stok Habis
                            </button>
                        @endif
                    </div>
                </form>

                <!-- Info Box -->
                <div class="bg-blue-50 rounded-2xl p-6 border-l-4 border-blue-500">
                    <h4 class="font-bold text-blue-800 mb-3 flex items-center gap-2">
                        <i class="bi bi-info-circle text-xl"></i>
                        Cara Penukaran
                    </h4>
                    <ul class="space-y-2 text-sm text-blue-900">
                        <li class="flex items-start gap-2">
                            <i class="bi bi-1-circle text-blue-600 mt-0.5"></i>
                            <span>Pilih jumlah item yang ingin ditukar</span>
                        </li>
                        <li class="flex items-start gap-2">
                            <i class="bi bi-2-circle text-blue-600 mt-0.5"></i>
                            <span>Klik "Masukkan Keranjang" untuk menambahkan ke cart</span>
                        </li>
                        <li class="flex items-start gap-2">
                            <i class="bi bi-3-circle text-blue-600 mt-0.5"></i>
                            <span>Lihat keranjang untuk review sebelum checkout</span>
                        </li>
                        <li class="flex items-start gap-2">
                            <i class="bi bi-4-circle text-blue-600 mt-0.5"></i>
                            <span>Checkout dan menunggu persetujuan admin</span>
                        </li>
                    </ul>
                </div>

            </div>
        </div>

    </main>

    <script>
        // ============================================================
        // QUANTITY & SUBTOTAL CALCULATOR
        // Tugas 2.1: Quantity Buttons (+/-)
        // Tugas 2.2: Kalkulasi Subtotal Real-Time
        // ============================================================
        
        // DOM Elements (global scope untuk diakses semua fungsi)
        let quantityInput;
        let subtotalDisplay;
        let qtyDisplay;
        let priceDisplay;
        let btnIncrease;
        let btnDecrease;
        let quantityContainer;
        
        // Data item (akan diambil dari data attributes dan hidden inputs)
        let itemPrice = 0;
        let itemStock = 0;
        let itemName = "{{ $rewardItem->name }}";
        
        // TUGAS 1: Variabel saldo user (dari data-attribute)
        let userBalance = 0;
        
        // DOM Elements untuk balance check
        let balanceStatusBadge;
        let balanceStatusText;
        let btnAddToCart;
        let btnInstantRedeem;

        /**
         * Fungsi updateSubtotal() - Wrapper untuk backward compatibility
         * Sekarang memanggil updateSubtotalAndCheckBalance()
         */
        function updateSubtotal() {
            updateSubtotalAndCheckBalance();
        }

        /**
         * TUGAS 2: Fungsi updateSubtotalAndCheckBalance()
         * Menggabungkan update subtotal + check balance
         * Menghilangkan duplikasi ikon
         */
        function updateSubtotalAndCheckBalance() {
            if (!quantityInput || !subtotalDisplay) {
                console.error('❌ Missing required elements');
                return;
            }
            
            // 1. Ambil kuantitas
            const qty = parseInt(quantityInput.value) || 1;
            
            // 2. Hitung subtotal
            const subtotal = itemPrice * qty;
            
            // 3. Update display subtotal
            subtotalDisplay.textContent = subtotal.toLocaleString('id-ID');
            
            // 4. Update breakdown
            if (qtyDisplay) qtyDisplay.textContent = qty;
            if (priceDisplay) priceDisplay.textContent = itemPrice.toLocaleString('id-ID');
            
            console.log('📊 Subtotal updated:', {
                qty: qty,
                price: itemPrice,
                subtotal: subtotal
            });
            
            // 5. Check balance dan update UI
            checkBalanceAndDisable(subtotal);
        }

        /**
         * TUGAS 2: Fungsi checkBalanceAndDisable() - DIPERBAIKI
         * Validasi saldo user vs subtotal yang dibutuhkan
         * Update UI badge dan disable/enable tombol
         * PERBAIKAN: Ikon hanya tampil 1x, tidak duplikat
         */
        function checkBalanceAndDisable(requiredPoints) {
            const availablePoints = userBalance;
            
            console.log('💰 Balance Check:', {
                available: availablePoints,
                required: requiredPoints,
                sufficient: availablePoints >= requiredPoints
            });
            
            // TUGAS 2.2: Perbandingan saldo
            if (requiredPoints > availablePoints) {
                // ❌ SALDO TIDAK CUKUP
                console.warn('⚠️ INSUFFICIENT BALANCE!');
                
                // TUGAS 2.2: Update badge (HAPUS IKON DUPLIKAT - set innerHTML langsung)
                if (balanceStatusBadge) {
                    balanceStatusBadge.className = 'px-4 py-2 bg-red-100 text-red-700 rounded-full font-semibold text-sm';
                }
                if (balanceStatusText) {
                    // PERBAIKAN: Set innerHTML sekali saja, tidak append
                    balanceStatusText.innerHTML = '<i class="bi bi-exclamation-triangle mr-1"></i>Saldo Tidak Cukup';
                }
                
                // TUGAS 2.2: Disable semua tombol aksi
                disablePlusButton();
                
                if (btnAddToCart) {
                    btnAddToCart.disabled = true;
                    btnAddToCart.classList.add('opacity-50', 'cursor-not-allowed');
                }
                if (btnInstantRedeem) {
                    btnInstantRedeem.disabled = true;
                    btnInstantRedeem.classList.add('opacity-50', 'cursor-not-allowed');
                }
                
            } else {
                // ✅ SALDO CUKUP
                console.log('✅ Balance sufficient');
                
                // TUGAS 2.2: Update badge (HAPUS IKON DUPLIKAT - set innerHTML langsung)
                if (balanceStatusBadge) {
                    balanceStatusBadge.className = 'px-4 py-2 bg-green-100 text-green-700 rounded-full font-semibold text-sm';
                }
                if (balanceStatusText) {
                    // PERBAIKAN: Set innerHTML sekali saja, tidak append
                    balanceStatusText.innerHTML = '<i class="bi bi-check-circle mr-1"></i>Saldo Cukup';
                }
                
                // TUGAS 2.2: Enable semua tombol aksi (selama tidak melebihi stok)
                const currentQty = parseInt(quantityInput.value) || 1;
                if (currentQty < itemStock) {
                    enablePlusButton();
                }
                
                if (btnAddToCart) {
                    btnAddToCart.disabled = false;
                    btnAddToCart.classList.remove('opacity-50', 'cursor-not-allowed');
                }
                if (btnInstantRedeem) {
                    btnInstantRedeem.disabled = false;
                    btnInstantRedeem.classList.remove('opacity-50', 'cursor-not-allowed');
                }
            }
        }

        /**
         * TUGAS 1: Helper function - Disable tombol +
         */
        function disablePlusButton() {
            if (btnIncrease) {
                btnIncrease.disabled = true;
                btnIncrease.classList.add('opacity-50', 'cursor-not-allowed');
                console.log('🔒 Plus button disabled');
            }
        }

        /**
         * TUGAS 1: Helper function - Enable tombol +
         */
        function enablePlusButton() {
            if (btnIncrease) {
                btnIncrease.disabled = false;
                btnIncrease.classList.remove('opacity-50', 'cursor-not-allowed');
                console.log('🔓 Plus button enabled');
            }
        }

        /**
         * Alert jika saldo tidak cukup untuk tambah qty
         */
        function showBalanceAlert() {
            const alertDiv = document.createElement('div');
            alertDiv.className = 'fixed top-20 right-4 bg-red-500 text-white px-6 py-3 rounded-xl shadow-lg z-50';
            alertDiv.innerHTML = `
                <div class="flex items-center gap-2">
                    <i class="bi bi-exclamation-circle text-xl"></i>
                    <span class="font-semibold">Saldo tidak cukup untuk menambah quantity!</span>
                </div>
            `;
            document.body.appendChild(alertDiv);
            
            setTimeout(() => {
                alertDiv.style.transition = 'opacity 0.3s';
                alertDiv.style.opacity = '0';
                setTimeout(() => alertDiv.remove(), 300);
            }, 2500);
        }

        /**
         * TUGAS 1.2: Fungsi Tombol '+' (Increase Quantity)
         * Logika Baru:
         * - Cek apakah nextSubtotal masih dalam batas saldo
         * - JANGAN naikkan jika melebihi saldo
         * - Disable tombol + jika sudah max budget
         */
        function increaseQty() {
            if (!quantityInput) {
                console.error('❌ Quantity input not found');
                return;
            }
            
            const currentValue = parseInt(quantityInput.value) || 1;
            
            // TUGAS 1.1: Dapatkan availableBalance dan itemPrice
            const availableBalance = userBalance;
            const pricePerItem = itemPrice;
            
            // TUGAS 1.2: Hitung nextSubtotal SEBELUM menaikkan
            const nextQuantity = currentValue + 1;
            const nextSubtotal = nextQuantity * pricePerItem;
            
            console.log('🔼 Attempting to increase:', {
                current: currentValue,
                next: nextQuantity,
                nextSubtotal: nextSubtotal,
                availableBalance: availableBalance,
                itemStock: itemStock
            });
            
            // Cek stok terlebih dahulu
            if (currentValue >= itemStock) {
                showStockAlert();
                console.warn('⚠️ Cannot increase: Maximum stock reached');
                return;
            }
            
            // TUGAS 1.2: Cek apakah nextSubtotal melebihi saldo
            if (nextSubtotal > availableBalance) {
                // JANGAN naikkan kuantitas
                console.warn('⚠️ Cannot increase: Insufficient balance!', {
                    needed: nextSubtotal,
                    available: availableBalance
                });
                
                // Panggil fungsi disable tombol +
                disablePlusButton();
                
                // Show alert
                showBalanceAlert();
                return;
            }
            
            // Jika lolos semua validasi, naikkan kuantitas
            quantityInput.value = nextQuantity;
            
            // Visual feedback
            if (btnIncrease) {
                btnIncrease.classList.add('scale-95');
                setTimeout(() => btnIncrease.classList.remove('scale-95'), 100);
            }
            
            console.log('✅ Quantity increased to:', nextQuantity);
            
            // TUGAS 1.2: Update subtotal dan check balance
            updateSubtotalAndCheckBalance();
        }

        /**
         * TUGAS 1.3: Fungsi Tombol '-' (Decrease Quantity)
         * Logika Baru:
         * - Selalu turunkan kuantitas (jika > 1)
         * - Setelah turun, SELALU enable tombol + (pasti ada sisa saldo)
         */
        function decreaseQty() {
            if (!quantityInput) {
                console.error('❌ Quantity input not found');
                return;
            }
            
            const currentValue = parseInt(quantityInput.value) || 1;
            
            // Cek apakah masih bisa dikurangi (tidak kurang dari 1)
            if (currentValue > 1) {
                const nextQuantity = currentValue - 1;
                quantityInput.value = nextQuantity;
                
                // Visual feedback
                if (btnDecrease) {
                    btnDecrease.classList.add('scale-95');
                    setTimeout(() => btnDecrease.classList.remove('scale-95'), 100);
                }
                
                console.log('✅ Quantity decreased to:', nextQuantity);
                
                // TUGAS 1.3: Update subtotal dan check balance
                updateSubtotalAndCheckBalance();
                
                // TUGAS 1.3: Setelah turun, SELALU enable tombol + (pasti ada sisa saldo)
                enablePlusButton();
            } else {
                console.warn('⚠️ Cannot decrease: Minimum quantity is 1');
            }
        }

        /**
         * Validasi dan update qty jika user edit manual
         */
        function validateAndUpdateQty() {
            if (!quantityInput) return;
            
            let value = parseInt(quantityInput.value) || 1;
            
            if (value < 1) value = 1;
            if (value > maxStock) {
                value = maxStock;
                showStockAlert();
            }
            
            quantityInput.value = value;
            updateSubtotal();
        }

        /**
         * Validasi dan update qty jika user edit manual input
         */
        function validateAndUpdateQty() {
            if (!quantityInput) return;
            
            let value = parseInt(quantityInput.value) || 1;
            
            // Batasi nilai min = 1, max = stock
            if (value < 1) value = 1;
            if (value > itemStock) {
                value = itemStock;
                showStockAlert();
            }
            
            quantityInput.value = value;
            updateSubtotal();
        }

        /**
         * Alert jika qty melebihi stock
         */
        function showStockAlert() {
            const alertDiv = document.createElement('div');
            alertDiv.className = 'fixed top-20 right-4 bg-orange-500 text-white px-6 py-3 rounded-xl shadow-lg z-50 animate-bounce';
            alertDiv.innerHTML = `
                <div class="flex items-center gap-2">
                    <i class="bi bi-exclamation-triangle text-xl"></i>
                    <span class="font-semibold">Stok maksimal ${itemStock} item!</span>
                </div>
            `;
            document.body.appendChild(alertDiv);
            
            setTimeout(() => {
                alertDiv.style.transition = 'opacity 0.3s';
                alertDiv.style.opacity = '0';
                setTimeout(() => alertDiv.remove(), 300);
            }, 2000);
        }

        // ============================================================
        // INITIALIZATION - DOMContentLoaded
        // ============================================================
        document.addEventListener('DOMContentLoaded', function() {
            console.log('🚀 Initializing Quantity & Subtotal Calculator...');
            
            // STEP 1: Ambil semua elemen DOM
            quantityInput = document.getElementById('quantity');
            subtotalDisplay = document.getElementById('subtotal');
            qtyDisplay = document.getElementById('qty-display');
            priceDisplay = document.getElementById('price-display');
            btnIncrease = document.getElementById('btnIncrease');
            btnDecrease = document.getElementById('btnDecrease');
            quantityContainer = document.querySelector('.quantity-container');
            
            // TUGAS 1: Ambil elemen untuk balance check
            balanceStatusBadge = document.getElementById('balance-status-badge');
            balanceStatusText = document.getElementById('balance-status-text');
            btnAddToCart = document.getElementById('btnAddToCart');
            btnInstantRedeem = document.getElementById('btnInstantRedeem');

            // STEP 2: Validasi elemen wajib ada
            if (!quantityInput) {
                console.error('❌ FATAL: Quantity input (#quantity) not found!');
                return;
            }
            if (!subtotalDisplay) {
                console.error('❌ FATAL: Subtotal display (#subtotal) not found!');
                return;
            }

            // STEP 3: TUGAS 2.1 - Ambil data dari data attributes
            if (quantityContainer) {
                itemPrice = parseInt(quantityContainer.getAttribute('data-item-price')) || 0;
                itemStock = parseInt(quantityContainer.getAttribute('data-item-stock')) || 0;
                
                console.log('📦 Item Data from attributes:', {
                    price: itemPrice,
                    stock: itemStock
                });
            }

            // TUGAS 1: Ambil saldo user dari data-attribute
            const balanceCard = document.querySelector('[data-user-balance]');
            if (balanceCard) {
                userBalance = parseInt(balanceCard.getAttribute('data-user-balance')) || 0;
                console.log('💰 User Balance:', userBalance);
            } else {
                console.warn('⚠️ User balance data not found!');
            }

            // Fallback: Ambil dari hidden input (jika data-attributes gagal)
            if (itemPrice === 0) {
                const rawPrice = document.getElementById('raw-item-price');
                if (rawPrice) itemPrice = parseInt(rawPrice.value) || 0;
            }
            if (itemStock === 0) {
                const rawStock = document.getElementById('raw-item-stock');
                if (rawStock) itemStock = parseInt(rawStock.value) || 0;
            }

            // Validasi data valid
            if (itemPrice === 0 || itemStock === 0) {
                console.error('❌ FATAL: Invalid item data!', { itemPrice, itemStock });
                return;
            }
            if (userBalance === 0) {
                console.error('❌ FATAL: User balance is 0!');
            }

            console.log('✅ All elements found:', {
                quantityInput: !!quantityInput,
                subtotalDisplay: !!subtotalDisplay,
                qtyDisplay: !!qtyDisplay,
                priceDisplay: !!priceDisplay,
                btnIncrease: !!btnIncrease,
                btnDecrease: !!btnDecrease
            });

            console.log('💰 Item Data:', {
                name: itemName,
                price: itemPrice,
                stock: itemStock
            });

            // STEP 4: TUGAS 2.1 - Event Listeners untuk tombol +/-
            if (btnIncrease) {
                btnIncrease.addEventListener('click', increaseQty);
                console.log('✅ Button (+) listener attached');
            } else {
                console.warn('⚠️ Button increase (#btnIncrease) not found');
            }
            
            if (btnDecrease) {
                btnDecrease.addEventListener('click', decreaseQty);
                console.log('✅ Button (-) listener attached');
            } else {
                console.warn('⚠️ Button decrease (#btnDecrease) not found');
            }

            // STEP 5: Event listener untuk manual input
            quantityInput.addEventListener('input', validateAndUpdateQty);
            console.log('✅ Manual input validation attached');

            // STEP 6: TUGAS 2.2 - Initial calculation saat form dimuat
            console.log('🔄 Running initial subtotal calculation...');
            updateSubtotal();
            
            console.log('✅ Calculator initialized successfully! Ready to use.');
        });

        // ============================================================
        // INSTANT REDEEM (SKIP CART)
        // ============================================================
        
        /**
         * Tukar langsung tanpa melalui keranjang
         * Langsung create Redemption dengan quantity yang dipilih
         */
        async function instantRedeem() {
            // Validasi elemen ada
            if (!quantityInput) {
                alert('Error: Form tidak ditemukan!');
                return;
            }

            // Validasi quantity
            const qty = parseInt(quantityInput.value) || 1;
            const totalPoints = qty * itemPrice; // Gunakan itemPrice, bukan pointsPerItem
            const userBalance = {{ $user->balance_points }};

            console.log('🔥 Instant Redeem triggered:', {
                quantity: qty,
                itemPrice: itemPrice,
                totalPoints: totalPoints,
                userBalance: userBalance
            });

            // Get button
            const btn = document.getElementById('btnInstantRedeem');
            if (!btn) {
                alert('Error: Button tidak ditemukan!');
                return;
            }

            const originalHTML = btn.innerHTML;
            
            // Disable button untuk prevent double click
            btn.disabled = true;
            btn.innerHTML = '<i class="bi bi-hourglass-split mr-2 animate-spin"></i>Memproses...';

            // Validasi saldo
            if (userBalance < totalPoints) {
                Swal.fire({
                    icon: 'error',
                    title: 'Saldo Tidak Cukup',
                    html: `Anda membutuhkan <strong>${totalPoints.toLocaleString('id-ID')}</strong> poin,<br>tetapi saldo Anda hanya <strong>${userBalance.toLocaleString('id-ID')}</strong> poin.`,
                    confirmButtonText: 'Tutup',
                    confirmButtonColor: '#d33'
                });
                btn.disabled = false;
                btn.innerHTML = originalHTML;
                return;
            }

            // TUGAS 1: KONFIRMASI DENGAN SWEETALERT2
            const result = await Swal.fire({
                title: '🔥 Konfirmasi Penukaran',
                html: `
                    <div class="text-left space-y-2">
                        <p><strong>Item:</strong> {{ $rewardItem->name }}</p>
                        <p><strong>Quantity:</strong> ${qty} item</p>
                        <p><strong>Total Poin:</strong> <span class="text-blue-600 font-bold">${totalPoints.toLocaleString('id-ID')}</span> poin</p>
                        <hr class="my-3">
                        <p class="text-sm text-gray-600">Poin akan langsung terpotong dan menunggu approval admin.</p>
                    </div>
                `,
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Ya, Tukar Sekarang!',
                cancelButtonText: 'Batal',
                reverseButtons: true
            });

            if (!result.isConfirmed) {
                console.log('❌ User cancelled instant redeem');
                btn.disabled = false;
                btn.innerHTML = originalHTML;
                return;
            }

            try {
                // Get CSRF token
                const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

                // Send request
                const response = await fetch('{{ route("tukar.instant", $rewardItem->id) }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': csrfToken,
                        'Accept': 'application/json'
                    },
                    body: JSON.stringify({
                        quantity: qty,
                        reward_item_id: {{ $rewardItem->id }},
                        branch_id: {{ $rewardItem->branch_id ?? 'null' }}
                    })
                });

                const data = await response.json();

                if (response.ok) {
                    // TUGAS 1: SUCCESS ALERT DENGAN SWEETALERT2
                    await Swal.fire({
                        icon: 'success',
                        title: 'Penukaran Berhasil!',
                        html: `
                            <p>${data.message || 'Penukaran Anda sedang diproses.'}</p>
                            <p class="text-sm text-gray-600 mt-2">Redirect ke riwayat transaksi...</p>
                        `,
                        timer: 2000,
                        timerProgressBar: true,
                        showConfirmButton: false
                    });
                    
                    // Redirect ke riwayat tukar
                    window.location.href = '{{ route("riwayat-tukar") }}';
                } else {
                    // Error dari server
                    throw new Error(data.message || 'Terjadi kesalahan saat proses penukaran');
                }
            } catch (error) {
                console.error('Instant redeem error:', error);
                
                // TUGAS 1: ERROR ALERT DENGAN SWEETALERT2
                Swal.fire({
                    icon: 'error',
                    title: 'Penukaran Gagal',
                    text: error.message || 'Terjadi kesalahan. Silakan coba lagi.',
                    confirmButtonText: 'Tutup',
                    confirmButtonColor: '#d33'
                });
                
                btn.disabled = false;
                btn.innerHTML = originalHTML;
            }
        }

        /**
         * Show alert notification
         */
        function showAlert(type, message) {
            const colors = {
                success: 'from-green-500 to-emerald-600',
                error: 'from-red-500 to-red-600',
                warning: 'from-orange-500 to-orange-600'
            };

            const icons = {
                success: 'bi-check-circle',
                error: 'bi-exclamation-circle',
                warning: 'bi-exclamation-triangle'
            };

            const alertDiv = document.createElement('div');
            alertDiv.className = `fixed top-20 right-4 bg-gradient-to-r ${colors[type]} text-white px-6 py-4 rounded-2xl shadow-2xl z-50 max-w-md`;
            alertDiv.innerHTML = `
                <div class="flex items-center gap-3">
                    <i class="bi ${icons[type]} text-2xl"></i>
                    <span class="font-semibold">${message}</span>
                </div>
            `;
            document.body.appendChild(alertDiv);

            // Auto remove after 4 seconds
            setTimeout(() => {
                alertDiv.style.transition = 'opacity 0.5s';
                alertDiv.style.opacity = '0';
                setTimeout(() => alertDiv.remove(), 500);
            }, 4000);
        }

        // Auto-hide alerts after 3 seconds
        setTimeout(() => {
            const alerts = document.querySelectorAll('[class*="from-green-500"], [class*="from-red-500"]');
            alerts.forEach(alert => {
                if (alert.classList.contains('mb-6')) {
                    alert.style.transition = 'opacity 0.5s';
                    alert.style.opacity = '0';
                    setTimeout(() => alert.remove(), 500);
                }
            });
        }, 3000);
    </script>

</body>
</html>
