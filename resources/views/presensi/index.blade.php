@extends('layouts.app')

@section('content')
<div class="container pb-4">

    {{-- HEADER --}}
    <div class="mb-4">
        <h3 class="gradient-text-info mb-1">
            <i class="bi bi-clipboard-check me-2"></i>
            Presensi Siswa Kelas {{ $rombel->nama_rombel ?? '-' }}
        </h3>

        </div>
    </div>

    {{-- ALERT --}}
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show">
            <i class="bi bi-check-circle me-1"></i>
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    {{-- FILTER & ACTION --}}
    <div class="d-flex justify-content-between align-items-end mb-4">
                <div class="d-inline-flex align-items-center gap-3">

            <span class="text-secondary fw-semibold">
                Tanggal Presensi
            </span>

            <form method="GET"
                action="{{ route('presensi.index') }}"
                class="mb-0">

                <input type="date"
                    name="tanggal"
                    value="{{ $tanggal }}"
                    class="form-control"
                    onchange="this.form.submit()">
            </form>

        </div>

        <a href="{{ route('presensi.rekap.tahunan', $rombel->id) }}"
           class="btn btn-gradient-secondary">
            <i class="bi bi-calendar-check me-1"></i>
            Lihat Rekap
        </a>
    </div>

    {{-- FORM PRESENSI --}}
    <form action="{{ route('presensi.store') }}" method="POST">
        @csrf
        <input type="hidden" name="tanggal" value="{{ $tanggal }}">

        <div class="card shadow-sm border-0">
            <div class="card-body p-0">

                <div class="table-responsive">
                    <table class="table table-bordered align-middle mb-0">
                        <thead class="table-light text-center">
                            <tr>
                                <th width="50">No</th>
                                <th class="text-start">Nama Siswa</th>
                                <th width="90">Hadir</th>
                                <th width="90">Sakit</th>
                                <th width="90">Izin</th>
                                <th width="90">Alfa</th>
                            </tr>
                        </thead>

                        <tbody>
                            @forelse($rombelSiswa as $item)
                                @php
                                    $presensiHariIni = $item->presensi->first();
                                @endphp
                                <tr>
                                    <td class="text-center">
                                        {{ $loop->iteration }}
                                    </td>

                                    <td>
                                        <div class="fw-semibold">
                                            {{ $item->siswa->nama_siswa }}
                                        </div>
                                        <small class="text-muted">
                                            NIS: {{ $item->siswa->nis ?? '-' }}
                                        </small>
                                    </td>

                                    @foreach(['Hadir','Sakit','Izin','Alfa'] as $status)
                                        <td class="text-center">
                                            <input type="radio"
                                                   name="presensi[{{ $item->id }}]"
                                                   value="{{ $status }}"
                                                   {{ ($presensiHariIni?->status ?? 'Hadir') === $status ? 'checked' : '' }}
                                                   required>
                                        </td>
                                    @endforeach
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="text-center py-4 text-muted">
                                        <i class="bi bi-people me-1"></i>
                                        Tidak ada siswa aktif
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

            </div>

            @if($rombelSiswa->count())
                <div class="card-footer text-end bg-white">
                    <button type="submit" class="btn btn-gradient-primary">
                        <i class="bi bi-save me-1"></i>
                        Simpan Presensi
                    </button>
                </div>
            @endif
        </div>
    </form>

</div>
@endsection
