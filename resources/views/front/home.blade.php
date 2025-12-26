@extends('layouts.app')

@section('title', 'KayUmah - Furniture Rumah Estetik')
@section('content')
    <!-- Hero Section -->
    <section class="natural-gradient">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-20">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-center">
                <!-- Hero Content -->
                <div class="text-center lg:text-left">
                    <h1 class="text-4xl md:text-5xl lg:text-6xl font-elegant font-bold text-gray-800 leading-tight">
                        Furniture untuk<br>
                        <span class="text-amber-800">Rumah Impian</span> Anda
                    </h1>
                    <p class="mt-6 text-lg text-gray-600 leading-relaxed">
                        Temukan koleksi furniture estetik dengan kualitas terbaik. 
                        Setiap produk dirancang untuk menciptakan kenyamanan dan keindahan di rumah Anda.
                    </p>
                    <div class="mt-8 flex flex-col sm:flex-row gap-4 justify-center lg:justify-start">
                        <a href="{{ route('products.index') }}" 
                           class="bg-amber-800 text-white px-8 py-4 rounded-lg hover:bg-amber-700 transition-colors duration-200 font-medium text-lg">
                            Jelajahi Produk
                        </a>
                        <a href="#featured" 
                           class="border border-amber-800 text-amber-800 px-8 py-4 rounded-lg hover:bg-amber-50 transition-colors duration-200 font-medium text-lg">
                            Lihat Koleksi
                        </a>
                    </div>
                </div>
                
                <!-- Hero Image -->
                <div class="relative">
                    <div class="bg-amber-100 rounded-2xl p-8 transform rotate-3">
                        <div class="bg-white rounded-xl shadow-lg transform -rotate-3 p-4">
                            <img src="https://images.unsplash.com/photo-1555041469-a586c61ea9bc?ixlib=rb-4.0.3&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=1170&q=80" 
                                 alt="Furniture Estetik" 
                                 class="rounded-lg w-full h-80 object-cover">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Categories Section -->
    <section class="py-16 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-12">
                <h2 class="text-3xl md:text-4xl font-elegant font-bold text-gray-800">Kategori Populer</h2>
                <p class="mt-4 text-gray-600 max-w-2xl mx-auto">
                    Temukan furniture sesuai kebutuhan ruangan Anda
                </p>
            </div>
            
            <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5 gap-6">
                @foreach($categories as $category)
                <a href="{{ route('products.index', ['category' => $category->id]) }}" 
                   class="group bg-amber-50 rounded-xl p-6 text-center hover:bg-amber-100 transition-all duration-300 transform hover:-translate-y-1">
                    <div class="w-16 h-16 bg-amber-800 rounded-lg mx-auto mb-4 flex items-center justify-center group-hover:bg-amber-700 transition-colors">
                        <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
                        </svg>
                    </div>
                    <h3 class="font-semibold text-gray-800 group-hover:text-amber-800 transition-colors">{{ $category->name }}</h3>
                    <p class="text-sm text-gray-600 mt-1">{{ $category->products_count ?? 0 }} produk</p>
                </a>
                @endforeach
            </div>
        </div>
    </section>

    <!-- Featured Products -->
    <section id="featured" class="py-16 bg-gray-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-12">
                <h2 class="text-3xl md:text-4xl font-elegant font-bold text-gray-800">Produk Unggulan</h2>
                <p class="mt-4 text-gray-600">Koleksi terbaik pilihan kami</p>
            </div>
            
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                @foreach($featuredProducts as $product)
                <a href="{{ route('products.show', $product) }}" class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden group hover:shadow-lg transition-all duration-300">
                    <div class="relative overflow-hidden">
                        <img src="{{ $product->main_image ? asset('storage/' . $product->main_image) : 'https://images.unsplash.com/photo-1555041469-a586c61ea9bc?ixlib=rb-4.0.3&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=1170&q=80' }}" 
                             alt="{{ $product->name }}" 
                             class="w-full h-48 object-cover group-hover:scale-105 transition-transform duration-300">
                        
                        @if($product->stock == 0)
                            <div class="absolute top-4 right-4 bg-red-500 text-white px-2 py-1 rounded-full text-xs font-medium">
                                Stok Habis
                            </div>
                        @elseif($product->stock < 5)
                            <div class="absolute top-4 right-4 bg-amber-500 text-white px-2 py-1 rounded-full text-xs font-medium">
                                Stok Terbatas
                            </div>
                        @endif
                    </div>
                    
                    <div class="p-4">
                        <div class="flex items-center justify-between mb-2">
                            <span class="text-xs font-medium text-amber-600 bg-amber-50 px-2 py-1 rounded">
                                {{ $product->category->name }}
                            </span>
                            @if($product->reviews_count > 0)
                            <div class="flex items-center space-x-1">
                                <svg class="w-4 h-4 text-amber-400" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                                </svg>
                                <span class="text-xs text-gray-600">{{ number_format($product->averageRating(), 1) }}</span>
                            </div>
                            @endif
                        </div>
                        
                        <h3 class="font-semibold text-gray-800 mb-2 line-clamp-2">{{ $product->name }}</h3>
                        <p class="text-gray-600 text-sm mb-3 line-clamp-2">{{ Str::limit($product->description, 60) }}</p>
                        
                        <div class="flex items-center justify-between">
                            <span class="text-lg font-bold text-amber-800">Rp {{ number_format($product->price, 0, ',', '.') }}</span>
                            
                            @if($product->stock > 0)
                                <form action="{{ route('cart.store') }}" method="POST" onclick="event.stopPropagation();">
                                    @csrf
                                    <input type="hidden" name="product_id" value="{{ $product->id }}">
                                    <input type="hidden" name="quantity" value="1">
                                    <button type="submit" 
                                            class="bg-amber-800 text-white p-2 rounded-lg hover:bg-amber-700 transition-colors duration-200">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
                                        </svg>
                                    </button>
                                </form>
                            @else
                                <button disabled 
                                        class="bg-gray-400 text-white p-2 rounded-lg cursor-not-allowed">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
                                    </svg>
                                </button>
                            @endif
                        </div>
                    </div>
                </a>
                @endforeach
            </div>
            
            <div class="text-center mt-12">
                <a href="{{ route('products.index') }}" 
                   class="inline-flex items-center px-6 py-3 border border-amber-800 text-amber-800 rounded-lg hover:bg-amber-800 hover:text-white transition-all duration-200 font-medium">
                    Lihat Semua Produk
                    <svg class="w-5 h-5 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/>
                    </svg>
                </a>
            </div>
        </div>
    </section>

    <!-- Features Section -->
    <section class="py-16 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <div class="text-center">
                    <div class="w-16 h-16 bg-amber-100 rounded-full flex items-center justify-center mx-auto mb-4">
                        <svg class="w-8 h-8 text-amber-800" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z"/>
                        </svg>
                    </div>
                    <h3 class="text-xl font-semibold text-gray-800 mb-2">Kualitas Premium</h3>
                    <p class="text-gray-600">Material terbaik dengan finishing sempurna untuk furniture yang tahan lama</p>
                </div>
                
                <div class="text-center">
                    <div class="w-16 h-16 bg-amber-100 rounded-full flex items-center justify-center mx-auto mb-4">
                        <svg class="w-8 h-8 text-amber-800" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
                        </svg>
                    </div>
                    <h3 class="text-xl font-semibold text-gray-800 mb-2">Desain Estetik</h3>
                    <p class="text-gray-600">Koleksi furniture dengan desain modern dan timeless untuk rumah impian Anda</p>
                </div>
                
                <div class="text-center">
                    <div class="w-16 h-16 bg-amber-100 rounded-full flex items-center justify-center mx-auto mb-4">
                        <svg class="w-8 h-8 text-amber-800" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"/>
                        </svg>
                    </div>
                    <h3 class="text-xl font-semibold text-gray-800 mb-2">Garansi Produk</h3>
                    <p class="text-gray-600">Dukungan purna jual dan garansi untuk kepuasan pelanggan</p>
                </div>
            </div>
        </div>
    </section>
@endsection