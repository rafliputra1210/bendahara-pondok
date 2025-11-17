@extends('layouts.app')

@section('content')

@php
  // nilai default supaya view aman
  $q          = $q          ?? '';
  $keterangan = $keterangan ?? '';
  $perPage    = $perPage    ?? (method_exists($pembayaran, 'perPage') ? $pembayaran->perPage() : 10);

  $totalSetoran     = $totalSetoran     ?? 0;
  $totalPengeluaran = $totalPengeluaran ?? 0;
  $totalSaldo       = $totalSaldo       ?? ($totalSetoran - $totalPengeluaran);

  // opsi dropdown keterangan
  $opsiKet = [
    ''                  => 'Semua',
    'Syahriyyah Pondok' => 'Syahriyyah Pondok',
    'Syahriyyah Mds'    => 'Syahriyyah Mds',
    'Loker'             => 'Loker',
  ];
@endphp

<style>
  .stat-mini { border:0; border-radius:14px; box-shadow:0 6px 14px rgba(0,0,0,.06); }
  .stat-mini .label{ font-size:.9rem; opacity:.9; }
  .stat-mini .value{ font-weight:800; font-size:1.35rem; }
  .table thead th { position:sticky; top:0; background:#fff; z-index:1; }
</style>

<div class="d-flex justify-content-between align-items-center mb-3 fade-in-up" style="--delay:.00s">
  <h3 class="fw-bold m-0"><i class="fa-solid fa-sack-dollar me-2"></i>Data Pembayaran</h3>
  <a href="{{ route('pembayaran.create') }}" class="btn btn-primary rippleable">
    <i class="fa fa-plus me-1"></i> Tambah
  </a>
</div>

{{-- Ringkasan --}}
<div class="row g-3 mb-3">
  <div class="col-12 col-md-4 col-xl-3">
    <div class="card stat-mini bg-primary text-white rippleable fade-in-up" style="--delay:.04s">
      <div class="card-body d-flex justify-content-between align-items-center">
        <div>
          <div class="label">Total Setoran</div>
          <div class="value">Rp {{ number_format($totalSetoran,0,',','.') }}</div>
        </div>
        <i class="fa-solid fa-wallet fs-2 opacity-75"></i>
      </div>
    </div>
  </div>
  <div class="col-12 col-md-4 col-xl-3">
    <div class="card stat-mini bg-danger text-white rippleable fade-in-up" style="--delay:.08s">
      <div class="card-body d-flex justify-content-between align-items-center">
        <div>
          <div class="label">Total Pengeluaran</div>
          <div class="value">Rp {{ number_format($totalPengeluaran,0,',','.') }}</div>
        </div>
        <i class="fa-solid fa-chart-line fs-2 opacity-75"></i>
      </div>
    </div>
  </div>
  <div class="col-12 col-md-4 col-xl-3">
    <div class="card stat-mini bg-success text-white rippleable fade-in-up" style="--delay:.12s">
      <div class="card-body d-flex justify-content-between align-items-center">
        <div>
          <div class="label">Total Saldo</div>
          <div class="value">Rp {{ number_format($totalSaldo,0,',','.') }}</div>
        </div>
        <i class="fa-solid fa-coins fs-2 opacity-75"></i>
      </div>
    </div>
  </div>
</div>

{{-- Filter & Pencarian --}}
<form method="GET" class="card shadow-sm mb-3 fade-in-up" style="--delay:.20s">
  <div class="card-body row g-2 align-items-end">
    <div class="col-12 col-md-4">
      <label class="form-label">Cari Nama Santri</label>
      <input type="text" name="q" value="{{ $q }}" class="form-control" placeholder="Ketik nama santri…">
    </div>

    <div class="col-6 col-md-3">
      <label class="form-label">Keterangan</label>
      <select name="keterangan" class="form-select">
        @foreach($opsiKet as $val => $label)
          <option value="{{ $val }}" {{ $keterangan === $val ? 'selected' : '' }}>
            {{ $label }}
          </option>
        @endforeach
      </select>
    </div>

    <div class="col-6 col-md-2">
      <label class="form-label">Per Halaman</label>
      <select name="per_page" class="form-select">
        @foreach([10,25,50,100] as $n)
          <option value="{{ $n }}" {{ (int)$perPage === $n ? 'selected':'' }}>{{ $n }}</option>
        @endforeach
      </select>
    </div>

    <div class="col-12 col-md-3 d-flex gap-2">
      <button class="btn btn-dark rippleable flex-grow-1"><i class="fa fa-search me-1"></i> Terapkan</button>
      <a href="{{ route('pembayaran.index') }}" class="btn btn-outline-secondary rippleable">Reset</a>
    </div>
  </div>
</form>

{{-- Tabel --}}
<div class="card shadow-sm fade-in-up" style="--delay:.24s">
  <div class="table-responsive">
    <table class="table align-middle table-hover mb-0">
      <thead class="table-light">
        <tr>
          <th style="width:60px">#</th>
          <th>Nama Santri</th>
          <th style="width:220px">Keterangan</th>
          <th style="width:170px">Jumlah</th>
          <th style="width:160px">Tanggal</th>
          <th style="width:160px" class="text-end">Aksi</th>
        </tr>
      </thead>
      <tbody>
        @forelse($pembayaran as $row)
          <tr>
            <td>{{ $loop->iteration + ($pembayaran->currentPage()-1)*$pembayaran->perPage() }}</td>
            <td class="fw-semibold">{{ $row->nama_santri }}</td>
            <td>{{ $row->keterangan ?? '-' }}</td>
            <td>Rp {{ number_format($row->jumlah,0,',','.') }}</td>
            <td>{{ optional($row->created_at)->format('d M Y') }}</td>
            <td class="text-end">
              <a href="{{ route('pembayaran.edit', $row->id) }}" class="btn btn-warning btn-sm rippleable">
                <i class="fa fa-pen-to-square"></i> Edit
              </a>
              <button type="button" class="btn btn-danger btn-sm rippleable" data-bs-toggle="modal" data-bs-target="#del{{ $row->id }}">
                <i class="fa fa-trash"></i> Hapus
              </button>

              {{-- Modal hapus --}}
              <div class="modal fade" id="del{{ $row->id }}" tabindex="-1" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered">
                  <div class="modal-content">
                    <div class="modal-header">
                      <h5 class="modal-title">Konfirmasi Hapus</h5>
                      <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                      Hapus pembayaran <strong>{{ $row->nama_santri }}</strong> ({{ $row->keterangan ?? '-' }})?
                    </div>
                    <div class="modal-footer">
                      <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                      <form action="{{ route('pembayaran.destroy',$row->id) }}" method="POST">
                        @csrf @method('DELETE')
                        <button class="btn btn-danger">Ya, Hapus</button>
                      </form>
                    </div>
                  </div>
                </div>
              </div>
              {{-- /modal --}}
            </td>
          </tr>
        @empty
          <tr>
            <td colspan="6">
              <div class="text-center py-5 text-muted">
                <i class="fa-regular fa-face-smile-wink fa-2xl mb-2 d-block"></i>
                Belum ada data pembayaran.
              </div>
            </td>
          </tr>
        @endforelse
      </tbody>
    </table>
  </div>

  @if($pembayaran->hasPages())
    <div class="card-footer d-flex justify-content-between align-items-center">
      <small class="text-muted">Menampilkan {{ $pembayaran->firstItem() }}–{{ $pembayaran->lastItem() }} dari {{ $pembayaran->total() }} data</small>
      {{ $pembayaran->onEachSide(1)->links() }}
    </div>
  @endif
</div>

@endsection
