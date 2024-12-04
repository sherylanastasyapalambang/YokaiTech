<?php

namespace App\Models;


// use Illuminate\Contracts\Auth\MustVerifyEmail;

use Illuminate\Support\Facades\Storage;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use App\Models\Order;


class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'address',
        'phone',
        'profileImage',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */

    //  public function getProfilePictureUrlAttribute()
    //  {
    //      return $this->profileImage
    //          ? Storage::url($this->profileImage)  // Jika ada gambar, ambil URL
    //          : asset('storage/profile/default-profileImage.jpg');  // Jika tidak ada, gunakan gambar default
             
    //  }
     
     
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function store() {
        return $this->hasOne(Store::class, 'seller_id');
    }

    
    public function products()
    {
        return $this->hasManyThrough(Product::class, Store::class, 'seller_id', 'store_id');
    }

    public function favorites() {
        return $this->hasMany(Favorite::class);
    }

    public function cart()
    {
        return $this->hasOne(Cart::class);
    }

    public function orders()

    {

        return $this->hasMany(Order::class);

    }

    public function reviews() {
        return $this->hasMany(Review::class);
    }

}
