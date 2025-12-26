<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class OrderController extends Controller
{
    // List semua order
    public function index()
    {
        $orders = Order::with('user', 'items')->orderBy('created_at', 'desc')->paginate(20);
        return view('admin.orders.index', compact('orders'));
    }

    // Tampilkan detail order termasuk bukti pembayaran
    public function show(Order $order)
    {
        $order->load('user', 'items', 'items.product');
        return view('admin.orders.show', compact('order'));
    }

    // Update status order (generic)
    public function updateStatus(Request $request, Order $order)
    {
        $request->validate([
            'order_status' => 'required|string',
            'payment_status' => 'nullable|string',
        ]);

        $data = [];
        if ($request->has('order_status')) {
            $data['order_status'] = $request->order_status;
        }
        if ($request->filled('payment_status')) {
            $data['payment_status'] = $request->payment_status;
        }

        $order->update($data);

        return redirect()->route('admin.orders.show', $order->id)->with('success', 'Order updated.');
    }

    // Approve payment: set payment_status => paid
    public function approvePayment(Order $order)
    {
        $order->update(['payment_status' => 'paid']);
        return redirect()->route('admin.orders.show', $order->id)->with('success', 'Payment approved.');
    }

    // Mark as shipped
    public function markShipped(Order $order)
    {
        $order->update(['order_status' => 'dikirim']);
        return redirect()->route('admin.orders.show', $order->id)->with('success', 'Pesanan ditandai sebagai dikirim.');
    }
}