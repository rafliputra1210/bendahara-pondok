@extends('layouts.admin')

@section('title', 'Data Siswa')

@section('content')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">

<style>
    /* Card */
    .page-card {
        background: #fff;
        border-radius: 14px;
        box-shadow: 0 12px 30px rgba(2,6,23,0.06);
        padding: 26px;
    }
    .page-header { display:flex; justify-content:space-between; align-items:center; gap:12px; margin-bottom:18px; }
    .page-title { font-size:22px; font-weight:700; color:#0f1724; }
    .page-sub { color:#64748b; font-size:13px; }

    /* Buttons */
    .btn-add {
        background: linear-gradient(135deg,#7c3aed,#5b21b6);
        color:#fff; padding:10px 16px; border-radius:12px; display:inline-flex; align-items:center; gap:8px;
        box-shadow:0 8px 20px rgba(124,58,237,0.18);
        text-decoration:none;
    }
    .btn-add:hover { transform:translateY(-3px); }

    /* Filter bar */
    .filter-bar { display:flex; gap:16px; flex-wrap:wrap; align-items:center; margin-bottom:18px; background:#f8fafc; padding:14px; border-radius:10px; }
    .filter-group { display:flex; flex-direction:column; gap:6px; font-size:14px; }
    .filter-group label { color:#334155; font-weight:600; }
    .form-control-inline {
        min-width:180px; padding:9px 12px; border-radius:8px; border:1px solid #e6eef6; background:#fff;
    }
    .form-control-inline.small { min-width:140px; }

    .btn-apply { background:#10b981; color:#fff; border-radius:10px; padding:9px 14px; font-weight:600; border:none; cursor:pointer; }
    .btn-reset { background:#fff; border:1px solid #e6eef6; border-radius:10px; padding:9px 12px; color:#475569; cursor:pointer; }

    /* Table */
    .table-wrap { overflow-x:auto; border-radius:12px; }
    table.table-siswa { width:100%; border-collapse:collapse; font-size:14px; }
    table.table-siswa thead th { background:#eef2ff; padding:14px; text-align:left; color:#0f1724; font-weight:700; border-bottom:1px solid #e6eef6; }
    table.table-siswa tbody td { padding:16px 14px; border-bottom:1px solid #f1f5f9; color:#334155; vertical-align:middle; }
    table.table-siswa tbody tr:hover { background:#fbfdff; }

    .badge-jk { display:inline-block; padding:6px 10px; border-radius:999px; font-weight:700; font-size:13px; }
    .badge-jk.m { background:#eef2ff; color:#3730a3; }
    .badge-jk.f { background:#fff1f2; color:#9f1239; }
    .badge-jk.empty { background:#f1f5f9; color:#94a3b8; }

    .action-btn { display:inline-flex; align-items:center; gap:6px; padding:8px; border-radius:8px; border:none; cursor:pointer; }
    .action-edit { background:#eff6ff; color:#1d4ed8; }
    .action-delete { background:#ffefef; color:#b91c1c; }

    /* pagination container */
    .pagination-wrap { display:flex; justify-content:flex-end; margin-top:18px; }

    /* Responsive */
    @media (max-width:900px) {
        .filter-bar { flex-direction:column; align-items:stretch; }
        .form-control-inline { min-width:100%; }
    }
</style>

<div class="page-card">
    <div class="page-header">
        <div>
            <div class="page-title"><i class="bi bi-people-fill me-2"></i> Data Siswa</div>
            <div class="page-sub">Daftar siswa yang digunakan pada data pembayaran.</div>
        </div>

        <a href="{{ route('siswa.create') }}" class="btn-add">
            <i class="bi bi-plus-lg"></i> Tambah Siswa
        </a>
    </div>

    {{-- FILTER BAR --}}
    <form action="{{ route('siswa.index') }}" method="GET" class="filter-bar" role="search">
        <div class="filter-group">
            <label>Filter Kelas</label>
            <select name="kelas" class="form-control-inline">
                <option value="semua">Semua Kelas</option>
                @foreach($kelasOptions as $opt)
                    <option value="{{ $opt }}" {{ (string)($kelas ?? '') === (string)$opt ? 'selected' : '' }}>
                        {{ $opt }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="filter-group">
            <label>Jenis Kelamin</label>
            <select name="jk" class="form-control">
                <option value="">-- Pilih Jenis Kelamin --</option>
                <option value="Laki-laki" {{ old('jk', $siswa->jk ?? '') == 'Laki-laki' ? 'selected' : '' }}>Laki-laki</option>
                <option value="Perempuan" {{ old('jk', $siswa->jk ?? '') == 'Perempuan' ? 'selected' : '' }}>Perempuan</option>
            </select>

        </div>

        <div class="filter-group" style="flex:1;">
            <label>Cari Nama</label>
            <input type="text" name="q" value="{{ $q ?? '' }}" class="form-control-inline" placeholder="Ketik nama...">
        </div>

        <div style="display:flex;align-items:flex-end;gap:10px;">
            <button type="submit" class="btn-apply">Terapkan</button>
            <a href="{{ route('siswa.index') }}" class="btn-reset">Reset</a>
        </div>
    </form>

    {{-- TABLE --}}
    <div class="table-wrap" style="margin-top:12px;">
        <table class="table-siswa">
            <thead>
                <tr>
                    <th style="width:60px;">No</th>
                    <th style="width:140px;">Tanggal</th>
                    <th>Nama Lengkap</th>
                    <th style="width:120px;">JK</th>
                    <th>Alamat</th>
                    <th style="width:90px;">Kelas</th>
                    <th style="width:160px; text-align:center;">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($siswa as $i => $row)
                    <tr>
                        <td>{{ ($siswa->currentPage()-1) * $siswa->perPage() + $i + 1 }}</td>
                        <td>{{ \Carbon\Carbon::parse($row->created_at)->format('d/m/Y') }}</td>

                        <td style="font-weight:700; color:#0f1724;">{{ strtoupper($row->nama_lengkap) }}</td>

                        <td>
                            @php $jkVal = trim($row->jk ?? ''); @endphp
                            @if($jkVal === 'Laki-laki')
                                <span class="badge-jk m">Laki-laki</span>
                            @elseif($jkVal === 'Perempuan')
                                <span class="badge-jk f">Perempuan</span>
                            @else
                                <span class="badge-jk empty">-</span>
                            @endif
                        </td>

                        <td>{{ $row->alamat ?? '-' }}</td>
                        <td>{{ $row->kelas ?? '-' }}</td>

                        <td style="text-align:center;">
                            <a href="{{ route('siswa.edit', $row->id) }}" class="action-btn action-edit" title="Edit">
                                <i class="bi bi-pencil"></i>
                            </a>

                            <form action="{{ route('siswa.destroy', $row->id) }}" method="POST" style="display:inline-block;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" onclick="return confirm('Hapus siswa {{ $row->nama_lengkap }}?')" class="action-btn action-delete" title="Hapus">
                                    <i class="bi bi-trash"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" style="text-align:center; padding:28px; color:#64748b;">
                            <i class="bi bi-info-circle me-2"></i> Belum ada data siswa.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    {{-- PAGINATION --}}
    <div class="pagination-wrap">
        {{ $siswa->withQueryString()->links() }}
    </div>
</div>

@endsection
