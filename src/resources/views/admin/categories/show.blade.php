@extends('layouts.admin')

@section('title', __('Category Details'))

@section('content')
<div class="container mx-auto">
    <h2 class="text-2xl font-bold mb-4">{{ __('Category Details') }}</h2>
    <div class="bg-white p-6 rounded-md shadow-md">
        <h3 class="text-xl font-semibold">{{ $category->name }}</h3>
        <p class="mt-2"><strong>{{ __('Slug') }}:</strong> {{ $category->slug }}</p>
        <p class="mt-2"><strong>{{ __('Parent Category') }}:</strong> {{ $category->parent ? $category->parent->name : '-' }}</p>
        <h4 class="mt-4 font-semibold">{{ __('Translations') }}</h4>
        <ul class="list-disc pl-5">
            @foreach ($category->translations as $translation)
                <li>{{ $translation->locale == 'ar' ? __('Arabic') : __('English') }}: {{ $translation->name }}</li>
            @endforeach
        </ul>
        <div class="mt-4 flex space-x-2">
            <a href="{{ route('admin.categories.edit', $category->id) }}" class="bg-yellow-500 text-white px-4 py-2 rounded hover:bg-yellow-600">{{ __('Edit') }}</a>
            <a href="{{ route('admin.categories.index') }}" class="bg-gray-500 text-white px-4 py-2 rounded hover:bg-gray-600">{{ __('Back') }}</a>
        </div>
    </div>
    <div class="mt-4">
        <h4 class="text-xl font-semibold">{{ __('Products in this Category') }}</h4>
        @if ($products->isEmpty())
            <p class="text-gray-600">{{ __('No products found in this category.') }}</p>
        @else
            <div class="overflow-x-auto">
        <table class="w-full bg-white shadow-md rounded">
            <thead class="bg-gray-200">
                <tr>
                    <th class="py-2 px-4 text-right">{{ __('ID') }}</th>
                    <th class="py-2 px-4 text-right">{{ __('Name') }}</th>
                    <th class="py-2 px-4 text-right">{{ __('Category') }}</th>
                    <th class="py-2 px-4 text-right">{{ __('Price') }}</th>
                    <th class="py-2 px-4 text-right">{{ __('Stock') }}</th>
                    <th class="py-2 px-4 text-right">{{ __('Actions') }}</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($products as $product)
                    <tr class="border-b">
                        <td class="py-2 px-4">{{ $product->id }}</td>
                        <td class="py-2 px-4">{{ $product->name }}</td>
                        <td class="py-2 px-4">{{ $product->category->name }}</td>
                        <td class="py-2 px-4">{{ $product->price }}</td>
                        <td class="py-2 px-4">{{ $product->stock }}</td>
                        <td class="py-2 px-4 flex space-x-2">
                            <a href="{{ route('admin.products.show', $product->id) }}" class="bg-blue-500 text-white px-3 py-1 rounded hover:bg-blue-600">{{ __('View') }}</a>
                            <a href="{{ route('admin.products.edit', $product->id) }}" class="bg-yellow-500 text-white px-3 py-1 rounded hover:bg-yellow-600">{{ __('Edit') }}</a>
                            <form action="{{ route('admin.products.destroy', $product->id) }}" method="POST" class="inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="bg-red-500 text-white px-3 py-1 rounded hover:bg-red-600" onclick="return confirm('{{ __('Are you sure?') }}')">{{ __('Delete') }}</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        </div>
        <div class="mt-4">
            {{ $products->links() }}    
                </div>
    </div>
        @endif
    
</div>
@endsection