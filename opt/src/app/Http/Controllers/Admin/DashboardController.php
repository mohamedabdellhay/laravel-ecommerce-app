<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use App\Models\Specification;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\View\View;

class DashboardController extends Controller
{
    /**
     * Display the dashboard.
     *
     * @return \Illuminate\View\View
     */
    public function index(): View
    {
        $data = [
            'totalProducts' => Product::count(),
            'totalCategories' => Category::count(),
            'totalSpecifications' => Specification::count(),
            'totalUsers' => User::count(),
            'recentProducts' => Product::with('category')
                ->latest()
                ->take(5)
                ->get(),
        ];

        return view('admin.dashboard', $data);
    }
}
