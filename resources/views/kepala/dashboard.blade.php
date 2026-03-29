<!doctype html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title>Dashboard Kepala Madrasah</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="min-h-screen bg-gradient-to-br from-gray-100 to-gray-200">

<div class="max-w-7xl mx-auto p-6">

    <!-- HEADER -->
    <div class="flex flex-col md:flex-row md:items-center md:justify-between mb-8 gap-4">
        <div>
            <h1 class="text-3xl font-extrabold text-gray-800">
                Dashboard Kepala Madrasah
            </h1>
            <p class="text-sm text-gray-600 mt-1">
                Monitoring transaksi & pembayaran bendahara (read-only).
            </p>
        </div>

        <form method="POST" action="{{ route('logout') }}">
            @csrf
            @method('DELETE')
            <button
                type="submit"
                class="flex items-center gap-2 px-5 py-2.5 rounded-lg
                       bg-red-600 text-white font-medium
                       hover:bg-red-700 transition shadow">
                Logout
            </button>
        </form>
    </div>

    <!-- CARD RINGKASAN -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-10">

        <!-- PEMASUKAN -->
        <div class="rounded-xl p-5 text-white shadow-lg
                    bg-gradient-to-r from-blue-500 to-blue-600">
            <p class="text-sm opacity-90">Total Pemasukan</p>
            <p class="mt-3 text-3xl font-bold">
                Rp {{ number_format($totalPemasukan ?? 0, 0, ',', '.') }}
            </p>
        </div>

        <!-- PENGELUARAN -->
        <div class="rounded-xl p-5 text-white shadow-lg
                    bg-gradient-to-r from-red-500 to-red-600">
            <p class="text-sm opacity-90">Total Pengeluaran</p>
            <p class="mt-3 text-3xl font-bold">
                Rp {{ number_format($totalPengeluaran ?? 0, 0, ',', '.') }}
            </p>
        </div>

        <!-- SALDO -->
        <div class="rounded-xl p-5 text-white shadow-lg
                    bg-gradient-to-r from-green-500 to-green-600">
            <p class="text-sm opacity-90">Saldo Akhir</p>
            <p class="mt-3 text-3xl font-bold">
                Rp {{ number_format($saldo ?? 0, 0, ',', '.') }}
            </p>
        </div>

    </div>

    <!-- TRANSAKSI TERBARU -->
    <div class="bg-white rounded-xl shadow mb-8 overflow-hidden">
        <div class="px-5 py-4 border-b">
            <h2 class="font-semibold text-lg text-gray-800">
                Transaksi Terbaru
            </h2>
        </div>

        <div class="overflow-x-auto">
            <table class="min-w-full text-sm">
                <thead class="bg-gray-50 text-gray-600 uppercase text-xs">
                <tr>
                    <th class="px-4 py-3 text-left">Tanggal</th>
                    <th class="px-4 py-3 text-left">Jenis</th>
                    <th class="px-4 py-3 text-left">Keterangan</th>
                    <th class="px-4 py-3 text-right">Jumlah</th>
                </tr>
                </thead>
                <tbody>
                @forelse($transaksiTerbaru as $t)
                    <tr class="border-t hover:bg-gray-50">
                        <td class="px-4 py-3">
                            {{ \Carbon\Carbon::parse($t->tanggal)->format('d-m-Y') }}
                        </td>
                        <td class="px-4 py-3 capitalize">
                            <span class="px-2 py-1 rounded text-xs font-semibold
                                {{ $t->jenis === 'pengeluaran'
                                    ? 'bg-red-100 text-red-700'
                                    : 'bg-blue-100 text-blue-700' }}">
                                {{ $t->jenis }}
                            </span>
                        </td>
                        <td class="px-4 py-3">{{ $t->keterangan }}</td>
                        <td class="px-4 py-3 text-right font-medium">
                            Rp {{ number_format($t->jumlah, 0, ',', '.') }}
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="px-4 py-6 text-center text-gray-500">
                            Belum ada data transaksi.
                        </td>
                    </tr>
                @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- PEMBAYARAN TERBARU -->
    <div class="bg-white rounded-xl shadow overflow-hidden">
        <div class="px-5 py-4 border-b">
            <h2 class="font-semibold text-lg text-gray-800">
                Pembayaran Terbaru
            </h2>
        </div>

        <div class="overflow-x-auto">
            <table class="min-w-full text-sm">
                <thead class="bg-gray-50 text-gray-600 uppercase text-xs">
                <tr>
                    <th class="px-4 py-3 text-left">Tanggal</th>
                    <th class="px-4 py-3 text-left">Nama Santri</th>
                    <th class="px-4 py-3 text-left">Keterangan</th>
                    <th class="px-4 py-3 text-right">Jumlah</th>
                </tr>
                </thead>
                <tbody>
                @forelse($pembayaranTerbaru as $p)
                    <tr class="border-t hover:bg-gray-50">
                        <td class="px-4 py-3">
                            {{ \Carbon\Carbon::parse($p->tanggal ?? $p->created_at)->format('d-m-Y') }}
                        </td>
                        <td class="px-4 py-3 font-medium">
                            {{ $p->nama_santri ?? '-' }}
                        </td>
                        <td class="px-4 py-3 text-gray-600">
                            {{ $p->keterangan ?? '-' }}
                        </td>
                        <td class="px-4 py-3 text-right font-semibold text-green-700">
                            Rp {{ number_format($p->jumlah ?? 0, 0, ',', '.') }}
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="px-4 py-6 text-center text-gray-500">
                            Belum ada data pembayaran.
                        </td>
                    </tr>
                @endforelse
                </tbody>
            </table>
        </div>
    </div>

</div>
</body>
</html>
