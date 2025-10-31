<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        // Statistik untuk dashboard admin
        $totalProducts = Product::count();
        $totalOrders = Order::count();
        $totalUsers = User::where('role', 'user')->count();
        $recentOrders = Order::with('user')->latest()->take(5)->get();

        return view('admin.dashboard', compact(
            'totalProducts', 
            'totalOrders', 
            'totalUsers', 
            'recentOrders'
        ));
    }
}