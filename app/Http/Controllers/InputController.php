<?php
namespace App\Http\Controllers;

use App\Models\NilaiAkademik;
use App\Models\PreferensiMinat;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class InputController extends Controller
{
    public function form()
    {
        // $matakuliah  = ['Pemrograman', 'Jaringan', 'Multimedia', 'Akuntansi'];
        $matakuliah = ['Algoritma Dan Struktur Data', 'Sistem Digital', 'Pemrograman Beriorentasi Objek', 'Perancangan Sistem', 'Jaringan Komputer', 'Grafika Komputer', 'Pemrograman Jaringan'];
        // $minat       = ['Pemrograman', 'Jaringan', 'Multimedia', 'Akuntansi'];
        $minat = ['Sistem Cerdas', 'AI', 'Jaringan'];

        $tingkat     = ['rendah', 'sedang', 'tinggi'];
        $mahasiswaId = Auth::user()->mahasiswa->id;

        // Ambil data nilai dan minat sebelumnya (jika ada)
        $nilaiLama = NilaiAkademik::where('mahasiswa_id', $mahasiswaId)
            ->pluck('nilai', 'matakuliah')->toArray();

        $minatLama = PreferensiMinat::where('mahasiswa_id', $mahasiswaId)
            ->pluck('tingkat_minat', 'bidang')->toArray();

        return view('pages.input.form', compact('matakuliah', 'minat', 'tingkat', 'nilaiLama', 'minatLama'));
    }

    public function submit(Request $request)
    {
        $mahasiswaId = Auth::user()->mahasiswa->id;

        // Simpan nilai
        foreach ($request->nilai as $mk => $nilai) {
            NilaiAkademik::updateOrCreate(
                ['mahasiswa_id' => $mahasiswaId, 'matakuliah' => $mk],
                ['nilai' => $nilai]
            );
        }

        // Simpan minat
        foreach ($request->minat as $bidang => $tingkat) {
            PreferensiMinat::updateOrCreate(
                ['mahasiswa_id' => $mahasiswaId, 'bidang' => $bidang],
                ['tingkat_minat' => $tingkat]
            );
        }

        // Redirect ke halaman Tes Bakat atau notifikasi sukses
        return redirect()->route('tes.form')
            ->with('success', 'Nilai dan minat berhasil disimpan. Silakan lanjutkan ke pengisian tes bakat.');
    }

}