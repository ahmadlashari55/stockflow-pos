@extends('layouts.admin')
@section('title', 'Expenses')
@section('content')
<div class="row">
    <div class="col-md-12 mb-4">
        <div class="card bg-danger text-white shadow-sm border-0">
            <div class="card-body">
                <h5 class="mb-0">Total Expenses (All Time)</h5>
                <h2 class="mb-0">Rs {{ number_format($totalExpense, 2) }}</h2>
            </div>
        </div>
    </div>
    <div class="col-md-12">
        <div class="card shadow-sm border-0">
            <div class="card-header bg-white d-flex justify-content-between align-items-center py-3">
                <h5 class="mb-0">Expense History</h5>
                <a href="{{ route('expenses.create') }}" class="btn btn-primary btn-sm"><i class="bi bi-plus-lg"></i> Add Expense</a>
            </div>
            <div class="card-body">
                <table class="table table-bordered table-striped align-middle">
                    <thead class="table-dark">
                        <tr>
                            <th>Date</th><th>Title</th><th>Amount</th><th>Added By</th><th>Note</th><th width="120">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($expenses as $expense)
                        <tr>
                            <td>{{ \Carbon\Carbon::parse($expense->expense_date)->format('d M Y') }}</td>
                            <td>{{ $expense->title }}</td>
                            <td class="text-danger fw-bold">Rs {{ number_format($expense->amount, 2) }}</td>
                            <td>{{ $expense->user->name }}</td>
                            <td>{{ $expense->note ?? '-' }}</td>
                            <td>
                                <a href="{{ route('expenses.edit', $expense->id) }}" class="btn btn-sm btn-info text-white"><i class="bi bi-pencil"></i></a>
                                <form action="{{ route('expenses.destroy', $expense->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Are you sure?');">
                                    @csrf @method('DELETE')
                                    <button class="btn btn-sm btn-danger"><i class="bi bi-trash"></i></button>
                                </form>
                            </td>
                        </tr>
                        @empty
                        <tr><td colspan="6" class="text-center">No expenses found.</td></tr>
                        @endforelse
                    </tbody>
                </table>
                <div class="mt-3">{{ $expenses->links() }}</div>
            </div>
        </div>
    </div>
</div>
@endsection