<?php

namespace App\Http\Controllers;

use App\Models\Transaksi;
use Illuminate\Http\Request;

class TransaksiController extends Controller
{
    // LIST: tampilkan hanya pengeluaran
    public function index()
    {
        $items = Transaksi::where('jenis', 'pengeluaran')
            ->latest('tanggal')
            ->paginate(10);

        return view('transaksi.index', compact('items'));
    }

    // FORM TAMBAH
    public function create()
    {
        return view('transaksi.create');
    }

    // SIMPAN
    public function store(Request $request)
    {
        $data = $request->validate([
            'keterangan' => ['required','string','max:255'],
            'jumlah'     => ['required','numeric','min:0'],
            'tanggal'    => ['required','date'],
        ]);

        // tidak perlu set 'jenis', model akan otomatis isi 'pengeluaran'

        Transaksi::create($data);

        return redirect()->route('transaksi.index')
            ->with('success', 'Pengeluaran berhasil disimpan.');
    }

    // FORM EDIT
    public function edit(Transaksi $transaksi)
    {
        return view('transaksi.edit', compact('transaksi'));
    }

    // UPDATE
    public function update(Request $request, Transaksi $transaksi)
    {
        $data = $request->validate([
            'keterangan' => ['required','string','max:255'],
            'jumlah'     => ['required','numeric','min:0'],
            'tanggal'    => ['required','date'],
        ]);

        // tidak perlu set 'jenis', model tetap memaksanya menjadi pengeluaran
        $transaksi->update($data);

        return redirect()->route('transaksi.index')
            ->with('success', 'Pengeluaran berhasil diubah.');
    }

    // HAPUS
    public function destroy(Transaksi $transaksi)
    {
        // Karena semua data adalah pengeluaran, cukup hapus langsung
        $transaksi->delete();

        return back()->with('success', 'Pengeluaran berhasil dihapus.');
    }
}
