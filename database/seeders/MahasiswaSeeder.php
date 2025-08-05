<?php
namespace Database\Seeders;

use App\Models\Mahasiswa;
use App\Models\User;
use Illuminate\Database\Seeder;

class MahasiswaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $user = User::where('email', 'mahasiswa@example.com')->first();

        Mahasiswa::create([
            'user_id' => $user->id,
            'nama'    => 'Bahrul Ulum',
            'nim'     => '23206052008',
            'prodi'   => 'Teknik Informatika',
        ]);
    }
}