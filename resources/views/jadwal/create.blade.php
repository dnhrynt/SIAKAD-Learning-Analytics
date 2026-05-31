@extends('layouts.app')

@section('content')
<div class="container pb-4">

    {{-- Header --}}
    <div class="mb-4">
        <h3 class="gradient-text-primary">
            <i class="bi bi-calendar-plus-fill me-2"></i>
            Tambah Jadwal Pelajaran
            <small class="text-muted">
                ({{ $tahunAktif->nama_tahun_ajaran }} {{ $tahunAktif->semester }})
            </small>
        </h3>
        <p class="text-muted mb-0">
            Menyusun jadwal pelajaran untuk tahun ajaran aktif
        </p>
    </div>

    {{-- Card Form --}}
    <div class="card border-0 shadow-sm">
        <div class="card-body">

            <form action="{{ route('jadwal.store') }}" method="POST">
                @csrf

                <div class="row">

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
                                    {{ old('hari_id') == $h->id ? 'selected' : '' }}>
                                    {{ $h->nama_hari }}
                                </option>
                            @endforeach
                        </select>
                        @error('hari_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- Jam Pelajaran (Checkbox) --}}
                    <div class="col-12 mb-3">
                        <label class="form-label fw-semibold">
                            Jam Pelajaran
                        </label>
                    
                        <div class="row">
                            @foreach($jam as $j)
                                <div class="col-md-3 col-sm-4 col-6 mb-2">
                                    <div class="form-check">
                                        <input class="form-check-input"
                                               type="checkbox"
                                               name="jam_id[]"
                                               value="{{ $j->id }}"
                                               id="jam{{ $j->id }}"
                                               {{ in_array($j->id, old('jam_id', [])) ? 'checked' : '' }}>
                    
                                        <label class="form-check-label" for="jam{{ $j->id }}">
                                            {{ $j->jam_mulai }} - {{ $j->jam_selesai }}
                                        </label>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    
                        @error('jam_id')
                            <div class="text-danger small mt-1">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    {{-- Mata Pelajaran per Kelas --}}
                    <div class="col-12 mb-3">
                        <label class="form-label fw-semibold">
                            Mata Pelajaran per Kelas
                        </label>
                            <div class="row">
                                @foreach($rombels as $rombel)
                                    <div class="col-lg-4 col-md-6 mb-3">
                                        <div class="border rounded p-2 h-100 bg-light-subtle">
                                
                                            <label class="fw-semibold small gradient-text-primary">
                                                {{ $rombel->nama_rombel }}
                                            </label>
                                                <select name="guru_mapel_id[{{ $rombel->id }}]"
                                                        class="form-select form-select-sm mt-1">
                                                    <option value="">— Tidak ada jadwal —</option>
                                                
                                                    @foreach($guruMapel as $gm)
                                                        @if($gm->rombel_id == $rombel->id)
                                                            <option value="{{ $gm->id }}">
                                                                {{ $gm->mapel->nama_mapel }} — {{ $gm->guru->nama_guru }}
                                                            </option>
                                                        @endif
                                                    @endforeach
                                                </select>
                                
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @error('guru_mapel_id')
                            <div class="text-danger small">{{ $message }}</div>
                        @enderror
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
                        Simpan Jadwal
                    </button>
                </div>

            </form>

        </div>
    </div>

</div>
@endsection

