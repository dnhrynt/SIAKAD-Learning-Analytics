<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class NilaiRapor extends Model
{
    protected $table = 'nilai_rapor';

    protected $casts = [
        'nilai_rapor' => 'float',
    ];

    protected $fillable = [
        'rombel_siswa_id',
        'guru_mapel_id',
        'nilai_rapor',
    ];

    public function rombelSiswa()
    {
        return $this->belongsTo(RombelSiswa::class, 'rombel_siswa_id', 'id');
    }

    public function guruMapel()
    {
        return $this->belongsTo(GuruMapel::class, 'guru_mapel_id', 'id');
    }
}
