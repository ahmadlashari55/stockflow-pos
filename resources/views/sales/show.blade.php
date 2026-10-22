@extends('layouts.admin')
@section('title', 'Sale Details')
@section('content')
<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card shadow-sm border-0">
            <div class="card-header bg-white d-flex justify-content-between align-items-center py-3">
                <h5 class="mb-0">Invoice: {{ $sale->invoice_no }}</h5>
                <a href="{{ route('sales.receipt', $sale->id) }}" target="_blank" class="btn btn-primary btn-sm"><i class="bi bi-printer"></i> Print Receipt</a>
            </div>
            <div class="card-body">
                <div class="row mb-4">
                    <div class="col-6">
                        <strong>Customer:</strong><br>
                        {{ $sale->customer->name ?? 'Walk-in Customer' }}<br>
                        {{ $sale->customer->phone ?? '' }}
                    </div>
                    <div class="col-6 text-end">
                        <strong>Date:</strong> {{ $sale->created_at->format('d M Y, h:i A') }}<br>
                        <strong>Cashier:</strong> {{ $sale->user->name }}
                    </div>
                </div>

                <table class="table table-bordered">
                    <thead class="table-light">
                        <tr>
                            <th>Product</th>
                            <th>Price</th>
                            <th>Qty</th>
                            <th class="text-end">Total</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($sale->items as $item)
                        <tr>
                            <td>{{ $item->product->name }}</td>
                            <td>Rs {{ number_format($item->unit_price, 2) }}</td>
                            <td>{{ $item->quantity }}</td>
                            <td class="text-end">Rs {{ number_format($item->subtotal, 2) }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>

                <div class="row justify-content-end">
                    <div class="col-md-5">
                        <table class="table table-sm">
                            <tr><td>Subtotal:</td><td class="text-end">Rs {{ number_format($sale->subtotal, 2) }}</td></tr>
                            <tr><td>Discount:</td><td class="text-end">- Rs {{ number_format($sale->discount, 2) }}</td></tr>
                            <tr class="fw-bold"><td>Total:</td><td class="text-end">Rs {{ number_format($sale->total_amount, 2) }}</td></tr>
                            <tr><td>Paid:</td><td class="text-end">Rs {{ number_format($sale->paid_amount, 2) }}</td></tr>
                            <tr class="text-danger"><td>Due:</td><td class="text-end">Rs {{ number_format($sale->due_amount, 2) }}</td></tr>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection