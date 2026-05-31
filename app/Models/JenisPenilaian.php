<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class JenisPenilaian extends Model
{
    protected $table = 'jenis_penilaian';
    protected $fillable = [
        'tujuan_pembelajaran_id',
        'nama_jenis',
        'bobot',
    ];

    public function tujuanPembelajaran()
    {
        return $this->belongsTo(TujuanPembelajaran::class, 'tujuan_pembelajaran_id', 'id');
    }

    public function penilaians()
    {
        return $this->hasMany(Nilai::class, 'jenis_penilaian_id', 'id');
    }
}
