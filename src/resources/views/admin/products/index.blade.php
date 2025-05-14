@extends('layouts.admin')

@section('title', __('Products'))

@section('content')
<div class="container mx-auto">
    <h2 class="text-2xl font-bold mb-4">{{ __('Products') }}</h2>
    <a href="{{ route('admin.products.create') }}" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600 mb-4 inline-block">{{ __('Create Product') }}</a>
    
    <div class="bg-white p-4 rounded shadow-md mb-6">
        <form id="filter-form" class="grid grid-cols-1 md:grid-cols-3 gap-4">
            <div>
                <label for="search" class="block text-sm font-medium text-gray-700 mb-1">{{ __('Search') }}</label>
                <input type="text" id="search" name="search" class="w-full rounded border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500" placeholder="{{ __('Product name or SKU') }}">
            </div>
            
            <div>
                <label for="category_id" class="block text-sm font-medium text-gray-700 mb-1">{{ __('Category') }}</label>
                <select id="category_id" name="category_id" class="w-full rounded border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                    <option value="">{{ __('All Categories') }}</option>
                    @foreach($categories as $category)
                        <option value="{{ $category->id }}">{{ $category->name }}</option>
                    @endforeach
                </select>
            </div>
            
            <div>
                <label for="sort_by" class="block text-sm font-medium text-gray-700 mb-1">{{ __('Sort By') }}</label>
                <div class="flex space-x-2">
                    <select id="sort_by" name="sort_by" class="flex-1 rounded border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                        <option value="created_at">{{ __('Date') }}</option>
                        <option value="name">{{ __('Name') }}</option>
                        <option value="price">{{ __('Price') }}</option>
                        <option value="stock">{{ __('Stock') }}</option>
                    </select>
                    <select id="sort_direction" name="sort_direction" class="rounded border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                        <option value="desc">{{ __('Desc') }}</option>
                        <option value="asc">{{ __('Asc') }}</option>
                    </select>
                </div>
            </div>
            
            <div class="md:col-span-2">
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label for="min_price" class="block text-sm font-medium text-gray-700 mb-1">{{ __('Min Price') }}</label>
                        <input type="number" id="min_price" name="min_price" class="w-full rounded border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500" min="0" step="0.01">
                    </div>
                    <div>
                        <label for="max_price" class="block text-sm font-medium text-gray-700 mb-1">{{ __('Max Price') }}</label>
                        <input type="number" id="max_price" name="max_price" class="w-full rounded border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500" min="0" step="0.01">
                    </div>
                </div>
            </div>
            
            <div class="md:col-span-3 flex justify-end">
                <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">{{ __('Filter') }}</button>
                <button type="button" id="reset-filters" class="ml-2 bg-gray-300 text-gray-700 px-4 py-2 rounded hover:bg-gray-400">{{ __('Reset') }}</button>
            </div>
        </form>
    </div>
    
    <div class="overflow-x-auto">
        <table class="w-full bg-white shadow-md rounded">
            <thead class="bg-gray-200">
                <tr>
                    <th class="py-2 px-4 text-right">{{ __('ID') }}</th>
                    <th class="py-2 px-4 text-right">{{ __('Name') }}</th>
                    <th class="py-2 px-4 text-right">{{ __('Category') }}</th>
                    <th class="py-2 px-4 text-right">{{ __('Price') }}</th>
                    <th class="py-2 px-4 text-right">{{ __('Stock') }}</th>
                    <th class="py-2 px-4 text-right">{{ __('Actions') }}</th>
                </tr>
            </thead>
            <tbody id="products-table-body">
                @include('admin.products.partials.product_rows')
            </tbody>
        </table>
        <div id="pagination-container" class="mt-6 flex justify-center">
            {{ $products->links() }}
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    $(document).ready(function() {
        // Function to fetch products with the given parameters
        function fetchProducts(page, url, formData = {}) {
            $('#products-table-body').html('<tr><td colspan="6" class="text-center py-4">Loading...</td></tr>');
            $('#pagination-container').addClass('opacity-50').find('a').addClass('pointer-events-none');
            
            // Create the URL with all parameters
            let fetchUrl = '{{ route("admin.products.index") }}?page=' + page;
            
            // Add form data to URL if provided
            if (Object.keys(formData).length > 0) {
                for (const [key, value] of Object.entries(formData)) {
                    if (value) fetchUrl += '&' + key + '=' + encodeURIComponent(value);
                }
            }

            $.ajax({
                url: fetchUrl,
                type: 'GET',
                dataType: 'json',
                success: function(response) {
                    $('#products-table-body').html(response.products || '<tr><td colspan="6" class="text-center py-4">No products found.</td></tr>');
                    $('#pagination-container').html(response.pagination || '').removeClass('opacity-50').find('a').removeClass('pointer-events-none');
                    window.history.pushState({ page: page, formData: formData }, '', fetchUrl);
                },
                error: function(xhr, status, error) {
                    console.error('AJAX Error:', status, error);
                    $('#products-table-body').html('<tr><td colspan="6" class="text-center py-4 text-red-500">Error loading products. Please try again.</td></tr>');
                    $('#pagination-container').removeClass('opacity-50').find('a').removeClass('pointer-events-none');
                }
            });
        }

        // Handle pagination links clicks
        $(document).on('click', '#pagination-container .pagination a', function(e) {
            e.preventDefault();
            var url = $(this).attr('href');
            var page = new URL(url).searchParams.get('page') || 1;
            
            // Get current form data
            let formData = {};
            $('#filter-form').serializeArray().forEach(function(item) {
                formData[item.name] = item.value;
            });
            
            fetchProducts(page, url, formData);
        });
        
        // Handle filter form submission
        $('#filter-form').on('submit', function(e) {
            e.preventDefault();
            
            // Get form data
            let formData = {};
            $(this).serializeArray().forEach(function(item) {
                formData[item.name] = item.value;
            });
            
            // Fetch first page with filters
            fetchProducts(1, '{{ route("admin.products.index") }}', formData);
        });
        
        // Handle reset button click
        $('#reset-filters').on('click', function() {
            // Reset form fields
            $('#filter-form')[0].reset();
            
            // Fetch first page without filters
            fetchProducts(1, '{{ route("admin.products.index") }}');
        });

        // Handle browser back/forward buttons
        $(window).on('popstate', function(event) {
            if (event.originalEvent.state) {
                const state = event.originalEvent.state;
                const page = state.page || 1;
                const formData = state.formData || {};
                
                // Set form values from state
                if (formData) {
                    for (const [key, value] of Object.entries(formData)) {
                        $('#' + key).val(value);
                    }
                }
                
                fetchProducts(page, window.location.href, formData);
            }
        });
    });
</script>
@endpush
