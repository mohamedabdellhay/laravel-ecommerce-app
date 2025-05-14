<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('User Details') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <div class="mb-6">
                        <h3 class="text-lg font-medium mb-4">User Information</h3>
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <p class="text-sm font-medium text-gray-500">Name</p>
                                <p class="mt-1">{{ $user->name }}</p>
                            </div>
                            
                            <div>
                                <p class="text-sm font-medium text-gray-500">Email</p>
                                <p class="mt-1">{{ $user->email }}</p>
                            </div>
                            
                            <div>
                                <p class="text-sm font-medium text-gray-500">Role</p>
                                <p class="mt-1">
                                    @if ($user->is_admin)
                                        <span class="px-2 py-1 bg-purple-100 text-purple-800 rounded-full text-xs">Admin</span>
                                    @else
                                        <span class="px-2 py-1 bg-gray-100 text-gray-800 rounded-full text-xs">User</span>
                                    @endif
                                </p>
                            </div>
                            
                            <div>
                                <p class="text-sm font-medium text-gray-500">Registered</p>
                                <p class="mt-1">{{ $user->created_at->format('F j, Y g:i A') }}</p>
                            </div>
                            
                            @if($user->email_verified_at)
                            <div>
                                <p class="text-sm font-medium text-gray-500">Email Verified</p>
                                <p class="mt-1">{{ $user->email_verified_at->format('F j, Y g:i A') }}</p>
                            </div>
                            @endif
                        </div>
                    </div>
                    
                    <div class="flex justify-between mt-6">
                        <a href="{{ route('admin.users.index') }}" class="text-sm text-gray-600 hover:text-gray-900">
                            Back to Users
                        </a>
                        <div class="flex space-x-2">
                            <a href="{{ route('admin.users.edit', $user->id) }}" class="px-4 py-2 bg-yellow-500 text-white rounded-md hover:bg-yellow-600">
                                Edit
                            </a>
                            <form action="{{ route('admin.users.destroy', $user->id) }}" method="POST" class="inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="px-4 py-2 bg-red-500 text-white rounded-md hover:bg-red-600" onclick="return confirm('Are you sure you want to delete this user?')">
                                    Delete
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout> 