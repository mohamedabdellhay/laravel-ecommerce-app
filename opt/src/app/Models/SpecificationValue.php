<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Support\Str;

class SpecificationValue extends Model
{
    use HasFactory;

    protected $fillable = [
        'specification_id',
        'value',
        'slug',
        'color_code',
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($specValue) {
            if (empty($specValue->slug)) {
                $specValue->slug = Str::slug($specValue->value);
            }
        });
    }

    /**
     * Get the specification that owns this value
     */
    public function specification(): BelongsTo
    {
        return $this->belongsTo(Specification::class);
    }

    /**
     * Get the products that have this specification value
     */
    public function products(): BelongsToMany
    {
        return $this->belongsToMany(Product::class, 'product_specifications')
            ->withPivot('custom_value')
            ->withTimestamps();
    }
}
