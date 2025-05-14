<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Filter extends Model
{
    use HasFactory;

    protected $fillable = [];

    public function values()
    {
        return $this->hasMany(FilterValue::class);
    }

    public function translations()
    {
        return $this->hasMany(FilterTranslation::class);
    }

    public function translation($locale = null)
    {
        $locale = $locale ?? app()->getLocale();
        return $this->translations()->where('locale', $locale)->first();
    }

    public function getNameAttribute()
    {
        return $this->translation()->name ?? '';
    }
}
