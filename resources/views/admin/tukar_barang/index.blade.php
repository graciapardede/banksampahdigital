<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manajemen Barang Tukar - Green Saving</title>
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
    @include('admin.partials.header')

    <!-- Page Header with Actions -->
    <div class="max-w-6xl mx-auto px-4 py-6">
        <div class="bg-gradient-to-r from-teal-500 to-cyan-600 rounded-2xl shadow-lg p-6">
            <div class="flex flex-col md:flex-row md:justify-between md:items-center gap-4">
                <div class="text-white">
                    <div class="flex items-center gap-3 mb-2">
                        <div class="w-12 h-12 bg-white bg-opacity-20 backdrop-blur-sm rounded-xl flex items-center justify-center">
                            <i class="bi bi-gift text-2xl"></i>
                        </div>
                        <div>
                            <h2 class="font-bold text-2xl">{{ __('Manajemen Barang Tukar') }}</h2>
                            <p class="text-sm text-teal-100">Kelola stok dan katalog barang reward</p>
                        </div>
                    </div>
                </div>
                <div class="flex flex-wrap items-center gap-3">
                    <a href="#" class="inline-flex items-center gap-2 bg-white bg-opacity-20 backdrop-blur-sm border-2 border-white text-white px-6 py-2 rounded-xl font-semibold shadow-lg hover:bg-opacity-30 transition-all">
                        <i class="bi bi-download"></i>
                        <span>Export</span>
                    </a>
                    <button x-on:click.prevent="openAddModal()" class="inline-flex items-center gap-2 bg-white text-teal-600 px-6 py-2 rounded-xl font-semibold shadow-lg hover:shadow-xl hover:scale-105 transition-all">
                        <i class="bi bi-plus-circle text-lg"></i>
                        <span>Tambah Barang</span>
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Main Content -->
    <main class="max-w-6xl mx-auto px-4 pb-8" x-data="{
            showModal: false,
            modalItem: null,
            qty: 1,
            // Add-item modal state
            showAddModal: false,
            addForm: {
                name: '',
                points: '',
                description: '',
                stock: 1,
                imageUrl: ''
            },
            openModal(item){ this.modalItem = item; this.qty = 1; this.showModal = true },
            closeModal(){ this.showModal = false; this.modalItem = null; this.qty = 1 },
            inc(){ this.qty = Number(this.qty) + 1 },
            dec(){ if(this.qty > 1) this.qty = Number(this.qty) - 1 },
            // add-item modal methods
            openAddModal(){ this.addForm = { name: '', points: '', description: '', stock: 1, imageUrl: '' }; if($refs && $refs.addImage) $refs.addImage.value = null; this.showAddModal = true },
            closeAddModal(){ this.showAddModal = false },
            onAddImageChange(e){ const file = e.target.files && e.target.files[0]; if(!file){ this.addForm.imageUrl = ''; return } const reader = new FileReader(); reader.onload = (ev) => { this.addForm.imageUrl = ev.target.result }; reader.readAsDataURL(file) },
            submitAdd(){ console.log('Tambah Barang:', this.addForm); this.showAddModal = false }
        }">
            {{-- Alert Success (consistent with other admin pages) --}}
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
                <div class="max-w-7xl">
                    <!-- Statistics cards -->
                    <div class="grid grid-cols-2 lg:grid-cols-5 gap-4 mb-6">
                        @php
                            $stats = [
                                ['label' => 'Total Barang', 'value' => 0, 'icon' => 'bi-gift', 'color' => 'blue'],
                                ['label' => 'Aktif', 'value' => 0, 'icon' => 'bi-check-circle', 'color' => 'green'],
                                ['label' => 'Total Stok', 'value' => 0, 'icon' => 'bi-box-seam', 'color' => 'purple'],
                                ['label' => 'Stok Menipis', 'value' => 0, 'icon' => 'bi-exclamation-triangle', 'color' => 'orange'],
                                ['label' => 'Total Ditukar', 'value' => 0, 'icon' => 'bi-arrow-repeat', 'color' => 'teal'],
                            ];
                        @endphp

                        @foreach($stats as $stat)
                            <div class="p-5 rounded-2xl bg-gradient-to-br from-{{ $stat['color'] }}-50 to-{{ $stat['color'] }}-100 border border-{{ $stat['color'] }}-200 shadow-sm hover:shadow-md transition-all">
                                <div class="flex items-center justify-between mb-3">
                                    <div class="w-10 h-10 rounded-xl bg-{{ $stat['color'] }}-500 flex items-center justify-center">
                                        <i class="bi {{ $stat['icon'] }} text-white text-lg"></i>
                                    </div>
                                </div>
                                <div class="text-xs font-semibold text-{{ $stat['color'] }}-600 uppercase tracking-wide mb-1">{{ $stat['label'] }}</div>
                                <div class="text-2xl font-bold text-gray-800">{{ $stat['value'] }}</div>
                            </div>
                        @endforeach
                    </div>

                    <!-- Search and filters -->
                    <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4 mb-6">
                        <div class="flex-1">
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                    <i class="bi bi-search text-gray-400"></i>
                                </div>
                                <input type="text" placeholder="Cari nama barang atau kategori..." class="w-full pl-12 pr-4 py-3 rounded-xl border-2 border-gray-200 focus:outline-none focus:border-teal-500 transition-colors" />
                            </div>
                        </div>
                        <div class="flex items-center gap-3">
                            <select class="px-5 py-3 rounded-xl border-2 border-gray-200 focus:border-teal-500 focus:outline-none font-semibold text-sm text-gray-700">
                                <option>Semua Status</option>
                                <option>Aktif</option>
                                <option>Nonaktif</option>
                            </select>
                            <button class="px-5 py-3 bg-teal-500 hover:bg-teal-600 text-white rounded-xl font-semibold text-sm transition-colors flex items-center gap-2">
                                <i class="bi bi-funnel"></i>
                                <span>Filter</span>
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                <div class="max-w-7xl">
                    <!-- Product grid -->
                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                        @php
                            // If controller provided $items, use it. Otherwise create simple demo items to show layout.
                            if (!isset($items) || empty($items)) {
                                // prefer an image name without spaces; fall back to file with space if present
                                $imgWithUnderscore = public_path('images/tukar_reward.png');
                                $imgWithSpace = public_path('images/tukar reward.png');

                                if (file_exists($imgWithUnderscore)) {
                                    $defaultImage = asset('images/tukar_reward.png');
                                } elseif (file_exists($imgWithSpace)) {
                                    // encode spaces for URLs
                                    $defaultImage = asset('images/' . rawurlencode('tukar reward.png'));
                                } else {
                                    // final fallback to an existing image in project
                                    $defaultImage = asset('images/tukar reward.png');
                                }

                                $items = [];
                                for ($i = 1; $i <= 6; $i++) {
                                    $items[] = (object) [
                                        'id' => $i,
                                        'name' => 'Beras Premium 5 kg',
                                        'points' => 200,
                                        'stock' => 20,
                                        'image' => $defaultImage,
                                    ];
                                }
                            }
                        @endphp

                        @php
                            // prepare JSON-safe first item for header button
                            $firstItem = null;
                            if (!empty($items)) {
                                $firstItem = $items[0];
                            }
                        @endphp

                        @foreach($items as $item)
                            <div class="bg-white rounded-xl shadow-sm p-4">
                                <div class="flex flex-col items-center text-center gap-3">
                                    <div class="w-32 h-32 bg-gray-50 rounded-lg flex items-center justify-center overflow-hidden">
                                        <img src="{{ $item->image }}" alt="{{ $item->name }}" class="object-contain h-full" />
                                    </div>
                                    <div class="w-full">
                                        <h3 class="font-semibold text-lg text-gray-800">{{ $item->name }}</h3>
                                        <div class="text-sm text-gray-500 mt-1">{{ $item->points }} poin</div>
                                        <div class="text-sm text-gray-500 mt-2">Stok: <span class="font-medium">{{ $item->stock }}</span></div>

                                        <div class="mt-4 flex gap-2">
                                            <button
                                                class="flex-1 bg-green-600 hover:bg-green-700 text-white py-2 rounded"
                                                x-on:click="openModal({!! json_encode(['id'=> $item->id, 'name'=> $item->name, 'image'=> $item->image, 'stock'=> $item->stock, 'points'=> $item->points]) !!})"
                                            >
                                                Tambah Stok
                                            </button>
                                            <a href="#" class="flex-1 border border-gray-200 text-gray-700 py-2 rounded text-center">Lihat</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
            {{-- Modal for add stock --}}
            <div x-show="showModal" x-cloak class="fixed inset-0 z-50 flex items-center justify-center">
                <div x-show="showModal" x-transition.opacity class="fixed inset-0 bg-black bg-opacity-40"></div>
                <div x-show="showModal" x-transition class="bg-white rounded-lg shadow-lg w-full max-w-2xl mx-4 z-50">
                    <div class="p-6">
                        <h3 class="text-lg font-semibold text-gray-800">Tambah Stok</h3>
                        <p class="text-sm text-gray-500">Apakah Anda ingin menambahkan Stok Barang ?</p>

                        <div class="mt-6 flex gap-6 items-center">
                            <div class="w-36 h-36 bg-gray-50 rounded-lg flex items-center justify-center overflow-hidden">
                                <template x-if="modalItem">
                                    <img :src="modalItem.image" :alt="modalItem.name" class="object-contain h-full" />
                                </template>
                            </div>

                            <div class="flex-1">
                                <div class="font-semibold text-gray-800" x-text="modalItem ? modalItem.name : ''"></div>
                                <div class="text-sm text-gray-500 mt-2">Minyak berkualitas untuk memasak</div>

                                <div class="mt-4 flex items-center gap-2">
                                    <button type="button" class="px-3 py-1 bg-gray-100 rounded" x-on:click="dec">-</button>
                                    <input type="number" x-model="qty" min="1" class="w-20 text-center px-2 py-1 border rounded" />
                                    <button type="button" class="px-3 py-1 bg-gray-100 rounded" x-on:click="inc">+</button>
                                </div>
                            </div>
                        </div>

                        <div class="mt-6 flex justify-end gap-3">
                            <button type="button" class="px-4 py-2 bg-white border rounded" x-on:click="closeModal">Batal</button>
                            <button type="button" class="px-4 py-2 bg-green-600 text-white rounded" x-on:click.prevent="console.log('Tambah', modalItem, qty); closeModal()">Tambahkan Stok</button>
                        </div>
                    </div>
                </div>
            </div>
            {{-- Modal for Tambah Barang (create new exchange item) --}}
            <div x-show="showAddModal" x-cloak class="fixed inset-0 z-50 flex items-center justify-center">
                <div x-show="showAddModal" x-transition.opacity class="fixed inset-0 bg-black bg-opacity-40"></div>
                <div x-show="showAddModal" x-transition class="bg-white rounded-lg shadow-lg w-full max-w-3xl mx-4 z-50">
                    <div class="p-6">
                        <h3 class="text-lg font-semibold text-gray-800">Tambah Barang</h3>
                        <p class="text-sm text-gray-500">Tambahkan detail barang yang dapat ditukar menggunakan poin.</p>

                        <div class="mt-6 grid grid-cols-1 md:grid-cols-3 gap-6 items-start">
                            <div class="col-span-1 flex flex-col items-center gap-3">
                                <div class="w-40 h-40 bg-gray-50 rounded-lg flex items-center justify-center overflow-hidden border">
                                    <template x-if="addForm.imageUrl">
                                        <img :src="addForm.imageUrl" alt="preview" class="object-contain h-full w-full" />
                                    </template>
                                    <template x-if="!addForm.imageUrl">
                                        <div class="text-gray-400">Preview</div>
                                    </template>
                                </div>
                                <input type="file" accept="image/*" x-ref="addImage" @change="onAddImageChange($event)" class="text-sm text-gray-500" />
                            </div>

                            <div class="col-span-2">
                                <div class="grid grid-cols-1 gap-4">
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700">Nama Barang</label>
                                        <input type="text" x-model="addForm.name" class="mt-1 block w-full rounded border px-3 py-2" placeholder="Masukkan nama barang" />
                                    </div>

                                    <div class="grid grid-cols-2 gap-4">
                                        <div>
                                            <label class="block text-sm font-medium text-gray-700">Poin</label>
                                            <input type="number" x-model="addForm.points" class="mt-1 block w-full rounded border px-3 py-2" placeholder="Jumlah poin" />
                                        </div>
                                        <div>
                                            <label class="block text-sm font-medium text-gray-700">Stok Awal</label>
                                            <input type="number" x-model="addForm.stock" min="0" class="mt-1 block w-full rounded border px-3 py-2" />
                                        </div>
                                    </div>

                                    <div>
                                        <label class="block text-sm font-medium text-gray-700">Deskripsi</label>
                                        <textarea x-model="addForm.description" class="mt-1 block w-full rounded border px-3 py-2" rows="3" placeholder="Deskripsi singkat barang"></textarea>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="mt-6 flex justify-end gap-3">
                            <button type="button" class="px-4 py-2 bg-white border rounded" x-on:click="closeAddModal">Batal</button>
                            <button type="button" class="px-4 py-2 bg-green-600 text-white rounded" x-on:click.prevent="submitAdd()">Tambahkan Barang</button>
                        </div>
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

</body>
</html>
