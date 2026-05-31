@extends('layouts.app')

@section('title', 'User-SIAKAD-sman-1-grabagan')

@section('content')
<div class="container">

    <div class="mb-3">
        <h3 class="gradient-text-info mb-4">
            <i class="bi bi-people-fill me-2"></i>
            Manajemen User SIAKAD
        </h3>

        @if(auth()->user()->hasRole(\App\Enums\UserRole::KEPALA_SEKOLAH))
            <div class="text-end">
                <a href="{{ route('users.create') }}"
                class="btn btn-gradient-secondary">
                    <i class="bi bi-plus-circle me-1"></i>
                    Tambah User
                </a>
            </div>
        @endif
    </div>

    <table class="table table-bordered table-hover align-middle">
        <thead class="fw-bold">
            <tr>
                <th width="5%">No</th>
                <th width="25%">Username</th>
                <th width="25%">Guru Pemilik</th>
                <th width="35%">Role</th>
                <th width="10%">Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($users as $user)
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ $user->username }}</td>
                <td>{{ $user->guru?->nama_guru }}</td>
                <td>
                    @forelse ($user->roles as $role)
                        <div class="d-flex align-items-center gap-1">
                            <span>{{ $role->nama_role }}</span>

                            <form action="{{ route('users.roles.remove', [$user->id, $role->id]) }}"
                                method="POST"
                                onsubmit="return confirm('Yakin hapus role ini dari user?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit"
                                        class="btn btn-link text-danger p-0 fs-5">
                                    <i class="bi bi-x fs-4"></i>
                                </button>
                            </form>
                        </div>
                    @empty
                        <span class="text-muted">Belum ada role</span>
                    @endforelse
                    {{-- Tambah Role --}}
                    <form action="{{ route('users.roles.add', $user->id) }}"
                          method="POST"
                          class="d-flex gap-2 mt-2 mb-1">
                        @csrf
                        <select name="role_id" class="form-select form-select-sm" required>
                            <option value="">+ Tambah Role</option>
                            @foreach ($roles as $role)
                                @if(!$user->hasRole($role->id))
                                    <option value="{{ $role->id }}">{{ $role->nama_role }}</option>
                                @endif
                            @endforeach
                        </select>
                        <button class="btn btn-sm btn-primary">Tambah</button>
                    </form>

                </td>
                <td class="text-center">
    <form action="{{ route('users.destroy', $user->id) }}"
          method="POST"
          onsubmit="return confirm('Yakin hapus user ini?')">
        @csrf
        @method('DELETE')
        <button type="submit"
                class="btn btn-link text-danger p-0 fs-5"
                title="Hapus User">
            <i class="bi bi-trash3-fill"></i>
        </button>
    </form>
</td>

            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
