@extends('layouts.app')

@section('title', 'Checkout - KayUmah')
@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <!-- Header -->
    <div class="mb-8">
        <h1 class="text-3xl md:text-4xl font-elegant font-bold text-gray-800">Checkout</h1>
        <p class="text-gray-600 mt-2">Lengkapi informasi pengiriman dan pembayaran</p>
    </div>

    <form action="{{ route('checkout.store') }}" method="POST">
        @csrf
        
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- Checkout Form -->
            <div class="lg:col-span-2">
                <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
                    <h2 class="text-xl font-semibold text-gray-800 mb-6">Informasi Pengiriman</h2>
                    
                    <!-- Shipping Address -->
                    <div class="mb-6">
                        <label for="shipping_address" class="block text-sm font-medium text-gray-700 mb-3">
                            Alamat Pengiriman Lengkap
                        </label>
                        <textarea name="shipping_address" id="shipping_address" rows="4" required
                                  class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-amber-500 focus:border-amber-500 transition-colors"
                                  placeholder="Contoh: Jl. Merdeka No. 123, RT 01/RW 02, Kel. Menteng, Kec. Menteng, Jakarta Pusat 10310"
                                  >{{ old('shipping_address', Auth::user()->address) }}</textarea>
                        @error('shipping_address')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                    
                    <!-- Contact Info -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                        <div>
                            <label for="name" class="block text-sm font-medium text-gray-700 mb-3">Nama Penerima</label>
                            <input type="text" name="name" id="name" required
                                   class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-amber-500 focus:border-amber-500 transition-colors"
                                   value="{{ old('name', Auth::user()->name) }}">
                        </div>
                        
                        <div>
                            <label for="phone" class="block text-sm font-medium text-gray-700 mb-3">Nomor Telepon</label>
                            <input type="tel" name="phone" id="phone" required
                                   class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-amber-500 focus:border-amber-500 transition-colors"
                                   value="{{ old('phone', Auth::user()->phone) }}"
                                   placeholder="Contoh: 081234567890">
                        </div>
                    </div>
                    
                    <!-- Shipping Method -->
                    <div class="mb-6">
                        <h3 class="text-lg font-medium text-gray-800 mb-4">Metode Pengiriman</h3>
                        <div class="space-y-3">
                            <label class="flex items-center p-4 border border-gray-300 rounded-lg cursor-pointer hover:border-amber-500 transition-colors">
                                <input type="radio" name="shipping_method" value="regular" checked class="text-amber-600 focus:ring-amber-500">
                                <div class="ml-3">
                                    <span class="font-medium text-gray-800">Reguler</span>
                                    <p class="text-sm text-gray-600">Estimasi 3-5 hari kerja - Gratis</p>
                                </div>
                            </label>
                            
                            <label class="flex items-center p-4 border border-gray-300 rounded-lg cursor-pointer hover:border-amber-500 transition-colors">
                                <input type="radio" name="shipping_method" value="express" class="text-amber-600 focus:ring-amber-500">
                                <div class="ml-3">
                                    <span class="font-medium text-gray-800">Express</span>
                                    <p class="text-sm text-gray-600">Estimasi 1-2 hari kerja - Rp 50.000</p>
                                </div>
                            </label>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Order Summary -->
            <div class="lg:col-span-1">
                <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 sticky top-24">
                    <h3 class="text-lg font-semibold text-gray-800 mb-4">Ringkasan Pesanan</h3>
                    
                    <!-- Order Items -->
                    <div class="space-y-4 mb-6">
                        @foreach($cartItems as $item)
                        <div class="flex items-center space-x-3">
                            <div class="flex-shrink-0 w-12 h-12 bg-gray-200 rounded-lg overflow-hidden">
                                <img src="{{ $item->product->main_image ? asset('storage/' . $item->product->main_image) : 'https://images.unsplash.com/photo-1555041469-a586c61ea9bc?ixlib=rb-4.0.3&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=1170&q=80' }}" 
                                     alt="{{ $item->product->name }}" 
                                     class="w-full h-full object-cover">
                            </div>
                            <div class="flex-1 min-w-0">
                                <p class="text-sm font-medium text-gray-800 truncate">{{ $item->product->name }}</p>
                                <p class="text-sm text-gray-600">Qty: {{ $item->quantity }}</p>
                            </div>
                            <div class="text-right">
                                <p class="text-sm font-semibold text-gray-800">
                                    Rp {{ number_format($item->product->price * $item->quantity, 0, ',', '.') }}
                                </p>
                            </div>
                        </div>
                        @endforeach
                    </div>
                    
                    <!-- Price Breakdown -->
                    <div class="space-y-2 border-t border-gray-200 pt-4">
                        <div class="flex justify-between">
                            <span class="text-gray-600">Subtotal</span>
                            <span class="text-gray-800">Rp {{ number_format($total, 0, ',', '.') }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-600">Ongkos Kirim</span>
                            <span class="text-green-600">Gratis</span>
                        </div>
                        <div class="flex justify-between text-lg font-semibold border-t border-gray-200 pt-2">
                            <span class="text-gray-800">Total</span>
                            <span class="text-amber-800">Rp {{ number_format($total, 0, ',', '.') }}</span>
                        </div>
                    </div>
                    
                    <!-- Checkout Button -->
                    <button type="submit" 
                            class="w-full bg-amber-800 text-white py-3 px-6 rounded-lg hover:bg-amber-700 transition-colors duration-200 font-semibold mt-6">
                        Buat Pesanan
                    </button>
                    
                    <!-- Back to Cart -->
                    <a href="{{ route('cart.index') }}" 
                       class="w-full border border-gray-300 text-gray-700 py-3 px-6 rounded-lg hover:bg-gray-50 transition-colors duration-200 font-medium text-center block mt-3">
                        Kembali ke Keranjang
                    </a>
                </div>
            </div>
        </div>
    </form>
</div>
@endsection