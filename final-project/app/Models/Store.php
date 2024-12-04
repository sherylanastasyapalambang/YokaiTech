<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Store extends Model
{
    protected $fillable = [
        'seller_id',
        'slug',
        'name',
        'description',
        'address',
        'phone',
        'storeImage',
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($store) {
            $store->slug = Str::slug($store->name);
        });
    }

    public function seller()
    {
        return $this->belongsTo(User::class, 'seller_id');
    }

    public function products()
    {
        return $this->hasMany(Product::class);
    }

    
}
