@extends('layouts.app')

@section('content')
<div class="container pb-4">

    {{-- Header --}}
    <div class="mb-4">
        <h3 class="gradient-text-primary">
            <i class="bi bi-pencil-square me-2"></i>
            Edit Rombongan Belajar
        </h3>
        <p class="text-muted mb-0">
            Perbarui data rombongan belajar dan wali kelas
        </p>
    </div>

    {{-- Card Form --}}
    <div class="card border-0 shadow-sm">
        <div class="card-body">

            <form action="{{ route('rombel.update', $rombel->id) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="row">

                    {{-- Nama Rombel --}}
                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-semibold">
                            Nama Rombel
                        </label>
                        <input type="text"
                               name="nama_rombel"
                               class="form-control @error('nama_rombel') is-invalid @enderror"
                               value="{{ old('nama_rombel', $rombel->nama_rombel) }}"
                               required>
                        @error('nama_rombel')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- Kelas --}}
                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-semibold">
                            Kelas
                        </label>
                        <select name="kelas_id"
                                class="form-select @error('kelas_id') is-invalid @enderror"
                                required>
                            @foreach ($kelas as $k)
                                <option value="{{ $k->id }}"
                                    {{ old('kelas_id', $rombel->kelas_id) == $k->id ? 'selected' : '' }}>
                                    {{ $k->nama_kelas }}
                                </option>
                            @endforeach
                        </select>
                        @error('kelas_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- Wali Kelas --}}
                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-semibold">
                            Wali Kelas
                        </label>
                        <select name="wali_kelas_id"
                                class="form-select @error('wali_kelas_id') is-invalid @enderror"
                                required>
                            <option value="">-- Pilih Wali Kelas --</option>
                            @foreach ($waliKelas as $guru)
                                <option value="{{ $guru->id }}"
                                    {{ old('wali_kelas_id', $rombel->wali_kelas_id) == $guru->id ? 'selected' : '' }}>
                                    {{ $guru->nama_guru }}
                                </option>
                            @endforeach
                        </select>
                        @error('wali_kelas_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- Tahun Ajaran --}}
                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-semibold">
                            Tahun Ajaran
                        </label>
                        <input type="hidden"
                               name="tahun_ajaran_id"
                               value="{{ $rombel->tahun_ajaran_id }}">

                        <input type="text"
                               class="form-control bg-light"
                               value="{{ $rombel->tahunAjaran->nama_tahun_ajaran }} {{ $rombel->tahunAjaran->semester }}"
                               readonly>
                    </div>

                </div>

                {{-- Tombol --}}
                <div class="d-flex justify-content-between mt-4">
                    <a href="{{ route('rombel.index') }}"
                       class="btn btn-gradient-secondary d-inline-flex align-items-center gap-2">
                        <i class="bi bi-arrow-left"></i>
                        Kembali
                    </a>

                    <button type="submit"
                            class="btn btn-gradient-primary d-inline-flex align-items-center gap-2">
                        <i class="bi bi-save"></i>
                        Update Rombel
                    </button>
                </div>

            </form>

        </div>
    </div>

</div>
@endsection
