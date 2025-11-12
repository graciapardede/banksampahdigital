<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Jenis Sampah - Green Saving</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
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
    <style>
        [x-cloak] { display: none !important; }
    </style>
</head>
<body class="min-h-screen bg-gradient-to-br from-green-50 to-green-100 font-poppins" x-data="wasteTypeData()">

    <!-- Header -->
    <header class="bg-white shadow-sm">
        <div class="max-w-6xl mx-auto px-4 py-6">
            <div class="flex justify-between items-center">
                <!-- Logo -->
                <div class="flex items-center space-x-3">
                    <div class="w-12 h-12 bg-gradient-to-br from-green-500 to-green-600 rounded-xl flex items-center justify-center shadow-lg">
                        <i class="bi bi-recycle text-white text-2xl"></i>
                    </div>
                    <div>
                        <h1 class="font-bold text-xl text-gray-800">Green Saving Admin</h1>
                        <p class="text-sm text-green-600">Halo, {{ Auth::user()->name }}</p>
                    </div>
                </div>

                <!-- Admin Actions -->
                <div class="flex items-center space-x-4">
                    <!-- Admin Badge -->
                    <div class="bg-gradient-to-r from-green-100 to-emerald-50 px-6 py-3 rounded-full border-2 border-green-300 shadow-md">
                        <div class="flex items-center space-x-2">
                            <i class="bi bi-shield-check text-green-600 text-xl"></i>
                            <span class="font-bold text-green-700 text-sm">Administrator</span>
                        </div>
                    </div>

                    <!-- Notification Bell -->
                    <a href="#" class="w-12 h-12 bg-gray-100 hover:bg-gray-200 rounded-xl flex items-center justify-center transition-all">
                        <i class="bi bi-bell text-gray-700 text-xl"></i>
                    </a>

                    <!-- Logout Button -->
                    <form method="POST" action="{{ route('logout') }}" class="inline">
                        @csrf
                        <button type="submit" class="w-12 h-12 bg-red-100 hover:bg-red-200 rounded-xl flex items-center justify-center transition-all">
                            <i class="bi bi-box-arrow-right text-red-600 text-xl"></i>
                        </button>
                    </form>
                </div>
            </div>
        </div>

        <!-- Navigation Tabs -->
        <div class="bg-green-100 px-4 py-4">
            <div class="max-w-6xl mx-auto">
                <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-6 gap-3">
                    <a href="{{ route('admin.dashboard') }}" class="bg-white text-gray-700 px-4 lg:px-6 py-3 rounded-2xl text-xs lg:text-sm font-semibold hover:bg-green-50 transition-colors shadow-sm flex items-center justify-center space-x-2 w-full">
                        <i class="bi bi-house-door"></i>
                        <span class="truncate">Dashboard</span>
                    </a>
                    <a href="{{ route('admin.setoran') }}" class="bg-white text-gray-700 px-4 lg:px-6 py-3 rounded-2xl text-xs lg:text-sm font-semibold hover:bg-green-50 transition-colors shadow-sm flex items-center justify-center space-x-2 w-full">
                        <i class="bi bi-graph-up"></i>
                        <span class="truncate">Setoran</span>
                    </a>
                    <a href="{{ route('admin.penukaran') }}" class="bg-white text-gray-700 px-4 lg:px-6 py-3 rounded-2xl text-xs lg:text-sm font-semibold hover:bg-green-50 transition-colors shadow-sm flex items-center justify-center space-x-2 w-full">
                        <i class="bi bi-arrow-left-right"></i>
                        <span class="truncate">Penukaran</span>
                    </a>
                    <a href="{{ route('admin.tukar-barang') }}" class="bg-white text-gray-700 px-4 lg:px-6 py-3 rounded-2xl text-xs lg:text-sm font-semibold hover:bg-green-50 transition-colors shadow-sm flex items-center justify-center space-x-2 w-full">
                        <i class="bi bi-gift"></i>
                        <span class="truncate">Tukar Barang</span>
                    </a>
                    <a href="{{ route('admin.waste-types.index') }}" class="bg-green-500 text-white px-4 lg:px-6 py-3 rounded-2xl text-xs lg:text-sm font-semibold shadow-md flex items-center justify-center space-x-2 w-full">
                        <i class="bi bi-recycle"></i>
                        <span class="truncate">Jenis Sampah</span>
                    </a>
                    <a href="{{ route('admin.branches.index') }}" class="bg-white text-gray-700 px-4 lg:px-6 py-3 rounded-2xl text-xs lg:text-sm font-semibold hover:bg-green-50 transition-colors shadow-sm flex items-center justify-center space-x-2 w-full">
                        <i class="bi bi-building"></i>
                        <span class="truncate">Cabang</span>
                    </a>
                </div>
            </div>
        </div>
    </header>

    <!-- Page Header with Actions -->
    <div class="max-w-6xl mx-auto px-4 py-6">
        <div class="bg-gradient-to-r from-teal-500 to-cyan-600 rounded-2xl shadow-lg p-6">
            <div class="flex flex-col md:flex-row md:justify-between md:items-center gap-4">
                <div class="text-white">
                    <div class="flex items-center gap-3 mb-2">
                        <div class="w-12 h-12 bg-white bg-opacity-20 backdrop-blur-sm rounded-xl flex items-center justify-center">
                            <i class="bi bi-recycle text-2xl"></i>
                        </div>
                        <div>
                            <h2 class="font-bold text-2xl">{{ __('Manajemen Jenis Sampah') }}</h2>
                            <p class="text-sm text-teal-100">Kelola kategori dan poin sampah</p>
                        </div>
                    </div>
                </div>
                <div class="flex flex-wrap items-center gap-3">
                    <button x-on:click.prevent="openAddModal()" class="inline-flex items-center gap-2 bg-white text-teal-600 px-6 py-2 rounded-xl font-semibold shadow-lg hover:shadow-xl hover:scale-105 transition-all">
                        <i class="bi bi-plus-circle text-lg"></i>
                        <span>Tambah Jenis Sampah</span>
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Main Content -->
    <main class="max-w-6xl mx-auto px-4 pb-8">
        
        {{-- Success Notification --}}
        @if(session('success'))
            <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 3000)"
                 class="mb-4 bg-gradient-to-r from-green-500 to-emerald-600 text-white px-6 py-4 rounded-xl shadow-lg flex items-center justify-between">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 bg-white bg-opacity-20 rounded-full flex items-center justify-center">
                        <i class="bi bi-check-circle-fill text-2xl"></i>
                    </div>
                    <div>
                        <p class="font-semibold">Berhasil!</p>
                        <p class="text-sm text-green-50">{{ session('success') }}</p>
                    </div>
                </div>
                <button @click="show = false" class="text-white hover:text-green-100 transition-colors">
                    <i class="bi bi-x-lg text-xl"></i>
                </button>
            </div>
        @endif

        {{-- Success Notification (Alpine.js) --}}
        <div x-show="showSuccessNotification" 
             x-transition:enter="transition ease-out duration-300"
             x-transition:enter-start="opacity-0 transform translate-y-2"
             x-transition:enter-end="opacity-100 transform translate-y-0"
             x-transition:leave="transition ease-in duration-200"
             x-transition:leave-start="opacity-100"
             x-transition:leave-end="opacity-0"
             class="mb-4 bg-gradient-to-r from-green-500 to-emerald-600 text-white px-6 py-4 rounded-xl shadow-lg flex items-center justify-between"
             style="display: none;">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 bg-white bg-opacity-20 rounded-full flex items-center justify-center">
                    <i class="bi bi-check-circle-fill text-2xl"></i>
                </div>
                <div>
                    <p class="font-semibold">Berhasil!</p>
                    <p class="text-sm text-green-50" x-text="successMessage"></p>
                </div>
            </div>
            <button @click="showSuccessNotification = false" class="text-white hover:text-green-100 transition-colors">
                <i class="bi bi-x-lg text-xl"></i>
            </button>
        </div>

        <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
            <div class="max-w-7xl">
                <!-- Search -->
                <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4 mb-6">
                    <div class="flex-1">
                        <input type="text" x-model="searchQuery" placeholder="Cari nama jenis sampah atau kategori..." class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:outline-none focus:ring-2 focus:ring-green-500" />
                    </div>
                </div>

                <!-- Table -->
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nama</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Kategori</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Poin/Kg</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Deskripsi</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @php
                                $wasteTypesData = [
                                    (object)[
                                        'id' => 1,
                                        'name' => 'Plastik',
                                        'category' => 'Plastik',
                                        'points_per_unit' => 300,
                                        'description' => 'Botol plastik bekas minuman',
                                        'unit' => 'Kg'
                                    ],
                                    (object)[
                                        'id' => 2,
                                        'name' => 'Kaleng',
                                        'category' => 'Logam',
                                        'points_per_unit' => 500,
                                        'description' => 'Kaleng minuman aluminium',
                                        'unit' => 'Kg'
                                    ],
                                    (object)[
                                        'id' => 3,
                                        'name' => 'Kardus',
                                        'category' => 'Kertas',
                                        'points_per_unit' => 250,
                                        'description' => 'Kardus bekas kemasan',
                                        'unit' => 'Kg'
                                    ],
                                    (object)[
                                        'id' => 4,
                                        'name' => 'Kertas',
                                        'category' => 'Kertas',
                                        'points_per_unit' => 200,
                                        'description' => 'Kertas bekas cetak/tulis',
                                        'unit' => 'Kg'
                                    ],
                                    (object)[
                                        'id' => 5,
                                        'name' => 'Botol Kaca',
                                        'category' => 'Kaca',
                                        'points_per_unit' => 150,
                                        'description' => 'Botol kaca bekas',
                                        'unit' => 'Kg'
                                    ],
                                ];
                            @endphp

                            @foreach($wasteTypesData as $item)
                            <tr class="hover:bg-gray-50">
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm font-medium text-gray-900">{{ $item->name }}</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                        {{ $item->category }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm font-bold text-green-600">{{ $item->points_per_unit }} poin</div>
                                </td>
                                <td class="px-6 py-4">
                                    <div class="text-sm text-gray-500">{{ $item->description }}</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                    <div class="flex gap-2">
                                        <button
                                            x-on:click="openEditModal({!! json_encode($item) !!})"
                                            class="inline-flex items-center justify-center w-9 h-9 rounded-lg bg-blue-50 text-blue-600 hover:bg-blue-100 transition-colors"
                                            title="Edit"
                                        >
                                            <i class="bi bi-pencil-square"></i>
                                        </button>
                                        <button
                                            x-on:click="openDeleteModal({!! json_encode($item) !!})"
                                            class="inline-flex items-center justify-center w-9 h-9 rounded-lg bg-red-50 text-red-600 hover:bg-red-100 transition-colors"
                                            title="Hapus"
                                        >
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        {{-- Modal Tambah Jenis Sampah --}}
        <div x-show="showAddModal" x-cloak class="fixed inset-0 z-50 flex items-center justify-center p-4">
            <div x-show="showAddModal" x-transition.opacity class="fixed inset-0 bg-black bg-opacity-50"></div>
            <div x-show="showAddModal" x-transition class="bg-white rounded-2xl shadow-2xl w-full max-w-md z-50 max-h-[95vh] overflow-y-auto">
                <div class="p-6">
                    <!-- Header -->
                    <div class="flex items-center justify-between mb-6">
                        <h3 class="text-xl font-bold text-gray-800">Tambah Jenis Sampah</h3>
                        <button x-on:click="closeAddModal" class="text-gray-400 hover:text-gray-600">
                            <i class="bi bi-x-lg text-xl"></i>
                        </button>
                    </div>

                    <!-- Form -->
                    <form @submit.prevent="submitAdd">
                        <div class="space-y-4">
                            <!-- Nama -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Nama</label>
                                <input 
                                    type="text" 
                                    x-model="addForm.name" 
                                    class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-green-500 focus:border-transparent" 
                                    placeholder="Contoh: Plastik"
                                />
                            </div>

                            <!-- Kategori -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Kategori</label>
                                <select 
                                    x-model="addForm.category" 
                                    class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-green-500 focus:border-transparent bg-white"
                                >
                                    <option value="">Pilih kategori</option>
                                    <option value="Plastik">Plastik</option>
                                    <option value="Kertas">Kertas</option>
                                    <option value="Logam">Logam</option>
                                    <option value="Kaca">Kaca</option>
                                    <option value="Organik">Organik</option>
                                </select>
                            </div>

                            <!-- Poin/Kg -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Poin / Kg</label>
                                <input 
                                    type="number" 
                                    x-model="addForm.points_per_unit" 
                                    class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-green-500 focus:border-transparent" 
                                    placeholder="300 poin"
                                />
                            </div>

                            <!-- Deskripsi -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Deskripsi</label>
                                <textarea 
                                    x-model="addForm.description" 
                                    rows="3"
                                    class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-green-500 focus:border-transparent" 
                                    placeholder="Botol plastik bekas minuman"
                                ></textarea>
                            </div>

                            <!-- Upload Foto (Optional) -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Upload Foto</label>
                                <div class="border-2 border-dashed border-gray-300 rounded-xl p-6 text-center cursor-pointer hover:border-green-500 transition-colors"
                                     x-on:click="$refs.addImageInput.click()">
                                    <template x-if="!addForm.imageUrl">
                                        <div>
                                            <i class="bi bi-cloud-upload text-4xl text-gray-400 mb-2"></i>
                                            <p class="text-sm text-gray-500">Klik untuk upload foto</p>
                                        </div>
                                    </template>
                                    <template x-if="addForm.imageUrl">
                                        <img :src="addForm.imageUrl" class="mx-auto h-24 object-contain" />
                                    </template>
                                </div>
                                <input type="file" x-ref="addImageInput" @change="onAddImageChange($event)" accept="image/*" class="hidden" />
                            </div>
                        </div>

                        <!-- Action Buttons -->
                        <div class="mt-6 flex gap-3">
                            <button 
                                type="button" 
                                x-on:click="closeAddModal"
                                class="flex-1 px-6 py-3 bg-white border-2 border-gray-300 text-gray-700 rounded-xl font-semibold hover:bg-gray-50 transition-all"
                            >
                                Batal
                            </button>
                            <button 
                                type="submit"
                                class="flex-1 px-6 py-3 bg-gradient-to-r from-green-500 to-green-600 hover:from-green-600 hover:to-green-700 text-white rounded-xl font-semibold shadow-lg hover:shadow-xl transition-all"
                            >
                                Simpan
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        {{-- Modal Edit Jenis Sampah --}}
        <div x-show="showEditModal" x-cloak class="fixed inset-0 z-50 flex items-center justify-center p-4">
            <div x-show="showEditModal" x-transition.opacity class="fixed inset-0 bg-black bg-opacity-50"></div>
            <div x-show="showEditModal" x-transition class="bg-white rounded-2xl shadow-2xl w-full max-w-md z-50 max-h-[95vh] overflow-y-auto">
                <div class="p-6">
                    <!-- Header -->
                    <div class="flex items-center justify-between mb-6">
                        <h3 class="text-xl font-bold text-gray-800">Edit Jenis Sampah</h3>
                        <button x-on:click="closeEditModal" class="text-gray-400 hover:text-gray-600">
                            <i class="bi bi-x-lg text-xl"></i>
                        </button>
                    </div>

                    <!-- Form -->
                    <form @submit.prevent="submitEdit">
                        <div class="space-y-4">
                            <!-- Nama -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Nama</label>
                                <input 
                                    type="text" 
                                    x-model="editForm.name" 
                                    class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-green-500 focus:border-transparent" 
                                    placeholder="Contoh: Plastik"
                                />
                            </div>

                            <!-- Kategori -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Kategori</label>
                                <select 
                                    x-model="editForm.category" 
                                    class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-green-500 focus:border-transparent bg-white"
                                >
                                    <option value="">Pilih kategori</option>
                                    <option value="Plastik">Plastik</option>
                                    <option value="Kertas">Kertas</option>
                                    <option value="Logam">Logam</option>
                                    <option value="Kaca">Kaca</option>
                                    <option value="Organik">Organik</option>
                                </select>
                            </div>

                            <!-- Poin/Kg -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Poin / Kg</label>
                                <input 
                                    type="number" 
                                    x-model="editForm.points_per_unit" 
                                    class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-green-500 focus:border-transparent" 
                                    placeholder="300 poin"
                                />
                            </div>

                            <!-- Deskripsi -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Deskripsi</label>
                                <textarea 
                                    x-model="editForm.description" 
                                    rows="3"
                                    class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-green-500 focus:border-transparent" 
                                    placeholder="Botol plastik bekas minuman"
                                ></textarea>
                            </div>

                            <!-- Upload Foto (Optional) -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Upload Foto</label>
                                <div class="border-2 border-dashed border-gray-300 rounded-xl p-6 text-center cursor-pointer hover:border-green-500 transition-colors"
                                     x-on:click="$refs.editImageInput.click()">
                                    <template x-if="!editForm.imageUrl">
                                        <div>
                                            <i class="bi bi-cloud-upload text-4xl text-gray-400 mb-2"></i>
                                            <p class="text-sm text-gray-500">Klik untuk upload foto baru</p>
                                        </div>
                                    </template>
                                    <template x-if="editForm.imageUrl">
                                        <img :src="editForm.imageUrl" class="mx-auto h-24 object-contain" />
                                    </template>
                                </div>
                                <input type="file" x-ref="editImageInput" @change="onEditImageChange($event)" accept="image/*" class="hidden" />
                            </div>
                        </div>

                        <!-- Action Buttons -->
                        <div class="mt-6 flex gap-3">
                            <button 
                                type="button" 
                                x-on:click="closeEditModal"
                                class="flex-1 px-6 py-3 bg-white border-2 border-gray-300 text-gray-700 rounded-xl font-semibold hover:bg-gray-50 transition-all"
                            >
                                Batal
                            </button>
                            <button 
                                type="submit"
                                class="flex-1 px-6 py-3 bg-gradient-to-r from-green-500 to-green-600 hover:from-green-600 hover:to-green-700 text-white rounded-xl font-semibold shadow-lg hover:shadow-xl transition-all"
                            >
                                Simpan
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        {{-- Modal Konfirmasi Hapus --}}
        <div x-show="showDeleteModal" x-cloak class="fixed inset-0 z-50 flex items-center justify-center p-4">
            <div x-show="showDeleteModal" x-transition.opacity class="fixed inset-0 bg-black bg-opacity-50"></div>
            <div x-show="showDeleteModal" x-transition class="bg-white rounded-2xl shadow-2xl w-full max-w-md z-50">
                <div class="p-6">
                    <div class="flex items-center justify-center w-16 h-16 bg-red-100 rounded-full mx-auto mb-4">
                        <i class="bi bi-exclamation-triangle text-red-600 text-3xl"></i>
                    </div>
                    
                    <h3 class="text-lg font-semibold text-gray-800 text-center mb-2">Hapus Jenis Sampah?</h3>
                    <p class="text-sm text-gray-500 text-center mb-6">Apakah Anda yakin ingin menghapus jenis sampah ini? Tindakan ini tidak dapat dibatalkan.</p>

                    <template x-if="deleteItem">
                        <div class="bg-gray-50 rounded-lg p-4 mb-6 border border-gray-200">
                            <div class="text-sm">
                                <p class="font-semibold text-gray-800 mb-1" x-text="deleteItem.name"></p>
                                <p class="text-gray-500 text-xs" x-text="deleteItem.description"></p>
                                <div class="mt-2 flex items-center gap-2">
                                    <span class="px-2 py-1 text-xs font-semibold rounded-full bg-green-100 text-green-800" x-text="deleteItem.category"></span>
                                    <span class="text-xs text-gray-600" x-text="deleteItem.points_per_unit + ' poin'"></span>
                                </div>
                            </div>
                        </div>
                    </template>

                    <div class="flex gap-3">
                        <button 
                            type="button" 
                            x-on:click="closeDeleteModal"
                            class="flex-1 px-4 py-2.5 bg-gray-100 hover:bg-gray-200 text-gray-700 rounded-xl font-semibold transition-all"
                        >
                            <i class="bi bi-x-circle mr-1"></i>
                            Batal
                        </button>
                        <button 
                            type="button" 
                            x-on:click="confirmDelete"
                            class="flex-1 px-4 py-2.5 bg-gradient-to-r from-red-500 to-red-600 hover:from-red-600 hover:to-red-700 text-white rounded-xl font-semibold transition-all shadow-md hover:shadow-lg"
                        >
                            <i class="bi bi-trash-fill mr-1"></i>
                            Ya, Hapus
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <!-- Footer -->
    <footer class="bg-gradient-to-r from-green-50 to-emerald-50 py-8 mt-12 border-t border-green-200">
        <div class="max-w-6xl mx-auto px-4">
            <div class="flex flex-col items-center gap-4">
                <div class="w-16 h-16 bg-gradient-to-br from-green-500 to-green-600 rounded-2xl flex items-center justify-center shadow-lg">
                    <i class="bi bi-recycle text-white text-3xl"></i>
                </div>
                <h3 class="text-xl font-bold text-green-600">Green Saving Admin Panel</h3>
                <p class="text-sm text-gray-600 text-center">
                    Sistem Manajemen Bank Sampah Digital
                </p>
                <p class="text-sm text-gray-500">© 2025 Green Saving. All rights reserved.</p>
            </div>
        </div>
    </footer>

    <script>
        function wasteTypeData() {
            return {
                searchQuery: '',
                showAddModal: false,
                showEditModal: false,
                showDeleteModal: false,
                showSuccessNotification: false,
                successMessage: '', 
                deleteItem: null,
                addForm: {
                    name: '',
                    category: '',
                    points_per_unit: '',
                    description: '',
                    imageUrl: ''
                },
                editForm: {
                    id: null,
                    name: '',
                    category: '',
                    points_per_unit: '',
                    description: '',
                    imageUrl: ''
                },
                
                openAddModal() {
                    this.addForm = {
                        name: '',
                        category: '',
                        points_per_unit: '',
                        description: '',
                        imageUrl: ''
                    };
                    if(this.$refs && this.$refs.addImageInput) { 
                        this.$refs.addImageInput.value = null;
                    }
                    this.showAddModal = true;
                },
                
                closeAddModal() {
                    this.showAddModal = false;
                },
                
                onAddImageChange(e) {
                    const file = e.target.files && e.target.files[0];
                    if(!file) {
                        this.addForm.imageUrl = '';
                        return;
                    }
                    const reader = new FileReader();
                    reader.onload = (ev) => {
                        this.addForm.imageUrl = ev.target.result;
                    };
                    reader.readAsDataURL(file);
                },
                
                submitAdd() {
                    if(!this.addForm.name || !this.addForm.category || !this.addForm.points_per_unit) {
                        alert('Mohon lengkapi semua field yang diperlukan!');
                        return;
                    }
                    
                    console.log('Tambah Jenis Sampah:', this.addForm);
                    
                    this.showAddModal = false;
                    this.successMessage = 'Jenis sampah "' + this.addForm.name + '" berhasil ditambahkan!';
                    this.showSuccessNotification = true;
                    
                    setTimeout(() => {
                        this.showSuccessNotification = false;
                    }, 4000);
                    
                    // TODO: Submit to backend
                    // You can use fetch or form submit here
                },
                
                openEditModal(item) {
                    this.editForm = {
                        id: item.id,
                        name: item.name,
                        category: item.category,
                        points_per_unit: item.points_per_unit,
                        description: item.description || '',
                        imageUrl: ''
                    };
                    if(this.$refs && this.$refs.editImageInput) {
                        this.$refs.editImageInput.value = null;
                    }
                    this.showEditModal = true;
                },
                
                closeEditModal() {
                    this.showEditModal = false;
                },
                
                onEditImageChange(e) {
                    const file = e.target.files && e.target.files[0];
                    if(!file) {
                        this.editForm.imageUrl = '';
                        return;
                    }
                    const reader = new FileReader();
                    reader.onload = (ev) => {
                        this.editForm.imageUrl = ev.target.result;
                    };
                    reader.readAsDataURL(file);
                },
                
                submitEdit() {
                    if(!this.editForm.name || !this.editForm.category || !this.editForm.points_per_unit) {
                        alert('Mohon lengkapi semua field yang diperlukan!');
                        return;
                    }
                    
                    console.log('Edit Jenis Sampah:', this.editForm);
                    
                    this.showEditModal = false;
                    this.successMessage = 'Jenis sampah "' + this.editForm.name + '" berhasil diperbarui!';
                    this.showSuccessNotification = true;
                    
                    setTimeout(() => {
                        this.showSuccessNotification = false;
                    }, 4000);
                    
                    // TODO: Submit to backend
                },
                
                openDeleteModal(item) {
                    this.deleteItem = item;
                    this.showDeleteModal = true;
                },
                
                closeDeleteModal() {
                    this.showDeleteModal = false;
                    this.deleteItem = null;
                },
                
                confirmDelete() {
                    console.log('Hapus Jenis Sampah:', this.deleteItem);
                    const itemName = this.deleteItem.name;
                    this.showDeleteModal = false;
                    
                    this.successMessage = 'Jenis sampah "' + itemName + '" berhasil dihapus!';
                    this.showSuccessNotification = true;
                    
                    setTimeout(() => {
                        this.showSuccessNotification = false;
                    }, 4000);
                    
                    this.deleteItem = null;
                    
                    // TODO: Submit delete to backend
                }
            }
        }
    </script>

</body>
</html>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            @if(session('success'))
                <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 3000)"
                    class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4">
                    <span class="block sm:inline">{{ session('success') }}</span>
                    <span @click="show = false" class="absolute top-0 bottom-0 right-0 px-4 py-3 cursor-pointer">
                        <svg class="fill-current h-6 w-6 text-green-500" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                            <path d="M14.348 14.849a1.2 1.2 0 0 1-1.697 0L10 11.819l-2.651 3.029a1.2 1.2 0 1 1-1.697-1.697l2.758-3.15-2.759-3.152a1.2 1.2 0 1 1 1.697-1.697L10 8.183l2.651-3.031a1.2 1.2 0 1 1 1.697 1.697l-2.758 3.152 2.758 3.15a1.2 1.2 0 0 1 0 1.698z"/>
                        </svg>
                    </span>
                </div>
            @endif

            <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                <div class="max-w-full">
                    <h3 class="text-gray-700 font-semibold mb-4">Daftar Jenis Sampah</h3>
                    <p class="text-sm text-gray-500 mb-6">Atur konversi poin per jenis sampah</p>

                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nama Jenis</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Kategori</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Poin/Kg</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Harga Pasar</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Deskripsi</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @php
                                    // fallback demo rows if controller doesn't pass $wasteTypes
                                    $demo = [
                                        (object)['name'=>'Plastik PET','category'=>'Plastik','points'=>100,'price'=>'Rp 5.000','description'=>'Botol plastik bekas minuman'],
                                        (object)['name'=>'Kaleng Aluminium','category'=>'Logam','points'=>250,'price'=>'Rp 12.000','description'=>'Kaleng minuman bekas'],
                                        (object)['name'=>'Kertas/Kardus','category'=>'Kertas','points'=>50,'price'=>'Rp 2.000','description'=>'Kertas dan kardus bekas'],
                                    ];
                                    $rows = isset($wasteTypes) && count($wasteTypes) ? $wasteTypes : $demo;
                                @endphp

                                @foreach($rows as $wt)
                                    <tr>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $wt->name ?? $wt['name'] ?? '' }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $wt->category ?? $wt['category'] ?? '-' }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-green-600">{{ $wt->points ?? $wt['points'] ?? 0 }} poin</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $wt->price ?? $wt['price'] ?? '-' }}</td>
                                        <td class="px-6 py-4 text-sm text-gray-500">{{ $wt->description ?? $wt['description'] ?? '' }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                            <a href="#" class="inline-flex items-center justify-center w-9 h-9 rounded-full border border-gray-200 text-green-600 mr-2" title="Edit">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor"><path d="M17.414 2.586a2 2 0 010 2.828l-9.9 9.9a1 1 0 01-.464.263l-4 1a1 1 0 01-1.213-1.213l1-4a1 1 0 01.263-.464l9.9-9.9a2 2 0 012.828 0z"/></svg>
                                            </a>
                                            <form action="#" method="POST" class="inline-block" onsubmit="return confirm('Yakin ingin menghapus?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="inline-flex items-center justify-center w-9 h-9 rounded-full border border-gray-200 text-red-600" title="Hapus">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M6 2a1 1 0 00-1 1v1H3.5A1.5 1.5 0 002 5.5V6h16v-.5A1.5 1.5 0 0016.5 4H15V3a1 1 0 00-1-1H6zm2 6a1 1 0 011 1v6a1 1 0 11-2 0V9a1 1 0 011-1zm4 0a1 1 0 011 1v6a1 1 0 11-2 0V9a1 1 0 011-1z" clip-rule="evenodd"/></svg>
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
