@extends('layouts.admin')

@section('title', __('Create Category'))

@section('content')
<div class="container mx-auto">
    <h2 class="text-2xl font-bold mb-4">{{ __('Create Category') }}</h2>
    <form action="{{ route('admin.categories.store') }}" method="POST" class="space-y-6">
        @csrf
        <div>
            <label for="slug" class="block text-sm font-medium text-gray-700">{{ __('Slug') }}</label>
            <input type="text" name="slug" id="slug" value="{{ old('slug') }}" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" required>
        </div>
        <div>
            <label for="parent_id" class="block text-sm font-medium text-gray-700">{{ __('Parent Category') }}</label>
            <select name="parent_id" id="parent_id" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                <option value="">{{ __('None') }}</option>
                @foreach ($categories as $category)
                    <option value="{{ $category->id }}" {{ old('parent_id') == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                @endforeach
            </select>
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
            </div>
        @endforeach

        <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">{{ __('Create') }}</button>
    </form>
</div>
@endsection