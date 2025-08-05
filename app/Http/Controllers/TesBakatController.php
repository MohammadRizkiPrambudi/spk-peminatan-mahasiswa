<?php
namespace App\Http\Controllers;

use App\Models\TesBakat;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TesBakatController extends Controller
{
    public function form()
    {
        // $bidangBakat = ['Pemrograman', 'Jaringan', 'Multimedia', 'Akuntansi'];
        $bidangBakat = ['Sistem Cerdas', 'AI', 'Jaringan'];

        $existing = TesBakat::where('mahasiswa_id', Auth::user()->mahasiswa->id)
            ->pluck('skor', 'kategori_bakat')->toArray();

        return view('pages.tes_bakat.form', compact('bidangBakat', 'existing'));
    }

    public function submit(Request $request)
    {
        $request->validate([
            'skor'   => 'required|array',
            'skor.*' => 'numeric|min:0|max:100',
        ]);

        $mahasiswaId = Auth::user()->mahasiswa->id;

        foreach ($request->skor as $bidang => $nilai) {
            TesBakat::updateOrCreate(
                ['mahasiswa_id' => $mahasiswaId, 'kategori_bakat' => $bidang],
                ['skor' => $nilai]
            );
        }

        return redirect()->route('tes.form')->with('success', 'Tes bakat berhasil disimpan.');
    }
}