<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Mahasiswa;
use App\Models\TesBakat;
use Illuminate\Http\Request;

class TesBakatController extends Controller
{
    public function index()
    {
        $data = TesBakat::with('mahasiswa')->orderBy('mahasiswa_id')->get();
        return view('pages.tes.index', compact('data'));
    }

    public function create()
    {
        $mahasiswa = Mahasiswa::all();
        // $kategori  = ['Pemrograman', 'Jaringan', 'Multimedia', 'Akuntansi'];
        $kategori = ['Sistem Cerdas', 'AI', 'Jaringan'];
        return view('pages.tes.create', compact('mahasiswa', 'kategori'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'mahasiswa_id'   => 'required|exists:mahasiswa,id',
            'kategori_bakat' => 'required|string',
            'skor'           => 'required|integer|min:0|max:100',
        ]);

        TesBakat::create($request->all());

        return redirect()->route('admin.tes.index')->with('success', 'Data tes bakat berhasil disimpan.');
    }

    public function edit($id)
    {
        $tes       = TesBakat::findOrFail($id);
        $mahasiswa = Mahasiswa::all();
        // $kategori  = ['Pemrograman', 'Jaringan', 'Multimedia', 'Akuntansi'];
        $kategori = ['Sistem Cerdas', 'AI', 'Jaringan'];
        return view('pages.tes.edit', compact('tes', 'mahasiswa', 'kategori'));
    }

    public function update(Request $request, $id)
    {
        $tes = TesBakat::findOrFail($id);

        $request->validate([
            'mahasiswa_id'   => 'required|exists:mahasiswa,id',
            'kategori_bakat' => 'required|string',
            'skor'           => 'required|integer|min:0|max:100',
        ]);

        $tes->update($request->all());

        return redirect()->route('admin.tes.index')->with('success', 'Data tes bakat berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $tes = TesBakat::findOrFail($id);
        $tes->delete();

        return redirect()->route('admin.tes.index')->with('success', 'Data tes bakat berhasil dihapus.');
    }
}