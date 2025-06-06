<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductVariant extends Model
{
    use HasFactory;

    protected $fillable = ['product_id', 'sku', 'price', 'stock'];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function filterValues()
    {
        return $this->belongsToMany(FilterValue::class, 'variant_filter_values');
    }

    public function orderItems()
    {
        return $this->hasMany(OrderItem::class);
    }
}
