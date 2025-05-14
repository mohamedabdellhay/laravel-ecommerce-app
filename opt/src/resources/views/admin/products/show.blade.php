<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Product Details') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <div class="mb-6">
                        <div class="flex justify-between items-center mb-4">
                            <h3 class="text-lg font-medium">Product Information</h3>
                            <a href="{{ route('admin.products.specifications.index', $product->id) }}" class="px-4 py-2 bg-purple-600 text-white rounded-md hover:bg-purple-700">
                                Manage Specifications
                            </a>
                        </div>
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <p class="text-sm font-medium text-gray-500">Name</p>
                                <p class="mt-1">{{ $product->name }}</p>
                            </div>
                            
                            <div>
                                <p class="text-sm font-medium text-gray-500">SKU</p>
                                <p class="mt-1">{{ $product->sku }}</p>
                            </div>

                            <div>
                                <p class="text-sm font-medium text-gray-500">Slug</p>
                                <p class="mt-1">{{ $product->slug }}</p>
                            </div>
                            
                            <div>
                                <p class="text-sm font-medium text-gray-500">Price</p>
                                <p class="mt-1">
                                    @if($product->sale_price)
                                        <span class="line-through text-gray-500">${{ number_format($product->price, 2) }}</span>
                                        <span class="text-red-600">${{ number_format($product->sale_price, 2) }}</span>
                                    @else
                                        ${{ number_format($product->price, 2) }}
                                    @endif
                                </p>
                            </div>
                            
                            <div>
                                <p class="text-sm font-medium text-gray-500">Stock</p>
                                <p class="mt-1">{{ $product->stock }} units</p>
                            </div>
                            
                            <div>
                                <p class="text-sm font-medium text-gray-500">Category</p>
                                <p class="mt-1">
                                    @if ($product->category)
                                        <a href="{{ route('admin.categories.show', $product->category->id) }}" class="text-blue-600 hover:underline">
                                            {{ $product->category->name }}
                                        </a>
                                    @else
                                        None
                                    @endif
                                </p>
                            </div>
                            
                            <div>
                                <p class="text-sm font-medium text-gray-500">Status</p>
                                <p class="mt-1">
                                    @if ($product->is_active)
                                        <span class="px-2 py-1 bg-green-100 text-green-800 rounded-full text-xs">Active</span>
                                    @else
                                        <span class="px-2 py-1 bg-red-100 text-red-800 rounded-full text-xs">Inactive</span>
                                    @endif
                                </p>
                            </div>
                            
                            <div>
                                <p class="text-sm font-medium text-gray-500">Featured</p>
                                <p class="mt-1">
                                    @if ($product->is_featured)
                                        <span class="px-2 py-1 bg-blue-100 text-blue-800 rounded-full text-xs">Featured</span>
                                    @else
                                        <span class="px-2 py-1 bg-gray-100 text-gray-800 rounded-full text-xs">Not Featured</span>
                                    @endif
                                </p>
                            </div>
                            
                            <div class="col-span-1 md:col-span-2">
                                <p class="text-sm font-medium text-gray-500">Description</p>
                                <p class="mt-1">{{ $product->description ?? 'No description available' }}</p>
                            </div>
                        </div>
                    </div>

                    <!-- Product Specifications -->
                    <div class="mt-8 mb-6">
                        <div class="flex justify-between items-center mb-4">
                            <h3 class="text-lg font-medium">Product Specifications</h3>
                            <a href="{{ route('admin.products.specifications.create', $product->id) }}" class="px-4 py-2 bg-gray-800 text-white rounded-md hover:bg-gray-700">
                                Add Specification
                            </a>
                        </div>
                        
                        @if ($product->specifications->isEmpty())
                            <div class="bg-yellow-50 border border-yellow-200 text-yellow-800 p-4 rounded mb-4">
                                No specifications have been added to this product yet.
                            </div>
                        @else
                            <div class="overflow-x-auto">
                                <table class="min-w-full bg-white">
                                    <thead>
                                        <tr class="bg-gray-100 text-gray-700 uppercase text-sm leading-normal">
                                            <th class="py-3 px-6 text-left">Specification</th>
                                            <th class="py-3 px-6 text-left">Value</th>
                                            <th class="py-3 px-6 text-center">Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody class="text-gray-600 text-sm">
                                        @foreach ($product->specifications as $specification)
                                            <tr class="border-b border-gray-200 hover:bg-gray-50">
                                                <td class="py-4 px-6">
                                                    <div class="font-medium">{{ $specification->name }}</div>
                                                    <div class="text-xs text-gray-500">{{ $specification->code }}</div>
                                                </td>
                                                <td class="py-4 px-6">{{ $specification->pivot->value }}</td>
                                                <td class="py-4 px-6 text-center">
                                                    <div class="flex justify-center space-x-2">
                                                        <a href="{{ route('admin.products.specifications.edit', [$product->id, $specification->id]) }}" class="text-yellow-600 hover:text-yellow-900">
                                                            Edit
                                                        </a>
                                                        <form action="{{ route('admin.products.specifications.destroy', [$product->id, $specification->id]) }}" method="POST" class="inline">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit" class="text-red-600 hover:text-red-900" onclick="return confirm('Are you sure you want to remove this specification?')">
                                                                Remove
                                                            </button>
                                                        </form>
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        @endif
                    </div>
                    
                    <div class="flex justify-between mt-6">
                        <a href="{{ route('admin.products.index') }}" class="text-sm text-gray-600 hover:text-gray-900">
                            Back to Products
                        </a>
                        <div class="flex space-x-2">
                            <a href="{{ route('admin.products.specifications.index', $product->id) }}" class="px-4 py-2 bg-purple-600 text-white rounded-md hover:bg-purple-700">
                                Specifications
                            </a>
                            <a href="{{ route('admin.products.edit', $product->id) }}" class="px-4 py-2 bg-yellow-500 text-white rounded-md hover:bg-yellow-600">
                                Edit
                            </a>
                            <form action="{{ route('admin.products.destroy', $product->id) }}" method="POST" class="inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="px-4 py-2 bg-red-500 text-white rounded-md hover:bg-red-600" onclick="return confirm('Are you sure you want to delete this product?')">
                                    Delete
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout> 