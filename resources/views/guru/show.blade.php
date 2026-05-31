@extends('layouts.app')

@section('content')
<div class="container">

    {{-- Alert sukses --}}
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="mb-3">
    <span class="gradient-text-secondary fw-semibold">
        <i class="bi bi-person-badge me-1"></i>
        Profil Saya
    </span>
</div>


            <div class="card shadow-sm border-0">
                <div class="card-body">

                    {{-- Header Profil --}}
<div class="d-flex align-items-center mb-4 p-3 rounded"
     style="background: linear-gradient(135deg, #667eeac7, #764ba2b0);">

    <div class="me-3">
        <i class="bi bi-person-circle fs-1 text-white"></i>
    </div>
    <div>
        <h4 class="mb-1 text-white fw-semibold">
            {{ $guru->nama_guru }}
        </h4>
        <small class="text-white-50">
            NIP: {{ $guru->nip ?? '-' }}
        </small>
    </div>
</div>


              

                    {{-- Detail Profil --}}
                    <table class="table table-borderless mb-4">
                        <tr>
                            <th width="180" class="text-muted">
                                Jenis Kelamin
                            </th>
                            <td class="fw-semibold">
                                {{ $guru->jenis_kelamin ?? '-' }}
                            </td>
                        </tr>
                        <tr>
                            <th class="text-muted">
                                Tempat, Tgl Lahir
                            </th>
                            <td class="fw-semibold">
                                {{ $guru->tempat_lahir ?? '-' }},
                                {{ $guru->tanggal_lahir
                                    ? \Carbon\Carbon::parse($guru->tanggal_lahir)->format('d M Y')
                                    : '-' }}
                            </td>
                        </tr>
                        <tr>
                            <th class="text-muted">
                                Agama
                            </th>
                            <td class="fw-semibold">
                                {{ $guru->agama ?? '-' }}
                            </td>
                        </tr>
                        <tr>
                            <th class="text-muted">
                                Alamat
                            </th>
                            <td class="fw-semibold">
                                {{ $guru->alamat ?? '-' }}
                            </td>
                        </tr>
                        <tr>
                            <th class="text-muted">
                                No. Telepon
                            </th>
                            <td class="fw-semibold">
                                {{ $guru->no_telp ?? '-' }}
                            </td>
                        </tr>
                    </table>

                    {{-- Aksi --}}
                    <div class="d-flex justify-content-end gap-2">
                        <a href="{{ route('guru.edit') }}"
                           class="btn btn-gradient-secondary">
                            <i class="bi bi-pencil-square me-1"></i>
                            Edit Profil
                        </a>
                    </div>

                </div>
            </div>

        </div>
    </div>
</div>
@endsection
