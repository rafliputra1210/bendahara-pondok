<?php

namespace App\Exports;

use Illuminate\Support\Collection;
use Illuminate\Support\Carbon;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class RiwayatExport implements FromCollection, WithHeadings, WithMapping, ShouldAutoSize
{
    /** @var \Illuminate\Support\Collection<int,object|array> */
    protected Collection $rows;

    public function __construct(Collection $rows)
    {
        // reset index agar penomoran No urut stabil
        $this->rows = $rows->values();
    }

    public function collection()
    {
        return $this->rows;
    }

    public function headings(): array
    {
        return ['No', 'Tanggal', 'Jenis', 'Keterangan', 'Jumlah', 'Sumber'];
    }

    public function map($row): array
    {
        static $i = 0;
        $i++;

        $tanggal = null;
        if (isset($row->tanggal)) {
            $tanggal = $row->tanggal instanceof \DateTimeInterface
                ? Carbon::instance($row->tanggal)->format('d-m-Y')
                : Carbon::parse($row->tanggal)->format('d-m-Y');
        }

        return [
            $i,
            $tanggal,
            isset($row->jenis) ? ucfirst((string) $row->jenis) : '',
            isset($row->keterangan) ? (string) $row->keterangan : '',
            (int) ($row->jumlah ?? 0), // biar Excel format sendiri
            isset($row->sumber) ? (string) $row->sumber : '',
        ];
    }
}
