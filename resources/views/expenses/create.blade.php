@extends('layouts.admin')
@section('title', 'Add Expense')
@section('content')
<div class="row justify-content-center"><div class="col-md-8">
    <div class="card shadow-sm border-0">
        <div class="card-header bg-white py-3"><h5 class="mb-0">Record New Expense</h5></div>
        <div class="card-body">
            <form action="{{ route('expenses.store') }}" method="POST">
                @csrf
                <div class="mb-3">
                    <label class="form-label">Expense Title <span class="text-danger">*</span></label>
                    <input type="text" name="title" class="form-control" value="{{ old('title') }}" placeholder="e.g. Electricity Bill, Shop Rent" required>
                </div>
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Amount (Rs) <span class="text-danger">*</span></label>
                        <input type="number" step="0.01" name="amount" class="form-control" value="{{ old('amount') }}" required>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Date <span class="text-danger">*</span></label>
                        <input type="date" name="expense_date" class="form-control" value="{{ old('expense_date', date('Y-m-d')) }}" required>
                    </div>
                </div>
                <div class="mb-3">
                    <label class="form-label">Note (Optional)</label>
                    <textarea name="note" class="form-control" rows="2">{{ old('note') }}</textarea>
                </div>
                <button type="submit" class="btn btn-primary">Save Expense</button>
                <a href="{{ route('expenses.index') }}" class="btn btn-secondary">Cancel</a>
            </form>
        </div>
    </div>
</div></div>
@endsection