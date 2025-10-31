<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'KayUmah - Furniture Rumah Estetik')</title>
    
    <!-- TailwindCSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    
    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&family=Playfair+Display:wght@400;500;600;700&display=swap" rel="stylesheet">
    
    <!-- Heroicons -->
    <script src="https://unpkg.com/@heroicons/vue@2.0.16/outline/index.js"></script>
    
    <style>
        body {
            font-family: 'Poppins', sans-serif;
        }
        
        .font-elegant {
            font-family: 'Playfair Display', serif;
        }
        
        .natural-gradient {
            background: linear-gradient(135deg, #fef7ed 0%, #fefefe 100%);
        }
    </style>
</head>
<body class="bg-white">
    <!-- Navbar -->
    @include('components.navbar')
    
    <!-- Main Content -->
    <main>
        @yield('content')
    </main>
    
    <!-- Footer -->
    <footer class="bg-amber-900 text-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
                <!-- Logo & Description -->
                <div class="md:col-span-2">
                    <div class="flex items-center space-x-3 mb-4">
                        <div class="w-8 h-8 bg-white rounded-lg flex items-center justify-center">
                            <span class="text-amber-900 font-bold text-sm">K</span>
                        </div>
                        <span class="text-xl font-elegant font-semibold">KayUmah</span>
                    </div>
                    <p class="text-amber-100 leading-relaxed">
                        KayUmah menyediakan furniture rumah berkualitas dengan desain estetik dan natural. 
                        Setiap produk dibuat dengan perhatian pada detail dan kenyamanan.
                    </p>
                </div>
                
                <!-- Quick Links -->
                <div>
                    <h3 class="font-semibold text-lg mb-4">Tautan Cepat</h3>
                    <ul class="space-y-2">
                        <li><a href="{{ route('home') }}" class="text-amber-100 hover:text-white transition-colors">Beranda</a></li>
                        <li><a href="{{ route('products.index') }}" class="text-amber-100 hover:text-white transition-colors">Produk</a></li>
                        <li><a href="#" class="text-amber-100 hover:text-white transition-colors">Tentang Kami</a></li>
                        <li><a href="#" class="text-amber-100 hover:text-white transition-colors">Kontak</a></li>
                    </ul>
                </div>
                
                <!-- Contact Info -->
                <div>
                    <h3 class="font-semibold text-lg mb-4">Kontak</h3>
                    <div class="space-y-2 text-amber-100">
                        <p>📧 hello@kayumah.com</p>
                        <p>📞 (021) 1234-5678</p>
                        <p>📍 Jakarta, Indonesia</p>
                    </div>
                </div>
            </div>
            
            <div class="border-t border-amber-700 mt-8 pt-8 text-center text-amber-200">
                <p>&copy; 2024 KayUmah. All rights reserved.</p>
            </div>
        </div>
    </footer>

    <!-- Scripts -->
    <script>
        // Mobile menu toggle
        function toggleMobileMenu() {
            const menu = document.getElementById('mobile-menu');
            menu.classList.toggle('hidden');
        }
        
        // Auto-hide flash messages
        document.addEventListener('DOMContentLoaded', function() {
            setTimeout(() => {
                const flashMessages = document.querySelectorAll('.bg-green-100, .bg-red-100');
                flashMessages.forEach(msg => {
                    msg.style.display = 'none';
                });
            }, 5000);
        });
    </script>
    
    @yield('scripts')
</body>
</html>