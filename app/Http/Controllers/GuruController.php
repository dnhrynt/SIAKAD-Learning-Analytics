<?php

namespace App\Http\Controllers;

use App\Models\Guru;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Enums\UserRole;
use App\Models\User;
use Illuminate\Validation\Rule;

class GuruController extends Controller
{
    public function index()
    {
        /** @var User $user */
        $user = Auth::user();

        abort_if(
            !$user->hasRole(UserRole::KEPALA_SEKOLAH),
            403
        );

        $gurus = Guru::oldest()->get();
        return view('guru.index', compact('gurus'));
    }

    public function create()
    {
        /** @var User $user */
        $user = Auth::user();

        abort_if(
            !$user->hasRole(UserRole::KEPALA_SEKOLAH),
            403
        );

        return view('guru.create');
    }

    public function store(Request $request)
    {
        /** @var User $user */
        $user = Auth::user();

        abort_if(
            !$user->hasRole(UserRole::KEPALA_SEKOLAH),
            403
        );

        Guru::create($request->validate([
            'nip' => 'required|unique:gurus',
            'nama_guru' => 'required',
            'jenis_kelamin' => 'required|in:Laki-laki,Perempuan',
        ]));

        return redirect()->route('guru.index');
    }

    // ======================
    // PROFIL GURU SENDIRI
    // ======================

    public function show()
    {
        /** @var User $user */
        $user = Auth::user();

        $guru = $user->guru;
        abort_if(!$guru, 404);

        return view('guru.show', compact('guru'));
    }

    public function edit()
    {
        /** @var User $user */
        $user = Auth::user();

        $guru = $user->guru;
        abort_if(!$guru, 404);

        return view('guru.edit', compact('guru'));
    }

    public function update(Request $request)
{
    /** @var User $user */
    $user = Auth::user();

    $guru = $user->guru;
    abort_if(!$guru, 404);

    $data = $request->validate([
        'nip' => [
            'required',
            'string',
            'max:50',
            Rule::unique('gurus')->ignore($guru->id),
        ],
        'nama_guru'     => 'required|string|max:255',
        'jenis_kelamin' => 'required|in:Laki-laki,Perempuan',
        'tempat_lahir'  => 'nullable|string|max:255',
        'tanggal_lahir' => 'nullable|date',
        'agama'         => 'nullable|string|max:100',
        'alamat'        => 'nullable|string',
        'no_telp'       => 'nullable|string|max:20',
    ]);

    $guru->update($data);

    return redirect()
        ->route('guru.show')
        ->with('success', 'Profil berhasil diperbarui');
}

}
