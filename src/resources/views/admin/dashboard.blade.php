@extends('layouts.admin')

@section('title', 'Dashboard')

@section('content')
    <div class="bg-white shadow-md rounded-lg p-6 mb-6">
        <h1 class="text-2xl font-bold mb-6">{{ __('Dashboard') }}</h1>
        
        <!-- Statistics Cards -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-8">
            <!-- Total Products -->
            <div class="bg-gradient-to-r from-blue-500 to-blue-600 rounded-lg shadow-md overflow-hidden">
                <div class="p-6 text-white">
                    <div class="flex items-center">
                        <div class="p-3 rounded-full bg-white bg-opacity-30">
                            <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 8h14M5 8a2 2 0 110-4h14a2 2 0 110 4M5 8v10a2 2 0 002 2h10a2 2 0 002-2V8m-9 4h4"></path>
                            </svg>
                        </div>
                        <div class="ml-4">
                            <h3 class="text-lg font-semibold">{{ __('Total Products') }}</h3>
                            <p class="text-3xl font-bold">{{ $stats['totalProducts'] }}</p>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Total Categories -->
            <div class="bg-gradient-to-r from-green-500 to-green-600 rounded-lg shadow-md overflow-hidden">
                <div class="p-6 text-white">
                    <div class="flex items-center">
                        <div class="p-3 rounded-full bg-white bg-opacity-30">
                            <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"></path>
                            </svg>
                        </div>
                        <div class="ml-4">
                            <h3 class="text-lg font-semibold">{{ __('Total Categories') }}</h3>
                            <p class="text-3xl font-bold">{{ $stats['totalCategories'] }}</p>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Total Orders -->
            <div class="bg-gradient-to-r from-purple-500 to-purple-600 rounded-lg shadow-md overflow-hidden">
                <div class="p-6 text-white">
                    <div class="flex items-center">
                        <div class="p-3 rounded-full bg-white bg-opacity-30">
                            <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"></path>
                            </svg>
                        </div>
                        <div class="ml-4">
                            <h3 class="text-lg font-semibold">{{ __('Total Orders') }}</h3>
                            <p class="text-3xl font-bold">{{ $stats['totalOrders'] }}</p>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Total Users -->
            <div class="bg-gradient-to-r from-yellow-500 to-yellow-600 rounded-lg shadow-md overflow-hidden">
                <div class="p-6 text-white">
                    <div class="flex items-center">
                        <div class="p-3 rounded-full bg-white bg-opacity-30">
                            <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path>
                            </svg>
                        </div>
                        <div class="ml-4">
                            <h3 class="text-lg font-semibold">{{ __('Customers') }}</h3>
                            <p class="text-3xl font-bold">{{ $stats['totalUsers'] }}</p>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Pending Orders -->
            <div class="bg-gradient-to-r from-red-500 to-red-600 rounded-lg shadow-md overflow-hidden">
                <div class="p-6 text-white">
                    <div class="flex items-center">
                        <div class="p-3 rounded-full bg-white bg-opacity-30">
                            <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                        <div class="ml-4">
                            <h3 class="text-lg font-semibold">{{ __('Pending Orders') }}</h3>
                            <p class="text-3xl font-bold">{{ $stats['pendingOrders'] }}</p>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Low Stock Products -->
            <div class="bg-gradient-to-r from-orange-500 to-orange-600 rounded-lg shadow-md overflow-hidden">
                <div class="p-6 text-white">
                    <div class="flex items-center">
                        <div class="p-3 rounded-full bg-white bg-opacity-30">
                            <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
                            </svg>
                        </div>
                        <div class="ml-4">
                            <h3 class="text-lg font-semibold">{{ __('Low Stock') }}</h3>
                            <p class="text-3xl font-bold">{{ $stats['lowStockProducts'] }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <!-- Recent Orders -->
            <div class="bg-white rounded-lg shadow-md overflow-hidden mb-6">
                <div class="bg-gray-50 px-6 py-3 border-b">
                    <h3 class="text-lg font-semibold">{{ __('Recent Orders') }}</h3>
                </div>
                <div class="p-6">
                    @if($recentOrders->count() > 0)
                        <div class="overflow-x-auto">
                            <table class="w-full text-sm text-left">
                                <thead class="text-xs uppercase bg-gray-50">
                                    <tr>
                                        <th class="px-6 py-3">{{ __('Order ID') }}</th>
                                        <th class="px-6 py-3">{{ __('Customer') }}</th>
                                        <th class="px-6 py-3">{{ __('Status') }}</th>
                                        <th class="px-6 py-3">{{ __('Total') }}</th>
                                        <th class="px-6 py-3">{{ __('Date') }}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($recentOrders as $order)
                                        <tr class="border-b hover:bg-gray-50">
                                            <td class="px-6 py-4">#{{ $order->id }}</td>
                                            <td class="px-6 py-4">{{ $order->user->name }}</td>
                                            <td class="px-6 py-4">
                                                <span class="px-2 py-1 text-xs rounded-full 
                                                    @if($order->status == 'completed') bg-green-100 text-green-800
                                                    @elseif($order->status == 'processing') bg-blue-100 text-blue-800
                                                    @elseif($order->status == 'cancelled') bg-red-100 text-red-800
                                                    @else bg-yellow-100 text-yellow-800 @endif">
                                                    {{ ucfirst($order->status) }}
                                                </span>
                                            </td>
                                            <td class="px-6 py-4">${{ number_format($order->total, 2) }}</td>
                                            <td class="px-6 py-4">{{ $order->created_at->format('M d, Y') }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        <div class="mt-4">
                            <a href="{{ route('admin.orders.index') }}" class="text-blue-600 hover:underline">{{ __('View All Orders') }} →</a>
                        </div>
                    @else
                        <p class="text-gray-500">{{ __('No recent orders found.') }}</p>
                    @endif
                </div>
            </div>
            
            <!-- Recent Products -->
            <div class="bg-white rounded-lg shadow-md overflow-hidden mb-6">
                <div class="bg-gray-50 px-6 py-3 border-b">
                    <h3 class="text-lg font-semibold">{{ __('Recently Added Products') }}</h3>
                </div>
                <div class="p-6">
                    @if($recentProducts->count() > 0)
                        <div class="space-y-4">
                            @foreach($recentProducts as $product)
                                <div class="flex items-center border-b pb-4">
                                    <div class="w-16 h-16 bg-gray-200 rounded-md flex items-center justify-center mr-4">
                                        @if($product->images->count() > 0)
                                            <img src="{{ $product->images->first()->path }}" alt="{{ $product->translations->where('locale', app()->getLocale())->first()->name ?? '' }}" class="w-full h-full object-cover rounded-md">
                                        @else
                                            <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                            </svg>
                                        @endif
                                    </div>
                                    <div class="flex-1">
                                        <h4 class="font-semibold">{{ $product->translations->where('locale', app()->getLocale())->first()->name ?? 'Untitled Product' }}</h4>
                                        <p class="text-sm text-gray-500">
                                            {{ $product->category->translations->where('locale', app()->getLocale())->first()->name ?? 'Uncategorized' }}
                                        </p>
                                    </div>
                                    <div class="text-right">
                                        <p class="font-semibold">${{ number_format($product->price, 2) }}</p>
                                        <p class="text-sm text-gray-500">{{ $product->created_at->format('M d, Y') }}</p>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                        <div class="mt-4">
                            <a href="{{ route('admin.products.index') }}" class="text-blue-600 hover:underline">{{ __('View All Products') }} →</a>
                        </div>
                    @else
                        <p class="text-gray-500">{{ __('No recent products found.') }}</p>
                    @endif
                </div>
            </div>
        </div>
        
        <!-- Quick Actions -->
        <div class="bg-white rounded-lg shadow-md overflow-hidden">
            <div class="bg-gray-50 px-6 py-3 border-b">
                <h3 class="text-lg font-semibold">{{ __('Quick Actions') }}</h3>
            </div>
            <div class="p-6">
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
                    <a href="{{ route('admin.products.create') }}" class="flex items-center p-4 bg-blue-50 rounded-lg hover:bg-blue-100 transition">
                        <span class="p-2 rounded-full bg-blue-500 text-white mr-3">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                            </svg>
                        </span>
                        <span>{{ __('Add New Product') }}</span>
                    </a>
                    
                    <a href="{{ route('admin.categories.create') }}" class="flex items-center p-4 bg-green-50 rounded-lg hover:bg-green-100 transition">
                        <span class="p-2 rounded-full bg-green-500 text-white mr-3">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                            </svg>
                        </span>
                        <span>{{ __('Add New Category') }}</span>
                    </a>
                    
                    <a href="{{ route('admin.orders.index') }}?status=pending" class="flex items-center p-4 bg-yellow-50 rounded-lg hover:bg-yellow-100 transition">
                        <span class="p-2 rounded-full bg-yellow-500 text-white mr-3">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                            </svg>
                        </span>
                        <span>{{ __('Pending Orders') }}</span>
                    </a>
                    
                    <a href="{{ route('admin.products.index') }}?stock=low" class="flex items-center p-4 bg-red-50 rounded-lg hover:bg-red-100 transition">
                        <span class="p-2 rounded-full bg-red-500 text-white mr-3">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
                            </svg>
                        </span>
                        <span>{{ __('Low Stock Products') }}</span>
                    </a>
                </div>
            </div>
        </div>
    </div>
@endsection 