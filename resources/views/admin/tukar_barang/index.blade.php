<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Manajemen Barang Tukar') }}
            </h2>
            <div class="flex items-center gap-3">
                <a href="#" class="inline-flex items-center gap-2 bg-white border border-gray-200 text-gray-700 px-3 py-2 rounded shadow-sm hover:bg-gray-50">
                    <!-- Export icon -->
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor"><path d="M3 3a1 1 0 000 2h10a1 1 0 100-2H3z"/><path d="M3 7a1 1 0 000 2h6a1 1 0 100-2H3z"/><path d="M3 11a1 1 0 000 2h4a1 1 0 100-2H3z"/></svg>
                    <span>Export</span>
                </a>

                <a href="#" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                    + Tambah Barang
                </a>
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
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

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <!-- Statistics cards -->
                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-5 gap-4 mb-6">
                        @php
                            $stats = [
                                ['label' => 'Total Barang', 'value' => 0],
                                ['label' => 'Aktif', 'value' => 0],
                                ['label' => 'Total Stok', 'value' => 0],
                                ['label' => 'Stok Menipis', 'value' => 0],
                                ['label' => 'Total Ditukar', 'value' => 0],
                            ];
                        @endphp

                        @foreach($stats as $stat)
                            <div class="p-4 rounded-lg border bg-white shadow-sm">
                                <div class="text-sm text-gray-500">{{ $stat['label'] }}</div>
                                <div class="mt-2 text-2xl font-bold text-gray-800">{{ $stat['value'] }}</div>
                            </div>
                        @endforeach
                    </div>

                    <!-- Search and filters -->
                    <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4 mb-6">
                        <div class="flex-1">
                            <input type="text" placeholder="Cari nama barang atau kategori..." class="w-full px-4 py-3 rounded border focus:outline-none focus:ring" />
                        </div>
                        <div class="flex items-center gap-3">
                            <select class="px-4 py-3 rounded border">
                                <option>Semua Status</option>
                                <option>Aktif</option>
                                <option>Nonaktif</option>
                            </select>
                        </div>
                    </div>

                    <!-- Product grid -->
                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                        @php
                            // If controller provided $items, use it. Otherwise create demo items to show layout.
                            if(!isset($items)) {
                                $items = collect(range(1,6))->map(function($i){
                                    return (object)[
                                        'id' => $i,
                                        'name' => 'Beras Premium 5 kg',
                                        'points' => 200,
                                        'stock' => 20,
                                        'image' => asset('images/tukar reward.png'),
                                    ];
                                });
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
                                            <button class="flex-1 bg-green-600 hover:bg-green-700 text-white py-2 rounded">Tambah Stok</button>
                                            <a href="#" class="flex-1 border border-gray-200 text-gray-700 py-2 rounded text-center">Lihat</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
