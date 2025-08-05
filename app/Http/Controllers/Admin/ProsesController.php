<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Mahasiswa;
use App\Models\NilaiAkademik;
use App\Models\PreferensiMinat;
use App\Models\RekomendasiPeminatan;
use App\Models\TesBakat;
use App\Services\DempsterShaferService;
use App\Services\FuzzyLogicService;

class ProsesController extends Controller
{
    public function index()
    {
        $mahasiswa = Mahasiswa::all();
        return view('pages.proses.index', compact('mahasiswa'));
    }

    public function proses($id)
    {
        $mahasiswa = Mahasiswa::findOrFail($id);
        $nilai     = NilaiAkademik::where('mahasiswa_id', $id)->pluck('nilai', 'matakuliah')->toArray();
        $minat     = PreferensiMinat::where('mahasiswa_id', $id)->pluck('tingkat_minat', 'bidang')->toArray();
        $tes       = TesBakat::where('mahasiswa_id', $id)->pluck('skor', 'kategori_bakat')->toArray();

        // Proses Fuzzy
        $fuzzy       = new FuzzyLogicService();
        $fuzzyResult = $fuzzy->prosesFuzzifikasi($nilai, $minat, $id);

        // Ubah tes bakat menjadi BPA
        $totalTes = array_sum($tes);
        $tesBpa   = [];
        foreach ($tes as $bidang => $skor) {
            $tesBpa[$bidang] = round($skor / $totalTes, 4);
        }
        $tesBpa['θ'] = round(1 - array_sum($tesBpa), 4); // ketidaktahuan

        // Proses Dempster-Shafer
        $dsService   = new DempsterShaferService();
        $finalResult = $dsService->combine($fuzzyResult, $tesBpa);

        // Simpan hasil rekomendasi
        $maxKey = array_key_first(array_filter($finalResult, fn($v) => $v === max($finalResult)));
        RekomendasiPeminatan::updateOrCreate(
            ['mahasiswa_id' => $id],
            ['peminatan_utama' => $maxKey, 'nilai_kepercayaan' => $finalResult[$maxKey] ?? 0]
        );

        return redirect()->route('admin.hasil.index')->with('success', 'Perhitungan berhasil dan hasil disimpan.');
    }

    public function prosesAjax($id)
    {
        $mahasiswa = Mahasiswa::findOrFail($id);
        $nilai     = NilaiAkademik::where('mahasiswa_id', $id)->pluck('nilai', 'matakuliah')->toArray();
        $minat     = PreferensiMinat::where('mahasiswa_id', $id)->pluck('tingkat_minat', 'bidang')->toArray();
        $tes       = TesBakat::where('mahasiswa_id', $id)->pluck('skor', 'kategori_bakat')->toArray();

        $fuzzy       = new FuzzyLogicService();
        $fuzzyResult = $fuzzy->prosesFuzzifikasi($nilai, $minat, $id);

        // Normalisasi tes bakat jadi BPA
        $totalTes = array_sum($tes);
        $tesBpa   = [];
        foreach ($tes as $bidang => $skor) {
            $tesBpa[$bidang] = round($skor / $totalTes, 4);
        }
        $tesBpa['θ'] = round(1 - array_sum($tesBpa), 4);

        $ds       = new DempsterShaferService();
        $dsResult = $ds->combine($fuzzyResult, $tesBpa);

        $rekomendasi = array_key_first(array_filter($dsResult, fn($v) => $v === max($dsResult)));

        return response()->json([
            'mahasiswa'   => $mahasiswa,
            'fuzzy'       => $fuzzyResult,
            'ds'          => $dsResult,
            'rekomendasi' => $rekomendasi,
        ]);
    }
}