<?php
namespace App\Services;

use App\Models\FuzzyResult;
use App\Models\MatakuliahBidang;

class FuzzyLogicService
{
    /**
     * Fungsi fuzzifikasi: jika nilai >=70 dianggap tinggi penuh (1.0)
     */
    private function fuzzifikasiNilai($nilai)
    {
        $tinggi = $nilai >= 70 ? 1.0 : 0.0;

        return [
            'rendah' => 0,
            'sedang' => 0,
            'tinggi' => $tinggi,
        ];
    }

    /**
     * Bobot minat (kalau mau pakai 0.8 untuk tinggi, ganti di sini)
     */
    private function bobotMinat($minat)
    {
        return match ($minat) {
            'rendah' => 0.2,
            'sedang' => 0.5,
            'tinggi' => 1.0,
            default => 0.0,
        };
    }

    /**
     * Proses fuzzifikasi nilai dan minat
     */
    // public function prosesFuzzifikasi(array $dataNilai, array $dataMinat, int $mahasiswaId): array
    // {
    //     $output = [];

    //     foreach ($dataNilai as $matakuliah => $nilai) {
    //         $fuzzyTinggi = $this->fuzzifikasiNilai($nilai)['tinggi'];

    //         // Ambil mapping matakuliah ke bidang
    //         $mapping = MatakuliahBidang::where('matakuliah', $matakuliah)->get();

    //         foreach ($mapping as $map) {
    //             $bidang     = $map->bidang;
    //             $bobotMK    = $map->bobot;
    //             $bobotMinat = $this->bobotMinat($dataMinat[$bidang] ?? 'sedang');

    //             $bpa = $fuzzyTinggi * $bobotMinat * $bobotMK;

    //             // Akumulasi BPA per bidang
    //             $output[$bidang] = ($output[$bidang] ?? 0) + round($bpa, 3);
    //         }
    //     }

    //     // Normalisasi kalau total >1
    //     $totalBpa = array_sum($output);
    //     if ($totalBpa > 1) {
    //         foreach ($output as $bidang => $nilai) {
    //             $output[$bidang] = round($nilai / $totalBpa, 3);
    //         }
    //         $totalBpa = array_sum($output);
    //     }

    //     // Tambahkan theta (ketidakpastian)
    //     $output['θ'] = round(1 - $totalBpa, 3);

    //     // Simpan ke database
    //     FuzzyResult::updateOrCreate(
    //         ['mahasiswa_id' => $mahasiswaId],
    //         ['output_fuzzy' => $output]
    //     );

    //     return $output;
    // }

    public function prosesFuzzifikasi(array $dataNilai, array $dataMinat, int $mahasiswaId): array
    {
        $output = [];

        foreach ($dataNilai as $matakuliah => $nilai) {
            $fuzzyTinggi = $this->fuzzifikasiNilai($nilai)['tinggi'];

            $mapping = MatakuliahBidang::where('matakuliah', $matakuliah)->get();

            foreach ($mapping as $map) {
                $bidang  = $map->bidang;
                $bobotMK = $map->bobot;

                // HILANGKAN pengaruh minat
                $bpa = $fuzzyTinggi * $bobotMK;

                $output[$bidang] = ($output[$bidang] ?? 0) + round($bpa, 3);
            }
        }

        // Normalisasi jika total > 1
        $totalBpa = array_sum($output);
        if ($totalBpa > 1) {
            foreach ($output as $bidang => $nilai) {
                $output[$bidang] = round($nilai / $totalBpa, 3);
            }
            $totalBpa = array_sum($output);
        }

        // Tambahkan θ (ketidakpastian)
        $output['θ'] = round(1 - $totalBpa, 3);

        // Simpan ke database
        FuzzyResult::updateOrCreate(
            ['mahasiswa_id' => $mahasiswaId],
            ['output_fuzzy' => $output]
        );

        return $output;
    }

}