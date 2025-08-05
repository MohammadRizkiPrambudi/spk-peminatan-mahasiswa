<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Mahasiswa;
use App\Models\PreferensiMinat;
use Illuminate\Http\Request;

class PreferensiMinatController extends Controller
{
    public function index()
    {
        $data = PreferensiMinat::with('mahasiswa')->orderBy('mahasiswa_id')->get();
        return view('pages.minat.index', compact('data'));
    }

    public function create()
    {
        $mahasiswa = Mahasiswa::all();
        // $bidang    = ['Pemrograman', 'Jaringan', 'Multimedia', 'Akuntansi'];
        $bidang  = ['Sistem Cerdas', 'AI', 'Jaringan'];
        $tingkat = ['rendah', 'sedang', 'tinggi'];

        return view('pages.minat.create', compact('mahasiswa', 'bidang', 'tingkat'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'mahasiswa_id'  => 'required|exists:mahasiswa,id',
            'bidang'        => 'required|string',
            'tingkat_minat' => 'required|in:rendah,sedang,tinggi',
        ]);

        PreferensiMinat::create($request->all());

        return redirect()->route('admin.minat.index')->with('success', 'Preferensi berhasil disimpan.');
    }

    public function edit($id)
    {
        $minat     = PreferensiMinat::findOrFail($id);
        $mahasiswa = Mahasiswa::all();
        // $bidang    = ['Pemrograman', 'Jaringan', 'Multimedia', 'Akuntansi'];
        $bidang  = ['Sistem Cerdas', 'AI', 'Jaringan'];
        $tingkat = ['rendah', 'sedang', 'tinggi'];

        return view('pages.minat.edit', compact('minat', 'mahasiswa', 'bidang', 'tingkat'));
    }

    public function update(Request $request, $id)
    {
        $minat = PreferensiMinat::findOrFail($id);

        $request->validate([
            'mahasiswa_id'  => 'required|exists:mahasiswa,id',
            'bidang'        => 'required|string',
            'tingkat_minat' => 'required|in:rendah,sedang,tinggi',
        ]);

        $minat->update($request->all());

        return redirect()->route('admin.minat.index')->with('success', 'Preferensi diperbarui.');
    }

    public function destroy($id)
    {
        $minat = PreferensiMinat::findOrFail($id);
        $minat->delete();

        return redirect()->route('admin.minat.index')->with('success', 'Preferensi dihapus.');
    }
}