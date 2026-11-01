<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>StockFlow POS - @yield('title', 'Dashboard')</title>
    <link rel="icon" href="data:image/svg+xml,<svg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 100 100'><text y='.9em' font-size='90'>📦</text></svg>">
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    
    <style>
        body { min-height: 100vh; display: flex; flex-direction: column; background-color: #f4f6f9; }
        .wrapper { display: flex; flex: 1; }
        .sidebar { width: 250px; background: #343a40; color: #fff; min-height: 100vh; }
        .sidebar a { color: #c2c7d0; text-decoration: none; padding: 12px 20px; display: block; }
        .sidebar a:hover, .sidebar a.active { background: #494e53; color: #fff; border-left: 4px solid #0d6efd; }
        .sidebar .brand { font-size: 1.25rem; font-weight: bold; padding: 15px 20px; background: #23272b; border-bottom: 1px solid #4b545c; }
        .main-content { flex: 1; padding: 20px; overflow-x: hidden; }
        .topbar { background: #fff; padding: 15px 20px; border-bottom: 1px solid #dee2e6; display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px; border-radius: 5px; box-shadow: 0 1px 3px rgba(0,0,0,.1); }
    </style>
</head>
<body>

    <div class="wrapper">
        <!-- Sidebar -->
                <!-- Sidebar -->
        <div class="sidebar">
            <div class="brand">
                <i class="bi bi-box-seam"></i> StockFlow
            </div>
            
            <a href="/dashboard" class="{{ request()->is('dashboard') ? 'active' : '' }}">
                <i class="bi bi-speedometer2"></i> Dashboard
            </a>

            <!-- Sirf Admin aur Staff ko dikhega (Category view permission) -->
            @can('category.view')
            <a href="{{ route('categories.index') }}" class="{{ request()->is('categories*') ? 'active' : '' }}">
                <i class="bi bi-tags"></i> Categories
            </a>
            @endcan

            @can('unit.view')
            <a href="{{ route('units.index') }}" class="{{ request()->is('units*') ? 'active' : '' }}">
                <i class="bi bi-rulers"></i> Units
            </a>
            @endcan

            @can('supplier.view')
            <a href="{{ route('suppliers.index') }}" class="{{ request()->is('suppliers*') ? 'active' : '' }}">
                <i class="bi bi-truck"></i> Suppliers
            </a>
            @endcan

            <!-- Sirf Admin aur Staff ko dikhega (Product edit permission) -->
            @can('product.edit')
            <a href="{{ route('products.index') }}" class="{{ request()->is('products*') ? 'active' : '' }}">
                <i class="bi bi-box"></i> Products
            </a>
            @endcan

            @can('customer.view')
            <a href="{{ route('customers.index') }}" class="{{ request()->is('customers*') ? 'active' : '' }}">
                <i class="bi bi-people"></i> Customers
            </a>
            @endcan

            @can('pos.access')
            <a href="{{ route('pos.index') }}" class="{{ request()->is('pos*') ? 'active' : '' }}">
                <i class="bi bi-cart"></i> POS
            </a>
            @endcan

            @can('sale.view')
            <a href="{{ route('sales.index') }}" class="{{ request()->is('sales*') ? 'active' : '' }}">
                <i class="bi bi-receipt"></i> Sales
            </a>
            @endcan

            @can('category.view')
<a href="{{ route('expenses.index') }}" class="{{ request()->is('expenses*') ? 'active' : '' }}">
    <i class="bi bi-wallet2"></i> Expenses
</a>
@endcan
            
            <hr class="text-secondary mx-3">
            
            <form method="POST" action="{{ route('logout') }}" class="px-3 mt-3">
                @csrf
                <button type="submit" class="btn btn-danger w-100 btn-sm">
                    <i class="bi bi-box-arrow-right"></i> Logout
                </button>
            </form>
        </div>

        <!-- Main Content -->
        <div class="main-content">
            <!-- Topbar -->
            <div class="topbar">
                <h5 class="m-0">@yield('title', 'Dashboard')</h5>
                <div class="d-flex align-items-center">
                    <span class="me-3"><i class="bi bi-person-circle"></i> {{ Auth::user()->name }}</span>
                    <span class="badge bg-primary text-capitalize">{{ Auth::user()->getRoleNames()->first() ?? 'User' }}</span>
                </div>
            </div>

            <!-- Page Content -->
            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show shadow-sm">
                    <i class="bi bi-check-circle-fill me-2"></i> {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            @if(session('error'))
                <div class="alert alert-danger alert-dismissible fade show shadow-sm">
                    <i class="bi bi-exclamation-triangle-fill me-2"></i> {{ session('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            @yield('content')
        </div>
    </div>

    <!-- Bootstrap 5 JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    
    <!-- Stack for Custom Scripts (POS etc.) -->
    @stack('scripts')
</body>
</html>