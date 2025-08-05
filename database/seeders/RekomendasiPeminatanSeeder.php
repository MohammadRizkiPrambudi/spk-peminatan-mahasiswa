<?php
namespace Database\Seeders;

use App\Models\Mahasiswa;
use App\Models\RekomendasiPeminatan;
use Illuminate\Database\Seeder;

class RekomendasiPeminatanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $mhs = Mahasiswa::first();

        RekomendasiPeminatan::create([
            'mahasiswa_id'      => $mhs->id,
            'peminatan_utama'   => 'Jaringan',
            'nilai_kepercayaan' => 0.5,
        ]);
    }
}