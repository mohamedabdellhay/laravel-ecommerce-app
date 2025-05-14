<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Product Specifications') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                <div class="mb-6">
                    <div class="flex justify-between items-center">
                        <h3 class="text-lg font-medium">{{ $product->name }} - Specifications</h3>
                        <div class="flex space-x-2">
                            <a href="{{ route('admin.products.show', $product->id) }}" class="inline-flex items-center px-4 py-2 bg-blue-500 text-white rounded-md hover:bg-blue-600">
                                Back to Product
                            </a>
                            <a href="{{ route('admin.products.specifications.create', $product->id) }}" class="inline-flex items-center px-4 py-2 bg-gray-800 text-white rounded-md hover:bg-gray-700">
                                Add Specification
                            </a>
                        </div>
                    </div>
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

                @if ($product->specifications->isEmpty())
                    <div class="bg-yellow-50 border border-yellow-200 text-yellow-800 p-4 rounded mb-4">
                        No specifications have been added to this product yet.
                    </div>
                @else
                    <div class="overflow-x-auto">
                        <table class="min-w-full bg-white">
                            <thead>
                                <tr class="bg-gray-100 text-gray-700 uppercase text-sm leading-normal">
                                    <th class="py-3 px-6 text-left">ID</th>
                                    <th class="py-3 px-6 text-left">Name</th>
                                    <th class="py-3 px-6 text-left">Value</th>
                                    <th class="py-3 px-6 text-left">Display Order</th>
                                    <th class="py-3 px-6 text-center">Actions</th>
                                </tr>
                            </thead>
                            <tbody class="text-gray-600 text-sm">
                                @foreach ($product->specifications->sortBy('display_order') as $specification)
                                    <tr class="border-b border-gray-200 hover:bg-gray-50">
                                        <td class="py-4 px-6">{{ $specification->id }}</td>
                                        <td class="py-4 px-6">{{ $specification->name }}</td>
                                        <td class="py-4 px-6">{{ $specification->value }}</td>
                                        <td class="py-4 px-6">{{ $specification->display_order }}</td>
                                        <td class="py-4 px-6 text-center">
                                            <div class="flex justify-center space-x-2">
                                                <a href="{{ route('admin.products.specifications.edit', [$product->id, $specification->id]) }}" class="text-yellow-600 hover:text-yellow-900">
                                                    Edit
                                                </a>
                                                <form action="{{ route('admin.products.specifications.destroy', [$product->id, $specification->id]) }}" method="POST" class="inline">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="text-red-600 hover:text-red-900" onclick="return confirm('Are you sure you want to delete this specification?')">
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
                @endif
            </div>
        </div>
    </div>
</x-app-layout> 