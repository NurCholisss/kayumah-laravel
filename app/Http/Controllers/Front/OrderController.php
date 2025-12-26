<?php
namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    // Tampilkan list semua orders user
    public function index()
    {
        $orders = Auth::user()->orders()->orderBy('created_at', 'desc')->get();
        return view('front.orders.index', compact('orders'));
    }

    // Tampilkan status / detail order untuk user
    public function show(Order $order)
    {
        if ($order->user_id !== Auth::id()) {
            abort(403);
        }

        // Load items and product relation
        $order->load('items.product');

        return view('front.orders.show', compact('order'));
    }

    // Generate or stream invoice PDF for an order
    public function invoice(Request $request, Order $order)
    {
        if ($order->user_id !== Auth::id()) {
            abort(403);
        }

        $order->load('items.product');

        // If barryvdh/laravel-dompdf is installed, use it
        if (class_exists('\\Barryvdh\\DomPDF\\Facade\\Pdf') || class_exists('Barryvdh\\DomPDF\\PDF')) {
            // Use facade if available
            if (class_exists('Barryvdh\\DomPDF\\Facade\\Pdf')) {
                $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('front.orders.invoice', compact('order'));
            } else {
                // fallback to main class
                $pdf = app('dompdf.wrapper')->loadView('front.orders.invoice', compact('order'));
            }

            $filename = 'invoice-' . $order->order_number . '.pdf';

            // If requested for inline viewing (iframe), stream the PDF instead of forcing download
            if ($request->query('disposition') === 'inline') {
                return $pdf->stream($filename);
            }

            return $pdf->download($filename);
        }

        // If package not installed, show helpful message with install instructions
        return response()->view('front.orders.invoice-not-installed', compact('order'));
    }

    // Allow user to cancel (delete) their own order when permitted
    public function destroy(Order $order)
    {
        if ($order->user_id !== Auth::id()) {
            abort(403);
        }

        // Only allow cancellation when order status allows it
        if (! $order->canBeCancelled()) {
            return redirect()->back()->with('error', 'Order cannot be cancelled at this stage.');
        }

        DB::transaction(function () use ($order) {
            // Restore product stock for each item
            foreach ($order->items as $item) {
                if ($item->product) {
                    $item->product->increment('stock', $item->quantity);
                }
            }

            // Delete order items and order itself
            $order->items()->delete();
            $order->delete();
        });

        return redirect()->route('cart.index')->with('success', 'Pesanan berhasil dibatalkan dan dihapus.');
    }
}
