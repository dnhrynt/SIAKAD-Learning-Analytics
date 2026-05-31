@extends('layouts.app')

@section('content')
<div class="container pb-4">

    <div class="mb-3 ">
        <h4 class="fw-bold gradient-text-info">
            <i class="bi bi-clipboard-data"></i>
            Rekap Presensi {{ $rombel->nama_rombel }}
        </h4>
        <small class="text-muted">Tahun Ajaran {{ $rombel->tahunAjaran->nama_tahun_ajaran }} {{ $rombel->tahunAjaran->semester }}</small>
    </div>
    <div class="text-end mb-3">
        <a href="{{ route('presensi.index') }}" class="btn btn-gradient-secondary">
            <i class="bi bi-arrow-left"></i>
            Kembali
        </a>
    </div>

    <h5 class="fw-bold mb-3 gradient-text-primary">
        <i class="bi bi-clipboard2-check"></i>
        Ringkasan Kehadiran Tahunan
    </h5>
    
    <div class="card mb-4 shadow-sm">
        <div class="table-responsive">
            <table class="table table-sm table-bordered align-middle">
                <thead class="table-light text-center">
                    <tr>
                        <th width="8%">NIS</th>
                        <th class="text-start">Nama</th>
                        <th>H</th>
                        <th>S</th>
                        <th>I</th>
                        <th>A</th>
                        <th>% Hadir</th>
                    </tr>
                </thead>
                <tbody>
                @foreach($rombel->rombelSiswa as $item)
    
                    @php
                        $rekap = [
                            'Hadir'=>0,
                            'Sakit'=>0,
                            'Izin'=>0,
                            'Alfa'=>0
                        ];
    
                        foreach($item->presensi as $p){
                            $rekap[$p->status]++;
                        }
    
                        $total = array_sum($rekap) ?: 1;
                    @endphp
    
                    <tr class="text-center">
                        <td>{{ $item->siswa->nis }}</td>
                        <td class="text-start">{{ $item->siswa->nama_siswa }}</td>
                        <td>{{ $rekap['Hadir'] }}</td>
                        <td>{{ $rekap['Sakit'] }}</td>
                        <td>{{ $rekap['Izin'] }}</td>
                        <td>{{ $rekap['Alfa'] }}</td>
                        <td class="fw-semibold gradient-text-secondary">
                            {{ round($rekap['Hadir'] / $total * 100,1) }}%
                        </td>
                    </tr>
    
                @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <h5 class="fw-bold mb-3 gradient-text-primary">
        <i class="bi bi-calendar2-check"></i>
        Rincian Per Bulan
    </h5>
    
    @foreach($tanggalPerBulan as $bulan => $listTanggal)
    
        <div class="card mb-4 shadow-sm">
            <div class="card-header bg-light fw-semibold">
                {{ \Carbon\Carbon::createFromFormat('Y-m', $bulan)->translatedFormat('F Y') }}
            </div>
    
            <div class="table-responsive">
                <table class="table table-sm table-bordered align-middle mb-0">
                    <thead class="table-light text-center">
                        <tr>
                            <th width="8%">NIS</th>
                            <th class="text-start" width="22%">Nama</th>
    
                            @foreach($listTanggal as $tgl)
                                <th>
                                    {{ \Carbon\Carbon::parse($tgl)->format('d') }}
                                </th>
                            @endforeach
                        </tr>
                    </thead>
                    <tbody>
    
                    @foreach($rombel->rombelSiswa as $item)
    
                        @php
                            $presensiMap = $item->presensi->keyBy('tanggal');
                        @endphp
    
                        <tr class="text-center">
                            <td>{{ $item->siswa->nis }}</td>
                            <td class="text-start">{{ $item->siswa->nama_siswa }}</td>
    
                            @foreach($listTanggal as $tgl)
                                @php
                                    $status = $presensiMap[$tgl]->status ?? null;
                                @endphp
    
                                <td class="
                                    @switch($status)
                                        @case('Hadir') bg-excellent @break
                                        @case('Sakit') bg-good @break
                                        @case('Izin') bg-warning-custom @break
                                        @case('Alfa') bg-risk @break
                                    @endswitch
                                ">
                                    {{ $status ? substr($status,0,1) : '-' }}
                                </td>
                            @endforeach
                        </tr>
    
                    @endforeach
    
                    </tbody>
                </table>
            </div>
        </div>
    
    @endforeach


</div>

@endsection
