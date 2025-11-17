@extends('layouts.app')

@section('content')
<h3 class="mb-3">Tambah Transaksi (Pengeluaran)</h3>

<div class="card">
  <div class="card-body">
    <form action="{{ route('transaksi.store') }}" method="POST" class="row g-3">
      @csrf

      {{-- jenis dipaksa pengeluaran --}}
      <input type="hidden" name="jenis" value="pengeluaran">

      <div class="col-12">
        <label class="form-label">Keterangan</label>
        <input type="text" name="keterangan" value="{{ old('keterangan') }}" class="form-control"
               placeholder="cth: beli ATK, pulsa, listrik" required>
        @error('keterangan') <small class="text-danger">{{ $message }}</small> @enderror
      </div>

      <div class="col-12 col-md-6">
        <label class="form-label">Jumlah (Rp)</label>
        <input type="number" name="jumlah" value="{{ old('jumlah') }}" class="form-control" min="0" step="1" required>
        @error('jumlah') <small class="text-danger">{{ $message }}</small> @enderror
      </div>

      <div class="col-12 col-md-6">
        <label class="form-label">Tanggal</label>
        <input type="date" name="tanggal" value="{{ old('tanggal') }}" class="form-control">
        @error('tanggal') <small class="text-danger">{{ $message }}</small> @enderror
      </div>

      <div class="col-12 d-flex gap-2">
        <button class="btn btn-success">Simpan</button>
        <button class="btn btn-primary" name="to_dashboard" value="1">Simpan & Ke Dashboard</button>
        <a href="{{ route('dashboard') }}" class="btn btn-secondary">Kembali ke Dashboard</a>
      </div>
    </form>
  </div>
</div>
@endsection
