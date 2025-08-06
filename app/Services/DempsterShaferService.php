<?php
namespace App\Services;

use App\Models\DempsterShaferResult;
use App\Models\RekomendasiPeminatan;

class DempsterShaferService
{
    /**
     * Menggabungkan 2 BPA (basic probability assignment)
     */
    public function combine(array $bpa1, array $bpa2): array
    {
        $result   = [];
        $conflict = 0;

        foreach ($bpa1 as $aKey => $aVal) {
            foreach ($bpa2 as $bKey => $bVal) {
                $aSet         = explode(',', $aKey);
                $bSet         = explode(',', $bKey);
                $intersection = array_intersect($aSet, $bSet);

                if (count($intersection) > 0) {
                    $key          = implode(',', $intersection);
                    $result[$key] = ($result[$key] ?? 0) + ($aVal * $bVal);
                } else {
                    $conflict += ($aVal * $bVal);
                }
            }
        }

        $k = 1 - $conflict;

        if ($k <= 0) {
            return $bpa1;
        }

        $normalized = [];
        $total      = 0;

        foreach ($result as $key => $val) {
            $norm = $val / $k;

            // BATASI agar tidak lebih dari 0.95 per bidang
            if ($norm > 0.95) {
                $norm = 0.95;
            }

            $normalized[$key] = round($norm, 6);
            $total += $normalized[$key];
        }

        // Pastikan ada theta (ketidakpastian) jika total < 1
        if (! isset($normalized['θ'])) {
            $normalized['θ'] = 0;
        }

        if ($total < 1) {
            $normalized['θ'] += round(1 - $total, 6);
        }

        // Normalisasi ulang jika tetap over 1 (cadangan jaga-jaga)
        $sum = array_sum($normalized);
        if ($sum > 1) {
            foreach ($normalized as $k => $v) {
                $normalized[$k] = round($v / $sum, 6);
            }
        }

        return $normalized;
    }

    /**
     * Simpan ke database hasil DS dan rekomendasi
     */
    public function simpanHasil(array $combined, int $mahasiswaId): array
    {
        $sorted    = collect($combined)->sortDesc();
        $topBidang = $sorted->keys()->first();
        $topNilai  = $sorted->values()->first();

        // Simpan ke dempster_shafer_results
        DempsterShaferResult::updateOrCreate(
            ['mahasiswa_id' => $mahasiswaId],
            [
                'belief'       => $combined,
                'plausibility' => $combined, // sederhananya disamakan dulu
            ]
        );

        // Simpan ke rekomendasi jika valid
        if ($topBidang !== 'θ' && $topNilai > 0) {
            RekomendasiPeminatan::updateOrCreate(
                ['mahasiswa_id' => $mahasiswaId],
                [
                    'peminatan_utama'   => $topBidang,
                    'nilai_kepercayaan' => $topNilai,
                ]
            );
        }

        return [
            'rekomendasi' => $topBidang,
            'kepercayaan' => $topNilai,
            'semua'       => $combined,
        ];
    }
}