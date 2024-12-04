<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Product extends Model
{
    protected $fillable = [
        'store_id',
        'name',
        'slug',
        'description',
        'price',
        'stock',
        'image',
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($product) {
            // Membuat slug awal dengan kombinasi nama dan store_id
            $baseSlug = Str::slug($product->name) . '-' . $product->store_id;

            // Mengecek apakah slug sudah ada di database
            $count = static::where('slug', 'LIKE', "$baseSlug%")->count();

            // Jika ada slug serupa, tambahkan angka di akhir
            $product->slug = $count ? "{$baseSlug}-{$count}" : $baseSlug;
        });
    }

    public function store()
    {
        return $this->belongsTo(Store::class);
    }

    public function categories()
    {
        return $this->belongsToMany(Category::class, 'product_categories');
    }

    public function favorites()
    {
        return $this->hasMany(Favorite::class);
    }

    public function cartItems() {
        return $this->hasMany(CartItem::class);
    }

    public function orderItems() {
        return $this->hasMany(OrderItem::class);
    }

    public function reviews() {
        return $this->hasMany(Review::class);
    }

    public function getRoundedRatingAttribute()
    {
        // Ambil rata-rata rating dari review utama yang dibuat oleh buyer saja
        $averageRating = $this->reviews()
            ->whereNull('parent_id') // Hanya review utama
            ->whereHas('user', function ($query) {
                $query->where('role', 'buyer'); // Hanya review dari buyer
            })
            ->avg('rating'); // Hitung rata-rata rating

        // Jika rata-rata rating ada, bulatkan ke 0.5 terdekat
        return $averageRating 
            ? round($averageRating * 2) / 2 
            : null;
    }


}
