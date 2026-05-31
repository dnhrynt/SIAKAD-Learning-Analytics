@extends('layouts.app')

@section('content')
<div class="container">

    {{-- Header --}}
    <div class="mb-3">
        <h3 class="gradient-text-info mb-4">
            <i class="bi bi-people-fill me-2"></i>
            Data Guru SMA Negeri 1 Grabagan
        </h3>

        @if(auth()->user()->hasRole(\App\Enums\UserRole::KEPALA_SEKOLAH))
            <div class="text-end">
                <a href="{{ route('guru.create') }}"
                class="btn btn-gradient-secondary">
                    <i class="bi bi-plus-circle me-1"></i>
                    Tambah Guru
                </a>
            </div>
        @endif
    </div>


    {{-- Card --}}
    <div class="card shadow-sm border-0">
        <div class="card-body">

            <div class="table-responsive">
                <table class="table table-bordered table-hover align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th>No</th>
                            <th>NIP</th>
                            <th >Nama Guru</th>
                            <th>Jenis Kelamin</th>
                            <th>No Telp</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($gurus as $guru)
                            <tr>
                                <td>
                                    {{ $loop->iteration }}
                                </td>
                                <td>{{ $guru->nip }}</td>
                                <td>{{ $guru->nama_guru }}</td>
                                <td>{{ $guru->jenis_kelamin }}</td>
                                <td>{{ $guru->no_telp ?? '-' }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center text-muted py-4">
                                    <i class="bi bi-info-circle me-1"></i>
                                    Data guru belum tersedia
                                </td>
                            </tr>
                        @endforelse
                    </tbody>

                </table>
            </div>

        </div>
    </div>

</div>
@endsection
