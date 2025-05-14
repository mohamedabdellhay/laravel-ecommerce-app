<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProductStoreRequest extends FormRequest
{
    public function authorize()
    {
        // Update this if you have authorization logic
        return true;
    }

    public function rules()
    {
        return [
            'price' => 'required|numeric|min:0',
            'sku' => 'required|string|max:255|unique:products,sku',
            'stock' => 'required|integer|min:0',
            'category_id' => 'required|exists:categories,id',
            'slug' => 'required|string|max:255|unique:products,slug',
            // Add other rules as needed
        ];
    }
}