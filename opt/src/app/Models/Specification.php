<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Str;

class Specification extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'code',
        'description',
        'is_active',
        'has_multiple_values',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'is_active' => 'boolean',
        'has_multiple_values' => 'boolean',
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($specification) {
            if (empty($specification->code)) {
                $specification->code = Str::slug($specification->name);
            }
        });
    }

    /**
     * The categories that belong to the specification.
     */
    public function categories(): BelongsToMany
    {
        return $this->belongsToMany(Category::class, 'category_specifications')
            ->withTimestamps();
    }

    /**
     * The products that belong to the specification.
     */
    public function products(): BelongsToMany
    {
        return $this->belongsToMany(Product::class, 'product_specifications')
            ->withPivot(['specification_value_id', 'custom_value'])
            ->withTimestamps();
    }

    /**
     * Get all the predefined values for this specification
     */
    public function values(): HasMany
    {
        return $this->hasMany(SpecificationValue::class);
    }

    /**
     * Scope a query to only include active specifications.
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }
}
