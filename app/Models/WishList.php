<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class WishList extends Model
{
    protected $table = 'wishlists';
    protected $fillable = ['customer_id', 'product_id'];

    // Relationships
    public function Product()
    {
        return $this->belongsTo(Product::class);
    }

    public function Customer()
    {
        return $this->belongsTo(Customer::class);
    }
}
