@extends('layouts.app')

@section('title', 'Katalog Produk - KayUmah')
@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <!-- Header -->
    <div class="mb-8">
        <h1 class="text-3xl md:text-4xl font-elegant font-bold text-gray-800 mb-4">Katalog Furniture</h1>
        <p class="text-gray-600">Temukan furniture perfect untuk setiap ruangan</p>
    </div>

    <div class="flex flex-col lg:flex-row gap-8">
        <!-- Sidebar Filters -->
        <div class="lg:w-1/4">
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 sticky top-24">
                <h3 class="font-semibold text-gray-800 mb-4">Filter Produk</h3>
                
                <!-- Category Filter -->
                <div class="mb-6">
                    <h4 class="font-medium text-gray-700 mb-3">Kategori</h4>
                    <div class="space-y-2">
                        <a href="{{ route('products.index') }}" 
                           class="block text-sm text-gray-600 hover:text-amber-800 transition-colors {{ !request('category') ? 'text-amber-800 font-medium' : '' }}">
                            Semua Kategori
                        </a>
                        @foreach($categories as $category)
                        <a href="{{ route('products.index', ['category' => $category->id]) }}" 
                           class="block text-sm text-gray-600 hover:text-amber-800 transition-colors {{ request('category') == $category->id ? 'text-amber-800 font-medium' : '' }}">
                            {{ $category->name }}
                            <span class="text-gray-400 text-xs">({{ $category->products_count ?? 0 }})</span>
                        </a>
                        @endforeach
                    </div>
                </div>
                
                <!-- Search Form -->
                <div class="mb-6">
                    <h4 class="font-medium text-gray-700 mb-3">Cari Produk</h4>
                    <form action="{{ route('products.index') }}" method="GET">
                        <div class="relative">
                            <input type="text" 
                                   name="search" 
                                   value="{{ request('search') }}"
                                   placeholder="Cari furniture..."
                                   class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-amber-500 focus:border-amber-500 transition-colors">
                            <button type="submit" 
                                    class="absolute right-3 top-1/2 transform -translate-y-1/2 text-gray-400 hover:text-amber-800 transition-colors">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                                </svg>
                            </button>
                        </div>
                    </form>
                </div>
                
                <!-- Clear Filters -->
                @if(request('category') || request('search'))
                <a href="{{ route('products.index') }}" 
                   class="w-full bg-gray-100 text-gray-700 px-4 py-2 rounded-lg hover:bg-gray-200 transition-colors text-center block text-sm">
                    Hapus Filter
                </a>
                @endif
            </div>
        </div>

        <!-- Products Grid -->
        <div class="lg:w-3/4">
            <!-- Results Info -->
            <div class="flex justify-between items-center mb-6">
                <p class="text-gray-600">
                    Menampilkan {{ $products->total() }} produk
                    @if(request('search'))
                        untuk "{{ request('search') }}"
                    @endif
                </p>
                
                <!-- Sort Options (preserve category/search) -->
                <form id="sortForm" method="GET" action="{{ route('products.index') }}">
                    @if(request('category'))
                        <input type="hidden" name="category" value="{{ request('category') }}">
                    @endif
                    @if(request('search'))
                        <input type="hidden" name="search" value="{{ request('search') }}">
                    @endif
                    <select name="sort" onchange="document.getElementById('sortForm').submit()" class="border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-amber-500 focus:border-amber-500 transition-colors">
                        <option value="latest" {{ request('sort', 'latest') == 'latest' ? 'selected' : '' }}>Urutkan: Terbaru</option>
                        <option value="price_asc" {{ request('sort') == 'price_asc' ? 'selected' : '' }}>Harga: Rendah ke Tinggi</option>
                        <option value="price_desc" {{ request('sort') == 'price_desc' ? 'selected' : '' }}>Harga: Tinggi ke Rendah</option>
                    </select>
                </form>
            </div>

            <!-- Products Grid -->
            @if($products->count() > 0)
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach($products as $product)
                <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden group hover:shadow-lg transition-all duration-300">
                    <a href="{{ route('products.show', $product) }}" class="block relative overflow-hidden">
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
                    </a>
                    
                    <div class="p-4">
                        <div class="flex items-center justify-between mb-2">
                            <span class="text-xs font-medium text-amber-600 bg-amber-50 px-2 py-1 rounded">
                                {{ $product->category->name }}
                            </span>
                            @if($product->reviews->count() > 0)
                            <div class="flex items-center space-x-1">
                                <svg class="w-4 h-4 text-amber-400" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                                </svg>
                                <span class="text-xs text-gray-600">{{ number_format($product->averageRating(), 1) }}</span>
                            </div>
                            @endif
                        </div>
                        
                        <a href="{{ route('products.show', $product) }}">
                            <h3 class="font-semibold text-gray-800 mb-2 line-clamp-2 hover:text-amber-800 transition-colors">{{ $product->name }}</h3>
                        </a>
                        <p class="text-gray-600 text-sm mb-3 line-clamp-2">{{ Str::limit($product->description, 80) }}</p>
                        
                        <div class="flex items-center justify-between">
                            <span class="text-lg font-bold text-amber-800">Rp {{ number_format($product->price, 0, ',', '.') }}</span>
                            
                            @if($product->stock > 0)
                                <form action="{{ route('cart.store') }}" method="POST">
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
                </div>
                @endforeach
            </div>

            <!-- Pagination -->
            <div class="mt-12">
                {{ $products->links() }}
            </div>
            @else
            <div class="text-center py-12">
                <svg class="w-16 h-16 text-gray-400 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
                </svg>
                <h3 class="text-lg font-semibold text-gray-800 mb-2">Produk tidak ditemukan</h3>
                <p class="text-gray-600 mb-4">Coba ubah kata kunci pencarian atau filter kategori</p>
                <a href="{{ route('products.index') }}" 
                   class="bg-amber-800 text-white px-6 py-2 rounded-lg hover:bg-amber-700 transition-colors">
                    Lihat Semua Produk
                </a>
            </div>
            @endif
        </div>
    </div>
</div>

<style>
    .line-clamp-2 {
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }
</style>
@endsection