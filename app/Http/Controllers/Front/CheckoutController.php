<?php
namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\Cart;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CheckoutController extends Controller
{
    public function index()
    {
        $selectedIds = request()->query('selected', []);
        
        $query = Cart::with('product')
            ->where('user_id', Auth::id());

        // Filter by selected IDs jika ada
        if (!empty($selectedIds)) {
            $query->whereIn('id', $selectedIds);
        }

        $cartItems = $query->get();

        if ($cartItems->isEmpty()) {
            return redirect()->route('cart.index')->with('error', 'Pilih minimal satu item untuk checkout.');
        }

        $total = $cartItems->sum(function ($item) {
            return $item->product->price * $item->quantity;
        });

        return view('front.checkout.index', compact('cartItems', 'total', 'selectedIds'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'shipping_address' => 'required|string|min:10',
            'selected_items' => 'required|array|min:1',
            'selected_items.*' => 'required|exists:carts,id',
        ]);

        $selectedIds = $request->input('selected_items');

        $cartItems = Cart::with('product')
            ->where('user_id', Auth::id())
            ->whereIn('id', $selectedIds)
            ->get();

        if ($cartItems->isEmpty()) {
            return redirect()->route('cart.index')->with('error', 'Pilih minimal satu item untuk checkout.');
        }

        // Cek stok untuk semua item terpilih
        foreach ($cartItems as $item) {
            if ($item->product->stock < $item->quantity) {
                return redirect()->route('cart.index')
                    ->with('error', "Insufficient stock for {$item->product->name}.");
            }
        }

        $order = null;

        DB::transaction(function () use ($request, $cartItems, $selectedIds, &$order) {
            // Create order
            $order = Order::create([
                'user_id' => Auth::id(),
                'total_amount' => $cartItems->sum(function ($item) {
                    return $item->product->price * $item->quantity;
                }),
                'shipping_address' => $request->shipping_address,
            ]);

            // Create order items dan update stok
            foreach ($cartItems as $item) {
                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $item->product_id,
                    'quantity' => $item->quantity,
                    'price' => $item->product->price,
                    'subtotal' => $item->product->price * $item->quantity,
                ]);

                // Update stok produk
                $item->product->decrement('stock', $item->quantity);
            }

            // Delete only selected items from cart
            Cart::where('user_id', Auth::id())
                ->whereIn('id', $selectedIds)
                ->delete();
        });

        // Safety: pastikan order dibuat
        if (! $order) {
            return redirect()->route('home')->with('error', 'Failed to create order. Please try again.');
        }

        // Redirect to payment page to complete payment
        return redirect()->route('payment.show', $order->id)->with('success', 'Order placed. Please complete payment.');
    }
}