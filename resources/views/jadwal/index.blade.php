@extends('layouts.app')

@section('content')
<div class="container">

    {{-- Header --}}
    <h3 class="gradient-text-info mb-3">
        <i class="bi bi-calendar-week-fill"></i>
        Jadwal Pelajaran
        <small class="text-muted">
            ({{ $tahunAktif->nama_tahun_ajaran }} {{ $tahunAktif->semester }})
        </small>
    </h3>

    {{-- Action Bar --}}
    <div class="text-end mb-3">
        {{-- Tombol tambah (role 1 & 2) --}}
        @if(auth()->user()->roles->contains('id', 1) || auth()->user()->roles->contains('id', 2))
            <a href="{{ route('jadwal.create') }}"
               class="btn btn-gradient-secondary d-inline-flex align-items-center gap-2">
                <i class="bi bi-plus-circle fs-5"></i>
                <span class="fw-bold">Tambah Jadwal</span>
            </a>
        @endif
    </div>

    {{-- Jika belum ada jadwal --}}
    @if ($jadwal->isEmpty())
        <div class="alert alert-info">
            Jadwal belum tersedia.
        </div>
    @endif

    {{-- Jadwal per Hari --}}
    @foreach ($jadwal as $hari => $items)

        @php
            $isWali = auth()->user()->roles->contains('id', 3);
        @endphp

        <div class="card mb-4 shadow-sm">
            <div class="card-header fw-bold text-secondary">
                <i class="bi bi-calendar-event me-1"></i>
                {{ $hari }}
            </div>

            <div class="table-responsive">

                {{-- ===============================
                    ROLE 3 (WALI KELAS)
                =============================== --}}
                @if($isWali)

                    <table class="table table-bordered table-hover align-middle mb-0">
                        <thead class="table-light">
                            <tr class="text-center">
                                <th style="width:200px">Jam</th>
                                <th>Mata Pelajaran</th>
                                <th>Guru Pengajar</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($items->sortBy(fn($i) => $i->jam->jam_mulai) as $row)
                                <tr>
                                    <td class="text-center fw-semibold">
                                        {{ $row->jam->jam_mulai }} - {{ $row->jam->jam_selesai }}
                                    </td>
                                    <td>
                                        {{ $row->guruMapel->mapel->nama_mapel }}
                                    </td>
                                    <td>
                                        {{ $row->guruMapel->guru->nama_guru }}
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>

                {{-- ===============================
                    ROLE 1 & 2 (ADMIN / KURIKULUM)
                =============================== --}}
                @else

                    @php
                        $perJam = $items->groupBy('jam_id');
                    @endphp

                    <table class="table table-bordered align-middle mb-0">
                        <thead class="table-light">
                            <tr class="text-center">
                                <th style="width:140px">Jam</th>
                                @foreach($rombels as $rombel)
                                    <th>{{ $rombel->nama_rombel }}</th>
                                @endforeach
                            </tr>
                        </thead>

                        <tbody>
                            @foreach ($perJam->sortBy(fn($rows) => $rows->first()->jam->jam_mulai) as $jamId => $rows)

                                @php
                                    $jam = $rows->first()->jam;
                                @endphp

                                <tr>
                                    <td class="text-center fw-semibold">
                                        {{ $jam->jam_mulai }} - {{ $jam->jam_selesai }}
                                    </td>

                                    @foreach($rombels as $rombel)
                                        @php
                                            $cell = $rows->firstWhere(
                                                fn($r) => $r->guruMapel->rombel_id == $rombel->id
                                            );
                                        @endphp

                                        <td class="text-center">
                                            @if($cell)
                                                <div class="text-muted small">
                                                    {{ $cell->guruMapel->mapel->nama_mapel }}
                                                </div>
                                                    <a href="{{ route('jadwal.edit', $cell->id) }}"
                                                    class="gradient-text-primary">
                                                        <i class="bi bi-pencil-square"></i>
                                                    </a>
                                            @else
                                                <span class="text-muted">-</span>
                                            @endif
                                        </td>
                                    @endforeach
                                </tr>

                            @endforeach
                        </tbody>
                    </table>

                @endif

            </div>
        </div>

    @endforeach

</div>
@endsection
