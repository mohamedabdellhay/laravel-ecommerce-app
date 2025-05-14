<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Category Specifications') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                <div class="mb-6">
                    <div class="flex justify-between items-center">
                        <h3 class="text-lg font-medium">{{ $category->name }} - Specifications</h3>
                        <div class="flex space-x-2">
                            <a href="{{ route('admin.categories.show', $category->id) }}" class="inline-flex items-center px-4 py-2 bg-blue-500 text-white rounded-md hover:bg-blue-600">
                                Back to Category
                            </a>
                            <a href="{{ route('admin.categories.specifications.create', $category->id) }}" class="inline-flex items-center px-4 py-2 bg-gray-800 text-white rounded-md hover:bg-gray-700">
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

                @if ($category->specifications->isEmpty())
                    <div class="bg-yellow-50 border border-yellow-200 text-yellow-800 p-4 rounded mb-4">
                        No specifications have been assigned to this category yet.
                    </div>
                @else
                    <div class="overflow-x-auto">
                        <table class="min-w-full bg-white">
                            <thead>
                                <tr class="bg-gray-100 text-gray-700 uppercase text-sm leading-normal">
                                    <th class="py-3 px-6 text-left">ID</th>
                                    <th class="py-3 px-6 text-left">Name</th>
                                    <th class="py-3 px-6 text-left">Code</th>
                                    <th class="py-3 px-6 text-left">Display Order</th>
                                    <th class="py-3 px-6 text-center">Actions</th>
                                </tr>
                            </thead>
                            <tbody class="text-gray-600 text-sm">
                                @foreach ($category->specifications as $specification)
                                    <tr class="border-b border-gray-200 hover:bg-gray-50">
                                        <td class="py-4 px-6">{{ $specification->id }}</td>
                                        <td class="py-4 px-6">{{ $specification->name }}</td>
                                        <td class="py-4 px-6">{{ $specification->code }}</td>
                                        <td class="py-4 px-6">{{ $specification->pivot->display_order }}</td>
                                        <td class="py-4 px-6 text-center">
                                            <div class="flex justify-center space-x-2">
                                                <a href="{{ route('admin.specifications.show', $specification->id) }}" class="text-blue-600 hover:text-blue-900">
                                                    View
                                                </a>
                                                <a href="{{ route('admin.categories.specifications.edit', [$category->id, $specification->id]) }}" class="text-yellow-600 hover:text-yellow-900">
                                                    Edit Order
                                                </a>
                                                <form action="{{ route('admin.categories.specifications.destroy', [$category->id, $specification->id]) }}" method="POST" class="inline">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="text-red-600 hover:text-red-900" onclick="return confirm('Are you sure you want to remove this specification from the category?')">
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
                
                <div class="mt-8">
                    <h4 class="font-medium text-gray-700 mb-2">These specifications will be available to all products in this category</h4>
                    <p class="text-sm text-gray-500">
                        When you create or edit a product in this category, you will be able to set values for these specifications.
                    </p>
                </div>
            </div>
        </div>
    </div>
</x-app-layout> 