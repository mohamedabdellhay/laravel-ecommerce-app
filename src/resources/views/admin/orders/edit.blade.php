@extends('layouts.admin')

@section('title', __('Edit Order'))

@section('content')
<div class="container mx-auto">
    <h2 class="text-2xl font-bold mb-4">{{ __('Edit Order') }}</h2>
    <form action="{{ route('admin.orders.update', $order->id) }}" method="POST" class="space-y-6">
        @csrf
        @method('PUT')
        <div>
            <label for="user_id" class="block text-sm font-medium text-gray-700">{{ __('User') }}</label>
            <select name="user_id" id="user_id" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" required>
                <option value="">{{ __('Select User') }}</option>
                @foreach ($users as $user)
                    <option value="{{ $user->id }}" {{ old('user_id', $order->user_id) == $user->id ? 'selected' : '' }}>{{ $user->name }}</option>
                @endforeach
            </select>
        </div>
        <div>
            <label for="status" class="block text-sm font-medium text-gray-700">{{ __('Status') }}</label>
            <select name="status" id="status" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" required>
                <option value="pending" {{ old('status', $order->status) == 'pending' ? 'selected' : '' }}>{{ __('Pending') }}</option>
                <option value="processing" {{ old('status', $order->status) == 'processing' ? 'selected' : '' }}>{{ __('Processing') }}</option>
                <option value="shipped" {{ old('status', $order->status) == 'shipped' ? 'selected' : '' }}>{{ __('Shipped') }}</option>
                <option value="delivered" {{ old('status', $order->status) == 'delivered' ? 'selected' : '' }}>{{ __('Delivered') }}</option>
                <option value="cancelled" {{ old('status', $order->status) == 'cancelled' ? 'selected' : '' }}>{{ __('Cancelled') }}</option>
            </select>
        </div>

        <!-- Order Items -->
        <h4 class="text-lg font-semibold">{{ __('Order Items') }}</h4>
        <div id="items-container">
            @foreach ($order->items as $index => $item)
                <div class="bg-white p-4 rounded-md shadow-md mb-4">
                    <div class="grid grid-cols-3 gap-4">
                        <div>
                            <label for="items_{{ $index }}_product_id" class="block text-sm font-medium text-gray-700">{{ __('Product') }}</label>
                            <select name="items[{{ $index }}][product_id]" id="items_{{ $index }}_product_id" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" required>
                                <option value="">{{ __('Select Product') }}</option>
                                @foreach ($products as $product)
                                    <option value="{{ $product->id }}" {{ old('items.' . $index . '.product_id', $item->product_id) == $product->id ? 'selected' : '' }}>{{ $product->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div>
                            <label for="items_{{ $index }}_quantity" class="block text-sm font-medium text-gray-700">{{ __('Quantity') }}</label>
                            <input type="number" name="items[{{ $index }}][quantity]" id="items_{{ $index }}_quantity" value="{{ old('items.' . $index . '.quantity', $item->quantity) }}" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" min="1" required>
                        </div>
                        <div>
                            <label for="items_{{ $index }}_price" class="block text-sm font-medium text-gray-700">{{ __('Price') }}</label>
                            <input type="number" name="items[{{ $index }}][price]" id="items_{{ $index }}_price" value="{{ old('items.' . $index . '.price', $item->price) }}" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" step="0.01" required>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
        <button type="button" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600" onclick="addItemField()">{{ __('Add Item') }}</button>

        <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">{{ __('Update') }}</button>
    </form>
</div>

<script>
    function addItemField() {
        const index = document.querySelectorAll('[name*="items"]').length / 3;
        const html = `
            <div class="bg-white p-4 rounded-md shadow-md mb-4">
                <div class="grid grid-cols-3 gap-4">
                    <div>
                        <label for="items_${index}_product_id" class="block text-sm font-medium text-gray-700">{{ __('Product') }}</label>
                        <select name="items[${index}][product_id]" id="items_${index}_product_id" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" required>
                            <option value="">{{ __('Select Product') }}</option>
                            @foreach ($products as $product)
                                <option value="{{ $product->id }}">{{ $product->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label for="items_${index}_quantity" class="block text-sm font-medium text-gray-700">{{ __('Quantity') }}</label>
                        <input type="number" name="items[${index}][quantity]" id="items_${index}_quantity" value="1" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" min="1" required>
                    </div>
                    <div>
                        <label for="items_${index}_price" class="block text-sm font-medium text-gray-700">{{ __('Price') }}</label>
                        <input type="number" name="items[${index}][price]" id="items_${index}_price" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" step="0.01" required>
                    </div>
                </div>
            </div>`;
        document.querySelector('#items-container').insertAdjacentHTML('beforeend', html);
    }
</script>
@endsection