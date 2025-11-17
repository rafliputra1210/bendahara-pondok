@extends('layouts.app')

@section('content')
<h3 class="mb-3">Edit Transaksi (Pengeluaran)</h3>

<div class="card">
  <div class="card-body">
    <form action="{{ route('transaksi.update', $transaksi->id) }}" method="POST" class="row g-3">
      @csrf
      @method('PUT')

      <input type="hidden" name="jenis" value="pengeluaran">

      <div class="col-12">
        <label class="form-label">Keterangan</label>
        <input type="text" name="keterangan" value="{{ old('keterangan',$transaksi->keterangan) }}"
               class="form-control" required>
        @error('keterangan') <small class="text-danger">{{ $message }}</small> @enderror
      </div>

      <div class="col-12 col-md-6">
        <label class="form-label">Jumlah (Rp)</label>
        <input type="number" name="jumlah" value="{{ old('jumlah',$transaksi->jumlah) }}"
               class="form-control" min="0" step="1" required>
        @error('jumlah') <small class="text-danger">{{ $message }}</small> @enderror
      </div>

      <div class="col-12 col-md-6">
        <label class="form-label">Tanggal</label>
        <input type="date" name="tanggal"
               value="{{ old('tanggal', optional($transaksi->tanggal)->format('Y-m-d')) }}"
               class="form-control">
        @error('tanggal') <small class="text-danger">{{ $message }}</small> @enderror
      </div>

      <div class="col-12 d-flex gap-2">
        <button class="btn btn-primary">Simpan Perubahan</button>
        <a href="{{ route('transaksi.index') }}" class="btn btn-secondary">Batal</a>
      </div>
    </form>
  </div>
</div>
@endsection
