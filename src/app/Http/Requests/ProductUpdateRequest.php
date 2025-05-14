<?php




namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProductUpdateRequest extends FormRequest
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
            'stock' => 'required|integer|min:0',
            'category_id' => 'required|exists:categories,id',
            'slug' => 'required|string|max:255',
            // Add other rules as needed
        ];
    }
}