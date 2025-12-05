<a href="{{ route('tukar.detail', $reward->id) }}" class="bg-white rounded-2xl overflow-hidden shadow-sm hover:shadow-lg transition-all hover:scale-[1.02] reward-card block cursor-pointer" 
     data-id="{{ $reward->id }}"
     data-name="{{ $reward->name }}" 
     data-desc="{{ $reward->description ?? 'Produk berkualitas' }}" 
     data-price="{{ $reward->points_cost }}"
     data-stock="{{ $reward->stock }}"
     data-branch="{{ $reward->branch_id }}"
     data-image="{{ $reward->image ? asset('images/' . $reward->image) : asset('images/default.png') }}">
    <div class="p-5">
        <!-- Image -->
        <div class="bg-gradient-to-br from-green-50 to-emerald-50 rounded-xl p-4 mb-4 flex items-center justify-center h-48">
            @if($reward->image)
                <img src="{{ asset('images/' . $reward->image) }}" alt="{{ $reward->name }}" class="h-40 w-auto object-contain">
            @else
                <i class="bi bi-gift text-gray-300 text-6xl"></i>
            @endif
        </div>
        
        <!-- Content -->
        <div class="space-y-3">
            <div>
                <h3 class="font-bold text-gray-800 text-lg mb-1">{{ $reward->name }}</h3>
                <p class="text-sm text-gray-500">{{ $reward->description ?? 'Produk berkualitas' }}</p>
            </div>
            
            <div class="pt-2 border-t border-gray-100 space-y-2">
                <div class="flex items-center justify-between">
                    <p class="text-xs text-gray-500">Harga</p>
                    <p class="text-lg font-bold text-green-600">
                        <i class="bi bi-coin text-green-500 mr-1"></i>
                        {{ number_format($reward->points_cost, 0, ',', '.') }} poin
                    </p>
                </div>
                <div class="flex items-center justify-between">
                    <p class="text-xs text-gray-500">Stok Tersedia</p>
                    <p class="text-sm font-semibold {{ $reward->stock > 10 ? 'text-green-600' : 'text-orange-600' }}">
                        <i class="bi bi-box-seam mr-1"></i>
                        {{ $reward->stock }} item
                    </p>
                </div>
            </div>
        </div>
    </div>
</a>
