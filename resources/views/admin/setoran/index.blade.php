<x-app-layout>
    <x-slot name="header">
        <div class="bg-gradient-to-r from-green-500 to-emerald-600 -mx-4 -my-3 px-4 py-6 sm:-mx-6 sm:px-6">
            <div class="flex flex-col md:flex-row md:justify-between md:items-center gap-4">
                <div class="text-white">
                    <div class="flex items-center gap-3 mb-2">
                        <div class="w-12 h-12 bg-white bg-opacity-20 backdrop-blur-sm rounded-xl flex items-center justify-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                            </svg>
                        </div>
                        <div>
                            <h2 class="font-bold text-2xl">{{ __('Manajemen Setoran') }}</h2>
                            <p class="text-sm text-green-100">Laporan aktivitas dan kinerja Cabang</p>
                        </div>
                    </div>
                </div>
                <div class="flex flex-wrap items-center gap-3">
                    <select class="px-4 py-2 rounded-xl border-2 border-white bg-white bg-opacity-90 backdrop-blur-sm text-gray-700 font-semibold shadow-lg hover:bg-opacity-100 transition-all">
                        <option>Hari ini</option>
                        <option>Mingguan</option>
                        <option>Bulanan</option>
                    </select>
                    <a href="#" class="inline-flex items-center gap-2 bg-white text-green-600 px-6 py-2 rounded-xl font-semibold shadow-lg hover:shadow-xl hover:scale-105 transition-all">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M3 17a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zm3.293-7.707a1 1 0 011.414 0L9 10.586V3a1 1 0 112 0v7.586l1.293-1.293a1 1 0 111.414 1.414l-3 3a1 1 0 01-1.414 0l-3-3a1 1 0 010-1.414z" clip-rule="evenodd" />
                        </svg>
                        <span>Export PDF</span>
                    </a>
                </div>
            </div>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            {{-- Branch Info Card with Gradient --}}
            <div class="bg-gradient-to-br from-green-50 to-emerald-50 border-2 border-green-200 rounded-2xl shadow-lg overflow-hidden">
                <div class="p-6">
                    <div class="flex items-start justify-between">
                        <div class="flex-1">
                            <div class="flex items-center gap-3 mb-2">
                                <div class="w-10 h-10 bg-gradient-to-br from-green-500 to-emerald-600 rounded-xl flex items-center justify-center shadow-md">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-white" viewBox="0 0 20 20" fill="currentColor">
                                        <path fill-rule="evenodd" d="M4 4a2 2 0 012-2h8a2 2 0 012 2v12a1 1 0 110 2h-3a1 1 0 01-1-1v-2a1 1 0 00-1-1H9a1 1 0 00-1 1v2a1 1 0 01-1 1H4a1 1 0 110-2V4zm3 1h2v2H7V5zm2 4H7v2h2V9zm2-4h2v2h-2V5zm2 4h-2v2h2V9z" clip-rule="evenodd" />
                                    </svg>
                                </div>
                                <div>
                                    <div class="text-sm font-medium text-green-600">Laporan Cabang</div>
                                    <div class="text-xl font-bold text-gray-800">Cabang Sitoluama</div>
                                </div>
                            </div>
                            <p class="text-sm text-gray-600 mt-2">Jl. Raya Sitoluama No. 123, Laguboti</p>
                        </div>
                        <div class="bg-white px-4 py-2 rounded-xl shadow-sm border-2 border-green-200">
                            <div class="text-xs text-gray-500">Status</div>
                            <div class="flex items-center gap-2 mt-1">
                                <div class="w-2 h-2 bg-green-500 rounded-full animate-pulse"></div>
                                <span class="font-semibold text-green-600">Aktif</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Stats cards with Icons & Gradients --}}
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
                <div class="bg-white rounded-2xl shadow-lg border-l-4 border-green-500 p-6 hover:shadow-xl transition-all">
                    <div class="flex items-center justify-between mb-3">
                        <div class="w-12 h-12 bg-gradient-to-br from-green-100 to-green-50 rounded-xl flex items-center justify-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-green-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12" />
                            </svg>
                        </div>
                        <span class="text-green-600 text-sm font-bold bg-green-50 px-3 py-1 rounded-full">+12%</span>
                    </div>
                    <div class="text-sm font-medium text-gray-500">Total Setoran</div>
                    <div class="mt-2 text-3xl font-bold text-gray-800">12</div>
                    <div class="text-xs text-gray-500 mt-1">45.8kg sampah terkumpul</div>
                </div>

                <div class="bg-white rounded-2xl shadow-lg border-l-4 border-emerald-500 p-6 hover:shadow-xl transition-all">
                    <div class="flex items-center justify-between mb-3">
                        <div class="w-12 h-12 bg-gradient-to-br from-emerald-100 to-emerald-50 rounded-xl flex items-center justify-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-emerald-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4" />
                            </svg>
                        </div>
                        <span class="text-emerald-600 text-sm font-bold bg-emerald-50 px-3 py-1 rounded-full">8 done</span>
                    </div>
                    <div class="text-sm font-medium text-gray-500">Total Penukaran</div>
                    <div class="mt-2 text-3xl font-bold text-gray-800">8</div>
                    <div class="text-xs text-gray-500 mt-1">320 poin ditukar</div>
                </div>

                <div class="bg-white rounded-2xl shadow-lg border-l-4 border-teal-500 p-6 hover:shadow-xl transition-all">
                    <div class="flex items-center justify-between mb-3">
                        <div class="w-12 h-12 bg-gradient-to-br from-teal-100 to-teal-50 rounded-xl flex items-center justify-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-teal-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                            </svg>
                        </div>
                        <span class="text-teal-600 text-sm font-bold bg-teal-50 px-3 py-1 rounded-full">+5 baru</span>
                    </div>
                    <div class="text-sm font-medium text-gray-500">Pengguna Aktif</div>
                    <div class="mt-2 text-3xl font-bold text-gray-800">15</div>
                    <div class="text-xs text-gray-500 mt-1">Aktif hari ini</div>
                </div>

                <div class="bg-white rounded-2xl shadow-lg border-l-4 border-lime-500 p-6 hover:shadow-xl transition-all">
                    <div class="flex items-center justify-between mb-3">
                        <div class="w-12 h-12 bg-gradient-to-br from-lime-100 to-lime-50 rounded-xl flex items-center justify-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-lime-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>
                        <span class="text-lime-600 text-sm font-bold bg-lime-50 px-3 py-1 rounded-full">Net</span>
                    </div>
                    <div class="text-sm font-medium text-gray-500">Net Poin</div>
                    <div class="mt-2 text-3xl font-bold text-gray-800">105</div>
                    <div class="text-xs text-gray-500 mt-1">Diberikan / Ditukar</div>
                </div>
            </div>

            {{-- Mid row: composition and top users --}}
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                <div class="lg:col-span-2 bg-white rounded-2xl shadow-lg p-6">
                    <div class="flex items-center justify-between mb-6">
                        <div>
                            <div class="flex items-center gap-3">
                                <div class="w-10 h-10 bg-gradient-to-br from-green-500 to-emerald-600 rounded-xl flex items-center justify-center shadow-md">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 3.055A9.001 9.001 0 1020.945 13H11V3.055z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.488 9H15V3.512A9.025 9.025 0 0120.488 9z" />
                                    </svg>
                                </div>
                                <div>
                                    <h3 class="text-lg font-bold text-gray-800">Komposisi Jenis Sampah</h3>
                                    <p class="text-sm text-gray-500">Breakdown jenis sampah hari ini</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="flex items-center justify-center">
                            <!-- placeholder for chart -->
                            <div class="w-48 h-48 bg-gradient-to-br from-green-50 to-emerald-50 rounded-full flex items-center justify-center text-gray-400 border-4 border-green-200 shadow-inner">
                                <div class="text-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-16 w-16 mx-auto text-green-500 mb-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 3.055A9.001 9.001 0 1020.945 13H11V3.055z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.488 9H15V3.512A9.025 9.025 0 0120.488 9z" />
                                    </svg>
                                    <div class="text-sm font-semibold text-green-600">Chart Area</div>
                                </div>
                            </div>
                        </div>
                        <div class="space-y-3">
                            <div class="bg-gradient-to-r from-green-50 to-green-100 p-4 rounded-xl border-l-4 border-green-500 hover:shadow-md transition-all">
                                <div class="flex items-center justify-between">
                                    <div class="flex items-center gap-3">
                                        <span class="w-4 h-4 rounded-full bg-green-500 shadow-md"></span>
                                        <span class="font-semibold text-gray-700">Plastik</span>
                                    </div>
                                    <div class="text-right">
                                        <div class="font-bold text-green-700">18.5 kg</div>
                                        <div class="text-xs text-green-600">40%</div>
                                    </div>
                                </div>
                            </div>
                            <div class="bg-gradient-to-r from-emerald-50 to-emerald-100 p-4 rounded-xl border-l-4 border-emerald-500 hover:shadow-md transition-all">
                                <div class="flex items-center justify-between">
                                    <div class="flex items-center gap-3">
                                        <span class="w-4 h-4 rounded-full bg-emerald-500 shadow-md"></span>
                                        <span class="font-semibold text-gray-700">Kertas</span>
                                    </div>
                                    <div class="text-right">
                                        <div class="font-bold text-emerald-700">13.8 kg</div>
                                        <div class="text-xs text-emerald-600">30%</div>
                                    </div>
                                </div>
                            </div>
                            <div class="bg-gradient-to-r from-teal-50 to-teal-100 p-4 rounded-xl border-l-4 border-teal-500 hover:shadow-md transition-all">
                                <div class="flex items-center justify-between">
                                    <div class="flex items-center gap-3">
                                        <span class="w-4 h-4 rounded-full bg-teal-500 shadow-md"></span>
                                        <span class="font-semibold text-gray-700">Logam</span>
                                    </div>
                                    <div class="text-right">
                                        <div class="font-bold text-teal-700">9.2 kg</div>
                                        <div class="text-xs text-teal-600">20%</div>
                                    </div>
                                </div>
                            </div>
                            <div class="bg-gradient-to-r from-lime-50 to-lime-100 p-4 rounded-xl border-l-4 border-lime-500 hover:shadow-md transition-all">
                                <div class="flex items-center justify-between">
                                    <div class="flex items-center gap-3">
                                        <span class="w-4 h-4 rounded-full bg-lime-500 shadow-md"></span>
                                        <span class="font-semibold text-gray-700">Kaca</span>
                                    </div>
                                    <div class="text-right">
                                        <div class="font-bold text-lime-700">4.6 kg</div>
                                        <div class="text-xs text-lime-600">10%</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="bg-white rounded-2xl shadow-lg p-6">
                    <div class="flex items-center gap-3 mb-6">
                        <div class="w-10 h-10 bg-gradient-to-br from-yellow-400 to-orange-400 rounded-xl flex items-center justify-center shadow-md">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z" />
                            </svg>
                        </div>
                        <h3 class="text-lg font-bold text-gray-800">Top Kontributor</h3>
                    </div>
                    <div class="space-y-3">
                        <div class="bg-gradient-to-r from-yellow-50 to-orange-50 p-4 rounded-xl border-2 border-yellow-300 shadow-sm">
                            <div class="flex items-center gap-3">
                                <div class="w-10 h-10 bg-gradient-to-br from-yellow-400 to-orange-400 rounded-full flex items-center justify-center text-white font-bold shadow-md">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                        <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                    </svg>
                                </div>
                                <div class="flex-1">
                                    <div class="font-bold text-gray-800">Sari Simanullang</div>
                                    <div class="text-sm text-yellow-600 font-semibold">5 Setoran • 125 Poin</div>
                                </div>
                            </div>
                        </div>
                        <div class="bg-gradient-to-r from-gray-50 to-gray-100 p-4 rounded-xl border border-gray-200">
                            <div class="flex items-center gap-3">
                                <div class="w-10 h-10 bg-gradient-to-br from-gray-300 to-gray-400 rounded-full flex items-center justify-center text-white font-bold shadow-sm">2</div>
                                <div class="flex-1">
                                    <div class="font-semibold text-gray-800">Binsar Hutabarat</div>
                                    <div class="text-sm text-gray-600">4 Setoran • 98 Poin</div>
                                </div>
                            </div>
                        </div>
                        <div class="bg-gradient-to-r from-orange-50 to-yellow-50 p-4 rounded-xl border border-orange-200">
                            <div class="flex items-center gap-3">
                                <div class="w-10 h-10 bg-gradient-to-br from-orange-300 to-yellow-400 rounded-full flex items-center justify-center text-white font-bold shadow-sm">3</div>
                                <div class="flex-1">
                                    <div class="font-semibold text-gray-800">Maria Situmorang</div>
                                    <div class="text-sm text-gray-600">3 Setoran • 72 Poin</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Summary cards with Progress --}}
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <div class="bg-gradient-to-br from-green-500 to-emerald-600 rounded-2xl p-6 text-white shadow-lg hover:shadow-xl transition-all">
                    <div class="flex items-center justify-between mb-4">
                        <div class="w-12 h-12 bg-white bg-opacity-20 backdrop-blur-sm rounded-xl flex items-center justify-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 6l3 1m0 0l-3 9a5.002 5.002 0 006.001 0M6 7l3 9M6 7l6-2m6 2l3-1m-3 1l-3 9a5.002 5.002 0 006.001 0M18 7l3 9m-3-9l-6-2m0-2v2m0 16V5m0 16H9m3 0h3" />
                            </svg>
                        </div>
                        <span class="text-xs font-semibold bg-white bg-opacity-20 px-3 py-1 rounded-full">Hari Ini</span>
                    </div>
                    <div class="text-sm font-medium opacity-90 mb-2">Sampah Terkumpul</div>
                    <div class="text-4xl font-bold mb-3">45.8<span class="text-xl">kg</span></div>
                    <div class="bg-white bg-opacity-20 rounded-full h-2 mb-2">
                        <div class="bg-white h-2 rounded-full" style="width: 5%"></div>
                    </div>
                    <div class="text-xs opacity-90">Target bulanan: 1000kg (5%)</div>
                </div>

                <div class="bg-gradient-to-br from-teal-500 to-cyan-600 rounded-2xl p-6 text-white shadow-lg hover:shadow-xl transition-all">
                    <div class="flex items-center justify-between mb-4">
                        <div class="w-12 h-12 bg-white bg-opacity-20 backdrop-blur-sm rounded-xl flex items-center justify-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>
                        <span class="text-xs font-semibold bg-white bg-opacity-20 px-3 py-1 rounded-full">425 Total</span>
                    </div>
                    <div class="text-sm font-medium opacity-90 mb-2">Poin Diberikan</div>
                    <div class="text-4xl font-bold mb-3">425<span class="text-xl">pt</span></div>
                    <div class="flex items-center gap-2 text-xs opacity-90">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6" />
                        </svg>
                        <span>Rata-rata: 35 poin/setoran</span>
                    </div>
                </div>

                <div class="bg-gradient-to-br from-lime-500 to-green-600 rounded-2xl p-6 text-white shadow-lg hover:shadow-xl transition-all">
                    <div class="flex items-center justify-between mb-4">
                        <div class="w-12 h-12 bg-white bg-opacity-20 backdrop-blur-sm rounded-xl flex items-center justify-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                            </svg>
                        </div>
                        <span class="text-xs font-semibold bg-white bg-opacity-20 px-3 py-1 rounded-full">Tinggi</span>
                    </div>
                    <div class="text-sm font-medium opacity-90 mb-2">Tingkat Penukaran</div>
                    <div class="text-4xl font-bold mb-3">75<span class="text-xl">%</span></div>
                    <div class="bg-white bg-opacity-20 rounded-full h-2 mb-2">
                        <div class="bg-white h-2 rounded-full" style="width: 75%"></div>
                    </div>
                    <div class="text-xs opacity-90">320 dari 425 poin ditukar</div>
                </div>
            </div>

            {{-- Info Cabang with Better Layout --}}
            <div class="bg-white rounded-2xl shadow-lg overflow-hidden">
                <div class="bg-gradient-to-r from-green-500 to-emerald-600 px-6 py-4">
                    <h3 class="text-lg font-bold text-white flex items-center gap-2">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd" />
                        </svg>
                        Informasi Detail
                    </h3>
                </div>
                <div class="p-6">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                        <div>
                            <div class="flex items-center gap-2 mb-4">
                                <div class="w-8 h-8 bg-green-100 rounded-lg flex items-center justify-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-green-600" viewBox="0 0 20 20" fill="currentColor">
                                        <path fill-rule="evenodd" d="M4 4a2 2 0 012-2h8a2 2 0 012 2v12a1 1 0 110 2h-3a1 1 0 01-1-1v-2a1 1 0 00-1-1H9a1 1 0 00-1 1v2a1 1 0 01-1 1H4a1 1 0 110-2V4zm3 1h2v2H7V5zm2 4H7v2h2V9zm2-4h2v2h-2V5zm2 4h-2v2h2V9z" clip-rule="evenodd" />
                                    </svg>
                                </div>
                                <h4 class="font-bold text-gray-800">Detail Cabang</h4>
                            </div>
                            <div class="space-y-3">
                                <div class="flex items-start gap-3 p-3 bg-gray-50 rounded-xl">
                                    <div class="text-sm text-gray-500 w-24 font-medium">Nama:</div>
                                    <div class="text-sm font-semibold text-gray-800 flex-1">Cabang Sitoluama</div>
                                </div>
                                <div class="flex items-start gap-3 p-3 bg-gray-50 rounded-xl">
                                    <div class="text-sm text-gray-500 w-24 font-medium">Alamat:</div>
                                    <div class="text-sm font-semibold text-gray-800 flex-1">Jl. Raya Sitoluama No. 123, Laguboti</div>
                                </div>
                                <div class="flex items-start gap-3 p-3 bg-gray-50 rounded-xl">
                                    <div class="text-sm text-gray-500 w-24 font-medium">Kontak:</div>
                                    <div class="text-sm font-semibold text-gray-800 flex-1">+62 812-3456-7890</div>
                                </div>
                                <div class="flex items-start gap-3 p-3 bg-green-50 rounded-xl border-2 border-green-200">
                                    <div class="text-sm text-gray-500 w-24 font-medium">Status:</div>
                                    <div class="flex items-center gap-2">
                                        <div class="w-2 h-2 bg-green-500 rounded-full animate-pulse"></div>
                                        <span class="text-sm font-bold text-green-600">Aktif</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div>
                            <div class="flex items-center gap-2 mb-4">
                                <div class="w-8 h-8 bg-emerald-100 rounded-lg flex items-center justify-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-emerald-600" viewBox="0 0 20 20" fill="currentColor">
                                        <path fill-rule="evenodd" d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 000 2h8a1 1 0 100-2H6z" clip-rule="evenodd" />
                                    </svg>
                                </div>
                                <h4 class="font-bold text-gray-800">Periode Laporan</h4>
                            </div>
                            <div class="space-y-3">
                                <div class="flex items-start gap-3 p-3 bg-gray-50 rounded-xl">
                                    <div class="text-sm text-gray-500 w-28 font-medium">Periode:</div>
                                    <div class="text-sm font-semibold text-gray-800 flex-1">Hari ini</div>
                                </div>
                                <div class="flex items-start gap-3 p-3 bg-gray-50 rounded-xl">
                                    <div class="text-sm text-gray-500 w-28 font-medium">Tanggal:</div>
                                    <div class="text-sm font-semibold text-gray-800 flex-1">{{ date('d/m/Y') }}</div>
                                </div>
                                <div class="flex items-start gap-3 p-3 bg-gray-50 rounded-xl">
                                    <div class="text-sm text-gray-500 w-28 font-medium">Dibuat oleh:</div>
                                    <div class="text-sm font-semibold text-gray-800 flex-1">{{ Auth::user()->name }}</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
