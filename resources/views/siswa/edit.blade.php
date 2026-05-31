@extends('layouts.app')

@section('content')
<div class="container pb-4">

    {{-- Header --}}
    <div class="mb-4">
        <h3 class="gradient-text-primary">
            <i class="bi bi-pencil-square me-2"></i>
            Edit Siswa
        </h3>
        <p class="text-muted mb-0">
            Perbarui data siswa jika terdapat kesalahan
        </p>
    </div>

    {{-- Card Form --}}
    <div class="card border-0 shadow-sm">
        <div class="card-body">

            <form action="{{ route('siswa.update', $siswa->id) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="row">

                    {{-- NIS --}}
                    <div class="col-md-4 mb-3">
                        <label class="form-label fw-semibold">NIS</label>
                        <input type="text"
                               name="nis"
                               class="form-control @error('nis') is-invalid @enderror"
                               value="{{ old('nis', $siswa->nis) }}"
                               required>
                        @error('nis')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- Nama Siswa --}}
                    <div class="col-md-8 mb-3">
                        <label class="form-label fw-semibold">Nama Siswa</label>
                        <input type="text"
                               name="nama_siswa"
                               class="form-control @error('nama_siswa') is-invalid @enderror"
                               value="{{ old('nama_siswa', $siswa->nama_siswa) }}"
                               required>
                        @error('nama_siswa')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- Jenis Kelamin --}}
                    <div class="col-md-4 mb-3">
                        <label class="form-label fw-semibold">Jenis Kelamin</label>
                        <select name="jenis_kelamin"
                                class="form-select @error('jenis_kelamin') is-invalid @enderror"
                                required>
                            <option value="">-- Pilih --</option>
                            <option value="Laki-laki"
                                {{ old('jenis_kelamin', $siswa->jenis_kelamin) == 'Laki-laki' ? 'selected' : '' }}>
                                Laki-laki
                            </option>
                            <option value="Perempuan"
                                {{ old('jenis_kelamin', $siswa->jenis_kelamin) == 'Perempuan' ? 'selected' : '' }}>
                                Perempuan
                            </option>
                        </select>
                        @error('jenis_kelamin')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- Tempat Lahir --}}
                    <div class="col-md-4 mb-3">
                        <label class="form-label fw-semibold">Tempat Lahir</label>
                        <input type="text"
                               name="tempat_lahir"
                               class="form-control @error('tempat_lahir') is-invalid @enderror"
                               value="{{ old('tempat_lahir', $siswa->tempat_lahir) }}"
                               required>
                        @error('tempat_lahir')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- Tanggal Lahir --}}
                    <div class="col-md-4 mb-3">
                        <label class="form-label fw-semibold">Tanggal Lahir</label>
                        <input type="date"
                               name="tanggal_lahir"
                               class="form-control @error('tanggal_lahir') is-invalid @enderror"
                               value="{{ old('tanggal_lahir', $siswa->tanggal_lahir) }}"
                               required>
                        @error('tanggal_lahir')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- Agama --}}
                    <div class="col-md-4 mb-3">
                        <label class="form-label fw-semibold">Agama</label>
                        <input type="text"
                               name="agama"
                               class="form-control @error('agama') is-invalid @enderror"
                               value="{{ old('agama', $siswa->agama) }}"
                               required>
                        @error('agama')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- Alamat --}}
                    <div class="col-md-8 mb-3">
                        <label class="form-label fw-semibold">Alamat</label>
                        <textarea name="alamat"
                                  rows="3"
                                  class="form-control @error('alamat') is-invalid @enderror"
                                  required>{{ old('alamat', $siswa->alamat) }}</textarea>
                        @error('alamat')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                </div>

                {{-- Tombol --}}
                <div class="d-flex justify-content-between mt-4">
                    <a href="{{ route('siswa.index') }}"
                       class="btn btn-gradient-secondary d-inline-flex align-items-center gap-2">
                        <i class="bi bi-arrow-left"></i>
                        Kembali
                    </a>

                    <button type="submit"
                            class="btn btn-gradient-primary d-inline-flex align-items-center gap-2">
                        <i class="bi bi-save"></i>
                        Update Siswa
                    </button>
                </div>

            </form>

        </div>
    </div>

</div>
@endsection
