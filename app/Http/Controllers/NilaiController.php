<?php

namespace App\Http\Controllers;

use App\Models\GuruMapel;
use App\Models\Nilai;
use App\Models\RombelSiswa;
use App\Models\JenisPenilaian;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Services\PenilaianService;



class NilaiController extends Controller
{
    public function index(GuruMapel $guruMapel)
    {
        // Pastikan guru hanya melihat tugasnya
        
        if(Auth::user()->guru_id !== $guruMapel->guru_id) {
            abort(403, 'Unauthorized action.');
        }

        // Ambil rombel & mapel
        $rombel = $guruMapel->rombel;
        $mapel  = $guruMapel->mapel;

        // Ambil siswa dalam rombel
        $siswaList = RombelSiswa::with('siswa')
            ->where('rombel_id', $rombel->id)
            ->get();

        // Ambil TP + Jenis Penilaian sesuai guru_mapel
        $tujuanPembelajaran = $guruMapel->tujuanPembelajaran()
            ->with('jenisPenilaian')
            ->get();

        // Ambil semua nilai yang sudah ada
        $nilai = Nilai::whereIn(
                'rombel_siswa_id',
                $siswaList->pluck('id')
            )
            ->whereIn(
                'jenis_penilaian_id',
                $tujuanPembelajaran
                    ->pluck('jenisPenilaian')
                    ->flatten()
                    ->pluck('id')
            )
            ->get()
            ->keyBy(fn ($n) => $n->rombel_siswa_id.'-'.$n->jenis_penilaian_id);

        return view('nilai.index', compact(
            'guruMapel',
            'rombel',
            'mapel',
            'siswaList',
            'tujuanPembelajaran',
            'nilai'
        ));
    }


    public function store(
        Request $request,
        RombelSiswa $rombelSiswa,
        JenisPenilaian $jenisPenilaian,
        PenilaianService $penilaianService
    ) {
        $request->validate([
            'nilai' => ['required', 'numeric', 'min:0', 'max:100'],
        ]);

        Nilai::updateOrCreate(
            [
                'rombel_siswa_id'    => $rombelSiswa->id,
                'jenis_penilaian_id' => $jenisPenilaian->id,
            ],
            [
                'nilai' => $request->nilai,
            ]
        );

        // 🔥 HITUNG OTOMATIS (REAL-TIME)
        $penilaianService->hitungNilaiTP(
            $rombelSiswa->id,
            $jenisPenilaian->tujuan_pembelajaran_id
        );

        $penilaianService->hitungNilaiRapor(
            $rombelSiswa->id,
            $jenisPenilaian->tujuanPembelajaran->guru_mapel_id
        );

        return back()->with('success', 'Nilai berhasil disimpan');
    }



}
