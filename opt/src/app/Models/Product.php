<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Product extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'slug',
        'description',
        'image',
        'additional_images',
        'price',
        'sale_price',
        'category_id',
        'stock',
        'sku',
        'is_active',
        'is_featured',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'price' => 'decimal:2',
        'sale_price' => 'decimal:2',
        'is_active' => 'boolean',
        'is_featured' => 'boolean',
        'additional_images' => 'array',
    ];

    /**
     * Get the category that owns the Product
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    /**
     * Get the specifications for this product
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function specifications(): BelongsToMany
    {
        return $this->belongsToMany(Specification::class, 'product_specifications')
            ->withPivot(['specification_value_id', 'custom_value'])
            ->withTimestamps();
    }

    /**
     * Get the specification values for this product
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function specificationValues(): BelongsToMany
    {
        return $this->belongsToMany(SpecificationValue::class, 'product_specifications')
            ->withPivot('custom_value')
            ->withTimestamps();
    }

    /**
     * Get all the specifications from the product's category
     * 
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getCategorySpecifications()
    {
        if (!$this->category) {
            return collect([]);
        }

        try {
            return $this->category->specifications()
                ->with('values')
                ->get();
        } catch (\Exception $e) {
            // Handle the case where the category_specifications table doesn't exist
            return collect([]);
        }
    }

    /**
     * Scope a query to only include active products.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * Scope a query to only include featured products.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeFeatured($query)
    {
        return $query->where('is_featured', true);
    }

    /**
     * Get the product's current price (either sale price or regular price)
     *
     * @return float
     */
    public function getCurrentPrice()
    {
        return $this->sale_price ?? $this->price;
    }

    /**
     * Get the product's image URL
     * 
     * @return string|null
     */
    public function getImageUrl()
    {
        if (!$this->image) {
            return null;
        }

        // Check if the image is a full URL
        if (filter_var($this->image, FILTER_VALIDATE_URL)) {
            return $this->image;
        }

        // Check if the image is stored in the storage directory
        if (str_starts_with($this->image, 'storage/')) {
            return asset($this->image);
        }

        // Default storage location
        return asset('storage/' . $this->image);
    }

    /**
     * Get the product's additional images URLs
     * 
     * @return array
     */
    public function getAdditionalImageUrls()
    {
        if (!$this->additional_images) {
            return [];
        }

        $images = [];
        foreach ($this->additional_images as $image) {
            if (filter_var($image, FILTER_VALIDATE_URL)) {
                $images[] = $image;
            } else if (str_starts_with($image, 'storage/')) {
                $images[] = asset($image);
            } else {
                $images[] = asset('storage/' . $image);
            }
        }

        return $images;
    }
}
