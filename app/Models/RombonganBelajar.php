<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RombonganBelajar extends Model
{
    protected $table = 'rombongan_belajar';

    protected $fillable = [
        'nama_rombel',
        'kelas_id',
        'tahun_ajaran_id',
        'wali_kelas_id',
    ];

    public function tahunAjaran()
    {
        return $this->belongsTo(TahunAjaran::class, 'tahun_ajaran_id', 'id');
    }

    public function kelas()
    {
        return $this->belongsTo(Kelas::class, 'kelas_id', 'id');
    }

    public function waliKelas()
    {
        return $this->belongsTo(Guru::class, 'wali_kelas_id', 'id');
    }

    public function rombelSiswa()
    {
        return $this->hasMany(RombelSiswa::class, 'rombel_id', 'id')
            ->orderBy(
                Siswa::select('nama_siswa')
                    ->whereColumn('siswa.id', 'rombel_siswa.siswa_id')
            );
    }

}
