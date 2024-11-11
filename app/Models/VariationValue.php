<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class VariationValue extends Model
{
    protected $fillable = ['option_id', 'value'];

    /**
     * Get the option that owns this value.
     */
    public function option()
    {
        return $this->belongsTo(VariationOption::class, 'option_id');
    }
}
