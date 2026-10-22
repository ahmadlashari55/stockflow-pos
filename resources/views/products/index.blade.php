@extends('layouts.admin')
@section('title', 'Products')
@section('content')
<div class="card shadow-sm border-0">
    <div class="card-header bg-white d-flex justify-content-between align-items-center py-3">
        <h5 class="mb-0">All Products</h5>
        <a href="{{ route('products.create') }}" class="btn btn-primary btn-sm"><i class="bi bi-plus-lg"></i> Add Product</a>
    </div>
    <div class="card-body">
        <table class="table table-bordered table-striped align-middle">
            <thead class="table-dark">
                <tr>
                    <th>Image</th><th>Product Name</th><th>SKU</th><th>Price</th><th>Stock</th><th>Status</th><th width="150">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($products as $product)
                <tr>
                    <td>
                        @if($product->image)
                            <img src="{{ asset('storage/' . $product->image) }}" width="50" class="img-thumbnail">
                        @else
                            <span class="text-muted"><i class="bi bi-image fs-3"></i></span>
                        @endif
                    </td>
                    <td>{{ $product->name }}<br><small class="text-muted">{{ $product->category->name ?? 'No Category' }}</small></td>
                    <td>{{ $product->sku }}</td>
                    <td>Rs {{ number_format($product->selling_price, 2) }}</td>
                    <td>
                        {{ $product->stock_quantity }} {{ $product->unit->short_name ?? '' }}
                    </td>
                    <td>
                        @if($product->is_low_stock)
                            <span class="badge bg-warning text-dark">Low Stock</span>
                        @else
                            <span class="badge bg-success">In Stock</span>
                        @endif
                    </td>
                    <td>
                        <a href="{{ route('products.edit', $product->id) }}" class="btn btn-sm btn-info text-white"><i class="bi bi-pencil"></i></a>
                        <form action="{{ route('products.destroy', $product->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Are you sure?');">
                            @csrf @method('DELETE')
                            <button class="btn btn-sm btn-danger"><i class="bi bi-trash"></i></button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr><td colspan="7" class="text-center">No products found.</td></tr>
                @endforelse
            </tbody>
        </table>
        <div class="mt-3">{{ $products->links() }}</div>
    </div>
</div>
@endsection