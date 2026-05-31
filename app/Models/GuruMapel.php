<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GuruMapel extends Model
{
    protected $table = 'guru_mapel';
    protected $fillable = [
        'guru_id',
        'mapel_id',
        'rombel_id',
        'kktp',
    ];

    public function guru()
    {
        return $this->belongsTo(Guru::class, 'guru_id', 'id');
    }

    public function mapel()
    {
        return $this->belongsTo(Mapel::class, 'mapel_id', 'id');
    }

    public function rombel()
    {
        return $this->belongsTo(RombonganBelajar::class, 'rombel_id', 'id');
    }

    public function jadwal()
    {
        return $this->hasMany(Jadwal::class, 'guru_mapel_id', 'id');
    }

    public function tujuanPembelajaran()
    {
        return $this->hasMany(TujuanPembelajaran::class, 'guru_mapel_id', 'id');
    }

    public function nilaiRapor()
    {
        return $this->hasMany(NilaiRapor::class, 'guru_mapel_id', 'id');
    }
}
