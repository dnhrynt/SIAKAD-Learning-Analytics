<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;

class GuruSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('gurus')->insert([
            'nip'=> '123456',
            'nama_guru'=> 'ida karyati, S. Pd.',
            'jenis_kelamin'=> 'Perempuan',
            'tempat_lahir'=> 'Tuban',
            'tanggal_lahir'=> Carbon::create(1988, 5, 12),
            'agama'=> 'Kristen',
            'alamat'=> 'Jalan Gajah Mada No. 22',
            'no_telp'=> '087811936544'
        ]);
    }
}
