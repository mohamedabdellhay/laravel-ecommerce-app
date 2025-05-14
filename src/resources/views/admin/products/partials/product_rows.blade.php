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

@if(count($products) === 0)
    <tr>
        <td colspan="6" class="py-4 text-center">{{ __('No products found.') }}</td>
    </tr>
@endif 