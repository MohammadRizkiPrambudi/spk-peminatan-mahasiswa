<?php
namespace App\Services;

use App\Models\DempsterShaferResult;
use App\Models\RekomendasiPeminatan;

class DempsterShaferService
{
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
        foreach ($result as $key => $val) {
            $normalized[$key] = $val / $k;
        }

        foreach ($normalized as $key => $val) {
            $normalized[$key] = round($val, 4);
        }

        $sum = array_sum($normalized);
        if ($sum > 1) {
            foreach ($normalized as $key => $val) {
                $normalized[$key] = round($val / $sum, 4);
            }
        }

        return $normalized;
    }

    public function simpanHasil(array $combined, int $mahasiswaId): array
    {
        $sorted    = collect($combined)->sortDesc();
        $topBidang = $sorted->keys()->first();
        $topNilai  = $sorted->values()->first();

        DempsterShaferResult::updateOrCreate(
            ['mahasiswa_id' => $mahasiswaId],
            [
                'belief'       => $combined,
                'plausibility' => $combined,
            ]
        );

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