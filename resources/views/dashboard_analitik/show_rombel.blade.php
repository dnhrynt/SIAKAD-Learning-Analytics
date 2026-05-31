@extends('layouts.app')

@section('content')
<div class="container-fluid px-4 pb-4">

    {{-- HEADER --}}
    <div class="mb-4">
        <h4 class="gradient-text-info fw-bold mb-1">
            <i class="bi bi-bar-chart-line"></i>
            Analitik Kelas {{ $rombel->nama_rombel }} ({{ $rombel->tahunAjaran->nama_tahun_ajaran }} {{ $rombel->tahunAjaran->semester }})
        </h4>
        <small class="text-muted">
            Wali Kelas: {{ $rombel->waliKelas->nama_guru ?? '-' }}
        </small>
    </div>

    {{-- ================= GRAFIK PRESENSI ================= --}}
    <div class="card shadow-sm mb-4 px-5 py-3">
        <div class="card-body">

            <div class="row align-items-center gx-5">

                {{-- KIRI: DONUT --}}
                <div class="col-md-5 text-center">
                    <canvas id="presensiChart"
                            width="180"
                            height="180"
                            data-stats='@json(array_values($presensiGraph))'>
                    </canvas>

                    <div class="mt-3 small">
                        <span class="badge bg-excellent me-2">Excellent</span>
                        <span class="badge bg-warning-custom me-2">Warning</span>
                        <span class="badge bg-risk">Risk</span>
                    </div>
                </div>

                {{-- KANAN: RINGKASAN --}}
                <div class="col-md-7">

                    @php
                        $totalSiswa = array_sum($presensiGraph) ?: 1;

                        $persenRajin   = round($presensiGraph['Excellent'] / $totalSiswa * 100);
                        $persenAman    = round($presensiGraph['Warning'] / $totalSiswa * 100);
                        $persenWarning = round($presensiGraph['Risk'] / $totalSiswa * 100);
                    @endphp

                    <h6 class="fw-semibold mb-3">Ringkasan Kehadiran</h6>

                    {{-- Excellent --}}
                    <div class="mb-3">
                        <div class="d-flex justify-content-between small mb-1">
                            <span>Excellent</span>
                            <strong>{{ $persenRajin }}%</strong>
                        </div>
                        <div class="progress" style="height: 8px;">
                            <div class="progress-bar bg-excellent progress-dynamic"
                                data-value="{{ $persenRajin }}"
                                role="progressbar"
                                aria-valuemin="0"
                                aria-valuemax="100">
                            </div>
                        </div>
                    </div>

                    {{-- Warning --}}
                    <div class="mb-3">
                        <div class="d-flex justify-content-between small mb-1">
                            <span>Warning</span>
                            <strong>{{ $persenAman }}%</strong>
                        </div>
                        <div class="progress" style="height: 8px;">
                            <div class="progress-bar bg-warning-custom progress-dynamic"
                                data-value="{{ $persenAman }}"
                                role="progressbar"
                                aria-valuemin="0"
                                aria-valuemax="100">
                            </div>
                        </div>
                    </div>

                    {{-- Risk --}}
                    <div>
                        <div class="d-flex justify-content-between small mb-1">
                            <span>Risk</span>
                            <strong>{{ $persenWarning }}%</strong>
                        </div>
                        <div class="progress" style="height: 8px;">
                            <div class="progress-bar bg-risk progress-dynamic"
                                data-value="{{ $persenWarning }}"
                                role="progressbar"
                                aria-valuemin="0"
                                aria-valuemax="100">
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>


    {{-- ================= REKAP PRESENSI ================= --}}
    {{-- Filter Kategori --}}
    <div class="d-flex justify-content-between align-items-center mb-3">

        <h6 class="fw-semibold gradient-text-info mb-0">
            <i class="bi bi-clipboard-data"></i>
            Rekap Presensi Siswa
        </h6>

        <form method="GET">
            <select name="kategori"
                    class="form-select form-select-sm"
                    onchange="this.form.submit()">

                <option value="">Semua Kategori</option>

                <option value="Excellent"
                    {{ request('kategori') == 'Excellent' ? 'selected' : '' }}>
                    Excellent
                </option>

                <option value="Warning"
                    {{ request('kategori') == 'Warning' ? 'selected' : '' }}>
                    Warning
                </option>

                <option value="Risk"
                    {{ request('kategori') == 'Risk' ? 'selected' : '' }}>
                    Risk
                </option>

            </select>
        </form>

    </div>

    <div class="card shadow-sm mb-4">
        <div class="card-body p-0">

            <div class="px-3 pt-3 pb-2">
                <h6 class="fw-semibold gradient-text-info mb-0">
                    <i class="bi bi-clipboard-data"></i>
                    Rekap Presensi Siswa
                </h6>
            </div>

            <div class="card shadow-sm mt-4">
                <div class="table-responsive">
                    <table class="table table-sm align-middle mb-0">
                        <thead class="table-light text-center">
                            <tr>
                                <th width="10%">NIS</th>
                                <th class="text-start">Nama Siswa</th>
                                <th width="10%">Hadir</th>
                                <th width="10%">Sakit</th>
                                <th width="10%">Izin</th>
                                <th width="10%">Alfa</th>
                                <th width="15%">Kategori</th>
                            </tr>
                        </thead>

                        <tbody>
                        @foreach($rekapSiswa as $row)

                            <tr>
                                <td class="text-center">
                                    {{ $row['nis'] }}
                                </td>

                                <td>
                                    {{ $row['nama_siswa'] }}
                                </td>

                                <td class="text-center fw-semibold">
                                    {{ $row['hadir_persen'] }}%
                                </td>

                                <td class="text-center fw-semibold">
                                    {{ $row['sakit_persen'] }}%
                                </td>

                                <td class="text-center fw-semibold">
                                    {{ $row['izin_persen'] }}%
                                </td>

                                <td class="text-center fw-semibold">
                                    {{ $row['alfa_persen'] }}%
                                </td>

                                <td class="text-center">
                                    <span class="badge {{
                                        $row['kategori'] == 'Excellent'
                                            ? 'bg-excellent'
                                            : ($row['kategori'] == 'Warning'
                                                ? 'bg-warning-custom'
                                                : 'bg-risk')
                                    }}">
                                        {{ $row['kategori'] }}
                                    </span>
                                </td>
                            </tr>

                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    {{-- ================= MAPEL ================= --}}
    <div class="card shadow-sm mb-5">
        <div class="card-body">
            <h6 class="fw-semibold gradient-text-info mb-3">
                <i class="bi bi-journal-text"></i>
                Analitik Mata Pelajaran
            </h6>

            <div class="row">
                @foreach($listMapel as $gm)
                    <div class="col-md-3 mb-3">
                        <a href="{{ route('dashboard.analitik.mapel', $gm->id) }}"
                           class="text-decoration-none">
                            <div class="card h-100 shadow-sm hover-card">
                                <div class="card-body text-center">
                                    <i class="bi bi-book fs-2 gradient-text-primary"></i>
                                    <h6 class="mb-1 gradient-text-primary fw-semibold">
                                        {{ $gm->mapel->nama_mapel }}
                                    </h6>
                                    <small class="text-muted d-block">
                                        {{ $gm->guru->nama_guru }}
                                    </small>
                                    <small class="text-muted">
                                        KKTP: {{ $gm->kktp }}
                                    </small>
                                </div>
                            </div>
                        </a>
                    </div>
                @endforeach
            </div>
        </div>
    </div>

</div>

</div>

{{-- SCRIPT CHART JS --}}
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    const canvas = document.getElementById('presensiChart');
    const data = JSON.parse(canvas.dataset.stats);

    const total = data.reduce((a, b) => a + b, 0);
    const maxValue = Math.max(...data);
    const percent = total ? Math.round((maxValue / total) * 100) : 0;

    const centerText = {
        id: 'centerText',
        beforeDraw(chart) {
            const { width } = chart;
            const { height } = chart;
            const ctx = chart.ctx;
            ctx.restore();

            const fontSize = (height / 110).toFixed(2);
            ctx.font = `600 ${fontSize}em sans-serif`;
            ctx.textBaseline = 'middle';
            ctx.fillStyle = '#212529';

            const text = percent + '%';
            const textX = Math.round((width - ctx.measureText(text).width) / 2);
            const textY = height / 2;

            ctx.fillText(text, textX, textY);
            ctx.save();
        }
    };

    new Chart(canvas, {
        type: 'doughnut',
        data: {
            labels: ['Excellent', 'Warning', 'Risk'],
            datasets: [{
                data: data,
                backgroundColor: ['#3413f0ff', '#764ba2', '#f40f67ff'],
            }]
        },
        options: {
            cutout: '70%',
            plugins: {
                legend: { display: false }
            }
        },
        plugins: [centerText]
    });

    document.querySelectorAll('.progress-dynamic').forEach(bar => {
        const value = bar.dataset.value || 0;
        bar.style.width = value + '%';
        bar.setAttribute('aria-valuenow', value);
    });
</script>

@endsection