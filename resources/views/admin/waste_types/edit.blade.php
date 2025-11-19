<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Edit Jenis Sampah - Green Saving</title>
    <script src="https://cdn.tailwindcss.com"></script>
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
    @include('admin.partials.header')

    <!-- Page Content -->
    <div class="max-w-4xl mx-auto px-4 py-8">
        <!-- Breadcrumb -->
        <div class="mb-6">
            <nav class="flex items-center space-x-2 text-sm text-gray-600">
                <a href="{{ route('admin.dashboard') }}" class="hover:text-green-600 transition">
                    <i class="bi bi-house-door"></i> Dashboard
                </a>
                <span>/</span>
                <a href="{{ route('admin.waste-types.index') }}" class="hover:text-green-600 transition">
                    Jenis Sampah
                </a>
                <span>/</span>
                <span class="text-green-600 font-semibold">Edit Data</span>
            </nav>
        </div>

        <!-- Page Header -->
        <div class="bg-gradient-to-r from-blue-500 to-indigo-600 rounded-2xl shadow-lg p-6 mb-6">
            <div class="flex items-center gap-4">
                <div class="w-14 h-14 bg-white bg-opacity-20 backdrop-blur-sm rounded-xl flex items-center justify-center">
                    <i class="bi bi-pencil-square text-3xl text-white"></i>
                </div>
                <div class="text-white">
                    <h2 class="font-bold text-2xl">Edit Jenis Sampah</h2>
                    <p class="text-blue-50 text-sm mt-1">Perbarui data jenis sampah: <strong>{{ $wasteType->name }}</strong></p>
                </div>
            </div>
        </div>

        <!-- Tips Admin Alert -->
        <div class="bg-gradient-to-r from-blue-50 to-indigo-50 border-l-4 border-blue-500 rounded-xl shadow-md p-6 mb-6">
            <div class="flex items-start gap-4">
                <div class="w-12 h-12 bg-blue-500 rounded-xl flex items-center justify-center flex-shrink-0">
                    <i class="bi bi-lightbulb text-white text-2xl"></i>
                </div>
                <div>
                    <h4 class="font-bold text-blue-900 text-lg mb-2">💡 Tips untuk Admin</h4>
                    <ul class="space-y-2 text-blue-800 text-sm">
                        <li class="flex items-start gap-2">
                            <i class="bi bi-check-circle-fill text-blue-600 mt-0.5"></i>
                            <span><strong>Item Spesifik (Harga Tinggi):</strong> Buat item untuk sampah yang sudah dipilah dengan baik. Contoh: "Botol Aqua Bersih" dengan harga 4000 poin/kg</span>
                        </li>
                        <li class="flex items-start gap-2">
                            <i class="bi bi-check-circle-fill text-blue-600 mt-0.5"></i>
                            <span><strong>Item Campuran (Harga Rendah):</strong> Buat item "Campur" untuk warga yang tidak memilah. Contoh: "Plastik Campur" dengan harga 1000 poin/kg</span>
                        </li>
                        <li class="flex items-start gap-2">
                            <i class="bi bi-info-circle-fill text-blue-600 mt-0.5"></i>
                            <span>Perbedaan harga akan mendorong warga untuk memilah sampah dengan lebih baik!</span>
                        </li>
                    </ul>
                </div>
            </div>
        </div>

        <!-- Form Card -->
        <div class="bg-white rounded-2xl shadow-lg p-8">
            <form action="{{ route('admin.waste-types.update', $wasteType) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <!-- Nama Jenis Sampah -->
                <div class="mb-6">
                    <label for="name" class="block text-sm font-semibold text-gray-700 mb-2">
                        <i class="bi bi-tag mr-1"></i> Nama Barang
                        <span class="text-red-500">*</span>
                    </label>
                    <input 
                        type="text" 
                        name="name" 
                        id="name" 
                        value="{{ old('name', $wasteType->name) }}"
                        class="w-full px-4 py-3 border-2 border-gray-300 rounded-xl focus:border-green-500 focus:ring-2 focus:ring-green-200 transition-all outline-none @error('name') border-red-500 @enderror"
                        placeholder="Misal: Botol Aqua Bersih / Plastik Campur / Kardus Tebal"
                        required
                    >
                    @error('name')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                    <p class="text-gray-500 text-sm mt-1">
                        <i class="bi bi-info-circle"></i> Gunakan nama yang spesifik untuk harga tinggi, atau 'Campur' untuk harga rendah
                    </p>
                </div>

                <!-- Kategori -->
                <div class="mb-6">
                    <label for="category" class="block text-sm font-semibold text-gray-700 mb-2">
                        <i class="bi bi-grid-3x3 mr-1"></i> Kategori
                        <span class="text-red-500">*</span>
                    </label>
                    <select 
                        name="category" 
                        id="category" 
                        class="w-full px-4 py-3 border-2 border-gray-300 rounded-xl focus:border-green-500 focus:ring-2 focus:ring-green-200 transition-all outline-none @error('category') border-red-500 @enderror"
                        required
                    >
                        <option value="">-- Pilih Kategori --</option>
                        <option value="Plastik" {{ old('category', $wasteType->category) == 'Plastik' ? 'selected' : '' }}>🔵 Plastik</option>
                        <option value="Kertas" {{ old('category', $wasteType->category) == 'Kertas' ? 'selected' : '' }}>🟡 Kertas</option>
                        <option value="Logam" {{ old('category', $wasteType->category) == 'Logam' ? 'selected' : '' }}>⚪ Logam</option>
                        <option value="Kaca" {{ old('category', $wasteType->category) == 'Kaca' ? 'selected' : '' }}>🟢 Kaca</option>
                        <option value="Elektronik" {{ old('category', $wasteType->category) == 'Elektronik' ? 'selected' : '' }}>🔴 Elektronik</option>
                        <option value="Lainnya" {{ old('category', $wasteType->category) == 'Lainnya' ? 'selected' : '' }}>⚫ Lainnya</option>
                    </select>
                    @error('category')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Satuan -->
                <div class="mb-6">
                    <label for="unit" class="block text-sm font-semibold text-gray-700 mb-2">
                        <i class="bi bi-rulers mr-1"></i> Satuan
                        <span class="text-red-500">*</span>
                    </label>
                    <select 
                        name="unit" 
                        id="unit" 
                        class="w-full px-4 py-3 border-2 border-gray-300 rounded-xl focus:border-green-500 focus:ring-2 focus:ring-green-200 transition-all outline-none @error('unit') border-red-500 @enderror"
                        required
                    >
                        <option value="">-- Pilih Satuan --</option>
                        <option value="kg" {{ old('unit', $wasteType->unit) == 'kg' ? 'selected' : '' }}>Kilogram (kg)</option>
                        <option value="liter" {{ old('unit', $wasteType->unit) == 'liter' ? 'selected' : '' }}>Liter</option>
                        <option value="pcs" {{ old('unit', $wasteType->unit) == 'pcs' ? 'selected' : '' }}>Pieces (pcs)</option>
                    </select>
                    @error('unit')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Poin per Unit -->
                <div class="mb-6">
                    <label for="points_per_unit" class="block text-sm font-semibold text-gray-700 mb-2">
                        <i class="bi bi-coin mr-1"></i> Harga Poin per Unit
                        <span class="text-red-500">*</span>
                    </label>
                    <input 
                        type="number" 
                        name="points_per_unit" 
                        id="points_per_unit" 
                        value="{{ old('points_per_unit', $wasteType->points_per_unit) }}"
                        min="1"
                        step="1"
                        class="w-full px-4 py-3 border-2 border-gray-300 rounded-xl focus:border-green-500 focus:ring-2 focus:ring-green-200 transition-all outline-none @error('points_per_unit') border-red-500 @enderror"
                        placeholder="Contoh: 4000 (untuk item pilihan) atau 1000 (untuk campur)"
                        required
                    >
                    @error('points_per_unit')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                    <p class="text-gray-500 text-sm mt-1">
                        <i class="bi bi-info-circle"></i> Harga tinggi untuk sampah terpilah, harga rendah untuk campuran
                    </p>
                </div>

                <!-- Deskripsi (Opsional) -->
                <div class="mb-6">
                    <label for="description" class="block text-sm font-semibold text-gray-700 mb-2">
                        <i class="bi bi-card-text mr-1"></i> Deskripsi (Opsional)
                    </label>
                    <textarea 
                        name="description" 
                        id="description" 
                        rows="3"
                        class="w-full px-4 py-3 border-2 border-gray-300 rounded-xl focus:border-green-500 focus:ring-2 focus:ring-green-200 transition-all outline-none @error('description') border-red-500 @enderror"
                        placeholder="Deskripsi tambahan tentang jenis sampah ini..."
                    >{{ old('description', $wasteType->description) }}</textarea>
                    @error('description')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Gambar (Opsional) -->
                <div class="mb-8">
                    <label for="image" class="block text-sm font-semibold text-gray-700 mb-2">
                        <i class="bi bi-image mr-1"></i> Gambar (Opsional)
                    </label>
                    
                    @if($wasteType->image)
                        <div class="mb-3">
                            <p class="text-sm text-gray-600 mb-2">Gambar saat ini:</p>
                            <img src="{{ asset('images/' . $wasteType->image) }}" alt="{{ $wasteType->name }}" class="w-32 h-32 object-cover rounded-xl border-2 border-gray-200">
                        </div>
                    @endif

                    <input 
                        type="file" 
                        name="image" 
                        id="image" 
                        accept="image/*"
                        class="w-full px-4 py-3 border-2 border-gray-300 rounded-xl focus:border-green-500 focus:ring-2 focus:ring-green-200 transition-all outline-none file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-green-50 file:text-green-700 hover:file:bg-green-100 @error('image') border-red-500 @enderror"
                    >
                    @error('image')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                    <p class="text-gray-500 text-sm mt-1">
                        <i class="bi bi-info-circle"></i> Format: JPG, JPEG, PNG, GIF (Max: 2MB). Kosongkan jika tidak ingin mengubah gambar.
                    </p>
                </div>

                <!-- Action Buttons -->
                <div class="flex flex-col sm:flex-row gap-3">
                    <button 
                        type="submit"
                        class="flex-1 bg-gradient-to-r from-blue-500 to-indigo-600 hover:from-blue-600 hover:to-indigo-700 text-white font-bold py-3 px-6 rounded-xl shadow-lg hover:shadow-xl transition-all duration-300 flex items-center justify-center gap-2"
                    >
                        <i class="bi bi-check-circle text-xl"></i>
                        <span>Update Data</span>
                    </button>
                    
                    <a 
                        href="{{ route('admin.waste-types.index') }}"
                        class="flex-1 bg-gray-200 hover:bg-gray-300 text-gray-700 font-bold py-3 px-6 rounded-xl shadow hover:shadow-lg transition-all duration-300 flex items-center justify-center gap-2"
                    >
                        <i class="bi bi-x-circle text-xl"></i>
                        <span>Batal</span>
                    </a>
                </div>
            </form>
        </div>
    </div>

    <!-- Footer -->
    <footer class="bg-white mt-12 py-6 border-t">
        <div class="max-w-6xl mx-auto px-4 text-center text-gray-600 text-sm">
            <p>&copy; 2024 Green Saving. Kelola Bank Sampah Digital.</p>
        </div>
    </footer>

</body>
</html>
