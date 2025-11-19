<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Setoran - Green Saving Admin</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css" rel="stylesheet">
</head>
<body class="min-h-screen bg-gradient-to-br from-green-50 to-green-100 font-poppins">

    <!-- Header -->
    @include('admin.partials.header')

    <!-- Main Content -->
    <main class="max-w-5xl mx-auto px-4 py-8">
        
        <!-- Back Button -->
        <a href="{{ route('admin.setoran.index') }}" class="inline-flex items-center space-x-2 text-green-600 hover:text-green-700 mb-6 transition-colors">
            <i class="bi bi-arrow-left"></i>
            <span>Kembali ke Daftar Setoran</span>
        </a>

        <!-- Page Header -->
        <div class="bg-gradient-to-r from-green-500 to-emerald-600 rounded-2xl shadow-lg p-6 mb-6">
            <div class="flex items-center justify-between">
                <div class="flex items-center gap-4">
                    <div class="w-14 h-14 bg-white bg-opacity-20 backdrop-blur-sm rounded-xl flex items-center justify-center">
                        <i class="bi bi-receipt-cutoff text-3xl text-white"></i>
                    </div>
                    <div class="text-white">
                        <h2 class="font-bold text-2xl">Detail Setoran</h2>
                        <p class="text-green-50 text-sm mt-1">ID Transaksi: #{{ str_pad($deposit->id, 5, '0', STR_PAD_LEFT) }}</p>
                    </div>
                </div>
                <div>
                    @if($deposit->status == 'verified')
                        <span class="px-6 py-3 bg-green-100 text-green-700 rounded-xl font-bold text-sm flex items-center gap-2">
                            <i class="bi bi-check-circle-fill"></i>
                            Terverifikasi
                        </span>
                    @elseif($deposit->status == 'pending')
                        <span class="px-6 py-3 bg-yellow-100 text-yellow-700 rounded-xl font-bold text-sm flex items-center gap-2">
                            <i class="bi bi-clock-fill"></i>
                            Pending
                        </span>
                    @else
                        <span class="px-6 py-3 bg-red-100 text-red-700 rounded-xl font-bold text-sm flex items-center gap-2">
                            <i class="bi bi-x-circle-fill"></i>
                            Ditolak
                        </span>
                    @endif
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <!-- Left Column: Informasi Warga & Cabang -->
            <div class="lg:col-span-1 space-y-6">
                <!-- Info Warga -->
                <div class="bg-white rounded-2xl shadow-lg p-6">
                    <div class="flex items-center gap-3 mb-4">
                        <div class="w-10 h-10 bg-blue-100 rounded-xl flex items-center justify-center">
                            <i class="bi bi-person-circle text-blue-600 text-xl"></i>
                        </div>
                        <h3 class="font-bold text-lg text-gray-800">Informasi Warga</h3>
                    </div>
                    
                    <div class="space-y-3">
                        <div>
                            <p class="text-xs text-gray-500 mb-1">Nama Lengkap</p>
                            <p class="font-semibold text-gray-800">{{ $deposit->user->name }}</p>
                        </div>
                        <div>
                            <p class="text-xs text-gray-500 mb-1">Email</p>
                            <p class="text-sm text-gray-700">{{ $deposit->user->email }}</p>
                        </div>
                        <div>
                            <p class="text-xs text-gray-500 mb-1">No. Telepon</p>
                            <p class="text-sm text-gray-700">{{ $deposit->user->phone ?? '-' }}</p>
                        </div>
                        <div>
                            <p class="text-xs text-gray-500 mb-1">Saldo Poin Saat Ini</p>
                            <p class="text-xl font-bold text-green-600">
                                {{ number_format($deposit->user->balance_points ?? 0, 0, ',', '.') }} Poin
                            </p>
                        </div>
                    </div>
                </div>

                <!-- Info Cabang -->
                <div class="bg-white rounded-2xl shadow-lg p-6">
                    <div class="flex items-center gap-3 mb-4">
                        <div class="w-10 h-10 bg-green-100 rounded-xl flex items-center justify-center">
                            <i class="bi bi-building text-green-600 text-xl"></i>
                        </div>
                        <h3 class="font-bold text-lg text-gray-800">Lokasi Cabang</h3>
                    </div>
                    
                    <div class="space-y-3">
                        <div>
                            <p class="text-xs text-gray-500 mb-1">Nama Cabang</p>
                            <p class="font-semibold text-gray-800">{{ $deposit->branch->name ?? 'Tidak ada' }}</p>
                        </div>
                        <div>
                            <p class="text-xs text-gray-500 mb-1">Alamat</p>
                            <p class="text-sm text-gray-700">{{ $deposit->branch->address ?? '-' }}</p>
                        </div>
                        <div>
                            <p class="text-xs text-gray-500 mb-1">Tanggal Transaksi</p>
                            <p class="text-sm text-gray-700">{{ $deposit->created_at->format('d M Y, H:i') }} WIB</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Right Column: Detail Items & Total -->
            <div class="lg:col-span-2 space-y-6">
                <!-- Detail Item Sampah -->
                <div class="bg-white rounded-2xl shadow-lg p-6">
                    <div class="flex items-center gap-3 mb-6">
                        <div class="w-10 h-10 bg-purple-100 rounded-xl flex items-center justify-center">
                            <i class="bi bi-recycle text-purple-600 text-xl"></i>
                        </div>
                        <h3 class="font-bold text-lg text-gray-800">Detail Item Sampah</h3>
                    </div>

                    <div class="overflow-x-auto">
                        <table class="w-full">
                            <thead>
                                <tr class="border-b-2 border-gray-200">
                                    <th class="text-left py-3 px-4 text-xs font-bold text-gray-600 uppercase">Jenis Sampah</th>
                                    <th class="text-center py-3 px-4 text-xs font-bold text-gray-600 uppercase">Berat</th>
                                    <th class="text-center py-3 px-4 text-xs font-bold text-gray-600 uppercase">Poin/Unit</th>
                                    <th class="text-right py-3 px-4 text-xs font-bold text-gray-600 uppercase">Subtotal Poin</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($deposit->depositItems as $item)
                                <tr class="border-b border-gray-100 hover:bg-gray-50 transition-colors">
                                    <td class="py-4 px-4">
                                        <div class="flex items-center gap-3">
                                            <div class="w-10 h-10 bg-green-100 rounded-lg flex items-center justify-center">
                                                <i class="bi bi-trash text-green-600"></i>
                                            </div>
                                            <div>
                                                <p class="font-semibold text-gray-800">{{ $item->wasteType->name }}</p>
                                                <p class="text-xs text-gray-500">{{ $item->wasteType->category ?? 'Umum' }}</p>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="py-4 px-4 text-center">
                                        <span class="font-semibold text-gray-800">{{ number_format($item->weight, 1, ',', '.') }}</span>
                                        <span class="text-sm text-gray-500">{{ $item->wasteType->unit ?? 'kg' }}</span>
                                    </td>
                                    <td class="py-4 px-4 text-center">
                                        <span class="text-sm text-gray-600">{{ number_format($item->wasteType->points_per_unit ?? 0, 0, ',', '.') }}</span>
                                    </td>
                                    <td class="py-4 px-4 text-right">
                                        <span class="font-bold text-green-600">{{ number_format($item->points ?? 0, 0, ',', '.') }}</span>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- Total Summary -->
                <div class="bg-gradient-to-r from-green-500 to-emerald-600 rounded-2xl shadow-lg p-6">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center gap-4">
                            <div class="w-14 h-14 bg-white bg-opacity-20 backdrop-blur-sm rounded-xl flex items-center justify-center">
                                <i class="bi bi-star-fill text-white text-2xl"></i>
                            </div>
                            <div class="text-white">
                                <p class="text-sm opacity-90">Total Poin Diterima</p>
                                <p class="text-xs opacity-75 mt-1">Telah ditambahkan ke saldo warga</p>
                            </div>
                        </div>
                        <div class="text-right">
                            <p class="text-4xl font-bold text-white">{{ number_format($deposit->total_points ?? 0, 0, ',', '.') }}</p>
                            <p class="text-sm text-green-100 mt-1">Poin</p>
                        </div>
                    </div>
                </div>

                <!-- Print Button -->
                <div class="flex justify-end gap-3">
                    <button onclick="window.print()" class="px-6 py-3 bg-blue-500 hover:bg-blue-600 text-white rounded-xl font-semibold transition-colors flex items-center gap-2 shadow-lg">
                        <i class="bi bi-printer"></i>
                        <span>Cetak Struk</span>
                    </button>
                </div>
            </div>
        </div>
    </main>

    <!-- Print Styles -->
    <style>
        @media print {
            body {
                background: white;
            }
            header, .no-print {
                display: none !important;
            }
        }
    </style>

</body>
</html>
