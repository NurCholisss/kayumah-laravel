<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function index()
    {
        $orders = Order::with('user')->latest()->get();
        return view('admin.orders.index', compact('orders'));
    }

    public function show(Order $order)
    {
        $order->load(['user', 'items.product']);
        return view('admin.orders.show', compact('order'));
    }

    public function updateStatus(Request $request, Order $order)
    {
        $validated = $request->validate([
            'order_status' => 'required|in:pending,processed,shipped,completed,cancelled',
        ]);

        // Determine payment_status based on selected order_status
        $statusMap = [
            'pending' => 'pending',
            'processed' => 'pending',
            'shipped' => 'paid',
            'completed' => 'paid',
            'cancelled' => 'failed',
        ];

        $paymentStatus = $statusMap[$validated['order_status']] ?? 'pending';

        $order->update([
            'order_status' => $validated['order_status'],
            'payment_status' => $paymentStatus,
        ]);

        // Redirect back to orders management list
        return redirect()->route('admin.orders.index')
            ->with('success', 'Order status and payment status updated successfully.');
    }
}