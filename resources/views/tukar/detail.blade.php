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
                    },
                    keyframes: {
                        'spin-slow': {
                            '0%': { transform: 'rotate(0deg)' },
                            '100%': { transform: 'rotate(360deg)' }
                        },
                        'pulse-ring': {
                            '0%, 100%': { boxShadow: '0 0 0 0 rgba(34, 197, 94, 0.7)' },
                            '50%': { boxShadow: '0 0 0 15px rgba(34, 197, 94, 0)' }
                        }
                    },
                    animation: {
                        'spin-slow': 'spin-slow 1s linear infinite',
                        'pulse-ring': 'pulse-ring 2s infinite'
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
                            <span id="balance-status-text">Saldo Cukup</span>
                        </span>
                    </div>
                </div>

                <!-- Add to Cart Form -->
                <form id="cartForm" action="{{ route('cart.add', $rewardItem->id) }}" method="POST" class="bg-white rounded-2xl shadow-lg p-6 space-y-6">
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
                        
                        <!-- Input Quantity - Text Input untuk manual entry -->
                        <div class="flex items-center justify-center gap-3">
                            <!-- Minus Button -->
                            <button type="button"
                                id="btnMinus"
                                onclick="decrementQuantity()"
                                class="w-12 h-12 bg-red-100 hover:bg-red-200 text-red-600 font-bold rounded-lg transition-all text-xl flex items-center justify-center">
                                −
                            </button>

                            <!-- Input Field -->
                            <input type="text" 
                                name="quantity" 
                                id="quantity" 
                                value="1" 
                                data-price="{{ $rewardItem->points_cost }}"
                                data-max="{{ $rewardItem->stock }}"
                                class="w-24 px-4 py-3 text-center text-2xl font-bold border-2 border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500 bg-white transition-all hover:border-green-500"
                                inputmode="numeric"
                                pattern="[0-9]*"
                                placeholder="1"
                                onfocus="this.select()">

                            <!-- Plus Button -->
                            <button type="button"
                                id="btnPlus"
                                onclick="incrementQuantity()"
                                class="w-12 h-12 bg-green-100 hover:bg-green-200 text-green-600 font-bold rounded-lg transition-all text-xl flex items-center justify-center">
                                +
                            </button>
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
                        @if($rewardItem->stock > 0)
                            <!-- Masukkan Keranjang Button -->
                            <button type="button"
                                id="btnAddToCart"
                                onclick="showConfirmModal()"
                                class="w-full py-4 bg-gradient-to-r from-green-500 to-green-600 hover:from-green-600 hover:to-green-700 text-white font-bold rounded-xl transition-all shadow-lg hover:shadow-xl disabled:opacity-50 disabled:cursor-not-allowed">
                                <i class="bi bi-cart-plus mr-2"></i>
                                Masukkan Keranjang
                            </button>

                            <!-- Tukar Langsung Button -->
                            <button type="button" 
                                id="btnInstantRedeem"
                                onclick="instantRedeem()"
                                class="w-full py-4 bg-gradient-to-r from-blue-500 to-blue-600 hover:from-blue-600 hover:to-blue-700 text-white font-bold rounded-xl transition-all shadow-lg hover:shadow-xl disabled:opacity-50 disabled:cursor-not-allowed">
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

    <!-- Modal Konfirmasi Tambah ke Keranjang -->
    <div id="confirmModal" class="hidden fixed inset-0 bg-black bg-opacity-50 z-50 flex items-center justify-center p-4">
        <div class="bg-white rounded-2xl max-w-md w-full shadow-2xl transform transition-all">
            <div class="p-6">
                <!-- Icon & Title -->
                <div class="text-center mb-6">
                    <div class="w-16 h-16 bg-green-100 rounded-full flex items-center justify-center mx-auto mb-4">
                        <i class="bi bi-cart-check text-green-600 text-3xl"></i>
                    </div>
                    <h3 class="text-2xl font-bold text-gray-800 mb-2">Konfirmasi Penukaran</h3>
                    <p class="text-gray-600">Apakah Anda yakin ingin menambahkan barang ini ke keranjang?</p>
                </div>

                <!-- Product Info -->
                <div class="bg-gray-50 rounded-xl p-4 mb-6">
                    <div class="flex items-center gap-4 mb-3">
                        <div class="w-16 h-16 bg-white rounded-lg flex items-center justify-center flex-shrink-0">
                            @if($rewardItem->image)
                                <img src="{{ asset('images/' . $rewardItem->image) }}" alt="{{ $rewardItem->name }}" class="w-12 h-12 object-contain">
                            @else
                                <i class="bi bi-gift text-gray-400 text-2xl"></i>
                            @endif
                        </div>
                        <div class="flex-1">
                            <h4 class="font-bold text-gray-800 text-sm">{{ $rewardItem->name }}</h4>
                            <p class="text-xs text-gray-500">{{ $rewardItem->description ?? 'Produk berkualitas' }}</p>
                        </div>
                    </div>
                    
                    <div class="border-t border-gray-200 pt-3 space-y-2">
                        <div class="flex justify-between text-sm">
                            <span class="text-gray-600">Jumlah:</span>
                            <span class="font-semibold text-gray-800" id="modal-quantity">1 item</span>
                        </div>
                        <div class="flex justify-between text-sm">
                            <span class="text-gray-600">Harga Satuan:</span>
                            <span class="font-semibold text-green-600">
                                <i class="bi bi-coin text-xs"></i>
                                <span id="modal-price">{{ number_format($rewardItem->points_cost, 0, ',', '.') }}</span> poin
                            </span>
                        </div>
                        <div class="flex justify-between items-center pt-2 border-t border-gray-200">
                            <span class="font-semibold text-gray-700">Total:</span>
                            <span class="text-xl font-bold text-green-600">
                                <i class="bi bi-coin"></i>
                                <span id="modal-total">{{ number_format($rewardItem->points_cost, 0, ',', '.') }}</span> poin
                            </span>
                        </div>
                    </div>
                </div>

                <!-- Buttons -->
                <div class="flex gap-3">
                    <button type="button" 
                        onclick="closeConfirmModal()"
                        class="flex-1 bg-gray-100 hover:bg-gray-200 text-gray-700 font-semibold py-3 rounded-xl transition-all">
                        <i class="bi bi-x-circle mr-2"></i>
                        Batal
                    </button>
                    <button type="button" 
                        onclick="confirmAddToCart()"
                        class="flex-1 bg-gradient-to-r from-green-500 to-green-600 hover:from-green-600 hover:to-green-700 text-white font-semibold py-3 rounded-xl transition-all shadow-md">
                        <i class="bi bi-check-circle mr-2"></i>
                        Lanjut
                    </button>
                </div>
            </div>
        </div>
    </div>

    <script>
        // ============================================================
        // MODAL KONFIRMASI FUNCTIONS
        // ============================================================
        
        /**
         * Show confirmation modal before adding to cart
         */
        function showConfirmModal() {
            // Update modal with current quantity and total
            const quantity = parseInt(document.getElementById('quantity').value) || 1;
            const price = itemPrice;
            const total = quantity * price;
            
            // Update modal content
            document.getElementById('modal-quantity').textContent = quantity + ' item';
            document.getElementById('modal-total').textContent = total.toLocaleString('id-ID');
            
            // Show modal
            const modal = document.getElementById('confirmModal');
            modal.classList.remove('hidden');
            modal.classList.add('flex');
        }
        
        /**
         * Close confirmation modal
         */
        function closeConfirmModal() {
            const modal = document.getElementById('confirmModal');
            modal.classList.add('hidden');
            modal.classList.remove('flex');
        }
        
        /**
         * Confirm and submit the form to add to cart
         */
        function confirmAddToCart() {
            // Close modal
            closeConfirmModal();
            
            // Show loading state
            const btnAddToCart = document.getElementById('btnAddToCart');
            const btnInstantRedeem = document.getElementById('btnInstantRedeem');
            const originalText = btnAddToCart.innerHTML;
            
            btnAddToCart.disabled = true;
            btnInstantRedeem.disabled = true;
            
            // Update button with loading spinner
            btnAddToCart.innerHTML = `
                <span class="inline-flex items-center gap-2">
                    <i class="bi bi-hourglass-split animate-spin-slow"></i>
                    Memproses...
                </span>
            `;
            
            // Submit form to add to cart (no additional confirmation)
            setTimeout(() => {
                document.getElementById('cartForm').submit();
            }, 300);
        }
        
        /**
         * Close modal when clicking outside
         */
        document.addEventListener('click', function(event) {
            const modal = document.getElementById('confirmModal');
            if (event.target === modal) {
                closeConfirmModal();
            }
        });
        
        /**
         * Close modal with ESC key
         */
        document.addEventListener('keydown', function(event) {
            if (event.key === 'Escape') {
                closeConfirmModal();
            }
        });

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
                
                // TUGAS 2.2: Enable semua tombol aksi
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
         * Fungsi untuk menambah kuantitas (tombol +)
         */
        function incrementQuantity() {
            if (!quantityInput) return;
            
            let value = parseInt(quantityInput.value) || 1;
            value++;
            
            if (value > itemStock) {
                value = itemStock;
                showStockAlert();
                return;
            }
            
            quantityInput.value = value;
            validateAndUpdateQty();
        }

        /**
         * Fungsi untuk mengurangi kuantitas (tombol -)
         */
        function decrementQuantity() {
            if (!quantityInput) return;
            
            let value = parseInt(quantityInput.value) || 1;
            value--;
            
            if (value < 1) value = 1;
            
            quantityInput.value = value;
            validateAndUpdateQty();
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
                priceDisplay: !!priceDisplay
            });

            console.log('💰 Item Data:', {
                name: itemName,
                price: itemPrice,
                stock: itemStock
            });

            // STEP 4: Event listener untuk text input (filter hanya angka + validasi)
            quantityInput.addEventListener('input', function(e) {
                // Ambil value dan hapus karakter non-angka
                let value = e.target.value.replace(/[^0-9]/g, '');
                
                // Update input dengan value yang sudah difilter
                e.target.value = value;
                
                // Jika kosong, jangan langsung set ke 1 (biarkan user ketik)
                if (value === '') {
                    return;
                }
                
                // Validasi dan update
                validateAndUpdateQty();
            });
            console.log('✅ Text input validation attached');
            
            // STEP 5: Event listener untuk blur (saat user keluar dari input field)
            quantityInput.addEventListener('blur', function(e) {
                // Jika kosong saat blur, set ke 1
                if (e.target.value === '') {
                    e.target.value = '1';
                    updateSubtotal();
                } else {
                    validateAndUpdateQty();
                }
            });
            console.log('✅ Blur event listener attached');

            // STEP 6: Initial calculation saat form dimuat
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
            btn.innerHTML = '<i class="bi bi-hourglass-split mr-2 animate-spin-slow"></i>Memproses...';

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
                title: 'Konfirmasi Penukaran',
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

            // Show loading overlay
            showInstantRedeemLoading();
            btn.innerHTML = '<i class="bi bi-hourglass-split mr-2 animate-spin-slow"></i>Memproses...';

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
                
                // Remove loading overlay
                const overlay = document.getElementById('instantRedeemLoadingOverlay');
                if (overlay) overlay.remove();
                
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
         * Show instant redeem loading overlay
         */
        function showInstantRedeemLoading() {
            const overlay = document.createElement('div');
            overlay.id = 'instantRedeemLoadingOverlay';
            overlay.className = 'fixed inset-0 bg-black bg-opacity-40 z-[100] flex items-center justify-center p-4';
            overlay.innerHTML = `
                <div class="bg-white rounded-2xl shadow-2xl p-8 text-center max-w-sm mx-auto">
                    <div class="mb-6 flex justify-center">
                        <div class="relative w-24 h-24">
                            <div class="absolute inset-0 bg-gradient-to-r from-green-400 to-emerald-500 rounded-full opacity-20 animate-pulse-ring"></div>
                            <div class="absolute inset-2 bg-white rounded-full flex items-center justify-center">
                                <i class="bi bi-hourglass-split text-4xl text-green-600 animate-spin-slow"></i>
                            </div>
                        </div>
                    </div>
                    <h3 class="text-xl font-bold text-gray-800 mb-2">Memproses Penukaran</h3>
                    <p class="text-gray-600 text-sm mb-4">Mohon tunggu sebentar...</p>
                    <div class="flex justify-center gap-1">
                        <div class="w-2 h-2 bg-green-500 rounded-full animate-bounce" style="animation-delay: 0s;"></div>
                        <div class="w-2 h-2 bg-green-500 rounded-full animate-bounce" style="animation-delay: 0.2s;"></div>
                        <div class="w-2 h-2 bg-green-500 rounded-full animate-bounce" style="animation-delay: 0.4s;"></div>
                    </div>
                </div>
            `;
            document.body.appendChild(overlay);
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

        // Auto checkout disabled - user manually clicks button to checkout
    </script>

</body>
</html>
