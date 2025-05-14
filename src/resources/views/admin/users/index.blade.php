@extends('layouts.admin')

@section('title', __('Users'))

@section('content')
<div class="container mx-auto">
    <h2 class="text-2xl font-bold mb-4">{{ __('Users') }}</h2>
    <a href="{{ route('admin.users.create') }}" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600 mb-4 inline-block">{{ __('Create User') }}</a>
    
    <div class="overflow-x-auto">
        <table class="w-full bg-white shadow-md rounded">
            <thead class="bg-gray-200">
                <tr>
                    <th class="py-2 px-4 text-left">{{ __('ID') }}</th>
                    <th class="py-2 px-4 text-left">{{ __('Name') }}</th>
                    <th class="py-2 px-4 text-left">{{ __('Email') }}</th>
                    <th class="py-2 px-4 text-left">{{ __('Admin') }}</th>
                    <th class="py-2 px-4 text-left">{{ __('Created') }}</th>
                    <th class="py-2 px-4 text-left">{{ __('Actions') }}</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($users as $user)
                    <tr class="border-b">
                        <td class="py-2 px-4">{{ $user->id }}</td>
                        <td class="py-2 px-4">{{ $user->name }}</td>
                        <td class="py-2 px-4">{{ $user->email }}</td>
                        <td class="py-2 px-4">
                            @if ($user->is_admin)
                                <span class="bg-green-100 text-green-800 py-1 px-2 rounded">{{ __('Yes') }}</span>
                            @else
                                <span class="bg-gray-100 text-gray-800 py-1 px-2 rounded">{{ __('No') }}</span>
                            @endif
                        </td>
                        <td class="py-2 px-4">{{ $user->created_at->format('Y-m-d') }}</td>
                        <td class="py-2 px-4 flex space-x-2">
                            <a href="{{ route('admin.users.show', $user->id) }}" class="bg-blue-500 text-white px-3 py-1 rounded hover:bg-blue-600">{{ __('View') }}</a>
                            <a href="{{ route('admin.users.edit', $user->id) }}" class="bg-yellow-500 text-white px-3 py-1 rounded hover:bg-yellow-600">{{ __('Edit') }}</a>
                            <form action="{{ route('admin.users.destroy', $user->id) }}" method="POST" class="inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="bg-red-500 text-white px-3 py-1 rounded hover:bg-red-600" onclick="return confirm('{{ __('Are you sure?') }}')">{{ __('Delete') }}</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
                
                @if(count($users) === 0)
                    <tr>
                        <td colspan="6" class="py-4 text-center">{{ __('No users found.') }}</td>
                    </tr>
                @endif
            </tbody>
        </table>
        <div class="mt-6">
            {{ $users->links() }}
        </div>
    </div>
</div>
@endsection
