@extends('layouts.admin')

@section('title', 'Units')

@section('content')
<div class="card shadow-sm border-0">
    <div class="card-header bg-white d-flex justify-content-between align-items-center py-3">
        <h5 class="mb-0">All Units</h5>
        <a href="{{ route('units.create') }}" class="btn btn-primary btn-sm">
            <i class="bi bi-plus-lg"></i> Add Unit
        </a>
    </div>
    <div class="card-body">
        <table class="table table-bordered table-striped align-middle">
            <thead class="table-dark">
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Short Name</th>
                    <th>Allow Decimal</th>
                    <th width="150">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($units as $unit)
                <tr>
                    <td>{{ $unit->id }}</td>
                    <td>{{ $unit->name }}</td>
                    <td><span class="badge bg-secondary">{{ $unit->short_name }}</span></td>
                    <td>
                        @if($unit->allow_decimal)
                            <span class="badge bg-success">Yes</span>
                        @else
                            <span class="badge bg-danger">No</span>
                        @endif
                    </td>
                    <td>
                        <a href="{{ route('units.edit', $unit->id) }}" class="btn btn-sm btn-info text-white">
                            <i class="bi bi-pencil"></i> Edit
                        </a>
                        <form action="{{ route('units.destroy', $unit->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Are you sure?');">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-sm btn-danger"><i class="bi bi-trash"></i> Delete</button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="text-center">No units found.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
        <div class="mt-3">{{ $units->links() }}</div>
    </div>
</div>
@endsection