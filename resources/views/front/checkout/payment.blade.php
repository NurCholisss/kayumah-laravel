@extends('layouts.app')

@section('title', 'Payment - KayUmah')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <div class="mb-8">
        <h1 class="text-3xl md:text-4xl font-elegant font-bold text-gray-800">Pembayaran untuk Order {{ $order->order_number }}</h1>
        <p class="text-gray-600 mt-2">Pilih metode pembayaran untuk menyelesaikan pesanan Anda</p>
    </div>

    @if(session('error'))
        <div class="bg-red-100 border border-red-400 text-red-800 px-4 py-3 rounded mb-6">
            {{ session('error') }}
        </div>
    @endif

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <!-- Payment Methods -->
        <div class="lg:col-span-2">
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
                <h2 class="text-xl font-semibold text-gray-800 mb-6">Pilih Metode Pembayaran</h2>

                <form action="{{ route('payment.process', $order->id) }}" method="POST" id="paymentForm">
                    @csrf
                    
                    <!-- COD Option -->
                    <label class="mb-6 block">
                        <div class="flex items-center p-4 border-2 border-gray-200 rounded-lg cursor-pointer hover:border-amber-500 transition-colors" onclick="selectPaymentMethod('cod')">
                            <input type="radio" name="method" value="cod" class="w-5 h-5 text-amber-800 cursor-pointer" id="methodCod">
                            <div class="ml-4 flex-1">
                                <p class="font-semibold text-gray-800">Bayar di Tempat (COD)</p>
                                <p class="text-sm text-gray-600">Pembayaran saat barang diterima</p>
                            </div>
                        </div>
                    </label>

                    <!-- Online Payment Option -->
                    <label class="block">
                        <div class="flex items-center p-4 border-2 border-gray-200 rounded-lg cursor-pointer hover:border-amber-500 transition-colors" onclick="selectPaymentMethod('online')">
                            <input type="radio" name="method" value="online" class="w-5 h-5 text-amber-800 cursor-pointer" id="methodOnline" checked>
                            <div class="ml-4 flex-1">
                                <p class="font-semibold text-gray-800">Transfer Bank / E-wallet</p>
                                <p class="text-sm text-gray-600">Gunakan Virtual Account untuk transfer ke rekening kami</p>
                            </div>
                        </div>
                    </label>

                    <button type="submit" class="w-full bg-amber-800 hover:bg-amber-700 text-white font-semibold px-6 py-3 rounded-lg transition-colors duration-200 mt-8">
                        Lanjutkan Pembayaran
                    </button>
                </form>
            </div>
        </div>

        <!-- Order Summary -->
        <div class="lg:col-span-1">
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 sticky top-24">
                <h3 class="text-lg font-semibold text-gray-800 mb-4">Ringkasan Pesanan</h3>
                
                <div class="space-y-3 mb-6 pb-6 border-b border-gray-200">
                    <div class="flex justify-between">
                        <span class="text-gray-600">Order Number:</span>
                        <span class="font-semibold text-gray-800">{{ $order->order_number }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-gray-600">Subtotal:</span>
                        <span class="font-semibold text-gray-800">Rp {{ number_format($order->total_amount, 0, ',', '.') }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-gray-600">Ongkos Kirim:</span>
                        <span class="font-semibold text-green-600">Gratis</span>
                    </div>
                </div>

                <div class="space-y-3 mb-6">
                    <div class="flex justify-between text-lg">
                        <span class="font-semibold text-gray-800">Total Pembayaran:</span>
                        <span class="font-bold text-amber-800">Rp {{ number_format($order->total_amount, 0, ',', '.') }}</span>
                    </div>
                </div>

                <div class="bg-amber-50 p-4 rounded-lg mb-6">
                    <p class="text-sm text-gray-700"><span class="font-semibold">Status:</span> {{ ucfirst($order->payment_status) }}</p>
                    <p class="text-sm text-gray-700 mt-2"><span class="font-semibold">Alamat Pengiriman:</span> {{ Str::limit($order->shipping_address, 50) }}</p>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    function selectPaymentMethod(method) {
        document.getElementById('method' + (method === 'cod' ? 'Cod' : 'Online')).checked = true;
    }
</script>
@endsection
