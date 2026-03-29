<?php

namespace App\Imports;

use App\Models\Siswa;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;

class SiswaImport implements ToModel, WithHeadingRow, WithValidation
{
    /**
     * Mapping tiap baris Excel ke model Siswa.
     *
     * Pastikan header di Excel: nama_lengkap | alamat | kelas
     */
    public function model(array $row)
    {
        return new Siswa([
            'nama_lengkap' => $row['nama_lengkap'] ?? '',
            'alamat'       => $row['alamat']       ?? null,
            'kelas'        => $row['kelas']        ?? null,
        ]);
    }

    /**
     * Validasi per-row.
     */
    public function rules(): array
    {
        return [
            '*.nama_lengkap' => ['required', 'string', 'max:255'],
            '*.alamat'       => ['nullable', 'string', 'max:255'],
            '*.kelas'        => ['nullable', 'string', 'max:50'],
        ];
    }
}
