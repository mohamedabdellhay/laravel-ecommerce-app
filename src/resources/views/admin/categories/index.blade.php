@extends('layouts.admin')

@section('title', __('Categories'))

@section('content')
<div class="container mx-auto">
    <h2 class="text-2xl font-bold mb-4">{{ __('Categories') }}</h2>
    <a href="{{ route('admin.categories.create') }}" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600 mb-4 inline-block">{{ __('Create Category') }}</a>
    <div class="overflow-x-auto">
        <table class="w-full bg-white shadow-md rounded">
            <thead class="bg-gray-200">
                <tr>
                    <th class="py-2 px-4 text-right">{{ __('ID') }}</th>
                    <th class="py-2 px-4 text-right">{{ __('Name') }}</th>
                    <th class="py-2 px-4 text-right">{{ __('Slug') }}</th>
                    <th class="py-2 px-4 text-right">{{ __('Parent Category') }}</th>
                    <th class="py-2 px-4 text-right">{{ __('Actions') }}</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($categories as $category)
                    <tr class="border-b">
                        <td class="py-2 px-4">{{ $category->id }}</td>
                        <td class="py-2 px-4">{{ $category->name }}</td>
                        <td class="py-2 px-4">{{ $category->slug }}</td>
                        <td class="py-2 px-4">{{ $category->parent ? $category->parent->name : '-' }}</td>
                        <td class="py-2 px-4 flex space-x-2">
                            <a href="{{ route('admin.categories.show', $category->id) }}" class="bg-blue-500 text-white px-3 py-1 rounded hover:bg-blue-600">{{ __('View') }}</a>
                            <a href="{{ route('admin.categories.edit', $category->id) }}" class="bg-yellow-500 text-white px-3 py-1 rounded hover:bg-yellow-600">{{ __('Edit') }}</a>
                            <form action="{{ route('admin.categories.destroy', $category->id) }}" method="POST" class="inline">
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
</div>
@endsection