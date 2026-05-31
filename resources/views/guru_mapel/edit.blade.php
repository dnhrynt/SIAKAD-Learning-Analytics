@extends('layouts.app')

@section('content')
<div class="container pb-4">

    {{-- Header --}}
    <div class="mb-4">
        <h3 class="gradient-text-primary">
            <i class="bi bi-pencil-square me-2"></i>
            Edit Penugasan Guru
        </h3>
        <p class="text-muted mb-0">
            Perbarui data penugasan guru sesuai kewenangan Anda
        </p>
    </div>

    {{-- Card Form --}}
    <div class="card border-0 shadow-sm">
        <div class="card-body">

            <form action="{{ route('guru-mapel.update', $data->id) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="row">

                    {{-- ROLE 2 : Admin --}}
                    @if(auth()->user()->hasRole(2))

                        {{-- Guru --}}
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-semibold">
                                Guru
                            </label>
                            <select name="guru_id"
                                    class="form-select @error('guru_id') is-invalid @enderror">
                                @foreach($guruList as $guru)
                                    <option value="{{ $guru->id }}"
                                        {{ old('guru_id', $data->guru_id) == $guru->id ? 'selected' : '' }}>
                                        {{ $guru->nama_guru }}
                                    </option>
                                @endforeach
                            </select>
                            @error('guru_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Mata Pelajaran --}}
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-semibold">
                                Mata Pelajaran
                            </label>
                            <select name="mapel_id"
                                    class="form-select @error('mapel_id') is-invalid @enderror">
                                @foreach($mapelList as $mapel)
                                    <option value="{{ $mapel->id }}"
                                        {{ old('mapel_id', $data->mapel_id) == $mapel->id ? 'selected' : '' }}>
                                        {{ $mapel->nama_mapel }}
                                    </option>
                                @endforeach
                            </select>
                            @error('mapel_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Rombel --}}
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-semibold">
                                Rombongan Belajar
                            </label>
                            <select name="rombel_id"
                                    class="form-select @error('rombel_id') is-invalid @enderror">
                                @foreach($rombelList as $rombel)
                                    <option value="{{ $rombel->id }}"
                                        {{ old('rombel_id', $data->rombel_id) == $rombel->id ? 'selected' : '' }}>
                                        {{ $rombel->nama_rombel }}
                                    </option>
                                @endforeach
                            </select>
                            @error('rombel_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                    @endif

                    {{-- GURU TERKAIT : hanya KKTp --}}
                    @if(auth()->user()->hasRole(5) && auth()->user()->guru_id == $data->guru_id)

                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-semibold">
                                KKTp
                            </label>
                            <input type="number"
                                   name="kktp"
                                   class="form-control @error('kktp') is-invalid @enderror"
                                   value="{{ old('kktp', $data->kktp) }}"
                                   min="0">
                            @error('kktp')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                    @endif

                </div>

                {{-- Tombol --}}
                <div class="d-flex justify-content-between mt-4">
                    <a href="{{ route('guru-mapel.index') }}"
                       class="btn btn-gradient-secondary d-inline-flex align-items-center gap-2">
                        <i class="bi bi-arrow-left"></i>
                        Kembali
                    </a>

                    <button type="submit"
                            class="btn btn-gradient-primary d-inline-flex align-items-center gap-2">
                        <i class="bi bi-save"></i>
                        Update Penugasan
                    </button>
                </div>

            </form>

        </div>
    </div>

</div>
@endsection
