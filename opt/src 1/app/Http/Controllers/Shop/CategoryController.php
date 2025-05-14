<?php

namespace App\Http\Controllers\Shop;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    /**
     * Display a listing of all categories.
     */
    public function index()
    {
        $parentCategories = Category::where('is_active', true)
            ->whereNull('parent_id')
            ->with('children')
            ->get();

        return view('shop.categories.index', compact('parentCategories'));
    }

    /**
     * Display the specified category with its products.
     */
    public function show($slug)
    {
        $category = Category::where('slug', $slug)
            ->where('is_active', true)
            ->with(['products' => function ($query) {
                $query->where('status', 'active')
                    ->orderBy('created_at', 'desc')
                    ->paginate(12);
            }])
            ->firstOrFail();

        // Get subcategories if this is a parent category
        $subcategories = [];
        if ($category->parent_id === null) {
            $subcategories = Category::where('parent_id', $category->id)
                ->where('is_active', true)
                ->get();
        }

        // Get sibling categories if this is a subcategory
        $siblingCategories = [];
        if ($category->parent_id !== null) {
            $siblingCategories = Category::where('parent_id', $category->parent_id)
                ->where('is_active', true)
                ->where('id', '!=', $category->id)
                ->get();
        }

        return view('shop.categories.show', compact('category', 'subcategories', 'siblingCategories'));
    }
}
