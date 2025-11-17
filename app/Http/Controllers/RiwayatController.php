<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Pembayaran;
use App\Models\Transaksi;
use App\Exports\RiwayatExport;               // <- pakai class export
use Maatwebsite\Excel\Facades\Excel;         // <- facade excel
use Barryvdh\DomPDF\Facade\Pdf;

class RiwayatController extends Controller
{
    public function index(Request $r)
    {
        $jenis   = $r->get('jenis', '');
        $q       = trim($r->get('q', ''));
        $dari    = $r->get('dari');
        $sampai  = $r->get('sampai');
        $perPage = (int) $r->get('per_page', 15);

        // pemasukan dari Pembayaran (Setoran)
        $pemb = Pembayaran::query()->selectRaw("
            id,
            created_at as tanggal,
            CONCAT('Setoran - ', COALESCE(keterangan,''),' (', nama_santri, ')') as keterangan,
            jumlah,
            'pemasukan' as jenis,
            'Pembayaran' as sumber
        ");

        // transaksi (pemasukan/pengeluaran)
        $trans = Transaksi::query()->selectRaw("
            id,
            COALESCE(tanggal, created_at) as tanggal,
            COALESCE(keterangan,'') as keterangan,
            jumlah,
            LOWER(jenis) as jenis,
            'Transaksi' as sumber
        ");

        $riwayat = DB::query()->fromSub($pemb->unionAll($trans), 'x')
            ->when($jenis !== '',  fn($q2) => $q2->where('jenis', $jenis))
            ->when($q !== '',      fn($q2) => $q2->where('keterangan', 'like', "%{$q}%"))
            ->when($dari,          fn($q2) => $q2->whereDate('tanggal', '>=', $dari))
            ->when($sampai,        fn($q2) => $q2->whereDate('tanggal', '<=', $sampai))
            ->orderByDesc('tanggal')
            ->paginate($perPage)
            ->withQueryString();

        $totalMasuk  = (float) Pembayaran::sum('jumlah')
                      + (float) Transaksi::where('jenis', 'pemasukan')->sum('jumlah');
        $totalKeluar = (float) Transaksi::where('jenis', 'pengeluaran')->sum('jumlah');
        $saldo       = $totalMasuk - $totalKeluar;

        return view('riwayat.index', compact(
            'riwayat','totalMasuk','totalKeluar','saldo','q','jenis','dari','sampai','perPage'
        ));
    }

    public function exportExcel(Request $r)
    {
        $jenis  = $r->get('jenis', '');
        $q      = trim($r->get('q', ''));
        $dari   = $r->get('dari');
        $sampai = $r->get('sampai');

        $pemb = Pembayaran::query()->selectRaw("
            id,
            created_at as tanggal,
            CONCAT('Setoran - ', COALESCE(keterangan,''),' (', nama_santri, ')') as keterangan,
            jumlah,
            'pemasukan' as jenis,
            'Pembayaran' as sumber
        ");

        $trans = Transaksi::query()->selectRaw("
            id,
            COALESCE(tanggal, created_at) as tanggal,
            COALESCE(keterangan,'') as keterangan,
            jumlah,
            LOWER(jenis) as jenis,
            'Transaksi' as sumber
        ");

        $rows = DB::query()->fromSub($pemb->unionAll($trans), 'x')
            ->when($jenis !== '',  fn($q2) => $q2->where('jenis', $jenis))
            ->when($q !== '',      fn($q2) => $q2->where('keterangan', 'like', "%{$q}%"))
            ->when($dari,          fn($q2) => $q2->whereDate('tanggal', '>=', $dari))
            ->when($sampai,        fn($q2) => $q2->whereDate('tanggal', '<=', $sampai))
            ->orderByDesc('tanggal')
            ->get();

        return Excel::download(new RiwayatExport($rows), 'riwayat-'.now()->format('Ymd_His').'.xlsx');
    }
}
