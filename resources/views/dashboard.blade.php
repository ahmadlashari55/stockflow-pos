@extends('layouts.admin')

@section('title', 'Dashboard')

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card shadow-sm border-0 mb-4">
                <div class="card-body">
                    <h4 class="card-title">Welcome back, {{ Auth::user()->name }}! 👋</h4>
                    <p class="text-muted mb-0">Yahan aap apne store ka overall performance dekh sakte hain.</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Real Stat Cards -->
    <div class="row">
        <!-- Total Products -->
        <div class="col-md-3">
            <div class="card text-white bg-primary mb-3 shadow-sm border-0">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="card-title text-uppercase mb-1">Total Products</h6>
                            <h2 class="mb-0">{{ $totalProducts }}</h2>
                        </div>
                        <i class="bi bi-box fs-1 opacity-50"></i>
                    </div>
                </div>
                <div class="card-footer bg-transparent border-0 py-2">
                    <a href="{{ route('products.index') }}" class="text-white text-decoration-none small">View Products <i class="bi bi-arrow-right"></i></a>
                </div>
            </div>
        </div>

        <!-- Today's Sales -->
        <div class="col-md-3">
            <div class="card text-white bg-success mb-3 shadow-sm border-0">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="card-title text-uppercase mb-1">Today's Sales</h6>
                            <h2 class="mb-0">Rs {{ number_format($todaySales, 2) }}</h2>
                        </div>
                        <i class="bi bi-currency-dollar fs-1 opacity-50"></i>
                    </div>
                </div>
                <div class="card-footer bg-transparent border-0 py-2">
                    <a href="{{ route('sales.index') }}" class="text-white text-decoration-none small">View Sales <i class="bi bi-arrow-right"></i></a>
                </div>
            </div>
        </div>

        <!-- Low Stock -->
        <div class="col-md-3">
            <div class="card text-dark bg-warning mb-3 shadow-sm border-0">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="card-title text-uppercase mb-1">Low Stock Items</h6>
                            <h2 class="mb-0">{{ $lowStockCount }}</h2>
                        </div>
                        <i class="bi bi-exclamation-triangle fs-1 opacity-50"></i>
                    </div>
                </div>
                <div class="card-footer bg-transparent border-0 py-2">
                    <a href="{{ route('products.index') }}" class="text-dark text-decoration-none small">Check Inventory <i class="bi bi-arrow-right"></i></a>
                </div>
            </div>
        </div>

        <!-- Customers -->
        <div class="col-md-3">
            <div class="card text-white bg-danger mb-3 shadow-sm border-0">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="card-title text-uppercase mb-1">Customers</h6>
                            <h2 class="mb-0">{{ $totalCustomers }}</h2>
                        </div>
                        <i class="bi bi-people fs-1 opacity-50"></i>
                    </div>
                </div>
                <div class="card-footer bg-transparent border-0 py-2">
                    <a href="{{ route('customers.index') }}" class="text-white text-decoration-none small">View Customers <i class="bi bi-arrow-right"></i></a>
                </div>
            </div>
        </div>
    </div>

    <!-- Recent Sales Table -->
    <div class="row mt-3">
        <div class="col-md-8">
            <div class="card shadow-sm border-0">
                <div class="card-header bg-white py-3">
                    <h5 class="mb-0">Recent Sales</h5>
                </div>
                <div class="card-body p-0">
                    <table class="table table-hover mb-0">
                        <thead class="table-light">
                            <tr>
                                <th>Invoice</th>
                                <th>Customer</th>
                                <th>Total</th>
                                <th>Date</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($recentSales as $sale)
                            <tr>
                                <td><a href="{{ route('sales.show', $sale->id) }}">{{ $sale->invoice_no }}</a></td>
                                <td>{{ $sale->customer->name ?? 'Walk-in' }}</td>
                                <td>Rs {{ number_format($sale->total_amount, 2) }}</td>
                                <td>{{ $sale->created_at->diffForHumans() }}</td>
                            </tr>
                            @empty
                            <tr><td colspan="4" class="text-center py-3">No sales yet.</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection