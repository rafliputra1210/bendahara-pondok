@extends('layouts.admin')

@section('title', 'Tambah Siswa')

@section('content')
    <link rel="stylesheet"
          href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">

    <style>
        .page-card {
            background: #ffffff;
            border-radius: 18px;
            box-shadow: 0 16px 40px rgba(15, 23, 42, 0.10);
            padding: 26px;
        }

        .page-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 18px;
        }

        .page-header-title {
            font-size: 22px;
            font-weight: 700;
            color: #0f172a;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .page-header-title i {
            font-size: 22px;
            color: #4f46e5;
        }

        .page-header-sub {
            font-size: 14px;
            color: #64748b;
        }

        .btn-back {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 8px 16px;
            border-radius: 999px;
            border: 1px solid #e5e7eb;
            background: #ffffff;
            color: #374151;
            font-size: 13px;
            text-decoration: none;
            transition: .2s;
        }

        .btn-back:hover {
            background: #f3f4f6;
        }

        .form-card {
            margin-top: 10px;
            border-radius: 14px;
            background: #f9fafb;
            padding: 20px 18px 18px;
        }

        .form-group {
            margin-bottom: 14px;
        }

        .form-label {
            font-size: 14px;
            font-weight: 500;
            color: #374151;
            margin-bottom: 5px;
            display: block;
        }

        .form-control {
            border-radius: 10px;
            border: 1px solid #d1d5db;
            padding: 10px 12px;
            font-size: 14px;
            width: 100%;
            outline: none;
            transition: border-color .2s, box-shadow .2s;
        }

        .form-control:focus {
            border-color: #4f46e5;
            box-shadow: 0 0 0 3px rgba(79, 70, 229, 0.15);
        }

        .text-danger {
            font-size: 12px;
            color: #dc2626;
            margin-top: 2px;
        }

        .form-actions {
            margin-top: 4px;
            display: flex;
            justify-content: flex-end;
            gap: 10px;
        }

        .btn-secondary {
            padding: 9px 18px;
            border-radius: 999px;
            border: 1px solid #d1d5db;
            background: #ffffff;
            color: #374151;
            font-size: 14px;
            display: inline-flex;
            align-items: center;
            gap: 6px;
            text-decoration: none;
        }

        .btn-secondary:hover {
            background: #f3f4f6;
        }

        .btn-primary {
            padding: 9px 22px;
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
            box-shadow: 0 10px 20px rgba(16, 185, 129, 0.35);
            transition: .2s;
        }

        .btn-primary:hover {
            background: #059669;
            transform: translateY(-1px);
        }
    </style>

    <div class="page-card">
        <div class="page-header">
            <div>
                <div class="page-header-title">
                    <i class="bi bi-person-plus"></i> Tambah Siswa
                </div>
                <div class="page-header-sub">
                    Tambahkan siswa baru yang akan digunakan pada data pembayaran.
                </div>
            </div>

            <a href="{{ route('siswa.index') }}" class="btn-back">
                <i class="bi bi-arrow-left"></i> Kembali
            </a>
        </div>

        <div class="form-card">
            <form action="{{ route('siswa.store') }}" method="POST">
                @csrf

                <div class="form-group">
                    <label class="form-label">Nama Lengkap</label>
                    <input type="text" name="nama_lengkap"
                           class="form-control"
                           value="{{ old('nama_lengkap') }}"
                           required>
                    @error('nama_lengkap')<div class="text-danger">{{ $message }}</div>@enderror
                </div>
                {{-- Jenis Kelamin --}}
        <div class="mb-3">
            <label class="form-label">Jenis Kelamin</label>
                <select name="jenis_kelamin" class="form-control" required>
                        <option value="">-- Pilih Jenis Kelamin --</option>
                        <option value="Laki-laki"  {{ old('jenis_kelamin') == 'Laki-laki' ? 'selected' : '' }}>Laki-laki</option>
                        <option value="Perempuan"  {{ old('jenis_kelamin') == 'Perempuan' ? 'selected' : '' }}>Perempuan</option>
                </select>
                @error('jenis_kelamin')
            <div class="text-danger small">{{ $message }}</div>
                @enderror
            </div>

                <div class="form-group">
                    <label class="form-label">Alamat</label>
                    <input type="text" name="alamat"
                           class="form-control"
                           value="{{ old('alamat') }}"
                           required>
                    @error('alamat')<div class="text-danger">{{ $message }}</div>@enderror
                </div>

                <div class="form-group">
                    <label class="form-label">Kelas</label>
                    <input type="text" name="kelas"
                           class="form-control"
                           value="{{ old('kelas') }}"
                           placeholder="Contoh: 7A / 10 / XII IPA 1"
                           required>
                    @error('kelas')<div class="text-danger">{{ $message }}</div>@enderror
                </div>

                <div class="form-actions">
                    <a href="{{ route('siswa.index') }}" class="btn-secondary">
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
