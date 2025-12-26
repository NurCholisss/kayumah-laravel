<?php
namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\Cart;
use App\Models\Product;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    public function index()
    {
        $cartItems = Cart::with('product')
            ->where('user_id', Auth::id())
            ->get();

        $total = $cartItems->sum(function ($item) {
            return $item->product->price * $item->quantity;
        });

        return view('front.cart.index', compact('cartItems', 'total'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|integer|min:1',
        ]);

        $product = Product::findOrFail($request->product_id);

        // Cek stok
        if ($product->stock < $request->quantity) {
            return redirect()->back()->with('error', 'Insufficient stock.');
        }

        // Cek jika item sudah ada di cart
        $existingCart = Cart::where('user_id', Auth::id())
            ->where('product_id', $request->product_id)
            ->first();

        if ($existingCart) {
            $existingCart->update([
                'quantity' => $existingCart->quantity + $request->quantity
            ]);
        } else {
            Cart::create([
                'user_id' => Auth::id(),
                'product_id' => $request->product_id,
                'quantity' => $request->quantity,
            ]);
        }

        // Jika ada flag redirect_to_checkout, langsung ke checkout
        if ($request->input('redirect_to_checkout')) {
            return redirect()->route('checkout.index')->with('success', 'Produk berhasil ditambahkan ke keranjang. Lanjutkan ke checkout.');
        }

        return redirect()->back()->with('success', 'Produk berhasil ditambahkan ke keranjang.');
    }

    public function update(Request $request, Cart $cart)
    {
        $request->validate([
            'quantity' => 'required|integer|min:1',
        ]);

        // Cek stok
        if ($cart->product->stock < $request->quantity) {
            if ($request->wantsJson() || $request->expectsJson()) {
                return response()->json(['error' => 'Insufficient stock.'], 422);
            }

            return redirect()->back()->with('error', 'Insufficient stock.');
        }

        $cart->update(['quantity' => $request->quantity]);

        // If this is an AJAX/JSON request, return updated subtotals so frontend can update UI
        if ($request->wantsJson() || $request->expectsJson()) {
            // Recalculate item subtotal and cart totals from authoritative server state
            $itemSubtotal = $cart->product->price * $cart->quantity;

            $cartItems = Cart::with('product')
                ->where('user_id', $cart->user_id)
                ->get();

            $cartSubtotal = $cartItems->sum(function ($item) {
                return $item->product->price * $item->quantity;
            });

            return response()->json([
                'item_subtotal' => $itemSubtotal,
                'cart_subtotal' => $cartSubtotal,
            ]);
        }

        return redirect()->route('cart.index')->with('success', 'Cart updated successfully.');
    }

    public function destroy(Cart $cart)
    {
        // Pastikan user hanya bisa menghapus cart miliknya sendiri
        if ($cart->user_id !== Auth::id()) {
            abort(403);
        }

        $cart->delete();

        return redirect()->route('cart.index')->with('success', 'Item removed from cart.');
    }
}