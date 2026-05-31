<?php

namespace App\Http\Controllers;

use App\Models\GuruMapel;
use App\Models\TujuanPembelajaran;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TujuanPembelajaranController extends Controller
{
    /**
     * List tujuan pembelajaran milik guru
     */
    public function index()
    {
        $guruId = Auth::user()->guru->id;

        $guruMapelList = GuruMapel::with(['mapel', 'rombel'])
            ->where('guru_id', $guruId)
            ->get();

        $tujuanList = TujuanPembelajaran::with(['jenisPenilaian', 'guruMapel'])
            ->whereHas('guruMapel', function ($q) use ($guruId) {
                $q->where('guru_id', $guruId);
            })
            ->get();

        return view('tujuan_pembelajaran.index', compact('guruMapelList', 'tujuanList'));
    }

    /**
     * Form tambah tujuan pembelajaran
     */
    public function create(GuruMapel $guruMapel)
    {
        $this->authorizeGuruMapel($guruMapel);

        return view('tujuan_pembelajaran.create', compact('guruMapel'));
    }

    /**
     * Simpan tujuan pembelajaran
     */
    public function store(Request $request, GuruMapel $guruMapel)
    {
        $this->authorizeGuruMapel($guruMapel);

        $request->validate([
            'nama_tujuan' => 'required|string|max:255',
            'deskripsi'   => 'nullable|string',
        ]);

        TujuanPembelajaran::create([
            'guru_mapel_id' => $guruMapel->id,
            'nama_tujuan'   => $request->nama_tujuan,
            'deskripsi'     => $request->deskripsi,
        ]);

        return redirect()
            ->route('tujuan-pembelajaran.show', $guruMapel->id)
            ->with('success', 'Tujuan pembelajaran berhasil ditambahkan');
    }

    /**
     * Daftar tujuan pembelajaran per guru_mapel
     */
    public function show(GuruMapel $guruMapel)
    {
        $this->authorizeGuruMapel($guruMapel);

        $tujuanList = $guruMapel->tujuanPembelajaran;

        return view('tujuan_pembelajaran.show', compact('guruMapel', 'tujuanList'));
    }

    /**
     * Form edit
     */
    public function edit(TujuanPembelajaran $tujuan)
    {
        $this->authorizeGuruMapel($tujuan->guruMapel);

        return view('tujuan_pembelajaran.edit', compact('tujuan'));
    }

    /**
     * Update data
     */
    public function update(Request $request, TujuanPembelajaran $tujuan)
    {
        $this->authorizeGuruMapel($tujuan->guruMapel);

        $request->validate([
            'nama_tujuan' => 'required|string|max:255',
            'deskripsi'   => 'nullable|string',
        ]);

        $tujuan->update($request->only('nama_tujuan', 'deskripsi'));

        return redirect()
            ->route('tujuan-pembelajaran.show', $tujuan->guru_mapel_id)
            ->with('success', 'Tujuan pembelajaran berhasil diperbarui');
    }

    /**
     * Hapus
     */
    public function destroy(TujuanPembelajaran $tujuan)
    {
        $this->authorizeGuruMapel($tujuan->guruMapel);

        $tujuan->delete();

        return back()->with('success', 'Tujuan pembelajaran berhasil dihapus');
    }

    /**
     * Validasi kepemilikan guru
     */
    private function authorizeGuruMapel(GuruMapel $guruMapel)
    {
        $authGuruId = Auth::user()->guru->id;
    
        if ((int) $guruMapel->guru_id !== (int) $authGuruId) {
            abort(403, 'Akses ditolak');
        }
    }

}
