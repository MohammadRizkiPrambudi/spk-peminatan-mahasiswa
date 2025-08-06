<?php
namespace App\Services;

use App\Models\MatakuliahBidang;

class FuzzyLogicService
{
    // Definisikan bidang-bidang peminatan sebagai array sederhana
    private $bidangPeminatan = ['AI', 'Jaringan', 'Sistem Cerdas'];

    /**
     * Menghitung BPA (Basic Probability Assignment) Akademik dari nilai dan bobot mata kuliah.
     * Logika ini didasarkan pada perhitungan "Total Kontribusi per Bidang (BPA) Akademik" di Excel.
     *
     * @param array $nilai_akademik - Array nilai dengan key mata kuliah (e.g., ['Algoritma dan Struktur Data' => 95, ...])
     * @return array BPA per bidang (dengan kunci string sederhana) dan BPA untuk ketidakpastian (theta)
     */
    public function calculateBpaAkademik(array $nilai_akademik): array
    {
        // Mendapatkan semua bobot mata kuliah per bidang dari database
        $bobot_matakuliah = MatakuliahBidang::all();

        // Inisialisasi total kontribusi per bidang
        $totalKontribusi        = array_fill_keys($this->bidangPeminatan, 0);
        $totalSeluruhKontribusi = 0;

        // Iterasi setiap mata kuliah yang ada di database
        foreach ($bobot_matakuliah as $item) {
            $mata_kuliah = $item->matakuliah;
            $bidang      = $item->bidang;
            $bobot       = $item->bobot;

            // Periksa apakah nilai mata kuliah tersebut ada di data mahasiswa
            if (isset($nilai_akademik[$mata_kuliah])) {
                $nilai = $nilai_akademik[$mata_kuliah];

                // Hitung kontribusi (Nilai x Bobot)
                $kontribusi = $nilai * $bobot;

                // Tambahkan ke total kontribusi per bidang
                $totalKontribusi[$bidang] += $kontribusi;
            }
        }

        // Hitung total seluruh kontribusi
        $totalSeluruhKontribusi = array_sum($totalKontribusi);

        // Jika total kontribusi 0, semua kepercayaan dialihkan ke ketidakpastian (theta)
        if ($totalSeluruhKontribusi == 0) {
            $bpa       = array_fill_keys($this->bidangPeminatan, 0.00);
            $bpa['θ'] = 1.00; // Semua massa ke theta
            return $bpa;
        }

        // Hitung BPA dengan menormalisasi kontribusi
        $bpa             = [];
        $sumOfSingletons = 0;
        foreach ($totalKontribusi as $bidang => $kontribusi) {
            $mass         = round($kontribusi / $totalSeluruhKontribusi, 4);
            $bpa[$bidang] = $mass; // Kunci adalah string sederhana
            $sumOfSingletons += $mass;
        }

        // Tambahkan BPA untuk ketidakpastian (theta)
        $bpa['θ'] = round(1 - $sumOfSingletons, 4);

        return $bpa;
    }

    /**
     * Menghitung BPA (Basic Probability Assignment) untuk Minat dan Bakat.
     * Logika ini mengasumsikan bahwa preferensi minat adalah BPA yang sudah dinormalisasi.
     *
     * @param array $minat_bakat - Array minat dengan key bidang (e.g., ['AI' => 70, 'Jaringan' => 75, ...])
     * @return array BPA per bidang (dengan kunci string sederhana) dan BPA untuk ketidakpastian (theta)
     */
    public function calculateBpaMinatBakat(array $minat_bakat): array
    {
        // Hitung total skor minat bakat
        $totalSkor = array_sum($minat_bakat);

        // Jika total skor 0, semua kepercayaan dialihkan ke ketidakpastian (theta)
        if ($totalSkor == 0) {
            $bpa       = array_fill_keys($this->bidangPeminatan, 0.00);
            $bpa['θ'] = 1.00; // Semua massa ke theta
            return $bpa;
        }

        // Hitung BPA dengan menormalisasi skor minat
        $bpa             = [];
        $sumOfSingletons = 0;
        foreach ($minat_bakat as $bidang => $skor) {
            $mass         = round($skor / $totalSkor, 4);
            $bpa[$bidang] = $mass; // Kunci adalah string sederhana
            $sumOfSingletons += $mass;
        }

        // Tambahkan BPA untuk ketidakpastian (theta)
        $bpa['θ'] = round(1 - $sumOfSingletons, 4);

        return $bpa;
    }
}
