<!doctype html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title>@yield('title', 'SIM Bendahara')</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="min-h-screen bg-gray-100">

<div class="min-h-screen flex">

    {{-- SIDEBAR --}}
    <aside class="w-64 bg-green-900 text-white flex flex-col">
        <div class="px-6 py-4 text-lg font-bold border-b border-green-800">
            MANAGEMENT BENDAHARA DIGITAL
        </div>

        <nav class="flex-1 px-2 py-4 space-y-1">
            <a href="{{ route('dashboard') }}"
               class="flex items-center px-3 py-2 rounded
                      {{ request()->routeIs('dashboard') ? 'bg-green-700' : 'hover:bg-green-800' }}">
                <span class="ml-1">Dashboard</span>
            </a>

            <a href="{{ route('transaksi.index') }}"
               class="flex items-center px-3 py-2 rounded
                      {{ request()->routeIs('transaksi.*') ? 'bg-green-700' : 'hover:bg-green-800' }}">
                <span class="ml-1">Data Transaksi</span>
            </a>

            <a href="{{ route('siswa.index') }}"
               class="flex items-center px-3 py-2 rounded
                      {{ request()->routeIs('pembayaran.*') ? 'bg-green-700' : 'hover:bg-green-800' }}">
                <span class="ml-1">Data Siswa</span>
            </a>

            <a href="{{ route('pembayaran.index') }}"
               class="flex items-center px-3 py-2 rounded
                      {{ request()->routeIs('pembayaran.*') ? 'bg-green-700' : 'hover:bg-green-800' }}">
                <span class="ml-1">Data Pembayaran</span>
            </a>
                
            <a href="{{ route('riwayat.index') }}"
               class="flex items-center px-3 py-2 rounded
                      {{ request()->routeIs('riwayat.*') ? 'bg-green-700' : 'hover:bg-green-800' }}">
                <span class="ml-1">Riwayat Transaksi</span>
            </a>
        </nav>

        <div class="px-4 py-4 border-t border-green-800">
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                @method('DELETE')
                <button type="submit"
                        class="w-full px-3 py-2 text-left rounded bg-green-700 hover:bg-green-600">
                    Logout
                </button>
            </form>
        </div>
    </aside>

    {{-- KONTEN UTAMA --}}
    <main class="flex-1 bg-gray-100">
        @yield('content')
    </main>

</div>

</body>
</html>
