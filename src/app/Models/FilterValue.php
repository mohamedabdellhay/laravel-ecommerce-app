<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FilterValue extends Model
{
    use HasFactory;

    protected $fillable = ['filter_id'];

    public function filter()
    {
        return $this->belongsTo(Filter::class);
    }

    public function translations()
    {
        return $this->hasMany(FilterValueTranslation::class);
    }

    public function variants()
    {
        return $this->belongsToMany(ProductVariant::class, 'variant_filter_values');
    }

    public function translation($locale = null)
    {
        $locale = $locale ?? app()->getLocale();
        return $this->translations()->where('locale', $locale)->first();
    }

    public function getValueAttribute()
    {
        return $this->translation()->value ?? '';
    }
}
