@extends('layouts.admin')

@section('title', 'Edit Unit')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card shadow-sm border-0">
            <div class="card-header bg-white py-3">
                <h5 class="mb-0">Edit Unit: {{ $unit->name }}</h5>
            </div>
            <div class="card-body">
                <form action="{{ route('units.update', $unit->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="mb-3">
                        <label class="form-label">Unit Name <span class="text-danger">*</span></label>
                        <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name', $unit->name) }}" required>
                        @error('name') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Short Name <span class="text-danger">*</span></label>
                        <input type="text" name="short_name" class="form-control @error('short_name') is-invalid @enderror" value="{{ old('short_name', $unit->short_name) }}" required>
                        @error('short_name') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                    <div class="mb-3 form-check">
                        <input type="checkbox" name="allow_decimal" class="form-check-input" id="allowDecimal" {{ $unit->allow_decimal ? 'checked' : '' }}>
                        <label class="form-check-label" for="allowDecimal">Allow Decimal (e.g. 1.5 kg)</label>
                    </div>
                    <button type="submit" class="btn btn-primary">Update Unit</button>
                    <a href="{{ route('units.index') }}" class="btn btn-secondary">Cancel</a>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection