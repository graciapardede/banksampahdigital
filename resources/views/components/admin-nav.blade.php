<nav class="bg-green-100 px-4 py-4">
    <div class="max-w-6xl mx-auto">
        <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-6 gap-3">
            <!-- 1. Dashboard -->
            <a href="{{ route('admin.dashboard') }}" 
               class="{{ request()->routeIs('admin.dashboard') ? 'bg-green-500 text-white' : 'bg-white text-gray-700 hover:bg-green-50' }} px-4 lg:px-6 py-3 rounded-2xl text-xs lg:text-sm font-semibold transition-colors shadow-sm flex items-center justify-center space-x-2 w-full">
                <i class="bi bi-house-door"></i>
                <span class="truncate">Dashboard</span>
            </a>

            <!-- 2. Setoran Sampah -->
            <a href="{{ route('admin.setoran.index') }}" 
               class="{{ request()->routeIs('admin.setoran.*') ? 'bg-green-500 text-white' : 'bg-white text-gray-700 hover:bg-green-50' }} px-4 lg:px-6 py-3 rounded-2xl text-xs lg:text-sm font-semibold transition-colors shadow-sm flex items-center justify-center space-x-2 w-full">
                <i class="bi bi-graph-up"></i>
                <span class="truncate">Setoran</span>
            </a>

            <!-- 3. Penukaran Poin -->
            <a href="{{ route('admin.penukaran.index') }}" 
               class="{{ request()->routeIs('admin.penukaran.*') ? 'bg-green-500 text-white' : 'bg-white text-gray-700 hover:bg-green-50' }} px-4 lg:px-6 py-3 rounded-2xl text-xs lg:text-sm font-semibold transition-colors shadow-sm flex items-center justify-center space-x-2 w-full">
                <i class="bi bi-arrow-left-right"></i>
                <span class="truncate">Penukaran</span>
            </a>

            <!-- 4. Tukar Barang (Reward Item) -->
            <a href="{{ route('admin.reward-items.index') }}" 
               class="{{ request()->routeIs('admin.reward-items.*') || request()->routeIs('admin.tukar-barang') ? 'bg-green-500 text-white' : 'bg-white text-gray-700 hover:bg-green-50' }} px-4 lg:px-6 py-3 rounded-2xl text-xs lg:text-sm font-semibold transition-colors shadow-sm flex items-center justify-center space-x-2 w-full">
                <i class="bi bi-gift"></i>
                <span class="truncate">Tukar Barang</span>
            </a>

            <!-- 5. Jenis Sampah -->
            <a href="{{ route('admin.waste-types.index') }}" 
               class="{{ request()->routeIs('admin.waste-types.*') ? 'bg-green-500 text-white' : 'bg-white text-gray-700 hover:bg-green-50' }} px-4 lg:px-6 py-3 rounded-2xl text-xs lg:text-sm font-semibold transition-colors shadow-sm flex items-center justify-center space-x-2 w-full">
                <i class="bi bi-recycle"></i>
                <span class="truncate">Jenis Sampah</span>
            </a>

            <!-- 6. Laporan -->
            <a href="{{ route('admin.laporan.index') }}" 
               class="{{ request()->routeIs('admin.laporan.*') ? 'bg-green-500 text-white' : 'bg-white text-gray-700 hover:bg-green-50' }} px-4 lg:px-6 py-3 rounded-2xl text-xs lg:text-sm font-semibold transition-colors shadow-sm flex items-center justify-center space-x-2 w-full">
                <i class="bi bi-file-earmark-bar-graph"></i>
                <span class="truncate">Laporan</span>
            </a>
        </div>
    </div>
</nav>
