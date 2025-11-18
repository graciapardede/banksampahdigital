<header class="bg-white shadow-sm">
    <div class="max-w-6xl mx-auto px-4 py-6">
        <div class="flex justify-between items-center">
            <!-- Logo -->
            <div class="flex items-center space-x-3">
                <div class="w-12 h-12 bg-gradient-to-br from-green-500 to-green-600 rounded-xl flex items-center justify-center shadow-lg">
                    <i class="bi bi-recycle text-white text-2xl"></i>
                </div>
                <div>
                    <h1 class="font-bold text-xl text-gray-800">Green Saving Admin</h1>
                    <p class="text-sm text-green-600">Halo, {{ Auth::user()->name }}</p>
                </div>
            </div>

            <!-- Admin Actions -->
            <div class="flex items-center space-x-4">
                <!-- Admin Badge -->
                <div class="bg-gradient-to-r from-green-100 to-emerald-50 px-6 py-3 rounded-full border-2 border-green-300 shadow-md">
                    <div class="flex items-center space-x-2">
                        <i class="bi bi-shield-check text-green-600 text-xl"></i>
                        <span class="font-bold text-green-700 text-sm">Administrator</span>
                    </div>
                </div>

                <!-- Logout Button -->
                <form method="POST" action="{{ route('logout') }}" class="inline">
                    @csrf
                    <button type="submit" class="w-12 h-12 bg-red-100 hover:bg-red-200 rounded-xl flex items-center justify-center transition-all">
                        <i class="bi bi-box-arrow-right text-red-600 text-xl"></i>
                    </button>
                </form>
            </div>
        </div>
    </div>

    <!-- Navigation Tabs -->
    <div class="bg-green-100 px-4 py-4">
        <div class="max-w-6xl mx-auto">
            <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-6 gap-3">
                <a href="{{ route('admin.dashboard') }}" class="{{ request()->routeIs('admin.dashboard') ? 'bg-green-500 text-white' : 'bg-white text-gray-700 hover:bg-green-50' }} px-4 lg:px-6 py-3 rounded-2xl text-xs lg:text-sm font-semibold transition-colors shadow-sm flex items-center justify-center space-x-2 w-full">
                    <i class="bi bi-house-door"></i>
                    <span class="truncate">Dashboard</span>
                </a>
                <a href="{{ route('admin.setoran.index') }}" class="{{ request()->routeIs('admin.setoran.*') ? 'bg-green-500 text-white' : 'bg-white text-gray-700 hover:bg-green-50' }} px-4 lg:px-6 py-3 rounded-2xl text-xs lg:text-sm font-semibold transition-colors shadow-sm flex items-center justify-center space-x-2 w-full">
                    <i class="bi bi-graph-up"></i>
                    <span class="truncate">Setoran</span>
                </a>
                <a href="{{ route('admin.penukaran.index') }}" class="{{ request()->routeIs('admin.penukaran.*') ? 'bg-green-500 text-white' : 'bg-white text-gray-700 hover:bg-green-50' }} px-4 lg:px-6 py-3 rounded-2xl text-xs lg:text-sm font-semibold transition-colors shadow-sm flex items-center justify-center space-x-2 w-full">
                    <i class="bi bi-arrow-left-right"></i>
                    <span class="truncate">Penukaran</span>
                </a>
                <a href="{{ route('admin.reward-items.index') }}" class="{{ request()->routeIs('admin.reward-items.*') ? 'bg-green-500 text-white' : 'bg-white text-gray-700 hover:bg-green-50' }} px-4 lg:px-6 py-3 rounded-2xl text-xs lg:text-sm font-semibold transition-colors shadow-sm flex items-center justify-center space-x-2 w-full">
                    <i class="bi bi-gift"></i>
                    <span class="truncate">Tukar Barang</span>
                </a>
                <a href="{{ route('admin.waste-types.index') }}" class="{{ request()->routeIs('admin.waste-types.*') ? 'bg-green-500 text-white' : 'bg-white text-gray-700 hover:bg-green-50' }} px-4 lg:px-6 py-3 rounded-2xl text-xs lg:text-sm font-semibold transition-colors shadow-sm flex items-center justify-center space-x-2 w-full">
                    <i class="bi bi-recycle"></i>
                    <span class="truncate">Jenis Sampah</span>
                </a>
                <a href="{{ route('admin.laporan.index') }}" class="{{ request()->routeIs('admin.laporan.*') ? 'bg-green-500 text-white' : 'bg-white text-gray-700 hover:bg-green-50' }} px-4 lg:px-6 py-3 rounded-2xl text-xs lg:text-sm font-semibold transition-colors shadow-sm flex items-center justify-center space-x-2 w-full">
                    <i class="bi bi-file-earmark-bar-graph"></i>
                    <span class="truncate">Laporan</span>
                </a>
            </div>
        </div>
    </div>
</header>
