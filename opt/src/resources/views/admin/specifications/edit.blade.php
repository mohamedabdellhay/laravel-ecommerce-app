<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Edit Specification') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <form action="{{ route('admin.specifications.update', $specification->id) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="mb-6">
                            <a href="{{ route('admin.specifications.index') }}" class="text-blue-600 hover:text-blue-800">
                                &larr; Back to Specifications
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

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label for="name" class="block text-sm font-medium text-gray-700">Specification Name</label>
                                <input type="text" name="name" id="name" value="{{ old('name', $specification->name) }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                <p class="mt-1 text-sm text-gray-500">For example: Color, Size, Material, etc.</p>
                            </div>

                            <div>
                                <label for="code" class="block text-sm font-medium text-gray-700">Code (Optional)</label>
                                <input type="text" name="code" id="code" value="{{ old('code', $specification->code) }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                <p class="mt-1 text-sm text-gray-500">Used in URLs and filters. Will be auto-generated if empty.</p>
                            </div>

                            <div class="md:col-span-2">
                                <label for="description" class="block text-sm font-medium text-gray-700">Description (Optional)</label>
                                <textarea name="description" id="description" rows="3" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">{{ old('description', $specification->description) }}</textarea>
                            </div>

                            <div class="md:col-span-2">
                                <div class="flex items-center">
                                    <input type="checkbox" name="has_multiple_values" id="has_multiple_values" class="rounded border-gray-300 text-indigo-600 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" {{ old('has_multiple_values', $specification->has_multiple_values) ? 'checked' : '' }}>
                                    <label for="has_multiple_values" class="ml-2 block text-sm font-medium text-gray-700">
                                        Has Multiple Values
                                    </label>
                                </div>
                                <p class="mt-1 text-sm text-gray-500">
                                    Check this if this specification can have multiple predefined values (e.g., Color can have Red, Blue, Green).
                                    You can manage the values from the specification details page.
                                </p>
                            </div>
                        </div>

                        <div class="mt-6 flex items-center justify-between">
                            <a href="{{ route('admin.specifications.values.index', $specification->id) }}" class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded">
                                Manage Values
                            </a>
                            <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                                Update Specification
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout> 