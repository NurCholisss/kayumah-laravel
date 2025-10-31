<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'order_id', 'product_id', 'quantity', 'price', 'subtotal'
    ];

    protected $casts = [
        'price' => 'decimal:2',
        'subtotal' => 'decimal:2',
    ];

    // Relasi ke order (item belongs to order)
    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    // Relasi ke product (item belongs to product)
    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    // Auto calculate subtotal
    public static function boot()
    {
        parent::boot();
        
        static::creating(function ($item) {
            $item->subtotal = $item->price * $item->quantity;
        });

        static::updating(function ($item) {
            $item->subtotal = $item->price * $item->quantity;
        });
    }
}