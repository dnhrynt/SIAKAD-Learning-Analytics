<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TahunAjaran extends Model
{
    protected $table = 'tahun_ajaran';

    protected $fillable = [
        'nama_tahun_ajaran',
        'semester',
        'status',
    ];

    public function rombonganBelajar()
    {
        return $this->hasMany(RombonganBelajar::class, 'tahun_ajaran_id');
    }
}
