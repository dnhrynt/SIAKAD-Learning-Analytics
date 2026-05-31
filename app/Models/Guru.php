<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Guru extends Model
{
    protected $fillable = [
        'nip',
        'nama_guru',
        'jenis_kelamin',
        'tempat_lahir',
        'tanggal_lahir',
        'agama',
        'alamat',
        'no_telp',
    ];

    public function user()
    {
        return $this->hasOne(User::class, 'guru_id', 'id');
    }

    public function mapels()
    {
        return $this->hasMany(GuruMapel::class, 'guru_id', 'id');
    }

    public function waliKelas()
    {
        return $this->hasMany(RombonganBelajar::class, 'wali_kelas_id', 'id');
    }
}

