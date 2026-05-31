@extends('layouts.app')

@section('content')
<div class="container pb-4">

    {{-- Header --}}
    <div class="mb-4">
        <h3 class="gradient-text-primary">
            <i class="bi bi-pencil-square me-2"></i>
            Edit Mata Pelajaran
        </h3>
        <p class="text-muted mb-0">
            Perbarui data mata pelajaran
        </p>
    </div>

    {{-- Card Form --}}
    <div class="card border-0 shadow-sm">
        <div class="card-body">

            <form action="{{ route('mapel.update', $mapel->id) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="row">

                    {{-- Kode Mapel --}}
                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-semibold">
                            Kode Mata Pelajaran
                        </label>
                        <input type="text"
                               name="kode_mapel"
                               class="form-control @error('kode_mapel') is-invalid @enderror"
                               value="{{ old('kode_mapel', $mapel->kode_mapel) }}"
                               required>
                        @error('kode_mapel')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- Nama Mapel --}}
                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-semibold">
                            Nama Mata Pelajaran
                        </label>
                        <input type="text"
                               name="nama_mapel"
                               class="form-control @error('nama_mapel') is-invalid @enderror"
                               value="{{ old('nama_mapel', $mapel->nama_mapel) }}"
                               required>
                        @error('nama_mapel')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                </div>

                {{-- Tombol --}}
                <div class="d-flex justify-content-between mt-4">
                    <a href="{{ route('mapel.index') }}"
                       class="btn btn-gradient-secondary d-inline-flex align-items-center gap-2">
                        <i class="bi bi-arrow-left"></i>
                        Kembali
                    </a>

                    <button type="submit"
                            class="btn btn-gradient-primary d-inline-flex align-items-center gap-2">
                        <i class="bi bi-check-circle"></i>
                        Update Mapel
                    </button>
                </div>

            </form>

        </div>
    </div>

</div>
@endsection
