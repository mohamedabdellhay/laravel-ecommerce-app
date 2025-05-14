<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FilterValueTranslation extends Model
{
    use HasFactory;

    protected $fillable = ['filter_value_id', 'locale', 'value'];

    public function filterValue()
    {
        return $this->belongsTo(FilterValue::class);
    }
}
