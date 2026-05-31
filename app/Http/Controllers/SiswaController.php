<?php

namespace App\Http\Controllers;

use App\Models\Siswa;
use App\Models\RombelSiswa;
use App\Models\RombonganBelajar;
use App\Models\TahunAjaran;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Enums\UserRole;
use Illuminate\Support\Facades\Auth;


class SiswaController extends Controller
{
    /**
     * LIST SISWA (berbasis rombel_siswa)
     */
    public function index()
    {
        /** @var User $user */
        $user = Auth::user();
        $tahunAktif = TahunAjaran::where('status', 'Aktif')->firstOrFail();

        // WALI KELAS
        if ($user->hasRole(UserRole::WALI_KELAS)) {
            $rombel = RombonganBelajar::where('wali_kelas_id', $user->guru_id)
                ->where('tahun_ajaran_id', $tahunAktif->id)
                ->firstOrFail();

            $rombelSiswa = RombelSiswa::with('siswa')
                ->where('rombel_id', $rombel->id)
                ->orderBy(
                    Siswa::select('nama_siswa')
                        ->whereColumn('siswa.id', 'rombel_siswa.siswa_id')
                )
                ->get();


            return view('siswa.index', compact('rombelSiswa', 'rombel'));
        }

        abort(403);
    }

    public function indexAll(RombonganBelajar $rombel)
    {
        $rombelSiswa = RombelSiswa::with('siswa')
            ->where('rombel_id', $rombel->id)
            ->get()
            ->sortBy(fn($rs) => strtolower($rs->siswa->nama_siswa))
            ->values();
        
        return view('siswa.index-all', compact('rombel', 'rombelSiswa'));
    }


    /**
     * FORM TAMBAH SISWA
     */
    public function create()
    {
        /** @var User $user */
        $user = Auth::user();
        abort_if(!$user->hasRole(UserRole::WALI_KELAS), 403);

        return view('siswa.create');
    }

    /**
     * SIMPAN SISWA + ROMBEL SISWA
     */
    public function store(Request $request)
    {
        /** @var User $user */
        $user = Auth::user();
        abort_if(!$user->hasRole(UserRole::WALI_KELAS), 403);

        $request->validate([
            'nis' => 'required|unique:siswa,nis',
            'nama_siswa' => 'required',
            'jenis_kelamin' => 'required',
        ]);

        DB::transaction(function () use ($request) {

            /** @var User $user */
            $user = Auth::user();

            $tahunAktif = TahunAjaran::where('status', 'Aktif')->firstOrFail();

            $rombel = RombonganBelajar::where('wali_kelas_id', $user->guru_id)
                ->where('tahun_ajaran_id', $tahunAktif->id)
                ->firstOrFail();

            $siswa = Siswa::create($request->all());

            RombelSiswa::create([
                'rombel_id' => $rombel->id,
                'siswa_id' => $siswa->id,
                'status' => 'aktif',
            ]);
        });

        return redirect()->route('siswa.index')
            ->with('success', 'Siswa berhasil ditambahkan');
    }

    /**
     * FORM EDIT SISWA (MASTER)
     */
    public function edit(Siswa $siswa)
    {
        /** @var User $user */
        $user = Auth::user();
        abort_if(!$user->hasRole(UserRole::WALI_KELAS), 403);

        return view('siswa.edit', compact('siswa'));
    }

    /**
     * UPDATE MASTER SISWA
     */
    public function update(Request $request, Siswa $siswa)
    {
        /** @var User $user */
        $user = Auth::user();
        abort_if(!$user->hasRole(UserRole::WALI_KELAS), 403);

        $request->validate([
            'nis' => 'required|unique:siswa,nis,' . $siswa->id,
            'nama_siswa' => 'required',
        ]);

        $siswa->update($request->all());

        return redirect()->route('siswa.index')
            ->with('success', 'Data siswa diperbarui');
    }
}
