@extends('layouts.app')

@section('title', 'Payment - KayUmah')

@section('content')
<div class="py-6">
    <h1 class="text-2xl md:text-3xl font-bold mb-6">Pembayaran untuk Order {{ $order->order_number }}</h1>

    @if(session('error'))
        <div class="bg-red-100 text-red-800 p-3 mb-4">{{ session('error') }}</div>
    @endif

    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <div class="bg-white p-6 shadow rounded">
            <h2 class="font-semibold mb-3">Ringkasan Pesanan</h2>
            <div class="space-y-2 text-sm text-gray-700">
                <div><span class="font-medium">Subtotal:</span> Rp {{ number_format($order->total_amount, 2, ',', '.') }}</div>
                <div><span class="font-medium">Alamat Pengiriman:</span> {{ $order->shipping_address }}</div>
                <div><span class="font-medium">Status Pembayaran:</span> {{ ucfirst($order->payment_status) }}</div>
            </div>
        </div>

        <div class="bg-white p-6 shadow rounded">
            <h2 class="font-semibold mb-3">Pilih Metode Pembayaran</h2>

            <form action="{{ route('payment.process', $order->id) }}" method="POST">
                @csrf

                <div class="mb-4">
                    <label class="flex items-center space-x-3">
                        <input type="radio" name="method" value="cod" checked class="form-radio h-4 w-4" />
                        <span>Cash on Delivery (Bayar di Tempat)</span>
                    </label>
                </div>

                <div class="mb-4">
                    <label class="flex items-center space-x-3">
                        <input type="radio" name="method" value="online" class="form-radio h-4 w-4" />
                        <span>Bayar Sekarang (Simulasi Online)</span>
                    </label>
                </div>

                <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded">Lanjutkan Pembayaran</button>
            </form>
        </div>
    </div>
</div>

@endsection
