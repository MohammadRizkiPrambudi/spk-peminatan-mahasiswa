<?php
namespace App\Http\Controllers; // Perhatikan namespace, ini bukan Admin

use App\Models\Mahasiswa;
use App\Models\NilaiAkademik;
use App\Models\PreferensiMinat;
use App\Models\RekomendasiPeminatan;
use App\Models\TesBakat;
use App\Services\DempsterShaferService;
use App\Services\FuzzyLogicService;
use Illuminate\Support\Facades\Log;
// Untuk logging error

class HasilRekomendasiController extends Controller
{
    protected $fuzzyService;
    protected $dsService;

    public function __construct(FuzzyLogicService $fuzzyService, DempsterShaferService $dsService)
    {
        $this->fuzzyService = $fuzzyService;
        $this->dsService    = $dsService;
    }

    /**
     * Menampilkan hasil rekomendasi untuk mahasiswa yang sedang login.
     * Logika perhitungan di sini sama persis dengan ProsesController::proses().
     */
    public function showSelf()
    {
        $user = auth()->user();

        // Pastikan user memiliki relasi ke model Mahasiswa
        if (! $user->mahasiswa) {
            abort(404, 'Data mahasiswa tidak ditemukan untuk user ini.');
        }

        $mahasiswaId = $user->mahasiswa->id;
        $mahasiswa   = Mahasiswa::findOrFail($mahasiswaId); // Ambil model mahasiswa

        // 1. Ambil data mentah dari database untuk mahasiswa yang sedang login
        $nilai = NilaiAkademik::where('mahasiswa_id', $mahasiswaId)->pluck('nilai', 'matakuliah')->toArray();
        $minat = PreferensiMinat::where('mahasiswa_id', $mahasiswaId)->pluck('tingkat_minat', 'bidang')->toArray();
        $tes   = TesBakat::where('mahasiswa_id', $mahasiswaId)->pluck('skor', 'kategori_bakat')->toArray();

        // Inisialisasi variabel untuk hasil perhitungan
        $bpaAkademik      = [];
        $bpaMinat         = [];
        $tesBpa           = [];
        $finalCombinedBpa = [];
        $rekomendasiUtama = 'Belum Diproses';
        $nilaiKepercayaan = 0;

        // Hanya lakukan perhitungan jika semua data yang diperlukan tersedia
        if (! empty($nilai) && ! empty($minat) && ! empty($tes)) {
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
            $allBpasToCombine = [
                $bpaAkademik,
                $bpaMinat,
                $tesBpa,
            ];

            $finalCombinedBpa = $this->dsService->combineEvidences($allBpasToCombine);

            // Penanganan jika ada error saat kombinasi (misal: konflik sempurna)
            if (isset($finalCombinedBpa['error'])) {
                Log::error('Dempster-Shafer Combination Error for Mahasiswa ID ' . $mahasiswaId . ': ' . $finalCombinedBpa['error']);
                return redirect()->back()->with('error', 'Terjadi konflik dalam perhitungan rekomendasi: ' . $finalCombinedBpa['error']);
            }

            // 4. Tentukan Rekomendasi Peminatan Utama
            $rekomendasiUtama = $this->dsService->getRecommendation($finalCombinedBpa);
            $nilaiKepercayaan = $finalCombinedBpa[$rekomendasiUtama] ?? 0; // Ambil nilai dari kunci string sederhana

            // 5. Simpan hasil rekomendasi ke database (sesuai ProsesController)
            RekomendasiPeminatan::updateOrCreate(
                ['mahasiswa_id' => $mahasiswaId],
                ['peminatan_utama' => $rekomendasiUtama, 'nilai_kepercayaan' => $nilaiKepercayaan]
            );

        } else {
            Log::warning('Data tidak lengkap untuk perhitungan rekomendasi mahasiswa ID: ' . $mahasiswaId);
            return redirect()->back()->with('warning', 'Data akademik, minat, atau tes bakat belum lengkap untuk perhitungan rekomendasi.');
        }

        // Ambil hasil rekomendasi yang telah disimpan untuk ditampilkan
        $rekomendasiModel = RekomendasiPeminatan::where('mahasiswa_id', $mahasiswaId)->first();

        // Siapkan data untuk view
        $dataForView = [
            'mahasiswa'       => $mahasiswa,
            'bpaAkademikView' => $bpaAkademik,      // Langsung gunakan hasil perhitungan
            'bpaMinatView'    => $bpaMinat,         // Langsung gunakan hasil perhitungan
            'bpaTesBakatView' => $tesBpa,           // Langsung gunakan hasil perhitungan
            'dsResultView'    => $finalCombinedBpa, // Langsung gunakan hasil perhitungan
            'rekomendasi'     => $rekomendasiModel, // Model rekomendasi dari DB
        ];

        return view('pages.rekomendasi.index', $dataForView);
    }

    /**
     * Memproses perhitungan rekomendasi peminatan untuk mahasiswa tertentu (AJAX).
     * Logika perhitungan di sini sama persis dengan ProsesController::prosesAjax().
     *
     * @param int $id ID Mahasiswa
     * @return \Illuminate\Http\JsonResponse
     */
    public function showSelfAjax($id) // Menggunakan $id untuk konsistensi dengan ProsesController
    {
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
