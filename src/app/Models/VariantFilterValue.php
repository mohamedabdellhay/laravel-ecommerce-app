<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VariantFilterValue extends Model
{
    use HasFactory;

    protected $fillable = ['variant_id', 'filter_value_id'];

    public function variant()
    {
        return $this->belongsTo(ProductVariant::class);
    }

    public function filterValue()
    {
        return $this->belongsTo(FilterValue::class);
    }
}
