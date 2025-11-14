<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pengunjung extends Model
{
    use HasFactory;

    protected $table = 'pengunjung';

    protected $fillable = [
        'tanggal',
        'nama_nip',
        'instansi',
        'layanan',
        'keperluan',
        'no_hp',
        'sudah_survey',
    ];

    public function survey()
    {
        return $this->hasOne(SurveiKepuasan::class);
    }
}