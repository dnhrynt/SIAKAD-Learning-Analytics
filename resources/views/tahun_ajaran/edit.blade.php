@extends('layouts.app')

@section('content')
<div class="container pb-4">

    {{-- Header --}}
    <div class="mb-4">
        <h3 class="gradient-text-primary">
            <i class="bi bi-calendar-check-fill me-2"></i>
            Edit Tahun Ajaran
        </h3>
        <p class="text-muted mb-0">
            Perbarui data tahun ajaran dan atur status aktif
        </p>
    </div>

    {{-- Card Form --}}
    <div class="card border-0 shadow-sm">
        <div class="card-body">

            <form action="{{ route('tahun-ajaran.update', $tahunAjaran->id) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="row">

                    {{-- Nama Tahun Ajaran --}}
                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-semibold">
                            Nama Tahun Ajaran
                        </label>
                        <input type="text"
                               name="nama_tahun_ajaran"
                               class="form-control @error('nama_tahun_ajaran') is-invalid @enderror"
                               value="{{ old('nama_tahun_ajaran', $tahunAjaran->nama_tahun_ajaran) }}"
                               placeholder="Contoh: 2024/2025"
                               required>
                        @error('nama_tahun_ajaran')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- Semester --}}
                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-semibold">
                            Semester
                        </label>
                        <select name="semester"
                                class="form-select @error('semester') is-invalid @enderror"
                                required>
                            <option value="Ganjil"
                                {{ old('semester', $tahunAjaran->semester) == 'Ganjil' ? 'selected' : '' }}>
                                Ganjil
                            </option>
                            <option value="Genap"
                                {{ old('semester', $tahunAjaran->semester) == 'Genap' ? 'selected' : '' }}>
                                Genap
                            </option>
                        </select>
                        @error('semester')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- Status --}}
                    <div class="col-12 mb-3">
                        <label class="form-label fw-semibold">
                            Status Tahun Ajaran
                        </label>

                        <div class="border rounded p-3 bg-light">
                            <div class="form-check form-check-inline">
                                <input class="form-check-input"
                                       type="radio"
                                       name="status"
                                       id="statusNonAktif"
                                       value="Non-Aktif"
                                       {{ old('status', $tahunAjaran->status) == 'Non-Aktif' ? 'checked' : '' }}>
                                <label class="form-check-label" for="statusNonAktif">
                                    Non-Aktif
                                </label>
                            </div>

                            <div class="form-check form-check-inline ms-3">
                                <input class="form-check-input"
                                       type="radio"
                                       name="status"
                                       id="statusAktif"
                                       value="Aktif"
                                       {{ old('status', $tahunAjaran->status) == 'Aktif' ? 'checked' : '' }}>
                                <label class="form-check-label" for="statusAktif">
                                    Aktif
                                </label>
                            </div>

                            <div class="mt-2">
                                <small class="text-muted">
                                    * Jika diset Aktif, tahun ajaran lain otomatis menjadi Non-Aktif
                                </small>
                            </div>
                        </div>

                        @error('status')
                            <div class="text-danger small mt-1">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                </div>

                {{-- Tombol --}}
                <div class="d-flex justify-content-between mt-4">
                    <a href="{{ route('tahun-ajaran.index') }}"
                       class="btn btn-gradient-secondary">
                        <i class="bi bi-arrow-left me-1"></i>
                        Kembali
                    </a>

                    <button type="submit"
                            class="btn btn-gradient-primary">
                        <i class="bi bi-save me-1"></i>
                        Update Tahun Ajaran
                    </button>
                </div>

            </form>

        </div>
    </div>

</div>
@endsection
