@extends('layouts.app')

@section('content')
<div class="container-fluid px-4 pb-4">

    {{-- HEADER --}}
    <div class="mb-4">
        <h4 class="gradient-text-info fw-bold mb-1">
            <i class="bi bi-bar-chart-line"></i>
            Analitik Nilai {{ $guruMapel->mapel->nama_mapel }} Kelas {{ $guruMapel->rombel->nama_rombel }}
        </h4>
        <small class="text-muted">
            Guru : {{ $guruMapel->guru->nama_guru }} |
            KKTP : {{ $kktp }}
        </small>
    </div>

    {{-- ================= GRAFIK NILAI ================= --}}
    <div class="card shadow-sm mb-4 px-5 py-3">
        <div class="card-body">

            <div class="row align-items-center gx-5">

                {{-- KIRI: DONUT --}}
                <div class="col-md-5 text-center">
                    <canvas id="nilaiChart"
                            width="180"
                            height="180"
                            data-stats='@json(array_values($nilaiGraph))'>
                    </canvas>

                    <div class="mt-3 small">
                        <span class="badge bg-excellent me-2">Terlampaui</span>
                        <span class="badge bg-primary me-2">Tercapai</span>
                        <span class="badge bg-warning-custom me-2">Mendekati</span>
                        <span class="badge bg-risk">Tertinggal</span>
                    </div>
                </div>

                {{-- KANAN: RINGKASAN --}}
                <div class="col-md-7">

                    @php
                        $total = array_sum($nilaiGraph) ?: 1;

                        $pTerlampaui = round($nilaiGraph['terlampaui'] / $total * 100);
                        $pTercapai   = round($nilaiGraph['tercapai'] / $total * 100);
                        $pMendekati  = round($nilaiGraph['mendekati'] / $total * 100);
                        $pTertinggal = round($nilaiGraph['tertinggal'] / $total * 100);
                    @endphp

                    <h6 class="fw-semibold mb-3">Ringkasan Capaian</h6>

                    @foreach([
                        ['Terlampaui', $pTerlampaui, 'excellent'],
                        ['Tercapai', $pTercapai, 'primary'],
                        ['Mendekati', $pMendekati, 'warning-custom'],
                        ['Tertinggal', $pTertinggal, 'risk'],
                    ] as [$label, $value, $color])
                        <div class="mb-3">
                            <div class="d-flex justify-content-between small mb-1">
                                <span>{{ $label }}</span>
                                <strong>{{ $value }}%</strong>
                            </div>
                            <div class="progress" style="height:8px">
                                <div class="progress-bar bg-{{ $color }} progress-dynamic"
                                     data-value="{{ $value }}"></div>
                            </div>
                        </div>
                    @endforeach

                </div>
            </div>
        </div>
    </div>
    
    {{-- ================= SEBARAN NILAI ================= --}}
    <div class="card shadow-sm mb-4 px-4 py-3">
        <div class="card-body">

            <div class="row align-items-center g-4">

                {{-- KIRI: KKTP & MEAN --}}
                <div class="col-md-4 d-flex justify-content-center">
                    <div class="d-flex gap-5 align-items-center">

                        {{-- KKTP --}}
                        <div>
                            <div class="gradient-text-primary text-center">
                                <i class="bi bi-flag fs-4"></i>
                                <div class="small mt-1">KKTP</div>
                                <div class="fs-4 fw-bold">{{ $kktp }}</div>
                            </div>
                        </div>

                        {{-- MEAN --}}
                        <div>
                            <div class="gradient-text-info text-center">
                                <i class="bi bi-graph-up-arrow fs-4"></i>
                                <div class="small mt-1">MEAN</div>
                                <div class="fs-4 fw-bold">{{ $mean }}</div>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- KANAN: KESIMPULAN --}}
                <div class="col-md-8">
                    <h6 class="fw-semibold mb-2">
                        <i class="bi bi-info-circle"></i>
                        Kesimpulan
                    </h6>

                    <ul class="mb-0 ps-3 small">
                        <li>
                            <span class="{{ $meanClass }}">
                                {{ $meanMessage }}
                            </span>
                        </li>
                        <li class="mt-1">
                            <span class="{{ $stdDevClass }}">
                                {{ $stdDevMessage }}
                            </span>
                            <span class="text-muted">
                                (Standar Deviasi: {{ $stdDev }})
                            </span>
                        </li>
                    </ul>
                </div>

            </div>

        </div>
    </div>

    {{-- ================= REKAP NILAI ================= --}}
    <div class="card shadow-sm mb-5">
        <div class="card-body p-0">

            <div class="px-3 pt-3 pb-2 d-flex justify-content-between align-items-center flex-wrap gap-2">

                {{-- HEADING --}}
                <h6 class="fw-semibold gradient-text-info mb-0">
                    <i class="bi bi-clipboard-data"></i>
                    Rekap Nilai Siswa
                </h6>

                {{-- FILTER --}}
                <form method="GET" class="d-flex align-items-center gap-2">

                    <small class="text-muted">Filter:</small>

                    <select name="status"
                            class="form-select form-select-sm"
                            onchange="this.form.submit()">

                        <option value="">Semua Status</option>

                        <option value="terlampaui"
                            {{ request('status') == 'terlampaui' ? 'selected' : '' }}>
                            Terlampaui
                        </option>

                        <option value="tercapai"
                            {{ request('status') == 'tercapai' ? 'selected' : '' }}>
                            Tercapai
                        </option>

                        <option value="mendekati"
                            {{ request('status') == 'mendekati' ? 'selected' : '' }}>
                            Mendekati
                        </option>

                        <option value="tertinggal"
                            {{ request('status') == 'tertinggal' ? 'selected' : '' }}>
                            Tertinggal
                        </option>

                    </select>
                </form>

            </div>

            <div class="table-responsive">
                <table class="table table-sm table-bordered align-middle mb-0">
                    <thead class="table-light text-center">
                        <tr>
                            <th width="8%">NIS</th>
                            <th class="text-start">Nama Siswa</th>
                            @foreach($tps as $tp)
                                <th>{{ $tp->nama_tujuan }}</th>
                            @endforeach
                            <th width="10%">Nilai Rapor</th>
                            <th width="12%">Keterangan</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($rekapNilai as $row)
                        <tr>
                            <td class="text-center">{{ $row['nis'] }}</td>
                            <td>{{ $row['nama'] }}</td>

                            @foreach($tps as $tp)
                                <td class="text-center">
                                    {{ $row['nilai_tp'][$tp->nama_tujuan] ?? '-' }}
                                </td>
                            @endforeach

                            <td class="text-center fw-semibold">
                                {{ $row['nilai_rapor'] }}
                            </td>

                            <td class="text-center">
                                <span class="badge bg-{{
                                    $row['status']=='Terlampaui' ? 'excellent' :
                                    ($row['status']=='Tercapai' ? 'primary' :
                                    ($row['status']=='Mendekati' ? 'warning-custom' : 'risk'))
                                }}">
                                    {{ $row['status'] }}
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

{{-- SCRIPT --}}
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    const canvas = document.getElementById('nilaiChart');
    const data = JSON.parse(canvas.dataset.stats);

    new Chart(canvas, {
        type: 'doughnut',
        data: {
            labels: ['Terlampaui','Tercapai','Mendekati','Tertinggal'],
            datasets: [{
                data: data,
                backgroundColor: ['#3413f0ff','#6677ea','#764ba2','#f40f67ff']
            }]
        },
        options: {
            cutout: '70%',
            plugins: { legend: { display: false } }
        }
    });

    document.querySelectorAll('.progress-dynamic').forEach(bar => {
        bar.style.width = (bar.dataset.value || 0) + '%';
    });
</script>
@endsection
