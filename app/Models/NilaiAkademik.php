<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NilaiAkademik extends Model
{
    use HasFactory;

    protected $table = 'nilai_akademik';

    protected $fillable = ['mahasiswa_id', 'matakuliah', 'nilai'];

    public function mahasiswa()
    {
        return $this->belongsTo(Mahasiswa::class);
    }
}