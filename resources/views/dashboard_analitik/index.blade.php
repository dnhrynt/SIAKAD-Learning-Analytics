@extends('layouts.app')

@section('content')
<div class="container">

    {{-- HEADER --}}
    <h3 class="gradient-text-info mb-5">
        <i class="bi bi-graph-up-arrow"></i>
        Dashboard Analitik Akademik
    </h3>

    {{-- FILTER TAHUN AJARAN --}}
    <div class="d-flex align-items-center gap-3 mb-4">

        <span class="text-secondary fw-semibold">
            Filter Tahun Ajaran
        </span>

        <form method="GET" action="{{ route('dashboard.analitik.index') }}">
            <select name="tahun_ajaran_id"
                    class="form-select text-secondary"
                    onchange="this.form.submit()">
                @foreach($allTahun as $ta)
                    <option value="{{ $ta->id }}"
                        {{ $selectedTahunId == $ta->id ? 'selected' : '' }}>
                        {{ $ta->nama_tahun_ajaran }}
                        {{ $ta->semester }}
                        {{ $ta->status === 'Aktif' ? '( Aktif )' : '' }}
                    </option>
                @endforeach
            </select>
        </form>

    </div>

    {{-- TAB NAV --}}
    @php
        $activeTab = $isManagement ? 'management' : ($isWali ? 'wali' : 'guru');
    @endphp

    <ul class="nav nav-tabs mb-4">
        @if($isManagement)
            <li class="nav-item">
                <button class="nav-link {{ $activeTab == 'management' ? 'active' : '' }}"
                        data-bs-toggle="tab"
                        data-bs-target="#management">
                    <i class="bi bi-buildings me-1"></i>
                    Management
                </button>
            </li>
        @endif

        @if($isWali)
            <li class="nav-item">
                <button class="nav-link {{ $activeTab == 'wali' ? 'active' : '' }}"
                        data-bs-toggle="tab"
                        data-bs-target="#wali">
                    <i class="bi bi-person-badge-fill me-1"></i>
                    Wali Kelas
                </button>
            </li>
        @endif

        @if($isGuru)
            <li class="nav-item">
                <button class="nav-link {{ $activeTab == 'guru' ? 'active' : '' }}"
                        data-bs-toggle="tab"
                        data-bs-target="#guru">
                    <i class="bi bi-journal-text me-1"></i>
                    Guru Pengajar
                </button>
            </li>
        @endif
    </ul>

    {{-- TAB CONTENT --}}
    <div class="tab-content">

        {{-- ================= MANAGEMENT ================= --}}
        @if($isManagement)
        <div class="tab-pane fade {{ $activeTab == 'management' ? 'show active' : '' }}" id="management">
            <div class="row g-4">
                @forelse($rombelManagement as $rombel)
                    <div class="col-md-4">
                        <div class="card h-100 shadow-sm border-0 rombel-card">
                            <div class="card-body text-center">

                                <i class="bi bi-house-fill fs-1 gradient-text-info mb-3"></i>

                                <h5 class="fw-bold gradient-text-info mb-1">
                                    {{ $rombel->nama_rombel }}
                                </h5>

                                <div class="text-muted mb-3">
                                    {{ $rombel->kelas->nama_kelas ?? 'Tingkat' }}
                                </div>

                                <a href="{{ route('dashboard.analitik.rombel', $rombel->id) }}"
                                   class="btn btn-gradient-secondary">
                                    <i class="bi bi-pie-chart-fill me-1"></i>
                                    Lihat Analitik
                                </a>

                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-12">
                        <div class="alert alert-secondary text-center small text-muted">
                            Data rombel belum tersedia
                        </div>
                    </div>
                @endforelse
            </div>
        </div>
        @endif

        {{-- ================= WALI KELAS ================= --}}
        @if($isWali)
        <div class="tab-pane fade {{ $activeTab == 'wali' ? 'show active' : '' }}" id="wali">
            @if($rombelWali)
                <div class="card shadow-sm border-0 text-center p-5">
                    <i class="bi bi-house-heart-fill fs-1 gradient-text-info mb-3"></i>

                    <h4 class="fw-bold gradient-text-info mb-1">
                        {{ $rombelWali->nama_rombel }}
                    </h4>

                    <div class="text-muted mb-4">
                        {{ $rombelWali->tahunAjaran->nama_tahun_ajaran }}
                    </div>

                    <a href="{{ route('dashboard.analitik.rombel', $rombelWali->id) }}"
                       class="btn btn-gradient-secondary btn-lg px-5">
                        <i class="bi bi-bar-chart-line-fill me-2"></i>
                        Buka Analitik Kelas
                    </a>
                </div>
            @else
                <div class="alert alert-secondary text-center text-muted">
                    Anda tidak terdaftar sebagai wali kelas pada tahun ajaran ini
                </div>
            @endif
        </div>
        @endif

        {{-- ================= GURU MAPEL ================= --}}
        @if($isGuru)
        <div class="tab-pane fade {{ $activeTab == 'guru' ? 'show active' : '' }}" id="guru">
            <div class="card shadow-sm border-0">
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table align-middle">
                            <thead class="table-light">
                                <tr>
                                    <th>Mata Pelajaran</th>
                                    <th>Rombel</th>
                                    <th>KKTP</th>
                                    <th class="text-center">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($mapelGuru as $gm)
                                    <tr>
                                        <td class="fw-semibold">
                                            {{ $gm->mapel->nama_mapel ?? '-' }}
                                        </td>
                                        <td>{{ $gm->rombel->nama_rombel ?? '-' }}</td>
                                        <td>{{ $gm->kktp }}</td>
                                        <td class="text-center">
                                            <a href="{{ route('dashboard.analitik.mapel', $gm->id) }}"
                                               class="btn btn-sm btn-gradient-secondary">
                                                <i class="bi bi-bar-chart-fill"></i>
                                            </a>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" class="text-center text-muted small">
                                            Tidak ada jadwal mengajar
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        @endif

    </div>
</div>
@endsection
