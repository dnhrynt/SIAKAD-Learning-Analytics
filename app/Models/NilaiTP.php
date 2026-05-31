<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class NilaiTP extends Model
{
    protected $table = 'nilai_tp';

    protected $casts = [
        'nilai' => 'float',
    ];

    protected $fillable = [
        'rombel_siswa_id',
        'tujuan_pembelajaran_id',
        'nilai',
    ];

    public function rombelSiswa()
    {
        return $this->belongsTo(RombelSiswa::class, 'rombel_siswa_id', 'id');
    }

    public function tujuanPembelajaran()
    {
        return $this->belongsTo(TujuanPembelajaran::class, 'tujuan_pembelajaran_id', 'id');
    }
}
