@extends('layouts.app')

@section('title', 'Order Status - KayUmah')

@section('content')
<div class="py-4">
    <div class="max-w-2xl mx-auto space-y-6">
        <h1 class="text-2xl lg:text-3xl font-bold mb-2 leading-tight">Status Pesanan {{ $order->order_number }}</h1>

        @if(session('success'))
            <div class="bg-green-100 text-green-800 p-3 mb-4 rounded">{{ session('success') }}</div>
        @endif

        <div class="bg-white p-5 shadow rounded mb-4">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-3 text-sm text-gray-700">
                <div><span class="font-medium">Status Pesanan:</span> {{ ucfirst($order->order_status) }}</div>
                <div><span class="font-medium">Status Pembayaran:</span> {{ ucfirst($order->payment_status) }}</div>
                <div><span class="font-medium">Total:</span> Rp {{ number_format($order->total_amount, 2, ',', '.') }}</div>
                <div><span class="font-medium">Dibuat pada:</span> {{ $order->created_at->format('d M Y H:i') }}</div>
                <div class="md:col-span-2"><span class="font-medium">Alamat Pengiriman:</span>
                    <div class="text-gray-800 mt-1 whitespace-normal break-all">{{ $order->shipping_address }}</div>
                </div>
            </div>

            <!-- If VA info present in session (after choosing online payment), show instructions -->
            @if(session('va_info'))
            @php $va = session('va_info'); @endphp
            <div class="mt-4 border-t pt-4">
                <h4 class="font-medium mb-2">Instruksi Pembayaran (Virtual Account)</h4>
                <div class="text-sm text-gray-700 space-y-1">
                    <div><strong>Bank:</strong> {{ $va['bank'] }}</div>
                    <div><strong>No. VA:</strong> <span class="font-mono">{{ $va['va_number'] }}</span></div>
                    <div><strong>Nama Rekening:</strong> {{ $va['account_name'] }}</div>
                    <div><strong>Jumlah:</strong> Rp {{ $va['amount'] }}</div>
                    <div class="text-xs text-gray-500 mt-2">Silakan lakukan transfer ke nomor Virtual Account di atas. Setelah transfer diterima, status pembayaran akan diperbarui.</div>
                </div>

                <!-- Upload Bukti Transfer Form -->
                <div class="mt-4 border-t pt-4">
                    <h4 class="font-medium mb-3">Unggah Bukti Transfer</h4>
                    @if($order->payment_proof)
                        <div class="mb-3 p-3 bg-green-50 border border-green-200 rounded">
                            <p class="text-sm text-green-700 mb-2">✓ Bukti transfer sudah diunggah</p>
                            <a href="{{ asset('storage/' . $order->payment_proof) }}" target="_blank" class="text-amber-800 underline text-sm">Lihat bukti transfer</a>
                        </div>
                    @endif
                    <form action="{{ route('payment.uploadProof', $order->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="mb-3">
                            <label class="block text-sm font-medium text-gray-700 mb-2">Pilih file bukti transfer (JPG, PNG, PDF - max 5MB)</label>
                            <input type="file" name="payment_proof" accept="image/jpeg,image/png,application/pdf" required 
                                   class="block w-full text-sm text-gray-500
                                   file:mr-4 file:py-2 file:px-4
                                   file:rounded-lg file:border-0
                                   file:text-sm file:font-semibold
                                   file:bg-amber-50 file:text-amber-800
                                   hover:file:bg-amber-100" />
                            @error('payment_proof')
                                <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                        <button type="submit" class="w-full bg-amber-800 text-white px-4 py-2 rounded hover:bg-amber-700 font-medium">Unggah Bukti Transfer</button>
                    </form>
                </div>
            </div>
            @endif
        </div>

        <div class="bg-white p-5 shadow rounded">
        <h2 class="font-semibold mb-3">Items</h2>
        <div class="overflow-x-auto">
            <table class="w-full table-auto border-collapse">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-4 py-2 text-left text-sm font-medium">Produk</th>
                        <th class="px-4 py-2 text-sm font-medium text-right">Harga</th>
                        <th class="px-4 py-2 text-sm font-medium text-center">Jumlah</th>
                        <th class="px-4 py-2 text-sm font-medium text-right">Subtotal</th>
                    </tr>
                </thead>
                <tbody class="divide-y">
                    @foreach($order->items as $item)
                    <tr>
                        <td class="px-4 py-2 text-sm">{{ $item->product->name ?? 'Product deleted' }}</td>
                        <td class="px-4 py-2 text-sm text-right">Rp {{ number_format($item->price, 2, ',', '.') }}</td>
                        <td class="px-4 py-2 text-sm text-center">{{ $item->quantity }}</td>
                        <td class="px-4 py-2 text-sm text-right">Rp {{ number_format($item->subtotal, 2, ',', '.') }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <!-- PDF Invoice Preview -->
        <div class="mt-6">
            <h3 class="font-semibold mb-2">Preview Invoice (PDF)</h3>

            <div class="border rounded overflow-hidden">
                <iframe src="{{ route('orders.invoice', $order->id) }}?disposition=inline" 
                        class="w-full" style="height:600px;" frameborder="0"></iframe>
            </div>

            <div class="mt-2 flex justify-end space-x-2">
                <a href="{{ route('orders.invoice', $order->id) }}" 
                   class="inline-block bg-amber-800 text-white px-3 py-2 rounded hover:bg-amber-700">Download PDF</a>
                <a href="{{ route('orders.invoice', $order->id) }}?disposition=inline" target="_blank" 
                   class="inline-block border border-gray-300 px-3 py-2 rounded hover:bg-gray-50">Open in new tab</a>
            </div>
        </div>

        <!-- Back to home placed at the bottom as requested -->
        <div class="mt-6">
            <a href="{{ route('home') }}" class="inline-block bg-gray-200 text-black px-4 py-2 rounded hover:bg-gray-300 font-medium">Kembali ke Beranda</a>
        </div>

    </div>
</div>

@endsection

