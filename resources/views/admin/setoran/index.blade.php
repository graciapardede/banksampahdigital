<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <div>
                <h2 class="font-semibold text-xl text-gray-800 leading-tight">{{ __('Manajemen Setoran') }}</h2>
                <p class="text-sm text-gray-500">Laporan aktivitas dan kinerja Cabang</p>
            </div>
            <div class="flex items-center gap-3">
                <select class="px-3 py-2 rounded border bg-white">
                    <option>Hari ini</option>
                    <option>Mingguan</option>
                    <option>Bulanan</option>
                </select>
                <a href="#" class="inline-flex items-center gap-2 bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded">
                    <!-- Export PDF -->
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor"><path d="M6 2a1 1 0 000 2h8a1 1 0 100-2H6z"/></svg>
                    <span>Export PDF</span>
                </a>
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            {{-- Top card: period & export --}}
            <div class="p-4 sm:p-6 bg-white shadow sm:rounded-lg">
                <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
                    <div class="flex-1">
                        <div class="text-sm text-gray-500">Laporan Cabang</div>
                        <div class="text-lg font-semibold text-gray-800">Laporan Aktivitas dan kinerja Cabang Sitoluama</div>
                    </div>
                    <div class="flex items-center gap-3">
                        <label class="text-sm text-gray-500">Periode</label>
                        <select class="px-3 py-2 rounded border bg-white">
                            <option>Hari ini</option>
                            <option>Mingguan</option>
                            <option>Bulanan</option>
                        </select>
                        <a href="#" class="inline-flex items-center gap-2 bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded ml-2">Export PDF</a>
                    </div>
                </div>
            </div>

            {{-- Stats cards --}}
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
                <div class="p-4 bg-white rounded shadow-sm">
                    <div class="text-sm text-gray-500">Total Setoran</div>
                    <div class="mt-2 text-2xl font-bold text-gray-800">12 <span class="text-xs text-gray-400">setoran</span></div>
                    <div class="text-xs text-gray-400 mt-1">45.8kg sampah</div>
                </div>

                <div class="p-4 bg-white rounded shadow-sm">
                    <div class="text-sm text-gray-500">Total Penukaran</div>
                    <div class="mt-2 text-2xl font-bold text-gray-800">8</div>
                    <div class="text-xs text-gray-400 mt-1">320 poin
                    </div>
                </div>

                <div class="p-4 bg-white rounded shadow-sm">
                    <div class="text-sm text-gray-500">Pengguna Aktif</div>
                    <div class="mt-2 text-2xl font-bold text-gray-800">15</div>
                    <div class="text-xs text-gray-400 mt-1">hari ini</div>
                </div>

                <div class="p-4 bg-white rounded shadow-sm">
                    <div class="text-sm text-gray-500">Net Poin</div>
                    <div class="mt-2 text-2xl font-bold text-gray-800">105</div>
                    <div class="text-xs text-gray-400 mt-1">Poin diberikan / ditukar</div>
                </div>
            </div>

            {{-- Mid row: composition and top users --}}
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-4">
                <div class="lg:col-span-2 p-4 bg-white rounded shadow-sm">
                    <div class="flex items-center justify-between mb-4">
                        <div>
                            <h3 class="text-gray-700 font-semibold">Komposisi Jenis Sampah</h3>
                            <p class="text-sm text-gray-500">Breakdown jenis sampah hari ini</p>
                        </div>
                    </div>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div class="p-4">
                            <!-- placeholder for chart -->
                            <div class="h-44 bg-gray-50 rounded flex items-center justify-center text-gray-400">[Chart placeholder]</div>
                        </div>
                        <div class="p-4">
                            <ul class="space-y-3">
                                <li class="flex items-center justify-between">
                                    <div class="flex items-center gap-3"><span class="w-3 h-3 rounded-full bg-green-500 inline-block"></span><span class="text-sm text-gray-700">Plastik</span></div>
                                    <div class="text-sm text-gray-500">18.5 kg</div>
                                </li>
                                <li class="flex items-center justify-between">
                                    <div class="flex items-center gap-3"><span class="w-3 h-3 rounded-full bg-blue-400 inline-block"></span><span class="text-sm text-gray-700">Kertas</span></div>
                                    <div class="text-sm text-gray-500">13.8 kg</div>
                                </li>
                                <li class="flex items-center justify-between">
                                    <div class="flex items-center gap-3"><span class="w-3 h-3 rounded-full bg-yellow-400 inline-block"></span><span class="text-sm text-gray-700">Logam</span></div>
                                    <div class="text-sm text-gray-500">9.2 kg</div>
                                </li>
                                <li class="flex items-center justify-between">
                                    <div class="flex items-center gap-3"><span class="w-3 h-3 rounded-full bg-purple-400 inline-block"></span><span class="text-sm text-gray-700">Kaca</span></div>
                                    <div class="text-sm text-gray-500">4.6 kg</div>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>

                <div class="p-4 bg-white rounded shadow-sm">
                    <h3 class="text-gray-700 font-semibold mb-3">Pengguna Teraktif</h3>
                    <ol class="space-y-3">
                        <li class="flex items-center justify-between"><div class="flex items-center gap-3"><span class="h-6 w-6 rounded-full bg-yellow-300 flex items-center justify-center">1</span><div><div class="font-medium">Sari Simanullang</div><div class="text-sm text-gray-400">5 Setoran</div></div></div></li>
                        <li class="flex items-center justify-between"><div class="flex items-center gap-3"><span class="h-6 w-6 rounded-full bg-gray-200 flex items-center justify-center">2</span><div><div class="font-medium">Binsar Hutabarat</div><div class="text-sm text-gray-400">4 Setoran</div></div></div></li>
                        <li class="flex items-center justify-between"><div class="flex items-center gap-3"><span class="h-6 w-6 rounded-full bg-gray-200 flex items-center justify-center">3</span><div><div class="font-medium">Maria Situmorang</div><div class="text-sm text-gray-400">3 Setoran</div></div></div></li>
                    </ol>
                </div>
            </div>

            {{-- Summary cards --}}
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <div class="p-4 bg-green-50 rounded shadow-sm">
                    <div class="text-sm text-gray-700">Sampah Terkumpul</div>
                    <div class="mt-2 text-2xl font-bold text-green-700">45.8kg</div>
                    <div class="text-xs text-green-600 mt-1">Target bulanan: 1000kg (5%)</div>
                </div>
                <div class="p-4 bg-blue-50 rounded shadow-sm">
                    <div class="text-sm text-gray-700">Point Diberikan</div>
                    <div class="mt-2 text-2xl font-bold text-blue-700">45.8kg</div>
                    <div class="text-xs text-blue-600 mt-1">Rata-rata: 35 poin/setoran</div>
                </div>
                <div class="p-4 bg-purple-50 rounded shadow-sm">
                    <div class="text-sm text-gray-700">Tingkat Penukaran</div>
                    <div class="mt-2 text-2xl font-bold text-purple-700">75%</div>
                    <div class="text-xs text-purple-600 mt-1">320 dari 425 poin</div>
                </div>
            </div>

            {{-- Info Cabang --}}
            <div class="p-4 bg-white rounded shadow-sm">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <h4 class="text-sm font-semibold text-gray-700">Detail Cabang</h4>
                        <div class="mt-3 text-sm text-gray-600 grid grid-cols-2 gap-2">
                            <div>Nama:</div><div class="font-medium">Cabang Sitoluama</div>
                            <div>Alamat:</div><div class="font-medium">Jl. Raya Sitoluama No. 123, Laguboti</div>
                            <div>Kontak:</div><div class="font-medium">+62 812-3456-7890</div>
                            <div>Status:</div><div class="font-medium">Aktif</div>
                        </div>
                    </div>
                    <div>
                        <h4 class="text-sm font-semibold text-gray-700">Periode Laporan</h4>
                        <div class="mt-3 text-sm text-gray-600 grid grid-cols-2 gap-2">
                            <div>Periode:</div><div class="font-medium">Hari ini</div>
                            <div>Tanggal:</div><div class="font-medium">{{ date('d/m/Y') }}</div>
                            <div>Dibuat oleh:</div><div class="font-medium">Admin Cabang</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
