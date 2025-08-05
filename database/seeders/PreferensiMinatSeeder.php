<?php
namespace Database\Seeders;

use App\Models\Mahasiswa;
use App\Models\PreferensiMinat;
use Illuminate\Database\Seeder;

class PreferensiMinatSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $mhs = Mahasiswa::first();

        $bidangs = ['Pemrograman', 'Jaringan', 'Multimedia', 'Akuntansi'];
        $minats  = ['rendah', 'sedang', 'tinggi'];

        foreach ($bidangs as $bidang) {
            PreferensiMinat::create([
                'mahasiswa_id'  => $mhs->id,
                'bidang'        => $bidang,
                'tingkat_minat' => $minats[array_rand($minats)],
            ]);
        }
    }
}