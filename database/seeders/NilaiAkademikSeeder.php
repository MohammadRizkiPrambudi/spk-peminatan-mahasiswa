<?php
namespace Database\Seeders;

use App\Models\Mahasiswa;
use App\Models\NilaiAkademik;
use Illuminate\Database\Seeder;

class NilaiAkademikSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $mhs = Mahasiswa::first();

        $matkuls = ['Pemrograman', 'Jaringan', 'Multimedia', 'Basis Data'];

        foreach ($matkuls as $matkul) {
            NilaiAkademik::create([
                'mahasiswa_id' => $mhs->id,
                'matakuliah'   => $matkul,
                'nilai'        => rand(60, 100),
            ]);
        }
    }
}