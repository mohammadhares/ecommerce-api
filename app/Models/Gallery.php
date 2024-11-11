<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Gallery extends Model
{
    protected $fillable = ['product_id', 'image'];

    // Relationship to Product
    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
