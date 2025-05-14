<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Category;
use App\Models\Brand;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    /**
     * Display the dashboard with statistics.
     */
    public function index()
    {
        $stats = [
            'totalProducts' => Product::count(),
            'activeProducts' => Product::where('status', 'active')->count(),
            'featuredProducts' => Product::where('is_featured', true)->count(),
            'totalCategories' => Category::count(),
            'totalBrands' => Brand::count(),
            'lowStockProducts' => Product::where('stock', '<=', 5)->count(),
        ];

        $recentProducts = Product::with(['category', 'brand'])
            ->latest()
            ->take(5)
            ->get();

        return view('admin.dashboard', compact('stats', 'recentProducts'));
    }
}
