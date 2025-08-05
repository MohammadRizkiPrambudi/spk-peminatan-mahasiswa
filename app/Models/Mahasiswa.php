<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

// app/Models/Mahasiswa.php
class Mahasiswa extends Model
{
    use HasFactory;

    protected $table    = 'mahasiswa';
    protected $fillable = ['user_id', 'nama', 'nim', 'prodi'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function nilaiAkademik()
    {
        return $this->hasMany(NilaiAkademik::class);
    }

    public function preferensiMinat()
    {
        return $this->hasMany(PreferensiMinat::class);
    }

    public function tesBakat()
    {
        return $this->hasMany(TesBakat::class);
    }

    public function rekomendasiPeminatan()
    {
        return $this->hasOne(RekomendasiPeminatan::class, 'mahasiswa_id');
    }
}