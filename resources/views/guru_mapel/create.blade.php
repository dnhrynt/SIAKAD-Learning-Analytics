@extends('layouts.app')

@section('content')
<div class="container pb-4">

    {{-- Header --}}
    <div class="mb-4">
        <h3 class="gradient-text-primary">
            <i class="bi bi-person-badge-fill me-2"></i>
            Tambah Penugasan Guru
        </h3>
        <p class="text-muted mb-0">
            Menetapkan guru pengampu mata pelajaran pada rombongan belajar
        </p>
    </div>

    {{-- Card Form --}}
    <div class="card border-0 shadow-sm">
        <div class="card-body">

            <form action="{{ route('guru-mapel.store') }}" method="POST">
                @csrf

                <div class="row">

                    {{-- Guru --}}
                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-semibold">
                            Guru
                        </label>
                        <select name="guru_id"
                                class="form-select @error('guru_id') is-invalid @enderror"
                                required>
                            <option value="">-- Pilih Guru --</option>
                            @foreach($guruList as $guru)
                                <option value="{{ $guru->id }}"
                                    {{ old('guru_id') == $guru->id ? 'selected' : '' }}>
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
                                class="form-select @error('mapel_id') is-invalid @enderror"
                                required>
                            <option value="">-- Pilih Mata Pelajaran --</option>
                            @foreach($mapelList as $mapel)
                                <option value="{{ $mapel->id }}"
                                    {{ old('mapel_id') == $mapel->id ? 'selected' : '' }}>
                                    {{ $mapel->nama_mapel }}
                                </option>
                            @endforeach
                        </select>
                        @error('mapel_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    {{-- Rombongan Belajar --}}
                    <div class="col-12 mb-3">
                        <label class="form-label fw-semibold mb-2">
                            Rombongan Belajar
                        </label>
                    
                        {{-- Checkbox Pilih Semua --}}
                        <div class="form-check mb-3">
                            <input class="form-check-input me-2" type="checkbox" id="checkAll">
                            <label class="form-check-label fw-semibold" for="checkAll">
                                Pilih Semua Rombel
                            </label>
                        </div>
                    
                        {{-- List Rombel --}}
                        <div class="row">
                            @foreach($rombelList as $rombel)
                                <div class="col-md-4 col-sm-6 mb-2">
                                    <div class="form-check">
                                        <input class="form-check-input me-2"
                                               type="checkbox"
                                               name="rombel_id[]"
                                               value="{{ $rombel->id }}"
                                               id="rombel{{ $rombel->id }}"
                                               {{ (is_array(old('rombel_id')) && in_array($rombel->id, old('rombel_id'))) ? 'checked' : '' }}>
                    
                                        <label class="form-check-label" for="rombel{{ $rombel->id }}">
                                            {{ $rombel->nama_rombel }}
                                        </label>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    
                        @error('rombel_id')
                            <div class="text-danger small mt-2">{{ $message }}</div>
                        @enderror
                    </div>


                    {{-- Tahun Ajaran (Read Only dari Rombel Aktif) --}}
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
                    <a href="{{ route('guru-mapel.index') }}"
                       class="btn btn-gradient-secondary d-inline-flex align-items-center gap-2">
                        <i class="bi bi-arrow-left"></i>
                        Kembali
                    </a>

                    <button type="submit"
                            class="btn btn-gradient-primary d-inline-flex align-items-center gap-2">
                        <i class="bi bi-save"></i>
                        Simpan Penugasan
                    </button>
                </div>

            </form>

        </div>
    </div>

</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    const checkAll = document.getElementById('checkAll');

    if (checkAll) {
        checkAll.addEventListener('change', function () {
            document.querySelectorAll('input[name="rombel_id[]"]').forEach(cb => {
                cb.checked = this.checked;
            });
        });
    }
});
</script>
@endpush

