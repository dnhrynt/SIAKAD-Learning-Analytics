<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Role;
use App\Models\Guru;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;


class UserController extends Controller
{
    public function index()
    {
        $users = User::with('roles')->get();
        $roles = Role::all();

        return view('users.index', compact('users', 'roles'));
    }

    public function create()
    {
        $roles = Role::all();
        $gurus = Guru::orderBy('nama_guru')->get();
        return view('users.create', compact('roles', 'gurus'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'username' => 'required|string|unique:users,username',
            'password' => 'required|min:6|confirmed',
            'guru_id' => 'nullable|exists:gurus,id',
            'role_ids' => 'nullable|array',
            'role_ids.*' => 'exists:roles,id'
        ]);

        $user = User::create([
            'username' => $request->username,
            'password' => Hash::make($request->password),
            'guru_id' => $request->guru_id,
        ]);

        if ($request->filled('role_ids')) {
            $user->roles()->attach($request->role_ids);
        }

        return redirect()
            ->route('users.index')
            ->with('success', 'User berhasil ditambahkan');
    }

    public function addRole(Request $request, User $user)
    {
        $request->validate([
            'role_id' => 'required|exists:roles,id'
        ]);

        if (!$user->hasRole($request->role_id)) {
            $user->roles()->attach($request->role_id);
        }

        return back()->with('success', 'Role berhasil ditambahkan');
    }

    public function removeRole(User $user, Role $role)
    {
        $user->roles()->detach($role->id);

        return back()->with('success', 'Role berhasil dihapus');
    }

    public function destroy(User $user)
    {
        $user->roles()->detach(); // hapus relasi dulu
        $user->delete();

        return back()->with('success', 'User berhasil dihapus');
    }
}
