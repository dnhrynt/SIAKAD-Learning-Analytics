@extends('layouts.app')

@section('content')
<div class="container-fluid px-4">

    {{-- HEADER --}}
    <h4 class="mt-4 mb-2 gradient-text-info">
        <i class="bi bi-clipboard-data me-1"></i>
        Rekap Nilai Akademik
        <span class="fw-normal">– {{ $siswa->nama_siswa }}</span>
    </h4>

    {{-- TOMBOL KEMBALI --}}
    <div class="d-flex justify-content-end mb-3">
        <a href="{{ route('rekap-nilai.index') }}" class="btn btn-gradient-secondary">
            <i class="bi bi-arrow-left me-1"></i>
            Kembali
        </a>
    </div>

    <div class="card shadow-sm mb-4">
        <div class="card-header bg-light fw-bold">
            <i class="bi bi-table me-1"></i>
            Rekap Nilai Per Semester
        </div>

        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-hover align-middle text-center">
                    <thead class="table-secondary">
                        <tr>
                            <th class="text-start">Mata Pelajaran</th>
                            @foreach ($tahunAjaran as $ta)
                                <th>
                                    {{ $ta->nama_tahun_ajaran }}
                                    <br>
                                    <small>{{ $ta->semester }}</small>
                                </th>
                            @endforeach
                        </tr>
                    </thead>

                    <tbody>
                        @foreach ($rekap as $row)
                            <tr>
                                <td class="text-start fw-semibold">
                                    {{ $row['mapel'] }}
                                </td>

                                @foreach ($tahunAjaran as $ta)
                                    <td>
                                        {{ $row['nilai'][$ta->id] ?? '-' }}
                                    </td>
                                @endforeach
                            </tr>
                        @endforeach

                        @if(count($rekap) === 0)
                            <tr>
                                <td colspan="{{ 1 + count($tahunAjaran) }}"
                                    class="text-center text-muted py-4">
                                    <i class="bi bi-info-circle me-1"></i>
                                    Data nilai belum tersedia
                                </td>
                            </tr>
                        @endif
                    </tbody>
                </table>
            </div>
        </div>
    </div>

</div>
@endsection
