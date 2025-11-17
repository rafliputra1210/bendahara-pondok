<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title') - Admin Pondok</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { background: #f8f9fa; }
        .sidebar { min-height: 100vh; background: #dc3545; color: white; }
        .sidebar a { color: white; text-decoration: none; display: block; padding: 10px 15px; }
        .sidebar a:hover { background: #bb2d3b; }
        .card-stats { color: white; border-radius: 10px; }
    </style>
</head>
<body>

<div class="d-flex">
    <!-- Sidebar -->
    <div class="sidebar p-3">
        <h4 class="text-center mb-4">💰 Bendahara</h4>
        <a href="{{ route('dashboard') }}">🏠 Dashboard</a>
        <a href="{{ route('pembayaran.index') }}">💵 Data Pembayaran</a>
        <a href="#">📊 Laporan</a>
    </div>

    <!-- Main Content -->
    <div class="flex-grow-1 p-4">
        <h3>@yield('header')</h3>
        <hr>
        @yield('content')
    </div>
</div>

</body>
</html>
