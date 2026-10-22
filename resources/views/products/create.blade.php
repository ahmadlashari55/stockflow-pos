@extends('layouts.admin')
@section('title', 'Add Product')
@section('content')
<div class="row justify-content-center"><div class="col-md-10">
    <div class="card shadow-sm border-0">
        <div class="card-header bg-white py-3"><h5 class="mb-0">Add New Product</h5></div>
        <div class="card-body">
            <form action="{{ route('products.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Product Name <span class="text-danger">*</span></label>
                        <input type="text" name="name" class="form-control" value="{{ old('name') }}" required>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label">SKU / Barcode <span class="text-danger">*</span></label>
                        <input type="text" name="sku" class="form-control" value="{{ old('sku') }}" required>
                    </div>
                    
                    <div class="col-md-4 mb-3">
                        <label class="form-label">Category</label>
                        <select name="category_id" class="form-select">
                            <option value="">Select Category</option>
                            @foreach($categories as $category)
                                <option value="{{ $category->id }}">{{ $category->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-4 mb-3">
                        <label class="form-label">Unit</label>
                        <select name="unit_id" class="form-select">
                            <option value="">Select Unit</option>
                            @foreach($units as $unit)
                                <option value="{{ $unit->id }}">{{ $unit->name }} ({{ $unit->short_name }})</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-4 mb-3">
                        <label class="form-label">Supplier</label>
                        <select name="supplier_id" class="form-select">
                            <option value="">Select Supplier</option>
                            @foreach($suppliers as $supplier)
                                <option value="{{ $supplier->id }}">{{ $supplier->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-3 mb-3">
                        <label class="form-label">Cost Price <span class="text-danger">*</span></label>
                        <input type="number" step="0.01" name="cost_price" class="form-control" value="{{ old('cost_price', 0) }}" required>
                    </div>
                    <div class="col-md-3 mb-3">
                        <label class="form-label">Selling Price <span class="text-danger">*</span></label>
                        <input type="number" step="0.01" name="selling_price" class="form-control" value="{{ old('selling_price', 0) }}" required>
                    </div>
                    <div class="col-md-3 mb-3">
                        <label class="form-label">Stock Qty <span class="text-danger">*</span></label>
                        <input type="number" step="0.001" name="stock_quantity" class="form-control" value="{{ old('stock_quantity', 0) }}" required>
                    </div>
                    <div class="col-md-3 mb-3">
                        <label class="form-label">Low Stock Alert Qty</label>
                        <input type="number" step="0.001" name="low_stock_threshold" class="form-control" value="{{ old('low_stock_threshold', 5) }}">
                    </div>

                    <div class="col-md-12 mb-3">
                        <label class="form-label">Product Image (Max 2MB)</label>
                        <input type="file" name="image" class="form-control">
                    </div>
                </div>
                
                <button type="submit" class="btn btn-primary">Save Product</button>
                <a href="{{ route('products.index') }}" class="btn btn-secondary">Cancel</a>
            </form>
        </div>
    </div>
</div></div>
@endsection