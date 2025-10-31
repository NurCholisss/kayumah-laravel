@extends('layouts.app')

@section('title', $product->name . ' - KayUmah')
@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <!-- Breadcrumb -->
    <nav class="flex mb-8" aria-label="Breadcrumb">
        <ol class="flex items-center space-x-2 text-sm text-gray-600">
            <li><a href="{{ route('home') }}" class="hover:text-amber-800 transition-colors">Beranda</a></li>
            <li><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg></li>
            <li><a href="{{ route('products.index') }}" class="hover:text-amber-800 transition-colors">Produk</a></li>
            <li><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg></li>
            <li class="text-gray-400">{{ Str::limit($product->name, 30) }}</li>
        </ol>
    </nav>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-12">
        <!-- Product Images -->
        <div>
            <!-- Main Image -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-4 mb-4">
                <img src="{{ $product->main_image ? asset('storage/' . $product->main_image) : 'https://images.unsplash.com/photo-1555041469-a586c61ea9bc?ixlib=rb-4.0.3&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=1170&q=80' }}" 
                     alt="{{ $product->name }}" 
                     class="w-full h-96 object-cover rounded-lg" id="mainImage">
            </div>
            
            <!-- Thumbnail Images -->
            @if($product->images->count() > 0)
            <div class="grid grid-cols-4 gap-2">
                <button onclick="changeImage('{{ asset('storage/' . $product->main_image) }}')" 
                        class="border-2 border-amber-600 rounded-lg overflow-hidden">
                    <img src="{{ asset('storage/' . $product->main_image) }}" 
                         alt="Thumbnail" 
                         class="w-full h-20 object-cover">
                </button>
                @foreach($product->images as $image)
                <button onclick="changeImage('{{ asset('storage/' . $image->image_path) }}')" 
                        class="border border-gray-200 rounded-lg overflow-hidden hover:border-amber-600 transition-colors">
                    <img src="{{ asset('storage/' . $image->image_path) }}" 
                         alt="Thumbnail" 
                         class="w-full h-20 object-cover">
                </button>
                @endforeach
            </div>
            @endif
        </div>

        <!-- Product Info -->
        <div>
            <div class="mb-6">
                <span class="text-sm font-medium text-amber-600 bg-amber-50 px-3 py-1 rounded-full">
                    {{ $product->category->name }}
                </span>
                <h1 class="text-3xl font-elegant font-bold text-gray-800 mt-4 mb-2">{{ $product->name }}</h1>
                
                <!-- Rating -->
                @if($product->reviews->count() > 0)
                <div class="flex items-center space-x-2 mb-4">
                    <div class="flex items-center">
                        @for($i = 1; $i <= 5; $i++)
                            <svg class="w-5 h-5 {{ $i <= $product->averageRating() ? 'text-amber-400' : 'text-gray-300' }}" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                            </svg>
                        @endfor
                    </div>
                    <span class="text-gray-600">({{ $product->reviews->count() }} ulasan)</span>
                </div>
                @endif
                
                <!-- Price -->
                <div class="mb-6">
                    <span class="text-3xl font-bold text-amber-800">Rp {{ number_format($product->price, 0, ',', '.') }}</span>
                </div>
                
                <!-- Stock Status -->
                <div class="mb-6">
                    @if($product->stock > 0)
                        <span class="text-green-600 font-medium">✓ Stok Tersedia</span>
                        <p class="text-sm text-gray-600 mt-1">{{ $product->stock }} unit ready</p>
                    @else
                        <span class="text-red-600 font-medium">✗ Stok Habis</span>
                    @endif
                </div>
            </div>

            <!-- Add to Cart -->
            @if($product->stock > 0)
            <form action="{{ route('cart.store') }}" method="POST" class="mb-8">
                @csrf
                <input type="hidden" name="product_id" value="{{ $product->id }}">
                
                <!-- Quantity Selector -->
                <div class="flex items-center space-x-4 mb-6">
                    <span class="text-gray-700 font-medium">Jumlah:</span>
                    <div class="flex items-center border border-gray-300 rounded-lg">
                        <button type="button" onclick="decreaseQuantity()" class="px-4 py-2 text-gray-600 hover:text-amber-800 transition-colors">-</button>
                        <input type="number" name="quantity" id="quantity" value="1" min="1" max="{{ $product->stock }}" 
                               class="w-16 text-center border-0 focus:ring-0">
                        <button type="button" onclick="increaseQuantity()" class="px-4 py-2 text-gray-600 hover:text-amber-800 transition-colors">+</button>
                    </div>
                    <span class="text-sm text-gray-600">Maks: {{ $product->stock }} unit</span>
                </div>
                
                <!-- Action Buttons -->
                <div class="flex flex-col sm:flex-row gap-4">
                    <button type="submit" 
                            class="flex-1 bg-amber-800 text-white px-8 py-4 rounded-lg hover:bg-amber-700 transition-colors duration-200 font-semibold text-lg">
                        + Tambah ke Keranjang
                    </button>
                    <button type="button" 
                            class="flex-1 border border-amber-800 text-amber-800 px-8 py-4 rounded-lg hover:bg-amber-50 transition-colors duration-200 font-semibold text-lg">
                        Beli Sekarang
                    </button>
                </div>
            </form>
            @else
            <div class="bg-gray-100 rounded-lg p-6 text-center mb-8">
                <p class="text-gray-600 mb-4">Produk sedang tidak tersedia</p>
                <button disabled class="bg-gray-400 text-white px-8 py-4 rounded-lg cursor-not-allowed font-semibold text-lg">
                    Stok Habis
                </button>
            </div>
            @endif

            <!-- Product Description -->
            <div class="border-t border-gray-200 pt-8">
                <h3 class="text-xl font-semibold text-gray-800 mb-4">Deskripsi Produk</h3>
                <div class="prose prose-amber max-w-none text-gray-600 leading-relaxed">
                    {{ $product->description }}
                </div>
            </div>
        </div>
    </div>

    <!-- Related Products -->
    @if($relatedProducts->count() > 0)
    <section class="mt-16">
        <h2 class="text-2xl font-elegant font-bold text-gray-800 mb-8">Produk Serupa</h2>
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
            @foreach($relatedProducts as $relatedProduct)
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden group hover:shadow-lg transition-all duration-300">
                <a href="{{ route('products.show', $relatedProduct) }}" class="block relative overflow-hidden">
                    <img src="{{ $relatedProduct->main_image ? asset('storage/' . $relatedProduct->main_image) : 'https://images.unsplash.com/photo-1555041469-a586c61ea9bc?ixlib=rb-4.0.3&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=1170&q=80' }}" 
                         alt="{{ $relatedProduct->name }}" 
                         class="w-full h-48 object-cover group-hover:scale-105 transition-transform duration-300">
                </a>
                
                <div class="p-4">
                    <h3 class="font-semibold text-gray-800 mb-2 line-clamp-2">{{ $relatedProduct->name }}</h3>
                    <div class="flex items-center justify-between">
                        <span class="text-lg font-bold text-amber-800">Rp {{ number_format($relatedProduct->price, 0, ',', '.') }}</span>
                        @if($relatedProduct->stock > 0)
                            <form action="{{ route('cart.store') }}" method="POST">
                                @csrf
                                <input type="hidden" name="product_id" value="{{ $relatedProduct->id }}">
                                <input type="hidden" name="quantity" value="1">
                                <button type="submit" 
                                        class="bg-amber-800 text-white p-2 rounded-lg hover:bg-amber-700 transition-colors duration-200">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
                                    </svg>
                                </button>
                            </form>
                        @endif
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </section>
    @endif
</div>

<script>
    function changeImage(src) {
        document.getElementById('mainImage').src = src;
    }
    
    function increaseQuantity() {
        const quantityInput = document.getElementById('quantity');
        const max = parseInt(quantityInput.max);
        const current = parseInt(quantityInput.value);
        if (current < max) {
            quantityInput.value = current + 1;
        }
    }
    
    function decreaseQuantity() {
        const quantityInput = document.getElementById('quantity');
        const min = parseInt(quantityInput.min);
        const current = parseInt(quantityInput.value);
        if (current > min) {
            quantityInput.value = current - 1;
        }
    }
</script>
@endsection