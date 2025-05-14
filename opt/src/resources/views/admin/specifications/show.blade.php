<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('View Specification') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <div class="mb-6">
                        <div class="flex justify-between items-center mb-6">
                            <h3 class="text-lg font-medium">Specification Details</h3>
                            <div class="flex space-x-2">
                                <a href="{{ route('admin.specifications.edit', $specification->id) }}" class="px-4 py-2 bg-yellow-500 text-white rounded-md hover:bg-yellow-600">
                                    Edit
                                </a>
                                <a href="{{ route('admin.specifications.index') }}" class="px-4 py-2 bg-gray-500 text-white rounded-md hover:bg-gray-600">
                                    Back to List
                                </a>
                            </div>
                        </div>

                        @if (session('success'))
                            <div class="mb-4 p-4 bg-green-100 border border-green-400 text-green-700 rounded">
                                {{ session('success') }}
                            </div>
                        @endif

                        <div class="bg-gray-50 p-6 rounded-lg shadow-sm">
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div>
                                    <h4 class="text-sm font-medium text-gray-500">ID</h4>
                                    <p class="mt-1">{{ $specification->id }}</p>
                                </div>
                                
                                <div>
                                    <h4 class="text-sm font-medium text-gray-500">Name</h4>
                                    <p class="mt-1">{{ $specification->name }}</p>
                                </div>
                                
                                <div>
                                    <h4 class="text-sm font-medium text-gray-500">Code</h4>
                                    <p class="mt-1">{{ $specification->code }}</p>
                                </div>
                                
                                <div>
                                    <h4 class="text-sm font-medium text-gray-500">Status</h4>
                                    <p class="mt-1">
                                        @if ($specification->is_active)
                                            <span class="px-2 py-1 bg-green-100 text-green-800 rounded-full text-xs">Active</span>
                                        @else
                                            <span class="px-2 py-1 bg-red-100 text-red-800 rounded-full text-xs">Inactive</span>
                                        @endif
                                    </p>
                                </div>
                                
                                <div class="md:col-span-2">
                                    <h4 class="text-sm font-medium text-gray-500">Description</h4>
                                    <p class="mt-1">{{ $specification->description ?: 'No description' }}</p>
                                </div>
                                
                                <div>
                                    <h4 class="text-sm font-medium text-gray-500">Created At</h4>
                                    <p class="mt-1">{{ $specification->created_at->format('M d, Y H:i') }}</p>
                                </div>
                                
                                <div>
                                    <h4 class="text-sm font-medium text-gray-500">Updated At</h4>
                                    <p class="mt-1">{{ $specification->updated_at->format('M d, Y H:i') }}</p>
                                </div>
                            </div>
                        </div>

                        <!-- Categories using this specification -->
                        <div class="mt-8">
                            <h4 class="text-lg font-medium mb-4">Categories Using This Specification</h4>
                            
                            @if($specification->categories->isEmpty())
                                <div class="bg-gray-50 p-4 rounded text-gray-600">
                                    This specification is not used in any categories yet.
                                </div>
                            @else
                                <div class="overflow-x-auto">
                                    <table class="min-w-full bg-white">
                                        <thead>
                                            <tr class="bg-gray-100 text-gray-700 text-sm leading-normal">
                                                <th class="py-3 px-6 text-left">ID</th>
                                                <th class="py-3 px-6 text-left">Category Name</th>
                                                <th class="py-3 px-6 text-left">Display Order</th>
                                                <th class="py-3 px-6 text-center">Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody class="text-gray-600 text-sm">
                                            @foreach($specification->categories as $category)
                                                <tr class="border-b border-gray-200 hover:bg-gray-50">
                                                    <td class="py-3 px-6">{{ $category->id }}</td>
                                                    <td class="py-3 px-6">{{ $category->name }}</td>
                                                    <td class="py-3 px-6">{{ $category->pivot->display_order }}</td>
                                                    <td class="py-3 px-6 text-center">
                                                        <a href="{{ route('admin.categories.show', $category->id) }}" class="text-blue-600 hover:text-blue-900">
                                                            View Category
                                                        </a>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            @endif
                        </div>

                        <!-- Products using this specification -->
                        <div class="mt-8">
                            <h4 class="text-lg font-medium mb-4">Products Using This Specification</h4>
                            
                            @if($specification->products->isEmpty())
                                <div class="bg-gray-50 p-4 rounded text-gray-600">
                                    This specification is not used in any products yet.
                                </div>
                            @else
                                <div class="overflow-x-auto">
                                    <table class="min-w-full bg-white">
                                        <thead>
                                            <tr class="bg-gray-100 text-gray-700 text-sm leading-normal">
                                                <th class="py-3 px-6 text-left">ID</th>
                                                <th class="py-3 px-6 text-left">Product Name</th>
                                                <th class="py-3 px-6 text-left">Value</th>
                                                <th class="py-3 px-6 text-center">Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody class="text-gray-600 text-sm">
                                            @foreach($specification->products as $product)
                                                <tr class="border-b border-gray-200 hover:bg-gray-50">
                                                    <td class="py-3 px-6">{{ $product->id }}</td>
                                                    <td class="py-3 px-6">{{ $product->name }}</td>
                                                    <td class="py-3 px-6">{{ $product->pivot->value }}</td>
                                                    <td class="py-3 px-6 text-center">
                                                        <a href="{{ route('admin.products.show', $product->id) }}" class="text-blue-600 hover:text-blue-900">
                                                            View Product
                                                        </a>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout> 