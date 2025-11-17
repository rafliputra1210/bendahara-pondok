@extends('layouts.app')

@section('content')
@if(session('success'))
  <div class="alert alert-success">{{ session('success') }}</div>
@endif
@if(session('error'))
  <div class="alert alert-danger">{{ session('error') }}</div>
@endif

<div class="d-flex justify-content-between align-items-center mb-3">
  <h3>Data Keuangan Pondok</h3>
  <a href="{{ route('transaksi.create') }}" class="btn btn-primary">Tambah Transaksi</a>
</div>

<table class="table">
  <thead>
    <tr>
      <th>#</th>
      <th>Keterangan</th>
      <th>Jumlah</th>
      <th>Tanggal</th>
      <th>Aksi</th>
    </tr>
  </thead>
  <tbody>
    @forelse($items as $row)
      <tr>
        <td>{{ $loop->iteration + ($items->currentPage()-1)*$items->perPage() }}</td>
        <td>{{ $row->keterangan }}</td>
        <td>Rp {{ number_format($row->jumlah,0,',','.') }}</td>
        <td>{{ \Carbon\Carbon::parse($row->tanggal)->format('d M Y') }}</td>
        <td class="d-flex gap-2">
          <a href="{{ route('transaksi.edit', $row->id) }}" class="btn btn-warning btn-sm">Edit</a>
          <form action="{{ route('transaksi.destroy', $row->id) }}" method="POST" class="d-inline">
            @csrf @method('DELETE')
            <button class="btn btn-danger btn-sm"
              onclick="return confirm('Yakin hapus pengeluaran ini?')">Hapus</button>
          </form>
        </td>
      </tr>
    @empty
      <tr><td colspan="5" class="text-center text-muted">Belum ada data.</td></tr>
    @endforelse
  </tbody>
</table>

{{ $items->links() }}
@endsection
