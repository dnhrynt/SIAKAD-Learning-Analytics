<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Enums\UserRole;
use App\Models\User;

class SidebarController extends Controller
{
    public static function menu()
    {
        /** @var User $user */
        $user = Auth::user();

        $roleMenus = [
            1 => [ // Kepala Sekolah
                ['label'=>'Home','route'=>'dashboard','icon'=>'bi-house'],
                ['label'=>'Guru','route'=>'guru.index','icon'=>'bi-person-badge'],
                ['label'=>'User','route'=>'users.index','icon'=>'bi-people'],
                ['label'=>'Kelas','route'=>'rombel.index','icon'=>'bi-door-open'],
                ['label'=>'Jadwal Pelajaran','route'=>'jadwal.index','icon'=>'bi-calendar-week'],
                ['label'=>'Dashboard Analitik','route'=>'dashboard.analitik.index','icon'=>'bi-bar-chart'],
            ],
            2 => [ // Kurikulum
                ['label'=>'Home','route'=>'dashboard','icon'=>'bi-house'],
                ['label'=>'Tahun Ajaran','route'=>'tahun-ajaran.index','icon'=>'bi-calendar'],
                ['label'=>'Manajemen Kelas','route'=>'rombel.index','icon'=>'bi-door-open'],
                ['label'=>'Mata Pelajaran','route'=>'mapel.index','icon'=>'bi-book'],
                ['label'=>'Penugasan Guru','route'=>'guru-mapel.index','icon'=>'bi-person-check'],
                ['label'=>'Manajemen Jadwal','route'=>'jadwal.index','icon'=>'bi-calendar-week'],
                ['label'=>'Dashboard Analitik','route'=>'dashboard.analitik.index','icon'=>'bi-bar-chart'],
            ],
            3 => [ // Wali Kelas
                ['label'=>'Home','route'=>'dashboard','icon'=>'bi-house'],
                ['label'=>'Siswa Saya','route'=>'siswa.index','icon'=>'bi-people'],
                ['label'=>'Jadwal Kelas','route'=>'jadwal.index','icon'=>'bi-calendar-event'],
                ['label'=>'Dashboard Analitik','route'=>'dashboard.analitik.index','icon'=>'bi-bar-chart'],
            ],
            4 => [ // Guru BK
                ['label'=>'Home','route'=>'dashboard','icon'=>'bi-house'],
                ['label'=>'Dashboard Analitik','route'=>'dashboard.analitik.index','icon'=>'bi-bar-chart'],
                ['label'=>'Rekap Nilai Siswa','route'=>'rekap-nilai.index','icon'=>'bi-file-earmark-bar-graph'],
            ],
            5 => [ // Guru Pengajar
                ['label'=>'Home','route'=>'dashboard','icon'=>'bi-house'],
                ['label'=>'Jadwal Mengajar','route'=>'jadwal.mengajar','icon'=>'bi-calendar-check'],
                ['label'=>'Dashboard Analitik','route'=>'dashboard.analitik.index','icon'=>'bi-bar-chart'],
            ],
        ];

        $menus = [];

        foreach ($user->roles as $role) {
            foreach ($roleMenus[$role->id] ?? [] as $menu) {
                // key by route supaya tidak dobel
                $menus[$menu['route']] = $menu;
            }
        }

        return array_values($menus);
    }
}
