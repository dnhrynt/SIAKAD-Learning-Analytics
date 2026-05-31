<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Siswa extends Model
{
    protected $table = 'siswa';
    protected $guarded = [];

    protected $fillable = [
        'nis',
        'nama_siswa',
        'jenis_kelamin',
        'tempat_lahir',
        'tanggal_lahir',
        'agama',
        'alamat',
    ];

    public function rombelSiswa()
    {
        return $this->hasMany(RombelSiswa::class, 'siswa_id');
    }
}
