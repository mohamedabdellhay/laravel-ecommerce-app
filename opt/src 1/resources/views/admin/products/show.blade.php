@extends('layouts.admin')

@section('content')
<div class="container-fluid">
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Product Details</h1>
        <a href="{{ route('admin.products.index') }}" class="d-none d-sm-inline-block btn btn-sm btn-secondary shadow-sm">
            <i class="fas fa-arrow-left fa-sm text-white-50"></i> Back
        </a>
    </div>

    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">{{ $product->name }}</h6>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-4">
                    @if($product->image)
                    <img src="{{ asset('storage/'.$product->image) }}" alt="{{ $product->name }}" class="img-fluid mb-3">
                    @else
                    <div class="bg-light p-5 text-center mb-3">
                        No Image Available
                    </div>
                    @endif
                </div>
                <div class="col-md-8">
                    <table class="table table-bordered">
                        <tr>
                            <th width="30%">Name</th>
                            <td>{{ $product->name }}</td>
                        </tr>
                        <tr>
                            <th>SKU</th>
                            <td>{{ $product->sku }}</td>
                        </tr>
                        <tr>
                            <th>Price</th>
                            <td>${{ number_format($product->price, 2) }}</td>
                        </tr>
                        @if($product->discount_price)
                        <tr>
                            <th>Discount Price</th>
                            <td>${{ number_format($product->discount_price, 2) }}</td>
                        </tr>
                        @endif
                        <tr>
                            <th>Stock</th>
                            <td>{{ $product->stock }}</td>
                        </tr>
                        <tr>
                            <th>Category</th>
                            <td>{{ $product->category->name }}</td>
                        </tr>
                        @if($product->brand)
                        <tr>
                            <th>Brand</th>
                            <td>{{ $product->brand->name }}</td>
                        </tr>
                        @endif
                        <tr>
                            <th>Status</th>
                            <td>
                                <span class="badge badge-{{ $product->status == 'active' ? 'success' : ($product->status == 'draft' ? 'warning' : 'secondary') }}">
                                    {{ ucfirst($product->status) }}
                                </span>
                            </td>
                        </tr>
                        <tr>
                            <th>Featured</th>
                            <td>{{ $product->is_featured ? 'Yes' : 'No' }}</td>
                        </tr>
                        <tr>
                            <th>Created At</th>
                            <td>{{ $product->created_at->format('M d, Y H:i') }}</td>
                        </tr>
                        <tr>
                            <th>Updated At</th>
                            <td>{{ $product->updated_at->format('M d, Y H:i') }}</td>
                        </tr>
                    </table>

                    <h5 class="mt-4">Short Description</h5>
                    <p>{{ $product->short_description ?? 'N/A' }}</p>

                    <h5 class="mt-4">Description</h5>
                    <div>{!! $product->description ?? 'N/A' !!}</div>
                </div>
            </div>
        </div>
        <div class="card-footer">
            <a href="{{ route('admin.products.edit', $product->id) }}" class="btn btn-primary">
                <i class="fas fa-edit"></i> Edit
            </a>
        </div>
    </div>
</div>
@endsection