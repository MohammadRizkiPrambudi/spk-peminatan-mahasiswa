<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Mahasiswa;
use App\Models\NilaiAkademik;
use Illuminate\Http\Request;

class NilaiAkademikController extends Controller
{
    public function index()
    {
        $data = NilaiAkademik::with('mahasiswa')->orderBy('mahasiswa_id')->get();
        return view('pages.nilai.index', compact('data'));
    }

    public function create()
    {
        $mahasiswa = Mahasiswa::all();
        // $matakuliah = ['Pemrograman', 'Jaringan', 'Multimedia', 'Akuntansi'];
        $matakuliah = ['Algoritma Dan Struktur Data', 'Sistem Digital', 'Pemrograman Beriorentasi Objek', 'Perancangan Sistem', 'Jaringan Komputer', 'Grafika Komputer', 'Pemrograman Jaringan'];
        return view('pages.nilai.create', compact('mahasiswa', 'matakuliah'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'mahasiswa_id' => 'required|exists:mahasiswa,id',
            'matakuliah'   => 'required|string',
            'nilai'        => 'required|integer|min:0|max:100',
        ]);

        NilaiAkademik::create($request->all());

        return redirect()->route('admin.nilai.index')->with('success', 'Nilai berhasil disimpan.');
    }

    public function edit($id)
    {
        $nilai     = NilaiAkademik::findOrFail($id);
        $mahasiswa = Mahasiswa::all();
        // $matakuliah = ['Pemrograman', 'Jaringan', 'Multimedia', 'Akuntansi'];
        $matakuliah = ['Algoritma Dan Struktur Data', 'Sistem Digital', 'Pemrograman Beriorentasi Objek', 'Perancangan Sistem', 'Jaringan Komputer', 'Grafika Komputer', 'Pemrograman Jaringan'];
        return view('pages.nilai.edit', compact('nilai', 'mahasiswa', 'matakuliah'));
    }

    public function update(Request $request, $id)
    {
        $nilai = NilaiAkademik::findOrFail($id);

        $request->validate([
            'mahasiswa_id' => 'required|exists:mahasiswa,id',
            'matakuliah'   => 'required|string',
            'nilai'        => 'required|integer|min:0|max:100',
        ]);

        $nilai->update($request->all());

        return redirect()->route('admin.nilai.index')->with('success', 'Nilai berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $nilai = NilaiAkademik::findOrFail($id);
        $nilai->delete();

        return redirect()->route('admin.nilai.index')->with('success', 'Nilai berhasil dihapus.');
    }
}