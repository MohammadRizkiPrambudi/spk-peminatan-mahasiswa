<?php
namespace App\Services;

class DempsterShaferService
{
    /**
     * Mengkombinasikan dua fungsi massa (BPA) menggunakan aturan kombinasi Dempster.
     * Kunci hipotesis diharapkan dalam format JSON-encoded array (e.g., '["AI"]', '["AI", "Jaringan"]').
     *
     * @param array $m1 Fungsi massa pertama (e.g., ['["AI"]' => 0.3, '["Jaringan"]' => 0.2, '["AI", "Jaringan", "Sistem Cerdas"]' => 0.5])
     * @param array $m2 Fungsi massa kedua
     * @return array Fungsi massa hasil kombinasi atau array dengan 'error' jika konflik total
     */
    private function combineTwoMassFunctions(array $m1, array $m2): array
    {
        $mCombined = [];
        $k         = 0; // Inisialisasi konflik

        // Iterasi melalui setiap hipotesis dari m1 dan m2
        foreach ($m1 as $h1Key => $mass1) {
            foreach ($m2 as $h2Key => $mass2) {
                // Decode hipotesis dari string JSON ke array
                $h1Set = json_decode($h1Key, true);
                $h2Set = json_decode($h2Key, true);

                // Hitung irisan (intersection) dari dua himpunan hipotesis
                $intersection = array_values(array_intersect($h1Set, $h2Set));
                sort($intersection); // Pastikan urutan konsisten untuk kunci
                $intersectionKey = json_encode($intersection);

                // Jika irisan kosong, itu adalah konflik
                if (empty($intersection)) {
                    $k += $mass1 * $mass2;
                } else {
                    // Jika irisan tidak kosong, tambahkan ke massa gabungan
                    $mCombined[$intersectionKey] = ($mCombined[$intersectionKey] ?? 0) + ($mass1 * $mass2);
                }
            }
        }

        // Normalisasi
        $normalizedFactor = 1 - $k;
        if ($normalizedFactor <= 0) {
            // Ini adalah kasus konflik total atau mendekati total.
            // Dalam DS, jika K=1, kombinasi tidak terdefinisi.
            // Kita bisa mengembalikan error atau array kosong untuk menandakan konflik.
            return ['error' => 'Total conflict detected: ' . round($k, 4)];
        }

        foreach ($mCombined as $hypothesis => $mass) {
            $mCombined[$hypothesis] = round($mass / $normalizedFactor, 4);
        }

        return $mCombined;
    }

    /**
     * Mengkombinasikan multiple fungsi massa (BPA) secara berurutan.
     * Input diharapkan adalah array dari BPAs, di mana setiap BPA memiliki kunci JSON-encoded array.
     *
     * @param array $bpas Array of BPAs (e.g., [$bpaAkademik, $bpaMinat, $tesBpa])
     * @return array Fungsi massa hasil kombinasi akhir atau array dengan 'error'
     */
    public function combineEvidences(array $bpas): array
    {
        if (empty($bpas)) {
            return [];
        }

        // Inisialisasi dengan BPA pertama. Pastikan kunci sudah dalam format JSON-encoded array.
        // Jika ada BPA yang belum di-encode, ini akan meng-encode-nya.
        $combinedBPA = [];
        foreach ($bpas[0] as $key => $value) {
            $encodedKey               = is_array($key) ? json_encode($key) : json_encode([$key]);
            $combinedBPA[$encodedKey] = $value;
        }

        // Kombinasikan dengan BPA berikutnya secara berurutan
        for ($i = 1; $i < count($bpas); $i++) {
            $nextBPA = [];
            foreach ($bpas[$i] as $key => $value) {
                $encodedKey           = is_array($key) ? json_encode($key) : json_encode([$key]);
                $nextBPA[$encodedKey] = $value;
            }
            $combinedBPA = $this->combineTwoMassFunctions($combinedBPA, $nextBPA);

            // Handle jika ada konflik total di tengah proses kombinasi
            if (isset($combinedBPA['error'])) {
                return $combinedBPA;
            }
        }

        // Setelah semua kombinasi, pastikan nilai theta (jika ada) dihitung ulang
        // Sisa massa yang tidak dialokasikan ke singleton atau himpunan lain
        // akan secara implisit menjadi massa untuk himpunan kosong (ketidakpastian sisa).
        // Namun, dalam konteks ini, kita memastikan total massa adalah 1.
        // Jika ada himpunan kosong (misalnya '[]') dari kombinasi, itu adalah konflik.

        return $combinedBPA;
    }

    /**
     * Menentukan rekomendasi peminatan terbaik dari hasil kombinasi Dempster-Shafer.
     * Mengambil hipotesis tunggal (singleton) dengan nilai kepercayaan (mass) tertinggi.
     *
     * @param array $combinedBPA Fungsi massa hasil kombinasi (e.g., ['["AI"]' => 0.6, '["Jaringan"]' => 0.3, '["AI", "Jaringan", "Sistem Cerdas"]' => 0.1])
     * @return string Nama bidang rekomendasi (e.g., 'AI', 'Jaringan', 'Sistem Cerdas')
     */
    public function getRecommendation(array $combinedBPA): string
    {
        $bestBidang    = null;
        $highestBelief = -1;

        foreach ($combinedBPA as $hypothesisKey => $mass) {
            $hypothesisSet = json_decode($hypothesisKey, true);

            // Kita hanya tertarik pada hipotesis tunggal (singletons) untuk rekomendasi utama
            // Pastikan hipotesisSet bukan array kosong (yang merepresentasikan konflik atau ketidakpastian sisa)
            if (count($hypothesisSet) === 1 && ! empty($hypothesisSet[0])) {
                $bidang = $hypothesisSet[0];
                if ($mass > $highestBelief) {
                    $highestBelief = $mass;
                    $bestBidang    = $bidang;
                }
            }
        }

        return $bestBidang ?? 'Tidak dapat ditentukan';
    }
}
