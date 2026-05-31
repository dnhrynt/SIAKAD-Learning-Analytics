@extends('layouts.app')

@section('content')
<div class="container pb-4">

    {{-- Header --}}
    <div class="mb-4">
        <h3 class="gradient-text-primary">
            <i class="bi bi-person-plus-fill me-2"></i>
            Tambah User
        </h3>
        <p class="text-muted mb-0">
            Lengkapi data user dan hubungkan dengan guru jika diperlukan
        </p>
    </div>

    {{-- Card Form --}}
    <div class="card border-0 shadow-sm">
        <div class="card-body">

            <form action="{{ route('users.store') }}" method="POST">
                @csrf

                <div class="row">

                    {{-- Username --}}
                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-semibold">
                            Username
                        </label>
                        <input type="text"
                               name="username"
                               class="form-control @error('username') is-invalid @enderror"
                               value="{{ old('username') }}"
                               placeholder="Masukkan username"
                               required>
                        @error('username')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- Guru --}}
                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-semibold">
                            Guru Pemilik
                        </label>
                        <select name="guru_id"
                                class="form-select">
                            <option value="">-- Pilih Guru --</option>
                            @foreach ($gurus as $guru)
                                <option value="{{ $guru->id }}"
                                    {{ old('guru_id') == $guru->id ? 'selected' : '' }}>
                                    {{ $guru->nama_guru }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    {{-- Password --}}
                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-semibold">
                            Password
                        </label>
                        <input type="password"
                               name="password"
                               class="form-control @error('password') is-invalid @enderror"
                               required>
                        @error('password')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- Konfirmasi Password --}}
                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-semibold">
                            Konfirmasi Password
                        </label>
                        <input type="password"
                               name="password_confirmation"
                               class="form-control"
                               required>
                    </div>

                    {{-- Role --}}
                    <div class="col-12 mb-3">
                        <label class="form-label fw-semibold">
                            Role
                        </label>
                        <div class="border rounded p-3 bg-light">
                            <div class="row">
                                @forelse ($roles as $role)
                                    <div class="col-md-4">
                                        <div class="form-check">
                                            <input class="form-check-input"
                                                   type="checkbox"
                                                   name="role_ids[]"
                                                   value="{{ $role->id }}"
                                                   id="role{{ $role->id }}">
                                            <label class="form-check-label"
                                                   for="role{{ $role->id }}">
                                                {{ $role->nama_role }}
                                            </label>
                                        </div>
                                    </div>
                                @empty
                                    <span class="text-muted">
                                        Role belum tersedia
                                    </span>
                                @endforelse
                            </div>
                        </div>
                    </div>

                </div>

                {{-- Tombol --}}
                <div class="d-flex justify-content-between mt-4">
                    <a href="{{ route('users.index') }}"
                       class="btn btn-gradient-secondary">
                        <i class="bi bi-arrow-left me-1"></i>
                        Kembali
                    </a>

                    <button type="submit"
                            class="btn btn-gradient-primary">
                        <i class="bi bi-save me-1"></i>
                        Simpan User
                    </button>
                </div>

            </form>

        </div>
    </div>

</div>
@endsection
