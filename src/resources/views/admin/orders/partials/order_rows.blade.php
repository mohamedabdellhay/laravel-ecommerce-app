@foreach ($orders as $order)
    <tr class="border-b">
        <td class="py-2 px-4">{{ $order->id }}</td>
        <td class="py-2 px-4">{{ $order->user->name }}</td>
        <td class="py-2 px-4">{{ $order->total }}</td>
        <td class="py-2 px-4">{{ __(ucfirst($order->status)) }}</td>
        <td class="py-2 px-4">{{ $order->created_at->format('Y-m-d') }}</td>
        <td class="py-2 px-4 flex space-x-2">
            <a href="{{ route('admin.orders.show', $order->id) }}" class="view-order bg-blue-500 text-white px-3 py-1 rounded hover:bg-blue-600" data-id="{{ $order->id }}">{{ __('View') }}</a>
            <a href="{{ route('admin.orders.edit', $order->id) }}" class="edit-order bg-yellow-500 text-white px-3 py-1 rounded hover:bg-yellow-600" data-id="{{ $order->id }}">{{ __('Edit') }}</a>
            <button type="button" class="delete-order bg-red-500 text-white px-3 py-1 rounded hover:bg-red-600" data-id="{{ $order->id }}">{{ __('Delete') }}</button>
        </td>
    </tr>
@endforeach