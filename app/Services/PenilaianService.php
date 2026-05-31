<?php

namespace App\Services;

use App\Models\Nilai;
use App\Models\NilaiTP;
use App\Models\NilaiRapor;

class PenilaianService
{
    /* ===============================
     * HITUNG & SIMPAN NILAI TP
     * =============================== */
    public function hitungNilaiTP(int $rombelSiswaId, int $tujuanPembelajaranId): void
    {
        $nilaiList = Nilai::with('jenisPenilaian')
            ->where('rombel_siswa_id', $rombelSiswaId)
            ->whereHas('jenisPenilaian', fn ($q) =>
                $q->where('tujuan_pembelajaran_id', $tujuanPembelajaranId)
            )
            ->get();

        if ($nilaiList->isEmpty()) {
            return;
        }

        $totalBobot = 0;
        $totalNilai = 0;

        foreach ($nilaiList as $nilai) {
            $bobot = (float) $nilai->jenisPenilaian->bobot;
            $totalNilai += $nilai->nilai * $bobot;
            $totalBobot += $bobot;
        }

        if ($totalBobot <= 0) {
            return;
        }

        $nilaiTP = $totalNilai / $totalBobot; // ❌ TANPA round

        NilaiTP::updateOrCreate(
            [
                'rombel_siswa_id'         => $rombelSiswaId,
                'tujuan_pembelajaran_id' => $tujuanPembelajaranId,
            ],
            [
                'nilai' => $nilaiTP,
            ]
        );
    }


    /* ===============================
     * HITUNG & SIMPAN NILAI RAPOR
     * =============================== */
    public function hitungNilaiRapor(int $rombelSiswaId, int $guruMapelId): void
    {
        $nilaiTPs = NilaiTP::where('rombel_siswa_id', $rombelSiswaId)
            ->whereHas('tujuanPembelajaran', fn ($q) =>
                $q->where('guru_mapel_id', $guruMapelId)
            )
            ->pluck('nilai');

        if ($nilaiTPs->isEmpty()) {
            return;
        }

        $nilaiRapor = $nilaiTPs->avg(); // ❌ TANPA round

        NilaiRapor::updateOrCreate(
            [
                'rombel_siswa_id' => $rombelSiswaId,
                'guru_mapel_id'   => $guruMapelId,
            ],
            [
                'nilai_rapor' => $nilaiRapor,
            ]
        );
    }

}
