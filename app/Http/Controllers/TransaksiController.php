<?php

namespace App\Http\Controllers;

use App\Models\Transaksi;
use Illuminate\Http\Request;

class TransaksiController extends Controller
{
    // LIST: hanya pengeluaran
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

        $data['jenis'] = 'pengeluaran'; // paksa pengeluaran

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

        $data['jenis'] = 'pengeluaran'; // tetap pengeluaran

        $transaksi->update($data);

        return redirect()->route('transaksi.index')
            ->with('success', 'Pengeluaran berhasil diubah.');
    }

    // HAPUS (jaga-jaga kalau ada data lama bukan pengeluaran)
    public function destroy(Transaksi $transaksi)
    {
        if ($transaksi->jenis !== 'pengeluaran') {
            return back()->with('error', 'Yang boleh dihapus hanya pengeluaran.');
        }

        $transaksi->delete();

        return back()->with('success', 'Pengeluaran berhasil dihapus.');
    }
}
