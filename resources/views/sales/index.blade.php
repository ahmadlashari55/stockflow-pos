@extends('layouts.admin')
@section('title', 'Sales History')
@section('content')
<div class="card shadow-sm border-0">
    <div class="card-header bg-white py-3">
        <h5 class="mb-0">All Sales</h5>
    </div>
    <div class="card-body">
        <table class="table table-bordered align-middle">
            <thead class="table-dark">
                <tr>
                    <th>Date</th><th>Invoice No</th><th>Customer</th><th>Total</th><th>Paid</th><th>Due</th><th>Cashier</th><th width="120">Action</th>
                </tr>
            </thead>
            <tbody>
                @forelse($sales as $sale)
                <tr>
                    <td>{{ $sale->created_at->format('d M Y, h:i A') }}</td>
                    <td><strong>{{ $sale->invoice_no }}</strong></td>
                    <td>{{ $sale->customer->name ?? 'Walk-in' }}</td>
                    <td>Rs {{ number_format($sale->total_amount, 2) }}</td>
                    <td>Rs {{ number_format($sale->paid_amount, 2) }}</td>
                    <td>
                        @if($sale->due_amount > 0)
                            <span class="text-danger">Rs {{ number_format($sale->due_amount, 2) }}</span>
                        @else
                            Rs 0.00
                        @endif
                    </td>
                    <td>{{ $sale->user->name }}</td>
                    <td>
                        <a href="{{ route('sales.show', $sale->id) }}" class="btn btn-sm btn-info text-white"><i class="bi bi-eye"></i></a>
                        <a href="{{ route('sales.receipt', $sale->id) }}" target="_blank" class="btn btn-sm btn-primary"><i class="bi bi-printer"></i></a>
                    </td>
                </tr>
                @empty
                <tr><td colspan="8" class="text-center">No sales found.</td></tr>
                @endforelse
            </tbody>
        </table>
        <div class="mt-3">{{ $sales->links() }}</div>
    </div>
</div>
@endsection