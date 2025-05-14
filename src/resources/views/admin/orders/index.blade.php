@extends('layouts.admin')

@section('title', __('Orders'))

@section('content')
<div class="container mx-auto">
    <h2 class="text-2xl font-bold mb-4">{{ __('Orders') }}</h2>
    <a href="{{ route('admin.orders.create') }}" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600 mb-4 inline-block">{{ __('Create Order') }}</a>
    
    <div class="bg-white p-4 rounded shadow-md mb-6">
        <form id="filter-form" class="grid grid-cols-1 md:grid-cols-4 gap-4">
            <div>
                <label for="status" class="block text-sm font-medium text-gray-700 mb-1">{{ __('Status') }}</label>
                <select id="status" name="status" class="w-full rounded border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                    <option value="">{{ __('All Statuses') }}</option>
                    <option value="pending">{{ __('Pending') }}</option>
                    <option value="processing">{{ __('Processing') }}</option>
                    <option value="shipped">{{ __('Shipped') }}</option>
                    <option value="delivered">{{ __('Delivered') }}</option>
                    <option value="cancelled">{{ __('Cancelled') }}</option>
                </select>
            </div>
            <div>
                <label for="user_id" class="block text-sm font-medium text-gray-700 mb-1">{{ __('User') }}</label>
                <select id="user_id" name="user_id" class="w-full rounded border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                    <option value="">{{ __('All Users') }}</option>
                    @foreach($users as $user)
                        <option value="{{ $user->id }}">{{ $user->name }}</option>
                    @endforeach
                </select>
            </div>
            <div>
                <label for="sort" class="block text-sm font-medium text-gray-700 mb-1">{{ __('Sort By') }}</label>
                <select id="sort" name="sort" class="w-full rounded border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                    <option value="newest">{{ __('Newest First') }}</option>
                    <option value="oldest">{{ __('Oldest First') }}</option>
                </select>
            </div>
            <div class="flex items-end">
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
                    <th class="py-2 px-4 text-right">{{ __('User') }}</th>
                    <th class="py-2 px-4 text-right">{{ __('Total Amount') }}</th>
                    <th class="py-2 px-4 text-right">{{ __('Status') }}</th>
                    <th class="py-2 px-4 text-right">{{ __('Created At') }}</th>
                    <th class="py-2 px-4 text-right">{{ __('Actions') }}</th>
                </tr>
            </thead>
            <tbody id="orders-table-body">
                @include('admin.orders.partials.order_rows')
            </tbody>
        </table>
        <div id="pagination-container" class="mt-6 flex justify-center">
            {{ $orders->links() }}
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    $(document).ready(function() {
        // Set up AJAX to always send the CSRF token
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        // Function to fetch orders with the given parameters
        function fetchOrders(page, url, formData = {}) {
            $('#orders-table-body').html('<tr><td colspan="6" class="text-center py-4">Loading...</td></tr>');
            $('#pagination-container').addClass('opacity-50').find('a').addClass('pointer-events-none');
            
            // Create the URL with all parameters
            let fetchUrl = '{{ route("admin.orders.index") }}?page=' + page;
            
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
                    $('#orders-table-body').html(response.orders || '<tr><td colspan="6" class="text-center py-4">No orders found.</td></tr>');
                    $('#pagination-container').html(response.pagination || '').removeClass('opacity-50').find('a').removeClass('pointer-events-none');
                    window.history.pushState({ page: page, formData: formData }, '', fetchUrl);
                },
                error: function(xhr, status, error) {
                    console.error('AJAX Error:', status, error);
                    $('#orders-table-body').html('<tr><td colspan="6" class="text-center py-4 text-red-500">Error loading orders. Please try again.</td></tr>');
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
            
            fetchOrders(page, url, formData);
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
            fetchOrders(1, '{{ route("admin.orders.index") }}', formData);
        });
        
        // Handle reset button click
        $('#reset-filters').on('click', function() {
            // Reset form fields
            $('#filter-form')[0].reset();
            
            // Fetch first page without filters
            fetchOrders(1, '{{ route("admin.orders.index") }}');
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
                
                fetchOrders(page, window.location.href, formData);
            }
        });

        $(document).on('click', '.delete-order', function() {
            const id = $(this).data('id');
            console.log(id, "clicked");
            if (confirm('Are you sure you want to delete this order?')) {
                $.ajax({
                    url: '{{ route("admin.orders.destroy", ["order" => ":id"]) }}'.replace(':id', id),
                    type: 'DELETE',
                    success: function(response) {
                        if (response.success) {
                            alert(response.message);
                            location.reload();
                        } else {
                            alert(response.message);
                        }
                    },
                    error: function(xhr, status, error) {
                        console.error('AJAX Error:', status, error);
                        if (xhr.responseJSON && xhr.responseJSON.message) {
                            alert(xhr.responseJSON.message);
                        } else {
                            alert('Error deleting order: ' + status + '. Please try again.');
                        }
                    }
                });
            }
        });
    });
</script>
@endpush
