@extends('layouts.app')
@section('title', 'Dashboard')

@section('content')
  <h2 class="mb-4 fw-bold fade-in-up" style="--delay:.00s">Dashboard Administrator</h2>

  <div class="row g-3 row-cols-1 row-cols-md-2 row-cols-xl-4">
    <div class="col">
      <div class="card stat-card bg-warning text-dark h-100 shadow-sm fade-in-up" style="--delay:.04s">
        <div class="card-body d-flex justify-content-between align-items-center">
          <div>
            <div class="label">Siswa Aktif</div>
            <div class="value">{{ $data['siswa_aktif'] }}</div>
          </div>
          <i class="fa fa-users"></i>
        </div>
      </div>
    </div>

    <div class="col">
      <div class="card stat-card bg-primary text-white h-100 shadow-sm fade-in-up" style="--delay:.08s">
        <div class="card-body d-flex justify-content-between align-items-center">
          <div>
            <div class="label">Total Setoran</div>
            <div class="value">Rp {{ number_format($data['total_setoran'],0,',','.') }}</div>
          </div>
          <i class="fa fa-wallet"></i>
        </div>
      </div>
    </div>

    <div class="col">
      <div class="card stat-card bg-danger text-white h-100 shadow-sm fade-in-up" style="--delay:.12s">
        <div class="card-body d-flex justify-content-between align-items-center">
          <div>
            <div class="label">Total Pengeluaran</div>
            <div class="value">Rp {{ number_format($data['total_pengeluaran'],0,',','.') }}</div>
          </div>
          <i class="fa fa-chart-line"></i>
        </div>
      </div>
    </div>

    <div class="col">
      <div class="card stat-card bg-success text-white h-100 shadow-sm fade-in-up" style="--delay:.16s">
        <div class="card-body d-flex justify-content-between align-items-center">
          <div>
            <div class="label">Total Saldo</div>
            <div class="value">Rp {{ number_format($data['total_saldo'],0,',','.') }}</div>
          </div>
          <i class="fa fa-coins"></i>
        </div>
      </div>
    </div>
  </div>

  <div class="card mt-4 shadow-sm fade-in-up" style="--delay:.22s">
    <div class="card-header fw-semibold">📅 Informasi Sekolah</div>
    <div class="card-body p-0">
      <div class="table-responsive">
        <table class="table table-striped mb-0">
          <thead class="table-light">
            <tr><th>No</th><th>Tanggal</th><th>Informasi</th></tr>
          </thead>
          <tbody>
            <tr><td>1</td><td>2025-11-04</td><td>Saldo Awal Tahun Ajaran Baru</td></tr>
            <tr><td>2</td><td>2025-11-10</td><td>Setoran Bulanan Santri</td></tr>
          </tbody>
        </table>
      </div>
    </div>
  </div>
@endsection
