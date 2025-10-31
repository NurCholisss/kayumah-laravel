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
        $cartItems = Cart::with('product')
            ->where('user_id', Auth::id())
            ->get();

        if ($cartItems->isEmpty()) {
            return redirect()->route('cart.index')->with('error', 'Your cart is empty.');
        }

        $total = $cartItems->sum(function ($item) {
            return $item->product->price * $item->quantity;
        });

        return view('front.checkout.index', compact('cartItems', 'total'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'shipping_address' => 'required|string|min:10',
        ]);

        $cartItems = Cart::with('product')
            ->where('user_id', Auth::id())
            ->get();

        if ($cartItems->isEmpty()) {
            return redirect()->route('cart.index')->with('error', 'Your cart is empty.');
        }

        // Cek stok untuk semua item
        foreach ($cartItems as $item) {
            if ($item->product->stock < $item->quantity) {
                return redirect()->route('cart.index')
                    ->with('error', "Insufficient stock for {$item->product->name}.");
            }
        }

        DB::transaction(function () use ($request, $cartItems) {
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

            // Clear cart
            Cart::where('user_id', Auth::id())->delete();
        });

        return redirect()->route('home')->with('success', 'Order placed successfully!');
    }
}