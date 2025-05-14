@extends('layouts.admin')

@section('title', __('Create Product'))

@section('content')
<div class="container mx-auto">
    <h2 class="text-2xl font-bold mb-4">{{ __('Create Product') }}</h2>
    <form action="{{ route('admin.products.store') }}" method="POST" class="space-y-6">
        @csrf
        <div>
            <label for="price" class="block text-sm font-medium text-gray-700">{{ __('Price') }}</label>
            <input type="number" name="price" id="price" step="0.01" value="{{ old('price') }}" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" required>
        </div>
         <div>
            <label for="sku" class="block text-sm font-medium text-gray-700">{{ __('SKU') }}</label>
            <input type="text" name="sku" id="sku" value="{{ old('sku') }}" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" required>
        </div>
        <div>
            <label for="stock" class="block text-sm font-medium text-gray-700">{{ __('Stock') }}</label>
            <input type="number" name="stock" id="stock" value="{{ old('stock') }}" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" required>
        </div>
        <div>
            <label for="category_id" class="block text-sm font-medium text-gray-700">{{ __('Category') }}</label>
            <select name="category_id" id="category_id" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" required>
                <option value="">{{ __('Select Category') }}</option>
                @foreach ($categories as $category)
                    <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                @endforeach
            </select>
        </div>
        <div>
            <label for="slug" class="block text-sm font-medium text-gray-700">{{ __('Slug') }}</label>
            <input type="text" name="slug" id="slug" value="{{ old('slug') }}" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" required>
        </div>

        <!-- Translations -->
        <h4 class="text-lg font-semibold">{{ __('Translations') }}</h4>
        @foreach (['ar', 'en'] as $locale)
            <div class="bg-white p-4 rounded-md shadow-md">
                <h5 class="font-medium">{{ $locale == 'ar' ? __('Arabic') : __('English') }}</h5>
                <input type="hidden" name="translations[{{$locale}}][locale]" value="{{ $locale }}">
                <div class="mt-2">
                    <label for="translations_{{ $locale }}_name" class="block text-sm font-medium text-gray-700">{{ __('Name') }}</label>
                    <input type="text" name="translations[{{$locale}}][name]" id="translations_{{ $locale }}_name" value="{{ old('translations.' . $locale . '.name') }}" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" required>
                </div>
                <div class="mt-2">
                    <label for="translations_{{ $locale }}_description" class="block text-sm font-medium text-gray-700">{{ __('Description') }}</label>
                    <textarea name="translations[{{$locale}}][description]" id="translations_{{ $locale }}_description" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">{{ old('translations.' . $locale . '.description') }}</textarea>
                </div>
                <div class="mt-4">
                    <label for="content_{{ $locale }}" class="block text-sm font-medium text-gray-700">{{ __('Detailed Content') }}</label>
                    <textarea name="content[{{$locale}}]" id="content_{{ $locale }}" class="tinymce">{{ old('content.' . $locale) }}</textarea>
                    <p class="text-sm text-gray-500 mt-1">{{ __('This content will be stored as HTML in a text file') }}</p>
                </div>
            </div>
        @endforeach

        <!-- Images -->
        <h4 class="text-lg font-semibold">{{ __('Images') }}</h4>
        <div id="images-container">
            <div class="mb-4">
                <label for="image_path" class="block text-sm font-medium text-gray-700">{{ __('Image Path') }}</label>
                <input type="file" name="images[0][path]" id="image_path" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" accept="image/*" required>
                <p class="text-sm text-gray-500 mt-1">{{ __('Upload an image for the product') }}</p>
                {{-- <label for="image_path" class="block text-sm font-medium text-gray-700 mt-2">{{ __('Image Alt Text') }}</label>
                <input type="text" name="images[0][alt]" id="image_alt" value="{{ old('images.0.alt') }}" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" required>
                <label for="image_path" class="block text-sm font-medium text-gray-700 mt-2">{{ __('Image Title') }}</label>
                <input type="text" name="images[0][title]" id="image_title" value="{{ old('images.0.title') }}" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" required>
                <label for="image_path" class="block text-sm font-medium text-gray-700 mt-2">{{ __('Image Description') }}</label>
                <input type="text" name="images[0][description]" id="image_description" value="{{ old('images.0.description') }}" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" required>
                <label for="image_path" class="block text-sm font-medium text-gray-700 mt-2">{{ __('Image Order') }}</label>
                <input type="number" name="images[0][order]" id="image_order" value="{{ old('images.0.order') }}" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" required>
                <label for="image_path" class="block text-sm font-medium text-gray-700 mt-2">{{ __('Image Size') }}</label> --}}
                <label class="inline-flex items-center mt-2">
                    <input type="checkbox" name="images[0][is_primary]" id="is_primary" class="form-checkbox" {{ old('images.0.is_primary') ? 'checked' : '' }}>
                    <span class="ml-2 text-sm text-gray-700">{{ __('Primary Image') }}</span>
                </label>
            </div>
        </div>

        <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">{{ __('Create') }}</button>
    </form>

    <script>
        function addImage() {
            const container = document.getElementById('images-container');
            const newImage = container.cloneNode(true);
            newImage.querySelector('input').value = '';
            newImage.querySelector('input[name="images[0][is_primary]"]').checked = false;
            container.appendChild(newImage);
        }
    </script>
    

</div>
@endsection