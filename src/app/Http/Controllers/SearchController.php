<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class SearchController extends Controller
{
    public function search(Request $request)
    {
        $query = Product::query()->with(['translations', 'category', 'variants', 'images']);

        // Search by name or description
        if ($request->has('q')) {
            $searchTerm = $request->q;
            $query->whereHas('translations', function ($q) use ($searchTerm) {
                $q->where('locale', app()->getLocale())
                    ->where(function ($q) use ($searchTerm) {
                        $q->where('name', 'LIKE', "%$searchTerm%")
                            ->orWhere('description', 'LIKE', "%$searchTerm%");
                    });
            });
        }

        // Filter by category
        if ($request->has('category_id')) {
            $query->where('category_id', $request->category_id);
        }

        // Filter by price range
        if ($request->has('min_price') && $request->has('max_price')) {
            $query->whereBetween('price', [$request->min_price, $request->max_price]);
        }

        // Filter by filter values (e.g., color, size)
        if ($request->has('filter_values')) {
            $filterValues = is_array($request->filter_values) ? $request->filter_values : explode(',', $request->filter_values);
            $query->whereHas('variants', function ($q) use ($filterValues) {
                $q->whereHas('filterValues', function ($q) use ($filterValues) {
                    $q->whereIn('filter_values.id', $filterValues);
                });
            });
        }

        $products = $query->get();

        return response()->json($products);
    }
}
