<?php
namespace Database\Seeders;

use App\Models\DempsterShaferResult;
use App\Models\Mahasiswa;
use Illuminate\Database\Seeder;

class DempsterShaferResultSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $mhs = Mahasiswa::first();

        DempsterShaferResult::create([
            'mahasiswa_id' => $mhs->id,
            'belief'       => [
                'Pemrograman' => 0.3,
                'Jaringan'    => 0.5,
                'Multimedia'  => 0.15,
                'Akuntansi'   => 0.05,
            ],
            'plausibility' => [
                'Pemrograman' => 0.6,
                'Jaringan'    => 0.7,
                'Multimedia'  => 0.4,
                'Akuntansi'   => 0.2,
            ],
        ]);
    }
}