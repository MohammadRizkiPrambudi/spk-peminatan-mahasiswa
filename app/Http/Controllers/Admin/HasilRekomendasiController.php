<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\RekomendasiPeminatan;

class HasilRekomendasiController extends Controller
{
    public function index()
    {
        $data = RekomendasiPeminatan::with(['mahasiswa', 'mahasiswa.nilaiAkademik', 'mahasiswa.preferensiMinat', 'mahasiswa.tesBakat'])->get();
        return view('pages.hasil.index', compact('data'));
    }
}