<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Users') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <div class="flex justify-between items-center mb-6">
                        <h3 class="text-lg font-medium">User Management</h3>
                        <a href="{{ route('admin.users.create') }}" class="px-4 py-2 bg-gray-800 text-white rounded-md hover:bg-gray-700">
                            Add New User
                        </a>
                    </div>

                    @if (session('success'))
                        <div class="mb-4 p-4 bg-green-100 border border-green-400 text-green-700 rounded">
                            {{ session('success') }}
                        </div>
                    @endif

                    @if (session('error'))
                        <div class="mb-4 p-4 bg-red-100 border border-red-400 text-red-700 rounded">
                            {{ session('error') }}
                        </div>
                    @endif

                    <div class="overflow-x-auto">
                        <table class="min-w-full bg-white" style="width: 100%;">
                            <thead>
                                <tr class="bg-gray-100 text-gray-700 uppercase text-sm leading-normal" style="text-align:left">
                                    <th class="py-3 px-6 text-left">ID</th>
                                    <th class="py-3 px-6 text-left">Name</th>
                                    <th class="py-3 px-6 text-left">Email</th>
                                    <th class="py-3 px-6 text-left">Role</th>
                                    <th class="py-3 px-6 text-left">Registered</th>
                                    <th class="py-3 px-6 text-center">Actions</th>
                                </tr>
                            </thead>
                            <tbody class="text-gray-600 text-sm">
                                @foreach ($users as $user)
                                    <tr class="border-b border-gray-200 hover:bg-gray-50">
                                        <td class="py-4 px-6">{{ $user->id }}</td>
                                        <td class="py-4 px-6">{{ $user->name }}</td>
                                        <td class="py-4 px-6">{{ $user->email }}</td>
                                        <td class="py-4 px-6">
                                            @if ($user->is_admin)
                                                <span class="px-2 py-1 bg-purple-100 text-purple-800 rounded-full text-xs">Admin</span>
                                            @else
                                                <span class="px-2 py-1 bg-gray-100 text-gray-800 rounded-full text-xs">User</span>
                                            @endif
                                        </td>
                                        <td class="py-4 px-6">{{ $user->created_at->format('M d, Y') }}</td>
                                        <td class="py-4 px-6 text-center">
                                            <div class="flex justify-between space-x-2">
                                                <a href="{{ route('admin.users.show', $user->id) }}" class="text-blue-600 hover:text-blue-900">
                                                    View
                                                </a>
                                                <a href="{{ route('admin.users.edit', $user->id) }}" class="text-yellow-600 hover:text-yellow-900">
                                                    Edit
                                                </a>
                                                <form action="{{ route('admin.users.destroy', $user->id) }}" method="POST" class="inline">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="text-red-600 hover:text-red-900" onclick="return confirm('Are you sure you want to delete this user?')">
                                                        Delete
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <div class="mt-4">
                        {{ $users->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout> 