<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    protected $fillable = ['name', 'bio', 'email', 'phone', 'image'];

    // Relationship to Cart
    public function carts()
    {
        return $this->hasMany(Cart::class);
    }

    // Relationship to Customer Addresses
    public function addresses()
    {
        return $this->hasMany(CustomerAddress::class);
    }

    // Relationship to Orders
    public function orders()
    {
        return $this->hasMany(Order::class);
    }

    public function review()
    {
        return $this->hasMany(Review::class);
    }

    public function wishlist()
    {
        return $this->hasMany(Review::class);
    }
}
