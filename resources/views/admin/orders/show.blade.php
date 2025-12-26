@extends('layouts.app')

@section('title', 'Admin - Order #' . $order->id)
@section('content')
<div class="max-w-4xl mx-auto px-4 py-8">
    <h1 class="text-2xl font-bold mb-4">Order #{{ $order->id }}</h1>

    @if(session('success'))
        <div class="mb-4 text-green-700">{{ session('success') }}</div>
    @endif

    <div class="bg-white rounded-lg shadow p-6 mb-6">
        <div class="mb-4">
            <strong>User:</strong> {{ $order->user->name ?? '—' }} / {{ $order->user->email ?? '' }}
        </div>
        <div class="mb-4">
            <strong>Total:</strong> Rp {{ number_format($order->total_amount,0,',','.') }}
        </div>
        <div class="mb-4">
            <strong>Payment Status:</strong> {{ $order->payment_status }}
        </div>
        <div class="mb-4">
            <strong>Order Status:</strong> {{ $order->order_status }}
        </div>

        <div class="mb-4">
            <strong>Bukti Pembayaran:</strong>
            @if($order->payment_proof)
                <div class="mt-2">
                    <a href="{{ asset('storage/' . $order->payment_proof) }}" target="_blank" class="text-amber-800 hover:underline">Lihat Bukti</a>
                    <div class="mt-2">
                        <img src="{{ asset('storage/' . $order->payment_proof) }}" alt="bukti" class="w-64 object-contain border rounded">
                    </div>
                </div>
            @else
                <div class="text-gray-600">Belum diunggah</div>
            @endif
        </div>

        <div class="mt-6">
            <form action="{{ route('admin.orders.updateStatus', $order) }}" method="POST" class="mb-4">
                @csrf
                @method('PUT')
                <label class="block mb-2 font-medium">Ubah Status Pesanan</label>
                <select name="order_status" class="border rounded px-3 py-2">
                    <option value="menunggu" {{ $order->order_status == 'menunggu' ? 'selected' : '' }}>Menunggu</option>
                    <option value="disetujui" {{ $order->order_status == 'disetujui' ? 'selected' : '' }}>Disetujui</option>
                    <option value="dikirim" {{ $order->order_status == 'dikirim' ? 'selected' : '' }}>Dikirim</option>
                    <option value="pesanan diterima" {{ $order->order_status == 'pesanan diterima' ? 'selected' : '' }}>Pesanan Diterima</option>
                    <option value="ditolak" {{ $order->order_status == 'ditolak' ? 'selected' : '' }}>Ditolak</option>
                </select>
                <button type="submit" class="ml-3 bg-amber-800 text-white px-4 py-2 rounded">Simpan</button>
            </form>
        </div>
    </div>

    <div class="bg-white rounded-lg shadow p-6">
        <h2 class="font-semibold mb-4">Items</h2>
        <ul>
            @foreach($order->items as $item)
                <li class="mb-2">{{ $item->product->name ?? '—' }} x {{ $item->quantity }} — Rp {{ number_format($item->price,0,',','.') }}</li>
            @endforeach
        </ul>
    </div>
</div>
@endsection
@section('page-description', 'Informasi lengkap pesanan')

@section('content')
<div class="max-w-6xl space-y-6">
    <!-- Order Summary -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Order Details -->
        <div class="lg:col-span-2 space-y-6">
            <!-- Order Items -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-200">
                <div class="px-6 py-4 border-b border-gray-200">
                    <h3 class="text-lg font-semibold text-gray-800">Item Pesanan</h3>
                </div>
                <div class="p-6">
                    <div class="space-y-4">
                        @foreach($order->items as $item)
                        <div class="flex items-center justify-between p-4 border border-gray-100 rounded-lg">
                            <div class="flex items-center space-x-4">
                                <div class="w-16 h-16 bg-gray-200 rounded-lg overflow-hidden">
                                    @if($item->product->main_image)
                                        <img src="{{ asset('storage/' . $item->product->main_image) }}" alt="{{ $item->product->name }}" class="w-full h-full object-cover">
                                    @else
                                        <div class="w-full h-full bg-gray-300 flex items-center justify-center">
                                            <svg class="w-6 h-6 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
                                            </svg>
                                        </div>
                                    @endif
                                </div>
                                <div>
                                    <h4 class="font-medium text-gray-800">{{ $item->product->name }}</h4>
                                    <p class="text-sm text-gray-600">Qty: {{ $item->quantity }}</p>
                                </div>
                            </div>
                            <div class="text-right">
                                <p class="font-semibold text-gray-800">Rp {{ number_format($item->price, 0, ',', '.') }}</p>
                                <p class="text-sm text-gray-600">Subtotal: Rp {{ number_format($item->subtotal, 0, ',', '.') }}</p>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>

            <!-- Shipping Address -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-200">
                <div class="px-6 py-4 border-b border-gray-200">
                    <h3 class="text-lg font-semibold text-gray-800">Alamat Pengiriman</h3>
                </div>
                <div class="p-6">
                    <p class="text-gray-700 whitespace-pre-line">{{ $order->shipping_address }}</p>
                </div>
            </div>
        </div>

        <!-- Order Actions & Summary -->
        <div class="space-y-6">
            <!-- Order Summary -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                <h3 class="text-lg font-semibold text-gray-800 mb-4">Ringkasan Pesanan</h3>
                <div class="space-y-3">
                    <div class="flex justify-between">
                        <span class="text-gray-600">Subtotal</span>
                        <span class="font-medium">Rp {{ number_format($order->total_amount, 0, ',', '.') }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-gray-600">Ongkos Kirim</span>
                        <span class="font-medium">Gratis</span>
                    </div>
                    <div class="border-t border-gray-200 pt-3 flex justify-between">
                        <span class="text-lg font-semibold text-gray-800">Total</span>
                        <span class="text-lg font-semibold text-gray-800">Rp {{ number_format($order->total_amount, 0, ',', '.') }}</span>
                    </div>
                </div>
            </div>

            <!-- Order Status Update -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                <h3 class="text-lg font-semibold text-gray-800 mb-4">Update Status</h3>
                <form action="{{ route('admin.orders.updateStatus', $order) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="space-y-4">
                        <div>
                            <label for="order_status" class="block text-sm font-medium text-gray-700 mb-2">Status Pesanan</label>
                            <select name="order_status" id="order_status" required
                                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-amber-500 focus:border-amber-500 transition-colors">
                                <option value="pending" {{ $order->order_status === 'pending' ? 'selected' : '' }}>Pending</option>
                                <option value="processed" {{ $order->order_status === 'processed' ? 'selected' : '' }}>Diproses</option>
                                <option value="shipped" {{ $order->order_status === 'shipped' ? 'selected' : '' }}>Dikirim</option>
                                <option value="completed" {{ $order->order_status === 'completed' ? 'selected' : '' }}>Selesai</option>
                                <option value="cancelled" {{ $order->order_status === 'cancelled' ? 'selected' : '' }}>Dibatalkan</option>
                            </select>
                        </div>
                        <button type="submit" 
                                class="w-full px-4 py-2 bg-amber-600 text-white rounded-lg hover:bg-amber-700 transition-colors">
                            Update Status
                        </button>
                    </div>
                </form>
            </div>
            
            <!-- Payment Proof -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                <h3 class="text-lg font-semibold text-gray-800 mb-4">Bukti Pembayaran</h3>
                @if($order->payment_proof)
                    <div class="mb-4">
                        <a href="{{ asset('storage/' . $order->payment_proof) }}" target="_blank">
                            <img src="{{ asset('storage/' . $order->payment_proof) }}" alt="Bukti Pembayaran" class="w-full h-auto rounded">
                        </a>
                    </div>
                    <div class="flex space-x-2">
                        @if($order->payment_status !== 'paid')
                        <form action="{{ route('admin.orders.approvePayment', $order) }}" method="POST">
                            @csrf
                            <button type="submit" class="px-4 py-2 bg-green-600 text-white rounded hover:bg-green-700">Setujui Pembayaran</button>
                        </form>
                        @endif

                        @if($order->order_status !== 'shipped')
                        <form action="{{ route('admin.orders.markShipped', $order) }}" method="POST">
                            @csrf
                            <button type="submit" class="px-4 py-2 bg-amber-600 text-white rounded hover:bg-amber-700">Tandai Dikirim</button>
                        </form>
                        @endif
                    </div>
                @else
                    <p class="text-sm text-gray-600">Belum ada bukti pembayaran yang diunggah oleh pelanggan.</p>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection