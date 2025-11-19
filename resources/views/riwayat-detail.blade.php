<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Transaksi #{{ $transaction->id }} - Green Saving</title>
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
    <header class="bg-white shadow-sm">
        <div class="max-w-6xl mx-auto px-4 py-6">
            <div class="flex justify-between items-center">
                <!-- Logo -->
                <div class="flex items-center space-x-3">
                    <div class="w-12 h-12 bg-gradient-to-br from-green-500 to-green-600 rounded-xl flex items-center justify-center shadow-lg">
                        <i class="bi bi-recycle text-white text-2xl"></i>
                    </div>
                    <div>
                        <h1 class="font-bold text-xl text-gray-800">Green Saving</h1>
                        <p class="text-sm text-green-600">Detail Transaksi</p>
                    </div>
                </div>

                <!-- Back Button -->
                <a href="{{ route('riwayat') }}" class="px-6 py-2 bg-gray-100 hover:bg-gray-200 text-gray-700 rounded-xl font-semibold transition-colors flex items-center space-x-2">
                    <i class="bi bi-arrow-left"></i>
                    <span>Kembali</span>
                </a>
            </div>
        </div>
    </header>

    <!-- Main Content -->
    <main class="max-w-4xl mx-auto px-4 py-8">
        
        <!-- Transaction Header Card -->
        <div class="bg-white rounded-2xl p-6 shadow-lg mb-6">
            <div class="flex items-center justify-between mb-6">
                <div class="flex items-center space-x-4">
                    <div class="w-16 h-16 bg-{{ $type === 'deposit' ? 'green' : 'blue' }}-100 rounded-2xl flex items-center justify-center">
                        @if($type === 'deposit')
                            <i class="bi bi-arrow-up-right text-green-600 text-3xl font-bold"></i>
                        @else
                            <i class="bi bi-arrow-down-left text-blue-600 text-3xl font-bold"></i>
                        @endif
                    </div>
                    <div>
                        <h2 class="text-2xl font-bold text-gray-800 flex items-center gap-2">
                            <i class="bi bi-{{ $type === 'deposit' ? 'recycle' : 'gift' }} text-{{ $type === 'deposit' ? 'green' : 'blue' }}-600"></i>
                            {{ $type === 'deposit' ? 'Setoran Sampah' : 'Penukaran Poin' }}
                        </h2>
                        <p class="text-gray-600 text-sm mt-1">ID Transaksi: #{{ $transaction->id }}</p>
                    </div>
                </div>

                <!-- Status Badge -->
                @if($transaction->status === 'verified' || $transaction->status === 'completed')
                    <span class="px-4 py-2 bg-green-100 text-green-700 rounded-full text-sm font-bold flex items-center gap-2">
                        <i class="bi bi-check-circle-fill"></i>
                        Selesai
                    </span>
                @elseif($transaction->status === 'confirmed')
                    <span class="px-4 py-2 bg-blue-100 text-blue-700 rounded-full text-sm font-bold flex items-center gap-2">
                        <i class="bi bi-check-circle"></i>
                        Siap Ambil
                    </span>
                @elseif($transaction->status === 'pending')
                    <span class="px-4 py-2 bg-yellow-100 text-yellow-700 rounded-full text-sm font-bold flex items-center gap-2">
                        <i class="bi bi-clock"></i>
                        Menunggu
                    </span>
                @elseif($transaction->status === 'rejected')
                    <span class="px-4 py-2 bg-red-100 text-red-700 rounded-full text-sm font-bold flex items-center gap-2">
                        <i class="bi bi-x-circle"></i>
                        Ditolak
                    </span>
                @elseif($transaction->status === 'cancelled')
                    <span class="px-4 py-2 bg-gray-100 text-gray-700 rounded-full text-sm font-bold flex items-center gap-2">
                        <i class="bi bi-slash-circle"></i>
                        Dibatalkan
                    </span>
                @endif
            </div>

            <!-- Transaction Info Grid -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 p-6 bg-gradient-to-br from-gray-50 to-gray-100 rounded-xl">
                <div>
                    <p class="text-sm text-gray-600 mb-1 flex items-center gap-1">
                        <i class="bi bi-calendar3"></i>
                        Tanggal
                    </p>
                    <p class="text-lg font-bold text-gray-800">{{ $transaction->created_at->format('d M Y') }}</p>
                    <p class="text-sm text-gray-500">{{ $transaction->created_at->format('H:i') }} WIB</p>
                </div>

                @if($type === 'deposit')
                <div>
                    <p class="text-sm text-gray-600 mb-1 flex items-center gap-1">
                        <i class="bi bi-box-seam"></i>
                        Total Berat
                    </p>
                    <p class="text-lg font-bold text-gray-800">{{ number_format($transaction->total_weight, 2) }} kg</p>
                    <p class="text-sm text-gray-500">{{ $transaction->depositItems->count() }} jenis sampah</p>
                </div>
                @else
                <div>
                    <p class="text-sm text-gray-600 mb-1 flex items-center gap-1">
                        <i class="bi bi-gift"></i>
                        Total Item
                    </p>
                    <p class="text-lg font-bold text-gray-800">{{ $transaction->redemptionItems->sum('quantity') }} pcs</p>
                    <p class="text-sm text-gray-500">{{ $transaction->redemptionItems->count() }} jenis barang</p>
                </div>
                @endif

                <div>
                    <p class="text-sm text-gray-600 mb-1 flex items-center gap-1">
                        <i class="bi bi-coin"></i>
                        Total Poin
                    </p>
                    <p class="text-2xl font-bold {{ $type === 'deposit' ? 'text-green-600' : 'text-red-600' }}">
                        {{ $type === 'deposit' ? '+' : '-' }}{{ number_format($transaction->total_points, 0, ',', '.') }}
                    </p>
                </div>
            </div>
        </div>

        <!-- Detail Items -->
        @if($type === 'deposit')
            <!-- Deposit Items Table -->
            <div class="bg-white rounded-2xl p-6 shadow-lg">
                <h3 class="text-xl font-bold text-gray-800 mb-4 flex items-center gap-2">
                    <i class="bi bi-list-ul text-green-600"></i>
                    Detail Sampah yang Disetor
                </h3>

                <div class="overflow-x-auto">
                    <table class="w-full">
                        <thead class="bg-green-50">
                            <tr>
                                <th class="px-4 py-3 text-left text-sm font-semibold text-gray-700">No</th>
                                <th class="px-4 py-3 text-left text-sm font-semibold text-gray-700">Jenis Sampah</th>
                                <th class="px-4 py-3 text-center text-sm font-semibold text-gray-700">Berat (kg)</th>
                                <th class="px-4 py-3 text-right text-sm font-semibold text-gray-700">Poin/kg</th>
                                <th class="px-4 py-3 text-right text-sm font-semibold text-gray-700">Subtotal Poin</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200">
                            @foreach($transaction->depositItems as $index => $item)
                            <tr class="hover:bg-gray-50 transition-colors">
                                <td class="px-4 py-4 text-sm text-gray-800">{{ $index + 1 }}</td>
                                <td class="px-4 py-4">
                                    <div class="flex items-center gap-2">
                                        <div class="w-8 h-8 bg-green-100 rounded-lg flex items-center justify-center">
                                            <i class="bi bi-recycle text-green-600 text-sm"></i>
                                        </div>
                                        <div>
                                            <p class="text-sm font-semibold text-gray-800">{{ $item->wasteType->name ?? 'Unknown' }}</p>
                                            <p class="text-xs text-gray-500">{{ $item->wasteType->category ?? '-' }}</p>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-4 py-4 text-center">
                                    <span class="px-3 py-1 bg-blue-50 text-blue-700 rounded-full text-sm font-semibold">
                                        {{ number_format($item->weight, 2) }} kg
                                    </span>
                                </td>
                                <td class="px-4 py-4 text-right text-sm text-gray-700">
                                    {{ number_format($item->wasteType->points_per_kg ?? 0, 0, ',', '.') }}
                                </td>
                                <td class="px-4 py-4 text-right">
                                    <span class="text-sm font-bold text-green-600">
                                        +{{ number_format($item->points, 0, ',', '.') }}
                                    </span>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                        <tfoot class="bg-green-50">
                            <tr>
                                <td colspan="4" class="px-4 py-4 text-right font-bold text-gray-800">TOTAL POIN:</td>
                                <td class="px-4 py-4 text-right">
                                    <span class="text-xl font-bold text-green-600">
                                        +{{ number_format($transaction->total_points, 0, ',', '.') }}
                                    </span>
                                </td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        @else
            <!-- Redemption Items Table -->
            <div class="bg-white rounded-2xl p-6 shadow-lg">
                <h3 class="text-xl font-bold text-gray-800 mb-4 flex items-center gap-2">
                    <i class="bi bi-list-ul text-blue-600"></i>
                    Detail Barang yang Ditukar
                </h3>

                <div class="overflow-x-auto">
                    <table class="w-full">
                        <thead class="bg-blue-50">
                            <tr>
                                <th class="px-4 py-3 text-left text-sm font-semibold text-gray-700">No</th>
                                <th class="px-4 py-3 text-left text-sm font-semibold text-gray-700">Nama Barang</th>
                                <th class="px-4 py-3 text-center text-sm font-semibold text-gray-700">Jumlah</th>
                                <th class="px-4 py-3 text-right text-sm font-semibold text-gray-700">Poin/Item</th>
                                <th class="px-4 py-3 text-right text-sm font-semibold text-gray-700">Subtotal Poin</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200">
                            @foreach($transaction->redemptionItems as $index => $item)
                            <tr class="hover:bg-gray-50 transition-colors">
                                <td class="px-4 py-4 text-sm text-gray-800">{{ $index + 1 }}</td>
                                <td class="px-4 py-4">
                                    <div class="flex items-center gap-2">
                                        <div class="w-8 h-8 bg-blue-100 rounded-lg flex items-center justify-center">
                                            <i class="bi bi-gift text-blue-600 text-sm"></i>
                                        </div>
                                        <p class="text-sm font-semibold text-gray-800">{{ $item->rewardItem->name ?? 'Unknown' }}</p>
                                    </div>
                                </td>
                                <td class="px-4 py-4 text-center">
                                    <span class="px-3 py-1 bg-green-50 text-green-700 rounded-full text-sm font-semibold">
                                        {{ $item->quantity }} pcs
                                    </span>
                                </td>
                                <td class="px-4 py-4 text-right text-sm text-gray-700">
                                    {{ number_format($item->points, 0, ',', '.') }}
                                </td>
                                <td class="px-4 py-4 text-right">
                                    <span class="text-sm font-bold text-red-600">
                                        -{{ number_format($item->points * $item->quantity, 0, ',', '.') }}
                                    </span>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                        <tfoot class="bg-blue-50">
                            <tr>
                                <td colspan="4" class="px-4 py-4 text-right font-bold text-gray-800">TOTAL POIN:</td>
                                <td class="px-4 py-4 text-right">
                                    <span class="text-xl font-bold text-red-600">
                                        -{{ number_format($transaction->total_points, 0, ',', '.') }}
                                    </span>
                                </td>
                            </tr>
                        </tfoot>
                    </table>
                </div>

                <!-- Pickup Location Info -->
                @if($transaction->branch)
                <div class="mt-6 p-4 bg-blue-50 rounded-xl border-2 border-blue-200">
                    <h4 class="font-bold text-gray-800 mb-2 flex items-center gap-2">
                        <i class="bi bi-geo-alt-fill text-blue-600"></i>
                        Lokasi Pengambilan
                    </h4>
                    <p class="text-gray-700">{{ $transaction->branch->name }}</p>
                    @if($transaction->branch->address)
                        <p class="text-sm text-gray-600 mt-1">{{ $transaction->branch->address }}</p>
                    @endif
                </div>
                @endif
            </div>
        @endif

        <!-- Action Buttons -->
        <div class="mt-6 flex justify-center space-x-3">
            <a href="{{ route('riwayat') }}" class="px-8 py-3 bg-gray-100 hover:bg-gray-200 text-gray-700 rounded-xl font-semibold transition-colors flex items-center space-x-2">
                <i class="bi bi-arrow-left"></i>
                <span>Kembali ke Riwayat</span>
            </a>
            
            <a href="{{ route('dashboard') }}" class="px-8 py-3 bg-green-500 hover:bg-green-600 text-white rounded-xl font-semibold transition-colors flex items-center space-x-2">
                <i class="bi bi-house-door"></i>
                <span>Ke Dashboard</span>
            </a>
        </div>

    </main>

    <!-- Footer -->
    <footer class="bg-gradient-to-r from-green-50 to-emerald-50 py-8 mt-12 border-t border-green-200">
        <div class="max-w-6xl mx-auto px-4">
            <div class="flex flex-col items-center gap-4">
                <div class="w-16 h-16 bg-gradient-to-br from-green-500 to-green-600 rounded-2xl flex items-center justify-center shadow-lg">
                    <i class="bi bi-recycle text-white text-3xl"></i>
                </div>
                <h3 class="text-xl font-bold text-green-600">Green Saving</h3>
                <p class="text-sm text-gray-600 text-center">
                    Bersama menjaga lingkungan untuk masa depan lebih baik
                </p>
                <p class="text-sm text-gray-500">© 2025 Green Saving. All rights reserved.</p>
            </div>
        </div>
    </footer>

</body>
</html>
