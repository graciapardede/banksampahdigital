<nav x-data="{ open: false }" class="bg-white border-b border-gray-100">
    <!-- Primary Navigation Menu -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex">
                <!-- Logo -->
                <div class="shrink-0 flex items-center">
                    <a href="{{ Auth::check() ? (Auth::user()->role === 'admin' ? route('admin.dashboard') : route('dashboard')) : route('eco.news.index') }}">
                        <x-application-logo class="block h-9 w-auto fill-current text-gray-800" />
                    </a>
                </div>

                <!-- Navigation Links -->
                <div class="hidden space-x-8 sm:-my-px sm:ms-10 sm:flex">
                    @auth
                        @if(Auth::user()->role === 'admin')
                            {{-- Admin Navigation --}}
                            <x-nav-link :href="route('admin.dashboard')" :active="request()->routeIs('admin.dashboard')">
                                {{ __('Dashboard') }}
                            </x-nav-link>
                            <x-nav-link :href="route('admin.setoran.index')" :active="request()->routeIs('admin.setoran.*')">
                                {{ __('Setoran') }}
                            </x-nav-link>
                            <x-nav-link :href="route('admin.penukaran.index')" :active="request()->routeIs('admin.penukaran.*')">
                                {{ __('Penukaran') }}
                            </x-nav-link>
                            <x-nav-link :href="route('admin.reward-items.index')" :active="request()->routeIs('admin.reward-items.*')">
                                {{ __('Tukar Barang') }}
                            </x-nav-link>
                            <x-nav-link :href="route('admin.waste-types.index')" :active="request()->routeIs('admin.waste-types.*')">
                                {{ __('Jenis Sampah') }}
                            </x-nav-link>
                        @else
                            {{-- User Navigation --}}
                            <x-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
                                {{ __('Dashboard') }}
                            </x-nav-link>
                        @endif
                    @endauth
                    
                    {{-- Eco News - Available for All Users (Authenticated and Guest) --}}
                    <x-nav-link :href="url('/eco-news')" :active="request()->routeIs('eco.news.*')">
                        🌿 {{ __('Eco News') }}
                    </x-nav-link>
                </div>
            </div>

            <!-- Settings Dropdown -->
            <div class="hidden sm:flex sm:items-center sm:ms-6">
                @auth
                    {{-- Tampilkan Saldo Poin untuk User/Warga --}}
                    @if($roleUser === 'user')
                        <div class="me-4 px-3 py-2 bg-green-50 border border-green-200 rounded-md">
                            <span class="text-xs text-gray-600">Saldo Poin:</span>
                            <span class="ms-1 text-sm font-bold text-green-600">{{ number_format($saldoPoin, 0, ',', '.') }}</span>
                        </div>
                    @endif

                    <x-dropdown align="right" width="48">
                        <x-slot name="trigger">
                            <button class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 bg-white hover:text-gray-700 focus:outline-none transition ease-in-out duration-150">
                                <div>{{ $namaUser }}</div>

                                <div class="ms-1">
                                    <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                    </svg>
                                </div>
                            </button>
                        </x-slot>

                        <x-slot name="content">
                            <div class="px-4 py-2 border-b border-gray-200">
                                <div class="text-sm font-medium text-gray-800">{{ $namaUser }}</div>
                                <div class="text-xs text-gray-500">{{ $emailUser }}</div>
                                @if($roleUser === 'user')
                                    <div class="mt-1 text-xs text-green-600 font-semibold">
                                        💰 {{ number_format($saldoPoin, 0, ',', '.') }} poin
                                    </div>
                                @endif
                            </div>

                            <!-- Authentication -->
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf

                                <x-dropdown-link :href="route('logout')"
                                        onclick="event.preventDefault();
                                                    this.closest('form').submit();">
                                    {{ __('Log Out') }}
                                </x-dropdown-link>
                            </form>
                        </x-slot>
                    </x-dropdown>
                @else
                    {{-- Login/Register buttons for guest users --}}
                    <a href="{{ route('login') }}" class="text-sm text-gray-700 hover:text-green-600 font-semibold px-4 py-2">
                        Masuk
                    </a>
                    <a href="{{ route('register') }}" class="ml-2 bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-lg text-sm font-semibold transition-colors">
                        Daftar
                    </a>
                @endauth
            </div>

            <!-- Hamburger -->
            <div class="-me-2 flex items-center sm:hidden">
                @guest
                    <a href="{{ route('login') }}" class="text-sm text-gray-700 hover:text-green-600 font-semibold px-2 py-1">
                        Masuk
                    </a>
                @endguest
                <button @click="open = ! open" class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-gray-500 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 focus:text-gray-500 transition duration-150 ease-in-out">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Responsive Navigation Menu -->
    <div :class="{'block': open, 'hidden': ! open}" class="hidden sm:hidden">
        <div class="pt-2 pb-3 space-y-1">
            @auth
                @if(Auth::user()->role === 'admin')
                    {{-- Admin Responsive Navigation --}}
                    <x-responsive-nav-link :href="route('admin.dashboard')" :active="request()->routeIs('admin.dashboard')">
                        {{ __('Dashboard') }}
                    </x-responsive-nav-link>
                    <x-responsive-nav-link :href="route('admin.setoran.index')" :active="request()->routeIs('admin.setoran.*')">
                        {{ __('Setoran') }}
                    </x-responsive-nav-link>
                    <x-responsive-nav-link :href="route('admin.penukaran.index')" :active="request()->routeIs('admin.penukaran.*')">
                        {{ __('Penukaran') }}
                    </x-responsive-nav-link>
                    <x-responsive-nav-link :href="route('admin.reward-items.index')" :active="request()->routeIs('admin.reward-items.*')">
                        {{ __('Tukar Barang') }}
                    </x-responsive-nav-link>
                    <x-responsive-nav-link :href="route('admin.waste-types.index')" :active="request()->routeIs('admin.waste-types.*')">
                        {{ __('Jenis Sampah') }}
                    </x-responsive-nav-link>
                @else
                    {{-- User Responsive Navigation --}}
                    <x-responsive-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
                        {{ __('Dashboard') }}
                    </x-responsive-nav-link>
                @endif
            @endauth
            
            {{-- Eco News - Available for All --}}
            <x-responsive-nav-link :href="url('/eco-news')" :active="request()->routeIs('eco.news.*')">
                🌿 {{ __('Eco News') }}
            </x-responsive-nav-link>
        </div>

        <!-- Responsive Settings Options -->
        @auth
        <div class="pt-4 pb-1 border-t border-gray-200">
            <div class="px-4">
                <div class="font-medium text-base text-gray-800">{{ $namaUser }}</div>
                <div class="font-medium text-sm text-gray-500">{{ $emailUser }}</div>
                @if($roleUser === 'user')
                    <div class="mt-2 px-3 py-2 bg-green-50 border border-green-200 rounded-md inline-block">
                        <span class="text-xs text-gray-600">Saldo Poin:</span>
                        <span class="ms-1 text-sm font-bold text-green-600">{{ number_format($saldoPoin, 0, ',', '.') }}</span>
                    </div>
                @endif
            </div>

            <div class="mt-3 space-y-1">
                <!-- Authentication -->
                <form method="POST" action="{{ route('logout') }}">
                    @csrf

                    <x-responsive-nav-link :href="route('logout')"
                            onclick="event.preventDefault();
                                        this.closest('form').submit();">
                        {{ __('Log Out') }}
                    </x-responsive-nav-link>
                </form>
            </div>
        </div>
        @else
        <div class="pt-4 pb-1 border-t border-gray-200">
            <div class="px-4 space-y-2">
                <a href="{{ route('login') }}" class="block w-full text-center bg-white border-2 border-green-600 text-green-600 hover:bg-green-50 px-4 py-2 rounded-lg font-semibold transition-colors">
                    Masuk
                </a>
                <a href="{{ route('register') }}" class="block w-full text-center bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-lg font-semibold transition-colors">
                    Daftar
                </a>
            </div>
        </div>
        @endauth
    </div>
</nav>
