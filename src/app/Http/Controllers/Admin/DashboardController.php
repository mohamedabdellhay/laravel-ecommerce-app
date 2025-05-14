<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Category;
use App\Models\Order;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\View\View;

class DashboardController extends Controller
{
    /**
     * Display the dashboard with statistics.
     *
     * @return \Illuminate\View\View
     */
    public function index(): View
    {
        // Get statistics
        $stats = [
            'totalProducts' => Product::count(),
            'totalCategories' => Category::count(),
            'totalOrders' => Order::count(),
            'totalUsers' => User::where('is_admin', false)->count(),
            'pendingOrders' => Order::where('status', 'pending')->count(),
            'lowStockProducts' => Product::whereHas('variants', function ($query) {
                $query->where('stock', '<=', 5);
            })->count(),
        ];

        // Get recent orders
        $recentOrders = Order::with('user')
            ->latest()
            ->take(5)
            ->get();

        // Get recent products
        $recentProducts = Product::with(['category', 'translations'])
            ->latest()
            ->take(5)
            ->get();

        return view('admin.dashboard', compact('stats', 'recentOrders', 'recentProducts'));
    }
}
