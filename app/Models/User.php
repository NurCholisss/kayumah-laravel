<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name', 'email', 'password', 'role', 'phone', 'address'
    ];

    protected $hidden = [
        'password', 'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    // Relasi ke carts (user memiliki banyak cart items)
    public function carts()
    {
        return $this->hasMany(\App\Models\Cart::class);
    }

    // Relasi ke orders (user memiliki banyak orders)
    public function orders()
    {
        return $this->hasMany(\App\Models\Order::class);
    }

    // Relasi ke reviews (user memiliki banyak reviews)
    public function reviews()
    {
        return $this->hasMany(\App\Models\Review::class);
    }

    // Cek apakah user adalah admin
    public function isAdmin(): bool
    {
        return $this->role === 'admin';
    }
}