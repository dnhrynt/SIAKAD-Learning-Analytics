@extends('layouts.app')

@section('content')
<div class="container">
    <h3 class="gradient-text-info mb-5">
        <i class="bi bi-person-badge-fill"></i>
        Penugasan Guru
        @if($tahunId)
            <small class="text-muted">
                ({{ $tahunAjaranList->firstWhere('id', $tahunId)?->nama_tahun_ajaran }})
            </small>
        @endif
    </h3>

    <div class="d-flex justify-content-between align-items-center mb-3">
        <div class="d-inline-flex align-items-center gap-3">

            {{-- Label --}}
            <span class="text-secondary fw-semibold">
                Filter Tahun Ajaran
            </span>

            {{-- Filter --}}
            <form method="GET" style="max-width: 300px;">
                <select name="tahun_ajaran_id"
                        class="form-select text-secondary"
                        onchange="this.form.submit()">
                    @foreach ($tahunAjaranList as $ta)
                        <option value="{{ $ta->id }}"
                            {{ $ta->id == $tahunId ? 'selected' : '' }}>
                            {{ $ta->nama_tahun_ajaran }}
                            {{ $ta->semester }}
                            {{ $ta->status === 'Aktif' ? '(Aktif)' : '' }}
                        </option>
                    @endforeach
                </select>
            </form>

        </div>

        {{-- Button --}}
        <a href="{{ route('guru-mapel.create') }}"
        class="btn btn-gradient-secondary d-inline-flex align-items-center gap-2">
            <i class="bi bi-plus-circle fs-5"></i>
            <span class="fw-bold">Tugas Baru</span>
        </a>
    </div>


    <table class="table table-bordered table-hover align-middle">
        <thead>
            <tr>
                <th>Guru</th>
                <th>Mapel</th>
                <th>Rombel</th>
                <th>KKTp</th>
                <th width="120">Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach($guruMapels as $gm)
            <tr>
                <td>{{ $gm->guru->nama_guru }}</td>
                <td>{{ $gm->mapel->nama_mapel }}</td>
                <td>{{ $gm->rombel->nama_rombel }}</td>
                <td>{{ $gm->kktp }}</td>
                <td class="text-center">
                    <a href="{{ route('guru-mapel.edit', $gm->id) }}" class="gradient-text-primary">
                        <i class="bi bi-pencil-square fs-5"></i>
                    </a>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
