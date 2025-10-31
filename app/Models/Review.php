<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    use HasFactory;

    protected $fillable = ['product_id', 'user_id', 'rating', 'comment'];

    // Relasi ke product (review belongs to product)
    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    // Relasi ke user (review belongs to user)
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Validasi rating antara 1-5
    public static function boot()
    {
        parent::boot();
        
        static::creating(function ($review) {
            if ($review->rating < 1 || $review->rating > 5) {
                throw new \Exception('Rating must be between 1 and 5');
            }
        });
    }
}