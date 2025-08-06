<?php
namespace App\Services;

use App\Models\FuzzyResult;
use App\Models\MatakuliahBidang;

class FuzzyLogicService
{
    private function fuzzyLinear($value, $low, $mid, $high)
    {
        if ($value <= $low) {
            return 0;
        } elseif ($value < $mid) {
            return ($value - $low) / ($mid - $low);
        } elseif ($value <= $high) {
            return ($high - $value) / ($high - $mid);
        }

        return 0;
    }

    private function fuzzifikasiNilai($nilai)
    {
        return [
            'rendah' => $this->fuzzyLinear($nilai, 0, 40, 60),
            'sedang' => $this->fuzzyLinear($nilai, 50, 65, 80),
            'tinggi' => $this->fuzzyLinear($nilai, 70, 85, 100),
        ];
    }

    private function bobotMinat($minat)
    {
        return match ($minat) {
            'rendah' => 0.2,
            'sedang' => 0.5,
            'tinggi' => 0.8,
            default => 0.0
        };
    }

    public function prosesFuzzifikasi(array $dataNilai, array $dataMinat, int $mahasiswaId): array
    {
        $output = [];

        foreach ($dataNilai as $matakuliah => $nilai) {
            $fuzzyTinggi = min($this->fuzzifikasiNilai($nilai)['tinggi'], 0.9);

            $mapping = MatakuliahBidang::where('matakuliah', $matakuliah)->get();

            foreach ($mapping as $map) {
                $bidang     = $map->bidang;
                $bobotMK    = $map->bobot;
                $bobotMinat = $this->bobotMinat($dataMinat[$bidang] ?? 'sedang');

                $bpa = $fuzzyTinggi * $bobotMinat * $bobotMK;

                $output[$bidang] = ($output[$bidang] ?? 0) + round($bpa, 4);
            }
        }

        // Normalisasi kalau total > 1
        $totalBpa = array_sum($output);
        if ($totalBpa > 1) {
            foreach ($output as $bidang => $nilai) {
                $output[$bidang] = round($nilai / $totalBpa, 4);
            }
            $totalBpa = array_sum($output);
        }

        // Tambahkan θ (ketidakpastian)
        $output['θ'] = max(0.05, round(1 - $totalBpa, 4));

        // Simpan ke database
        FuzzyResult::updateOrCreate(
            ['mahasiswa_id' => $mahasiswaId],
            ['output_fuzzy' => $output]
        );

        return $output;
    }

}