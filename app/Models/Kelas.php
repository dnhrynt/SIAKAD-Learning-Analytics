<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Kelas extends Model
{
    protected $table = 'kelas';
    protected $fillable = [
        'nama_kelas',
    ];

    public function rombel()
    {
        return $this->hasMany(RombonganBelajar::class, 'kelas_id', 'id');
    }
}
