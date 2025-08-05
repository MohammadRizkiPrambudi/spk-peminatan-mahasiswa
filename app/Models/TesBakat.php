<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TesBakat extends Model
{
    use HasFactory;

    protected $table    = 'tes_bakat';
    protected $fillable = ['mahasiswa_id', 'kategori_bakat', 'skor'];

    public function mahasiswa()
    {
        return $this->belongsTo(Mahasiswa::class);
    }
}