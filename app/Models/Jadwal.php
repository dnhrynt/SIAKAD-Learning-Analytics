<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Jadwal extends Model
{
    protected $table = 'jadwal';
    protected $fillable = [
        'guru_mapel_id',
        'hari_id',
        'jam_id'
    ];

    public function guruMapel()
    {
        return $this->belongsTo(GuruMapel::class, 'guru_mapel_id', 'id');
    }

    public function hari()
    {
        return $this->belongsTo(Hari::class, 'hari_id', 'id');
    }

    public function jam()
    {
        return $this->belongsTo( Jam::class, 'jam_id', 'id');
    }
}
