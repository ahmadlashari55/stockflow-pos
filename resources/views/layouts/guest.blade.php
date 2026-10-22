<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>StockFlow POS - @yield('title')</title>
    <link rel="icon" href="data:image/svg+xml,<svg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 100 100'><text y='.9em' font-size='90'>📦</text></svg>">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { background-color: #f4f6f9; height: 100vh; display: flex; align-items: center; justify-content: center; }
        .auth-card { width: 100%; max-width: 400px; border-radius: 10px; box-shadow: 0 4px 15px rgba(0,0,0,0.1); border: none; }
        .auth-header { background: #343a40; color: white; text-align: center; padding: 20px; border-radius: 10px 10px 0 0; }
    </style>
</head>
<body>

    <div class="card auth-card">
        <div class="auth-header">
            <h4 class="mb-0"><i class="bi bi-box-seam"></i> StockFlow POS</h4>
        </div>
        <div class="card-body p-4">
            @yield('content')
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>