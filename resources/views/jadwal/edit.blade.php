@extends('layouts.app')

@section('content')
<div class="container pb-4">

    {{-- Header --}}
    <div class="mb-4">
        <h3 class="gradient-text-primary">
            <i class="bi bi-pencil-square me-2"></i>
            Edit Jadwal Pelajaran
        </h3>
        <p class="text-muted mb-0">
            Perbarui jadwal pelajaran untuk tahun ajaran aktif
        </p>
    </div>

    {{-- Card Form --}}
    <div class="card border-0 shadow-sm">
        <div class="card-body">

            <form action="{{ route('jadwal.update', $jadwal->id) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="row">

                    {{-- Guru - Mapel - Rombel --}}
                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-semibold">
                            Guru • Mapel • Rombel
                        </label>
                        <select name="guru_mapel_id"
                                class="form-select @error('guru_mapel_id') is-invalid @enderror"
                                required>
                            <option value="">-- Pilih Penugasan --</option>
                            @foreach($guruMapel as $gm)
                                <option value="{{ $gm->id }}"
                                    {{ old('guru_mapel_id', $jadwal->guru_mapel_id) == $gm->id ? 'selected' : '' }}>
                                    {{ $gm->rombel->nama_rombel }} —
                                    {{ $gm->mapel->nama_mapel }} —
                                    {{ $gm->guru->nama_guru }}
                                </option>
                            @endforeach
                        </select>
                        @error('guru_mapel_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- Hari --}}
                    <div class="col-md-3 mb-3">
                        <label class="form-label fw-semibold">
                            Hari
                        </label>
                        <select name="hari_id"
                                class="form-select @error('hari_id') is-invalid @enderror"
                                required>
                            <option value="">-- Pilih Hari --</option>
                            @foreach($hari as $h)
                                <option value="{{ $h->id }}"
                                    {{ old('hari_id', $jadwal->hari_id) == $h->id ? 'selected' : '' }}>
                                    {{ $h->nama_hari }}
                                </option>
                            @endforeach
                        </select>
                        @error('hari_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- Jam --}}
                    <div class="col-md-3 mb-3">
                        <label class="form-label fw-semibold">
                            Jam Pelajaran
                        </label>
                        <select name="jam_id"
                                class="form-select @error('jam_id') is-invalid @enderror"
                                required>
                            <option value="">-- Pilih Jam --</option>
                            @foreach($jam as $j)
                                <option value="{{ $j->id }}"
                                    {{ old('jam_id', $jadwal->jam_id) == $j->id ? 'selected' : '' }}>
                                    {{ $j->jam_mulai }} - {{ $j->jam_selesai }}
                                </option>
                            @endforeach
                        </select>
                        @error('jam_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- Tahun Ajaran --}}
                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-semibold">
                            Tahun Ajaran Aktif
                        </label>
                        <input type="text"
                               class="form-control bg-light"
                               value="{{ $tahunAktif->nama_tahun_ajaran }} {{ $tahunAktif->semester }}"
                               readonly>
                    </div>

                </div>

                {{-- Tombol --}}
                <div class="d-flex justify-content-between mt-4">
                    <a href="{{ route('jadwal.index') }}"
                       class="btn btn-gradient-secondary d-inline-flex align-items-center gap-2">
                        <i class="bi bi-arrow-left"></i>
                        Kembali
                    </a>

                    <button type="submit"
                            class="btn btn-gradient-primary d-inline-flex align-items-center gap-2">
                        <i class="bi bi-save"></i>
                        Perbarui Jadwal
                    </button>
                </div>

            </form>

        </div>
    </div>

</div>
@endsection
