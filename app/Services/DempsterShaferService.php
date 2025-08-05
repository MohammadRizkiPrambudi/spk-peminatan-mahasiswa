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

        $normalized = [];
        $k          = 1 - $conflict;

        // Cegah pembagian dengan nol
        if ($k <= 0) {
            // fallback ke BPA awal jika semua konflik
            return $bpa1;
        }

        foreach ($result as $key => $val) {
            $normalized[$key] = round($val / $k, 6);
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