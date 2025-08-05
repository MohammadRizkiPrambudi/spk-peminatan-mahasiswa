<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RekomendasiPeminatan extends Model
{
    use HasFactory;

    protected $table    = 'rekomendasi_peminatan';
    protected $fillable = ['mahasiswa_id', 'peminatan_utama', 'nilai_kepercayaan'];

    public function mahasiswa()
    {
        return $this->belongsTo(Mahasiswa::class);
    }
}