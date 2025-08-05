<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\MatakuliahBidang;
use Illuminate\Http\Request;

class MatakuliahBidangController extends Controller
{
    public function index()
    {
        $data = MatakuliahBidang::all();
        return view('pages.matakuliahbidang.index', compact('data'));
    }

    public function create()
    {
        $matakuliah = ['Algoritma Dan Struktur Data', 'Sistem Digital', 'Pemrograman Beriorentasi Objek', 'Perancangan Sistem', 'Jaringan Komputer', 'Grafika Komputer', 'Pemrograman Jaringan'];
        $bidang     = ['Sistem Cerdas', 'AI', 'Jaringan'];
        return view('pages.matakuliahbidang.create', compact('matakuliah', 'bidang'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'matakuliah' => 'required|string',
            'bidang'     => 'required|string',
            'bobot'      => 'required|numeric|min:0|max:1',
        ]);

        MatakuliahBidang::create($request->all());

        return redirect()->route('admin.matakuliah-bidang.index')->with('success', 'Data berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $data       = MatakuliahBidang::findOrFail($id);
        $matakuliah = ['Algoritma Dan Struktur Data', 'Sistem Digital', 'Pemrograman Beriorentasi Objek', 'Perancangan Sistem', 'Jaringan Komputer', 'Grafika Komputer', 'Pemrograman Jaringan'];
        $bidang     = ['Sistem Cerdas', 'AI', 'Jaringan'];
        return view('pages.matakuliahbidang.edit', compact('data', 'matakuliah', 'bidang'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'matakuliah' => 'required|string',
            'bidang'     => 'required|string',
            'bobot'      => 'required|numeric|min:0|max:1',
        ]);

        MatakuliahBidang::findOrFail($id)->update($request->all());

        return redirect()->route('admin.matakuliah-bidang.index')->with('success', 'Data berhasil diperbarui.');
    }

    public function destroy($id)
    {
        MatakuliahBidang::destroy($id);
        return redirect()->route('admin.matakuliah-bidang.index')->with('success', 'Data berhasil dihapus.');
    }
}