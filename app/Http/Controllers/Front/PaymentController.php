<?php
namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PaymentController extends Controller
{
    // Tampilkan halaman pembayaran untuk order tertentu
    public function show(Order $order)
    {
        // Pastikan order milik user yang sedang login
        if ($order->user_id !== Auth::id()) {
            abort(403);
        }

        return view('front.checkout.payment', compact('order'));
    }

    // Proses pilihan pembayaran (simulasi sederhana)
    public function process(Request $request, Order $order)
    {
        if ($order->user_id !== Auth::id()) {
            abort(403);
        }

        $request->validate([
            'method' => 'required|in:cod,online',
        ]);

        $method = $request->method;

        if ($method === 'cod') {
            // Cash on Delivery: payment masih pending, ubah order_status
            $order->update([
                'order_status' => 'disetujui',
                'payment_status' => 'pending',
            ]);

            // Redirect to order status page
            return redirect()->route('orders.show', $order->id)->with('success', 'Order confirmed. Pay on delivery.');
        }

        // For 'online' we simulate a Virtual Account transfer flow.
        // Mark payment as pending (awaiting transfer) and keep order disetujui.
        $order->update([
            'payment_status' => 'pending',
            'order_status' => 'disetujui',
        ]);

        // Generate a fake Virtual Account (VA) info for this simulation.
        $vaInfo = [
            'bank' => 'Bank Mandiri',
            'va_number' => '8801' . str_pad($order->id, 8, '0', STR_PAD_LEFT),
            'account_name' => 'KayUmah Store',
            'amount' => number_format($order->total_amount, 0, ',', '.')
        ];

        // Redirect to order status page and share VA info via session flash so the
        // order show view can display transfer instructions.
        return redirect()->route('orders.show', $order->id)
            ->with('success', 'Payment initiated. Silakan lakukan transfer ke Virtual Account di bawah.')
            ->with('va_info', $vaInfo);
    }

    // Upload bukti transfer (image/pdf)
    public function uploadProof(Request $request, Order $order)
    {
        if ($order->user_id !== Auth::id()) {
            abort(403);
        }

        $request->validate([
            'payment_proof' => 'required|file|mimes:jpg,jpeg,png,pdf|max:5120',
        ]);

        $file = $request->file('payment_proof');
        $path = $file->store('payments', 'public');

        $order->update([
            'payment_proof' => $path,
            'payment_status' => 'pending_verification',
            'order_status' => 'disetujui',
        ]);

        return redirect()->route('orders.show', $order->id)->with('success', 'Bukti transfer berhasil diunggah. Menunggu verifikasi admin.');
    }
}
