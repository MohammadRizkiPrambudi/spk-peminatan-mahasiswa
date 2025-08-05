<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DempsterShaferResult extends Model
{
    use HasFactory;
    protected $fillable = ['mahasiswa_id', 'belief', 'plausibility'];

    protected $casts = [
        'belief'       => 'array',
        'plausibility' => 'array',
    ];

    public function mahasiswa()
    {
        return $this->belongsTo(Mahasiswa::class);
    }
}