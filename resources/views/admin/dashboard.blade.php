@extends('layouts.admin')

@section('title', 'Dashboard Administrator')

@section('content')
<style>
    body {
        background: #f3f6fd;
    }

    .page-wrapper {
        padding: 24px 32px;
    }

    .page-header {
        margin-bottom: 24px;
    }

    .page-title {
        font-size: 24px;
        font-weight: 700;
        color: #1f2937;
    }

    .page-subtitle {
        font-size: 13px;
        color: #6b7280;
    }

    .summary-row {
        display: grid;
        grid-template-columns: repeat(4, minmax(0, 1fr));
        gap: 18px;
        margin-bottom: 24px;
    }

    .summary-card {
        border-radius: 18px;
        padding: 16px 18px;
        color: #fff;
        box-shadow: 0 18px 30px rgba(15, 23, 42, 0.18);
        position: relative;
        overflow: hidden;
    }

    .summary-card.yellow  { background: linear-gradient(120deg,#fbbf24,#f97316); }
    .summary-card.blue    { background: linear-gradient(120deg,#2563eb,#4f46e5); }
    .summary-card.red     { background: linear-gradient(120deg,#f97373,#ef4444); }
    .summary-card.green   { background: linear-gradient(120deg,#22c55e,#16a34a); }

    .summary-label {
        font-size: 13px;
        font-weight: 600;
        text-transform: uppercase;
        opacity: .9;
    }

    .summary-value {
        font-size: 28px;
        font-weight: 800;
        margin: 4px 0 10px;
    }

    .card-panel {
        background: #ffffff;
        border-radius: 18px;
        padding: 16px 18px 18px;
        box-shadow: 0 14px 26px rgba(15, 23, 42, 0.12);
    }

    .bottom-row {
        display: grid;
        grid-template-columns: repeat(2, minmax(0,1fr));
        gap: 18px;
        margin-top: 16px;
    }

    .table-title {
        font-size: 14px;
        font-weight: 600;
        margin-bottom: 10px;
        color: #111827;
    }

    .table-custom {
        width: 100%;
        border-collapse: collapse;
        font-size: 12px;
    }

    .table-custom th,
    .table-custom td {
        padding: 8px 10px;
        border-bottom: 1px solid #e5e7eb;
    }

    .table-custom th {
        font-size: 11px;
        font-weight: 600;
        text-transform: uppercase;
        color: #6b7280;
    }
</style>

<div class="page-wrapper">

    {{-- HEADER --}}
    <div class="page-header">
        <h1 class="page-title">Dashboard Administrator</h1>
        <p class="page-subtitle">Ringkasan keuangan & transaksi santri.</p>
    </div>

    {{-- TOP SUMMARY CARDS --}}
    <div class="summary-row">
        <div class="summary-card yellow">
            <div class="summary-label">Siswa Aktif</div>
            <div class="summary-value">{{ $siswaAktif ?? 0 }}</div>
        </div>

        <div class="summary-card blue">
            <div class="summary-label">Total Setoran</div>
            <div class="summary-value">
                Rp {{ number_format($totalSetoran ?? 0, 0, ',', '.') }}
            </div>
        </div>

        <div class="summary-card red">
            <div class="summary-label">Total Pengeluaran</div>
            <div class="summary-value">
                Rp {{ number_format($totalPengeluaran ?? 0, 0, ',', '.') }}
            </div>
        </div>

        <div class="summary-card green">
            <div class="summary-label">Total Saldo</div>
            <div class="summary-value">
                Rp {{ number_format($saldo ?? 0, 0, ',', '.') }}
            </div>
        </div>
    </div>

    {{-- TABLES --}}
    <div class="bottom-row">
        {{-- Transaksi terbaru --}}
        <div class="card-panel">
            <div class="table-title">Transaksi Terbaru</div>
            <table class="table-custom">
                <thead>
                <tr>
                    <th>Tanggal</th>
                    <th>Jenis</th>
                    <th>Keterangan</th>
                    <th>Jumlah</th>
                </tr>
                </thead>
                <tbody>
                @forelse($transaksiTerbaru as $t)
                    <tr>
                        <td>{{ \Carbon\Carbon::parse($t->tanggal)->format('d-m-Y') }}</td>
                        <td>{{ $t->jenis }}</td>
                        <td>{{ $t->keterangan }}</td>
                        <td>Rp {{ number_format($t->jumlah, 0, ',', '.') }}</td>
                    </tr>
                @empty
                    <tr><td colspan="4">Belum ada transaksi.</td></tr>
                @endforelse
                </tbody>
            </table>
        </div>

        {{-- Pembayaran terbaru --}}
        <div class="card-panel">
            <div class="table-title">Pembayaran Terbaru</div>
            <table class="table-custom">
                <thead>
                <tr>
                    <th>Tanggal</th>
                    <th>Nama Santri</th>
                    <th>Keterangan</th>
                    <th>Jumlah</th>
                </tr>
                </thead>
                <tbody>
                @forelse($pembayaranTerbaru as $p)
                    <tr>
                        <td>{{ optional($p->created_at)->format('d-m-Y') }}</td>
                        <td>{{ $p->nama_santri }}</td>
                        <td>{{ $p->keterangan }}</td>
                        <td>Rp {{ number_format($p->jumlah, 0, ',', '.') }}</td>
                    </tr>
                @empty
                    <tr><td colspan="4">Belum ada pembayaran.</td></tr>
                @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
