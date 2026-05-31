@extends('layouts.app')

@section('content')
<div class="container pb-4">

    {{-- Header --}}
    <div class="mb-4">
        <h3 class="gradient-text-primary">
            <i class="bi bi-bullseye me-2"></i>
            Tambah Tujuan Pembelajaran
        </h3>
        <p class="text-muted mb-0">
            {{ $guruMapel->mapel->nama_mapel }} –
            {{ $guruMapel->rombel->nama_rombel }}
        </p>
    </div>

    {{-- Card Form --}}
    <div class="card border-0 shadow-sm">
        <div class="card-body">

            <form action="{{ route('tujuan-pembelajaran.store', $guruMapel->id) }}"
                  method="POST">
                @csrf

                <div class="row">

                    {{-- Nama Tujuan --}}
                    <div class="col-md-12 mb-3">
                        <label class="form-label fw-semibold">
                            Nama Tujuan Pembelajaran
                        </label>
                        <input type="text"
                               name="nama_tujuan"
                               class="form-control @error('nama_tujuan') is-invalid @enderror"
                               value="{{ old('nama_tujuan') }}"
                               placeholder="Contoh: Peserta didik mampu memahami ..."
                               required>
                        @error('nama_tujuan')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- Deskripsi --}}
                    <div class="col-md-12 mb-3">
                        <label class="form-label fw-semibold">
                            Deskripsi
                        </label>
                        <textarea name="deskripsi"
                                  class="form-control @error('deskripsi') is-invalid @enderror"
                                  rows="4"
                                  placeholder="Deskripsi tambahan tujuan pembelajaran">{{ old('deskripsi') }}</textarea>
                        @error('deskripsi')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                </div>

                {{-- Tombol --}}
                <div class="d-flex justify-content-between mt-4">
                    <a href="{{ route('tujuan-pembelajaran.show', $guruMapel->id) }}"
                       class="btn btn-gradient-secondary d-inline-flex align-items-center gap-2">
                        <i class="bi bi-arrow-left"></i>
                        Kembali
                    </a>

                    <button type="submit"
                            class="btn btn-gradient-primary d-inline-flex align-items-center gap-2">
                        <i class="bi bi-save"></i>
                        Simpan Tujuan
                    </button>
                </div>

            </form>

        </div>
    </div>

</div>
@endsection
