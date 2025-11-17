@extends('layouts.app')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-3 fade-in-up" style="--delay:.00s">
  <h3 class="fw-bold m-0"><i class="fa-solid fa-plus me-2"></i>Tambah Pembayaran</h3>
  <a href="{{ route('pembayaran.index') }}" class="btn btn-outline-secondary rippleable">Kembali</a>
</div>

<div class="card shadow-sm fade-in-up" style="--delay:.04s">
  <div class="card-body">
    <form action="{{ route('pembayaran.store') }}" method="POST" class="row g-3">
      @csrf

      <div class="col-12">
        <label class="form-label">Nama Santri</label>
        <input type="text" name="nama_santri" value="{{ old('nama_santri') }}" class="form-control" placeholder="cth: Ahmad Zaky" required>
        @error('nama_santri') <small class="text-danger">{{ $message }}</small> @enderror
      </div>

      <div class="col-12 col-md-6">
        <label class="form-label">Keterangan Setoran</label>
        <select name="keterangan" class="form-select" required>
        <option value="">-- Pilih --</option>
        <option value="Syahriyyah Pondok" {{ old('keterangan')=='Syahriyyah Pondok'?'selected':'' }}>Syahriyyah Pondok</option>
        <option value="Syahriyyah Mds"    {{ old('keterangan')=='Syahriyyah Mds'?'selected':'' }}>Syahriyyah Mds</option>
        <option value="Loker"             {{ old('keterangan')=='Loker'?'selected':'' }}>Loker</option>
      </select>
      <small class="text-muted d-block mt-1">Jenis pembayaran otomatis <b>Setoran</b>.</small>
      </div>

      <div class="col-12 col-md-6">
        <label class="form-label">Jumlah (Rp)</label>
        <input type="text" id="jumlah_display" class="form-control" inputmode="numeric" placeholder="cth: 150.000" autocomplete="off">
        <input type="hidden" name="jumlah" id="jumlah" value="{{ old('jumlah') }}">
        @error('jumlah') <small class="text-danger">{{ $message }}</small> @enderror
      </div>

      <div class="col-12 d-flex gap-2">
        <button class="btn btn-success rippleable"><i class="fa fa-save me-1"></i> Simpan</button>
        <a href="{{ route('pembayaran.index') }}" class="btn btn-secondary rippleable">Batal</a>
      </div>
    </form>
  </div>
</div>

{{-- Script format Rupiah --}}
<script>
(function(){
  const disp = document.getElementById('jumlah_display');
  const raw  = document.getElementById('jumlah');

  const fmt = n => new Intl.NumberFormat('id-ID').format(n);

  // inisialisasi dari old('jumlah') bila ada
  if(raw.value){
    disp.value = fmt(Number(raw.value||0));
  }

  disp.addEventListener('input', () => {
    const digits = disp.value.replace(/[^\d]/g,'');
    raw.value = digits ? String(parseInt(digits,10)) : '';
    disp.value = digits ? fmt(parseInt(digits,10)) : '';
  });
})();
</script>
@endsection
