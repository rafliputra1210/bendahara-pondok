<?php

namespace App\Http\Controllers;

use App\Models\Pembayaran;
use App\Models\Transaksi;
use App\Models\Siswa;
use Illuminate\Http\Request;
use Carbon\Carbon;

class PembayaranController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'role:admin']);
    }

    // ==================== DASHBOARD ADMIN ====================
    public function dashboard()
    {
        $siswaAktif = Pembayaran::distinct('nama_santri')->count('nama_santri');

        $totalSetoran = Pembayaran::where('jenis', 'setoran')->sum('jumlah');

        $totalPemasukan   = Transaksi::where('jenis', 'pemasukan')->sum('jumlah');
        $totalPengeluaran = Transaksi::where('jenis', 'pengeluaran')->sum('jumlah');

        $saldo = $totalSetoran + $totalPemasukan - $totalPengeluaran;

        $tanggal = Transaksi::selectRaw('DATE(tanggal) as tgl')
            ->where('tanggal', '>=', now()->subDays(6)->startOfDay())
            ->groupBy('tgl')
            ->orderBy('tgl')
            ->get();

        $labelTanggal    = [];
        $dataSetoran     = [];
        $dataPengeluaran = [];

        foreach ($tanggal as $row) {
            $tgl = $row->tgl;

            $labelTanggal[] = Carbon::parse($tgl)->format('d-m');

            $dataSetoran[] = Transaksi::whereDate('tanggal', $tgl)
                ->where('jenis', 'pemasukan')
                ->sum('jumlah');

            $dataPengeluaran[] = Transaksi::whereDate('tanggal', $tgl)
                ->where('jenis', 'pengeluaran')
                ->sum('jumlah');
        }

        $transaksiTerbaru  = Transaksi::orderBy('tanggal', 'desc')->limit(5)->get();
        $pembayaranTerbaru = Pembayaran::orderBy('created_at', 'desc')->limit(5)->get();

        return view('admin.dashboard', compact(
            'siswaAktif',
            'totalSetoran',
            'totalPengeluaran',
            'saldo',
            'transaksiTerbaru',
            'pembayaranTerbaru',
            'labelTanggal',
            'dataSetoran',
            'dataPengeluaran'
        ));
    }

    // ==================== DATA PEMBAYARAN ====================
    public function index(Request $request)
    {
        $nama       = $request->input('nama');
        $keterangan = $request->input('keterangan', 'semua');
        $perPage    = (int) $request->input('per_page', 10);

        $query = Pembayaran::query();

        if ($nama) {
            $query->where('nama_santri', 'like', "%{$nama}%");
        }

        if ($keterangan !== 'semua') {
            $query->where('keterangan', $keterangan);
        }

        $pembayaran = $query->orderBy('created_at', 'desc')->paginate($perPage);

        $totalSetoran     = Pembayaran::where('jenis', 'setoran')->sum('jumlah');
        $totalPengeluaran = Pembayaran::where('jenis', 'pengeluaran')->sum('jumlah');
        $saldo            = $totalSetoran - $totalPengeluaran;

        return view('admin.pembayaran.index', compact(
            'pembayaran',
            'totalSetoran',
            'totalPengeluaran',
            'saldo',
            'nama',
            'keterangan',
            'perPage'
        ));
    }

    // FORM TAMBAH PEMBAYARAN
    public function create()
    {
        // ambil semua siswa untuk dropdown
        $siswa = Siswa::orderBy('nama_lengkap')->get();

        return view('admin.pembayaran.create', compact('siswa'));
    }

    // SIMPAN PEMBAYARAN BARU
    public function store(Request $request)
    {
        $data = $request->validate([
            'siswa_id'   => 'required|exists:siswa,id',
            'keterangan' => 'required|string|max:255',
            'jumlah'     => 'required|numeric|min:0',
            'status'     => 'required|string',
        ]);

        // ambil nama siswa dari tabel siswa
        $siswa = Siswa::findOrFail($data['siswa_id']);

        $data['nama_santri'] = $siswa->nama_lengkap;
        $data['jenis']       = 'setoran';

        Pembayaran::create($data);

        return redirect()->route('pembayaran.index')
            ->with('success', 'Pembayaran berhasil ditambahkan.');
    }

    // FORM EDIT PEMBAYARAN
    public function edit($id)
    {
        $pembayaran = Pembayaran::findOrFail($id);
        $siswa      = Siswa::orderBy('nama_lengkap')->get();

        return view('admin.pembayaran.edit', compact('pembayaran', 'siswa'));
    }

    // UPDATE PEMBAYARAN
    public function update(Request $request, $id)
    {
        $data = $request->validate([
            'siswa_id'   => 'required|exists:siswa,id',
            'keterangan' => 'required|string|max:255',
            'jumlah'     => 'required|numeric|min:0',
            'status'     => 'required|string',
        ]);

        $siswa = Siswa::findOrFail($data['siswa_id']);

        $data['nama_santri'] = $siswa->nama_lengkap;
        $data['jenis']       = 'setoran';

        $pembayaran = Pembayaran::findOrFail($id);
        $pembayaran->update($data);

        return redirect()->route('pembayaran.index')
            ->with('success', 'Data pembayaran berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $pembayaran = Pembayaran::findOrFail($id);
        $pembayaran->delete();

        return redirect()->route('pembayaran.index')
            ->with('success', 'Data pembayaran berhasil dihapus.');
    }
     public function print($id)
    {
        $pembayaran = Pembayaran::findOrFail($id);

        // kalau ingin format tanggal di view saja juga boleh
        return view('admin.pembayaran.print', compact('pembayaran'));
    }
}
