<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'slug'];

    // Relasi ke products (1 kategori punya banyak produk)
    public function products()
    {
        return $this->hasMany(Product::class);
    }

    // Auto generate slug dari nama
    public static function boot()
    {
        parent::boot();
        
        static::creating(function ($category) {
            $category->slug = \Str::slug($category->name);
        });

        static::updating(function ($category) {
            $category->slug = \Str::slug($category->name);
        });
    }
}