<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Nilai extends Model
{
    protected $table = 'nilai';
    protected $fillable = [
        'rombel_siswa_id',
        'jenis_penilaian_id',
        'nilai',
    ];

    public function rombelSiswa()
    {
        return $this->belongsTo(RombelSiswa::class, 'rombel_siswa_id', 'id');
    }

    public function jenisPenilaian()
    {
        return $this->belongsTo(JenisPenilaian::class, 'jenis_penilaian_id', 'id');
    }
}
