<?php

namespace App\Http\Controllers;

use App\Models\TahunAjaran;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class TahunAjaranController extends Controller
{
    /**
     * Tampilkan semua tahun ajaran
     */
    public function index()
    {
        $tahunAjaran = TahunAjaran::orderByDesc('created_at')->get();

        return view('tahun_ajaran.index', compact('tahunAjaran'));
    }

    /**
     * Form create
     */
    public function create()
    {
        return view('tahun_ajaran.create');
    }

    /**
     * Simpan data
     */
    public function store(Request $request)
    {
       $request->validate([
        'nama_tahun_ajaran' => [
            'required',
            Rule::unique('tahun_ajaran')
                ->where('semester', $request->semester),
        ],
        'semester' => ['required', Rule::in(['Ganjil', 'Genap'])],
        'status' => ['required', Rule::in(['Aktif', 'Non-Aktif'])],
    ]);

        // Jika status Aktif → nonaktifkan yang lain
        if ($request->status === 'Aktif') {
            TahunAjaran::where('status', 'Aktif')
                ->update(['status' => 'Non-Aktif']);
        }

        TahunAjaran::create($request->all());

        return redirect()
            ->route('tahun-ajaran.index')
            ->with('success', 'Tahun ajaran berhasil ditambahkan');
    }

    /**
     * Form edit
     */
    public function edit(TahunAjaran $tahunAjaran)
    {
        return view('tahun_ajaran.edit', compact('tahunAjaran'));
    }

    /**
     * Update data
     */
    public function update(Request $request, TahunAjaran $tahunAjaran)
    {
        $request->validate([
            'nama_tahun_ajaran' => [
                'required',
                Rule::unique('tahun_ajaran')
                    ->where('semester', $request->semester)
                    ->ignore($tahunAjaran->id),
            ],
            'semester' => ['required', Rule::in(['Ganjil', 'Genap'])],
            'status' => ['required', Rule::in(['Aktif', 'Non-Aktif'])],
        ]);

        // Jika diubah menjadi Aktif → nonaktifkan yang lain
        if ($request->status === 'Aktif') {
            TahunAjaran::where('id', '!=', $tahunAjaran->id)
                ->where('status', 'Aktif')
                ->update(['status' => 'Non-Aktif']);
        }

        $tahunAjaran->update($request->all());

        return redirect()
            ->route('tahun-ajaran.index')
            ->with('success', 'Tahun ajaran berhasil diperbarui');
    }

    /**
     * Hapus data
     */
    public function destroy(TahunAjaran $tahunAjaran)
    {
        // Optional: larang hapus jika masih aktif
        if ($tahunAjaran->status === 'Aktif') {
            return back()->with('error', 'Tidak dapat menghapus tahun ajaran yang aktif');
        }

        $tahunAjaran->delete();

        return redirect()
            ->route('tahun-ajaran.index')
            ->with('success', 'Tahun ajaran berhasil dihapus');
    }
}
