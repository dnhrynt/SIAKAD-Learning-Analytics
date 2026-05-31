<?php

namespace App\Http\Controllers;

use App\Models\Jadwal;
use App\Models\TahunAjaran;
use App\Enums\UserRole;
use App\Models\RombonganBelajar;
use App\Models\User;
use App\Models\GuruMapel;
use App\Models\Hari;
use App\Models\Jam;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;


class JadwalController extends Controller
{
    /**
     * JADWAL UMUM
     * Role 1, 2, 3
     */
    public function index()
    {
        /** @var User $user */
        $user = Auth::user();
        $guru = $user->guru;

        $tahunAktif = TahunAjaran::where('status', 'aktif')->firstOrFail();

        $query = $this->baseQuery($tahunAktif);

        $rombels = RombonganBelajar::where('tahun_ajaran_id', $tahunAktif->id)
            ->orderBy('nama_rombel')
            ->get();

        // 🟢 Kepala Sekolah & Kurikulum → full access
        if ($user->hasAnyRole([
            UserRole::KEPALA_SEKOLAH,
            UserRole::KURIKULUM,
        ])) {
            // tidak dibatasi
        }

        // 🟡 Wali Kelas → hanya rombel wali
        elseif ($user->hasRole(UserRole::WALI_KELAS)) {
            $query->whereHas('guruMapel.rombel', function ($q) use ($guru) {
                $q->where('wali_kelas_id', $guru->id);
            });
        }

        // 🔴 selain itu ditolak
        else {
            abort(403);
        }

        $jadwal = $query
            ->orderBy('hari_id')
            ->orderBy('jam_id')
            ->get()
            ->groupBy('hari.nama_hari');

        return view('jadwal.index', compact(
            'jadwal',
            'tahunAktif',
            'rombels'
        ));
    }

    /**
     * JADWAL MENGAJAR SAYA
     * Role 5
     */
    public function mengajar()
    {
        /** @var User $user */
        $user = Auth::user();
        $guru = $user->guru;

        abort_if(
            !$user->hasRole(UserRole::GURU_PENGAJAR),
            403
        );

        $tahunAktif = TahunAjaran::where('status', 'aktif')->firstOrFail();

        $jadwal = $this->baseQuery($tahunAktif)
            ->whereHas('guruMapel', function ($q) use ($guru) {
                $q->where('guru_id', $guru->id);
            })
            ->orderBy('hari_id')
            ->orderBy('jam_id')
            ->get()
            ->groupBy('hari.nama_hari');

        return view('jadwal.mengajar', compact(
            'jadwal',
            'tahunAktif'
        ));
    }


    /**
     * QUERY DASAR JADWAL
     */
    private function baseQuery($tahunAktif)
    {
        return Jadwal::with([
            'hari',
            'jam',
            'guruMapel.mapel',
            'guruMapel.guru',
            'guruMapel.rombel'
        ])
        ->whereHas('guruMapel.rombel', function ($q) use ($tahunAktif) {
            $q->where('tahun_ajaran_id', $tahunAktif->id);
        });
    }

    public function create()
    {
        $tahunAktif = TahunAjaran::where('status', 'aktif')->firstOrFail();
    
        $rombels = RombonganBelajar::where('tahun_ajaran_id', $tahunAktif->id)
            ->orderBy('nama_rombel')
            ->get();
    
        $guruMapel = GuruMapel::with(['mapel', 'guru'])->get();
    
        $hari = Hari::orderBy('id')->get();
        $jam  = Jam::orderBy('jam_mulai')->get();
    
        return view('jadwal.create', compact(
            'tahunAktif',
            'rombels',
            'guruMapel',
            'hari',
            'jam'
        ));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'hari_id' => 'required|exists:hari,id',
            'jam_id'  => 'required|array|min:1',
            'jam_id.*'=> 'exists:jams,id',
        
            'guru_mapel_id'   => 'nullable|array',
            'guru_mapel_id.*' => 'nullable|exists:guru_mapel,id',
        ]);

        foreach ($data['guru_mapel_id'] as $rombelId => $guruMapelId) {
        
            // ⛔ Lewati kalau tidak dipilih mapel
            if (!$guruMapelId) continue;
        
            foreach ($data['jam_id'] as $jamId) {
        
                // Cek bentrok rombel
                $bentrok = Jadwal::where('hari_id', $data['hari_id'])
                    ->where('jam_id', $jamId)
                    ->whereHas('guruMapel', function ($q) use ($rombelId) {
                        $q->where('rombel_id', $rombelId);
                    })
                    ->exists();
        
                if ($bentrok) {
                    return back()->withErrors([
                        'jam_id' => "Bentrok jadwal di salah satu jam untuk rombel terkait"
                    ])->withInput();
                }
        
                Jadwal::create([
                    'guru_mapel_id' => $guruMapelId,
                    'hari_id'       => $data['hari_id'],
                    'jam_id'        => $jamId,
                ]);
            }
        }

        return redirect()
            ->route('jadwal.index')
            ->with('success', 'Jadwal berhasil ditambahkan');
    }


    public function edit(Jadwal $jadwal)
    {

        $tahunAktif = TahunAjaran::where('status', 'aktif')->firstOrFail();

        $guruMapel = GuruMapel::with(['guru', 'mapel', 'rombel'])
            ->whereHas('rombel', fn ($q) => $q->where('tahun_ajaran_id', $tahunAktif->id))
            ->get();

        $hari = Hari::orderBy('id')->get();
        $jam  = Jam::orderBy('jam_mulai')->get();

        return view('jadwal.edit', compact(
            'jadwal',
            'guruMapel',
            'hari',
            'jam',
            'tahunAktif'
        ));
    }

    public function update(Request $request, Jadwal $jadwal)
    {
        $data = $request->validate([
            'guru_mapel_id' => 'required|exists:guru_mapel,id',
            'hari_id'       => 'required|exists:hari,id',
            'jam_id'        => 'required|exists:jams,id',
        ]);

        // validasi bentrok (exclude diri sendiri)
        $bentrok = Jadwal::where('id', '!=', $jadwal->id)
            ->where('hari_id', $data['hari_id'])
            ->where('jam_id', $data['jam_id'])
            ->whereHas('guruMapel', function ($q) use ($data) {
                $q->where('rombel_id', function ($sub) use ($data) {
                    $sub->select('rombel_id')
                        ->from('guru_mapel')
                        ->where('id', $data['guru_mapel_id']);
                });
            })
            ->exists();

        if ($bentrok) {
            return back()->withErrors([
                'jam_id' => 'Jadwal bentrok untuk rombel ini'
            ])->withInput();
        }

        $jadwal->update($data);

        return redirect()->route('jadwal.index')
            ->with('success', 'Jadwal berhasil diperbarui');
    }

}
