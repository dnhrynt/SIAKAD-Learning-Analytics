<?php

namespace App\Http\Controllers;

use App\Models\Presensi;
use App\Models\RombelSiswa;
use App\Models\RombonganBelajar;
use App\Models\User;
use App\Models\TahunAjaran;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Enums\UserRole;

class PresensiController extends Controller
{
    /**
     * Halaman pilih tanggal & daftar siswa rombel wali kelas
     */
    public function index(Request $request)
    {
        $user = Auth::user();
        $guruId = $user->guru_id;
    
        $tahunAktif = TahunAjaran::where('status', 'Aktif')->firstOrFail();
    
        // ambil rombel wali kelas di tahun ajaran aktif
        $rombel = RombonganBelajar::where('wali_kelas_id', $guruId)
            ->where('tahun_ajaran_id', $tahunAktif->id)
            ->firstOrFail();
    
        $tanggal = $request->tanggal ?? Carbon::today()->toDateString();
    
        $rombelSiswa = $rombel->rombelSiswa()
            ->where('status', 'aktif')
            ->with([
                'siswa',
                'presensi' => function ($q) use ($tanggal) {
                    $q->where('tanggal', $tanggal);
                }
            ])
            ->get();
    
        return view('presensi.index', compact(
            'rombel',
            'rombelSiswa',
            'tanggal'
        ));
    }


    /**
     * Simpan / update presensi harian
     */
    public function store(Request $request)
    {
        $request->validate([
            'tanggal' => 'required|date',
            'presensi' => 'required|array',
        ]);

        foreach ($request->presensi as $rombelSiswaId => $status) {
            Presensi::updateOrCreate(
                [
                    'rombel_siswa_id' => $rombelSiswaId,
                    'tanggal' => $request->tanggal,
                ],
                [
                    'status' => $status,
                ]
            );
        }

        return redirect()
            ->back()
            ->with('success', 'Presensi berhasil disimpan');
    }

    /**
     * Rekap presensi per siswa (opsional)
     */

public function rekap(Request $request)
{
    /** @var User $user */
    $user = Auth::user();
    $bulan = $request->bulan ?? now()->format('Y-m');

    // Role yang boleh melihat SEMUA rombel
    $roleSemuaRombel = [
        UserRole::KEPALA_SEKOLAH,
        UserRole::KURIKULUM,
        UserRole::GURU_BK,
    ];

    // Cek hak akses
    if (! $user->hasAnyRole(array_merge($roleSemuaRombel, [UserRole::WALI_KELAS]))) {
        abort(403, 'Tidak memiliki akses');
    }

    if ($user->hasAnyRole($roleSemuaRombel)) {

        // 🔹 Semua rombel
        $rombels = RombonganBelajar::with([
                'rombelSiswa' => function ($q) {
                    $q->where('status', 'aktif');
                },
                'rombelSiswa.siswa',
                'rombelSiswa.presensi',
            ])
            ->orderBy('nama_rombel')
            ->get();

    } else {

        // 🔹 Hanya rombel wali kelas
        $rombels = RombonganBelajar::where('wali_kelas_id', $user->guru_id)
            ->with([
                'rombelSiswa' => function ($q) {
                    $q->where('status', 'aktif');
                },
                'rombelSiswa.siswa',
                'rombelSiswa.presensi',
            ])
            ->get();
    }

    return view('presensi.rekap', compact(
        'rombels',
        'bulan'
    ));
}

    /**
     * Rekap presensi tahunan per rombel
     */

    public function rekapTahunan($rombelId)
    {
        $rombel = RombonganBelajar::with([
            'tahunAjaran',
            'rombelSiswa' => fn ($q) => $q->where('status', 'aktif'),
            'rombelSiswa.siswa',
            'rombelSiswa.presensi',
        ])->findOrFail($rombelId);
    
        // Ambil semua tanggal unik
        $tanggalList = Presensi::whereIn(
                'rombel_siswa_id',
                $rombel->rombelSiswa->pluck('id')
            )
            ->select('tanggal')
            ->distinct()
            ->orderBy('tanggal')
            ->pluck('tanggal');
    
        $tanggalPerBulan = $tanggalList->groupBy(function ($tgl) {
            return Carbon::parse($tgl)->format('Y-m');
        });
    
        return view('presensi.rekap-tahunan', compact(
            'rombel',
            'tanggalPerBulan'
        ));
    }



}
