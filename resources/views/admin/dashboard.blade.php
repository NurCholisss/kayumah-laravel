@extends('layouts.admin')

@section('title', 'Dashboard - KayUmah')
@section('page-title', 'Dashboard')
@section('page-description', 'Ringkasan statistik dan aktivitas terbaru')

@section('content')
<div class="space-y-6">
    <!-- Statistics Cards -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <!-- Total Products Card -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-600 text-sm">Total Produk</p>
                    <h3 class="text-3xl font-bold text-gray-800 mt-2">{{ $totalProducts }}</h3>
                    <p class="text-green-600 text-sm mt-1">Tersedia di toko</p>
                </div>
                <div class="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center">
                    <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
                    </svg>
                </div>
            </div>
        </div>

        <!-- Total Orders Card -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-600 text-sm">Total Pesanan</p>
                    <h3 class="text-3xl font-bold text-gray-800 mt-2">{{ $totalOrders }}</h3>
                    <p class="text-amber-600 text-sm mt-1">Pesanan masuk</p>
                </div>
                <div class="w-12 h-12 bg-amber-100 rounded-lg flex items-center justify-center">
                    <svg class="w-6 h-6 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/>
                    </svg>
                </div>
            </div>
        </div>

        <!-- Total Users Card -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-600 text-sm">Total Pelanggan</p>
                    <h3 class="text-3xl font-bold text-gray-800 mt-2">{{ $totalUsers }}</h3>
                    <p class="text-green-600 text-sm mt-1">Aktif</p>
                </div>
                <div class="w-12 h-12 bg-green-100 rounded-lg flex items-center justify-center">
                    <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z"/>
                    </svg>
                </div>
            </div>
        </div>
    </div>

    <!-- Recent Orders & Quick Actions -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Recent Orders -->
        <div class="lg:col-span-2">
            <div class="bg-white rounded-xl shadow-sm border border-gray-200">
                <div class="px-6 py-4 border-b border-gray-200">
                    <h3 class="text-lg font-semibold text-gray-800">Pesanan Terbaru</h3>
                </div>
                <div class="p-6">
                    @if($recentOrders->count() > 0)
                        <div class="space-y-4">
                            @foreach($recentOrders as $order)
                            <div class="flex items-center justify-between p-4 border border-gray-100 rounded-lg hover:bg-gray-50">
                                <div>
                                    <p class="font-medium text-gray-800">#{{ $order->order_number }}</p>
                                    <p class="text-sm text-gray-600">{{ $order->user->name }}</p>
                                </div>
                                <div class="text-right">
                                    <p class="font-semibold text-gray-800">Rp {{ number_format($order->total_amount, 0, ',', '.') }}</p>
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium 
                                        {{ $order->order_status === 'completed' ? 'bg-green-100 text-green-800' : 
                                           ($order->order_status === 'pending' ? 'bg-yellow-100 text-yellow-800' : 
                                           'bg-blue-100 text-blue-800') }}">
                                        {{ ucfirst($order->order_status) }}
                                    </span>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    @else
                        <p class="text-gray-500 text-center py-4">Belum ada pesanan</p>
                    @endif
                </div>
            </div>
        </div>

        <!-- Quick Actions -->
        <div class="space-y-6">
            <!-- Quick Actions Card -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                <h3 class="text-lg font-semibold text-gray-800 mb-4">Aksi Cepat</h3>
                <div class="space-y-3">
                    <a href="{{ route('admin.products.create') }}" 
                       class="flex items-center space-x-3 w-full p-3 border border-gray-200 rounded-lg hover:bg-gray-50 transition-colors">
                        <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
                        </svg>
                        <span class="text-gray-700">Tambah Produk Baru</span>
                    </a>
                    
                    <a href="{{ route('admin.categories.index') }}" 
                       class="flex items-center space-x-3 w-full p-3 border border-gray-200 rounded-lg hover:bg-gray-50 transition-colors">
                        <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/>
                        </svg>
                        <span class="text-gray-700">Kelola Kategori</span>
                    </a>
                    
                    <a href="{{ route('admin.orders.index') }}" 
                       class="flex items-center space-x-3 w-full p-3 border border-gray-200 rounded-lg hover:bg-gray-50 transition-colors">
                        <svg class="w-5 h-5 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/>
                        </svg>
                        <span class="text-gray-700">Lihat Semua Pesanan</span>
                    </a>
                </div>
            </div>

            <!-- Status Info -->
            <div class="bg-amber-50 border border-amber-200 rounded-xl p-6">
                <h3 class="text-lg font-semibold text-amber-800 mb-2">Info Sistem</h3>
                <p class="text-amber-700 text-sm">Panel admin KayUmah berjalan dengan baik. Pantau terus pesanan dan stok produk.</p>
            </div>
        </div>
    </div>
</div>
@endsection