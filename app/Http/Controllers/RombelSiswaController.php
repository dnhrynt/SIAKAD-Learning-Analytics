<?php

namespace App\Http\Controllers;

use App\Models\RombelSiswa;
use App\Models\RombonganBelajar;
use App\Models\TahunAjaran;
use Illuminate\Http\Request;
use App\Enums\UserRole;
use App\Models\User;
use Illuminate\Support\Facades\Auth;


class RombelSiswaController extends Controller
{
    /**
     * UPDATE STATUS SISWA DALAM ROMBEL
     */
    public function updateStatus(Request $request, RombelSiswa $rombelSiswa)
    {
        // hanya wali kelas
        /** @var User $user */
        $user = Auth::user();
        abort_if(!$user->hasRole(UserRole::WALI_KELAS), 403);

        $request->validate([
            'status' => 'required|in:aktif,naik,tinggal,drop-out,lulus',
        ]);

        // pastikan rombel ini milik wali kelas & tahun aktif
        $tahunAktif = TahunAjaran::where('status', 'Aktif')->firstOrFail();

        $rombel = RombonganBelajar::where('id', $rombelSiswa->rombel_id)
            ->where('wali_kelas_id', $user->guru_id)
            ->where('tahun_ajaran_id', $tahunAktif->id)
            ->firstOrFail();

        // logika khusus lulus
        if ($request->status === 'lulus') {
            $rombelSiswa->update([
                'status' => 'lulus',
            ]);
        } else {
            $rombelSiswa->update([
                'status' => $request->status,
            ]);
        }

        return back()->with('success', 'Status siswa diperbarui');
    }
}
