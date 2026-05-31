<?php

namespace App\Http\Controllers;

use App\Models\RombonganBelajar;
use App\Models\TahunAjaran;
use App\Models\Kelas;
use App\Models\Guru;
use Illuminate\Http\Request;

class RombonganBelajarController extends Controller
{
    public function index(Request $request)
    {
        $tahunAktif = TahunAjaran::where('status', 'aktif')->first();
        $listTahun = TahunAjaran::orderBy('nama_tahun_ajaran', 'desc')->get();

        // Tentukan tahun yang dipakai
        $tahunDipilih = $request->tahun_ajaran_id
            ?? $tahunAktif?->id;

        $rombels = RombonganBelajar::with(['waliKelas', 'tahunAjaran'])
            ->when($tahunDipilih, function ($query) use ($tahunDipilih) {
                $query->where('tahun_ajaran_id', $tahunDipilih);
            })
            ->get();

        $tahunTampil = $listTahun->firstWhere('id', $tahunDipilih);

        return view('rombel.index', compact(
            'rombels',
            'tahunAktif',
            'listTahun',
            'tahunTampil',
            'tahunDipilih'
        ));
    }

    public function create()
    {
        $kelas = Kelas::all();
        $waliKelas = Guru::orderBy('nama_guru')->get();
        $tahunAktif = TahunAjaran::where('status', 'aktif')->first();

        return view('rombel.create', compact('kelas', 'waliKelas', 'tahunAktif'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_rombel' => 'required|string|max:100',
            'kelas_id' => 'required|exists:kelas,id',
            'wali_kelas_id' => 'required|exists:gurus,id',
            'tahun_ajaran_id' => 'required|exists:tahun_ajaran,id',
        ]);

        RombonganBelajar::create($request->all());

        return redirect()->route('rombel.index')
            ->with('success', 'Rombongan Belajar berhasil ditambahkan');
    }

    public function edit(RombonganBelajar $rombel)
    {
        $rombel->load('tahunAjaran');
        $kelas = Kelas::all();
        $waliKelas = Guru::orderBy('nama_guru')->get();

        return view('rombel.edit', compact('rombel', 'kelas', 'waliKelas'));
    }


    public function update(Request $request, RombonganBelajar $rombel)
    {
        $request->validate([
            'nama_rombel' => 'required|string|max:100',
            'kelas_id' => 'required|exists:kelas,id',
            'wali_kelas_id' => 'required|exists:gurus,id',
            'tahun_ajaran_id' => 'required|exists:tahun_ajaran,id',
        ]);

        $rombel->update($request->all());

        return redirect()->route('rombel.index')
            ->with('success', 'Rombongan Belajar berhasil diperbarui');
    }
}
