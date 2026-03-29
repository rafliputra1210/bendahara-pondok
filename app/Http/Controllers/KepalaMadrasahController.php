<?php

namespace App\Http\Controllers;

use App\Models\Pembayaran;
use App\Models\Transaksi;

class KepalaMadrasahController extends Controller
{
    /**
     * DASHBOARD KEPALA MADRASAH (READ ONLY)
     */
    public function index()
    {
        // Data sama seperti dashboard admin
        $totalSetoran = Pembayaran::sum('jumlah');
        $totalPengeluaran = Transaksi::where('jenis', 'pengeluaran')->sum('jumlah');
        $totalPemasukanTransaksi = Transaksi::where('jenis', 'pemasukan')->sum('jumlah');

        $totalPemasukan = $totalSetoran + $totalPemasukanTransaksi;
        $saldo = $totalPemasukan - $totalPengeluaran;

        $transaksiTerbaru = Transaksi::orderByDesc('tanggal')
            ->limit(5)
            ->get();

        $pembayaranTerbaru = Pembayaran::orderByDesc('created_at')
            ->limit(5)
            ->get();

        return view('kepala.dashboard', compact(
            'totalSetoran',
            'totalPengeluaran',
            'totalPemasukan',
            'saldo',
            'transaksiTerbaru',
            'pembayaranTerbaru'
        ));
    }
}
