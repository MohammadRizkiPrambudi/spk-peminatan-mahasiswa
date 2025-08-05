<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Mahasiswa;
use App\Models\NilaiAkademik;
use App\Models\PreferensiMinat;
use App\Models\TesBakat;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        $user      = Auth::user();
        $mahasiswa = $user->mahasiswa;

        $chartData = DB::table('rekomendasi_peminatan')
            ->select('peminatan_utama', DB::raw('count(*) as jumlah'))
            ->groupBy('peminatan_utama')
            ->pluck('jumlah', 'peminatan_utama');

        $jumlahMahasiswa  = Mahasiswa::count();
        $jumlahNilai      = NilaiAkademik::count();
        $jumlahPreferensi = PreferensiMinat::count();
        $jumlahTesBakat   = TesBakat::count();
        $jumlahAdmin      = User::role('admin')->count();
        $jumlahMahasiswa  = User::role('mahasiswa')->count();

        return view('dashboard.index', compact(
            'jumlahMahasiswa',
            'jumlahNilai',
            'jumlahPreferensi',
            'jumlahTesBakat',
            'jumlahAdmin',
            'chartData',
        ));
    }

}