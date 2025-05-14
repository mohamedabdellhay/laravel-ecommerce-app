<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Edit Category') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <form action="{{ route('admin.categories.update', $category->id) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="mb-4">
                            <label for="name" class="block text-sm font-medium text-gray-700">Name</label>
                            <input type="text" id="name" name="name" value="{{ old('name', $category->name) }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" required>
                            @error('name')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label for="slug" class="block text-sm font-medium text-gray-700">Slug</label>
                            <input type="text" id="slug" name="slug" value="{{ old('slug', $category->slug) }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                            <p class="mt-1 text-sm text-gray-500">Leave empty to auto-generate from name</p>
                            @error('slug')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label for="description" class="block text-sm font-medium text-gray-700">Description</label>
                            <textarea id="description" name="description" rows="3" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">{{ old('description', $category->description) }}</textarea>
                            @error('description')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label for="parent_id" class="block text-sm font-medium text-gray-700">Parent Category</label>
                            <select id="parent_id" name="parent_id" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                <option value="">None (Top Level Category)</option>
                                @foreach ($parentCategories as $parentCategory)
                                    <option value="{{ $parentCategory->id }}" {{ old('parent_id', $category->parent_id) == $parentCategory->id ? 'selected' : '' }}>
                                        {{ $parentCategory->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('parent_id')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <div class="flex items-center">
                                <input type="checkbox" id="is_active" name="is_active" value="1" {{ old('is_active', $category->is_active) ? 'checked' : '' }} class="rounded border-gray-300 text-indigo-600 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                <label for="is_active" class="ml-2 block text-sm font-medium text-gray-700">Active</label>
                            </div>
                            @error('is_active')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                        
                        <div class="mb-4">
                            <label for="specifications" class="block text-sm font-medium text-gray-700">Specifications</label>
                            <select id="specifications" name="specifications[]" multiple class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                @foreach ($specifications as $specification)
                                    <option value="{{ $specification->id }}" {{ $category->specifications->contains($specification->id) ? 'selected' : '' }}>
                                        {{ $specification->name }} ({{ $specification->code }})
                                    </option>
                                @endforeach
                            </select>
                            <p class="mt-1 text-sm text-gray-500">Hold Ctrl/Cmd to select multiple specifications</p>
                            @error('specifications')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="mb-6 p-4 border border-gray-200 rounded-md">
                            <h3 class="font-medium text-lg mb-3">Add Specifications</h3>
                            <div class="space-y-3">
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                    <div>
                                        <label for="new_specification" class="block text-sm font-medium text-gray-700">Select Specification</label>
                                        <select id="new_specification" name="new_specification" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                            <option value="">-- Select a specification --</option>
                                            @foreach ($specifications as $specification)
                                                <option value="{{ $specification->id }}">
                                                    {{ $specification->name }} ({{ $specification->code }})
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="flex items-end">
                                        <button type="button" id="add_specification" class="px-4 py-2 bg-indigo-600 text-white rounded-md hover:bg-indigo-700">
                                            Add Specification
                                        </button>
                                    </div>
                                </div>
                                <div id="selected_specifications" class="mt-3">
                                    <h4 class="text-sm font-medium text-gray-700 mb-2">Selected Specifications:</h4>
                                    <ul class="list-disc pl-5 space-y-1">
                                        @foreach ($category->specifications as $spec)
                                            <li>{{ $spec->name }} ({{ $spec->code }})</li>
                                        @endforeach
                                    </ul>
                                </div>
                            </div>
                        </div>

                        <div class="mb-4">
                            <label class="block text-sm font-medium text-gray-700 mb-2">Featured Category</label>
                            <div class="flex items-center">
                                <input type="checkbox" id="is_featured" name="is_featured" value="1" {{ old('is_featured', $category->is_featured) ? 'checked' : '' }} class="rounded border-gray-300 text-indigo-600 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                <label for="is_featured" class="ml-2 block text-sm font-medium text-gray-700">Show on homepage</label>
                            </div>
                            @error('is_featured')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label for="display_order" class="block text-sm font-medium text-gray-700">Display Order</label>
                            <input type="number" id="display_order" name="display_order" value="{{ old('display_order', $category->display_order ?? 0) }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                            <p class="mt-1 text-sm text-gray-500">Lower numbers will be displayed first</p>
                            @error('display_order')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="flex items-center justify-between mt-6">
                            <a href="{{ route('admin.categories.index') }}" class="text-sm text-gray-600 hover:text-gray-900">
                                Cancel
                            </a>
                            <button type="submit" class="px-4 py-2 bg-gray-800 text-white rounded-md hover:bg-gray-700">
                                Update Category
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const addSpecBtn = document.getElementById('add_specification');
            const specSelect = document.getElementById('new_specification');
            const selectedSpecsList = document.getElementById('selected_specifications').querySelector('ul');
            const multipleSpecSelect = document.getElementById('specifications');
            
            addSpecBtn.addEventListener('click', function() {
                const selectedSpec = specSelect.options[specSelect.selectedIndex];
                if (selectedSpec.value) {
                    // Add to the visual list
                    const listItem = document.createElement('li');
                    listItem.textContent = selectedSpec.text;
                    selectedSpecsList.appendChild(listItem);
                    
                    // Select in the multiple select
                    for (let i = 0; i < multipleSpecSelect.options.length; i++) {
                        if (multipleSpecSelect.options[i].value === selectedSpec.value) {
                            multipleSpecSelect.options[i].selected = true;
                            break;
                        }
                    }
                    
                    // Reset the selection
                    specSelect.selectedIndex = 0;
                }
            });
        });
    </script>
</x-app-layout> 