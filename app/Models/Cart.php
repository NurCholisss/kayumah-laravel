<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'product_id', 'quantity'];

    // Relasi ke user (cart belongs to user)
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Relasi ke product (cart belongs to product)
    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    // Hitung subtotal untuk item cart
    public function getSubtotalAttribute(): float
    {
        return $this->product->price * $this->quantity;
    }
}