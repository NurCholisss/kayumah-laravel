@extends('layouts.app')

@section('title', 'Riwayat Pembelian - KayUmah')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <!-- Breadcrumb -->
    <nav class="flex mb-8" aria-label="Breadcrumb">
        <ol class="flex items-center space-x-2 text-sm text-gray-600">
            <li><a href="{{ route('home') }}" class="hover:text-amber-800 transition-colors">Beranda</a></li>
            <li><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg></li>
            <li class="text-gray-400">Riwayat Pembelian</li>
        </ol>
    </nav>

    <div class="mb-8">
        <h1 class="text-3xl font-elegant font-bold text-gray-800">Riwayat Pembelian</h1>
        <p class="text-gray-600 mt-2">Kelola dan lihat detail pesanan Anda</p>
    </div>

    @if(session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded-lg mb-6" role="alert">
            {{ session('success') }}
        </div>
    @endif

    @if($orders->isEmpty())
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-12 text-center">
            <div class="mb-4">
                <svg class="w-16 h-16 text-gray-400 mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2v-9a2 2 0 012-2z"/>
                </svg>
            </div>
            <h2 class="text-xl font-semibold text-gray-800 mb-2">Belum Ada Pesanan</h2>
            <p class="text-gray-600 mb-6">Anda belum memiliki riwayat pembelian. Mulai berbelanja sekarang!</p>
            <a href="{{ route('products.index') }}" 
               class="inline-block bg-amber-800 text-white px-6 py-3 rounded-lg hover:bg-amber-700 transition-colors duration-200 font-medium">
                Jelajahi Produk
            </a>
        </div>
    @else
        <div class="space-y-4">
            @foreach($orders as $order)
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 hover:shadow-md transition-all duration-300 overflow-hidden">
                <div class="grid grid-cols-1 md:grid-cols-5 gap-4 p-6">
                    <!-- Order Number -->
                    <div>
                        <p class="text-sm text-gray-600 mb-1">No. Pesanan</p>
                        <p class="font-semibold text-gray-800">{{ $order->order_number }}</p>
                    </div>

                    <!-- Date -->
                    <div>
                        <p class="text-sm text-gray-600 mb-1">Tanggal</p>
                        <p class="font-semibold text-gray-800">{{ $order->created_at->format('d M Y') }}</p>
                        <p class="text-xs text-gray-500">{{ $order->created_at->format('H:i') }}</p>
                    </div>

                    <!-- Total Amount -->
                    <div>
                        <p class="text-sm text-gray-600 mb-1">Total</p>
                        <p class="font-semibold text-amber-800">Rp {{ number_format($order->total_amount, 0, ',', '.') }}</p>
                    </div>

                    <!-- Order Status -->
                    <div>
                        <p class="text-sm text-gray-600 mb-1">Status Pesanan</p>
                        @php
                            $statusColors = [
                                'pending' => 'bg-yellow-100 text-yellow-800',
                                'processing' => 'bg-blue-100 text-blue-800',
                                'shipped' => 'bg-purple-100 text-purple-800',
                                'delivered' => 'bg-green-100 text-green-800',
                                'cancelled' => 'bg-red-100 text-red-800',
                            ];
                            $statusColor = $statusColors[$order->order_status] ?? 'bg-gray-100 text-gray-800';
                        @endphp
                        <span class="inline-block px-3 py-1 rounded-full text-xs font-semibold {{ $statusColor }}">
                            {{ ucfirst($order->order_status) }}
                        </span>
                    </div>

                    <!-- Payment Status -->
                    <div>
                        <p class="text-sm text-gray-600 mb-1">Status Pembayaran</p>
                        @php
                            $paymentColors = [
                                'unpaid' => 'bg-red-100 text-red-800',
                                'pending' => 'bg-yellow-100 text-yellow-800',
                                'paid' => 'bg-green-100 text-green-800',
                            ];
                            $paymentColor = $paymentColors[$order->payment_status] ?? 'bg-gray-100 text-gray-800';
                        @endphp
                        <span class="inline-block px-3 py-1 rounded-full text-xs font-semibold {{ $paymentColor }}">
                            {{ ucfirst(str_replace('_', ' ', $order->payment_status)) }}
                        </span>
                    </div>
                </div>

                <!-- Action Buttons -->
                <div class="bg-gray-50 px-6 py-3 flex flex-col sm:flex-row gap-3 justify-end border-t border-gray-100">
                    <a href="{{ route('orders.show', $order) }}" 
                       class="inline-flex items-center justify-center px-4 py-2 bg-amber-800 text-white rounded-lg hover:bg-amber-700 transition-colors duration-200 font-medium text-sm">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                        </svg>
                        Lihat Detail
                    </a>
                    <a href="{{ route('orders.invoice', $order) }}" 
                       class="inline-flex items-center justify-center px-4 py-2 border border-amber-800 text-amber-800 rounded-lg hover:bg-amber-50 transition-colors duration-200 font-medium text-sm">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                        </svg>
                        Unduh Invoice
                    </a>
                    @if($order->canBeCancelled())
                    <form action="{{ route('orders.destroy', $order) }}" method="POST" class="inline" onsubmit="return confirm('Yakin ingin membatalkan pesanan ini?');">
                        @csrf
                        @method('DELETE')
                        <button type="submit" 
                                class="w-full sm:w-auto px-4 py-2 border border-red-300 text-red-600 rounded-lg hover:bg-red-50 transition-colors duration-200 font-medium text-sm">
                            Batalkan Pesanan
                        </button>
                    </form>
                    @endif
                </div>
            </div>
            @endforeach
        </div>
    @endif

    <!-- Back to home -->
    <div class="mt-8">
        <a href="{{ route('home') }}" 
           class="inline-flex items-center text-amber-800 hover:text-amber-700 font-medium">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
            </svg>
            Kembali ke Beranda
        </a>
    </div>
</div>

@endsection
