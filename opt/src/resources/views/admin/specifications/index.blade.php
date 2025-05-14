<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Specifications') }}
        </h2>
    </x-slot>
{{-- 
{
      "id": 1,
      "name": "dfgffggfg",
      "code": "gfgfgf",
      "description": "dfgdg",
      "is_active": false,
      "created_at": "2025-05-09T14:36:43.000000Z",
      "updated_at": "2025-05-09T14:36:43.000000Z"
    }
     --}}
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <div class="flex justify-between items-center mb-6">
                        <h3 class="text-lg font-medium">Specification Management</h3>
                        <a href="{{ route('admin.specifications.create') }}" class="px-4 py-2 bg-gray-800 text-white rounded-md hover:bg-gray-700">
                            Add New Specification
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
                        <table class="min-w-full bg-white w-full">
                            <thead>
                                <tr class="bg-gray-100 text-gray-700 uppercase text-sm leading-normal" style="width: 100%;text-align:left">
                                    <th class="py-3 px-6 text-left">ID</th>
                                    <th class="py-3 px-6 text-left">Name</th>
                                    <th class="py-3 px-6 text-left">Code</th>
                                    <th class="py-3 px-6 text-left">Status</th>
                                    <th class="py-3 px-6 text-left">Usage</th>
                                    <th class="py-3 px-6 text-center">Actions</th>
                                </tr>
                            </thead>
                            <tbody class="text-gray-600 text-sm">
                                @foreach ($specifications as $specification)
                                    <tr class="border-b border-gray-200 hover:bg-gray-50" style="width: 100%;">
                                        <td class="py-4 px-6">{{ $specification->id }}</td>
                                        <td class="py-4 px-6">{{ $specification->name }}</td>
                                        <td class="py-4 px-6">{{ $specification->code }}</td>
                                        <td class="py-4 px-6">
                                            @if ($specification->is_active)
                                                <span class="px-2 py-1 bg-green-100 text-green-800 rounded-full text-xs">Active</span>
                                            @else
                                                <span class="px-2 py-1 bg-red-100 text-red-800 rounded-full text-xs">Inactive</span>
                                            @endif
                                        </td>
                                        <td class="py-4 px-6">
                                            {{-- <span class="text-xs">{{ $specification->categories->count() }} categories</span><br> --}}
                                            {{-- <span class="text-xs">{{ $specification->products->count() }} products</span> --}}
                                        </td>
                                        <td class="py-4 px-6 text-center">
                                            <div class="flex justify-between space-x-2">
                                                <a href="{{ route('admin.specifications.show', $specification->id) }}" class="text-blue-600 hover:text-blue-900">
                                                    View
                                                </a>
                                                <a href="{{ route('admin.specifications.edit', $specification->id) }}" class="text-yellow-600 hover:text-yellow-900">
                                                    Edit
                                                </a>
                                                <form action="{{ route('admin.specifications.destroy', $specification->id) }}" method="POST" class="inline">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="text-red-600 hover:text-red-900" onclick="return confirm('Are you sure you want to delete this specification?')">
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
                        {{ $specifications->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout> 