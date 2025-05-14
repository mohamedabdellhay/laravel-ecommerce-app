<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Add Product Specification') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <div class="mb-6">
                        <div class="flex justify-between items-center mb-6">
                            <h3 class="text-lg font-medium">Add Specification to: {{ $product->name }}</h3>
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

                        @if (session('error'))
                            <div class="mb-4 p-4 bg-red-100 border border-red-400 text-red-700 rounded">
                                {{ session('error') }}
                            </div>
                        @endif

                        @if ($availableSpecs->isEmpty() && $suggestedSpecs->isEmpty())
                            <div class="bg-yellow-50 border border-yellow-200 text-yellow-800 p-4 rounded mb-4">
                                All available specifications have already been added to this product or there are no suitable specifications. 
                                <a href="{{ route('admin.specifications.create') }}" class="text-blue-600 hover:underline">
                                    Create a new specification
                                </a>
                            </div>
                        @else
                            <form action="{{ route('admin.specifications.store', $product->id) }}" method="POST">
                                @csrf
                                
                                <div class="mb-4">
                                    <label for="specification_id" class="block text-sm font-medium text-gray-700 mb-2">Select Specification</label>
                                    
                                    @if ($suggestedSpecs->isNotEmpty())
                                        <div class="mb-2">
                                            <p class="text-sm font-semibold text-gray-700">Suggested from Category ({{ $product->category ? $product->category->name : 'None' }})</p>
                                            <select id="suggested_specs" class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 mb-2" onchange="document.getElementById('specification_id').value = this.value; this.value = '';">
                                                <option value="">-- Select a suggested specification --</option>
                                                @foreach ($suggestedSpecs as $spec)
                                                    <option value="{{ $spec->id }}">
                                                        {{ $spec->name }} ({{ $spec->code }})
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    @endif
                                    
                                    <select name="specification_id" id="specification_id" class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" required>
                                        <option value="">-- Select a specification --</option>
                                        @foreach ($availableSpecs as $spec)
                                            <option value="{{ $spec->id }}">
                                                {{ $spec->name }} ({{ $spec->code }})
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="mb-4">
                                    <label for="value" class="block text-sm font-medium text-gray-700 mb-2">Value</label>
                                    <textarea name="value" id="value" rows="3" class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" required>{{ old('value') }}</textarea>
                                </div>

                                <div class="flex items-center justify-end mt-4">
                                    <button type="submit" class="px-4 py-2 bg-blue-500 text-white rounded-md hover:bg-blue-600">
                                        Add Specification
                                    </button>
                                </div>
                            </form>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout> 