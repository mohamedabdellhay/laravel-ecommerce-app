@extends('layouts.admin')

@section('title', __('User Details'))

@section('content')
<div class="container mx-auto">
    <h2 class="text-2xl font-bold mb-4">{{ __('User Details') }}</h2>
    <div class="bg-white p-6 rounded-md shadow-md max-w-lg">
        <div class="mb-4">
            <h3 class="text-xl font-semibold">{{ $user->name }}</h3>
            <p class="text-gray-600">{{ $user->email }}</p>
        </div>
        
        <div class="grid grid-cols-2 gap-4">
            <div>
                <p class="text-sm text-gray-600">{{ __('ID') }}</p>
                <p>{{ $user->id }}</p>
            </div>
            
            <div>
                <p class="text-sm text-gray-600">{{ __('Admin') }}</p>
                <p>
                    @if ($user->is_admin)
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                            {{ __('Yes') }}
                        </span>
                    @else
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800">
                            {{ __('No') }}
                        </span>
                    @endif
                </p>
            </div>
            
            <div>
                <p class="text-sm text-gray-600">{{ __('Registered On') }}</p>
                <p>{{ $user->created_at->format('Y-m-d H:i') }}</p>
            </div>
            
            <div>
                <p class="text-sm text-gray-600">{{ __('Last Updated') }}</p>
                <p>{{ $user->updated_at->format('Y-m-d H:i') }}</p>
            </div>
        </div>
        
        <div class="mt-6 flex space-x-4">
            <a href="{{ route('admin.users.edit', $user->id) }}" class="bg-yellow-500 text-white px-4 py-2 rounded hover:bg-yellow-600">
                {{ __('Edit') }}
            </a>
            <a href="{{ route('admin.users.index') }}" class="bg-gray-500 text-white px-4 py-2 rounded hover:bg-gray-600">
                {{ __('Back to List') }}
            </a>
            <form action="{{ route('admin.users.destroy', $user->id) }}" method="POST" class="inline">
                @csrf
                @method('DELETE')
                <button type="submit" class="bg-red-500 text-white px-4 py-2 rounded hover:bg-red-600" onclick="return confirm('{{ __('Are you sure you want to delete this user?') }}')">
                    {{ __('Delete') }}
                </button>
            </form>
        </div>
    </div>
</div>
@endsection