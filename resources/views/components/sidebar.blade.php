<!-- Sidebar Navigation -->
<aside id="sidebar" class="w-64 bg-amber-900 text-white flex flex-col transform transition-transform duration-300 ease-in-out md:translate-x-0 -translate-x-full fixed md:relative h-full z-50">
    <!-- Logo -->
    <div class="flex items-center justify-between p-4 border-b border-amber-700">
        <div class="flex items-center space-x-3">
            <div class="w-8 h-8 bg-white rounded-lg flex items-center justify-center">
                <span class="text-amber-900 font-bold text-sm">K</span>
            </div>
            <span class="text-xl font-semibold">KayUmah</span>
        </div>
        
        <!-- Close button for mobile -->
        <button class="md:hidden text-white" onclick="toggleSidebar()">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
            </svg>
        </button>
    </div>
    
    <!-- Navigation Menu -->
    <nav class="flex-1 overflow-y-auto py-4">
        <ul class="space-y-2 px-3">
            <!-- Dashboard -->
            <li>
                <a href="{{ route('admin.dashboard') }}" 
                   class="flex items-center space-x-3 px-4 py-3 rounded-lg transition-colors duration-200 
                          {{ Request::routeIs('admin.dashboard') ? 'bg-amber-800 text-white' : 'text-amber-100 hover:bg-amber-800' }}">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                    </svg>
                    <span>Dashboard</span>
                </a>
            </li>
            
            <!-- Products -->
            <li>
                <a href="{{ route('admin.products.index') }}" 
                   class="flex items-center space-x-3 px-4 py-3 rounded-lg transition-colors duration-200 
                          {{ Request::routeIs('admin.products.*') ? 'bg-amber-800 text-white' : 'text-amber-100 hover:bg-amber-800' }}">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
                    </svg>
                    <span>Produk</span>
                </a>
            </li>
            
            <!-- Categories -->
            <li>
                <a href="{{ route('admin.categories.index') }}" 
                   class="flex items-center space-x-3 px-4 py-3 rounded-lg transition-colors duration-200 
                          {{ Request::routeIs('admin.categories.*') ? 'bg-amber-800 text-white' : 'text-amber-100 hover:bg-amber-800' }}">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/>
                    </svg>
                    <span>Kategori</span>
                </a>
            </li>
            
            <!-- Orders -->
            <li>
                <a href="{{ route('admin.orders.index') }}" 
                   class="flex items-center space-x-3 px-4 py-3 rounded-lg transition-colors duration-200 
                          {{ Request::routeIs('admin.orders.*') ? 'bg-amber-800 text-white' : 'text-amber-100 hover:bg-amber-800' }}">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/>
                    </svg>
                    <span>Pesanan</span>
                </a>
            </li>
            
            <!-- Users -->
            <li>
                <a href="{{ route('admin.users.index') }}" 
                   class="flex items-center space-x-3 px-4 py-3 rounded-lg transition-colors duration-200 
                          {{ Request::routeIs('admin.users.*') ? 'bg-amber-800 text-white' : 'text-amber-100 hover:bg-amber-800' }}">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z"/>
                    </svg>
                    <span>Pengguna</span>
                </a>
            </li>
        </ul>
    </nav>
    
    <!-- Footer Sidebar -->
    <div class="p-4 border-t border-amber-700">
        <!-- Logout -->
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" 
                    class="flex items-center space-x-3 w-full px-4 py-3 rounded-lg text-amber-100 hover:bg-amber-800 transition-colors duration-200">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>
                </svg>
                <span>Keluar</span>
            </button>
        </form>
    </div>
</aside>

<!-- Overlay for mobile -->
<div id="overlay" class="fixed inset-0 bg-black bg-opacity-50 z-40 md:hidden" onclick="toggleSidebar()" style="display: none;"></div>

<!-- Mobile menu button -->
<button class="md:hidden fixed top-4 left-4 z-30 bg-amber-900 text-white p-2 rounded-lg" onclick="toggleSidebar()">
    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
    </svg>
</button>

<script>
    function toggleSidebar() {
        const sidebar = document.getElementById('sidebar');
        const overlay = document.getElementById('overlay');
        
        sidebar.classList.toggle('-translate-x-full');
        
        if (sidebar.classList.contains('-translate-x-full')) {
            overlay.style.display = 'none';
        } else {
            overlay.style.display = 'block';
        }
    }
</script>