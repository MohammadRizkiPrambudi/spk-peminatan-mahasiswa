<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MatakuliahBidang extends Model
{
    use HasFactory;
    protected $table = 'matakuliah_bidang';

    protected $fillable = ['matakuliah', 'bidang', 'bobot'];

    public $timestamps = true;
}