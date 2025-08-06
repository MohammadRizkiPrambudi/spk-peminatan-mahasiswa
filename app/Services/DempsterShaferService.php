<?php
namespace App\Services;

class DempsterShaferService
{
    // Definisikan bidang-bidang peminatan yang mungkin
    private $bidangPeminatan = ['AI', 'Jaringan', 'Sistem Cerdas'];

    /**
     * Mengkombinasikan dua fungsi massa (BPA) menggunakan aturan kombinasi Dempster yang disederhanakan (sesuai Excel).
     * Kunci hipotesis diharapkan dalam format string sederhana (e.g., 'AI', 'Jaringan', 'θ').
     *
     * @param array $m1 Fungsi massa pertama (e.g., ['AI' => 0.3, 'Jaringan' => 0.2, 'θ' => 0.5])
     * @param array $m2 Fungsi massa kedua
     * @return array Fungsi massa hasil kombinasi
     */
    private function combineTwoMassFunctions(array $m1, array $m2): array
    {
        $result   = [];
        $conflict = 0;

        // Inisialisasi hasil kombinasi untuk setiap bidang
        foreach ($this->bidangPeminatan as $bidang) {
            $result[$bidang] = 0;
        }
        $result['θ'] = 0; // Inisialisasi untuk theta gabungan

        // Pastikan semua BPA memiliki kunci 'θ' untuk perhitungan yang konsisten
        $m1['θ'] = $m1['θ'] ?? 0;
        $m2['θ'] = $m2['θ'] ?? 0;

        // Perhitungan Konflik (K) sesuai logika Excel:
        // K = Sum(m1(X) * m2(Y)) where X != Y (dan X, Y bukan theta)
        // PLUS (m1(X) * m2(theta) where X is not theta)
        // PLUS (m2(Y) * m1(theta) where Y is not theta)
        // Ini adalah interpretasi yang paling mendekati Excel Anda.

        // Bagian 1: Konflik antara singletons yang berbeda (AI vs Jaringan, dll)
        foreach ($this->bidangPeminatan as $b1) {
            foreach ($this->bidangPeminatan as $b2) {
                if ($b1 !== $b2) {
                    $conflict += ($m1[$b1] ?? 0) * ($m2[$b2] ?? 0);
                }
            }
        }

        // Bagian 2: Kombinasi langsung (intersection = singleton)
        foreach ($this->bidangPeminatan as $bidang) {
            // m_combined(A) = m1(A) * m2(A)
            $result[$bidang] += ($m1[$bidang] ?? 0) * ($m2[$bidang] ?? 0);

            // m_combined(A) = m1(A) * m2(theta)
            $result[$bidang] += ($m1[$bidang] ?? 0) * ($m2['θ'] ?? 0);

            // m_combined(A) = m2(A) * m1(theta)
            $result[$bidang] += ($m2[$bidang] ?? 0) * ($m1['θ'] ?? 0);
        }

        // Hitung K (konflik) yang sebenarnya untuk normalisasi
        // K adalah massa yang dialokasikan ke himpunan kosong (irisan kosong)
        // Dalam konteks Excel Anda, K adalah 1 - (sum semua hasil kombinasi yang tidak kosong)
        $k = 0;
        foreach ($m1 as $h1Key => $mass1) {
            foreach ($m2 as $h2Key => $mass2) {
                if ($h1Key === 'θ' && $h2Key === 'θ') {
                    // Theta dan Theta beririsan (menghasilkan theta)
                    $result['θ'] += $mass1 * $mass2;
                } elseif ($h1Key === 'θ') {
                    // Theta dan singleton (menghasilkan singleton) - sudah ditambahkan di atas
                } elseif ($h2Key === 'θ') {
                    // Singleton dan Theta (menghasilkan singleton) - sudah ditambahkan di atas
                } elseif ($h1Key === $h2Key) {
                    // Singleton yang sama (menghasilkan singleton) - sudah ditambahkan di atas
                } else {
                    // Singleton yang berbeda (irisan kosong -> konflik)
                    $k += $mass1 * $mass2;
                }
            }
        }

        $normalizedFactor = 1 - $k;

        // Normalisasi akhir
        if ($normalizedFactor <= 0) {
            // Konflik sempurna, atau pembagi nol. Kembalikan error.
            return ['error' => 'Total conflict detected or division by zero: ' . round($k, 4)];
        }

        $finalNormalized = [];
        $sumOfNormalized = 0;
        foreach ($result as $key => $val) {
            $finalNormalized[$key] = round($val / $normalizedFactor, 4);
            $sumOfNormalized += $finalNormalized[$key];
        }

                                                                  // Penyesuaian akhir untuk memastikan total 1.0 jika ada pembulatan
                                                                  // Ini mungkin diperlukan jika pembulatan 4 desimal membuat total sedikit lebih dari 1
        if ($sumOfNormalized > 1 && $sumOfNormalized <= 1.0001) { // Toleransi kecil untuk pembulatan
            foreach ($finalNormalized as $key => $val) {
                $finalNormalized[$key] = round($val / $sumOfNormalized, 4);
            }
        }

        return $finalNormalized;
    }

    /**
     * Mengkombinasikan multiple fungsi massa (BPA) secara berurutan.
     * Input diharapkan adalah array dari BPAs, di mana setiap BPA memiliki kunci string sederhana.
     *
     * @param array $bpas Array of BPAs (e.g., [$bpaAkademik, $bpaMinat, $tesBpa])
     * @return array Fungsi massa hasil kombinasi akhir atau array dengan 'error'
     */
    public function combineEvidences(array $bpas): array
    {
        if (empty($bpas)) {
            return [];
        }

        // Inisialisasi dengan BPA pertama
        $combinedBPA = $bpas[0];

        // Kombinasikan dengan BPA berikutnya secara berurutan
        for ($i = 1; $i < count($bpas); $i++) {
            $combinedBPA = $this->combineTwoMassFunctions($combinedBPA, $bpas[$i]);

            // Handle jika ada konflik total di tengah proses kombinasi
            if (isset($combinedBPA['error'])) {
                return $combinedBPA;
            }
        }

        return $combinedBPA;
    }

    /**
     * Menentukan rekomendasi peminatan terbaik dari hasil kombinasi Dempster-Shafer.
     * Mengambil hipotesis tunggal dengan nilai kepercayaan (mass) tertinggi.
     *
     * @param array $combinedBPA Fungsi massa hasil kombinasi (e.g., ['AI' => 0.6, 'Jaringan' => 0.3, 'θ' => 0.1])
     * @return string Nama bidang rekomendasi (e.g., 'AI', 'Jaringan', 'Sistem Cerdas')
     */
    public function getRecommendation(array $combinedBPA): string
    {
        $bestBidang    = null;
        $highestBelief = -1;

        foreach ($combinedBPA as $bidang => $mass) {
            // Kita hanya tertarik pada hipotesis tunggal (bukan 'θ') untuk rekomendasi utama
            if ($bidang !== 'θ') {
                if ($mass > $highestBelief) {
                    $highestBelief = $mass;
                    $bestBidang    = $bidang;
                }
            }
        }

        return $bestBidang ?? 'Tidak dapat ditentukan';
    }
}
