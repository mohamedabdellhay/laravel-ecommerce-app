<?php

namespace App\Http\Controllers\Shop;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Category;
use App\Models\Brand;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    /**
     * Display a listing of the products.
     */
    public function index(Request $request)
    {
        $query = Product::where('status', 'active')
            ->with(['category', 'brand']);

        // Filter by category
        if ($request->has('category')) {
            $category = Category::where('slug', $request->category)->firstOrFail();
            $categoryIds = [$category->id];

            // Include all subcategories
            if ($category->children->count() > 0) {
                $categoryIds = array_merge($categoryIds, $category->children->pluck('id')->toArray());
            }

            $query->whereIn('category_id', $categoryIds);
        }

        // Filter by brand
        if ($request->has('brand')) {
            $brand = Brand::where('slug', $request->brand)->firstOrFail();
            $query->where('brand_id', $brand->id);
        }

        // Filter by price range
        if ($request->has('min_price') && $request->has('max_price')) {
            $query->whereBetween('price', [$request->min_price, $request->max_price]);
        } elseif ($request->has('min_price')) {
            $query->where('price', '>=', $request->min_price);
        } elseif ($request->has('max_price')) {
            $query->where('price', '<=', $request->max_price);
        }

        // Search by keyword
        if ($request->has('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('description', 'like', "%{$search}%")
                    ->orWhere('short_description', 'like', "%{$search}%")
                    ->orWhere('sku', 'like', "%{$search}%");
            });
        }

        // Sort products
        if ($request->has('sort')) {
            switch ($request->sort) {
                case 'price_asc':
                    $query->orderBy('price', 'asc');
                    break;
                case 'price_desc':
                    $query->orderBy('price', 'desc');
                    break;
                case 'newest':
                    $query->orderBy('created_at', 'desc');
                    break;
                case 'name_asc':
                    $query->orderBy('name', 'asc');
                    break;
                default:
                    $query->orderBy('created_at', 'desc');
            }
        } else {
            $query->orderBy('created_at', 'desc');
        }

        $products = $query->paginate(12)->withQueryString();

        // Get all categories and brands for sidebar filters
        $categories = Category::where('is_active', true)->get();
        $brands = Brand::where('is_active', true)->get();

        return view('shop.products.index', compact('products', 'categories', 'brands'));
    }

    /**
     * Display the specified product.
     */
    public function show($slug)
    {
        $product = Product::where('slug', $slug)
            ->where('status', 'active')
            ->with(['category', 'brand'])
            ->firstOrFail();

        // Get related products (same category)
        $relatedProducts = Product::where('status', 'active')
            ->where('category_id', $product->category_id)
            ->where('id', '!=', $product->id)
            ->take(4)
            ->get();

        return view('shop.products.show', compact('product', 'relatedProducts'));
    }

    /**
     * Display featured products on homepage.
     */
    public function featured()
    {
        $featuredProducts = Product::where('status', 'active')
            ->where('is_featured', true)
            ->with(['category', 'brand'])
            ->take(8)
            ->get();

        $newArrivals = Product::where('status', 'active')
            ->orderBy('created_at', 'desc')
            ->take(8)
            ->get();

        return view('shop.home', compact('featuredProducts', 'newArrivals'));
    }
}
