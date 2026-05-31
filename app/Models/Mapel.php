<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Mapel extends Model
{
    protected $table = 'mapel';
    protected $fillable = [
        'kode_mapel',
        'nama_mapel',
    ];

    public function guruMapels()
    {
        return $this->hasMany(GuruMapel::class, 'mapel_id', 'id');
    }
}
