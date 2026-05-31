<?php

namespace App\Http\Controllers;

use App\Models\JenisPenilaian;
use App\Models\TujuanPembelajaran;
use Illuminate\Http\Request;

class JenisPenilaianController extends Controller
{
    /**
     * Daftar jenis penilaian per TP
     */
    public function index(TujuanPembelajaran $tujuanPembelajaran)
    {
        $jenisPenilaian = JenisPenilaian::where('tujuan_pembelajaran_id', $tujuanPembelajaran->id)
            ->orderBy('created_at')
            ->get();

        $totalBobot = $jenisPenilaian->sum('bobot');

        return view('jenis_penilaian.index', compact(
            'tujuanPembelajaran',
            'jenisPenilaian',
            'totalBobot'
        ));
    }

    /**
     * Form tambah
     */
    public function create(TujuanPembelajaran $tujuanPembelajaran)
    {
        $totalBobot = JenisPenilaian::where('tujuan_pembelajaran_id', $tujuanPembelajaran->id)
            ->sum('bobot');

        return view('jenis_penilaian.create', compact(
            'tujuanPembelajaran',
            'totalBobot'
        ));
    }

    /**
     * Simpan data
     */
public function store(Request $request)
{
    $request->validate([
        'tujuan_pembelajaran_id' => 'required|exists:tujuan_pembelajaran,id',
        'nama_jenis' => 'required|string|max:255',
        'bobot' => 'required|integer|min:1|max:100',
    ]);

    $tujuan = TujuanPembelajaran::findOrFail(
        $request->tujuan_pembelajaran_id
    );

    $totalBobot = $tujuan->jenisPenilaian()->sum('bobot');

    if ($totalBobot + $request->bobot > 100) {
        return back()->withInput()->withErrors([
            'bobot' => 'Total bobot tidak boleh melebihi 100%'
        ]);
    }

    $tujuan->jenisPenilaian()->create([
        'nama_jenis' => $request->nama_jenis,
        'bobot' => $request->bobot,
    ]);

    return back()->with('success', 'Jenis penilaian berhasil ditambahkan');
}

    /**
     * Form edit
     */
    public function edit(TujuanPembelajaran $tujuanPembelajaran, JenisPenilaian $jenisPenilaian)
    {
        $totalBobotLain = JenisPenilaian::where('tujuan_pembelajaran_id', $tujuanPembelajaran->id)
            ->where('id', '!=', $jenisPenilaian->id)
            ->sum('bobot');

        return view('jenis_penilaian.edit', compact(
            'tujuanPembelajaran',
            'jenisPenilaian',
            'totalBobotLain'
        ));
    }

    /**
     * Update data
     */
public function update(Request $request, JenisPenilaian $jenisPenilaian)
{
    // 1. Validasi
    $request->validate([
        'nama_jenis' => ['required', 'string', 'max:255'],
        'bobot'      => ['required', 'integer', 'min:1', 'max:100'],
    ]);

    // 2. Ambil tujuan pembelajaran terkait
    $tujuanPembelajaran = $jenisPenilaian->tujuanPembelajaran;

    // 3. Ambil guru_mapel_id untuk redirect (INI YANG PENTING)
    $guruMapelId = $tujuanPembelajaran->guru_mapel_id;

    // 4. Hitung total bobot selain data ini
    $totalBobotLain = JenisPenilaian::where('tujuan_pembelajaran_id', $tujuanPembelajaran->id)
        ->where('id', '!=', $jenisPenilaian->id)
        ->sum('bobot');

    // 5. Validasi total bobot
    if (($totalBobotLain + $request->bobot) > 100) {
        return back()
            ->withInput()
            ->withErrors([
                'bobot' => 'Total bobot melebihi 100% (Sisa slot: ' . (100 - $totalBobotLain) . '%).',
            ]);
    }

    // 6. Update data
    $jenisPenilaian->update([
        'nama_jenis' => $request->nama_jenis,
        'bobot'      => $request->bobot,
    ]);

    // 7. Redirect ke halaman yang BENAR (tidak 403)
    return redirect()
        ->route('tujuan-pembelajaran.show', $guruMapelId)
        ->with('success', 'Jenis penilaian berhasil diperbarui.');
}


    /**
     * Hapus data
     */
    public function destroy(
        TujuanPembelajaran $tujuanPembelajaran,
        JenisPenilaian $jenisPenilaian
    ) {
        $jenisPenilaian->delete();

        return redirect()
            ->route('jenis-penilaian.index', $tujuanPembelajaran->id)
            ->with('success', 'Jenis penilaian berhasil dihapus.');
    }
}
