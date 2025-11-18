<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Buat Setoran Baru - Green Saving Admin</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css" rel="stylesheet">
    <meta name="csrf-token" content="{{ csrf_token() }}">
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
                    <select name="user_id" id="user_id" required
                        class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:border-green-500 focus:outline-none transition-colors">
                        <option value="">-- Pilih Warga --</option>
                        @foreach($users as $user)
                        <option value="{{ $user->id }}" {{ old('user_id') == $user->id ? 'selected' : '' }}>
                            {{ $user->full_name }} ({{ $user->phone }})
                        </option>
                        @endforeach
                    </select>
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
                wasteTypeOptions += `<option value="${type.id}">${type.name} (${type.points_per_kg} poin/kg)</option>`;
            });
            
            itemDiv.innerHTML = `
                <div class="flex items-start space-x-4">
                    <div class="flex-1 space-y-4">
                        <div>
                            <label class="block text-xs font-semibold text-gray-600 mb-1">Jenis Sampah</label>
                            <select name="items[${itemCounter}][waste_type_id]" required
                                class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:border-green-500 focus:outline-none text-sm">
                                ${wasteTypeOptions}
                            </select>
                        </div>
                        <div>
                            <label class="block text-xs font-semibold text-gray-600 mb-1">Berat (kg)</label>
                            <input type="number" name="items[${itemCounter}][weight]" step="0.1" min="0.1" required
                                placeholder="Contoh: 2.5"
                                class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:border-green-500 focus:outline-none text-sm">
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
            }
        }

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

</body>
</html>
