@extends('layouts.admin')

@section('content')
<div class="p-6">

    {{-- Judul --}}
    <h1 class="text-2xl font-bold text-gray-800 mb-6">
        Riwayat Transaksi
    </h1>

    {{-- Ringkasan --}}
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">

        {{-- Pemasukan --}}
        <div class="bg-green-500 text-white rounded-xl p-6 shadow">
            <p class="text-sm opacity-80">Total Pemasukan</p>
            <p class="text-2xl font-bold mt-1">
                Rp {{ number_format($totalMasuk, 0, ',', '.') }}
            </p>
        </div>

        {{-- Pengeluaran --}}
        <div class="bg-red-500 text-white rounded-xl p-6 shadow">
            <p class="text-sm opacity-80">Total Pengeluaran</p>
            <p class="text-2xl font-bold mt-1">
                Rp {{ number_format($totalKeluar, 0, ',', '.') }}
            </p>
        </div>

        {{-- Saldo --}}
        <div class="bg-blue-500 text-white rounded-xl p-6 shadow">
            <p class="text-sm opacity-80">Saldo Akhir</p>
            <p class="text-2xl font-bold mt-1">
                Rp {{ number_format($totalMasuk - $totalKeluar, 0, ',', '.') }}
            </p>
        </div>

    </div>

    {{-- Tabel Riwayat --}}
    <div class="bg-white rounded-xl shadow p-6">
        <h2 class="text-lg font-semibold text-gray-700 mb-4">
            Detail Transaksi
        </h2>

        <div class="overflow-x-auto">
            <table class="min-w-full border border-gray-200 rounded-lg overflow-hidden">
                <thead class="bg-gray-100 text-gray-700">
                    <tr>
                        <th class="px-4 py-3 text-left text-sm font-semibold">Tanggal</th>
                        <th class="px-4 py-3 text-left text-sm font-semibold">Nama</th>
                        <th class="px-4 py-3 text-left text-sm font-semibold">Jenis</th>
                        <th class="px-4 py-3 text-right text-sm font-semibold">Jumlah</th>
                        <th class="px-4 py-3 text-left text-sm font-semibold">Keterangan</th>
                    </tr>
                </thead>

                <tbody class="divide-y divide-gray-200">
                    @forelse ($riwayat as $item)
                        <tr class="hover:bg-gray-50">
                            <td class="px-4 py-3 text-sm">
                                {{ $item->tanggal ?? $item->created_at->format('d-m-Y') }}
                            </td>
                            <td class="px-4 py-3 text-sm">
                                {{ $item->nama_santri ?? '-' }}
                            </td>
                            <td class="px-4 py-3 text-sm">
                                <span class="px-2 py-1 rounded text-xs font-semibold
                                    {{ $item->jenis === 'setoran' ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700' }}">
                                    {{ ucfirst($item->jenis) }}
                                </span>
                            </td>
                            <td class="px-4 py-3 text-sm text-right font-medium">
                                Rp {{ number_format($item->jumlah, 0, ',', '.') }}
                            </td>
                            <td class="px-4 py-3 text-sm">
                                {{ $item->keterangan }}
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-4 py-6 text-center text-gray-500">
                                Belum ada data transaksi
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

</div>
@endsection
