<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Penukaran #{{ $redemption->id }} - Green Saving</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
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

<div class="container mx-auto px-4 py-6 max-w-7xl">
    <!-- Header -->
    <div class="flex justify-between items-center mb-6">
        <div>
            <h1 class="text-3xl font-bold text-gray-800">Detail Permintaan Penukaran #{{ $redemption->id }}</h1>
            <p class="text-gray-600 mt-1">{{ \Carbon\Carbon::parse($redemption->created_at)->format('d F Y, H:i') }} WIB</p>
        </div>
        <div class="flex items-center gap-3">
            @if($redemption->status === 'pending')
                <span class="px-4 py-2 bg-yellow-100 text-yellow-800 rounded-lg font-semibold">
                    <i class="fas fa-clock mr-1"></i> Pending
                </span>
            @elseif($redemption->status === 'confirmed')
                <span class="px-4 py-2 bg-blue-100 text-blue-800 rounded-lg font-semibold">
                    <i class="fas fa-check-circle mr-1"></i> Confirmed
                </span>
            @elseif($redemption->status === 'completed')
                <span class="px-4 py-2 bg-green-100 text-green-800 rounded-lg font-semibold">
                    <i class="fas fa-check-double mr-1"></i> Completed
                </span>
            @elseif($redemption->status === 'cancelled')
                <span class="px-4 py-2 bg-red-100 text-red-800 rounded-lg font-semibold">
                    <i class="fas fa-times-circle mr-1"></i> Cancelled
                </span>
            @endif
            <a href="{{ route('admin.penukaran.index') }}" class="px-4 py-2 bg-gray-500 hover:bg-gray-600 text-white rounded-lg transition duration-200">
                <i class="fas fa-arrow-left mr-1"></i> Kembali
            </a>
        </div>
    </div>

    <!-- Info Warga & Lokasi -->
    <div class="bg-white rounded-lg shadow-md p-6 mb-6">
        <h2 class="text-xl font-bold text-gray-800 mb-4 border-b pb-2">
            <i class="fas fa-user-circle text-blue-600 mr-2"></i>Informasi Warga
        </h2>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <div class="mb-4">
                    <label class="text-sm font-semibold text-gray-600 block mb-1">Nama Warga</label>
                    <p class="text-lg text-gray-800">{{ $redemption->user->name }}</p>
                </div>
                <div class="mb-4">
                    <label class="text-sm font-semibold text-gray-600 block mb-1">Email</label>
                    <p class="text-gray-800">
                        <i class="fas fa-envelope text-gray-500 mr-2"></i>{{ $redemption->user->email }}
                    </p>
                </div>
                <div class="mb-4">
                    <label class="text-sm font-semibold text-gray-600 block mb-1">No. Telepon</label>
                    <p class="text-gray-800">
                        <i class="fas fa-phone text-gray-500 mr-2"></i>{{ $redemption->user->phone ?? '-' }}
                    </p>
                </div>
            </div>
            <div>
                <div class="mb-4">
                    <label class="text-sm font-semibold text-gray-600 block mb-1">Lokasi Pengambilan</label>
                    <p class="text-lg text-gray-800">
                        <i class="fas fa-map-marker-alt text-red-500 mr-2"></i>{{ $redemption->branch->name ?? 'Belum ditentukan' }}
                    </p>
                    <p class="text-sm text-gray-600 mt-1">{{ $redemption->branch->address ?? '' }}</p>
                </div>
                <div class="mb-4">
                    <label class="text-sm font-semibold text-gray-600 block mb-1">Total Poin Transaksi</label>
                    <p class="text-2xl font-bold text-green-600">
                        <i class="fas fa-coins mr-2"></i>{{ number_format($redemption->total_points, 0, ',', '.') }} Poin
                    </p>
                </div>
                <div class="mb-4">
                    <label class="text-sm font-semibold text-gray-600 block mb-1">Saldo Poin Warga Saat Ini</label>
                    <p class="text-lg text-gray-800">
                        {{ number_format($redemption->user->balance_points, 0, ',', '.') }} Poin
                    </p>
                </div>
            </div>
        </div>
    </div>

    <!-- Daftar Barang -->
    <div class="bg-white rounded-lg shadow-md p-6 mb-6">
        <h2 class="text-xl font-bold text-gray-800 mb-4 border-b pb-2">
            <i class="fas fa-shopping-bag text-green-600 mr-2"></i>Daftar Barang yang Ditukar
        </h2>
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">No</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Gambar</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nama Barang</th>
                        <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">Jumlah</th>
                        <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Poin/Item</th>
                        <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Subtotal Poin</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @foreach($redemption->redemptionItems as $index => $item)
                    <tr class="hover:bg-gray-50 transition">
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $index + 1 }}</td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            @if($item->rewardItem && $item->rewardItem->image)
                                <img src="{{ asset('images/' . $item->rewardItem->image) }}" 
                                     alt="{{ $item->rewardItem->name }}" 
                                     class="h-16 w-16 object-cover rounded-lg shadow-sm"
                                     onerror="this.src='{{ asset('images/no-image.png') }}'">
                            @else
                                <div class="h-16 w-16 bg-gray-200 rounded-lg flex items-center justify-center">
                                    <i class="fas fa-image text-gray-400 text-2xl"></i>
                                </div>
                            @endif
                        </td>
                        <td class="px-6 py-4">
                            <div class="text-sm font-medium text-gray-900">{{ $item->rewardItem->name }}</div>
                            @if($item->rewardItem && $item->rewardItem->description)
                                <div class="text-xs text-gray-500 mt-1">{{ Str::limit($item->rewardItem->description, 50) }}</div>
                            @endif
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-center">
                            <span class="px-3 py-1 bg-blue-100 text-blue-800 rounded-full text-sm font-semibold">
                                {{ $item->quantity }} pcs
                            </span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-right text-sm text-gray-900">
                            {{ number_format($item->points, 0, ',', '.') }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-bold text-green-600">
                            {{ number_format($item->quantity * $item->points, 0, ',', '.') }}
                        </td>
                    </tr>
                    @endforeach
                </tbody>
                <tfoot class="bg-gray-50">
                    <tr>
                        <td colspan="5" class="px-6 py-4 text-right text-sm font-bold text-gray-900">
                            TOTAL POIN:
                        </td>
                        <td class="px-6 py-4 text-right text-lg font-bold text-green-600">
                            {{ number_format($redemption->total_points, 0, ',', '.') }} Poin
                        </td>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>

    <!-- Action Buttons -->
    @if($redemption->status === 'pending')
    <div class="bg-yellow-50 border-l-4 border-yellow-500 rounded-lg shadow-md p-6">
        <div class="flex items-center justify-between">
            <div>
                <h3 class="text-lg font-bold text-yellow-800 mb-2">
                    <i class="fas fa-exclamation-triangle mr-2"></i>Permintaan Menunggu Konfirmasi
                </h3>
                <p class="text-yellow-700">Konfirmasi permintaan ini jika stok barang tersedia dan siap disiapkan.</p>
            </div>
            <div class="flex gap-3">
                <form action="{{ route('admin.penukaran.approve', $redemption->id) }}" method="POST" onsubmit="return confirmAction(event, 'Konfirmasi Permintaan', 'Apakah Anda yakin ingin mengkonfirmasi permintaan penukaran ini? Stok barang akan dikurangi.', 'warning')">
                    @csrf
                    @method('POST')
                    <button type="submit" class="px-6 py-3 bg-blue-600 hover:bg-blue-700 text-white font-semibold rounded-lg shadow-lg transition duration-200">
                        <i class="fas fa-check-circle mr-2"></i>Konfirmasi
                    </button>
                </form>
                <button type="button" onclick="openRejectModal()" class="px-6 py-3 bg-red-600 hover:bg-red-700 text-white font-semibold rounded-lg shadow-lg transition duration-200">
                    <i class="fas fa-times-circle mr-2"></i>Tolak
                </button>
            </div>
        </div>
    </div>
    @elseif($redemption->status === 'confirmed')
    <div class="bg-blue-50 border-l-4 border-blue-500 rounded-lg shadow-md p-6">
        <div class="flex items-center justify-between">
            <div>
                <h3 class="text-lg font-bold text-blue-800 mb-2">
                    <i class="fas fa-box-open mr-2"></i>Barang Siap Diambil
                </h3>
                <p class="text-blue-700">Klik tombol "Serahkan Barang" setelah warga mengambil barang di lokasi.</p>
                <p class="text-sm text-blue-600 mt-2 font-semibold">
                    <i class="fas fa-hourglass-half"></i> 
                    Sisa waktu pengambilan: <span id="admin-countdown">--:--:--</span>
                </p>
                @if($redemption->isExpired())
                    <p class="text-sm text-red-600 font-bold mt-1">
                        <i class="fas fa-exclamation-triangle"></i> Waktu pengambilan sudah expired!
                    </p>
                @endif
            </div>
            <form action="{{ route('admin.penukaran.complete', $redemption->id) }}" method="POST" onsubmit="return confirmAction(event, 'Serahkan Barang', 'Apakah Anda yakin barang sudah diserahkan kepada warga?', 'success')">
                @csrf
                @method('POST')
                <button type="submit" class="px-6 py-3 bg-green-600 hover:bg-green-700 text-white font-semibold rounded-lg shadow-lg transition duration-200">
                    <i class="fas fa-hand-holding mr-2"></i>Serahkan Barang
                </button>
            </form>
        </div>
    </div>
    @elseif($redemption->status === 'completed')
    <div class="bg-green-50 border-l-4 border-green-500 rounded-lg shadow-md p-6">
        <div class="flex items-center">
            <div class="flex-shrink-0">
                <i class="fas fa-check-circle text-green-600 text-4xl"></i>
            </div>
            <div class="ml-4">
                <h3 class="text-lg font-bold text-green-800 mb-1">
                    Transaksi Selesai
                </h3>
                <p class="text-green-700">Barang telah diserahkan kepada warga pada {{ \Carbon\Carbon::parse($redemption->updated_at)->format('d F Y, H:i') }} WIB</p>
            </div>
        </div>
    </div>
    @elseif($redemption->status === 'cancelled')
    <div class="bg-red-50 border-l-4 border-red-500 rounded-lg shadow-md p-6">
        <div class="flex items-center">
            <div class="flex-shrink-0">
                <i class="fas fa-times-circle text-red-600 text-4xl"></i>
            </div>
            <div class="ml-4">
                <h3 class="text-lg font-bold text-red-800 mb-1">
                    Transaksi Dibatalkan
                </h3>
                <p class="text-red-700">Permintaan penukaran ini telah dibatalkan.</p>
            </div>
        </div>
    </div>
    @endif
</div>

<script>
function confirmAction(event, title, text, icon) {
    event.preventDefault();
    
    Swal.fire({
        title: title,
        text: text,
        icon: icon,
        showCancelButton: true,
        confirmButtonColor: icon === 'warning' ? '#3b82f6' : '#10b981',
        cancelButtonColor: '#6b7280',
        confirmButtonText: 'Ya, Lanjutkan',
        cancelButtonText: 'Batal',
        reverseButtons: true
    }).then((result) => {
        if (result.isConfirmed) {
            event.target.submit();
        }
    });
    
    return false;
}

// Auto-hide success/error messages
document.addEventListener('DOMContentLoaded', function() {
    @if(session('success'))
        Swal.fire({
            icon: 'success',
            title: 'Berhasil!',
            text: '{{ session('success') }}',
            timer: 3000,
            showConfirmButton: false
        });
    @endif
    
    @if(session('error'))
        Swal.fire({
            icon: 'error',
            title: 'Gagal!',
            text: '{{ session('error') }}',
            timer: 3000,
            showConfirmButton: false
        });
    @endif
});
</script>

<!-- Modal Tolak Penukaran -->
<div id="rejectModal" class="hidden fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
    <div class="bg-white rounded-lg shadow-xl max-w-md w-full mx-4">
        <div class="bg-red-50 border-b-2 border-red-500 px-6 py-4">
            <h3 class="text-xl font-bold text-red-800">
                <i class="fas fa-times-circle mr-2"></i>Tolak Penukaran
            </h3>
        </div>
        
        <form action="{{ route('admin.penukaran.reject', $redemption->id) }}" method="POST" class="p-6">
            @csrf
            @method('POST')
            
            <div class="mb-4">
                <label class="block text-sm font-semibold text-gray-700 mb-2">
                    <i class="fas fa-comment mr-1"></i>Alasan Penolakan
                </label>
                <textarea 
                    name="rejection_reason" 
                    class="w-full px-4 py-3 border-2 border-gray-300 rounded-lg focus:outline-none focus:border-red-500 focus:ring-2 focus:ring-red-200 resize-none"
                    rows="4"
                    placeholder="Jelaskan alasan penolakan penukaran ini (min. 10 karakter)..."
                    required
                    minlength="10"
                ></textarea>
                @error('rejection_reason')
                    <p class="text-red-600 text-sm mt-2">{{ $message }}</p>
                @enderror
            </div>
            
            <p class="text-sm text-gray-600 mb-6 bg-red-50 p-3 rounded-lg">
                <i class="fas fa-info-circle mr-2"></i>
                Stok barang akan dikembalikan otomatis setelah penolakan.
            </p>
            
            <div class="flex gap-3">
                <button type="button" onclick="closeRejectModal()" class="flex-1 px-4 py-3 bg-gray-300 hover:bg-gray-400 text-gray-800 font-semibold rounded-lg transition">
                    Batal
                </button>
                <button type="submit" class="flex-1 px-4 py-3 bg-red-600 hover:bg-red-700 text-white font-semibold rounded-lg transition">
                    <i class="fas fa-check mr-2"></i>Tolak Penukaran
                </button>
            </div>
        </form>
    </div>
</div>

<script>
function openRejectModal() {
    document.getElementById('rejectModal').classList.remove('hidden');
}

function closeRejectModal() {
    document.getElementById('rejectModal').classList.add('hidden');
}

// Close modal saat klik di luar
document.getElementById('rejectModal').addEventListener('click', function(e) {
    if (e.target === this) {
        closeRejectModal();
    }
});

// Countdown timer untuk admin penukaran
@if($redemption->status === 'confirmed' && $redemption->expires_at)
document.addEventListener('DOMContentLoaded', function() {
    const expiresAt = new Date('{{ $redemption->expires_at->toIso8601String() }}').getTime();
    const countdownEl = document.getElementById('admin-countdown');
    
    function updateCountdown() {
        const now = new Date().getTime();
        const remaining = expiresAt - now;
        
        if (remaining <= 0) {
            countdownEl.textContent = '⏰ Waktu habis!';
            countdownEl.classList.add('text-red-700', 'font-bold');
            return;
        }
        
        const hours = Math.floor((remaining / (1000 * 60 * 60)) % 24);
        const minutes = Math.floor((remaining / (1000 * 60)) % 60);
        const seconds = Math.floor((remaining / 1000) % 60);
        
        countdownEl.textContent = `${String(hours).padStart(2, '0')}:${String(minutes).padStart(2, '0')}:${String(seconds).padStart(2, '0')}`;
    }
    
    updateCountdown();
    setInterval(updateCountdown, 1000);
});
@endif
</script>

</body>
</html>
