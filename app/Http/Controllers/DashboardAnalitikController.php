<?php

namespace App\Http\Controllers;

use App\Enums\UserRole;
use App\Models\GuruMapel;
use App\Models\Nilai;
use App\Models\Presensi;
use App\Models\RombelSiswa;
use App\Models\RombonganBelajar;
use App\Models\TahunAjaran;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class DashboardAnalitikController extends Controller
{
    /**
     * Halaman Utama Dashboard Analitik
     */
    public function index(Request $request)
    {
        /** @var User $user */
        $user = Auth::user();
        
        // 1. Setup Tahun Ajaran (Default: Aktif, atau dari Request)
        // Asumsi: Ada model TahunAjaran dengan scope active() atau field status
        $tahunAjaranId = $request->get('tahun_ajaran_id');
        $activeTahun = TahunAjaran::where('status', 'aktif')->first(); // Sesuaikan dengan logika DB Anda
        
        if (!$tahunAjaranId && $activeTahun) {
            $tahunAjaranId = $activeTahun->id;
        }

        $allTahun = TahunAjaran::orderBy('id', 'desc')->get();

        // 2. Data Container
        $data = [
            'allTahun' => $allTahun,
            'selectedTahunId' => $tahunAjaranId,
            'isManagement' => false,
            'rombelManagement' => [],
            'isWali' => false,
            'rombelWali' => null,
            'isGuru' => false,
            'mapelGuru' => [],
        ];

        // 3. Logika Role Management (Kepsek, Kurikulum, BK)
        if ($user->hasAnyRole([UserRole::KEPALA_SEKOLAH, UserRole::KURIKULUM, UserRole::GURU_BK])) {
            $data['isManagement'] = true;
            $data['rombelManagement'] = RombonganBelajar::where('tahun_ajaran_id', $tahunAjaranId)
                ->with('kelas', 'waliKelas')
                ->get();
        }

        // 4. Logika Role Wali Kelas
        // Cek apakah user punya role Wali DAN terdaftar sebagai wali di tahun yang dipilih
        if ($user->hasRole(UserRole::WALI_KELAS) && $user->guru_id) {
            $rombelWali = RombonganBelajar::where('tahun_ajaran_id', $tahunAjaranId)
                ->where('wali_kelas_id', $user->guru_id)
                ->first();
            
            if ($rombelWali) {
                $data['isWali'] = true;
                $data['rombelWali'] = $rombelWali;
            }
        }

        // 5. Logika Guru Pengajar
        if ($user->hasRole(UserRole::GURU_PENGAJAR) && $user->guru_id) {
            $data['isGuru'] = true;
            $data['mapelGuru'] = GuruMapel::where('guru_id', $user->guru_id)
                ->whereHas('rombel', function($q) use ($tahunAjaranId) {
                    $q->where('tahun_ajaran_id', $tahunAjaranId);
                })
                ->with(['mapel', 'rombel.kelas'])
                ->get();
        }

        return view('dashboard_analitik.index', $data);
    }

    /**
     * Detail Rombel (Grafik Presensi & List Mapel)
     * Diakses oleh: Management & Wali Kelas
     */
    public function showRombel(Request $request, $id)
    {
        $rombel = RombonganBelajar::with(['kelas', 'waliKelas', 'tahunAjaran'])->findOrFail($id);
        $rombel->load([
            'rombelSiswa',
            'rombelSiswa.siswa',
            'rombelSiswa.presensi',
        ]);

        $tanggalList = Presensi::whereIn(
                'rombel_siswa_id',
                $rombel->rombelSiswa->pluck('id')
            )
            ->select('tanggal')
            ->distinct()
            ->orderBy('tanggal')
            ->pluck('tanggal');

        // Kita perlu meloop siswa agar siswa yang belum ada presensi tetap terhitung (sebagai 0 atau 100 tergantung kebijakan, disini asumsi perlu data presensi)
        $listSiswa = RombelSiswa::with(['siswa', 'presensi'])
            ->where('rombel_id', $id)
            ->get();


        // Kategori Grafik
        $presensiGraph = [
            'Excellent' => 0,
            'Warning' => 0,
            'Risk' => 0
        ];

        $rekapSiswa = [];
        $filterKategori = $request->get('kategori');

        foreach ($listSiswa as $rs) {
            $total = $rs->presensi->count();
            $hadir = $rs->presensi->where('status', 'Hadir')->count();

            $persentase = $total > 0
                ? $hadir / $total * 100
                : 0;

            if ($persentase >= 90) {
                $kategori = 'Excellent';
                $presensiGraph['Excellent']++;
            } elseif ($persentase >= 75) {
                $kategori = 'Warning';
                $presensiGraph['Warning']++;
            } else {
                $kategori = 'Risk';
                $presensiGraph['Risk']++;
            }

            $rekap = [
                'Hadir' => $rs->presensi->where('status', 'Hadir')->count(),
                'Sakit' => $rs->presensi->where('status', 'Sakit')->count(),
                'Izin'  => $rs->presensi->where('status', 'Izin')->count(),
                'Alfa'  => $rs->presensi->where('status', 'Alfa')->count(),
            ];

            $totalHari = array_sum($rekap) ?: 1;

            $rekapSiswa[] = [
                'nis' => $rs->siswa->nis ?? '-',
                'nama_siswa' => $rs->siswa->nama_siswa ?? '-',

                'hadir_persen' => round($rekap['Hadir'] / $totalHari * 100, 1),
                'sakit_persen' => round($rekap['Sakit'] / $totalHari * 100, 1),
                'izin_persen'  => round($rekap['Izin'] / $totalHari * 100, 1),
                'alfa_persen'  => round($rekap['Alfa'] / $totalHari * 100, 1),

                'kategori' => $kategori,
            ];
        }
        if ($filterKategori) {
            $rekapSiswa = collect($rekapSiswa)
                ->where('kategori', $filterKategori)
                ->values();
        }


        // --- List Mapel di Rombel ini ---
        $listMapel = GuruMapel::where('rombel_id', $id)
            ->with(['mapel', 'guru'])
            ->get();

        return view('dashboard_analitik.show_rombel', compact(
            'rombel',
            'presensiGraph',
            'rekapSiswa',
            'listMapel',
            'tanggalList',
            'filterKategori'
        ));
    }

    /**
     * Detail Mapel (Grafik Nilai vs KKTP)
     * Diakses oleh: Management, Wali Kelas (via Rombel), & Guru Pengajar
     */
public function showMapel(Request $request, $guruMapelId)
{
    $guruMapel = GuruMapel::with([
        'mapel',
        'rombel.kelas',
        'guru',
        'tujuanPembelajaran.jenisPenilaian'
    ])->findOrFail($guruMapelId);

    $kktp = $guruMapel->kktp;

    // ===============================
    // FILTER STATUS
    // ===============================
    $filterStatus = $request->get('status');

    // ===============================
    // AMBIL SISWA DALAM ROMBEL
    // ===============================
    $listSiswa = RombelSiswa::with('siswa')
        ->where('rombel_id', $guruMapel->rombel_id)
        ->get();

    // ===============================
    // TUJUAN PEMBELAJARAN
    // ===============================
    $tps = $guruMapel->tujuanPembelajaran;

    // ===============================
    // DATA GRAFIK
    // ===============================
    $nilaiGraph = [
        'terlampaui' => 0,
        'tercapai'   => 0,
        'mendekati'  => 0,
        'tertinggal' => 0,
    ];

    // ===============================
    // KUMPULKAN ID PENILAIAN
    // ===============================
    $jenisPenilaianIds = $tps
        ->flatMap(fn ($tp) => $tp->jenisPenilaian->pluck('id'))
        ->unique()
        ->values();

    // ===============================
    // AMBIL SEMUA NILAI SEKALIGUS
    // ===============================
    $allNilai = Nilai::whereIn('jenis_penilaian_id', $jenisPenilaianIds)
        ->whereIn('rombel_siswa_id', $listSiswa->pluck('id'))
        ->get();

    $rekapNilai = [];

    // ===============================
    // LOOP SISWA
    // ===============================
    foreach ($listSiswa as $rs) {

        // Safety
        if (!$rs->siswa) {
            continue;
        }

        $nilaiTPs = [];

        $totalNilaiTP = 0;
        $jumlahTPValid = 0;

        // ===============================
        // LOOP TUJUAN PEMBELAJARAN
        // ===============================
        foreach ($tps as $tp) {

            $akumulasi = 0;
            $totalBobot = 0;
            $adaNilai = false;

            // ===============================
            // LOOP JENIS PENILAIAN
            // ===============================
            foreach ($tp->jenisPenilaian as $jp) {

                $nilai = $allNilai
                    ->where('rombel_siswa_id', $rs->id)
                    ->where('jenis_penilaian_id', $jp->id)
                    ->first();

                if ($nilai) {

                    $adaNilai = true;

                    $akumulasi += $nilai->nilai * $jp->bobot;

                    $totalBobot += $jp->bobot;
                }
            }

            // ===============================
            // HITUNG NILAI TP
            // ===============================
            if ($adaNilai && $totalBobot > 0) {

                $nilaiAkhirTP = round($akumulasi / $totalBobot, 2);

                $nilaiTPs[$tp->nama_tujuan] = $nilaiAkhirTP;

                $totalNilaiTP += $nilaiAkhirTP;

                $jumlahTPValid++;

            } else {

                $nilaiTPs[$tp->nama_tujuan] = null;
            }
        }

        // ===============================
        // HITUNG NILAI RAPOR
        // ===============================
        $nilaiRapor = $jumlahTPValid > 0
            ? round($totalNilaiTP / $jumlahTPValid, 2)
            : 0;

        // ===============================
        // KATEGORI NILAI
        // ===============================
        if ($nilaiRapor >= ($kktp + 7)) {

            $status = 'terlampaui';

        } elseif ($nilaiRapor >= $kktp) {

            $status = 'tercapai';

        } elseif ($nilaiRapor >= ($kktp - 7)) {

            $status = 'mendekati';

        } else {

            $status = 'tertinggal';
        }

        // ===============================
        // DATA GRAFIK
        // ===============================
        $nilaiGraph[$status]++;

        // ===============================
        // DATA TABEL
        // ===============================
        $rekapNilai[] = [
            'nis'          => $rs->siswa->nis ?? '-',
            'nama'         => $rs->siswa->nama_siswa ?? '-',
            'nilai_tp'     => $nilaiTPs,
            'nilai_rapor'  => $nilaiRapor,
            'status'       => ucfirst($status),
        ];
    }

// ===============================
// SIMPAN DATA ASLI (SEMUA SISWA)
// ===============================
$rekapNilaiAll = collect($rekapNilai);

// ===============================
// HITUNG STATISTIK KELAS
// SELALU DARI SEMUA SISWA
// ===============================
$nilaiRaporKelas = $rekapNilaiAll
    ->pluck('nilai_rapor')
    ->filter(fn ($n) => $n > 0)
    ->values();

$jumlahSiswa = $nilaiRaporKelas->count();

// ===============================
// MEAN
// ===============================
$mean = $jumlahSiswa > 0
    ? round($nilaiRaporKelas->avg(), 2)
    : 0;

// ===============================
// STANDAR DEVIASI
// ===============================
$stdDev = 0;

if ($jumlahSiswa > 1) {

    $variance = $nilaiRaporKelas
        ->map(fn ($n) => pow($n - $mean, 2))
        ->sum() / $jumlahSiswa;

    $stdDev = round(sqrt($variance), 2);
}

    // ===============================
    // FILTER STATUS
    // HANYA UNTUK TABEL
    // ===============================
    if ($filterStatus) {

        $rekapNilai = $rekapNilaiAll
            ->where('status', ucfirst($filterStatus))
            ->values();
    } else {

        $rekapNilai = $rekapNilaiAll;
    }

    // ===============================
    // SORTING BERDASARKAN NAMA
    // ===============================
    $rekapNilai = collect($rekapNilai)
        ->sortBy(fn ($row) => strtolower($row['nama']))
        ->values()
        ->all();

    $jumlahSiswa = $nilaiRaporKelas->count();

    // ===============================
    // MEAN
    // ===============================
    $mean = $jumlahSiswa > 0
        ? round($nilaiRaporKelas->avg(), 2)
        : 0;

    // ===============================
    // STANDAR DEVIASI
    // ===============================
    $stdDev = 0;

    if ($jumlahSiswa > 1) {

        $variance = $nilaiRaporKelas
            ->map(fn ($n) => pow($n - $mean, 2))
            ->sum() / $jumlahSiswa;

        $stdDev = round(sqrt($variance), 2);
    }

    // ===============================
    // INTERPRETASI MEAN
    // ===============================
    if ($mean >= $kktp) {

        $meanMessage = 'Nilai rata-rata kelas lebih tinggi dibandingkan KKTP. Kelas menunjukkan capaian pembelajaran yang baik.';

        $meanClass = 'text-excellent';

    } else {

        $meanMessage = 'Nilai rata-rata kelas masih di bawah KKTP. Perlu evaluasi dan penguatan pembelajaran.';

        $meanClass = 'text-risk';
    }

    // ===============================
    // INTERPRETASI STANDAR DEVIASI
    // ===============================
    if ($stdDev <= 2) {

        $stdDevMessage = 'Sebaran nilai relatif homogen, pemahaman siswa cenderung merata.';

        $stdDevClass = 'text-excellent';

    } elseif ($stdDev <= 5) {

        $stdDevMessage = 'Sebaran nilai cukup bervariasi, terdapat perbedaan tingkat pemahaman antar siswa.';

        $stdDevClass = 'text-good';

    } else {

        $stdDevMessage = 'Sebaran nilai sangat bervariasi, diperlukan diferensiasi dan pendampingan belajar.';

        $stdDevClass = 'text-risk';
    }

    // ===============================
    // RETURN VIEW
    // ===============================
    return view(
        'dashboard_analitik.show_mapel',
        compact(
            'guruMapel',
            'nilaiGraph',
            'rekapNilai',
            'kktp',
            'tps',
            'mean',
            'meanMessage',
            'meanClass',
            'stdDev',
            'stdDevMessage',
            'stdDevClass',
            'filterStatus'
        )
    );
}


}