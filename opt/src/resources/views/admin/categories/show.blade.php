<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Category Details') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <div class="mb-6">
                        <div class="flex justify-between items-center mb-4">
                            <h3 class="text-lg font-medium">Category Information</h3>
                            <a href="{{ route('admin.categories.specifications.index', $category->id) }}" class="px-4 py-2 bg-purple-600 text-white rounded-md hover:bg-purple-700">
                                Manage Specifications
                            </a>
                        </div>
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <p class="text-sm font-medium text-gray-500">Name</p>
                                <p class="mt-1">{{ $category->name }}</p>
                            </div>
                            
                            <div>
                                <p class="text-sm font-medium text-gray-500">Slug</p>
                                <p class="mt-1">{{ $category->slug }}</p>
                            </div>
                            
                            <div>
                                <p class="text-sm font-medium text-gray-500">Status</p>
                                <p class="mt-1">
                                    @if ($category->is_active)
                                        <span class="px-2 py-1 bg-green-100 text-green-800 rounded-full text-xs">Active</span>
                                    @else
                                        <span class="px-2 py-1 bg-red-100 text-red-800 rounded-full text-xs">Inactive</span>
                                    @endif
                                </p>
                            </div>
                            
                            <div>
                                <p class="text-sm font-medium text-gray-500">Parent Category</p>
                                <p class="mt-1">
                                    @if ($category->parent)
                                        <a href="{{ route('admin.categories.show', $category->parent->id) }}" class="text-blue-600 hover:underline">
                                            {{ $category->parent->name }}
                                        </a>
                                    @else
                                        None
                                    @endif
                                </p>
                            </div>
                            
                            <div class="col-span-1 md:col-span-2">
                                <p class="text-sm font-medium text-gray-500">Description</p>
                                <p class="mt-1">{{ $category->description ?? 'No description available' }}</p>
                            </div>
                            
                            <div>
                                <p class="text-sm font-medium text-gray-500">Specifications</p>
                                <p class="mt-1">
                                    {{ $category->specifications->count() }} specifications configured
                                    <a href="{{ route('admin.categories.specifications.index', $category->id) }}" class="text-blue-600 hover:underline ml-1">
                                        View
                                    </a>
                                </p>
                            </div>
                        </div>
                    </div>

                    @if ($category->children->count() > 0)
                    <div class="mt-8 mb-6">
                        <h3 class="text-lg font-medium mb-4">Subcategories</h3>
                        
                        <div class="overflow-x-auto">
                            <table class="min-w-full bg-white">
                                <thead>
                                    <tr class="bg-gray-100 text-gray-700 uppercase text-sm leading-normal">
                                        <th class="py-3 px-6 text-left">ID</th>
                                        <th class="py-3 px-6 text-left">Name</th>
                                        <th class="py-3 px-6 text-left">Slug</th>
                                        <th class="py-3 px-6 text-left">Status</th>
                                        <th class="py-3 px-6 text-center">Actions</th>
                                    </tr>
                                </thead>
                                <tbody class="text-gray-600 text-sm">
                                    @foreach ($category->children as $child)
                                        <tr class="border-b border-gray-200 hover:bg-gray-50">
                                            <td class="py-4 px-6">{{ $child->id }}</td>
                                            <td class="py-4 px-6">{{ $child->name }}</td>
                                            <td class="py-4 px-6">{{ $child->slug }}</td>
                                            <td class="py-4 px-6">
                                                @if ($child->is_active)
                                                    <span class="px-2 py-1 bg-green-100 text-green-800 rounded-full text-xs">Active</span>
                                                @else
                                                    <span class="px-2 py-1 bg-red-100 text-red-800 rounded-full text-xs">Inactive</span>
                                                @endif
                                            </td>
                                            <td class="py-4 px-6 text-center">
                                                <div class="flex justify-center space-x-2">
                                                    <a href="{{ route('admin.categories.show', $child->id) }}" class="text-blue-600 hover:text-blue-900">
                                                        View
                                                    </a>
                                                    <a href="{{ route('admin.categories.edit', $child->id) }}" class="text-yellow-600 hover:text-yellow-900">
                                                        Edit
                                                    </a>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                    @endif
                    
                    <div class="flex justify-between mt-6">
                        <a href="{{ route('admin.categories.index') }}" class="text-sm text-gray-600 hover:text-gray-900">
                            Back to Categories
                        </a>
                        <div class="flex space-x-2">
                            <a href="{{ route('admin.categories.specifications.index', $category->id) }}" class="px-4 py-2 bg-purple-600 text-white rounded-md hover:bg-purple-700">
                                Specifications
                            </a>
                            <a href="{{ route('admin.categories.edit', $category->id) }}" class="px-4 py-2 bg-yellow-500 text-white rounded-md hover:bg-yellow-600">
                                Edit
                            </a>
                            <form action="{{ route('admin.categories.destroy', $category->id) }}" method="POST" class="inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="px-4 py-2 bg-red-500 text-white rounded-md hover:bg-red-600" onclick="return confirm('Are you sure you want to delete this category?')">
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