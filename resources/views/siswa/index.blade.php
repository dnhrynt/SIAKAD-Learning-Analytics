@extends('layouts.app')

@section('content')
<div class="container">

    {{-- Header --}}
    <div class="mb-3">
        <h3 class="gradient-text-info mb-1">
            <i class="bi bi-people-fill me-2"></i>
            Manajemen Siswa {{ $rombel->nama_rombel }} ( {{ $rombel->tahunAjaran->nama_tahun_ajaran }} {{ $rombel->tahunAjaran->semester }} )
        </h3>
        
        <div class="d-flex justify-content-between align-items-center mt-3">
        
            {{-- KIRI --}}
            <div>
                <a href="{{ route('rombel.kenaikan.preview', $rombel->id) }}" 
                   class="btn gradient-text-primary fw-bold">
                    <i class="bi bi-arrow-up-circle fs-5 me-1"></i>
                    Proses Kenaikan
                </a>
            </div>
        
            {{-- KANAN --}}
            <div class="d-flex gap-2">
                <a href="{{ route('presensi.index') }}" 
                   class="btn btn-gradient-primary">
                    <i class="bi bi-clipboard-check me-1"></i>
                    Presensi
                </a>
        
                <a href="{{ route('siswa.create') }}" 
                   class="btn btn-gradient-secondary">
                    <i class="bi bi-plus-circle me-1"></i>
                    Tambah Siswa
                </a>
            </div>
        
        </div>

    </div>

    {{-- Alert --}}
    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    {{-- Table --}}
    <table class="table table-bordered table-hover align-middle">
        <thead class="table-light text-center">
            <tr>
                <th width="5%">No</th>
                <th>NIS</th>
                <th>Nama Siswa</th>
                <th width="8%">JK</th>
                <th width="18%">Status</th>
                <th width="10%">Aksi</th>
            </tr>
        </thead>
        <tbody>
        @forelse ($rombelSiswa as $rs)
            <tr>
                <td class="text-center">{{ $loop->iteration }}</td>
                <td>{{ $rs->siswa->nis }}</td>
                <td>{{ $rs->siswa->nama_siswa }}</td>
                <td class="text-center">{{ $rs->siswa->jenis_kelamin }}</td>

                {{-- STATUS --}}
                <td>
                    <form action="{{ route('rombel-siswa.update-status', $rs->id) }}"
                          method="POST">
                        @csrf
                        @method('PUT')

                        <select name="status"
                                class="form-select form-select-sm"
                                onchange="this.form.submit()">

                            @foreach (['aktif','naik','tinggal','drop-out','lulus'] as $status)
                                <option value="{{ $status }}"
                                    {{ $rs->status === $status ? 'selected' : '' }}>
                                    {{ ucfirst($status) }}
                                </option>
                            @endforeach

                        </select>
                    </form>
                </td>

                {{-- AKSI --}}
                <td class="gap-2 justify-content-center d-flex align-items-center">
                    <a href="{{ route('siswa.edit', $rs->siswa_id) }}"
                       class="gradient-text-primary"
                       title="Edit Siswa">
                        <i class="bi bi-pencil-square fs-5"></i>
                    </a>
                </td>
            </tr>
        @empty
            <tr>
                <td colspan="6" class="text-center text-muted">
                    Data siswa belum tersedia
                </td>
            </tr>
        @endforelse
        </tbody>
    </table>

</div>
@endsection
