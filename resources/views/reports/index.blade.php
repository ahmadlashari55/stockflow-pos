@extends('layouts.admin')
@section('title', 'Business Reports')
@section('content')

<!-- Filter Form -->
<div class="card shadow-sm border-0 mb-4">
    <div class="card-body">
        <form action="{{ route('reports.index') }}" method="GET" class="row align-items-end">
            <div class="col-md-4 mb-2">
                <label class="form-label">Start Date</label>
                <input type="date" name="start_date" class="form-control" value="{{ $startDate }}" required>
            </div>
            <div class="col-md-4 mb-2">
                <label class="form-label">End Date</label>
                <input type="date" name="end_date" class="form-control" value="{{ $endDate }}" required>
            </div>
            <div class="col-md-4 mb-2 d-flex gap-2">
                <button type="submit" class="btn btn-primary w-100"><i class="bi bi-search"></i> Generate</button>
                <a href="{{ route('reports.export', ['start_date' => $startDate, 'end_date' => $endDate]) }}" class="btn btn-success w-100"><i class="bi bi-file-earmark-excel"></i> Export Excel</a>
            </div>
        </form>
    </div>
</div>

<!-- Summary Cards -->
<div class="row mb-4">
    <div class="col-md-4">
        <div class="card bg-success text-white shadow-sm border-0">
            <div class="card-body">
                <h6 class="text-uppercase">Total Sales</h6>
                <h2 class="mb-0">Rs {{ number_format($totalSales, 2) }}</h2>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card bg-danger text-white shadow-sm border-0">
            <div class="card-body">
                <h6 class="text-uppercase">Total Expenses</h6>
                <h2 class="mb-0">Rs {{ number_format($totalExpenses, 2) }}</h2>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card bg-primary text-white shadow-sm border-0">
            <div class="card-body">
                <h6 class="text-uppercase">Net Profit</h6>
                <h2 class="mb-0">Rs {{ number_format($netProfit, 2) }}</h2>
            </div>
        </div>
    </div>
</div>

<!-- Detailed Tables -->
<div class="row">
    <!-- Sales Table -->
    <div class="col-md-6 mb-4">
        <div class="card shadow-sm border-0 h-100">
            <div class="card-header bg-white py-3">
                <h5 class="mb-0">Sales Details ({{ $sales->count() }})</h5>
            </div>
            <div class="card-body p-0" style="max-height: 400px; overflow-y: auto;">
                <table class="table table-sm table-hover mb-0">
                    <thead class="table-light sticky-top">
                        <tr>
                            <th>Invoice</th>
                            <th>Date</th>
                            <th class="text-end">Amount</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($sales as $sale)
                        <tr>
                            <td>{{ $sale->invoice_no }}</td>
                            <td>{{ $sale->created_at->format('d M Y') }}</td>
                            <td class="text-end">Rs {{ number_format($sale->total_amount, 2) }}</td>
                        </tr>
                        @empty
                        <tr><td colspan="3" class="text-center py-3">No sales found.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Expenses Table -->
    <div class="col-md-6 mb-4">
        <div class="card shadow-sm border-0 h-100">
            <div class="card-header bg-white py-3">
                <h5 class="mb-0">Expenses Details ({{ $expenses->count() }})</h5>
            </div>
            <div class="card-body p-0" style="max-height: 400px; overflow-y: auto;">
                <table class="table table-sm table-hover mb-0">
                    <thead class="table-light sticky-top">
                        <tr>
                            <th>Title</th>
                            <th>Date</th>
                            <th class="text-end">Amount</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($expenses as $expense)
                        <tr>
                            <td>{{ $expense->title }}</td>
                            <td>{{ \Carbon\Carbon::parse($expense->expense_date)->format('d M Y') }}</td>
                            <td class="text-end text-danger">Rs {{ number_format($expense->amount, 2) }}</td>
                        </tr>
                        @empty
                        <tr><td colspan="3" class="text-center py-3">No expenses found.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

@endsection