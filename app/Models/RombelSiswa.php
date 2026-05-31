<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RombelSiswa extends Model
{
    protected $table = 'rombel_siswa';
    protected $fillable = [
        'rombel_id',
        'siswa_id',
        'status',
    ];

    public function siswa()
    {
        return $this->belongsTo(Siswa::class, 'siswa_id');
    }

    public function rombonganBelajar()
    {
        return $this->belongsTo(RombonganBelajar::class, 'rombel_id');
    }

    public function nilaiTP()
    {
        return $this->hasMany(NilaiTP::class, 'rombel_siswa_id', 'id');
    }

    public function nilaiRapor()
    {
        return $this->hasMany(NilaiRapor::class, 'rombel_siswa_id', 'id');
    }

    public function nilai()
    {
        return $this->hasMany(Nilai::class, 'rombel_siswa_id', 'id');
    }

    public function presensi()
    {
        return $this->hasMany(Presensi::class, 'rombel_siswa_id', 'id');
    }
}
