@extends('layouts.admin')
@section('title', 'Suppliers')
@section('content')
<div class="card shadow-sm border-0">
    <div class="card-header bg-white d-flex justify-content-between align-items-center py-3">
        <h5 class="mb-0">All Suppliers</h5>
        <a href="{{ route('suppliers.create') }}" class="btn btn-primary btn-sm"><i class="bi bi-plus-lg"></i> Add Supplier</a>
    </div>
    <div class="card-body">
        <table class="table table-bordered table-striped align-middle">
            <thead class="table-dark">
                <tr>
                    <th>ID</th><th>Name / Company</th><th>Phone</th><th>Balance</th><th>Status</th><th width="150">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($suppliers as $supplier)
                <tr>
                    <td>{{ $supplier->id }}</td>
                    <td>{{ $supplier->name }} <br><small class="text-muted">{{ $supplier->company_name }}</small></td>
                    <td>{{ $supplier->phone ?? '-' }}</td>
                    <td>Rs {{ number_format($supplier->opening_balance, 2) }}</td>
                    <td>
                        @if($supplier->is_active) <span class="badge bg-success">Active</span> @else <span class="badge bg-danger">Inactive</span> @endif
                    </td>
                    <td>
                        <a href="{{ route('suppliers.edit', $supplier->id) }}" class="btn btn-sm btn-info text-white"><i class="bi bi-pencil"></i></a>
                        <form action="{{ route('suppliers.destroy', $supplier->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Are you sure?');">
                            @csrf @method('DELETE')
                            <button class="btn btn-sm btn-danger"><i class="bi bi-trash"></i></button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr><td colspan="6" class="text-center">No suppliers found.</td></tr>
                @endforelse
            </tbody>
        </table>
        <div class="mt-3">{{ $suppliers->links() }}</div>
    </div>
</div>
@endsection