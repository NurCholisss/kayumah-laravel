<?php
namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        // Ambil produk terbaru dan produk populer
        $featuredProducts = Product::with('category')
            ->where('stock', '>', 0)
            ->latest()
            ->take(8)
            ->get();

        $categories = Category::withCount('products')->get();

        return view('front.home', compact('featuredProducts', 'categories'));
    }
}