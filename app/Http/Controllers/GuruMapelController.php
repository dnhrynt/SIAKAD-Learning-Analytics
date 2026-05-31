<?php

namespace App\Http\Controllers;

use App\Models\GuruMapel;
use App\Models\Guru;
use App\Models\Mapel;
use App\Models\RombonganBelajar;
use App\Models\TahunAjaran;
use App\Models\User;
use App\Enums\UserRole;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class GuruMapelController extends Controller
{
    public function index(Request $request)
{
    // Tahun ajaran aktif (default)
    $tahunAktif = TahunAjaran::where('status', 'Aktif')->first();
    $tahunId = $request->tahun_ajaran_id ?? $tahunAktif?->id;

    $tahunAjaranList = TahunAjaran::orderBy('nama_tahun_ajaran', 'desc')->get();

    $guruMapels = GuruMapel::with(['guru', 'mapel', 'rombel.tahunAjaran'])
        ->whereHas('rombel', function ($q) use ($tahunId) {
            $q->where('tahun_ajaran_id', $tahunId);
        })
        ->orderBy('rombel_id')
        ->get();

    return view('guru_mapel.index', compact(
        'guruMapels',
        'tahunAjaranList',
        'tahunId'
    ));
}


    public function create()
    {
        $tahunAktif = TahunAjaran::where('status', 'Aktif')->firstOrFail();
    
        return view('guru_mapel.create', [
            'guruList'   => Guru::orderBy('nama_guru')->get(),
            'mapelList'  => Mapel::orderBy('nama_mapel')->get(),
            'tahunAktif' => $tahunAktif,
    
            // ✅ sekarang variabelnya sudah ada
            'rombelList' => RombonganBelajar::where('tahun_ajaran_id', $tahunAktif->id)
                                ->orderBy('nama_rombel')
                                ->get(),
        ]);
    }


    public function store(Request $request)
    {
        $tahunAktif = TahunAjaran::where('status', 'Aktif')->firstOrFail();
        $request->validate([
            'guru_id' => 'required|exists:gurus,id',
            'mapel_id' => 'required|exists:mapel,id',
            'rombel_id' => 'required|array|min:1',
            'rombel_id.*' => [
                'exists:rombongan_belajar,id',
                Rule::exists('rombongan_belajar', 'id')
                    ->where('tahun_ajaran_id', $tahunAktif->id),
            ],
        ]);

        foreach ($request->rombel_id as $rombelId) {
        
            // Cek duplikat dulu biar gak double assign
            $sudahAda = GuruMapel::where('guru_id', $request->guru_id)
                ->where('mapel_id', $request->mapel_id)
                ->where('rombel_id', $rombelId)
                ->exists();
        
            if (!$sudahAda) {
                GuruMapel::create([
                    'guru_id'   => $request->guru_id,
                    'mapel_id'  => $request->mapel_id,
                    'rombel_id' => $rombelId,
                    'kktp'      => 0,
                ]);
            }
        }
    
        return redirect()->route('guru-mapel.index')
            ->with('success', 'Penugasan guru berhasil ditambahkan');
    }

    public function edit(GuruMapel $guruMapel)
    {
        return view('guru_mapel.edit', [
            'data'       => $guruMapel,
            'guruList'   => Guru::orderBy('nama_guru')->get(),
            'mapelList'  => Mapel::orderBy('nama_mapel')->get(),
            'rombelList' => RombonganBelajar::orderBy('nama_rombel')->get(),
        ]);
    }

public function update(Request $request, GuruMapel $guruMapel)
{
    /** @var User $user */
    $user = Auth::user();

    /**
     * ðŸŸ¢ MODE GURU PENGAJAR
     * Jika request membawa kktp â†’ ini konteks penilaian
     */
    if (
        $request->has('kktp')
        && $user->hasRole(UserRole::GURU_PENGAJAR)
        && $user->guru_id === $guruMapel->guru_id
    ) {

        $validated = $request->validate([
            'kktp' => 'required|integer|min:0|max:100',
        ]);

        $guruMapel->update([
            'kktp' => $validated['kktp'],
        ]);

        return back()->with('success', 'KKTp berhasil diperbarui');
    }

    /**
     * ðŸŸ¢ MODE KURIKULUM / ADMIN
     */
    if ($user->hasRole(UserRole::KURIKULUM)) {

        $validated = $request->validate([
            'guru_id'   => 'required|exists:gurus,id',
            'mapel_id'  => 'required|exists:mapel,id',
            'rombel_id' => 'required|exists:rombongan_belajar,id',
        ]);

        $guruMapel->update($validated);

        return back()->with('success', 'Penugasan guru berhasil diperbarui');
    }

    abort(403, 'Tidak memiliki hak akses');
}


    public function destroy(GuruMapel $guruMapel)
    {
        $guruMapel->delete();
        return back()->with('success', 'Data berhasil dihapus');
    }
}
