<?php
namespace Database\Seeders;

use App\Models\FuzzyResult;
use App\Models\Mahasiswa;
use Illuminate\Database\Seeder;

class FuzzyResultSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $mhs = Mahasiswa::first();

        FuzzyResult::create([
            'mahasiswa_id' => $mhs->id,
            'output_fuzzy' => [
                'Pemrograman' => ['tinggi' => 0.7],
                'Jaringan'    => ['sedang' => 0.5],
                'Multimedia'  => ['rendah' => 0.2],
                'Akuntansi'   => ['sedang' => 0.4],
            ],
        ]);
    }
}