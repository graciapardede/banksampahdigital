<div class="bg-white rounded-3xl overflow-hidden shadow-lg hover:shadow-2xl transition-all duration-300 reward-card border border-gray-100 hover:border-green-200 group hover:-translate-y-1" 
     data-id="{{ $reward->id }}"
     data-name="{{ $reward->name }}" 
     data-desc="{{ $reward->description ?? 'Produk berkualitas' }}" 
     data-price="{{ $reward->points_cost }}"
     data-stock="{{ $reward->stock }}"
     data-branch="{{ $reward->branch_id }}"
     data-image="{{ $reward->image ? asset('images/' . $reward->image) : asset('images/default.png') }}">
    
    <!-- Image Container -->
    <div class="relative bg-gradient-to-br from-green-50 via-emerald-50 to-green-50 p-6 flex items-center justify-center h-56 overflow-hidden">
        <!-- Stock Badge -->
        @if($reward->stock > 0 && $reward->stock <= 10)
            <div class="absolute top-3 left-3 bg-gradient-to-r from-orange-500 to-orange-600 text-white px-3 py-1.5 rounded-lg text-xs font-bold shadow-md flex items-center gap-1">
                <i class="bi bi-exclamation-triangle-fill"></i>
                Stok Terbatas
            </div>
        @elseif($reward->stock > 10)
            <div class="absolute top-3 left-3 bg-gradient-to-r from-green-500 to-green-600 text-white px-3 py-1.5 rounded-lg text-xs font-bold shadow-md flex items-center gap-1">
                <i class="bi bi-check-circle-fill"></i>
                Tersedia
            </div>
        @else
            <div class="absolute top-3 left-3 bg-gradient-to-r from-red-500 to-red-600 text-white px-3 py-1.5 rounded-lg text-xs font-bold shadow-md flex items-center gap-1">
                <i class="bi bi-x-circle-fill"></i>
                Habis
            </div>
        @endif

        @if($reward->image)
            <img src="{{ asset('images/' . $reward->image) }}" alt="{{ $reward->name }}" class="h-44 w-auto object-contain group-hover:scale-105 transition-transform duration-300">
        @else
            <i class="bi bi-gift text-gray-300 text-7xl group-hover:scale-105 transition-transform duration-300"></i>
        @endif
    </div>
    
    <!-- Content -->
    <div class="p-6 space-y-4">
        <!-- Title & Description -->
        <div>
            <h3 class="font-bold text-gray-800 text-lg lg:text-xl mb-2 line-clamp-1">{{ $reward->name }}</h3>
            <p class="text-sm text-gray-600 line-clamp-2 leading-relaxed">{{ $reward->description ?? 'Produk berkualitas' }}</p>
        </div>
        
        <!-- Price & Stock Info -->
        <div class="space-y-3 pt-3 border-t border-gray-100">
            <!-- Price -->
            <div class="bg-gradient-to-br from-green-50 to-emerald-50 rounded-xl p-4 border border-green-100">
                <p class="text-xs text-green-600 font-semibold mb-1.5 uppercase tracking-wide">Harga Penukaran</p>
                <div class="flex items-center gap-2">
                    <div class="w-8 h-8 bg-gradient-to-br from-green-500 to-green-600 rounded-lg flex items-center justify-center shadow-sm">
                        <i class="bi bi-coin text-white text-sm"></i>
                    </div>
                    <p class="text-xl lg:text-2xl font-bold text-green-700">
                        {{ number_format($reward->points_cost, 0, ',', '.') }}
                    </p>
                    <span class="text-sm text-green-600 font-medium">poin</span>
                </div>
            </div>
            
            <!-- Stock -->
            <div class="flex items-center justify-between p-3 bg-gray-50 rounded-xl">
                <span class="text-xs text-gray-600 font-medium flex items-center gap-1.5">
                    <i class="bi bi-box-seam"></i>
                    Stok Tersedia
                </span>
                <span class="text-sm font-bold {{ $reward->stock > 10 ? 'text-green-600' : ($reward->stock > 0 ? 'text-orange-600' : 'text-red-600') }}">
                    {{ $reward->stock }} item
                </span>
            </div>
        </div>
        
        <!-- Action Button -->
        @if($reward->stock > 0)
            <a href="{{ route('tukar.detail', $reward->id) }}"
                class="block w-full bg-gradient-to-r from-green-500 to-green-600 hover:from-green-600 hover:to-green-700 text-white py-3.5 rounded-xl font-bold transition-all shadow-md hover:shadow-xl text-center text-sm lg:text-base group/btn">
                <span class="flex items-center justify-center gap-2">
                    <i class="bi bi-cart-plus text-lg"></i>
                    Lihat Detail & Tukar
                    <i class="bi bi-arrow-right group-hover/btn:translate-x-1 transition-transform"></i>
                </span>
            </a>
        @else
            <button disabled
                class="w-full bg-gray-200 text-gray-500 py-3.5 rounded-xl font-bold cursor-not-allowed border-2 border-gray-300">
                <i class="bi bi-x-circle mr-2"></i>
                Stok Habis
            </button>
        @endif
    </div>
</div>
