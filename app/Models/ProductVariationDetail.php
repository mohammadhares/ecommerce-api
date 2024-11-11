<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductVariationDetail extends Model
{
    public function variationOption()
    {
        return $this->belongsTo(VariationOption::class, 'option_id');
    }

    public function variationValue()
    {
        return $this->belongsTo(VariationValue::class, 'value_id');
    }
}
