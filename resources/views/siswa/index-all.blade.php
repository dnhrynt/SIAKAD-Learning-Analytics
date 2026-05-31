@extends('layouts.app')

@section('content')
<div class="container pb-4">

    {{-- Header --}}
    <div class="mb-4">
        <h3 class="gradient-text-info">
            <i class="bi bi-people-fill me-2"></i>
            Data Siswa
            {{ $rombel->nama_rombel }}
        </h3>
        <p class="text-muted mb-0">
            {{ $rombel->waliKelas->nama_guru }}
        </p>
    </div>

    {{-- Back --}}
    <div class="mb-3 text-end">
        <a href="{{ route('rombel.index') }}"
           class="btn btn-gradient-secondary d-inline-flex align-items-center gap-2">
            <i class="bi bi-arrow-left"></i>
            Kembali
        </a>
    </div>

    {{-- Table --}}
    <div class="card border-0 shadow-sm">
        <div class="card-body p-0">
            <table class="table table-bordered table-hover align-middle mb-0">
                <thead class="table-light text-center">
                    <tr>
                        <th width="5%">No</th>
                        <th>NIS</th>
                        <th>Nama Siswa</th>
                        <th>JK</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($rombelSiswa as $rs)
                        <tr>
                            <td class="text-center">{{ $loop->iteration }}</td>
                            <td>{{ $rs->siswa->nis }}</td>
                            <td>{{ $rs->siswa->nama_siswa }}</td>
                            <td class="text-center">
                                {{ $rs->siswa->jenis_kelamin }}
                            </td>
                            <td class="text-center">
                                <span class="badge bg-secondary">
                                    {{ ucfirst($rs->status) }}
                                </span>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5"
                                class="text-center text-muted py-4">
                                Belum ada siswa di rombel ini
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

</div>
@endsection
