@extends('layouts.admin')

@section('title', 'Data Pembayaran')

@section('content')
    {{-- ICONS --}}
    <link rel="stylesheet"
          href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">

    <style>
        /* BASE & LAYOUT */
        .page-card {
            background: #ffffff;
            border-radius: 16px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.05);
            padding: 30px;
        }

        .page-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 24px;
            border-bottom: 1px solid #f1f5f9;
            padding-bottom: 20px;
        }

        .page-header-title {
            font-size: 24px;
            font-weight: 700;
            color: #1e293b;
            margin-bottom: 4px;
        }

        .page-header-sub {
            font-size: 14px;
            color: #64748b;
        }

        /* BUTTON: TAMBAH */
        .btn-add {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 10px 20px;
            border-radius: 8px;
            background: #4f46e5;
            color: #ffffff;
            font-size: 14px;
            font-weight: 600;
            border: none;
            cursor: pointer;
            box-shadow: 0 8px 15px rgba(79, 70, 229, 0.3);
            transition: all .2s ease;
            text-decoration: none;
        }

        .btn-add i {
            font-size: 16px;
        }

        .btn-add:hover {
            background: #4338ca;
            box-shadow: 0 10px 20px rgba(79, 70, 229, 0.45);
            transform: translateY(-2px);
            color: #ffffff;
        }

        /* FILTER BAR */
        .filter-bar {
            display: flex;
            flex-wrap: wrap;
            gap: 20px;
            align-items: flex-end;
            margin-bottom: 24px;
            background: #f8fafc;
            padding: 15px;
            border-radius: 12px;
        }

        .filter-group {
            display: flex;
            flex-direction: column;
            gap: 6px;
            font-size: 14px;
        }

        .filter-group-label {
            font-weight: 500;
            color: #475569;
        }

        .input-icon,
        .select-icon {
            position: relative;
            display: inline-flex;
            align-items: center;
        }

        .input-icon input,
        .select-icon select {
            border-radius: 8px;
            border: 1px solid #cbd5e1;
            padding: 9px 15px 9px 40px;
            font-size: 14px;
            outline: none;
            background: #ffffff;
            min-width: 200px;
            transition: border-color .2s ease, box-shadow .2s ease;
            color: #1e293b;
        }

        .input-icon input:focus,
        .select-icon select:focus {
            border-color: #4f46e5;
            box-shadow: 0 0 0 3px rgba(79, 70, 229, 0.2);
        }

        .input-icon i,
        .select-icon i {
            position: absolute;
            left: 12px;
            font-size: 16px;
            color: #94a3b8;
        }

        .select-icon select {
            padding-right: 40px;
            appearance: none;
        }

        .select-icon .bi-chevron-down {
            position: absolute;
            right: 12px;
            left: auto;
            pointer-events: none;
            color: #94a3b8;
        }

        .btn-filter {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 9px 16px;
            border-radius: 8px;
            font-size: 14px;
            font-weight: 600;
            cursor: pointer;
            text-decoration: none;
            transition: all .2s ease;
        }

        .btn-filter i {
            font-size: 16px;
        }

        .btn-filter.primary {
            background: #10b981;
            border: 1px solid #10b981;
            color: #ffffff;
            box-shadow: 0 4px 10px rgba(16, 185, 129, 0.25);
        }

        .btn-filter.primary:hover {
            background: #059669;
            border-color: #059669;
            color: #ffffff;
        }

        .btn-filter.secondary {
            background: #ffffff;
            border: 1px solid #cbd5e1;
            color: #475569;
        }

        .btn-filter.secondary:hover {
            background: #f1f5f9;
            border-color: #94a3b8;
            color: #1e293b;
        }

        /* TABLE */
        .table-responsive {
            overflow-x: auto;
        }

        .table-custom {
            width: 100%;
            border-collapse: separate;
            border-spacing: 0;
            font-size: 14px;
        }

        .table-custom thead th {
            background: #e2e8f0;
            border-bottom: 2px solid #cbd5e1;
            padding: 12px 15px;
            font-weight: 700;
            color: #334155;
            text-transform: uppercase;
            text-align: left;
        }

        .table-custom thead th:first-child {
            border-top-left-radius: 8px;
        }

        .table-custom thead th:last-child {
            border-top-right-radius: 8px;
        }

        .table-custom tbody tr {
            transition: background-color .2s ease;
        }

        .table-custom td {
            padding: 12px 15px;
            color: #334155;
            vertical-align: middle;
            border-bottom: 1px solid #f1f5f9;
        }

        .table-custom tbody tr:hover {
            background-color: #f1f5f9;
        }

        .table-custom td.text-end {
            text-align: right;
            font-weight: 600;
            color: #10b981;
        }

        .table-custom td.text-center {
            text-align: center;
        }

        .empty-data-row td {
            font-style: italic;
            font-size: 14px;
            background: #f8fafc;
            border-radius: 0 0 8px 8px;
        }

        /* ACTION ICONS */
        .action-group {
            display: flex;
            justify-content: center;
            align-items: center;
            gap: 6px;
        }

        .badge-aksi {
            width: 32px;
            height: 32px;
            border-radius: 999px;
            border: 1px solid #e5e7eb;
            background: #ffffff;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            font-size: 15px;
            cursor: pointer;
            text-decoration: none;
            transition: all .18s ease;
        }

        .badge-aksi i {
            pointer-events: none;
        }

        .badge-print {
            color: #4f46e5;
        }

        .badge-edit {
            color: #0ea5e9;
        }

        .badge-hapus {
            color: #ef4444;
        }

        .badge-aksi:hover {
            transform: translateY(-1px);
            box-shadow: 0 4px 12px rgba(15, 23, 42, 0.12);
            border-color: transparent;
            background: #f9fafb;
        }

        .badge-print:hover {
            background: #eef2ff;
        }

        .badge-edit:hover {
            background: #e0f2fe;
        }

        .badge-hapus:hover {
            background: #fee2e2;
        }

        /* PAGINATION */
        .pagination-container {
            display: flex;
            justify-content: flex-end;
            margin-top: 20px;
        }

        .pagination-container nav {
            display: flex;
            gap: 4px;
        }

        .pagination-container .page-link {
            display: inline-flex;
            justify-content: center;
            align-items: center;
            min-width: 34px;
            height: 34px;
            padding: 0 8px;
            border-radius: 6px;
            color: #475569;
            text-decoration: none;
            transition: background-color .2s ease, color .2s ease;
            font-size: 14px;
            border: 1px solid #e2e8f0;
            background: #ffffff;
        }

        .pagination-container .page-link:hover {
            background-color: #f1f5f9;
        }

        .pagination-container .active .page-link {
            background-color: #4f46e5;
            border-color: #4f46e5;
            color: #ffffff;
            font-weight: 700;
        }

        .pagination-container .disabled .page-link {
            opacity: 0.5;
            cursor: not-allowed;
            background: #f8fafc;
            color: #94a3b8;
        }

        /* RESPONSIVE */
        @media (max-width: 992px) {
            .filter-bar {
                flex-direction: column;
                align-items: stretch;
            }

            .input-icon input,
            .select-icon select {
                min-width: 100%;
            }
        }
    </style>

    <div class="page-card">
        {{-- HEADER --}}
        <div class="page-header">
            <div>
                <div class="page-header-title">
                    <i class="bi bi-wallet2 me-2"></i> Daftar Pembayaran
                </div>
                <div class="page-header-sub">
                    Kelola setoran dan pembayaran santri di sini.
                </div>
            </div>

            <a href="{{ route('pembayaran.create') }}" class="btn-add">
                <i class="bi bi-plus-lg"></i>
                <span>Tambah Pembayaran</span>
            </a>
        </div>

        {{-- FILTER BAR --}}
        <form method="GET" action="{{ route('pembayaran.index') }}" class="filter-bar">
            @php
                $keteranganOptions = $pembayaran->pluck('keterangan')->filter()->unique()->values();
            @endphp

            {{-- Cari nama santri --}}
            <div class="filter-group">
                <span class="filter-group-label">Cari Nama Santri</span>
                <div class="input-icon">
                    <i class="bi bi-search"></i>
                    <input type="text" name="nama" value="{{ $nama ?? '' }}" placeholder="Ketik nama santri...">
                </div>
            </div>

            {{-- Keterangan --}}
            <div class="filter-group">
                <span class="filter-group-label">Filter Keterangan</span>
                <div class="select-icon">
                    <i class="bi bi-tag"></i>
                    <select name="keterangan">
                        <option value="semua" {{ ($keterangan ?? 'semua') == 'semua' ? 'selected' : '' }}>
                            Semua Keterangan
                        </option>
                        @foreach($keteranganOptions as $ket)
                            <option value="{{ $ket }}" {{ ($keterangan ?? '') == $ket ? 'selected' : '' }}>
                                {{ $ket }}
                            </option>
                        @endforeach
                    </select>
                    <i class="bi bi-chevron-down"></i>
                </div>
            </div>

            {{-- Per halaman --}}
            <div class="filter-group">
                <span class="filter-group-label">Data per Halaman</span>
                <div class="select-icon">
                    <i class="bi bi-grid-3x3-gap"></i>
                    <select name="per_page">
                        @foreach([10,25,50,100] as $opt)
                            <option value="{{ $opt }}" {{ ($perPage ?? 10) == $opt ? 'selected' : '' }}>
                                {{ $opt }} Data
                            </option>
                        @endforeach
                    </select>
                    <i class="bi bi-chevron-down"></i>
                </div>
            </div>

            {{-- Tombol --}}
            <button type="submit" class="btn-filter primary">
                <i class="bi bi-sliders"></i> Terapkan Filter
            </button>

            <a href="{{ route('pembayaran.index') }}" class="btn-filter secondary">
                <i class="bi bi-arrow-clockwise"></i> Reset
            </a>
        </form>

        {{-- TABEL --}}
        <div class="table-responsive">
            <table class="table-custom">
                <thead>
                <tr>
                    <th style="width:60px;text-align:center;">No</th>
                    <th style="width:140px;">Tanggal</th>
                    <th>Nama Santri</th>
                    <th>Keterangan</th>
                    <th style="width:120px;">Status</th>
                    <th style="width:160px;" class="text-end">Jumlah</th>
                    <th style="width:150px;" class="text-center">Aksi</th>
                </tr>
                </thead>

                <tbody>
                @forelse($pembayaran as $index => $row)
                    <tr>
                        {{-- No urut --}}
                        <td class="text-center">
                            {{ ($pembayaran->currentPage() - 1) * $pembayaran->perPage() + $index + 1 }}
                        </td>

                        {{-- Tanggal --}}
                        <td>{{ \Carbon\Carbon::parse($row->created_at)->format('d/m/Y') }}</td>

                        {{-- Nama santri --}}
                        <td>
                            <strong style="color:#1e293b;">
                                {{ $row->siswa->nama_lengkap ?? $row->nama_santri }}
                            </strong>
                        </td>

                        {{-- Keterangan --}}
                        <td>{{ $row->keterangan }}</td>

                        {{-- Status --}}
                        <td>
                            @if($row->status === 'Lunas')
                                <span style="color:#10b981;font-weight:600;">
                                    <i class="bi bi-check-circle-fill me-1"></i> Lunas
                                </span>
                            @else
                                <span style="color:#dc2626;font-weight:600;">
                                    <i class="bi bi-exclamation-circle-fill me-1"></i> Belum Lunas
                                </span>
                            @endif
                        </td>

                        {{-- Jumlah --}}
                        <td class="text-end">
                            Rp {{ number_format($row->jumlah, 0, ',', '.') }}
                        </td>

                        {{-- Aksi --}}
                        <td class="text-center">
                            <div class="action-group">
                                {{-- Cetak --}}
                                {{-- <a href="{{ route('pembayaran.print', $row->id) }}"
                                   class="badge-aksi badge-print"
                                   title="Cetak bukti pembayaran"
                                   target="_blank">
                                    <i class="bi bi-printer"></i>
                                </a> --}}

                                {{-- Edit --}}
                                <a href="{{ route('pembayaran.edit', $row->id) }}"
                                   class="badge-aksi badge-edit"
                                   title="Edit data">
                                    <i class="bi bi-pencil"></i>
                                </a>

                                {{-- Hapus --}}
                                <form action="{{ route('pembayaran.destroy', $row->id) }}"
                                      method="POST"
                                      style="display:inline-block"
                                      onsubmit="return confirm('Yakin ingin menghapus data pembayaran {{ $row->siswa->nama_lengkap ?? $row->nama_santri }} ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"
                                            class="badge-aksi badge-hapus"
                                            title="Hapus data">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr class="empty-data-row">
                        <td colspan="7" class="text-center" style="padding:25px;">
                            <i class="bi bi-info-circle me-2"></i>
                            Data pembayaran belum tersedia.
                        </td>
                    </tr>
                @endforelse
                </tbody>
            </table>
        </div>

        {{-- PAGINATION --}}
        <div class="pagination-container">
            {{ $pembayaran->withQueryString()->links() }}
        </div>
    </div>
@endsection
