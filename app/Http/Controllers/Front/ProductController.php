<?php
namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $query = Product::with('category', 'reviews')
            ->where('stock', '>', 0);

        // Filter by category
        if ($request->has('category') && $request->category != '') {
            $query->where('category_id', $request->category);
        }

        // Search by name
        if ($request->has('search') && $request->search != '') {
            $query->where('name', 'like', '%' . $request->search . '%');
        }

        // Apply sorting based on request (default: latest)
        $sort = $request->get('sort', 'latest');
        switch ($sort) {
            case 'price_asc':
                $query->orderBy('price', 'asc');
                break;
            case 'price_desc':
                $query->orderBy('price', 'desc');
                break;
            case 'latest':
            default:
                $query->latest();
                break;
        }

        $products = $query->paginate(12)->withQueryString();

        // Load categories with a products_count that matches the same availability filter (stock > 0)
        $categories = Category::withCount(['products' => function ($q) {
            $q->where('stock', '>', 0);
        }])->get();

        return view('front.products.index', compact('products', 'categories'));
    }

    public function show(Product $product)
    {
        $product->load(['category', 'images', 'reviews.user']);
        
        // Rekomendasi produk dari kategori yang sama
        $relatedProducts = Product::where('category_id', $product->category_id)
            ->where('id', '!=', $product->id)
            ->where('stock', '>', 0)
            ->take(4)
            ->get();

        return view('front.products.show', compact('product', 'relatedProducts'));
    }
}