<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Products') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <div class="flex justify-between items-center mb-6">
                        <h3 class="text-lg font-medium">Product Management</h3>
                        <a href="{{ route('admin.products.create') }}" class="px-4 py-2 bg-gray-800 text-white rounded-md hover:bg-gray-700">
                            Add New Product
                        </a>
                    </div>

                    @if (session('success'))
                        <div class="mb-4 p-4 bg-green-100 border border-green-400 text-green-700 rounded">
                            {{ session('success') }}
                        </div>
                    @endif

                    @if (session('error'))
                        <div class="mb-4 p-4 bg-red-100 border border-red-400 text-red-700 rounded">
                            {{ session('error') }}
                        </div>
                    @endif

                    <div class="overflow-x-auto">
                        <table class="min-w-full bg-white w-full" style="text-align: left">
                            <thead>
                                <tr class="bg-gray-100 text-gray-700 uppercase text-sm leading-normal" style="width:100%">
                                    <th class="py-3 px-6 text-left">ID</th>
                                    <th class="py-3 px-6 text-left">Name</th>
                                    <th class="py-3 px-6 text-left">SKU</th>
                                    <th class="py-3 px-6 text-left">Price</th>
                                    <th class="py-3 px-6 text-left">Category</th>
                                    <th class="py-3 px-6 text-left">Status</th>
                                    <th class="py-3 px-6 text-center">Actions</th>
                                </tr>
                            </thead>
                            <tbody class="text-gray-600 text-sm">
                                @foreach ($products as $product)
                                    <tr class="border-b border-gray-200 hover:bg-gray-50">
                                        <td class="py-4 px-6">{{ $product->id }}</td>
                                        <td class="py-4 px-6">{{ $product->name }}</td>
                                        <td class="py-4 px-6">{{ $product->sku }}</td>
                                        <td class="py-4 px-6">
                                            @if($product->sale_price)
                                                <span class="line-through text-gray-500">${{ number_format($product->price, 2) }}</span>
                                                <span class="text-red-600">${{ number_format($product->sale_price, 2) }}</span>
                                            @else
                                                ${{ number_format($product->price, 2) }}
                                            @endif
                                        </td>
                                        <td class="py-4 px-6">
                                            {{ $product->category ? $product->category->name : 'None' }}
                                        </td>
                                        <td class="py-4 px-6">
                                            @if ($product->is_active)
                                                <span class="px-2 py-1 bg-green-100 text-green-800 rounded-full text-xs">Active</span>
                                            @else
                                                <span class="px-2 py-1 bg-red-100 text-red-800 rounded-full text-xs">Inactive</span>
                                            @endif
                                        </td>
                                        <td class="py-4 px-6 text-center">
                                            <div class="flex justify-between space-x-2">
                                                <a href="{{ route('admin.products.show', $product->id) }}" class="text-blue-600 hover:text-blue-900">
                                                    View
                                                </a>
                                                <a href="{{ route('admin.products.edit', $product->id) }}" class="text-yellow-600 hover:text-yellow-900">
                                                    Edit
                                                </a>
                                                <a href="{{ route('admin.products.specifications.index', $product->id) }}" class="text-purple-600 hover:text-purple-900">
                                                    Specs
                                                </a>
                                                <form action="{{ route('admin.products.destroy', $product->id) }}" method="POST" class="inline">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="text-red-600 hover:text-red-900" onclick="return confirm('Are you sure you want to delete this product?')">
                                                        Delete
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <div class="mt-4">
                        {{ $products->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout> 