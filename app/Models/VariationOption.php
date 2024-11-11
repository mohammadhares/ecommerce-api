<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class VariationOption extends Model
{

    protected $fillable = ['name'];

    /**
     * Get the values associated with this option.
     */
    public function values()
    {
        return $this->hasMany(VariationValue::class, 'option_id');
    }
}
