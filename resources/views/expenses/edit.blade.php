@extends('layouts.admin')
@section('title', 'Edit Expense')
@section('content')
<div class="row justify-content-center"><div class="col-md-8">
    <div class="card shadow-sm border-0">
        <div class="card-header bg-white py-3"><h5 class="mb-0">Edit Expense</h5></div>
        <div class="card-body">
            <form action="{{ route('expenses.update', $expense->id) }}" method="POST">
                @csrf @method('PUT')
                <div class="mb-3">
                    <label class="form-label">Expense Title <span class="text-danger">*</span></label>
                    <input type="text" name="title" class="form-control" value="{{ old('title', $expense->title) }}" required>
                </div>
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Amount (Rs) <span class="text-danger">*</span></label>
                        <input type="number" step="0.01" name="amount" class="form-control" value="{{ old('amount', $expense->amount) }}" required>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Date <span class="text-danger">*</span></label>
                        <input type="date" name="expense_date" class="form-control" value="{{ old('expense_date', $expense->expense_date) }}" required>
                    </div>
                </div>
                <div class="mb-3">
                    <label class="form-label">Note (Optional)</label>
                    <textarea name="note" class="form-control" rows="2">{{ old('note', $expense->note) }}</textarea>
                </div>
                <button type="submit" class="btn btn-primary">Update Expense</button>
                <a href="{{ route('expenses.index') }}" class="btn btn-secondary">Cancel</a>
            </form>
        </div>
    </div>
</div></div>
@endsection