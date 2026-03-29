@extends('layouts.admin')

@section('title', 'Edit Data Pembayaran')

@section('content')
<link rel="stylesheet"
      href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">

<style>
    .page-wrapper {
        max-width: 1100px;
        margin: 0 auto;
    }

    .page-card {
        background: #ffffff;
        border-radius: 16px;
        box-shadow: 0 10px 30px rgba(15, 23, 42, 0.08);
        padding: 28px;
    }

    .page-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 20px;
    }

    .page-header-title {
        font-size: 22px;
        font-weight: 700;
        color: #111827;
    }

    .page-header-sub {
        font-size: 14px;
        color: #6b7280;
    }

    .btn-back {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        padding: 8px 14px;
        border-radius: 999px;
        border: 1px solid #e5e7eb;
        background: #ffffff;
        font-size: 13px;
        color: #374151;
        text-decoration: none;
        transition: .2s;
    }

    .btn-back:hover {
        background: #f3f4f6;
    }

    .form-grid {
        display: grid;
        grid-template-columns: repeat(2, minmax(0, 1fr));
        gap: 18px 24px;
        margin-top: 10px;
    }

    @media (max-width: 768px) {
        .form-grid {
            grid-template-columns: 1fr;
        }
    }

    .form-group {
        display: flex;
        flex-direction: column;
        gap: 6px;
    }

    .form-label {
        font-size: 14px;
        font-weight: 500;
        color: #374151;
    }

    .form-control,
    .form-select {
        border-radius: 10px;
        border: 1px solid #d1d5db;
        padding: 10px 12px;
        font-size: 14px;
        outline: none;
        transition: border-color .2s, box-shadow .2s;
        width: 100%;
    }

    .form-control:focus,
    .form-select:focus {
        border-color: #4f46e5;
        box-shadow: 0 0 0 3px rgba(79, 70, 229, 0.2);
    }

    .text-danger {
        color: #dc2626;
        font-size: 12px;
    }

    .btn-save {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        margin-top: 22px;
        padding: 10px 18px;
        border-radius: 999px;
        border: none;
        background: #10b981;
        color: #ffffff;
        font-size: 14px;
        font-weight: 600;
        cursor: pointer;
        box-shadow: 0 10px 20px rgba(16, 185, 129, 0.35);
        transition: .2s;
    }

    .btn-save:hover {
        background: #059669;
    }
</style>

<div class="page-wrapper">
    <div class="page-card">
        {{-- HEADER --}}
        <div class="page-header">
            <div>
                <div class="page-header-title">
                    <i class="bi bi-pencil-square me-2"></i>
                    Edit Pembayaran
                </div>
                <div class="page-header-sub">
                    Perbarui data pembayaran santri.
                </div>
            </div>

            <a href="{{ route('pembayaran.index') }}" class="btn-back">
                <i class="bi bi-arrow-left"></i> Kembali ke daftar
            </a>
        </div>

        {{-- FORM EDIT --}}
        <form action="{{ route('pembayaran.update', $pembayaran->id) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="form-grid">
                {{-- Nama Santri --}}
                <div class="form-group">
                    <label class="form-label">Nama Santri</label>
                    <select name="siswa_id" class="form-select" required>
                        @foreach ($siswa as $s)
                            <option value="{{ $s->id }}"
                                {{ old('siswa_id', $pembayaran->siswa_id) == $s->id ? 'selected' : '' }}>
                                {{ $s->nama_lengkap }} ({{ $s->kelas }})
                            </option>
                        @endforeach
                    </select>
                    @error('siswa_id')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>

                {{-- Keterangan --}}
                <div class="form-group">
                    <label class="form-label">Keterangan Setoran</label>
                    <select name="keterangan" class="form-select">
                        <option value="">-- Pilih keterangan --</option>
                        @foreach (['Syahriyyah Mds','Syahriyyah Pondok','SPP','Lainnya'] as $ket)
                            <option value="{{ $ket }}"
                                {{ old('keterangan', $pembayaran->keterangan) == $ket ? 'selected' : '' }}>
                                {{ $ket }}
                            </option>
                        @endforeach
                    </select>
                    @error('keterangan')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>

                {{-- Status --}}
                <div class="form-group">
                    <label class="form-label">Status Pembayaran</label>
                    <select name="status" class="form-select">
                        @foreach (['Belum Lunas','Lunas'] as $st)
                            <option value="{{ $st }}"
                                {{ old('status', $pembayaran->status) == $st ? 'selected' : '' }}>
                                {{ $st }}
                            </option>
                        @endforeach
                    </select>
                    @error('status')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>

                {{-- Jumlah --}}
                <div class="form-group">
                    <label class="form-label">Jumlah (Rp)</label>
                    <input type="number" name="jumlah" min="0"
                           class="form-control"
                           value="{{ old('jumlah', $pembayaran->jumlah) }}" required>
                    @error('jumlah')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
            </div>

            <button type="submit" class="btn-save">
                <i class="bi bi-check-circle"></i> Simpan Perubahan
            </button>
        </form>
    </div>
</div>
@endsection
