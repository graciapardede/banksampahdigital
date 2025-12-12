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
                        <div class="bg-white rounded-2xl shadow-md p-6 hover:shadow-lg transition-all cart-item" data-item-id="{{ $item['id'] }}" data-item-name="{{ $item['name'] }}" data-points="{{ $item['points_required'] * $item['quantity'] }}">
                            <div class="flex gap-4">
                                <!-- Checkbox -->
                                <div class="flex items-start pt-2" onclick="event.stopPropagation()">
                                    <input type="checkbox" 
                                        class="cart-checkbox w-5 h-5 text-green-600 border-2 border-gray-300 rounded focus:ring-green-500 cursor-pointer" 
                                        data-item-id="{{ $item['id'] }}"
                                        data-points="{{ $item['points_required'] * $item['quantity'] }}"
                                        data-quantity="{{ $item['quantity'] }}"
                                        onchange="updateCheckoutSummary()"
                                        checked>
                                </div>
                                
                                <!-- Image -->
                                <div class="w-24 h-24 bg-gradient-to-br from-green-50 to-emerald-50 rounded-xl flex items-center justify-center flex-shrink-0 cursor-pointer" onclick="window.location.href='{{ route('tukar.detail', $item['id']) }}'">
                                    @if($item['image'])
                                        <img src="{{ asset('images/' . $item['image']) }}" alt="{{ $item['name'] }}" class="w-20 h-20 object-contain">
                                    @else
                                        <i class="bi bi-gift text-gray-300 text-4xl"></i>
                                    @endif
                                </div>

                                <!-- Info -->
                                <div class="flex-1">
                                    <h3 class="font-bold text-lg text-gray-800 mb-1 cursor-pointer hover:text-green-600 transition-colors" onclick="window.location.href='{{ route('tukar.detail', $item['id']) }}'">{{ $item['name'] }}</h3>
                                    <div class="flex items-center gap-2 text-green-600 font-semibold mb-3">
                                        <i class="bi bi-coin"></i>
                                        <span>{{ number_format($item['points_required'], 0, ',', '.') }} poin/item</span>
                                    </div>

                                    <!-- Quantity Controls -->
                                    <div class="flex items-center gap-4" onclick="event.stopPropagation()">
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
                                <div class="flex flex-col items-end justify-between" onclick="event.stopPropagation()">
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

                    <!-- Select All & Clear Cart -->
                    <div class="flex items-center justify-between pt-4 border-t">
                        <label class="flex items-center gap-2 cursor-pointer">
                            <input type="checkbox" id="selectAll" class="w-4 h-4 text-green-600 border-2 border-gray-300 rounded focus:ring-green-500" onchange="toggleSelectAll()" checked>
                            <span class="text-gray-700 font-semibold">Pilih Semua</span>
                        </label>
                        
                        <form action="{{ route('cart.clear') }}" method="POST" class="inline">
                            @csrf
                            <button type="submit" 
                                onclick="return confirm('Yakin ingin mengosongkan keranjang?')"
                                class="text-red-600 hover:text-red-700 font-semibold flex items-center gap-2">
                                <i class="bi bi-trash"></i>
                            Kosongkan Keranjang
                        </button>
                    </form>
                    </div>
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
                                <span>Item Dipilih</span>
                                <span class="font-semibold" id="selectedItemCount">{{ count($cart) }} item</span>
                            </div>
                            <div class="flex justify-between text-gray-600">
                                <span>Total Quantity</span>
                                <span class="font-semibold" id="selectedQuantity">{{ array_sum(array_column($cart, 'quantity')) }} pcs</span>
                            </div>
                            <div class="pt-3 border-t-2 border-gray-200">
                                <div class="flex justify-between items-center">
                                    <span class="text-gray-700 font-semibold">Total Poin</span>
                                    <div class="text-right">
                                        <p class="text-3xl font-bold text-green-600" id="selectedTotalPoints">{{ number_format($totalPoints, 0, ',', '.') }}</p>
                                        <p class="text-xs text-gray-500">poin</p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Balance Check -->
                        <div id="balanceCheck">
                        @if($user->balance_points < $totalPoints)
                            <div class="bg-red-50 border-2 border-red-200 rounded-xl p-4">
                                <div class="flex items-center gap-2 text-red-700 mb-2">
                                    <i class="bi bi-exclamation-triangle text-xl"></i>
                                    <span class="font-bold">Saldo Tidak Cukup</span>
                                </div>
                                <p class="text-sm text-red-600" id="balanceShortage">
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
                        </div>

                        <!-- Checkout Form -->
                        <form id="checkoutForm" action="{{ route('cart.checkout') }}" method="POST" class="space-y-4">
                            @csrf
                            
                            <!-- Hidden input for selected items -->
                            <input type="hidden" name="selected_items" id="selectedItems" value="">
                            
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-2">Catatan (Opsional)</label>
                                <textarea id="checkoutNotes" name="notes" rows="3" 
                                    class="w-full border-2 border-gray-200 rounded-xl p-3 text-sm focus:border-green-500 focus:outline-none"
                                    placeholder="Tulis catatan jika ada..."></textarea>
                            </div>

                            <button type="button" 
                                id="checkoutButton"
                                onclick="showCheckoutModal()"
                                class="w-full bg-gradient-to-r from-green-500 to-green-600 hover:from-green-600 hover:to-green-700 text-white font-bold py-4 rounded-xl shadow-lg hover:shadow-xl transition-all">
                                <i class="bi bi-cart-check mr-2"></i>
                                Checkout Sekarang
                            </button>
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

    <!-- Modal Konfirmasi Checkout -->
    <div id="checkoutModal" class="hidden fixed inset-0 bg-black bg-opacity-50 z-50 flex items-center justify-center p-4">
        <div class="bg-white rounded-2xl max-w-lg w-full shadow-2xl transform transition-all">
            <div class="p-6">
                <!-- Icon & Title -->
                <div class="text-center mb-6">
                    <div class="w-20 h-20 bg-gradient-to-br from-green-100 to-emerald-100 rounded-full flex items-center justify-center mx-auto mb-4">
                        <i class="bi bi-cart-check-fill text-green-600 text-4xl"></i>
                    </div>
                    <h3 class="text-2xl font-bold text-gray-800 mb-2">Konfirmasi Checkout</h3>
                    <p class="text-gray-600">Pastikan data penukaran Anda sudah benar</p>
                </div>

                <!-- Summary Info -->
                <div class="bg-gradient-to-br from-gray-50 to-gray-100 rounded-xl p-5 mb-6 space-y-4">
                    <!-- Items (Generated by JavaScript) -->
                    <div class="border-b border-gray-300 pb-3">
                        <h4 class="text-sm font-semibold text-gray-700 mb-3">
                            Barang yang Ditukar
                        </h4>
                        <div id="modalItemsList" class="space-y-2 max-h-40 overflow-y-auto">
                            <!-- Items will be populated by JavaScript in showCheckoutModal() -->
                        </div>
                    </div>

                    <!-- Point Summary -->
                    <div class="space-y-2">
                        <div class="flex justify-between items-center text-sm">
                            <span class="text-gray-600">Saldo Saat Ini:</span>
                            <span class="font-semibold text-blue-600">
                                <i class="bi bi-wallet2 text-xs"></i>
                                {{ number_format($user->balance_points, 0, ',', '.') }} poin
                            </span>
                        </div>
                        <div class="flex justify-between items-center text-sm">
                            <span class="text-gray-600">Total Penukaran:</span>
                            <span id="modalTotalPoints" class="font-semibold text-red-600">
                                <i class="bi bi-dash-circle text-xs"></i>
                                0 poin
                            </span>
                        </div>
                        <div class="pt-3 border-t-2 border-gray-300">
                            <div class="flex justify-between items-center">
                                <span class="font-bold text-gray-800">Sisa Saldo:</span>
                                <span id="modalRemainingBalance" class="text-xl font-bold text-green-600">
                                    <i class="bi bi-coin"></i>
                                    {{ number_format($user->balance_points, 0, ',', '.') }} poin
                                </span>
                            </div>
                        </div>
                    </div>

                    <!-- Notes Preview -->
                    <div id="modalNotesPreview" class="hidden pt-3 border-t border-gray-300">
                        <p class="text-xs text-gray-600 mb-1">Catatan:</p>
                        <p id="modalNotesText" class="text-sm text-gray-800 italic bg-white rounded-lg p-2"></p>
                    </div>
                </div>

                <!-- Warning -->
                <div class="bg-yellow-50 border-2 border-yellow-200 rounded-xl p-4 mb-6">
                    <div class="flex items-start gap-3">
                        <i class="bi bi-exclamation-triangle-fill text-yellow-600 text-xl flex-shrink-0 mt-0.5"></i>
                        <div class="text-sm text-yellow-800">
                            <p class="font-bold mb-1">Perhatian!</p>
                            <ul class="space-y-1 text-xs">
                                <li>• Poin akan langsung terpotong setelah checkout</li>
                                <li>• Penukaran akan diproses oleh admin</li>
                                <li>• Anda dapat mengambil barang setelah disetujui</li>
                                <li>• Pastikan data sudah benar sebelum melanjutkan</li>
                            </ul>
                        </div>
                    </div>
                </div>

                <!-- Buttons -->
                <div class="flex gap-3">
                    <button type="button" 
                        onclick="closeCheckoutModal()"
                        class="flex-1 bg-gray-100 hover:bg-gray-200 text-gray-700 font-semibold py-3.5 rounded-xl transition-all flex items-center justify-center gap-2">
                        <i class="bi bi-x-circle"></i>
                        Batal
                    </button>
                    <button type="button" 
                        onclick="confirmCheckout()"
                        class="flex-1 bg-gradient-to-r from-green-500 to-green-600 hover:from-green-600 hover:to-green-700 text-white font-semibold py-3.5 rounded-xl transition-all shadow-md flex items-center justify-center gap-2">
                        <i class="bi bi-check-circle-fill"></i>
                        Ya, Lanjutkan
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Footer -->
    <footer class="bg-white py-6 mt-12 border-t">
        <div class="max-w-6xl mx-auto px-4 text-center">
            <p class="text-sm text-gray-600">© 2025 Green Saving. Sistem Bank Sampah Digital</p>
        </div>
    </footer>

    <script>
        /**
         * Show checkout confirmation modal
         */
        function showCheckoutModal() {
            const checkboxes = document.querySelectorAll('.cart-checkbox:checked');
            const userBalance = {{ $user->balance_points }};
            let totalPoints = 0;
            let itemsHTML = '';

            // Generate items list dari selected checkboxes
            checkboxes.forEach(checkbox => {
                const cartItem = checkbox.closest('.cart-item');
                const itemName = cartItem.querySelector('[data-item-name]')?.textContent || 'Item';
                const itemImage = cartItem.querySelector('img')?.src || null;
                const quantity = parseInt(checkbox.dataset.quantity);
                const points = parseInt(checkbox.dataset.points);
                const pointsPerItem = points / quantity; // Calculate points per item

                totalPoints += points;

                // Create item HTML
                const itemHTML = `
                    <div class="flex items-center justify-between text-sm bg-white rounded-lg p-2">
                        <div class="flex items-center gap-2">
                            <div class="w-10 h-10 bg-green-50 rounded-lg flex items-center justify-center flex-shrink-0">
                                ${itemImage ? `<img src="${itemImage}" alt="${itemName}" class="w-8 h-8 object-contain">` : '<i class="bi bi-gift text-green-600"></i>'}
                            </div>
                            <div>
                                <p class="font-semibold text-gray-800 text-xs">${itemName}</p>
                                <p class="text-xs text-gray-500">${quantity} × ${pointsPerItem.toLocaleString('id-ID')} poin</p>
                            </div>
                        </div>
                        <span class="font-bold text-green-600 text-sm">
                            ${points.toLocaleString('id-ID')}
                        </span>
                    </div>
                `;

                itemsHTML += itemHTML;
            });

            // Update modal items list
            document.getElementById('modalItemsList').innerHTML = itemsHTML;

            // Update total points in modal
            document.getElementById('modalTotalPoints').innerHTML = `
                <i class="bi bi-dash-circle text-xs"></i>
                ${totalPoints.toLocaleString('id-ID')} poin
            `;

            // Update remaining balance
            const remainingBalance = userBalance - totalPoints;
            document.getElementById('modalRemainingBalance').innerHTML = `
                <i class="bi bi-coin"></i>
                ${remainingBalance.toLocaleString('id-ID')} poin
            `;

            // Get notes value
            const notes = document.getElementById('checkoutNotes').value.trim();
            
            // Show/hide notes preview
            if (notes) {
                document.getElementById('modalNotesPreview').classList.remove('hidden');
                document.getElementById('modalNotesText').textContent = notes;
            } else {
                document.getElementById('modalNotesPreview').classList.add('hidden');
            }
            
            // Show modal
            const modal = document.getElementById('checkoutModal');
            modal.classList.remove('hidden');
            modal.classList.add('flex');
        }
        
        /**
         * Close checkout modal
         */
        function closeCheckoutModal() {
            const modal = document.getElementById('checkoutModal');
            modal.classList.add('hidden');
            modal.classList.remove('flex');
        }
        
        /**
         * Confirm and submit checkout
         */
        function confirmCheckout() {
            // Close modal
            closeCheckoutModal();
            
            // Show loading state on modal
            const confirmBtn = event.target;
            const originalText = confirmBtn.innerHTML;
            
            // Disable both buttons
            const cancelBtn = confirmBtn.previousElementSibling;
            confirmBtn.disabled = true;
            cancelBtn.disabled = true;
            
            // Update button with loading spinner
            confirmBtn.innerHTML = `
                <i class="bi bi-hourglass-split animate-spin-slow"></i>
                Memproses...
            `;
            
            // Also disable checkout button
            document.getElementById('checkoutButton').disabled = true;
            
            // Show overlay loading
            showCheckoutLoading();
            
            // Submit form after a brief delay
            setTimeout(() => {
                document.getElementById('checkoutForm').submit();
            }, 500);
        }
        
        /**
         * Show checkout loading overlay
         */
        function showCheckoutLoading() {
            // Create loading overlay
            const overlay = document.createElement('div');
            overlay.id = 'checkoutLoadingOverlay';
            overlay.className = 'fixed inset-0 bg-black bg-opacity-40 z-[100] flex items-center justify-center';
            overlay.innerHTML = `
                <div class="bg-white rounded-2xl shadow-2xl p-8 text-center max-w-sm">
                    <div class="mb-6 flex justify-center">
                        <div class="relative w-24 h-24">
                            <div class="absolute inset-0 bg-gradient-to-r from-green-400 to-emerald-500 rounded-full opacity-20 animate-pulse-ring"></div>
                            <div class="absolute inset-2 bg-white rounded-full flex items-center justify-center">
                                <i class="bi bi-hourglass-split text-4xl text-green-600 animate-spin-slow"></i>
                            </div>
                        </div>
                    </div>
                    <h3 class="text-xl font-bold text-gray-800 mb-2">Memproses Checkout</h3>
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
         * Close modal when clicking outside
         */
        document.addEventListener('click', function(event) {
            const modal = document.getElementById('checkoutModal');
            if (event.target === modal) {
                closeCheckoutModal();
            }
        });
        
        /**
         * Close modal with ESC key
         */
        document.addEventListener('keydown', function(event) {
            if (event.key === 'Escape') {
                closeCheckoutModal();
            }
        });

        /**
         * Toggle select all checkboxes
         */
        function toggleSelectAll() {
            const selectAllCheckbox = document.getElementById('selectAll');
            const checkboxes = document.querySelectorAll('.cart-checkbox');
            
            checkboxes.forEach(checkbox => {
                checkbox.checked = selectAllCheckbox.checked;
            });
            
            updateCheckoutSummary();
        }

        /**
         * Update checkout summary based on selected items
         */
        function updateCheckoutSummary() {
            const checkboxes = document.querySelectorAll('.cart-checkbox:checked');
            const userBalance = {{ $user->balance_points }};
            
            let totalPoints = 0;
            let totalItems = 0;
            let totalQuantity = 0;
            let selectedIds = [];
            
            checkboxes.forEach(checkbox => {
                const points = parseInt(checkbox.dataset.points);
                const quantity = parseInt(checkbox.dataset.quantity);
                const itemId = checkbox.dataset.itemId;
                
                totalPoints += points;
                totalItems += 1;
                totalQuantity += quantity;
                selectedIds.push(itemId);
            });
            
            // Update display
            document.getElementById('selectedItemCount').textContent = totalItems + ' item';
            document.getElementById('selectedQuantity').textContent = totalQuantity + ' pcs';
            document.getElementById('selectedTotalPoints').textContent = totalPoints.toLocaleString('id-ID');
            
            // Update hidden input
            document.getElementById('selectedItems').value = JSON.stringify(selectedIds);
            
            // Update balance check
            const balanceCheckDiv = document.getElementById('balanceCheck');
            const checkoutButton = document.getElementById('checkoutButton');
            
            if (totalItems === 0) {
                balanceCheckDiv.innerHTML = `
                    <div class="bg-gray-50 border-2 border-gray-200 rounded-xl p-4">
                        <div class="flex items-center gap-2 text-gray-600">
                            <i class="bi bi-info-circle text-xl"></i>
                            <span class="font-bold">Pilih item untuk checkout</span>
                        </div>
                    </div>
                `;
                checkoutButton.disabled = true;
                checkoutButton.classList.add('opacity-50', 'cursor-not-allowed');
            } else if (userBalance < totalPoints) {
                balanceCheckDiv.innerHTML = `
                    <div class="bg-red-50 border-2 border-red-200 rounded-xl p-4">
                        <div class="flex items-center gap-2 text-red-700 mb-2">
                            <i class="bi bi-exclamation-triangle text-xl"></i>
                            <span class="font-bold">Saldo Tidak Cukup</span>
                        </div>
                        <p class="text-sm text-red-600">
                            Kurang ${(totalPoints - userBalance).toLocaleString('id-ID')} poin
                        </p>
                    </div>
                `;
                checkoutButton.disabled = true;
                checkoutButton.classList.add('opacity-50', 'cursor-not-allowed');
            } else {
                balanceCheckDiv.innerHTML = `
                    <div class="bg-green-50 border-2 border-green-200 rounded-xl p-4">
                        <div class="flex items-center gap-2 text-green-700">
                            <i class="bi bi-check-circle text-xl"></i>
                            <span class="font-bold">Saldo Mencukupi</span>
                        </div>
                    </div>
                `;
                checkoutButton.disabled = false;
                checkoutButton.classList.remove('opacity-50', 'cursor-not-allowed');
            }
            
            // Update select all checkbox state
            const allCheckboxes = document.querySelectorAll('.cart-checkbox');
            const selectAllCheckbox = document.getElementById('selectAll');
            selectAllCheckbox.checked = checkboxes.length === allCheckboxes.length;
        }

        // Initialize checkout summary when page loads
        document.addEventListener('DOMContentLoaded', function() {
            updateCheckoutSummary();
        });
    </script>

</body>
</html>
