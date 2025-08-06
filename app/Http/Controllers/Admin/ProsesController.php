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
    protected $fuzzyService;
    protected $dsService;

    public function __construct(FuzzyLogicService $fuzzyService, DempsterShaferService $dsService)
    {
        $this->fuzzyService = $fuzzyService;
        $this->dsService    = $dsService;
    }

    /**
     * Menampilkan daftar mahasiswa untuk diproses.
     */
    public function index()
    {
        $mahasiswa = Mahasiswa::all();
        return view('pages.proses.index', compact('mahasiswa'));
    }

    /**
     * Memproses perhitungan rekomendasi peminatan untuk mahasiswa tertentu.
     * Menggunakan logika Fuzzy untuk BPA dan Dempster-Shafer untuk kombinasi bukti.
     *
     * @param int $id ID Mahasiswa
     * @return \Illuminate\Http\RedirectResponse
     */
    public function proses($id)
    {
        // 1. Ambil data mentah dari database untuk mahasiswa yang dipilih
        $mahasiswa = Mahasiswa::findOrFail($id);
        $nilai     = NilaiAkademik::where('mahasiswa_id', $id)->pluck('nilai', 'matakuliah')->toArray();
        $minat     = PreferensiMinat::where('mahasiswa_id', $id)->pluck('tingkat_minat', 'bidang')->toArray();
        $tes       = TesBakat::where('mahasiswa_id', $id)->pluck('skor', 'kategori_bakat')->toArray();

        // 2. Hitung BPA (Basic Probability Assignment) untuk setiap sumber data
        //    a. BPA dari Nilai Akademik
        $bpaAkademik = $this->fuzzyService->calculateBpaAkademik($nilai);

        //    b. BPA dari Preferensi Minat
        $bpaMinat = $this->fuzzyService->calculateBpaMinatBakat($minat);

        //    c. BPA dari Tes Bakat (normalisasi skor)
        $totalSkorTes = array_sum($tes);
        $tesBpa       = [];
        if ($totalSkorTes > 0) {
            $sumOfSingletonsTes = 0;
            foreach ($tes as $bidang => $skor) {
                $mass            = round($skor / $totalSkorTes, 4);
                $tesBpa[$bidang] = $mass; // Kunci adalah string sederhana
                $sumOfSingletonsTes += $mass;
            }
            $tesBpa['θ'] = round(1 - $sumOfSingletonsTes, 4); // Ketidakpastian theta
        } else {
            // Jika total skor tes 0, semua massa ke theta
            $tesBpa       = array_fill_keys(['AI', 'Jaringan', 'Sistem Cerdas'], 0.00);
            $tesBpa['θ'] = 1.00;
        }

        // 3. Kombinasi Bukti menggunakan Dempster-Shafer
        //    Siapkan semua BPA yang akan dikombinasikan
        $allBpasToCombine = [
            $bpaAkademik,
            $bpaMinat,
            $tesBpa,
        ];

        // Lakukan kombinasi Dempster-Shafer
        $finalCombinedBpa = $this->dsService->combineEvidences($allBpasToCombine);

        // Penanganan jika ada error saat kombinasi (misal: konflik sempurna)
        if (isset($finalCombinedBpa['error'])) {
            return redirect()->back()->with('error', $finalCombinedBpa['error']);
        }

        // 4. Tentukan Rekomendasi Peminatan Utama
        //    Ambil bidang dengan nilai kepercayaan tertinggi
        $rekomendasiUtama = $this->dsService->getRecommendation($finalCombinedBpa);

        // Nilai kepercayaan untuk rekomendasi utama
        // Ambil nilai dari kunci string sederhana
        $nilaiKepercayaan = $finalCombinedBpa[$rekomendasiUtama] ?? 0;

        // 5. Simpan hasil rekomendasi ke database
        RekomendasiPeminatan::updateOrCreate(
            ['mahasiswa_id' => $id],
            ['peminatan_utama' => $rekomendasiUtama, 'nilai_kepercayaan' => $nilaiKepercayaan]
        );

        return redirect()->route('admin.hasil.index')->with('success', 'Perhitungan berhasil dan hasil disimpan.');
    }

    /**
     * Memproses perhitungan rekomendasi peminatan untuk mahasiswa tertentu (AJAX).
     * Mengembalikan hasil perhitungan dalam format JSON.
     *
     * @param int $id ID Mahasiswa
     * @return \Illuminate\Http\JsonResponse
     */
    public function prosesAjax($id)
    {
        // 1. Ambil data mentah dari database
        $mahasiswa = Mahasiswa::findOrFail($id);
        $nilai     = NilaiAkademik::where('mahasiswa_id', $id)->pluck('nilai', 'matakuliah')->toArray();
        $minat     = PreferensiMinat::where('mahasiswa_id', $id)->pluck('tingkat_minat', 'bidang')->toArray();
        $tes       = TesBakat::where('mahasiswa_id', $id)->pluck('skor', 'kategori_bakat')->toArray();

        // 2. Hitung BPA (Basic Probability Assignment) untuk setiap sumber data
        $bpaAkademik = $this->fuzzyService->calculateBpaAkademik($nilai);
        $bpaMinat    = $this->fuzzyService->calculateBpaMinatBakat($minat);

        $totalSkorTes = array_sum($tes);
        $tesBpa       = [];
        if ($totalSkorTes > 0) {
            $sumOfSingletonsTes = 0;
            foreach ($tes as $bidang => $skor) {
                $mass            = round($skor / $totalSkorTes, 4);
                $tesBpa[$bidang] = $mass;
                $sumOfSingletonsTes += $mass;
            }
            $tesBpa['θ'] = round(1 - $sumOfSingletonsTes, 4);
        } else {
            $tesBpa       = array_fill_keys(['AI', 'Jaringan', 'Sistem Cerdas'], 0.00);
            $tesBpa['θ'] = 1.00;
        }

        // 3. Kombinasi Bukti menggunakan Dempster-Shafer
        $allBpasToCombine = [
            $bpaAkademik,
            $bpaMinat,
            $tesBpa,
        ];
        $finalCombinedBpa = $this->dsService->combineEvidences($allBpasToCombine);

        // Penanganan error untuk respons AJAX
        if (isset($finalCombinedBpa['error'])) {
            return response()->json(['error' => $finalCombinedBpa['error']], 500);
        }

        // 4. Tentukan Rekomendasi Peminatan Utama
        $rekomendasiUtama = $this->dsService->getRecommendation($finalCombinedBpa);
        $nilaiKepercayaan = $finalCombinedBpa[$rekomendasiUtama] ?? 0;

        // 5. Kembalikan hasil dalam format JSON
        return response()->json([
            'mahasiswa'                     => $mahasiswa,
            'bpa_akademik'                  => $bpaAkademik,
            'bpa_minat'                     => $bpaMinat,
            'bpa_tes'                       => $tesBpa,
            'ds_result'                     => $finalCombinedBpa,
            'rekomendasi'                   => $rekomendasiUtama,
            'nilai_kepercayaan_rekomendasi' => $nilaiKepercayaan,
        ]);
    }
}
