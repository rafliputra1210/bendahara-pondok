@extends('layouts.admin')

@section('title','Import Data Siswa')

@section('content')
<div class="page-card">
    <h1>Import Data Siswa</h1>
    <p>Upload file Excel (.xlsx / .xls / .csv) dengan kolom:
        <strong>nama_lengkap, alamat, kelas</strong>
    </p>

    {{-- Tampilkan error umum --}}
    @if ($errors->any())
        <div class="alert alert-danger">
            {{ $errors->first() }}
        </div>
    @endif

    <form action="{{ route('siswa.import') }}"
          method="POST"
          enctype="multipart/form-data">   {{-- <- WAJIB ADA --}}
        @csrf

        <div class="mb-3">
            <label class="form-label">File Excel</label>
            <input type="file"
                   name="file"                 {{-- <- HARUS "file" --}}
                   class="form-control"
                   required>
            @error('file')
                <div class="text-danger small">{{ $message }}</div>
            @enderror
        </div>

        <button type="submit" class="btn btn-success">Import</button>
        <a href="{{ route('siswa.index') }}" class="btn btn-secondary">Kembali</a>
    </form>
</div>
@endsection
