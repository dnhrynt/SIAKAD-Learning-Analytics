<?php

namespace App\Http\Controllers;

use App\Models\RombelSiswa;
use App\Models\RombonganBelajar;
use App\Models\TahunAjaran;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Enums\UserRole;

class KenaikanKelasController extends Controller
{
    /**
     * FORM KENAIKAN KELAS
     */
    public function index()
    {
        /** @var User $user */
        $user = Auth::user();
        abort_if(!$user->hasRole(UserRole::WALI_KELAS), 403);

        $tahunAktif = TahunAjaran::where('status', 'Aktif')->firstOrFail();

        $rombelAsal = RombonganBelajar::where('wali_kelas_id', $user->guru_id)
            ->where('tahun_ajaran_id', $tahunAktif->id)
            ->firstOrFail();

        $siswaAktif = RombelSiswa::with('siswa')
            ->where('rombel_id', $rombelAsal->id)
            ->where('status', 'aktif')
            ->get();

        // rombel tujuan = rombel tahun ajaran SELANJUTNYA
        $rombelsTujuan = RombonganBelajar::where('tahun_ajaran_id', '!=', $tahunAktif->id)
            ->orderBy('nama_rombel')
            ->get();

        return view('kenaikan-kelas.index', compact(
            'rombelAsal',
            'siswaAktif',
            'rombelsTujuan'
        ));
    }

    /**
     * PROSES KENAIKAN KELAS MASSAL
     */
    public function proses(Request $request)
    {
        $request->validate([
            'siswa_ids' => 'required|array',
            'rombel_tujuan_id' => 'required|exists:rombongan_belajar,id',
        ]);
    
        /** @var User $user */
        $user = Auth::user();
        abort_if(!$user->hasRole(UserRole::WALI_KELAS), 403);
    
        $tahunAktif = TahunAjaran::where('status', 'Aktif')->firstOrFail();
    
        $rombelAsal = RombonganBelajar::where('wali_kelas_id', $user->guru_id)
            ->where('tahun_ajaran_id', $tahunAktif->id)
            ->firstOrFail();
    
        DB::transaction(function () use ($request, $rombelAsal) {
    
            foreach ($request->siswa_ids as $siswaId) {
    
                // insert ke rombel baru
                RombelSiswa::firstOrCreate([
                    'rombel_id' => $request->rombel_tujuan_id,
                    'siswa_id'  => $siswaId,
                ], [
                    'status' => 'aktif',
                ]);
    
                // update status di rombel lama
                RombelSiswa::where('rombel_id', $rombelAsal->id)
                    ->where('siswa_id', $siswaId)
                    ->update(['status' => 'naik']);
            }
        });
    
        return redirect()
            ->route('siswa.index')
            ->with('success', 'Kenaikan kelas berhasil diproses');
    }

    public function preview(RombonganBelajar $rombel)
    {
        // Ambil siswa aktif
        $siswa = RombelSiswa::with('siswa')
            ->where('rombel_id', $rombel->id)
            ->where('status', 'aktif')
            ->get();

        // Ambil tahun ajaran berikutnya (TANPA fail)
        $tahunTujuan = TahunAjaran::where('id', '>', $rombel->tahun_ajaran_id)
            ->orderBy('id')
            ->first();

        // Default kosong
        $rombelTujuan = collect();

        // Kalau ada tahun tujuan, baru ambil rombel
        if ($tahunTujuan) {
            $rombelTujuan = RombonganBelajar::where('tahun_ajaran_id', $tahunTujuan->id)
                ->get();
        }

        return view('kenaikan_kelas.preview', compact(
            'rombel',
            'siswa',
            'rombelTujuan',
            'tahunTujuan'
        ));
    }


}

