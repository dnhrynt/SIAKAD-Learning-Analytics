<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Siswa;
use App\Models\NilaiRapor;
use App\Models\RombelSiswa;

class RekapNilaiController extends Controller
{
    public function index(Request $request)
    {
        $siswaList = Siswa::when($request->q, function ($query) use ($request) {
            $query->where('nama_siswa', 'like', '%' . $request->q . '%');
        })
        ->orderBy('nama_siswa')
        ->get();

        return view('rekap_nilai.index', compact('siswaList'));
    }


    public function show(Siswa $siswa)
    {
        // Semua rombel yang pernah diikuti siswa
        $rombelSiswa = RombelSiswa::with([
            'rombonganBelajar.tahunAjaran',
            'rombonganBelajar',
        ])
        ->where('siswa_id', $siswa->id)
        ->get();

        // Tahun ajaran (kolom)
        $tahunAjaran = $rombelSiswa
            ->pluck('rombonganBelajar.tahunAjaran')
            ->unique('id')
            ->values();

        // Nilai rapor siswa
        $nilaiRapor = NilaiRapor::with([
                'guruMapel.mapel',
                'guruMapel.rombel.tahunAjaran'
            ])
            ->whereIn('rombel_siswa_id', $rombelSiswa->pluck('id'))
            ->get();

        /*
        Struktur:
        [mapel_id][tahun_ajaran_id] = nilai
        */
        $rekap = [];

        foreach ($nilaiRapor as $nr) {
            $mapelId = $nr->guruMapel->mapel->id;
            $taId    = $nr->guruMapel->rombel->tahun_ajaran_id;

            $rekap[$mapelId]['mapel'] = $nr->guruMapel->mapel->nama_mapel;
            $rekap[$mapelId]['nilai'][$taId] = $nr->nilai_rapor;
        }

        return view('rekap_nilai.show', compact(
            'siswa',
            'tahunAjaran',
            'rekap'
        ));
    }
}
