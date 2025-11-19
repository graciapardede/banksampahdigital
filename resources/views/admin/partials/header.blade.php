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

</header>

<!-- Navigation Tabs -->
<x-admin-nav />
