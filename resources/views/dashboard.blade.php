@extends('layouts.admin')

@section('title', 'Dashboard')

@section('content')
    <!-- Welcome Banner -->
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

    <!-- Real Stat Cards (5 Cards) -->
    <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 row-cols-xl-5 g-3 mb-4">
        <!-- Total Products -->
        <div class="col">
            <div class="card text-white bg-primary h-100 shadow-sm border-0">
                <div class="card-body p-3">
                    <div class="d-flex justify-content-between align-items-start mb-2">
                        <h6 class="card-title text-uppercase mb-0" style="font-size: 0.8rem; letter-spacing: 0.5px;">Products</h6>
                        <i class="bi bi-box fs-4 opacity-50"></i>
                    </div>
                    <h3 class="mb-0">{{ $totalProducts }}</h3>
                </div>
                <div class="card-footer bg-transparent border-0 py-2">
                    <a href="{{ route('products.index') }}" class="text-white text-decoration-none small">View <i class="bi bi-arrow-right"></i></a>
                </div>
            </div>
        </div>

        <!-- Today's Sales -->
        <div class="col">
            <div class="card text-white bg-success h-100 shadow-sm border-0">
                <div class="card-body p-3">
                    <div class="d-flex justify-content-between align-items-start mb-2">
                        <h6 class="card-title text-uppercase mb-0" style="font-size: 0.8rem; letter-spacing: 0.5px;">Sales</h6>
                        <i class="bi bi-currency-dollar fs-4 opacity-50"></i>
                    </div>
                    <h3 class="mb-0">Rs {{ number_format($todaySales, 0) }}</h3>
                </div>
                <div class="card-footer bg-transparent border-0 py-2">
                    <a href="{{ route('sales.index') }}" class="text-white text-decoration-none small">View <i class="bi bi-arrow-right"></i></a>
                </div>
            </div>
        </div>

        <!-- Expenses -->
        <div class="col">
            <div class="card text-white bg-dark h-100 shadow-sm border-0">
                <div class="card-body p-3">
                    <div class="d-flex justify-content-between align-items-start mb-2">
                        <h6 class="card-title text-uppercase mb-0" style="font-size: 0.8rem; letter-spacing: 0.5px;">Expenses</h6>
                        <i class="bi bi-wallet2 fs-4 opacity-50"></i>
                    </div>
                    <h3 class="mb-0">Rs {{ number_format($todayExpenses, 0) }}</h3>
                </div>
                <div class="card-footer bg-transparent border-0 py-2">
                    <a href="{{ route('expenses.index') }}" class="text-white text-decoration-none small">View <i class="bi bi-arrow-right"></i></a>
                </div>
            </div>
        </div>

        <!-- Low Stock -->
        <div class="col">
            <div class="card text-dark bg-warning h-100 shadow-sm border-0">
                <div class="card-body p-3">
                    <div class="d-flex justify-content-between align-items-start mb-2">
                        <h6 class="card-title text-uppercase mb-0" style="font-size: 0.8rem; letter-spacing: 0.5px;">Low Stock</h6>
                        <i class="bi bi-exclamation-triangle fs-4 opacity-50"></i>
                    </div>
                    <h3 class="mb-0">{{ $lowStockCount }}</h3>
                </div>
                <div class="card-footer bg-transparent border-0 py-2">
                    <a href="{{ route('products.index') }}" class="text-dark text-decoration-none small">Check <i class="bi bi-arrow-right"></i></a>
                </div>
            </div>
        </div>

        <!-- Customers -->
        <div class="col">
            <div class="card text-white bg-danger h-100 shadow-sm border-0">
                <div class="card-body p-3">
                    <div class="d-flex justify-content-between align-items-start mb-2">
                        <h6 class="card-title text-uppercase mb-0" style="font-size: 0.8rem; letter-spacing: 0.5px;">Customers</h6>
                        <i class="bi bi-people fs-4 opacity-50"></i>
                    </div>
                    <h3 class="mb-0">{{ $totalCustomers }}</h3>
                </div>
                <div class="card-footer bg-transparent border-0 py-2">
                    <a href="{{ route('customers.index') }}" class="text-white text-decoration-none small">View <i class="bi bi-arrow-right"></i></a>
                </div>
            </div>
        </div>
    </div>

    <!-- Bottom Section: Recent Sales and Chart -->
    <div class="row">
        <!-- Recent Sales Table -->
        <div class="col-lg-5 mb-4">
            <div class="card shadow-sm border-0 h-100">
                <div class="card-header bg-white py-3">
                    <h5 class="mb-0">Recent Sales</h5>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th>Invoice</th>
                                    <th>Total</th>
                                    <th>Date</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($recentSales as $sale)
                                <tr>
                                    <td>
                                        <a href="{{ route('sales.show', $sale->id) }}" class="text-decoration-none fw-bold">
                                            {{ $sale->invoice_no }}
                                        </a>
                                        <br>
                                        <small class="text-muted">{{ $sale->customer->name ?? 'Walk-in' }}</small>
                                    </td>
                                    <td class="align-middle">Rs {{ number_format($sale->total_amount, 2) }}</td>
                                    <td class="align-middle text-muted small">{{ $sale->created_at->diffForHumans() }}</td>
                                </tr>
                                @empty
                                <tr><td colspan="3" class="text-center py-4">No sales yet.</td></tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <!-- Sales Chart -->
        <div class="col-lg-7 mb-4">
            <div class="card shadow-sm border-0 h-100">
                <div class="card-header bg-white py-3">
                    <h5 class="mb-0">Sales Overview (Last 7 Days)</h5>
                </div>
                <div class="card-body">
                    <canvas id="salesChart" style="height: 300px; width: 100%;"></canvas>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const ctx = document.getElementById('salesChart').getContext('2d');
        
        const dates = @json($dates);
        const totals = @json($totals);

        new Chart(ctx, {
            type: 'line',
            data: {
                labels: dates,
                datasets: [{
                    label: 'Daily Sales (Rs)',
                    data: totals,
                    borderColor: '#198754', // Bootstrap success green
                    backgroundColor: 'rgba(25, 135, 84, 0.1)',
                    borderWidth: 3,
                    fill: true,
                    tension: 0.4,
                    pointBackgroundColor: '#198754',
                    pointRadius: 4
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            callback: function(value) {
                                return 'Rs ' + value;
                            }
                        }
                    }
                },
                plugins: {
                    legend: {
                        display: false
                    }
                }
            }
        });
    });
</script>
@endpush