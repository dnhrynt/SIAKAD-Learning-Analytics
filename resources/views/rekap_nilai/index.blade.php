@extends('layouts.app')

@section('content')
<div class="container-fluid px-4">

    {{-- HEADER --}}
    <div class="mb-4">
        <h4 class="mt-2 mb-1 gradient-text-info">
            <i class="bi bi-journal-text me-1"></i>
            Rekap Nilai Siswa
        </h4>
        <small class="text-muted">
            Daftar rekap nilai akademik siswa dalam berbagai mata pelajaran dan tahun ajaran.
        </small>
    </div>

    <div class="card shadow-sm mb-4">
        <div class="card-header bg-light fw-bold d-flex justify-content-between align-items-center">
            <div>
                <i class="bi bi-people-fill me-1"></i>
                Daftar Siswa
            </div>

            {{-- SEARCH --}}
            <form action="{{ route('rekap-nilai.index') }}" method="GET" class="d-flex" style="max-width: 300px;">
                <input type="text"
                       name="q"
                       value="{{ request('q') }}"
                       class="form-control form-control-sm me-2"
                       placeholder="Cari nama siswa...">
                <button class="btn btn-sm btn-outline-secondary" type="submit">
                    <i class="bi bi-search"></i>
                </button>
            </form>
        </div>

        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-hover align-middle">
                    <thead class="table-secondary text-center">
                        <tr>
                            <th width="5%">#</th>
                            <th width="15%">NIS</th>
                            <th>Nama Siswa</th>
                            <th width="150">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($siswaList as $siswa)
                            <tr>
                                <td class="text-center">{{ $loop->iteration }}</td>
                                <td class="text-center">{{ $siswa->nis }}</td>
                                <td>{{ $siswa->nama_siswa }}</td>
                                <td class="text-center">
                                    <a href="{{ route('rekap-nilai.show', $siswa->id) }}"
                                       class="btn btn-sm btn-outline-primary">
                                        <i class="bi bi-eye me-1"></i>
                                        Lihat Rekap
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="text-center text-muted py-4">
                                    <i class="bi bi-info-circle me-1"></i>
                                    Data siswa tidak ditemukan
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
