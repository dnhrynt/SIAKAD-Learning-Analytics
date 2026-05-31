@extends('layouts.app')

@section('content')
<div class="container py-4 bg-content">

    <div class="row justify-content-center">
        <div class="col-md-8">

            <div class="card shadow-sm border-0">
                <div class="card-body">

                    {{-- Header --}}
                    <div class="d-flex align-items-center mb-4 p-3 rounded"
                         style="background: linear-gradient(135deg, #667eea, #764ba2);">
                        <div class="me-3">
                            <i class="bi bi-person-circle fs-1 text-white"></i>
                        </div>
                        <div>
                            <h4 class="mb-0 text-white fw-semibold">
                                Perbarui Profil Saya
                            </h4>
                        </div>
                    </div>

                    {{-- Form --}}
                    <form action="{{ route('guru.update') }}" method="POST">
                        @csrf
                        @method('PUT')

                        {{-- NIP --}}
                        <div class="mb-3">
                            <label class="form-label fw-semibold">
                                NIP
                            </label>
                            <input type="text"
                                name="nip"
                                value="{{ old('nip', $guru->nip) }}"
                                class="form-control @error('nip') is-invalid @enderror">

                            @error('nip')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Nama --}}
                        <div class="mb-3">
                            <label class="form-label fw-semibold">
                                Nama Lengkap
                            </label>
                            <input type="text"
                                   name="nama_guru"
                                   value="{{ old('nama_guru', $guru->nama_guru) }}"
                                   class="form-control @error('nama_guru') is-invalid @enderror">

                            @error('nama_guru')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Jenis Kelamin --}}
                        <div class="mb-3">
                            <label class="form-label fw-semibold">
                                Jenis Kelamin
                            </label>
                            <select name="jenis_kelamin"
                                    class="form-select @error('jenis_kelamin') is-invalid @enderror">
                                <option value="">-- Pilih Jenis Kelamin --</option>
                                <option value="Laki-laki"
                                    {{ old('jenis_kelamin', $guru->jenis_kelamin) == 'Laki-laki' ? 'selected' : '' }}>
                                    Laki-laki
                                </option>
                                <option value="Perempuan"
                                    {{ old('jenis_kelamin', $guru->jenis_kelamin) == 'Perempuan' ? 'selected' : '' }}>
                                    Perempuan
                                </option>
                            </select>

                            @error('jenis_kelamin')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Tempat Lahir --}}
                        <div class="mb-3">
                            <label class="form-label fw-semibold">
                                Tempat Lahir
                            </label>
                            <input type="text"
                                   name="tempat_lahir"
                                   value="{{ old('tempat_lahir', $guru->tempat_lahir) }}"
                                   class="form-control @error('tempat_lahir') is-invalid @enderror">

                            @error('tempat_lahir')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Tanggal Lahir --}}
                        <div class="mb-3">
                            <label class="form-label fw-semibold">
                                Tanggal Lahir
                            </label>
                            <input type="date"
                                   name="tanggal_lahir"
                                   value="{{ old('tanggal_lahir', $guru->tanggal_lahir) }}"
                                   class="form-control @error('tanggal_lahir') is-invalid @enderror">

                            @error('tanggal_lahir')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Agama --}}
                        <div class="mb-3">
                            <label class="form-label fw-semibold">
                                Agama
                            </label>
                            <input type="text"
                                   name="agama"
                                   value="{{ old('agama', $guru->agama) }}"
                                   class="form-control @error('agama') is-invalid @enderror">

                            @error('agama')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Alamat --}}
                        <div class="mb-3">
                            <label class="form-label fw-semibold">
                                Alamat
                            </label>
                            <textarea name="alamat"
                                      rows="3"
                                      class="form-control @error('alamat') is-invalid @enderror">{{ old('alamat', $guru->alamat) }}</textarea>

                            @error('alamat')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- No Telp --}}
                        <div class="mb-3">
                            <label class="form-label fw-semibold">
                                No. Telepon
                            </label>
                            <input type="text"
                                   name="no_telp"
                                   value="{{ old('no_telp', $guru->no_telp) }}"
                                   class="form-control @error('no_telp') is-invalid @enderror">

                            @error('no_telp')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Tombol --}}
                        <div class="d-flex justify-content-end gap-2 mt-4">
                            <a href="{{ route('guru.show') }}"
                               class="btn btn-gradient-secondary">
                                <i class="bi bi-arrow-left me-1"></i>
                                Kembali
                            </a>

                            <button type="submit"
                                    class="btn btn-gradient-primary">
                                <i class="bi bi-save me-1"></i>
                                Simpan Perubahan
                            </button>
                        </div>

                    </form>

                </div>
            </div>

        </div>
    </div>

</div>
@endsection
