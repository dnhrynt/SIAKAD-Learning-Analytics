@extends('layouts.app')

@section('content')
<div class="container pb-4">

    {{-- Header --}}
    <div class="mb-4">
        <h3 class="gradient-text-primary">
            <i class="bi bi-person-plus-fill me-2"></i>
            Tambah Data Guru
        </h3>
        <p class="text-muted mb-0">
            Lengkapi data guru dengan benar sebelum menyimpan
        </p>
    </div>

    {{-- Card Form --}}
    <div class="card border-0 shadow-sm">
        <div class="card-body">

            <form action="{{ route('guru.store') }}" method="POST">
                @csrf

                <div class="row">
                    {{-- NIP --}}
                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-semibold">
                            NIP
                        </label>
                        <input type="text"
                               name="nip"
                               class="form-control"
                               placeholder="Masukkan NIP"
                               required>
                    </div>

                    {{-- Nama Guru --}}
                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-semibold">
                            Nama Guru
                        </label>
                        <input type="text"
                               name="nama_guru"
                               class="form-control"
                               placeholder="Masukkan nama lengkap"
                               required>
                    </div>

                    {{-- Jenis Kelamin --}}
                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-semibold">
                            Jenis Kelamin
                        </label>
                        <select name="jenis_kelamin" class="form-select" required>
                            <option value="">-- Pilih Jenis Kelamin --</option>
                            <option value="Laki-laki"
                                {{ old('jenis_kelamin') == 'Laki-laki' ? 'selected' : '' }}>
                                Laki-laki
                            </option>

                            <option value="Perempuan"
                                {{ old('jenis_kelamin') == 'Perempuan' ? 'selected' : '' }}>
                                Perempuan
                            </option>

                        </select>
                    </div>


                {{-- Tombol --}}
                <div class="d-flex justify-content-between mt-4">
                    <a href="{{ route('guru.index') }}"
                       class="btn btn-gradient-secondary">
                        <i class="bi bi-arrow-left me-1"></i>
                        Kembali
                    </a>

                    <button type="submit"
                            class="btn btn-gradient-primary">
                        <i class="bi bi-save me-1"></i>
                        Simpan Data
                    </button>
                </div>

            </form>

        </div>
    </div>

</div>
@endsection
