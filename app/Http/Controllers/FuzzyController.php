<?php
namespace App\Http\Controllers;

use App\Models\Mahasiswa;
use App\Models\TesBakat;
use App\Services\DempsterShaferService;
use App\Services\FuzzyLogicService;

class FuzzyController extends Controller
{
    protected $fuzzyService;

    public function __construct(FuzzyLogicService $fuzzyService)
    {
        $this->fuzzyService = $fuzzyService;
    }

    public function proses($mahasiswa_id, DempsterShaferService $dsService)
    {
        $mahasiswa = Mahasiswa::with(['nilaiAkademik', 'preferensiMinat', 'tesBakat'])->findOrFail($mahasiswa_id);

        $nilai = $mahasiswa->nilaiAkademik->pluck('nilai', 'matakuliah')->toArray();
        $minat = $mahasiswa->preferensiMinat->pluck('tingkat_minat', 'bidang')->toArray();

        // Proses fuzzy
        $fuzzyResult = $this->fuzzyService->prosesFuzzifikasi($nilai, $minat, $mahasiswa->id);

        // Ambil tes bakat sebagai evidence kedua
        $tesBakat = $mahasiswa->tesBakat->pluck('skor', 'kategori_bakat')->toArray();
        $totalTes = array_sum($tesBakat);
        $tesBpa   = [];
        foreach ($tesBakat as $bidang => $skor) {
            $tesBpa[$bidang] = round($skor / $totalTes, 4); // normalisasi
        }

        $sisa         = round(1 - array_sum($tesBpa), 4);
        $tesBpa['θ'] = $sisa;

        // Kombinasi DS
        $combined = $dsService->combine($fuzzyResult, $tesBpa);

        // Simpan hasil
        $hasil = $dsService->simpanHasil($combined, $mahasiswa->id);

        return response()->json([
            'message'     => 'Berhasil diproses',
            'rekomendasi' => $hasil['rekomendasi'],
            'kepercayaan' => $hasil['kepercayaan'],
            'belief_all'  => $hasil['semua'],
        ]);
    }

}