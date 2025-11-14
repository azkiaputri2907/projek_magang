<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SurveiKepuasan extends Model
{
    use HasFactory;

    protected $table = 'survei_kepuasan';

    protected $guarded = ['id']; // Membolehkan mass assignment untuk semua kolom kecuali 'id'

    public function pengunjung()
    {
        return $this->belongsTo(Pengunjung::class);
    }
}