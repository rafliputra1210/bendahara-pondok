<?php

namespace App\Http\Controllers;

use App\Models\Pembayaran;

class RiwayatController extends Controller
{
    public function index()
{
    // Ambil semua riwayat transaksi
    $riwayat = Pembayaran::orderByRaw('COALESCE(tanggal, created_at) DESC')->get();

    // Total pemasukan (misal jenis = setoran / pemasukan)
    $totalMasuk = Pembayaran::where('jenis', 'setoran')->sum('jumlah');

    // Total pengeluaran
    $totalKeluar = Pembayaran::where('jenis', 'pengeluaran')->sum('jumlah');

    return view('riwayat.index', compact(
        'riwayat',
        'totalMasuk',
        'totalKeluar'
    ));
}
}
