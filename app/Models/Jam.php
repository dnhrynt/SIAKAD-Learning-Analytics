<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Jam extends Model
{
    protected $table = 'jams';

    protected $fillable = [
        'jam_mulai',
        'jam_selesai',
    ];

    public function jadwal(){
        return $this->hasMany( Jadwal::class, 'jam_id', 'id');
    }
}