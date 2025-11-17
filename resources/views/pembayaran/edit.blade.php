@extends('layouts.app')

@section('content')
@php
  // default agar tidak undefined kalau controller lupa kirim
  $totalSetoran     = $totalSetoran     ?? 0;
  $totalPengeluaran = $totalPengeluaran ?? 0;
  $totalSaldo       = $totalSaldo       ?? ($totalSetoran - $totalPengeluaran);
@endphp

<div class="d-flex justify-content-between align-items-center mb-3">
  <h3 class="fw-bold m-0"><i class="fa-solid fa-pen-to-square me-2"></i>Edit Pembayaran</h3>
  <a href="{{ route('pembayaran.index') }}" class="btn btn-outline-secondary">Kembali</a>
</div>

{{-- (Opsional) Kartu ringkasan; aman karena ada default di atas --}}
<div class="row g-3 mb-3">
  <div class="col-12 col-md-4">
    <div class="card stat-mini bg-primary text-white">
      <div class="card-body d-flex justify-content-between align-items-center">
        <div>
          <div class="label">Total Setoran</div>
          <div class="value">Rp {{ number_format($totalSetoran,0,',','.') }}</div>
        </div>
        <i class="fa-solid fa-wallet fs-4 opacity-75"></i>
      </div>
    </div>
  </div>
  <div class="col-12 col-md-4">
    <div class="card stat-mini bg-danger text-white">
      <div class="card-body d-flex justify-content-between align-items-center">
        <div>
          <div class="label">Total Pengeluaran</div>
          <div class="value">Rp {{ number_format($totalPengeluaran,0,',','.') }}</div>
        </div>
        <i class="fa-solid fa-chart-line fs-4 opacity-75"></i>
      </div>
    </div>
  </div>
  <div class="col-12 col-md-4">
    <div class="card stat-mini bg-success text-white">
      <div class="card-body d-flex justify-content-between align-items-center">
        <div>
          <div class="label">Total Saldo</div>
          <div class="value">Rp {{ number_format($totalSaldo,0,',','.') }}</div>
        </div>
        <i class="fa-solid fa-coins fs-4 opacity-75"></i>
      </div>
    </div>
  </div>
</div>

<div class="card shadow-sm">
  <div class="card-body">
    <form action="{{ route('pembayaran.update', $pembayaran->id) }}" method="POST" class="row g-3">
      @csrf
      @method('PUT')

      <div class="col-12">
        <label class="form-label">Nama Santri</label>
        <input type="text" name="nama_santri"
               value="{{ old('nama_santri', $pembayaran->nama_santri) }}"
               class="form-control" required>
        @error('nama_santri') <small class="text-danger">{{ $message }}</small> @enderror
      </div>

      <div class="col-12 col-md-6">
        <label class="form-label">Keterangan Setoran</label>
        @php
          $opsiKet = ['Syahriyyah Pondok', 'Syahriyyah Mds', 'Loker'];
          $ketNow  = old('keterangan', $pembayaran->keterangan);
        @endphp
        <select name="keterangan" class="form-select" required>
          <option value="" disabled {{ $ketNow ? '' : 'selected' }}>-- Pilih --</option>
          @foreach($opsiKet as $opt)
            <option value="{{ $opt }}" {{ $ketNow === $opt ? 'selected':'' }}>{{ $opt }}</option>
          @endforeach
        </select>
        <small class="text-muted d-block mt-1">Jenis pembayaran otomatis <b>Setoran</b>.</small>
        @error('keterangan') <small class="text-danger">{{ $message }}</small> @enderror
      </div>

      <div class="col-12 col-md-6">
        <label class="form-label">Jumlah (Rp)</label>
        <input type="text" id="jumlah_display" class="form-control" inputmode="numeric"
               autocomplete="off" placeholder="cth: 150.000">
        <input type="hidden" name="jumlah" id="jumlah"
               value="{{ old('jumlah', (int)$pembayaran->jumlah) }}">
        @error('jumlah') <small class="text-danger">{{ $message }}</small> @enderror
      </div>

      <div class="col-12 d-flex gap-2">
        <button class="btn btn-primary"><i class="fa fa-save me-1"></i> Simpan Perubahan</button>
        <a href="{{ route('pembayaran.index') }}" class="btn btn-secondary">Batal</a>
      </div>
    </form>
  </div>
</div>

{{-- Formatter rupiah --}}
<script>
(function(){
  const disp = document.getElementById('jumlah_display');
  const raw  = document.getElementById('jumlah');
  const fmt  = n => new Intl.NumberFormat('id-ID').format(n);

  if(raw.value){ disp.value = fmt(Number(raw.value||0)); }
  disp.addEventListener('input', () => {
    const digits = disp.value.replace(/[^\d]/g,'');
    raw.value = digits ? String(parseInt(digits,10)) : '';
    disp.value = digits ? fmt(parseInt(digits,10)) : '';
  });
})();
</script>
@endsection
