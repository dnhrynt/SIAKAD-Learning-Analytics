<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TujuanPembelajaran extends Model
{
    protected $table = 'tujuan_pembelajaran';

    protected $fillable = [
        'guru_mapel_id',
        'nama_tujuan',
        'deskripsi',
    ];

    public function guruMapel()
    {
        return $this->belongsTo(GuruMapel::class, 'guru_mapel_id');
    }

    public function jenisPenilaian()
    {
        return $this->hasMany(JenisPenilaian::class, 'tujuan_pembelajaran_id');
    }

   
}
