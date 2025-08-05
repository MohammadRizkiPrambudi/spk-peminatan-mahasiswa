<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PreferensiMinat extends Model
{
    use HasFactory;

    protected $table    = 'preferensi_minat';
    protected $fillable = ['mahasiswa_id', 'bidang', 'tingkat_minat'];

    public function mahasiswa()
    {
        return $this->belongsTo(Mahasiswa::class);
    }
}