<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Product extends Model
{
    use HasFactory;

    protected $fillable = ['price', 'stock', 'sku', 'category_id', 'slug', 'has_content'];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function variants()
    {
        return $this->hasMany(ProductVariant::class);
    }

    public function images()
    {
        return $this->hasMany(ProductImage::class);
    }

    public function translations()
    {
        return $this->hasMany(ProductTranslation::class);
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

    public function getDescriptionAttribute()
    {
        return $this->translation()->description ?? '';
    }

    /**
     * Get the product content for the specified locale
     * 
     * @param string|null $locale
     * @return string|null
     */
    public function getContent($locale = null)
    {
        $locale = $locale ?? app()->getLocale();
        if (!$this->has_content) {
            return null;
        }

        $filePath = "product-content/{$this->id}_{$locale}.txt";
        if (Storage::disk('public')->exists($filePath)) {
            return Storage::disk('public')->get($filePath);
        }

        return null;
    }

    /**
     * Save the product content for the specified locale
     * 
     * @param string $content
     * @param string|null $locale
     * @return bool
     */
    public function saveContent($content, $locale = null)
    {
        $locale = $locale ?? app()->getLocale();
        $filePath = "product-content/{$this->id}_{$locale}.txt";

        // Create directory if it doesn't exist
        Storage::disk('public')->makeDirectory('product-content', 0755, true);

        // Save content to file
        $saved = Storage::disk('public')->put($filePath, $content);

        // Update the has_content flag
        if ($saved && !$this->has_content) {
            $this->has_content = true;
            $this->save();
        }

        return $saved;
    }

    public function scopeFiltered($query)
    {
    // Example: filter by category or search term
    if (request()->has('category_id')) {
        $query->where('category_id', request('category_id'));
    }
    if (request()->has('search')) {
        $query->where('name', 'like', '%' . request('search') . '%');
    }
    return $query;
    }
    public function scopeSorted($query)
    {
        // Example: sort by price or name
        if (request()->has('sort_by')) {
            $query->orderBy(request('sort_by'), request('sort_direction', 'asc'));
        }
        return $query;
    }
    public function scopePaginated($query)
    {
        return $query->paginate(request('per_page', 10));
    }
    public function scopeWithRelations($query)
    {
        return $query->with(['category', 'variants', 'images']);
    }

}
