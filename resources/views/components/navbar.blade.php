<nav class="bg-white shadow-sm border-b border-gray-100 sticky top-0 z-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between items-center h-16">
            <!-- Logo -->
            <div class="flex items-center">
                <a href="{{ route('home') }}" class="flex items-center space-x-3">
                    <div class="w-8 h-8 bg-amber-800 rounded-lg flex items-center justify-center">
                        <span class="text-white font-bold text-sm">K</span>
                    </div>
                    <span class="text-xl font-elegant font-semibold text-gray-800">KayUmah</span>
                </a>
            </div>

            <!-- Desktop Navigation -->
            <div class="hidden md:flex items-center space-x-8">
                <a href="{{ route('home') }}" 
                   class="text-gray-700 hover:text-amber-800 transition-colors duration-200 {{ Request::routeIs('home') ? 'text-amber-800 font-medium' : '' }}">
                    Beranda
                </a>
                <a href="{{ route('products.index') }}" 
                   class="text-gray-700 hover:text-amber-800 transition-colors duration-200 {{ Request::routeIs('products.*') ? 'text-amber-800 font-medium' : '' }}">
                    Produk
                </a>
                @auth
                    <a href="{{ route('orders.index') }}" 
                       class="text-gray-700 hover:text-amber-800 transition-colors duration-200 {{ Request::routeIs('orders.*') ? 'text-amber-800 font-medium' : '' }}">
                        Riwayat Pembelian
                    </a>
                @endauth
            </div>

            <!-- Right Section -->
            <div class="flex items-center space-x-4">
                <!-- Cart Icon -->
                <a href="{{ route('cart.index') }}" class="relative p-2 text-gray-700 hover:text-amber-800 transition-colors">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"/>
                    </svg>
                    @auth
                        @php
                            $cartCount = Auth::user()->carts->count();
                        @endphp
                        @if($cartCount > 0)
                            <span class="absolute -top-1 -right-1 bg-amber-600 text-white text-xs rounded-full w-5 h-5 flex items-center justify-center">
                                {{ $cartCount }}
                            </span>
                        @endif
                    @endauth
                </a>

                <!-- Auth Links -->
                @auth
                    <div class="relative group">
                        <button class="flex items-center space-x-2 text-gray-700 hover:text-amber-800 transition-colors">
                            <div class="w-8 h-8 bg-amber-100 rounded-full flex items-center justify-center">
                                <span class="text-amber-800 font-medium text-sm">
                                    {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                                </span>
                            </div>
                            <span class="hidden md:block">{{ Auth::user()->name }}</span>
                        </button>
                        
                        <!-- Dropdown Menu -->
                        <div class="absolute right-0 mt-2 w-48 bg-white rounded-lg shadow-lg border border-gray-200 opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-200 z-50">
                            <div class="py-1">
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button type="submit" 
                                            class="w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 transition-colors">
                                        Keluar
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                @else
                    <div class="flex items-center space-x-4">
                        <a href="{{ route('login') }}" 
                           class="text-gray-700 hover:text-amber-800 transition-colors duration-200">
                            Masuk
                        </a>
                        <a href="{{ route('register') }}" 
                           class="bg-amber-800 text-white px-4 py-2 rounded-lg hover:bg-amber-700 transition-colors duration-200">
                            Daftar
                        </a>
                    </div>
                @endauth
            </div>

            <!-- Mobile menu button -->
            <div class="md:hidden">
                <button onclick="toggleMobileMenu()" 
                        class="p-2 rounded-md text-gray-700 hover:text-amber-800 hover:bg-amber-50 transition-colors">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                    </svg>
                </button>
            </div>
        </div>

        <!-- Mobile Navigation -->
        <div id="mobile-menu" class="md:hidden hidden border-t border-gray-100 py-4">
            <div class="flex flex-col space-y-4">
                <a href="{{ route('home') }}" 
                   class="text-gray-700 hover:text-amber-800 transition-colors duration-200 {{ Request::routeIs('home') ? 'text-amber-800 font-medium' : '' }}">
                    Beranda
                </a>
                <a href="{{ route('products.index') }}" 
                   class="text-gray-700 hover:text-amber-800 transition-colors duration-200 {{ Request::routeIs('products.*') ? 'text-amber-800 font-medium' : '' }}">
                    Produk
                </a>
                @auth
                    <a href="{{ route('cart.index') }}" 
                       class="text-gray-700 hover:text-amber-800 transition-colors duration-200 {{ Request::routeIs('cart.*') ? 'text-amber-800 font-medium' : '' }}">
                        Keranjang
                    </a>
                    <a href="{{ route('orders.index') }}" 
                       class="text-gray-700 hover:text-amber-800 transition-colors duration-200 {{ Request::routeIs('orders.*') ? 'text-amber-800 font-medium' : '' }}">
                        Riwayat Pembelian
                    </a>
                @endauth
                
                @guest
                    <div class="pt-4 border-t border-gray-100 space-y-2">
                        <a href="{{ route('login') }}" 
                           class="block text-gray-700 hover:text-amber-800 transition-colors duration-200">
                            Masuk
                        </a>
                        <a href="{{ route('register') }}" 
                           class="block bg-amber-800 text-white px-4 py-2 rounded-lg hover:bg-amber-700 transition-colors duration-200 text-center">
                            Daftar
                        </a>
                    </div>
                @endguest
            </div>
        </div>
    </div>
</nav>