@extends('layouts.admin')

@section('title', __('Order Details'))

@section('content')
<div class="container mx-auto">
    <h2 class="text-2xl font-bold mb-4">{{ __('Order Details') }}</h2>
    <div class="bg-white p-6 rounded-md shadow-md">
        <h3 class="text-xl font-semibold">{{ __('Order #') }}{{ $order->id }}</h3>
        <p class="mt-2"><strong>{{ __('User') }}:</strong> {{ $order->user->name }}</p>
        <p class="mt-2"><strong>{{ __('Total Amount') }}:</strong> {{ $order->total_amount }}</p>
        <p class="mt-2"><strong>{{ __('Status') }}:</strong> {{ __(ucfirst($order->status)) }}</p>
        <p class="mt-2"><strong>{{ __('Created At') }}:</strong> {{ $order->created_at->format('Y-m-d H:i:s') }}</p>
        <h4 class="mt-4 font-semibold">{{ __('Order Items') }}</h4>
        <ul class="list-disc pl-5">
            @foreach ($order->items as $item)
                <li>{{ $item->product->name }} - {{ __('Quantity') }}: {{ $item->quantity }} - {{ __('Price') }}: {{ $item->price }}</li>
            @endforeach
        </ul>
        <div class="mt-4 flex space-x-2">
            <a href="{{ route('admin.orders.edit', $order->id) }}" class="bg-yellow-500 text-white px-4 py-2 rounded hover:bg-yellow-600">{{ __('Edit') }}</a>
            <a href="{{ route('admin.orders.index') }}" class="bg-gray-500 text-white px-4 py-2 rounded hover:bg-gray-600">{{ __('Back') }}</a>
        </div>
    </div>
</div>
@endsection