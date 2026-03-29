<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Siswa;

class SiswaController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'role:admin']);
    }

    public function index(Request $request)
    {
        $kelas = $request->input('kelas', 'semua');
        $jk    = $request->input('jk', 'semua');
        $q     = $request->input('q', null);

        // opsi kelas untuk dropdown
        $kelasOptions = Siswa::select('kelas')
            ->whereNotNull('kelas')
            ->distinct()
            ->orderBy('kelas')
            ->pluck('kelas');

        $query = Siswa::query();

        if ($kelas && $kelas !== 'semua') {
            $query->where('kelas', $kelas);
        }

        if ($jk && $jk !== 'semua') {
            // pastikan ada kolom 'jk' di tabel
            $query->where('jk', $jk);
        }

        if ($q) {
            $query->where('nama_lengkap', 'like', "%{$q}%");
        }

        $siswa = $query->orderBy('nama_lengkap')->paginate(10);

        return view('admin.siswa.index', compact('siswa', 'kelasOptions', 'kelas', 'jk', 'q'));
    }

    public function create()
    {
        return view('admin.siswa.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'nama_lengkap' => 'required|string|max:255',
            'alamat'       => 'nullable|string|max:255',
            'kelas'        => 'nullable|string|max:100',
            'jk'           => 'nullable|in:Laki-laki,Perempuan',
        ]);

        Siswa::create($data);

        return redirect()->route('siswa.index')->with('success', 'Data siswa berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $siswa = Siswa::findOrFail($id);
        return view('admin.siswa.edit', compact('siswa'));
    }

    public function update(Request $request, $id)
    {
        $data = $request->validate([
            'nama_lengkap' => 'required|string|max:255',
            'alamat'       => 'nullable|string|max:255',
            'kelas'        => 'nullable|string|max:100',
            'jk'           => 'nullable|in:Laki-laki,Perempuan',
        ]);

        $siswa = Siswa::findOrFail($id);
        $siswa->update($data);

        return redirect()->route('siswa.index')->with('success', 'Data siswa berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $siswa = Siswa::findOrFail($id);
        $siswa->delete();

        return redirect()->route('siswa.index')->with('success', 'Data siswa berhasil dihapus.');
    }
}
