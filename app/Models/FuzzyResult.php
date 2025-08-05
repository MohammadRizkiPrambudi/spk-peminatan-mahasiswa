<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FuzzyResult extends Model
{
    use HasFactory;
    protected $fillable = ['mahasiswa_id', 'output_fuzzy'];

    protected $casts = [
        'output_fuzzy' => 'array',
    ];

    public function mahasiswa()
    {
        return $this->belongsTo(Mahasiswa::class);
    }
}