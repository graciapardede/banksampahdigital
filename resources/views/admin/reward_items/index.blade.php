<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
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
                    <a href="{{ route('admin.setoran.index') }}" class="bg-white text-gray-700 px-4 lg:px-6 py-3 rounded-2xl text-xs lg:text-sm font-semibold hover:bg-green-50 transition-colors shadow-sm flex items-center justify-center space-x-2 w-full">
                        <i class="bi bi-graph-up"></i>
                        <span class="truncate">Setoran</span>
                    </a>
                    <a href="{{ route('admin.penukaran.index') }}" class="bg-white text-gray-700 px-4 lg:px-6 py-3 rounded-2xl text-xs lg:text-sm font-semibold hover:bg-green-50 transition-colors shadow-sm flex items-center justify-center space-x-2 w-full">
                        <i class="bi bi-arrow-left-right"></i>
                        <span class="truncate">Penukaran</span>
                    </a>
                    <a href="{{ route('admin.reward-items.index') }}" class="bg-green-500 text-white px-4 lg:px-6 py-3 rounded-2xl text-xs lg:text-sm font-semibold shadow-md flex items-center justify-center space-x-2 w-full">
                        <i class="bi bi-gift"></i>
                        <span class="truncate">Tukar Barang</span>
                    </a>
                    <a href="{{ route('admin.waste-types.index') }}" class="bg-white text-gray-700 px-4 lg:px-6 py-3 rounded-2xl text-xs lg:text-sm font-semibold hover:bg-green-50 transition-colors shadow-sm flex items-center justify-center space-x-2 w-full">
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
                            <i class="bi bi-gift text-2xl"></i>
                        </div>
                        <div>
                            <h2 class="font-bold text-2xl">{{ __('Manajemen Barang Tukar') }}</h2>
                            <p class="text-sm text-teal-100">Kelola stok dan katalog barang reward</p>
                        </div>
                    </div>
                </div>
                <div class="flex flex-wrap items-center gap-3">
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
            action: 'add',
            showAddModal: false,
            addForm: {
                name: '',
                points_cost: '',
                description: '',
                stock: 1,
                image: ''
            },
            showEditModal: false,
            editForm: {},
            showDeleteModal: false,
            deleteItem: null,
            availableImages: @js(array_values(array_filter(scandir(public_path('images')), function($file) {
                return !in_array($file, ['.', '..']) && preg_match('/\.(jpg|jpeg|png|gif)$/i', $file);
            }))),
            openModal(item, actionType){ 
                this.modalItem = item; 
                this.qty = 1; 
                this.action = actionType; 
                this.showModal = true 
            },
            closeModal(){ this.showModal = false; this.modalItem = null; this.qty = 1 },
            inc(){ this.qty = Number(this.qty) + 1 },
            dec(){ if(this.qty > 1) this.qty = Number(this.qty) - 1 },
            submitStock(){
                const form = document.createElement('form');
                form.method = 'POST';
                form.action = `/admin/reward-items/${this.modalItem.id}/update-stock`;
                
                const csrf = document.createElement('input');
                csrf.type = 'hidden';
                csrf.name = '_token';
                csrf.value = document.querySelector('meta[name=csrf-token]').content;
                form.appendChild(csrf);
                
                const qtyInput = document.createElement('input');
                qtyInput.type = 'hidden';
                qtyInput.name = 'quantity';
                qtyInput.value = this.qty;
                form.appendChild(qtyInput);
                
                const actionInput = document.createElement('input');
                actionInput.type = 'hidden';
                actionInput.name = 'action';
                actionInput.value = this.action;
                form.appendChild(actionInput);
                
                document.body.appendChild(form);
                form.submit();
            },
            openAddModal(){ 
                this.addForm = { name: '', points_cost: '', description: '', stock: 1, image: '' }; 
                this.showAddModal = true 
            },
            closeAddModal(){ this.showAddModal = false },
            submitAdd(){
                const form = document.createElement('form');
                form.method = 'POST';
                form.action = '{{ route('admin.reward-items.store') }}';
                
                const csrf = document.createElement('input');
                csrf.type = 'hidden';
                csrf.name = '_token';
                csrf.value = document.querySelector('meta[name=csrf-token]').content;
                form.appendChild(csrf);
                
                Object.keys(this.addForm).forEach(key => {
                    const input = document.createElement('input');
                    input.type = 'hidden';
                    input.name = key;
                    input.value = this.addForm[key];
                    form.appendChild(input);
                });
                
                document.body.appendChild(form);
                form.submit();
            },
            openEditModal(item){
                this.editForm = {...item};
                this.showEditModal = true;
            },
            closeEditModal(){ this.showEditModal = false },
            submitEdit(){
                const form = document.createElement('form');
                form.method = 'POST';
                form.action = `/admin/reward-items/${this.editForm.id}`;
                
                const csrf = document.createElement('input');
                csrf.type = 'hidden';
                csrf.name = '_token';
                csrf.value = document.querySelector('meta[name=csrf-token]').content;
                form.appendChild(csrf);
                
                const method = document.createElement('input');
                method.type = 'hidden';
                method.name = '_method';
                method.value = 'PUT';
                form.appendChild(method);
                
                ['name', 'points_cost', 'description', 'stock', 'image'].forEach(key => {
                    const input = document.createElement('input');
                    input.type = 'hidden';
                    input.name = key;
                    input.value = this.editForm[key] || '';
                    form.appendChild(input);
                });
                
                document.body.appendChild(form);
                form.submit();
            },
            openDeleteModal(item){
                this.deleteItem = item;
                this.showDeleteModal = true;
            },
            closeDeleteModal(){ this.showDeleteModal = false; this.deleteItem = null },
            submitDelete(){
                const form = document.createElement('form');
                form.method = 'POST';
                form.action = `/admin/reward-items/${this.deleteItem.id}`;
                
                const csrf = document.createElement('input');
                csrf.type = 'hidden';
                csrf.name = '_token';
                csrf.value = document.querySelector('meta[name=csrf-token]').content;
                form.appendChild(csrf);
                
                const method = document.createElement('input');
                method.type = 'hidden';
                method.name = '_method';
                method.value = 'DELETE';
                form.appendChild(method);
                
                document.body.appendChild(form);
                form.submit();
            }
        }">
            {{-- Alert Success --}}
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

            <!-- Statistics cards -->
            <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg mb-4">
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-5 gap-4">
                    <div class="p-4 rounded-lg border bg-gradient-to-br from-blue-50 to-blue-100 shadow-sm">
                        <div class="text-sm text-blue-600 font-medium">Total Barang</div>
                        <div class="mt-2 text-2xl font-bold text-blue-800">{{ $stats['total'] ?? 0 }}</div>
                    </div>
                    <div class="p-4 rounded-lg border bg-gradient-to-br from-green-50 to-green-100 shadow-sm">
                        <div class="text-sm text-green-600 font-medium">Aktif</div>
                        <div class="mt-2 text-2xl font-bold text-green-800">{{ $stats['active'] ?? 0 }}</div>
                    </div>
                    <div class="p-4 rounded-lg border bg-gradient-to-br from-purple-50 to-purple-100 shadow-sm">
                        <div class="text-sm text-purple-600 font-medium">Total Stok</div>
                        <div class="mt-2 text-2xl font-bold text-purple-800">{{ $stats['total_stock'] ?? 0 }}</div>
                    </div>
                    <div class="p-4 rounded-lg border bg-gradient-to-br from-yellow-50 to-yellow-100 shadow-sm">
                        <div class="text-sm text-yellow-600 font-medium">Stok Menipis</div>
                        <div class="mt-2 text-2xl font-bold text-yellow-800">{{ $stats['low_stock'] ?? 0 }}</div>
                    </div>
                    <div class="p-4 rounded-lg border bg-gradient-to-br from-pink-50 to-pink-100 shadow-sm">
                        <div class="text-sm text-pink-600 font-medium">Total Ditukar</div>
                        <div class="mt-2 text-2xl font-bold text-pink-800">{{ $stats['total_redeemed'] ?? 0 }}</div>
                    </div>
                </div>
            </div>

            <!-- Search and filters -->
            <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg mb-4">
                <form method="GET" action="{{ route('admin.reward-items.index') }}" class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
                    <div class="flex-1">
                        <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari nama barang..." class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:outline-none focus:ring-2 focus:ring-green-500" />
                    </div>
                    <div class="flex items-center gap-3">
                        <select name="status" class="px-4 py-3 rounded-lg border border-gray-300 focus:outline-none focus:ring-2 focus:ring-green-500">
                            <option value="">Semua Status</option>
                            <option value="aktif" {{ request('status') === 'aktif' ? 'selected' : '' }}>Aktif</option>
                            <option value="habis" {{ request('status') === 'habis' ? 'selected' : '' }}>Habis</option>
                        </select>
                        <button type="submit" class="px-6 py-3 bg-green-600 text-white rounded-lg hover:bg-green-700 transition-colors">
                            <i class="bi bi-search"></i> Cari
                        </button>
                    </div>
                </form>
            </div>

            <!-- Product grid -->
            <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                @if($rewardItems->isEmpty())
                    <div class="text-center py-12">
                        <i class="bi bi-inbox text-6xl text-gray-300"></i>
                        <p class="mt-4 text-gray-500">Belum ada barang reward. Tambahkan barang pertama Anda!</p>
                        <button x-on:click="openAddModal()" class="mt-4 px-6 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700">
                            Tambah Barang
                        </button>
                    </div>
                @else
                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                        @foreach($rewardItems as $item)
                            <div class="bg-white rounded-xl shadow-md hover:shadow-lg transition-shadow p-5 border border-gray-200">
                                <div class="flex flex-col items-center text-center gap-3">
                                    <div class="w-40 h-40 bg-gradient-to-br from-gray-50 to-gray-100 rounded-lg flex items-center justify-center overflow-hidden border-2 border-gray-200">
                                        @if($item->image)
                                            <img src="{{ asset('images/' . $item->image) }}" alt="{{ $item->name }}" class="object-contain h-full w-full p-2" />
                                        @else
                                            <i class="bi bi-image text-6xl text-gray-300"></i>
                                        @endif
                                    </div>
                                    <div class="w-full">
                                        <h3 class="font-semibold text-lg text-gray-800">{{ $item->name }}</h3>
                                        <p class="text-xs text-gray-500 mt-1 line-clamp-2">{{ $item->description ?? 'Tidak ada deskripsi' }}</p>
                                        <div class="mt-2 flex items-center justify-center gap-2">
                                            <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-semibold bg-green-100 text-green-800">
                                                <i class="bi bi-coin mr-1"></i> {{ $item->points_cost }} poin
                                            </span>
                                        </div>
                                        <div class="mt-2">
                                            <span class="text-sm text-gray-600">Stok: </span>
                                            <span class="font-bold text-lg {{ $item->stock > 0 ? 'text-green-600' : 'text-red-600' }}">
                                                {{ $item->stock }}
                                            </span>
                                        </div>

                                        <div class="mt-4 grid grid-cols-2 gap-2">
                                            <button
                                                class="bg-green-600 hover:bg-green-700 text-white py-2 rounded-lg text-sm font-medium transition-colors"
                                                x-on:click="openModal(@js($item), 'add')"
                                            >
                                                <i class="bi bi-plus-circle"></i> Tambah Stok
                                            </button>
                                            <button
                                                class="bg-orange-600 hover:bg-orange-700 text-white py-2 rounded-lg text-sm font-medium transition-colors"
                                                x-on:click="openModal(@js($item), 'subtract')"
                                            >
                                                <i class="bi bi-dash-circle"></i> Kurangi Stok
                                            </button>
                                            <button
                                                class="border-2 border-blue-500 text-blue-600 hover:bg-blue-50 py-2 rounded-lg text-sm font-medium transition-colors"
                                                x-on:click="openEditModal(@js($item))"
                                            >
                                                <i class="bi bi-pencil"></i> Edit
                                            </button>
                                            <button
                                                class="border-2 border-red-500 text-red-600 hover:bg-red-50 py-2 rounded-lg text-sm font-medium transition-colors"
                                                x-on:click="openDeleteModal(@js($item))"
                                            >
                                                <i class="bi bi-trash"></i> Hapus
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    <!-- Pagination -->
                    <div class="mt-6">
                        {{ $rewardItems->links() }}
                    </div>
                @endif
            </div>

            {{-- Modal for update stock --}}
            <div x-show="showModal" x-cloak class="fixed inset-0 z-50 flex items-center justify-center">
                <div x-show="showModal" x-transition.opacity class="fixed inset-0 bg-black bg-opacity-50" x-on:click="closeModal()"></div>
                <div x-show="showModal" x-transition class="bg-white rounded-xl shadow-2xl w-full max-w-2xl mx-4 z-50">
                    <div class="p-6">
                        <h3 class="text-xl font-bold text-gray-800" x-text="action === 'add' ? 'Tambah Stok' : 'Kurangi Stok'"></h3>
                        <p class="text-sm text-gray-500 mt-1">Kelola stok barang reward</p>

                        <div class="mt-6 flex gap-6 items-start">
                            <div class="w-36 h-36 bg-gray-50 rounded-lg flex items-center justify-center overflow-hidden border-2">
                                <template x-if="modalItem && modalItem.image">
                                    <img :src="`/images/${modalItem.image}`" :alt="modalItem.name" class="object-contain h-full w-full p-2" />
                                </template>
                                <template x-if="modalItem && !modalItem.image">
                                    <i class="bi bi-image text-6xl text-gray-300"></i>
                                </template>
                            </div>

                            <div class="flex-1">
                                <div class="font-semibold text-lg text-gray-800" x-text="modalItem ? modalItem.name : ''"></div>
                                <div class="text-sm text-gray-500 mt-1" x-text="modalItem ? modalItem.description : ''"></div>
                                <div class="mt-2">
                                    <span class="text-sm text-gray-600">Stok saat ini: </span>
                                    <span class="font-bold text-lg text-green-600" x-text="modalItem ? modalItem.stock : 0"></span>
                                </div>

                                <div class="mt-4">
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Jumlah</label>
                                    <div class="flex items-center gap-2">
                                        <button type="button" class="px-4 py-2 bg-gray-200 hover:bg-gray-300 rounded-lg font-bold transition-colors" x-on:click="dec">-</button>
                                        <input type="number" x-model="qty" min="1" class="w-24 text-center px-3 py-2 border-2 border-gray-300 rounded-lg font-bold text-lg focus:outline-none focus:ring-2 focus:ring-green-500" />
                                        <button type="button" class="px-4 py-2 bg-gray-200 hover:bg-gray-300 rounded-lg font-bold transition-colors" x-on:click="inc">+</button>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="mt-6 flex justify-end gap-3">
                            <button type="button" class="px-6 py-2 bg-gray-200 hover:bg-gray-300 text-gray-800 rounded-lg font-medium transition-colors" x-on:click="closeModal">Batal</button>
                            <button type="button" class="px-6 py-2 text-white rounded-lg font-medium transition-colors" 
                                :class="action === 'add' ? 'bg-green-600 hover:bg-green-700' : 'bg-orange-600 hover:bg-orange-700'"
                                x-on:click="submitStock()">
                                <span x-text="action === 'add' ? 'Tambahkan' : 'Kurangi'"></span>
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Modal for Tambah Barang --}}
            <div x-show="showAddModal" x-cloak class="fixed inset-0 z-50 flex items-center justify-center">
                <div x-show="showAddModal" x-transition.opacity class="fixed inset-0 bg-black bg-opacity-50" x-on:click="closeAddModal()"></div>
                <div x-show="showAddModal" x-transition class="bg-white rounded-xl shadow-2xl w-full max-w-3xl mx-4 z-50 max-h-[90vh] overflow-y-auto">
                    <div class="p-6">
                        <h3 class="text-xl font-bold text-gray-800">Tambah Barang Baru</h3>
                        <p class="text-sm text-gray-500 mt-1">Tambahkan barang yang dapat ditukar dengan poin</p>

                        <div class="mt-6 grid grid-cols-1 md:grid-cols-3 gap-6">
                            <div class="col-span-1">
                                <label class="block text-sm font-medium text-gray-700 mb-2">Pilih Gambar</label>
                                <div class="w-full h-48 bg-gray-50 rounded-lg flex items-center justify-center overflow-hidden border-2">
                                    <template x-if="addForm.image">
                                        <img :src="`/images/${addForm.image}`" alt="preview" class="object-contain h-full w-full p-2" />
                                    </template>
                                    <template x-if="!addForm.image">
                                        <div class="text-center">
                                            <i class="bi bi-image text-6xl text-gray-300"></i>
                                            <p class="text-xs text-gray-400 mt-2">Pilih gambar</p>
                                        </div>
                                    </template>
                                </div>
                                <select x-model="addForm.image" class="mt-3 block w-full rounded-lg border px-3 py-2 text-sm">
                                    <option value="">-- Pilih Gambar --</option>
                                    <template x-for="img in availableImages" :key="img">
                                        <option :value="img" x-text="img"></option>
                                    </template>
                                </select>
                            </div>

                            <div class="col-span-2">
                                <div class="space-y-4">
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-1">Nama Barang <span class="text-red-500">*</span></label>
                                        <input type="text" x-model="addForm.name" class="block w-full rounded-lg border border-gray-300 px-4 py-2 focus:outline-none focus:ring-2 focus:ring-green-500" placeholder="Contoh: Beras Premium 5kg" required />
                                    </div>

                                    <div class="grid grid-cols-2 gap-4">
                                        <div>
                                            <label class="block text-sm font-medium text-gray-700 mb-1">Poin <span class="text-red-500">*</span></label>
                                            <input type="number" x-model="addForm.points_cost" min="1" class="block w-full rounded-lg border border-gray-300 px-4 py-2 focus:outline-none focus:ring-2 focus:ring-green-500" placeholder="200" required />
                                        </div>
                                        <div>
                                            <label class="block text-sm font-medium text-gray-700 mb-1">Stok Awal</label>
                                            <input type="number" x-model="addForm.stock" min="0" class="block w-full rounded-lg border border-gray-300 px-4 py-2 focus:outline-none focus:ring-2 focus:ring-green-500" />
                                        </div>
                                    </div>

                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-1">Deskripsi</label>
                                        <textarea x-model="addForm.description" class="block w-full rounded-lg border border-gray-300 px-4 py-2 focus:outline-none focus:ring-2 focus:ring-green-500" rows="4" placeholder="Deskripsi singkat tentang barang..."></textarea>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="mt-6 flex justify-end gap-3">
                            <button type="button" class="px-6 py-2 bg-gray-200 hover:bg-gray-300 text-gray-800 rounded-lg font-medium transition-colors" x-on:click="closeAddModal">Batal</button>
                            <button type="button" class="px-6 py-2 bg-green-600 hover:bg-green-700 text-white rounded-lg font-medium transition-colors" x-on:click="submitAdd()">Tambahkan Barang</button>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Modal for Edit Barang --}}
            <div x-show="showEditModal" x-cloak class="fixed inset-0 z-50 flex items-center justify-center">
                <div x-show="showEditModal" x-transition.opacity class="fixed inset-0 bg-black bg-opacity-50" x-on:click="closeEditModal()"></div>
                <div x-show="showEditModal" x-transition class="bg-white rounded-xl shadow-2xl w-full max-w-3xl mx-4 z-50 max-h-[90vh] overflow-y-auto">
                    <div class="p-6">
                        <h3 class="text-xl font-bold text-gray-800">Edit Barang</h3>
                        <p class="text-sm text-gray-500 mt-1">Perbarui informasi barang reward</p>

                        <div class="mt-6 grid grid-cols-1 md:grid-cols-3 gap-6">
                            <div class="col-span-1">
                                <label class="block text-sm font-medium text-gray-700 mb-2">Pilih Gambar</label>
                                <div class="w-full h-48 bg-gray-50 rounded-lg flex items-center justify-center overflow-hidden border-2">
                                    <template x-if="editForm.image">
                                        <img :src="`/images/${editForm.image}`" alt="preview" class="object-contain h-full w-full p-2" />
                                    </template>
                                    <template x-if="!editForm.image">
                                        <i class="bi bi-image text-6xl text-gray-300"></i>
                                    </template>
                                </div>
                                <select x-model="editForm.image" class="mt-3 block w-full rounded-lg border px-3 py-2 text-sm">
                                    <option value="">-- Pilih Gambar --</option>
                                    <template x-for="img in availableImages" :key="img">
                                        <option :value="img" x-text="img"></option>
                                    </template>
                                </select>
                            </div>

                            <div class="col-span-2">
                                <div class="space-y-4">
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-1">Nama Barang <span class="text-red-500">*</span></label>
                                        <input type="text" x-model="editForm.name" class="block w-full rounded-lg border border-gray-300 px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500" required />
                                    </div>

                                    <div class="grid grid-cols-2 gap-4">
                                        <div>
                                            <label class="block text-sm font-medium text-gray-700 mb-1">Poin <span class="text-red-500">*</span></label>
                                            <input type="number" x-model="editForm.points_cost" min="1" class="block w-full rounded-lg border border-gray-300 px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500" required />
                                        </div>
                                        <div>
                                            <label class="block text-sm font-medium text-gray-700 mb-1">Stok</label>
                                            <input type="number" x-model="editForm.stock" min="0" class="block w-full rounded-lg border border-gray-300 px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500" />
                                        </div>
                                    </div>

                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-1">Deskripsi</label>
                                        <textarea x-model="editForm.description" class="block w-full rounded-lg border border-gray-300 px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500" rows="4"></textarea>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="mt-6 flex justify-end gap-3">
                            <button type="button" class="px-6 py-2 bg-gray-200 hover:bg-gray-300 text-gray-800 rounded-lg font-medium transition-colors" x-on:click="closeEditModal">Batal</button>
                            <button type="button" class="px-6 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg font-medium transition-colors" x-on:click="submitEdit()">Simpan Perubahan</button>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Modal for Delete Confirmation --}}
            <div x-show="showDeleteModal" x-cloak class="fixed inset-0 z-50 flex items-center justify-center">
                <div x-show="showDeleteModal" x-transition.opacity class="fixed inset-0 bg-black bg-opacity-50" x-on:click="closeDeleteModal()"></div>
                <div x-show="showDeleteModal" x-transition class="bg-white rounded-xl shadow-2xl w-full max-w-md mx-4 z-50">
                    <div class="p-6">
                        <div class="flex items-center gap-4">
                            <div class="w-12 h-12 bg-red-100 rounded-full flex items-center justify-center flex-shrink-0">
                                <i class="bi bi-exclamation-triangle text-red-600 text-2xl"></i>
                            </div>
                            <div>
                                <h3 class="text-lg font-bold text-gray-800">Hapus Barang</h3>
                                <p class="text-sm text-gray-600 mt-1">Apakah Anda yakin ingin menghapus barang ini?</p>
                            </div>
                        </div>

                        <div class="mt-4 bg-gray-50 rounded-lg p-4">
                            <div class="font-semibold text-gray-800" x-text="deleteItem ? deleteItem.name : ''"></div>
                            <div class="text-sm text-gray-500 mt-1">
                                Stok: <span class="font-medium" x-text="deleteItem ? deleteItem.stock : 0"></span>
                            </div>
                        </div>

                        <p class="text-sm text-red-600 mt-4">
                            <i class="bi bi-info-circle"></i> Data yang dihapus tidak dapat dikembalikan!
                        </p>

                        <div class="mt-6 flex justify-end gap-3">
                            <button type="button" class="px-6 py-2 bg-gray-200 hover:bg-gray-300 text-gray-800 rounded-lg font-medium transition-colors" x-on:click="closeDeleteModal">Batal</button>
                            <button type="button" class="px-6 py-2 bg-red-600 hover:bg-red-700 text-white rounded-lg font-medium transition-colors" x-on:click="submitDelete()">
                                <i class="bi bi-trash"></i> Hapus Barang
                            </button>
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

    <style>
        [x-cloak] { display: none !important; }
    </style>

</body>
</html>
