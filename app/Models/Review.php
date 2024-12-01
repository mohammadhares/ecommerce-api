<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    protected $fillable = ['customer_id', 'product_id', 'rating', 'comment'];

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
