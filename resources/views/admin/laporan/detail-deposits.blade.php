<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Setoran - Laporan Cabang</title>
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

    <!-- Main Content -->
    <main class="max-w-7xl mx-auto px-4 py-8">
        
        <!-- Header -->
        <div class="mb-6">
            <div class="flex items-center gap-4 mb-4">
                <a href="{{ route('admin.laporan.index', ['period' => $period, 'start_date' => request('start_date'), 'end_date' => request('end_date')]) }}" class="w-12 h-12 bg-white hover:bg-gray-100 rounded-xl flex items-center justify-center shadow-lg transition-all">
                    <i class="bi bi-arrow-left text-gray-700 text-xl"></i>
                </a>
                <div>
                    <h1 class="text-3xl font-bold text-gray-800 flex items-center">
                        <i class="bi bi-file-earmark-text mr-3 text-green-600"></i>
                        Detail Transaksi Setoran
                    </h1>
                    <p class="text-gray-600 mt-1">Periode: {{ $startDate->format('d M Y') }} - {{ $endDate->format('d M Y') }}</p>
                </div>
            </div>
        </div>

        <!-- Summary Card -->
        <div class="bg-gradient-to-r from-green-500 to-emerald-600 rounded-2xl p-6 mb-6 text-white shadow-lg">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-green-100 text-sm mb-1">Total Transaksi Setoran</p>
                    <h3 class="text-4xl font-bold">{{ $deposits->total() }}</h3>
                </div>
                <div class="bg-white bg-opacity-20 rounded-full p-4">
                    <i class="bi bi-recycle text-4xl"></i>
                </div>
            </div>
        </div>

        <!-- Table -->
        <div class="bg-white rounded-2xl shadow-lg overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead class="bg-gradient-to-r from-green-500 to-emerald-600 text-white">
                        <tr>
                            <th class="px-6 py-4 text-left text-sm font-bold">No</th>
                            <th class="px-6 py-4 text-left text-sm font-bold">Tanggal</th>
                            <th class="px-6 py-4 text-left text-sm font-bold">Warga</th>
                            <th class="px-6 py-4 text-left text-sm font-bold">Item Sampah</th>
                            <th class="px-6 py-4 text-right text-sm font-bold">Total Berat</th>
                            <th class="px-6 py-4 text-right text-sm font-bold">Total Poin</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        @forelse($deposits as $index => $deposit)
                        <tr class="hover:bg-green-50 transition-colors">
                            <td class="px-6 py-4 text-sm text-gray-700">
                                {{ ($deposits->currentPage() - 1) * $deposits->perPage() + $index + 1 }}
                            </td>
                            <td class="px-6 py-4 text-sm text-gray-700">
                                <div class="flex items-center space-x-2">
                                    <i class="bi bi-calendar-check text-green-600"></i>
                                    <span>{{ $deposit->created_at->format('d/m/Y H:i') }}</span>
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                <div>
                                    <p class="font-semibold text-gray-800">{{ $deposit->user->name }}</p>
                                    <p class="text-xs text-gray-500">{{ $deposit->user->phone }}</p>
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                <div class="space-y-1">
                                    @foreach($deposit->depositItems as $item)
                                    <div class="flex items-center gap-2 text-xs">
                                        <span class="px-2 py-1 bg-green-100 text-green-700 rounded-lg font-medium">
                                            {{ $item->wasteType->name }}
                                        </span>
                                        <span class="text-gray-600">{{ $item->weight }} kg</span>
                                    </div>
                                    @endforeach
                                </div>
                            </td>
                            <td class="px-6 py-4 text-right">
                                <span class="font-bold text-gray-800">
                                    {{ number_format($deposit->depositItems->sum('weight'), 2) }} kg
                                </span>
                            </td>
                            <td class="px-6 py-4 text-right">
                                <span class="px-3 py-1 bg-green-100 text-green-700 rounded-lg font-bold text-sm">
                                    {{ number_format($deposit->total_points) }} poin
                                </span>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="px-6 py-12 text-center text-gray-500">
                                <i class="bi bi-inbox text-5xl mb-3 block"></i>
                                <p class="text-lg">Tidak ada data setoran pada periode ini</p>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                    @if($deposits->total() > 0)
                    <tfoot class="bg-gray-50 border-t-2 border-gray-300">
                        <tr>
                            <td colspan="4" class="px-6 py-4 text-right font-bold text-gray-800">TOTAL:</td>
                            <td class="px-6 py-4 text-right font-bold text-gray-800">
                                {{ number_format($deposits->sum(function($d) { return $d->depositItems->sum('weight'); }), 2) }} kg
                            </td>
                            <td class="px-6 py-4 text-right font-bold text-green-700 text-lg">
                                {{ number_format($deposits->sum('total_points')) }} poin
                            </td>
                        </tr>
                    </tfoot>
                    @endif
                </table>
            </div>
        </div>

        <!-- Pagination -->
        @if($deposits->hasPages())
        <div class="mt-6">
            {{ $deposits->links() }}
        </div>
        @endif

    </main>

</body>
</html>
