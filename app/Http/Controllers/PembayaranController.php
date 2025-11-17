<?php

namespace App\Http\Controllers;

use App\Models\Pembayaran;
use App\Models\Transaksi;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class PembayaranController extends Controller
{
    /** LIST + ringkasan + filter */
    public function index(Request $request)
{
    // ambil parameter dari query
    $q           = trim($request->get('q', ''));
    $keterangan  = $request->get('keterangan', ''); // '', 'Syahriyyah Pondok', 'Syahriyyah Mds', 'Loker'
    $perPage     = (int) $request->get('per_page', 10);
    if (! in_array($perPage, [10,25,50,100])) $perPage = 10;

    // build query data pembayaran
    $query = Pembayaran::query()->latest();

    if ($q !== '') {
        $query->where('nama_santri', 'like', "%{$q}%");
    }
    if ($keterangan !== '') {
        $query->where('keterangan', $keterangan);
    }

    $pembayaran = $query->paginate($perPage)->withQueryString();

    // ringkasan
    $totalSetoran     = (float) Pembayaran::sum('jumlah')
                         + (float) Transaksi::where('jenis','pemasukan')->sum('jumlah');
    $totalPengeluaran = (float) Transaksi::where('jenis','pengeluaran')->sum('jumlah');
    $totalSaldo       = $totalSetoran - $totalPengeluaran;

    return view('pembayaran.index', compact(
        'pembayaran', 'q', 'keterangan', 'perPage',
        'totalSetoran', 'totalPengeluaran', 'totalSaldo'
    ));
}


    /** FORM TAMBAH */
    public function create()
    {
        return view('pembayaran.create');
    }

    /** SIMPAN */
    public function store(Request $request)
    {
        $request->validate([
            'nama_santri' => ['required','string','max:255'],
            'keterangan'  => ['required', Rule::in(['Syahriyyah Pondok','Syahriyyah Mds','Loker'])],
            'jumlah'      => ['required','numeric','min:0'],
        ]);

        Pembayaran::create([
            'nama_santri' => $request->nama_santri,
            'keterangan'  => ucwords(strtolower($request->keterangan)),
            'jumlah'      => $request->jumlah,
            'jenis'       => 'Setoran', // pembayaran khusus setoran
        ]);

        return redirect()->route('pembayaran.index')->with('success','Setoran berhasil disimpan.');
    }

    /** FORM EDIT */
    public function edit(Pembayaran $pembayaran)
    {
        return view('pembayaran.edit', compact('pembayaran'));
    }

    /** UPDATE */
    public function update(Request $request, Pembayaran $pembayaran)
    {
        $request->validate([
            'nama_santri' => ['required','string','max:255'],
            'keterangan'  => ['required', Rule::in(['Syahriyyah Pondok','Syahriyyah Mds','Loker'])],
            'jumlah'      => ['required','numeric','min:0'],
        ]);

        $pembayaran->update([
            'nama_santri' => $request->nama_santri,
            'keterangan'  => ucwords(strtolower($request->keterangan)),
            'jumlah'      => $request->jumlah,
            'jenis'       => 'Setoran',
        ]);

        return redirect()->route('pembayaran.index')->with('success','Setoran berhasil diubah.');
    }

    /** HAPUS */
    public function destroy(Pembayaran $pembayaran)
    {
        $pembayaran->delete();
        return redirect()->route('pembayaran.index')->with('success','Setoran berhasil dihapus.');
    }

    /** DASHBOARD (tetap) */
    public function dashboard()
    {
        // santri aktif = jumlah nama santri unik
        $siswaAktif = Pembayaran::selectRaw("COUNT(DISTINCT LOWER(TRIM(nama_santri))) as jml")->value('jml');

        $totalSetoran     = (float) Pembayaran::sum('jumlah')
                           + (float) Transaksi::where('jenis','pemasukan')->sum('jumlah');
        $totalPengeluaran = (float) Transaksi::where('jenis','pengeluaran')->sum('jumlah');

        $data = [
            'siswa_aktif'       => $siswaAktif,
            'total_setoran'     => $totalSetoran,
            'total_pengeluaran' => $totalPengeluaran,
            'total_saldo'       => $totalSetoran - $totalPengeluaran,
        ];

        return view('dashboard', compact('data'));
    }
}
