@extends('layouts.app')

@section('content')
<div class="container">

    <h3 class="gradient-text-info mb-5">
        <i class="bi bi-houses-fill"></i>
        Rombongan Belajar
        @if($tahunTampil)
            <small class="text-muted">
                ({{ $tahunTampil->nama_tahun_ajaran }})
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
            @foreach ($listTahun as $tahun)
                <option value="{{ $tahun->id }}"
                    {{ $tahunDipilih == $tahun->id ? 'selected' : '' }}>
                    {{ $tahun->nama_tahun_ajaran }}
                    {{ $tahun->semester }}
                    {{ $tahun->status === 'Aktif' ? '(Aktif)' : '' }}
                </option>
            @endforeach
        </select>
    </form>

</div>


        <a href="{{ route('rombel.create') }}" class="btn btn-gradient-secondary">
            <i class="bi bi-plus-circle me-1"></i> 
            Tambah Rombel
        </a>
    </div>


    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    {{-- GRID --}}
    <div class="row g-4">
        @forelse ($rombels as $rombel)
            <div class="col-md-4">
                <div class="card h-100 shadow-sm border-0 rombel-card">
                    <div class="card-body shadow-sm text-center">
                        <i class="bi bi-house-fill fs-1 gradient-text-info mb-3"></i>

                        <h5 class="fw-bold gradient-text-info mb-1">
                            {{ $rombel->nama_rombel }}
                        </h5>

                        <div class="text-muted mb-3">
                            {{ $rombel->waliKelas?->nama_guru ?? 'Belum ditentukan' }}
                        </div>

                        <div>
                            <a href="{{ route('rombel.siswa.index-all', $rombel->id) }}" class="btn">
                                <i class="bi bi-people-fill fs-5 gradient-text-primary me-2"></i>
                            </a>
                            <a href="{{ route('rombel.edit', $rombel->id) }}" class="btn">
                                <i class="bi bi-pencil-square fs-5 gradient-text-primary me-2"></i>
                            </a>

                        </div>

                        
                    </div>
                </div>
            </div>
        @empty
            <div class="col-12">
                <div class="alert alert-secondary text-center small text-muted">
                    Data rombongan belajar belum tersedia
                </div>
            </div>
        @endforelse
    </div>

</div>

@endsection
