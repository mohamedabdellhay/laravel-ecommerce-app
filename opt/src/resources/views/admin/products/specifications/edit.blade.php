<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Edit Product Specification') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <div class="mb-6">
                        <div class="flex justify-between items-center mb-6">
                            <h3 class="text-lg font-medium">
                                Edit Specification for: {{ $product->name }}
                            </h3>
                            <a href="{{ route('admin.products.specifications.index', $product->id) }}" class="px-4 py-2 bg-gray-500 text-white rounded-md hover:bg-gray-600">
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

                        <form action="{{ route('admin.products.specifications.update', [$product->id, $specification->id]) }}" method="POST">
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
                                    <label for="value" class="block text-sm font-medium text-gray-700 mb-2">Value</label>
                                    <textarea name="value" id="value" rows="3" class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" required>{{ old('value', $specification->pivot->value) }}</textarea>
                                </div>
                            </div>

                            <div class="flex items-center justify-end mt-4">
                                <button type="submit" class="px-4 py-2 bg-yellow-500 text-white rounded-md hover:bg-yellow-600">
                                    Update Specification
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout> 