<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Buat Setoran Baru - Green Saving Admin</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css" rel="stylesheet">
    
    <!-- Select2 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    
    <meta name="csrf-token" content="{{ csrf_token() }}">
    
    <style>
        /* Custom styling untuk Select2 agar match dengan Tailwind */
        .select2-container--default .select2-selection--single {
            height: 48px !important;
            border: 2px solid #e5e7eb !important;
            border-radius: 0.75rem !important;
            padding: 0.5rem 1rem !important;
            display: flex !important;
            align-items: center !important;
        }
        
        .select2-container--default .select2-selection--single .select2-selection__rendered {
            line-height: 32px !important;
            padding-left: 0 !important;
            color: #374151 !important;
        }
        
        .select2-container--default .select2-selection--single .select2-selection__arrow {
            height: 46px !important;
            right: 8px !important;
        }
        
        .select2-container--default.select2-container--focus .select2-selection--single {
            border-color: #10b981 !important;
            outline: none !important;
            box-shadow: 0 0 0 3px rgba(16, 185, 129, 0.1) !important;
        }
        
        .select2-dropdown {
            border: 2px solid #e5e7eb !important;
            border-radius: 0.75rem !important;
            margin-top: 4px !important;
        }
        
        .select2-results__option {
            padding: 10px 16px !important;
        }
        
        .select2-results__option--highlighted {
            background-color: #10b981 !important;
        }
        
        .select2-search--dropdown .select2-search__field {
            border: 2px solid #e5e7eb !important;
            border-radius: 0.5rem !important;
            padding: 8px 12px !important;
            margin: 8px !important;
            width: calc(100% - 16px) !important;
        }
        
        .select2-search--dropdown .select2-search__field:focus {
            border-color: #10b981 !important;
            outline: none !important;
        }
        
        /* Animation for total points */
        #totalPoinDisplay {
            transition: transform 0.2s ease-in-out;
        }
        
        .subtotal-poin {
            transition: all 0.3s ease-in-out;
        }
    </style>
</head>
<body class="min-h-screen bg-gradient-to-br from-green-50 to-green-100 font-poppins">

    <!-- Header -->
    @include('admin.partials.header')

    <!-- Main Content -->
    <main class="max-w-4xl mx-auto px-4 py-8">
        
        <!-- Back Button -->
        <a href="{{ route('admin.setoran.index') }}" class="inline-flex items-center space-x-2 text-green-600 hover:text-green-700 mb-6">
            <i class="bi bi-arrow-left"></i>
            <span>Kembali ke Daftar Setoran</span>
        </a>

        <!-- Form Card -->
        <div class="bg-white rounded-2xl shadow-lg p-8">
            <div class="flex items-center space-x-3 mb-6">
                <div class="w-12 h-12 bg-green-100 rounded-xl flex items-center justify-center">
                    <i class="bi bi-plus-circle text-green-600 text-2xl"></i>
                </div>
                <div>
                    <h2 class="text-2xl font-bold text-gray-800">Buat Setoran Baru</h2>
                    <p class="text-sm text-gray-500">Input setoran sampah untuk warga</p>
                </div>
            </div>

            @if(session('error'))
            <div class="bg-red-50 border-l-4 border-red-500 p-4 mb-6">
                <div class="flex items-center">
                    <i class="bi bi-exclamation-circle text-red-500 text-xl mr-3"></i>
                    <p class="text-red-700">{{ session('error') }}</p>
                </div>
            </div>
            @endif

            @if($errors->any())
            <div class="bg-red-50 border-l-4 border-red-500 p-4 mb-6">
                <div class="flex items-start">
                    <i class="bi bi-exclamation-circle text-red-500 text-xl mr-3 mt-1"></i>
                    <div>
                        <p class="font-semibold text-red-700 mb-2">Terdapat kesalahan:</p>
                        <ul class="list-disc list-inside text-red-600 text-sm space-y-1">
                            @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
            @endif

            <form action="{{ route('admin.setoran.store') }}" method="POST" id="depositForm">
                @csrf

                <!-- Pilih Warga -->
                <div class="mb-6">
                    <label class="block text-sm font-semibold text-gray-700 mb-2">
                        <i class="bi bi-person-circle mr-1"></i> Pilih Warga <span class="text-red-500">*</span>
                    </label>
                    <select name="user_id" id="user_id" required class="select2-warga w-full">
                        <option value="">-- Pilih Warga --</option>
                        @foreach($users as $user)
                        <option value="{{ $user->id }}" {{ old('user_id') == $user->id ? 'selected' : '' }}>
                            {{ $user->name }} - {{ $user->phone ?? 'No HP -' }}
                        </option>
                        @endforeach
                    </select>
                    <p class="text-xs text-gray-500 mt-1">
                        <i class="bi bi-info-circle"></i> Ketik nama atau nomor HP untuk mencari warga
                    </p>
                </div>

                <!-- Info Cabang (Auto dari Admin) -->
                <div class="mb-6">
                    <label class="block text-sm font-semibold text-gray-700 mb-2">
                        <i class="bi bi-building mr-1"></i> Lokasi Cabang
                    </label>
                    @php
                        $adminBranch = Auth::user()->branch_id ? \App\Models\Branch::find(Auth::user()->branch_id) : null;
                    @endphp
                    <div class="w-full px-4 py-3 bg-green-50 border-2 border-green-200 rounded-xl">
                        <div class="flex items-center space-x-2">
                            <i class="bi bi-geo-alt-fill text-green-600"></i>
                            <div>
                                <p class="font-semibold text-gray-800">{{ $adminBranch ? $adminBranch->name : 'Belum diset' }}</p>
                                @if($adminBranch)
                                    <p class="text-sm text-gray-600">{{ $adminBranch->address }}</p>
                                @endif
                            </div>
                        </div>
                    </div>
                    <p class="text-xs text-gray-500 mt-1">
                        <i class="bi bi-info-circle"></i> Setoran otomatis tercatat di cabang Anda
                    </p>
                </div>

                <!-- Items Sampah -->
                <div class="mb-6">
                    <div class="flex items-center justify-between mb-3">
                        <label class="block text-sm font-semibold text-gray-700">
                            <i class="bi bi-recycle mr-1"></i> Item Sampah <span class="text-red-500">*</span>
                        </label>
                        <button type="button" onclick="addItem()" 
                            class="px-4 py-2 bg-green-500 hover:bg-green-600 text-white rounded-lg text-sm font-semibold transition-colors flex items-center space-x-2">
                            <i class="bi bi-plus-circle"></i>
                            <span>Tambah Item</span>
                        </button>
                    </div>

                    <div id="itemsContainer" class="space-y-4">
                        <!-- Item template akan ditambahkan di sini oleh JavaScript -->
                    </div>
                </div>

                <!-- Total Poin Summary -->
                <div class="mb-6 bg-gradient-to-r from-green-50 to-emerald-50 rounded-xl p-6 border-2 border-green-200">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center space-x-3">
                            <div class="w-12 h-12 bg-green-500 rounded-xl flex items-center justify-center">
                                <i class="bi bi-star-fill text-white text-xl"></i>
                            </div>
                            <div>
                                <p class="text-sm text-gray-600 font-medium">Total Poin Yang Akan Diterima Warga</p>
                                <p class="text-xs text-gray-500 mt-1">Dihitung otomatis dari berat × poin per unit</p>
                            </div>
                        </div>
                        <div class="text-right">
                            <p class="text-3xl font-bold text-green-600" id="totalPoinDisplay">0</p>
                            <p class="text-sm text-gray-600">Poin</p>
                        </div>
                    </div>
                </div>

                <!-- Buttons -->
                <div class="flex items-center justify-end space-x-4 pt-6 border-t">
                    <a href="{{ route('admin.setoran.index') }}" 
                        class="px-6 py-3 bg-gray-100 hover:bg-gray-200 text-gray-700 rounded-xl font-semibold transition-colors">
                        Batal
                    </a>
                    <button type="submit"
                        class="px-6 py-3 bg-gradient-to-r from-green-500 to-emerald-600 hover:from-green-600 hover:to-emerald-700 text-white rounded-xl font-semibold transition-all shadow-lg flex items-center space-x-2">
                        <i class="bi bi-check-circle"></i>
                        <span>Simpan Setoran</span>
                    </button>
                </div>
            </form>
        </div>
    </main>

    <script>
        const wasteTypes = @json($wasteTypes);
        let itemCounter = 0;

        // Add initial item on page load
        document.addEventListener('DOMContentLoaded', function() {
            addItem();
        });

        function addItem() {
            itemCounter++;
            const container = document.getElementById('itemsContainer');
            
            const itemDiv = document.createElement('div');
            itemDiv.className = 'bg-gray-50 rounded-xl p-4 border-2 border-gray-200';
            itemDiv.id = `item-${itemCounter}`;
            
            let wasteTypeOptions = '<option value="">-- Pilih Jenis Sampah --</option>';
            wasteTypes.forEach(type => {
                const points = type.points_per_unit ? type.points_per_unit.toLocaleString('id-ID') : '0';
                const unit = type.unit || 'kg';
                wasteTypeOptions += `<option value="${type.id}" data-points="${type.points_per_unit}" data-unit="${unit}">${type.name} (${points} poin/${unit})</option>`;
            });
            
            itemDiv.innerHTML = `
                <div class="flex items-start space-x-4">
                    <div class="flex-1 space-y-4">
                        <div>
                            <label class="block text-xs font-semibold text-gray-600 mb-1">Jenis Sampah</label>
                            <select name="items[${itemCounter}][waste_type_id]" 
                                    class="waste-type-select w-full px-3 py-2 border border-gray-300 rounded-lg focus:border-green-500 focus:outline-none text-sm" 
                                    data-item-id="${itemCounter}"
                                    required>
                                ${wasteTypeOptions}
                            </select>
                        </div>
                        <div>
                            <label class="block text-xs font-semibold text-gray-600 mb-1">
                                <span class="unit-label-${itemCounter}">Berat</span>
                            </label>
                            <div class="relative">
                                <input type="number" 
                                       name="items[${itemCounter}][weight]" 
                                       class="weight-input w-full px-3 py-2 border border-gray-300 rounded-lg focus:border-green-500 focus:outline-none text-sm" 
                                       data-item-id="${itemCounter}"
                                       step="0.1" 
                                       min="0.1" 
                                       placeholder="Contoh: 2.5"
                                       required>
                            </div>
                        </div>
                        <div class="bg-green-50 rounded-lg p-3 border border-green-200">
                            <div class="flex items-center justify-between">
                                <span class="text-xs font-semibold text-gray-600">Subtotal Poin:</span>
                                <span class="subtotal-poin text-lg font-bold text-green-600" data-item-id="${itemCounter}">0</span>
                            </div>
                        </div>
                    </div>
                    ${itemCounter > 1 ? `
                    <button type="button" onclick="removeItem(${itemCounter})"
                        class="w-10 h-10 bg-red-100 hover:bg-red-200 text-red-600 rounded-lg flex items-center justify-center transition-colors mt-6">
                        <i class="bi bi-trash"></i>
                    </button>
                    ` : ''}
                </div>
            `;
            
            container.appendChild(itemDiv);
        }

        function removeItem(id) {
            const item = document.getElementById(`item-${id}`);
            if (item) {
                item.remove();
                calculateTotalPoints(); // Recalculate after removing item
            }
        }

        // Calculate subtotal points for a specific item
        function calculateItemPoints(itemId) {
            const selectElement = document.querySelector(`.waste-type-select[data-item-id="${itemId}"]`);
            const weightInput = document.querySelector(`.weight-input[data-item-id="${itemId}"]`);
            const subtotalDisplay = document.querySelector(`.subtotal-poin[data-item-id="${itemId}"]`);
            
            if (!selectElement || !weightInput || !subtotalDisplay) return 0;
            
            const selectedOption = selectElement.options[selectElement.selectedIndex];
            const points = parseFloat(selectedOption.getAttribute('data-points')) || 0;
            const weight = parseFloat(weightInput.value) || 0;
            const unit = selectedOption.getAttribute('data-unit') || 'kg';
            
            const subtotal = points * weight;
            
            // Update subtotal display with animation
            subtotalDisplay.textContent = subtotal.toLocaleString('id-ID', {
                minimumFractionDigits: 0,
                maximumFractionDigits: 0
            }) + ' Poin';
            
            // Update unit label
            const unitLabel = document.querySelector(`.unit-label-${itemId}`);
            if (unitLabel) {
                unitLabel.textContent = `Berat (${unit})`;
            }
            
            return subtotal;
        }

        // Calculate total points from all items
        function calculateTotalPoints() {
            let total = 0;
            const allItems = document.querySelectorAll('.subtotal-poin');
            
            allItems.forEach(item => {
                const itemId = item.getAttribute('data-item-id');
                total += calculateItemPoints(itemId);
            });
            
            // Update total display with animation
            const totalDisplay = document.getElementById('totalPoinDisplay');
            totalDisplay.style.transform = 'scale(1.1)';
            totalDisplay.textContent = total.toLocaleString('id-ID', {
                minimumFractionDigits: 0,
                maximumFractionDigits: 0
            });
            
            setTimeout(() => {
                totalDisplay.style.transform = 'scale(1)';
            }, 200);
        }

        // Event delegation for dynamic items
        document.getElementById('itemsContainer').addEventListener('change', function(e) {
            if (e.target.classList.contains('waste-type-select')) {
                const itemId = e.target.getAttribute('data-item-id');
                calculateItemPoints(itemId);
                calculateTotalPoints();
            }
        });

        document.getElementById('itemsContainer').addEventListener('input', function(e) {
            if (e.target.classList.contains('weight-input')) {
                const itemId = e.target.getAttribute('data-item-id');
                calculateItemPoints(itemId);
                calculateTotalPoints();
            }
        });

        // Form validation
        document.getElementById('depositForm').addEventListener('submit', function(e) {
            const items = document.querySelectorAll('#itemsContainer > div');
            if (items.length === 0) {
                e.preventDefault();
                alert('Minimal harus ada 1 item sampah!');
                return false;
            }
        });
    </script>

    <!-- jQuery (required for Select2) -->
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    
    <!-- Select2 JS -->
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    
    <!-- Initialize Select2 -->
    <script>
        $(document).ready(function() {
            // Initialize Select2 untuk dropdown warga
            $('.select2-warga').select2({
                placeholder: '-- Pilih Warga --',
                allowClear: true,
                width: '100%',
                language: {
                    noResults: function() {
                        return "Warga tidak ditemukan";
                    },
                    searching: function() {
                        return "Mencari...";
                    },
                    inputTooShort: function() {
                        return "Ketik minimal 1 karakter";
                    }
                }
            });
        });
    </script>

</body>
</html>
