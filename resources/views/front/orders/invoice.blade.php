<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <title>Invoice {{ $order->order_number }}</title>
    <style>
        body { font-family: DejaVu Sans, Arial, sans-serif; font-size: 12px; }
        .header { text-align: center; margin-bottom: 20px; }
        .items table { width: 100%; border-collapse: collapse; }
        .items th, .items td { border: 1px solid #ddd; padding: 8px; }
        .right { text-align: right; }
    </style>
 </head>
<body>
    <div class="header">
        <h2>KayUmah</h2>
        <p>Invoice: {{ $order->order_number }}</p>
        <p>Date: {{ $order->created_at->format('d M Y H:i') }}</p>
    </div>

    <div class="billing">
        <p><strong>Customer:</strong> {{ $order->user->name ?? 'Guest' }}</p>
        <p><strong>Shipping Address:</strong> {{ $order->shipping_address }}</p>
    </div>

    <div class="items" style="margin-top:20px;">
        <table>
            <thead>
                <tr>
                    <th>Product</th>
                    <th class="right">Price</th>
                    <th class="right">Qty</th>
                    <th class="right">Subtotal</th>
                </tr>
            </thead>
            <tbody>
                @foreach($order->items as $item)
                <tr>
                    <td>{{ $item->product->name ?? 'Product deleted' }}</td>
                    <td class="right">Rp {{ number_format($item->price, 2, ',', '.') }}</td>
                    <td class="right">{{ $item->quantity }}</td>
                    <td class="right">Rp {{ number_format($item->subtotal, 2, ',', '.') }}</td>
                </tr>
                @endforeach
            </tbody>
            <tfoot>
                <tr>
                    <td colspan="3" class="right"><strong>Total</strong></td>
                    <td class="right"><strong>Rp {{ number_format($order->total_amount, 2, ',', '.') }}</strong></td>
                </tr>
            </tfoot>
        </table>
    </div>

</body>
</html>
