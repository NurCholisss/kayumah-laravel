<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'category_id', 'name', 'slug', 'description', 
        'price', 'stock', 'main_image'
    ];

    protected $casts = [
        'price' => 'decimal:2',
    ];

    // Relasi ke category (product belongs to category)
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    // Relasi ke product_images (1 produk punya banyak gambar)
    public function images()
    {
        return $this->hasMany(ProductImage::class);
    }

    // Relasi ke carts (product bisa di banyak cart)
    public function carts()
    {
        return $this->hasMany(Cart::class);
    }

    // Relasi ke order_items (product bisa di banyak order items)
    public function orderItems()
    {
        return $this->hasMany(OrderItem::class);
    }

    // Relasi ke reviews (product bisa punya banyak review)
    public function reviews()
    {
        return $this->hasMany(Review::class);
    }

    // Auto generate slug
    public static function boot()
    {
        parent::boot();
        
        static::creating(function ($product) {
            $product->slug = \Str::slug($product->name);
        });

        static::updating(function ($product) {
            $product->slug = \Str::slug($product->name);
        });
    }

    // Hitung rata-rata rating
    public function averageRating(): float
    {
        return $this->reviews()->avg('rating') ?: 0;
    }

    // Cek stok tersedia
    public function inStock(): bool
    {
        return $this->stock > 0;
    }
}