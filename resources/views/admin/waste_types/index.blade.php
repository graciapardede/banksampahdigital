<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Manajemen Jenis Sampah - Green Saving</title>
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
                    <a href="{{ route('admin.reward-items.index') }}" class="bg-white text-gray-700 px-4 lg:px-6 py-3 rounded-2xl text-xs lg:text-sm font-semibold hover:bg-green-50 transition-colors shadow-sm flex items-center justify-center space-x-2 w-full">
                        <i class="bi bi-gift"></i>
                        <span class="truncate">Tukar Barang</span>
                    </a>
                    <a href="{{ route('admin.waste-types.index') }}" class="bg-green-500 text-white px-4 lg:px-6 py-3 rounded-2xl text-xs lg:text-sm font-semibold shadow-md flex items-center justify-center space-x-2 w-full">
                        <i class="bi bi-recycle"></i>
                        <span class="truncate">Jenis Sampah</span>
                    </a>
                    <a href="{{ route('admin.laporan.index') }}" class="bg-white text-gray-700 px-4 lg:px-6 py-3 rounded-2xl text-xs lg:text-sm font-semibold hover:bg-green-50 transition-colors shadow-sm flex items-center justify-center space-x-2 w-full">
                        <i class="bi bi-file-earmark-text"></i>
                        <span class="truncate">Laporan</span>
                    </a>
                </div>
            </div>
        </div>
    </header>

    <!-- Page Header with Actions -->
    <div class="max-w-6xl mx-auto px-4 py-6">
        <div class="bg-gradient-to-r from-green-500 to-emerald-600 rounded-2xl shadow-lg p-6">
            <div class="flex flex-col md:flex-row md:justify-between md:items-center gap-4">
                <div class="text-white">
                    <div class="flex items-center gap-3 mb-2">
                        <div class="w-12 h-12 bg-white bg-opacity-20 backdrop-blur-sm rounded-xl flex items-center justify-center">
                            <i class="bi bi-recycle text-2xl"></i>
                        </div>
                        <div>
                            <h2 class="font-bold text-2xl">{{ __('Manajemen Jenis Sampah') }}</h2>
                            <p class="text-sm text-green-100">Kelola kategori dan nilai poin sampah</p>
                        </div>
                    </div>
                </div>
                <div class="flex flex-wrap items-center gap-3">
                    <a href="{{ route('admin.waste-types.create') }}" class="inline-flex items-center gap-2 bg-white text-green-600 px-6 py-2 rounded-xl font-semibold shadow-lg hover:shadow-xl hover:scale-105 transition-all">
                        <i class="bi bi-plus-circle text-lg"></i>
                        <span>Tambah Jenis Sampah</span>
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Main Content -->
    <main class="max-w-6xl mx-auto px-4 pb-8" x-data="{
            showAddModal: false,
            addForm: {
                name: '',
                category: '',
                unit: 'kg',
                points_per_unit: '',
                description: ''
            },
            addImagePreview: null,
            showEditModal: false,
            editForm: {},
            editImagePreview: null,
            showDeleteModal: false,
            deleteItem: null,
            openAddModal(){ 
                this.addForm = { name: '', category: '', unit: 'kg', points_per_unit: '', description: '' };
                this.addImagePreview = null;
                this.showAddModal = true 
            },
            closeAddModal(){ 
                this.showAddModal = false;
                this.addImagePreview = null;
            },
            handleAddImageUpload(event){
                const file = event.target.files[0];
                if(file) {
                    const reader = new FileReader();
                    reader.onload = (e) => {
                        this.addImagePreview = e.target.result;
                    };
                    reader.readAsDataURL(file);
                }
            },
            submitAdd(){
                const form = document.getElementById('addWasteForm');
                form.submit();
            },
            openEditModal(item){
                this.editForm = {...item};
                this.editImagePreview = item.image ? `/images/${item.image}` : null;
                this.showEditModal = true;
            },
            closeEditModal(){ 
                this.showEditModal = false;
                this.editImagePreview = null;
            },
            handleEditImageUpload(event){
                const file = event.target.files[0];
                if(file) {
                    const reader = new FileReader();
                    reader.onload = (e) => {
                        this.editImagePreview = e.target.result;
                    };
                    reader.readAsDataURL(file);
                }
            },
            submitEdit(){
                const form = document.getElementById('editWasteForm');
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
                form.action = `/admin/waste-types/${this.deleteItem.id}`;
                
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
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
                    <div class="p-4 rounded-lg border bg-gradient-to-br from-blue-50 to-blue-100 shadow-sm">
                        <div class="text-sm text-blue-600 font-medium">Total Jenis</div>
                        <div class="mt-2 text-2xl font-bold text-blue-800">{{ $wasteTypes->count() }}</div>
                    </div>
                    <div class="p-4 rounded-lg border bg-gradient-to-br from-green-50 to-green-100 shadow-sm">
                        <div class="text-sm text-green-600 font-medium">Plastik</div>
                        <div class="mt-2 text-2xl font-bold text-green-800">{{ $wasteTypes->where('category', 'Plastik')->count() }}</div>
                    </div>
                    <div class="p-4 rounded-lg border bg-gradient-to-br from-yellow-50 to-yellow-100 shadow-sm">
                        <div class="text-sm text-yellow-600 font-medium">Kertas</div>
                        <div class="mt-2 text-2xl font-bold text-yellow-800">{{ $wasteTypes->where('category', 'Kertas')->count() }}</div>
                    </div>
                    <div class="p-4 rounded-lg border bg-gradient-to-br from-purple-50 to-purple-100 shadow-sm">
                        <div class="text-sm text-purple-600 font-medium">Logam</div>
                        <div class="mt-2 text-2xl font-bold text-purple-800">{{ $wasteTypes->where('category', 'Logam')->count() }}</div>
                    </div>
                </div>
            </div>

            <!-- Search and filters -->
            <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg mb-4">
                <form method="GET" action="{{ route('admin.waste-types.index') }}" class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
                    <div class="flex-1">
                        <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari jenis sampah..." class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:outline-none focus:ring-2 focus:ring-green-500" />
                    </div>
                    <div class="flex items-center gap-3">
                        <select name="category" class="px-4 py-3 rounded-lg border border-gray-300 focus:outline-none focus:ring-2 focus:ring-green-500">
                            <option value="">Semua Kategori</option>
                            <option value="Plastik" {{ request('category') === 'Plastik' ? 'selected' : '' }}>Plastik</option>
                            <option value="Kertas" {{ request('category') === 'Kertas' ? 'selected' : '' }}>Kertas</option>
                            <option value="Logam" {{ request('category') === 'Logam' ? 'selected' : '' }}>Logam</option>
                            <option value="Kaca" {{ request('category') === 'Kaca' ? 'selected' : '' }}>Kaca</option>
                            <option value="Organik" {{ request('category') === 'Organik' ? 'selected' : '' }}>Organik</option>
                            <option value="Elektronik" {{ request('category') === 'Elektronik' ? 'selected' : '' }}>Elektronik</option>
                        </select>
                        <button type="submit" class="px-6 py-3 bg-green-600 text-white rounded-lg hover:bg-green-700 transition-colors">
                            <i class="bi bi-search"></i> Cari
                        </button>
                    </div>
                </form>
            </div>

            <!-- Waste types table -->
            <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                @if($wasteTypes->isEmpty())
                    <div class="text-center py-12">
                        <i class="bi bi-recycle text-6xl text-gray-300"></i>
                        <p class="mt-4 text-gray-500">Belum ada jenis sampah. Tambahkan jenis sampah pertama Anda!</p>
                        <a href="{{ route('admin.waste-types.create') }}" class="inline-block mt-4 px-6 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 transition-colors">
                            Tambah Jenis Sampah
                        </a>
                    </div>
                @else
                    <!-- Desktop Table View -->
                    <div class="hidden md:block overflow-x-auto">
                        <table class="w-full">
                            <thead class="bg-gradient-to-r from-green-50 to-emerald-50">
                                <tr>
                                    <th class="px-6 py-4 text-left text-xs font-bold text-gray-700 uppercase tracking-wider">
                                        Kategori
                                    </th>
                                    <th class="px-6 py-4 text-left text-xs font-bold text-gray-700 uppercase tracking-wider">
                                        Nama Barang
                                    </th>
                                    <th class="px-6 py-4 text-left text-xs font-bold text-gray-700 uppercase tracking-wider">
                                        Satuan
                                    </th>
                                    <th class="px-6 py-4 text-right text-xs font-bold text-gray-700 uppercase tracking-wider">
                                        Harga (Poin)
                                    </th>
                                    <th class="px-6 py-4 text-center text-xs font-bold text-gray-700 uppercase tracking-wider">
                                        Aksi
                                    </th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-200">
                                @foreach($wasteTypes as $item)
                                    <tr class="hover:bg-gray-50 transition-colors">
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            @if($item->category == 'Plastik')
                                                <span class="inline-flex items-center px-3 py-1.5 rounded-full text-sm font-semibold bg-blue-100 text-blue-800 border border-blue-200">
                                                    <i class="bi bi-circle-fill text-xs mr-2"></i> {{ $item->category }}
                                                </span>
                                            @elseif($item->category == 'Kertas')
                                                <span class="inline-flex items-center px-3 py-1.5 rounded-full text-sm font-semibold bg-yellow-100 text-yellow-800 border border-yellow-200">
                                                    <i class="bi bi-circle-fill text-xs mr-2"></i> {{ $item->category }}
                                                </span>
                                            @elseif($item->category == 'Logam')
                                                <span class="inline-flex items-center px-3 py-1.5 rounded-full text-sm font-semibold bg-gray-100 text-gray-800 border border-gray-300">
                                                    <i class="bi bi-circle-fill text-xs mr-2"></i> {{ $item->category }}
                                                </span>
                                            @elseif($item->category == 'Kaca')
                                                <span class="inline-flex items-center px-3 py-1.5 rounded-full text-sm font-semibold bg-green-100 text-green-800 border border-green-200">
                                                    <i class="bi bi-circle-fill text-xs mr-2"></i> {{ $item->category }}
                                                </span>
                                            @elseif($item->category == 'Elektronik')
                                                <span class="inline-flex items-center px-3 py-1.5 rounded-full text-sm font-semibold bg-red-100 text-red-800 border border-red-200">
                                                    <i class="bi bi-circle-fill text-xs mr-2"></i> {{ $item->category }}
                                                </span>
                                            @else
                                                <span class="inline-flex items-center px-3 py-1.5 rounded-full text-sm font-semibold bg-purple-100 text-purple-800 border border-purple-200">
                                                    <i class="bi bi-circle-fill text-xs mr-2"></i> {{ $item->category }}
                                                </span>
                                            @endif
                                        </td>
                                        <td class="px-6 py-4">
                                            <div class="flex items-center gap-3">
                                                @if($item->image)
                                                    <img src="{{ asset('images/' . $item->image) }}" alt="{{ $item->name }}" class="w-12 h-12 rounded-lg object-cover border border-gray-200">
                                                @else
                                                    <div class="w-12 h-12 bg-gray-100 rounded-lg flex items-center justify-center">
                                                        <i class="bi bi-recycle text-gray-400 text-xl"></i>
                                                    </div>
                                                @endif
                                                <div>
                                                    <p class="font-bold text-gray-900">{{ $item->name }}</p>
                                                    @if($item->description)
                                                        <p class="text-xs text-gray-500 line-clamp-1">{{ $item->description }}</p>
                                                    @endif
                                                </div>
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <span class="text-sm font-medium text-gray-700">{{ strtoupper($item->unit) }}</span>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-right">
                                            <span class="text-lg font-bold text-green-600">{{ number_format($item->points_per_unit, 0, ',', '.') }}</span>
                                            <span class="text-xs text-gray-500 ml-1">poin</span>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-center">
                                            <div class="flex items-center justify-center gap-2">
                                                <a href="{{ route('admin.waste-types.edit', $item) }}" class="inline-flex items-center px-3 py-2 bg-blue-500 hover:bg-blue-600 text-white text-sm font-medium rounded-lg transition-colors">
                                                    <i class="bi bi-pencil-square mr-1"></i> Edit
                                                </a>
                                                <form action="{{ route('admin.waste-types.destroy', $item) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus jenis sampah ini?')" class="inline">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="inline-flex items-center px-3 py-2 bg-red-500 hover:bg-red-600 text-white text-sm font-medium rounded-lg transition-colors">
                                                        <i class="bi bi-trash mr-1"></i> Hapus
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <!-- Mobile Card View -->
                    <div class="md:hidden space-y-4">
                        @foreach($wasteTypes as $item)
                            <div class="bg-white rounded-xl shadow-md p-4 border border-gray-200">
                                <div class="flex items-start gap-3 mb-3">
                                    @if($item->image)
                                        <img src="{{ asset('images/' . $item->image) }}" alt="{{ $item->name }}" class="w-16 h-16 rounded-lg object-cover border border-gray-200">
                                    @else
                                        <div class="w-16 h-16 bg-gray-100 rounded-lg flex items-center justify-center">
                                            <i class="bi bi-recycle text-gray-400 text-2xl"></i>
                                        </div>
                                    @endif
                                    <div class="flex-1">
                                        @if($item->category == 'Plastik')
                                            <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-semibold bg-blue-100 text-blue-800 mb-2">
                                                {{ $item->category }}
                                            </span>
                                        @elseif($item->category == 'Kertas')
                                            <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-semibold bg-yellow-100 text-yellow-800 mb-2">
                                                {{ $item->category }}
                                            </span>
                                        @elseif($item->category == 'Logam')
                                            <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-semibold bg-gray-100 text-gray-800 mb-2">
                                                {{ $item->category }}
                                            </span>
                                        @elseif($item->category == 'Kaca')
                                            <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-semibold bg-green-100 text-green-800 mb-2">
                                                {{ $item->category }}
                                            </span>
                                        @elseif($item->category == 'Elektronik')
                                            <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-semibold bg-red-100 text-red-800 mb-2">
                                                {{ $item->category }}
                                            </span>
                                        @else
                                            <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-semibold bg-purple-100 text-purple-800 mb-2">
                                                {{ $item->category }}
                                            </span>
                                        @endif
                                        <h3 class="font-bold text-gray-900">{{ $item->name }}</h3>
                                        <p class="text-sm text-gray-600 mt-1">{{ strtoupper($item->unit) }} • <span class="text-green-600 font-bold">{{ number_format($item->points_per_unit, 0, ',', '.') }}</span> poin</p>
                                    </div>
                                </div>
                                <div class="flex gap-2">
                                    <a href="{{ route('admin.waste-types.edit', $item) }}" class="flex-1 text-center px-3 py-2 bg-blue-500 hover:bg-blue-600 text-white text-sm font-medium rounded-lg transition-colors">
                                        <i class="bi bi-pencil-square"></i> Edit
                                    </a>
                                    <form action="{{ route('admin.waste-types.destroy', $item) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus?')" class="flex-1">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="w-full px-3 py-2 bg-red-500 hover:bg-red-600 text-white text-sm font-medium rounded-lg transition-colors">
                                            <i class="bi bi-trash"></i> Hapus
                                        </button>
                                    </form>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    <!-- Pagination -->
                    <div class="mt-6">
                        {{ $wasteTypes->links() }}
                    </div>
                @endif
            </div>

            {{-- Modal for Tambah Jenis Sampah --}}
            <div x-show="showAddModal" x-cloak class="fixed inset-0 z-50 flex items-center justify-center">
                <div x-show="showAddModal" x-transition.opacity class="fixed inset-0 bg-black bg-opacity-50" x-on:click="closeAddModal()"></div>
                <div x-show="showAddModal" x-transition class="bg-white rounded-xl shadow-2xl w-full max-w-3xl mx-4 z-50 max-h-[90vh] overflow-y-auto">
                    <div class="p-6">
                        <h3 class="text-xl font-bold text-gray-800">Tambah Jenis Sampah</h3>
                        <p class="text-sm text-gray-500 mt-1">Tambahkan jenis sampah baru ke sistem</p>

                        <form id="addWasteForm" method="POST" action="{{ route('admin.waste-types.store') }}" enctype="multipart/form-data">
                            @csrf
                            <div class="mt-6 grid grid-cols-1 md:grid-cols-3 gap-6">
                                <div class="col-span-1">
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Upload Gambar</label>
                                    <div class="w-full h-48 bg-gray-50 rounded-lg flex items-center justify-center overflow-hidden border-2 border-dashed border-gray-300 hover:border-green-500 transition-colors cursor-pointer" x-on:click="$refs.addWasteImageInput.click()">
                                        <template x-if="addImagePreview">
                                            <img :src="addImagePreview" alt="preview" class="object-contain h-full w-full p-2" />
                                        </template>
                                        <template x-if="!addImagePreview">
                                            <div class="text-center">
                                                <i class="bi bi-cloud-upload text-6xl text-gray-300"></i>
                                                <p class="text-xs text-gray-400 mt-2">Klik untuk upload gambar</p>
                                                <p class="text-xs text-gray-300 mt-1">PNG, JPG, JPEG, GIF</p>
                                            </div>
                                        </template>
                                    </div>
                                    <input type="file" x-ref="addWasteImageInput" name="image" accept="image/*" class="hidden" x-on:change="handleAddImageUpload($event)" />
                                    <button type="button" x-show="addImagePreview" x-on:click="addImagePreview = null; $refs.addWasteImageInput.value = ''" class="mt-2 w-full px-3 py-1 text-xs bg-red-100 text-red-600 rounded hover:bg-red-200">
                                        Hapus Gambar
                                    </button>
                                </div>

                                <div class="col-span-2">
                                    <div class="space-y-4">
                                        <div>
                                            <label class="block text-sm font-medium text-gray-700 mb-1">Nama Jenis Sampah <span class="text-red-500">*</span></label>
                                            <input type="text" name="name" x-model="addForm.name" class="block w-full rounded-lg border border-gray-300 px-4 py-2 focus:outline-none focus:ring-2 focus:ring-green-500" placeholder="Contoh: Botol Plastik PET" required />
                                        </div>

                                        <div class="grid grid-cols-2 gap-4">
                                            <div>
                                                <label class="block text-sm font-medium text-gray-700 mb-1">Kategori <span class="text-red-500">*</span></label>
                                                <select name="category" x-model="addForm.category" class="block w-full rounded-lg border border-gray-300 px-4 py-2 focus:outline-none focus:ring-2 focus:ring-green-500" required>
                                                    <option value="">-- Pilih Kategori --</option>
                                                    <option value="Plastik">Plastik</option>
                                                    <option value="Kertas">Kertas</option>
                                                    <option value="Logam">Logam</option>
                                                    <option value="Kaca">Kaca</option>
                                                    <option value="Organik">Organik</option>
                                                    <option value="Elektronik">Elektronik</option>
                                                </select>
                                            </div>
                                            <div>
                                                <label class="block text-sm font-medium text-gray-700 mb-1">Satuan <span class="text-red-500">*</span></label>
                                                <select name="unit" x-model="addForm.unit" class="block w-full rounded-lg border border-gray-300 px-4 py-2 focus:outline-none focus:ring-2 focus:ring-green-500" required>
                                                    <option value="kg">kg (kilogram)</option>
                                                    <option value="pcs">pcs (pieces)</option>
                                                    <option value="liter">liter</option>
                                                </select>
                                            </div>
                                        </div>

                                        <div>
                                            <label class="block text-sm font-medium text-gray-700 mb-1">Poin per Satuan <span class="text-red-500">*</span></label>
                                            <input type="number" name="points_per_unit" x-model="addForm.points_per_unit" min="1" step="0.01" class="block w-full rounded-lg border border-gray-300 px-4 py-2 focus:outline-none focus:ring-2 focus:ring-green-500" placeholder="100" required />
                                        </div>

                                        <div>
                                            <label class="block text-sm font-medium text-gray-700 mb-1">Deskripsi</label>
                                            <textarea name="description" x-model="addForm.description" class="block w-full rounded-lg border border-gray-300 px-4 py-2 focus:outline-none focus:ring-2 focus:ring-green-500" rows="3" placeholder="Deskripsi jenis sampah..."></textarea>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="mt-6 flex justify-end gap-3">
                                <button type="button" class="px-6 py-2 bg-gray-200 hover:bg-gray-300 text-gray-800 rounded-lg font-medium transition-colors" x-on:click="closeAddModal">Batal</button>
                                <button type="submit" class="px-6 py-2 bg-green-600 hover:bg-green-700 text-white rounded-lg font-medium transition-colors">Tambahkan</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            {{-- Modal for Edit Jenis Sampah --}}
            <div x-show="showEditModal" x-cloak class="fixed inset-0 z-50 flex items-center justify-center">
                <div x-show="showEditModal" x-transition.opacity class="fixed inset-0 bg-black bg-opacity-50" x-on:click="closeEditModal()"></div>
                <div x-show="showEditModal" x-transition class="bg-white rounded-xl shadow-2xl w-full max-w-3xl mx-4 z-50 max-h-[90vh] overflow-y-auto">
                    <div class="p-6">
                        <h3 class="text-xl font-bold text-gray-800">Edit Jenis Sampah</h3>
                        <p class="text-sm text-gray-500 mt-1">Perbarui informasi jenis sampah</p>

                        <form :id="'editWasteForm'" :action="`/admin/waste-types/${editForm.id}`" method="POST" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')
                            <div class="mt-6 grid grid-cols-1 md:grid-cols-3 gap-6">
                                <div class="col-span-1">
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Upload Gambar</label>
                                    <div class="w-full h-48 bg-gray-50 rounded-lg flex items-center justify-center overflow-hidden border-2 border-dashed border-gray-300 hover:border-blue-500 transition-colors cursor-pointer" x-on:click="$refs.editWasteImageInput.click()">
                                        <template x-if="editImagePreview">
                                            <img :src="editImagePreview" alt="preview" class="object-contain h-full w-full p-2" />
                                        </template>
                                        <template x-if="!editImagePreview">
                                            <div class="text-center">
                                                <i class="bi bi-cloud-upload text-6xl text-gray-300"></i>
                                                <p class="text-xs text-gray-400 mt-2">Klik untuk upload gambar baru</p>
                                                <p class="text-xs text-gray-300 mt-1">PNG, JPG, JPEG, GIF</p>
                                            </div>
                                        </template>
                                    </div>
                                    <input type="file" x-ref="editWasteImageInput" name="image" accept="image/*" class="hidden" x-on:change="handleEditImageUpload($event)" />
                                    <button type="button" x-show="editImagePreview" x-on:click="editImagePreview = null; $refs.editWasteImageInput.value = ''" class="mt-2 w-full px-3 py-1 text-xs bg-red-100 text-red-600 rounded hover:bg-red-200">
                                        Hapus Gambar
                                    </button>
                                </div>

                                <div class="col-span-2">
                                    <div class="space-y-4">
                                        <div>
                                            <label class="block text-sm font-medium text-gray-700 mb-1">Nama Jenis Sampah <span class="text-red-500">*</span></label>
                                            <input type="text" name="name" x-model="editForm.name" class="block w-full rounded-lg border border-gray-300 px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500" required />
                                        </div>

                                        <div class="grid grid-cols-2 gap-4">
                                            <div>
                                                <label class="block text-sm font-medium text-gray-700 mb-1">Kategori <span class="text-red-500">*</span></label>
                                                <select name="category" x-model="editForm.category" class="block w-full rounded-lg border border-gray-300 px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500" required>
                                                    <option value="">-- Pilih Kategori --</option>
                                                    <option value="Plastik">Plastik</option>
                                                    <option value="Kertas">Kertas</option>
                                                    <option value="Logam">Logam</option>
                                                    <option value="Kaca">Kaca</option>
                                                    <option value="Organik">Organik</option>
                                                    <option value="Elektronik">Elektronik</option>
                                                </select>
                                            </div>
                                            <div>
                                                <label class="block text-sm font-medium text-gray-700 mb-1">Satuan <span class="text-red-500">*</span></label>
                                                <select name="unit" x-model="editForm.unit" class="block w-full rounded-lg border border-gray-300 px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500" required>
                                                    <option value="kg">kg (kilogram)</option>
                                                    <option value="pcs">pcs (pieces)</option>
                                                    <option value="liter">liter</option>
                                                </select>
                                            </div>
                                        </div>

                                        <div>
                                            <label class="block text-sm font-medium text-gray-700 mb-1">Poin per Satuan <span class="text-red-500">*</span></label>
                                            <input type="number" name="points_per_unit" x-model="editForm.points_per_unit" min="1" step="0.01" class="block w-full rounded-lg border border-gray-300 px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500" required />
                                        </div>

                                        <div>
                                            <label class="block text-sm font-medium text-gray-700 mb-1">Deskripsi</label>
                                            <textarea name="description" x-model="editForm.description" class="block w-full rounded-lg border border-gray-300 px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500" rows="3"></textarea>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="mt-6 flex justify-end gap-3">
                                <button type="button" class="px-6 py-2 bg-gray-200 hover:bg-gray-300 text-gray-800 rounded-lg font-medium transition-colors" x-on:click="closeEditModal">Batal</button>
                                <button type="submit" class="px-6 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg font-medium transition-colors">Simpan Perubahan</button>
                            </div>
                        </form>
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
                                <h3 class="text-lg font-bold text-gray-800">Hapus Jenis Sampah</h3>
                                <p class="text-sm text-gray-600 mt-1">Apakah Anda yakin ingin menghapus jenis sampah ini?</p>
                            </div>
                        </div>

                        <div class="mt-4 bg-gray-50 rounded-lg p-4">
                            <div class="font-semibold text-gray-800" x-text="deleteItem ? deleteItem.name : ''"></div>
                            <div class="text-sm text-gray-500 mt-1">
                                Kategori: <span class="font-medium" x-text="deleteItem ? deleteItem.category : ''"></span>
                            </div>
                            <div class="text-sm text-gray-500">
                                Poin: <span class="font-medium" x-text="deleteItem ? deleteItem.points_per_unit : 0"></span>/
                                <span x-text="deleteItem ? deleteItem.unit : ''"></span>
                            </div>
                        </div>

                        <p class="text-sm text-red-600 mt-4">
                            <i class="bi bi-info-circle"></i> Data yang dihapus tidak dapat dikembalikan!
                        </p>

                        <div class="mt-6 flex justify-end gap-3">
                            <button type="button" class="px-6 py-2 bg-gray-200 hover:bg-gray-300 text-gray-800 rounded-lg font-medium transition-colors" x-on:click="closeDeleteModal">Batal</button>
                            <button type="button" class="px-6 py-2 bg-red-600 hover:bg-red-700 text-white rounded-lg font-medium transition-colors" x-on:click="submitDelete()">
                                <i class="bi bi-trash"></i> Hapus
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
