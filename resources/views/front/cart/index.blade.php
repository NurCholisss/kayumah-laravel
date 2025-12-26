@extends('layouts.app')

@section('title', 'Keranjang Belanja - KayUmah')
@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <!-- Header -->
    <div class="mb-8 flex items-center justify-between">
        <div>
            <h1 class="text-3xl md:text-4xl font-elegant font-bold text-gray-800">Keranjang Belanja</h1>
            <p class="text-gray-600 mt-2">Review produk yang akan Anda beli</p>
        </div>
        <div>
            <a href="{{ route('products.index') }}" class="bg-amber-800 text-white px-4 py-2 rounded-lg hover:bg-amber-700 transition-colors font-semibold">Mulai Belanja</a>
        </div>
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
                    <div class="p-6 cart-item" data-price="{{ $item->product->price }}">
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
                                <form action="{{ route('cart.update', $item) }}" method="POST" class="cart-update-form">
                                    @csrf
                                    @method('PUT')
                                    <div class="flex items-center border border-gray-300 rounded-lg">
                    <button type="button" 
                        class="px-3 py-1 text-gray-600 hover:text-amber-800 transition-colors qty-decrease">-</button>
                         <input type="number" name="quantity" value="{{ $item->quantity }}" min="1" max="{{ $item->product->stock }}"
                             class="w-12 text-center border-0 focus:ring-0 cart-quantity" >
                    <button type="button" 
                        class="px-3 py-1 text-gray-600 hover:text-amber-800 transition-colors qty-increase">+</button>
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
                            <span class="text-lg font-semibold text-gray-800 item-subtotal">
                                {{ number_format($item->product->price * $item->quantity, 0, ',', '.') }}
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
                        <span class="text-gray-800" id="cart-subtotal">{{ number_format($total, 0, ',', '.') }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-gray-600">Ongkos Kirim</span>
                        <span class="text-green-600">Gratis</span>
                    </div>
                    <div class="border-t border-gray-200 pt-3">
                        <div class="flex justify-between text-lg font-semibold">
                            <span class="text-gray-800">Total</span>
                            <span class="text-amber-800" id="cart-total">{{ number_format($total, 0, ',', '.') }}</span>
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
        @if(!isset($orders) || $orders->count() == 0)
        <!-- Empty Cart -->
        <div class="text-center py-16">
            <svg class="w-24 h-24 text-gray-400 mx-auto mb-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"/>
            </svg>
            <h3 class="text-2xl font-elegant font-bold text-gray-800 mb-4">Keranjang Belanja Kosong</h3>
            <p class="text-gray-600 mb-8 max-w-md mx-auto">
                Belum ada produk di keranjang belanja Anda. Yuk, jelajahi koleksi furniture estetik kami!
            </p>
            <!-- 'Mulai Belanja' moved to header -->
        </div>
        @endif
    @endif
</div>
    
    <!-- Order history (recent) -->
    @if(isset($orders) && $orders->count() > 0)
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 mt-6">
            <h2 class="text-lg font-semibold mb-4">Riwayat Pesanan Terbaru</h2>

            @foreach($orders as $order)
            <div class="border-t pt-4 mt-4">
                <div class="flex items-center justify-between mb-3">
                    <div>
                        <div class="text-sm font-medium">No. Pesanan: {{ $order->order_number }}</div>
                        <div class="text-xs text-gray-500">{{ $order->created_at->format('d M Y H:i') }}</div>
                    </div>
                    <div class="text-sm">
                        <span class="px-2 py-1 rounded text-white text-xs {{ $order->payment_status == 'paid' ? 'bg-green-600' : 'bg-yellow-500' }}">
                            {{ ucfirst($order->payment_status) }}
                        </span>
                    </div>
                </div>

                <div class="flex justify-end mb-3">
                    @if(method_exists($order, 'canBeCancelled') && $order->canBeCancelled())
                    <form action="{{ route('orders.destroy', $order->id) }}" method="POST" onsubmit="return confirm('Yakin ingin membatalkan pesanan ini? Semua item akan dikembalikan ke stok.');">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="bg-red-600 text-white px-3 py-1 rounded hover:bg-red-700 text-sm">Batalkan Pesanan</button>
                    </form>
                    @endif
                </div>

                <div class="space-y-3">
                    @foreach($order->items as $item)
                    <div class="flex items-center space-x-4">
                        <div class="w-20 h-20 bg-gray-100 rounded overflow-hidden flex-shrink-0">
                            <img src="{{ $item->product && $item->product->main_image ? asset('storage/' . $item->product->main_image) : 'https://images.unsplash.com/photo-1555041469-a586c61ea9bc?ixlib=rb-4.0.3&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=1170&q=80' }}" alt="{{ $item->product->name ?? 'Product' }}" class="w-full h-full object-cover">
                        </div>
                        <div class="flex-1 min-w-0">
                            <div class="text-sm font-medium text-gray-800">{{ $item->product->name ?? 'Product deleted' }}</div>
                            <div class="text-xs text-gray-500">Jumlah: {{ $item->quantity }} &middot; Rp {{ number_format($item->price, 0, ',', '.') }}</div>
                        </div>
                        <div class="text-right">
                            <div class="text-sm font-semibold">Rp {{ number_format($item->subtotal, 0, ',', '.') }}</div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
            @endforeach
        </div>
    </div>
    @endif
@endsection

@section('scripts')
    <script>
document.addEventListener('DOMContentLoaded', function () {
    // currency formatter (IDR, no decimals)
    const fmt = new Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR', maximumFractionDigits: 0 });

    function parseNumber(value) {
        return Number(value) || 0;
    }

    function recalcTotals() {
        // Keep this for initial UI-only calculation fallback; server is the source of truth.
        const items = document.querySelectorAll('.cart-item');
        let subtotal = 0;
        items.forEach(function(item) {
            const price = parseNumber(item.dataset.price);
            const qtyInput = item.querySelector('.cart-quantity');
            const qty = parseNumber(qtyInput ? qtyInput.value : 0);
            const itemTotal = price * qty;
            subtotal += itemTotal;
            const el = item.querySelector('.item-subtotal');
            if (el) {
                el.textContent = fmt.format(itemTotal);
            }
        });

        const subtotalEl = document.getElementById('cart-subtotal');
        const totalEl = document.getElementById('cart-total');
        if (subtotalEl) subtotalEl.textContent = fmt.format(subtotal);
        if (totalEl) totalEl.textContent = fmt.format(subtotal);
    }

    // Attach listeners to quantity inputs for immediate UI update and server persistence
    document.querySelectorAll('.cart-quantity').forEach(function(input) {
        input.addEventListener('input', function() {
            // clamp value between min and max
            const min = parseInt(this.min) || 1;
            const max = parseInt(this.max) || 9999;
            let v = parseInt(this.value) || min;
            if (v < min) v = min;
            if (v > max) v = max;
            this.value = v;

            // Update UI immediately
            recalcTotals();

            // Persist to server via AJAX
            const form = this.closest('.cart-update-form');
            if (!form) return;
            updateCartItem(form, v, this);
        });
    });

    // Also listen to +/- buttons to trigger recalculation and persistence
    document.querySelectorAll('.qty-decrease, .qty-increase').forEach(function(btn) {
        btn.addEventListener('click', function() {
            const input = this.parentNode.querySelector('input[type=number]');
            if (input) {
                // change value using stepUp/stepDown
                if (this.classList.contains('qty-increase')) input.stepUp();
                if (this.classList.contains('qty-decrease')) input.stepDown();

                // dispatch input event to trigger clamping, UI update and persistence
                input.dispatchEvent(new Event('input', { bubbles: true }));
            }
        });
    });

    // Helper: perform AJAX update for a cart item form
    async function updateCartItem(form, quantity, inputEl) {
        try {
            const url = form.getAttribute('action');
            const token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

            const res = await fetch(url, {
                method: 'PUT',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': token,
                    'X-Requested-With': 'XMLHttpRequest'
                },
                body: JSON.stringify({ quantity: quantity })
            });

            if (!res.ok) {
                const data = await res.json().catch(() => ({}));
                const message = data.error || 'Failed to update cart.';
                // revert input to previous value? show simple alert for now
                alert(message);
                return;
            }

            const data = await res.json();

            // Update the specific item subtotal UI
            const itemWrapper = form.closest('.cart-item');
            if (itemWrapper && data.item_subtotal !== undefined) {
                const el = itemWrapper.querySelector('.item-subtotal');
                if (el) el.textContent = fmt.format(data.item_subtotal);
            }

            // Update global cart totals
            if (data.cart_subtotal !== undefined) {
                const subtotalEl = document.getElementById('cart-subtotal');
                const totalEl = document.getElementById('cart-total');
                if (subtotalEl) subtotalEl.textContent = fmt.format(data.cart_subtotal);
                if (totalEl) totalEl.textContent = fmt.format(data.cart_subtotal);
            }

        } catch (err) {
            console.error('updateCartItem error', err);
            alert('Terjadi kesalahan saat memperbarui keranjang. Silakan coba lagi.');
        }
    }

    // Initial calculation (on page load)
    recalcTotals();
});
</script>
@endsection