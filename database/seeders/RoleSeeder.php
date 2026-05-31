<?php

namespace Database\Seeders;

use GuzzleHttp\Promise\Create;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
         DB::table('roles')->insert([
            ['nama_role' => 'Kepala Sekolah'],
            ['nama_role' => 'Kurikulum'],
            ['nama_role' => 'Wali Kelas'],
            ['nama_role' => 'Guru BK'],
            ['nama_role' => 'Guru Pengajar']
        ]);
    }
}
