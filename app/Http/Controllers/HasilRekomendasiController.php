<?php
namespace App\Http\Controllers;

use App\Models\DempsterShaferResult;
use App\Models\FuzzyResult;
use App\Models\Mahasiswa;
use App\Models\NilaiAkademik;
use App\Models\PreferensiMinat;
use App\Models\RekomendasiPeminatan;
use App\Models\TesBakat;
use App\Services\DempsterShaferService;
use App\Services\FuzzyLogicService;

class HasilRekomendasiController extends Controller
{

    public function showSelf(
        FuzzyLogicService $fuzzyService,
        DempsterShaferService $dsService
    ) {
        $user = auth()->user();

        if (! $user->mahasiswa) {
            abort(404, 'Mahasiswa tidak ditemukan');
        }

        $mahasiswaId = $user->mahasiswa->id;

        // Ambil data
        $nilai = NilaiAkademik::where('mahasiswa_id', $mahasiswaId)->pluck('nilai', 'matakuliah')->toArray();
        $minat = PreferensiMinat::where('mahasiswa_id', $mahasiswaId)->pluck('tingkat_minat', 'bidang')->toArray();
        $tes   = TesBakat::where('mahasiswa_id', $mahasiswaId)->pluck('skor', 'kategori_bakat')->toArray();

        // Jika data lengkap, lakukan proses
        if (! empty($nilai) && ! empty($minat) && ! empty($tes)) {
            $fuzzyResult = $fuzzyService->prosesFuzzifikasi($nilai, $minat, $mahasiswaId);

            $totalTes = array_sum($tes);
            $tesBpa   = [];
            foreach ($tes as $bidang => $skor) {
                $tesBpa[$bidang] = round($skor / $totalTes, 4);
            }
            $tesBpa['θ'] = round(1 - array_sum($tesBpa), 4);

            $combined = $dsService->combine($fuzzyResult, $tesBpa);
            $dsService->simpanHasil($combined, $mahasiswaId);
        }

        // Ambil hasil akhir dari database
        $mahasiswa   = Mahasiswa::findOrFail($mahasiswaId);
        $fuzzy       = FuzzyResult::where('mahasiswa_id', $mahasiswaId)->first();
        $ds          = DempsterShaferResult::where('mahasiswa_id', $mahasiswaId)->first();
        $rekomendasi = RekomendasiPeminatan::where('mahasiswa_id', $mahasiswaId)->first();

        return view('pages.rekomendasi.index', compact('mahasiswa', 'fuzzy', 'ds', 'rekomendasi'));
    }

}