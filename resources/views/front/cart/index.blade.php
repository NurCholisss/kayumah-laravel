@extends('layouts.app')

@section('title', 'Keranjang Belanja - KayUmah')
@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <!-- Header -->
    <div class="mb-8">
        <h1 class="text-3xl md:text-4xl font-elegant font-bold text-gray-800">Keranjang Belanja</h1>
        <p class="text-gray-600 mt-2">Review produk yang akan Anda beli</p>
    </div>

    @if($cartItems->count() > 0)
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <!-- Cart Items -->
        <div class="lg:col-span-2">
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
                <!-- Cart Header -->
                <div class="border-b border-gray-200 px-6 py-4 bg-gray-50">
                    <h2 class="text-lg font-semibold text-gray-800">Item Belanja ({{ $cartItems->count() }})</h2>
                </div>
                
                <!-- Cart Items List -->
                <div class="divide-y divide-gray-200">
                    @foreach($cartItems as $item)
                    <div class="p-6">
                        <div class="flex items-start space-x-4">
                            <!-- Product Image -->
                            <div class="flex-shrink-0 w-20 h-20 bg-gray-200 rounded-lg overflow-hidden">
                                <img src="{{ $item->product->main_image ? asset('storage/' . $item->product->main_image) : 'https://images.unsplash.com/photo-1555041469-a586c61ea9bc?ixlib=rb-4.0.3&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=1170&q=80' }}" 
                                     alt="{{ $item->product->name }}" 
                                     class="w-full h-full object-cover">
                            </div>
                            
                            <!-- Product Info -->
                            <div class="flex-1 min-w-0">
                                <a href="{{ route('products.show', $item->product) }}" 
                                   class="text-lg font-semibold text-gray-800 hover:text-amber-800 transition-colors">
                                    {{ $item->product->name }}
                                </a>
                                <p class="text-gray-600 text-sm mt-1">{{ $item->product->category->name }}</p>
                                <p class="text-amber-800 font-semibold text-lg mt-2">
                                    Rp {{ number_format($item->product->price, 0, ',', '.') }}
                                </p>
                            </div>
                            
                            <!-- Quantity Controls -->
                            <div class="flex items-center space-x-3">
                                <form action="{{ route('cart.update', $item) }}" method="POST">
                                    @csrf
                                    @method('PUT')
                                    <div class="flex items-center border border-gray-300 rounded-lg">
                                        <button type="button" onclick="this.parentNode.querySelector('input[type=number]').stepDown()" 
                                                class="px-3 py-1 text-gray-600 hover:text-amber-800 transition-colors">-</button>
                                        <input type="number" name="quantity" value="{{ $item->quantity }}" min="1" max="{{ $item->product->stock }}"
                                               class="w-12 text-center border-0 focus:ring-0" onchange="this.form.submit()">
                                        <button type="button" onclick="this.parentNode.querySelector('input[type=number]').stepUp()" 
                                                class="px-3 py-1 text-gray-600 hover:text-amber-800 transition-colors">+</button>
                                    </div>
                                </form>
                                
                                <!-- Remove Button -->
                                <form action="{{ route('cart.destroy', $item) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" 
                                            class="text-red-600 hover:text-red-800 transition-colors p-2">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                        </svg>
                                    </button>
                                </form>
                            </div>
                        </div>
                        
                        <!-- Subtotal -->
                        <div class="flex justify-between items-center mt-4 pt-4 border-t border-gray-100">
                            <span class="text-gray-600">Subtotal</span>
                            <span class="text-lg font-semibold text-gray-800">
                                Rp {{ number_format($item->product->price * $item->quantity, 0, ',', '.') }}
                            </span>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>

        <!-- Order Summary -->
        <div class="lg:col-span-1">
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 sticky top-24">
                <h3 class="text-lg font-semibold text-gray-800 mb-4">Ringkasan Belanja</h3>
                
                <div class="space-y-3 mb-6">
                    <div class="flex justify-between">
                        <span class="text-gray-600">Subtotal</span>
                        <span class="text-gray-800">Rp {{ number_format($total, 0, ',', '.') }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-gray-600">Ongkos Kirim</span>
                        <span class="text-green-600">Gratis</span>
                    </div>
                    <div class="border-t border-gray-200 pt-3">
                        <div class="flex justify-between text-lg font-semibold">
                            <span class="text-gray-800">Total</span>
                            <span class="text-amber-800">Rp {{ number_format($total, 0, ',', '.') }}</span>
                        </div>
                    </div>
                </div>
                
                <!-- Checkout Button -->
                <a href="{{ route('checkout.index') }}" 
                   class="w-full bg-amber-800 text-white py-3 px-6 rounded-lg hover:bg-amber-700 transition-colors duration-200 font-semibold text-center block">
                    Lanjut ke Checkout
                </a>
                
                <!-- Continue Shopping -->
                <a href="{{ route('products.index') }}" 
                   class="w-full border border-gray-300 text-gray-700 py-3 px-6 rounded-lg hover:bg-gray-50 transition-colors duration-200 font-medium text-center block mt-3">
                    Lanjut Belanja
                </a>
            </div>
        </div>
    </div>
    @else
    <!-- Empty Cart -->
    <div class="text-center py-16">
        <svg class="w-24 h-24 text-gray-400 mx-auto mb-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"/>
        </svg>
        <h3 class="text-2xl font-elegant font-bold text-gray-800 mb-4">Keranjang Belanja Kosong</h3>
        <p class="text-gray-600 mb-8 max-w-md mx-auto">
            Belum ada produk di keranjang belanja Anda. Yuk, jelajahi koleksi furniture estetik kami!
        </p>
        <a href="{{ route('products.index') }}" 
           class="bg-amber-800 text-white px-8 py-3 rounded-lg hover:bg-amber-700 transition-colors duration-200 font-semibold text-lg">
            Mulai Belanja
        </a>
    </div>
    @endif
</div>
@endsection