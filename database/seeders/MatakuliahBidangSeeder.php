<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MatakuliahBidangSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('matakuliah_bidang')->insert([
            [
                'matakuliah' => 'Algoritma dan Struktur Data',
                'bidang'     => 'AI',
                'bobot'      => 0.6,
            ],
            [
                'matakuliah' => 'Algoritma dan Struktur Data',
                'bidang'     => 'Sistem Cerdas',
                'bobot'      => 0.4,
            ],
            [
                'matakuliah' => 'Jaringan Komputer',
                'bidang'     => 'Jaringan',
                'bobot'      => 1,
            ],
            [
                'matakuliah' => 'Grafika Komputer',
                'bidang'     => 'AI',
                'bobot'      => 1,
            ],
            [
                'matakuliah' => 'Pemrograman Jaringan',
                'bidang'     => 'Jaringan',
                'bobot'      => 1,
            ],
        ]);
    }
}