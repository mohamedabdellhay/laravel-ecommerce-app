@extends('layouts.admin')

@section('title', __('Product Details'))

@section('content')
<div class="container mx-auto">
    <h2 class="text-2xl font-bold mb-4">{{ __('Product Details') }}</h2>
    <div class="bg-white p-6 rounded-md shadow-md">
        <h3 class="text-xl font-semibold">{{ $product->name }}</h3>
        <p class="mt-2"><strong>{{ __('Description') }}:</strong> {{ $product->description }}</p>
        <p class="mt-2"><strong>{{ __('Price') }}:</strong> {{ $product->price }}</p>
        <p class="mt-2"><strong>{{ __('Stock') }}:</strong> {{ $product->stock }}</p>
        <p class="mt-2"><strong>{{ __('Category') }}:</strong> {{ $product->category->name }}</p>
        <p class="mt-2"><strong>{{ __('Slug') }}:</strong> {{ $product->slug }}</p>
        
        <!-- Detailed Content -->
        @if ($product->has_content)
            <h4 class="mt-4 font-semibold">{{ __('Detailed Content') }}</h4>
            <div class="mt-2 border rounded-md">
                <div class="border-b">
                    <div class="flex">
                        @foreach (['en', 'ar'] as $locale)
                            <button 
                                class="content-tab px-4 py-2 {{ $locale === app()->getLocale() ? 'bg-blue-100 border-blue-500 border-b-2' : '' }}" 
                                data-locale="{{ $locale }}"
                            >
                                {{ $locale === 'ar' ? __('Arabic') : __('English') }}
                            </button>
                        @endforeach
                    </div>
                </div>
                <div class="p-4">
                    @foreach (['en', 'ar'] as $locale)
                        <div id="content-{{ $locale }}" class="content-panel {{ $locale === app()->getLocale() ? '' : 'hidden' }}">
                            @if (!empty($content[$locale]))
                                <div class="prose max-w-none">{!! $content[$locale] !!}</div>
                            @else
                                <p class="text-gray-500">{{ __('No content available in this language.') }}</p>
                            @endif
                        </div>
                    @endforeach
                </div>
            </div>
        @endif
        
        <h4 class="mt-4 font-semibold">{{ __('Images') }}</h4>
        <ul class="list-disc pl-5">
            @foreach ($product->images as $image)
                <li>{{ $image->image_path }} {{ $image->is_primary ? '(' . __('Primary') . ')' : '' }}</li>
            @endforeach
        </ul>
        <h4 class="mt-4 font-semibold">{{ __('Variants') }}</h4>
        <ul class="list-disc pl-5">
            @foreach ($product->variants as $variant)
                <li>{{ $variant->sku }} - {{ $variant->price }} ({{ $variant->stock }})</li>
            @endforeach
        </ul>
        <div class="mt-4 flex space-x-2">
            <a href="{{ route('admin.products.edit', $product->id) }}" class="bg-yellow-500 text-white px-4 py-2 rounded hover:bg-yellow-600">{{ __('Edit') }}</a>
            <a href="{{ route('admin.products.index') }}" class="bg-gray-500 text-white px-4 py-2 rounded hover:bg-gray-600">{{ __('Back') }}</a>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Tab switching for content
        const tabs = document.querySelectorAll('.content-tab');
        tabs.forEach(tab => {
            tab.addEventListener('click', function() {
                const locale = this.getAttribute('data-locale');
                
                // Hide all panels
                document.querySelectorAll('.content-panel').forEach(panel => {
                    panel.classList.add('hidden');
                });
                
                // Show the selected panel
                document.getElementById('content-' + locale).classList.remove('hidden');
                
                // Update tab styles
                tabs.forEach(t => {
                    t.classList.remove('bg-blue-100', 'border-blue-500', 'border-b-2');
                });
                this.classList.add('bg-blue-100', 'border-blue-500', 'border-b-2');
            });
        });
    });
</script>
@endsection