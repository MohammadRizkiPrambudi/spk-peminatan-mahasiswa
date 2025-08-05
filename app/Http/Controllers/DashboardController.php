<?php
namespace App\Http\Controllers;

use App\Models\PreferensiMinat;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $user      = Auth::user();
        $mahasiswa = $user->mahasiswa;

        $jumlahPreferensi = PreferensiMinat::count();
        $preferensi       = $mahasiswa->preferensiMinat()->first();
        $tesBakat         = $mahasiswa->tesBakat()->get();
        $nilaiAkademik    = $mahasiswa->nilaiAkademik()->get();
        $hasilRekomendasi = $mahasiswa->rekomendasiPeminatan()->first();

        return view('dashboard.mahasiswa', compact(
            'jumlahPreferensi',
            'preferensi',
            'tesBakat',
            'nilaiAkademik',
            'hasilRekomendasi'
        ));
    }
}