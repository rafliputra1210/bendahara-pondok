<!doctype html>
<html lang="id">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>@yield('title', 'SIM Bendahara')</title>
  
  <link rel="stylesheet" href="{{ asset('css/riwayat.css') }}">

  <!-- Bootstrap 5 -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <!-- Font Awesome -->
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet"/>

  <style>
    /* ====== Layout dasar ====== */
    body{ background:#e4e7ed; }
    .sidebar{
      height:100vh; width:240px; position:fixed; top:0; left:0;
      background:#082a14; color:#fff; overflow-y:auto;
    }
    .sidebar .brand{ padding:18px 20px; background:#079724; margin:0; font-weight:700; }
    .sidebar a{
      color:#fff; text-decoration:none; display:block; padding:12px 20px;
      transition: background-color .2s ease, padding-left .2s ease, transform .2s ease, color .2s;
    }
    .sidebar a:hover{ background:#495057; padding-left:28px; }
    .sidebar a.active{ background:#212529; font-weight:600; }
    .sidebar a:active{ transform:scale(.98); }

    .main{ margin-left:240px; padding:24px; }
    @media (max-width: 768px){
      .main{ margin-left:0; }
      .sidebar{ position:static; width:100%; height:auto; }
    }

    /* ====== Cards & tabel ====== */
    .stat-card{
      border:0; border-radius:16px;
      transition: transform .25s ease, box-shadow .25s ease, filter .25s ease;
      box-shadow: 0 6px 14px rgba(21, 18, 211, 0.619); cursor:pointer;
    }
    .stat-card:hover{
      transform: translateY(-6px) scale(1.01);
      box-shadow: 0 18px 32px rgba(0,0,0,.12);
      filter:saturate(1.05);
    }
    .stat-card:active{ transform: translateY(-2px) scale(.99); box-shadow: 0 8px 18px rgba(0,0,0,.18); }

    .table tbody tr{ transition: background-color .15s ease; }
    .table tbody tr:hover{ background: rgba(0,0,0,.03); }

    .btn{ transition: transform .15s ease, box-shadow .15s ease; }
    .btn:hover{ transform: translateY(-1px); box-shadow: 0 6px 16px rgba(0,0,0,.12); }
    .btn:active{ transform: translateY(0); box-shadow: 0 2px 8px rgba(0,0,0,.12); }

    /* Fade-in (stagger) */
    @keyframes fadeUp{ from{opacity:0; transform:translateY(14px);} to{opacity:1; transform:translateY(0);} }
    .fade-in-up{ animation: fadeUp .5s cubic-bezier(.2,.65,.25,1) both; animation-delay: var(--delay, 0s); }

    /* Ripple */
    .rippleable{ position:relative; overflow:hidden; }
    .ripple{
      position:absolute; border-radius:50%; transform:scale(0);
      animation:ripple .6s linear; background:rgba(255,255,255,.45); pointer-events:none;
    }
    @keyframes ripple{ to{ transform:scale(4); opacity:0; } }

    /* Aksesibilitas */
    @media (prefers-reduced-motion: reduce){
      .stat-card, .btn, .sidebar a{ transition:none !important; }
      .fade-in-up{ animation:none !important; }
    }
  </style>

  @yield('head')
</head>
<body>

  <!-- Sidebar -->
  <aside class="sidebar">
    <div class="brand">SIM Bendahara</div>
    <a href="{{ route('dashboard') }}"
       class="rippleable {{ request()->routeIs('dashboard') ? 'active' : '' }}">
      <i class="fa fa-home me-2"></i> Dashboard
    </a>
    <a href="{{ route('transaksi.index') }}"
       class="rippleable {{ request()->is('transaksi*') ? 'active' : '' }}">
      <i class="fa fa-right-left me-2"></i> Data Transaksi
    </a>
    <a href="{{ route('pembayaran.index') }}"
       class="rippleable {{ request()->is('pembayaran*') ? 'active' : '' }}">
      <i class="fa fa-money-bill me-2"></i> Data Pembayaran
    </a>
{{-- Riwayat Transaksi --}}
        <li class="{{ request()->routeIs('riwayat.*') ? 'active' : '' }}">
  <a href="{{ route('riwayat.index') }}" class="d-flex align-items-center">
    <i class="fa-solid fa-rotate-right me-2"></i> Riwayat Transaksi
  </a>
</li>
    <a href="#" class="rippleable"><i class="fa fa-right-from-bracket me-2"></i> Logout</a>
  </aside>

  <!-- Main -->
  <main class="main">
    <div class="container-fluid px-3 px-md-4">
      {{-- flash global --}}
      @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show fade-in-up" role="alert" style="--delay:.00s">
          {{ session('success') }}
          <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
      @endif

      @yield('content')
    </div>
  </main>

  <!-- Bootstrap JS -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

  <!-- Ripple -->
  <script>
    // jadikan semua .btn & .sidebar a otomatis 'rippleable'
    document.querySelectorAll('.btn, .sidebar a, .stat-card').forEach(el => el.classList.add('rippleable'));

    document.addEventListener('click', function(e){
      const host = e.target.closest('.rippleable');
      if(!host) return;
      const rect = host.getBoundingClientRect();
      const d = Math.max(rect.width, rect.height);
      const circle = document.createElement('span');
      circle.className = 'ripple';
      circle.style.width = circle.style.height = d + 'px';
      circle.style.left = (e.clientX - rect.left - d/2) + 'px';
      circle.style.top  = (e.clientY - rect.top  - d/2) + 'px';
      host.appendChild(circle);
      setTimeout(()=> circle.remove(), 600);
    }, false);
  </script>

  @yield('scripts')
</body>
</html>
