<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Mahasiswa;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class MahasiswaController extends Controller
{
    public function index()
    {
        $data = Mahasiswa::with('user')->latest()->get();
        return view('pages.mahasiswa.index', compact('data'));
    }

    public function create()
    {
        return view('pages.mahasiswa.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama'     => 'required|string',
            'nim'      => 'required|unique:mahasiswa,nim',
            'prodi'    => 'required|string',
            'email'    => 'required|email|unique:users,email',
            'password' => 'required|min:6',
        ]);

        // Buat akun user
        $user = User::create([
            'name'     => $request->nama,
            'email'    => $request->email,
            'password' => Hash::make($request->password),
        ]);

        $user->assignRole('mahasiswa');

        // Simpan ke tabel mahasiswa
        Mahasiswa::create([
            'user_id' => $user->id,
            'nama'    => $request->nama,
            'nim'     => $request->nim,
            'prodi'   => $request->prodi,
        ]);

        return redirect()->route('admin.mahasiswa.index')->with('success', 'Data mahasiswa berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $mahasiswa = Mahasiswa::with('user')->findOrFail($id);
        return view('pages.mahasiswa.edit', compact('mahasiswa'));
    }

    public function update(Request $request, $id)
    {
        $mahasiswa = Mahasiswa::findOrFail($id);

        $request->validate([
            'nama'  => 'required|string',
            'nim'   => 'required|unique:mahasiswa,nim,' . $id,
            'prodi' => 'required|string',
        ]);

        $mahasiswa->update([
            'nama'  => $request->nama,
            'nim'   => $request->nim,
            'prodi' => $request->prodi,
        ]);

        // Jika user-nya juga ingin diperbarui (optional)
        if ($mahasiswa->user) {
            $mahasiswa->user->update([
                'name'  => $request->nama,
                'email' => $request->email,
            ]);
        }

        return redirect()->route('admin.mahasiswa.index')->with('success', 'Data berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $mahasiswa = Mahasiswa::findOrFail($id);
        $mahasiswa->delete();

        // Opsional: hapus juga user-nya
        if ($mahasiswa->user) {
            $mahasiswa->user->delete();
        }

        return redirect()->route('admin.mahasiswa.index')->with('success', 'Data berhasil dihapus.');
    }
}