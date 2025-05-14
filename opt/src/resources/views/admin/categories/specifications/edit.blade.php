<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Edit Category Specification') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <div class="mb-6">
                        <div class="flex justify-between items-center mb-6">
                            <h3 class="text-lg font-medium">
                                Edit Display Order: {{ $specification->name }} in {{ $category->name }}
                            </h3>
                            <a href="{{ route('admin.categories.specifications.index', $category->id) }}" class="px-4 py-2 bg-gray-500 text-white rounded-md hover:bg-gray-600">
                                Back to Specifications
                            </a>
                        </div>

                        @if ($errors->any())
                            <div class="mb-4 p-4 bg-red-100 border border-red-400 text-red-700 rounded">
                                <ul>
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        <form action="{{ route('admin.categories.specifications.update', [$category->id, $specification->id]) }}" method="POST">
                            @csrf
                            @method('PUT')

                            <div class="mb-4">
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-4">
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-2">Specification Name</label>
                                        <div class="bg-gray-100 p-2 rounded">{{ $specification->name }}</div>
                                    </div>
                                    
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-2">Code</label>
                                        <div class="bg-gray-100 p-2 rounded">{{ $specification->code }}</div>
                                    </div>
                                </div>

                                <div class="mt-4">
                                    <label for="display_order" class="block text-sm font-medium text-gray-700 mb-2">Display Order</label>
                                    <input type="number" name="display_order" id="display_order" value="{{ old('display_order', $specification->pivot->display_order) }}" class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" min="0" required>
                                    <p class="text-xs text-gray-500 mt-1">Lower numbers will appear first in lists.</p>
                                </div>
                            </div>

                            <div class="flex items-center justify-end mt-4">
                                <button type="submit" class="px-4 py-2 bg-yellow-500 text-white rounded-md hover:bg-yellow-600">
                                    Update Display Order
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout> 