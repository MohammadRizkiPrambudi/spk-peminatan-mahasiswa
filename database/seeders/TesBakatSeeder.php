<?php
namespace Database\Seeders;

use App\Models\Mahasiswa;
use App\Models\TesBakat;
use Illuminate\Database\Seeder;

class TesBakatSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $mhs = Mahasiswa::first();

        $bidangs = ['Pemrograman', 'Jaringan', 'Multimedia', 'Akuntansi'];

        foreach ($bidangs as $bidang) {
            TesBakat::create([
                'mahasiswa_id'   => $mhs->id,
                'kategori_bakat' => $bidang,
                'skor'           => rand(50, 100) / 100.0,
            ]);
        }
    }
}