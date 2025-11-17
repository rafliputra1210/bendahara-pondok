@extends('layouts.app')

@section('content')
@php
  // ==== fallback supaya view tetap aman kalau variabel belum dikirim ====
  $totalMasuk   = $totalMasuk   ?? 0;
  $totalKeluar  = $totalKeluar  ?? 0;
  $saldo        = $saldo        ?? ($totalMasuk - $totalKeluar);
  $jenis        = $jenis        ?? '';
  $q            = $q            ?? '';
  $dari         = $dari         ?? '';
  $sampai       = $sampai       ?? '';
  $perPage      = (int)($perPage ?? (method_exists($riwayat ?? null, 'perPage') ? $riwayat->perPage() : 15));
@endphp

<style>
  :root{
    --ink:#0f172a;            /* slate-900 */
    --muted:#64748b;          /* slate-500 */
    --soft:#e2e8f0;           /* slate-200 */
    --bg:#ffffff;
    --brand:#2563eb;          /* indigo-600 */
    --brand-2:#4f46e5;        /* indigo-600 alt */
    --green:#16a34a;          /* emerald-600 */
    --red:#dc2626;            /* red-600 */
    --vio:#7c3aed;            /* violet-600 */
  }

  /* ===== header ===== */
  .page-actions .btn{ border-radius:10px; }
  .btn-soft{ background:#2674fa; border:1px solid #e2e8f0; color:#fcfdfd; }
  .btn-soft:hover{ background:#f9f9fa; color:#0f172a; }
  .btn-brand{ background:var(--brand); border-color:var(--brand); color:#fff; }
  .btn-brand:hover{ filter:brightness(.95); color:#fff; }

  /* ===== stat cards ===== */
  .stat-wrap{ display:grid; gap:14px; grid-template-columns:repeat(12,1fr); }
  .stat{ grid-column:span 12; background:var(--bg); border:1px solid var(--soft);
         border-radius:16px; padding:16px 18px; box-shadow:0 8px 24px rgba(15,23,42,.06); }
  @media (min-width:768px){ .stat{ grid-column:span 4; } }
  .stat .label{ color:var(--muted); font-weight:700; margin-bottom:6px; display:flex; align-items:center; gap:10px; }
  .stat .value{ font-size:1.55rem; font-weight:800; color:var(--ink); letter-spacing:.2px; }

  /* ===== filter ===== */
  .filter-card{ border:1px solid var(--soft); background:var(--bg); border-radius:16px; }
  .filter-grid{ display:grid; gap:12px; grid-template-columns:repeat(12,1fr); }
  .filter-grid > *{ grid-column:span 12; }
  @media (min-width:992px){
    .filter-grid > .col-jenis  { grid-column:span 3; }
    .filter-grid > .col-q      { grid-column:span 3; }
    .filter-grid > .col-dari   { grid-column:span 2; }
    .filter-grid > .col-sampai { grid-column:span 2; }
    .filter-grid > .col-page   { grid-column:span 2; }
  }

  /* ===== table ===== */
  .table-responsive{ border:1px solid var(--soft); border-radius:16px; overflow:hidden; }
  table thead th{
    position:sticky; top:0; z-index:2;
    background:#0080ff !important; border-bottom:1px solid var(--soft) !important;
    font-weight:800; color:#ffffff;
  }
  table tbody td{ vertical-align:middle; }
  .table-striped>tbody>tr:nth-of-type(odd)>*{ background:#fafafa; }
  .badge-soft{
    padding:.45rem .7rem; border-radius:999px; font-weight:800;
    border:1px solid transparent; letter-spacing:.2px; font-size:.82rem;
  }
  .badge-in  { background:rgba(22,163,74,.10); color:var(--green); border-color:rgba(22,163,74,.25); }
  .badge-out { background:rgba(220,38,38,.10); color:var(--red);   border-color:rgba(220,38,38,.25); }
  .chip{
    background:#eef2ff; color:#4338ca; border:1px solid #e0e7ff;
    font-weight:800; padding:.35rem .65rem; border-radius:999px; font-size:.78rem;
  }
  .chip.tx   { background:#ecfeff; color:#0369a1; border-color:#bae6fd; }   /* transaksi */
  .chip.pay  { background:#f5f3ff; color:#6d28d9; border-color:#ddd6fe; }   /* pembayaran */

  /* ===== print ===== */
  @media print{
    body{ background:#fff; }
    .sidebar, .navbar, .page-actions, .filter-card, .btn { display:none !important; }
    .stat-wrap{ grid-template-columns:repeat(3,1fr) !important; gap:8px; }
    .stat{ padding:10px 12px; box-shadow:none; }
    .table-responsive{ border:0; }
    table{ font-size:12px; }
  }
</style>

<div class="d-flex justify-content-between align-items-center mb-3">
  <h3 class="fw-bold m-0">
    <i class="fa-solid fa-rotate-left me-2"></i>Riwayat Transaksi
  </h3>

  <div class="page-actions d-flex gap-2">
    <button type="button" onclick="window.print()" class="btn btn-soft">
      <i class="fa-solid fa-print me-1"></i> Cetak
    </button>

    @if(Route::has('riwayat.export.excel'))
      <a href="{{ route('riwayat.export.excel', request()->query()) }}" class="btn btn-soft">
        <i class="fa-solid fa-file-excel me-1"></i> Excel
      </a>
    @endif
    @if(Route::has('riwayat.export.pdf'))
      <a href="{{ route('riwayat.export.pdf', request()->query()) }}" class="btn btn-soft">
        <i class="fa-solid fa-file-pdf me-1"></i> PDF
      </a>
    @endif
  </div>
</div>

{{-- ====== STAT CARDS ====== --}}
<div class="stat-wrap mb-3">
  <div class="stat">
    <div class="label"><i class="fa-solid fa-wallet"></i> Total Masuk</div>
    <div class="value">Rp {{ number_format((float)$totalMasuk,0,',','.') }}</div>
  </div>
  <div class="stat">
    <div class="label"><i class="fa-solid fa-chart-line"></i> Total Keluar</div>
    <div class="value">Rp {{ number_format((float)$totalKeluar,0,',','.') }}</div>
  </div>
  <div class="stat">
    <div class="label"><i class="fa-solid fa-coins"></i> Saldo</div>
    <div class="value">Rp {{ number_format((float)$saldo,0,',','.') }}</div>
  </div>
</div>

{{-- ====== FILTER ====== --}}
<form method="GET" class="p-3 mb-3 filter-card">
  <div class="filter-grid">
    <div class="col-jenis">
      <label class="form-label mb-1">Jenis</label>
      <select name="jenis" class="form-select">
        <option value="">Semua</option>
        <option value="pemasukan"   {{ $jenis==='pemasukan'?'selected':'' }}>Pemasukan</option>
        <option value="pengeluaran" {{ $jenis==='pengeluaran'?'selected':'' }}>Pengeluaran</option>
      </select>
    </div>

    <div class="col-q">
      <label class="form-label mb-1">Cari Keterangan</label>
      <input type="text" name="q" value="{{ $q }}" class="form-control" placeholder="ketik kata kunci…">
    </div>

    <div class="col-dari">
      <label class="form-label mb-1">Dari</label>
      <input type="date" name="dari" value="{{ $dari }}" class="form-control">
    </div>

    <div class="col-sampai">
      <label class="form-label mb-1">Sampai</label>
      <input type="date" name="sampai" value="{{ $sampai }}" class="form-control">
    </div>

    <div class="col-page">
      <label class="form-label mb-1">Per Halaman</label>
      <select name="per_page" class="form-select">
        @foreach([10,15,25,50,100] as $n)
          <option value="{{ $n }}" {{ (int)$perPage===$n?'selected':'' }}>{{ $n }}</option>
        @endforeach
      </select>
    </div>
  </div>

  <div class="d-flex gap-2 mt-3">
    <button class="btn btn-brand"><i class="fa fa-search me-1"></i> Terapkan</button>
    <a href="{{ route('riwayat.index') }}" class="btn btn-soft">Reset</a>
  </div>
</form>

{{-- ====== TABLE ====== --}}
<div class="table-responsive">
  <table class="table table-striped align-middle table-hover mb-0">
    <thead>
      <tr>
        <th style="width:70px" class="text-center">#</th>
        <th style="width:140px">Tanggal</th>
        <th style="width:150px">Jenis</th>
        <th>Keterangan</th>
        <th style="width:180px">Jumlah</th>
        <th style="width:160px">Sumber</th>
      </tr>
    </thead>
    <tbody>
      @forelse($riwayat as $row)
        <tr>
          <td class="text-center">
            {{ $loop->iteration + ($riwayat->currentPage()-1)*$riwayat->perPage() }}
          </td>
          <td>{{ \Illuminate\Support\Carbon::parse($row->tanggal)->translatedFormat('d M Y') }}</td>
          <td>
            @if(strtolower($row->jenis) === 'pemasukan')
              <span class="badge-soft badge-in">Pemasukan</span>
            @else
              <span class="badge-soft badge-out">Pengeluaran</span>
            @endif
          </td>
          <td class="fw-semibold">{{ $row->keterangan }}</td>
          <td>Rp {{ number_format((float)$row->jumlah,0,',','.') }}</td>
          <td>
            @php $src = strtolower($row->sumber ?? ''); @endphp
            <span class="chip {{ $src==='pembayaran'?'pay':'tx' }} text-uppercase">
              {{ $row->sumber }}
            </span>
          </td>
        </tr>
      @empty
        <tr>
          <td colspan="6" class="text-center text-muted py-5">
            <i class="fa-regular fa-face-smile-wink fa-2xl mb-2 d-block"></i>
            Belum ada data untuk filter ini.
          </td>
        </tr>
      @endforelse
    </tbody>

    {{-- ===== total halaman ini (sub-total) ===== --}}
    @if(($riwayat->count() ?? 0) > 0)
      @php $pageTotal = (float) $riwayat->sum('jumlah'); @endphp
      <tfoot>
        <tr>
          <th colspan="4" class="text-end">Total halaman ini</th>
          <th>Rp {{ number_format($pageTotal,0,',','.') }}</th>
          <th></th>
        </tr>
      </tfoot>
    @endif
  </table>
</div>

@if(isset($riwayat) && $riwayat->hasPages())
  <div class="d-flex justify-content-between align-items-center mt-2">
    <small class="text-muted">
      Menampilkan {{ $riwayat->firstItem() }}–{{ $riwayat->lastItem() }} dari {{ $riwayat->total() }} data
    </small>
    {{ $riwayat->onEachSide(1)->links() }}
  </div>
@endif
@endsection
