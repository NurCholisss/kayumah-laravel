<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id', 'order_number', 'total_amount', 
        'payment_status', 'order_status', 'shipping_address', 'payment_proof'
    ];

    protected $casts = [
        'total_amount' => 'decimal:2',
    ];

    // Relasi ke user (order belongs to user)
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Relasi ke order_items (1 order punya banyak items)
    public function items()
    {
        return $this->hasMany(OrderItem::class);
    }

    // Generate order number unik
    public static function boot()
    {
        parent::boot();
        
        static::creating(function ($order) {
            $order->order_number = 'KAYU-' . date('Ymd') . '-' . \Str::random(6);
        });
    }

    // Cek apakah order bisa dibatalkan
    public function canBeCancelled(): bool
    {
        return in_array($this->order_status, ['menunggu', 'disetujui']);
    }
}