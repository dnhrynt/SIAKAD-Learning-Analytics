<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Presensi extends Model
{
    protected $table = 'presensi';
    protected $fillable = [
        'rombel_siswa_id',
        'tanggal',
        'status',
    ];

    public function rombelSiswa()
    {
        return $this->belongsTo(RombelSiswa::class, 'rombel_siswa_id', 'id');
    }
}
