@extends('layouts.admin')

@section('title', 'Tambah Pembayaran')

@section('content')
    {{-- ICON --}}
    <link rel="stylesheet"
          href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">

    <style>
        .page-card {
            background: #ffffff;
            border-radius: 16px;
            box-shadow: 0 10px 30px rgba(15, 23, 42, 0.06);
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
            font-size: 13px;
            font-weight: 500;
            border: 1px solid #e5e7eb;
            background: #fff;
            color: #374151;
            text-decoration: none;
            transition: all .2s ease;
        }

        .btn-back:hover {
            background: #f3f4f6;
            border-color: #d1d5db;
        }

        .form-card {
            margin-top: 12px;
            border-radius: 12px;
            background: #f9fafb;
            padding: 20px 20px 16px;
        }

        .form-group {
            margin-bottom: 16px;
        }

        .form-label {
            font-size: 14px;
            font-weight: 500;
            color: #374151;
            margin-bottom: 6px;
        }

        .form-control,
        .form-select {
            border-radius: 10px;
            border: 1px solid #d1d5db;
            padding: 10px 12px;
            font-size: 14px;
            width: 100%;
            outline: none;
            transition: border-color .2s ease, box-shadow .2s ease;
        }

        .form-control:focus,
        .form-select:focus {
            border-color: #4f46e5;
            box-shadow: 0 0 0 3px rgba(79, 70, 229, 0.15);
        }

        .text-danger {
            font-size: 12px;
            color: #dc2626;
            margin-top: 3px;
        }

        .form-actions {
            margin-top: 10px;
            display: flex;
            justify-content: flex-end;
            gap: 10px;
        }

        .btn-secondary {
            padding: 9px 16px;
            border-radius: 999px;
            border: 1px solid #d1d5db;
            background: #ffffff;
            color: #374151;
            font-size: 14px;
            font-weight: 500;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 6px;
            transition: all .2s ease;
        }

        .btn-secondary:hover {
            background: #f3f4f6;
        }

        .btn-primary {
            padding: 9px 20px;
            border-radius: 999px;
            border: none;
            background: #10b981;
            color: #ffffff;
            font-size: 14px;
            font-weight: 600;
            display: inline-flex;
            align-items: center;
            gap: 6px;
            cursor: pointer;
            box-shadow: 0 8px 15px rgba(16, 185, 129, 0.35);
            transition: all .2s ease;
        }

        .btn-primary:hover {
            background: #059669;
            box-shadow: 0 10px 18px rgba(16, 185, 129, 0.45);
            transform: translateY(-1px);
        }
    </style>

    <div class="page-card">
        {{-- HEADER --}}
        <div class="page-header">
            <div>
                <div class="page-header-title">
                    <i class="bi bi-wallet2 me-2"></i> Tambah Pembayaran
                </div>
                <div class="page-header-sub">
                    Input setoran / pembayaran santri baru.
                </div>
            </div>

            <a href="{{ route('pembayaran.index') }}" class="btn-back">
                <i class="bi bi-arrow-left"></i>
                <span>Kembali</span>
            </a>
        </div>

        {{-- FORM --}}
        <div class="form-card">
            <form action="{{ route('pembayaran.store') }}" method="POST">
                @csrf

                {{-- Nama Santri --}}
                <div class="form-group">
    <label>Nama Santri</label>
    <select name="siswa_id" class="form-control" required>
        <option value="">-- Pilih Santri --</option>
        @foreach($siswa as $s)
            <option value="{{ $s->id }}">
                {{ $s->nama_lengkap }} ({{ $s->kelas }})
            </option>
        @endforeach
    </select>
</div>
                {{-- Keterangan --}}
                <div class="form-group">
                    <label class="form-label">
                        Keterangan Setoran
                    </label>
                    <select name="keterangan" class="form-select">
                        <option value="">-- Pilih keterangan --</option>
                        <option value="Syahriyyah Mds" {{ old('keterangan') == 'Syahriyyah Mds' ? 'selected' : '' }}>Syahriyyah Mds</option>
                        <option value="Syahriyyah Pondok" {{ old('keterangan') == 'Syahriyyah Pondok' ? 'selected' : '' }}>Syahriyyah Pondok</option>
                        <option value="SPP" {{ old('keterangan') == 'SPP' ? 'selected' : '' }}>SPP</option>
                        <option value="Lainnya" {{ old('keterangan') == 'Lainnya' ? 'selected' : '' }}>Lainnya</option>
                    </select>
                    @error('keterangan')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>

                {{-- Jumlah --}}
                <div class="form-group">
                    <label class="form-label">
                        Jumlah (Rp)
                    </label>
                    <input type="number"
                           name="jumlah"
                           value="{{ old('jumlah') }}"
                           class="form-control"
                           min="0"
                           placeholder="Contoh: 100000">
                    @error('jumlah')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>

                <p style="font-size: 12px; color:#6b7280; margin-top:6px;">
                    <i class="bi bi-info-circle me-1"></i>
                    Semua data di menu ini otomatis disimpan sebagai <strong>setoran</strong>.
                </p>
                {{-- Status Pembayaran --}}
        <div class="form-group">
                    <label class="form-label">Status Pembayaran</label>
                        <select name="status" class="form-select">
                        <option value="Belum Lunas">Belum Lunas</option>
                    <option value="Lunas">Lunas</option>
            </select>
        </div>

                {{-- BUTTONS --}}
                <div class="form-actions">
                    <a href="{{ route('pembayaran.index') }}" class="btn-secondary">
                        <i class="bi bi-x-circle"></i> Batal
                    </a>
                    <button type="submit" class="btn-primary">
                        <i class="bi bi-save"></i> Simpan
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection
