@extends('layouts.app')

@section('content')
<div class="container">
    <div class="mb-3">
        <h3 class="gradient-text-info mb-4">
            <i class="bi bi-book-fill me-2"></i>
            Manajemen Mata Pelajaran
        </h3>

            <div class="text-end">
                <a href="{{ route('mapel.create') }}"
                class="btn btn-gradient-secondary">
                    <i class="bi bi-plus-circle me-1"></i>
                    Tambah Mapel
                </a>
            </div>
    </div>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <table class="table table-bordered table-hover align-middle">
        <thead class="table-light">
            <tr>
                <th width="5%">No</th>
                <th>Kode Mapel</th>
                <th>Nama Mapel</th>
                <th width="20%">Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse($mapels as $mapel)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $mapel->kode_mapel }}</td>
                    <td>{{ $mapel->nama_mapel }}</td>
                    <td class="gap-2 justify-content-center d-flex align-items-center">
                        <a href="{{ route('mapel.edit', $mapel->id) }}" class="gradient-text-primary">
                            <i class="bi bi-pencil-square fs-5"></i>
                        </a>

                        <form action="{{ route('mapel.destroy', $mapel->id) }}" 
                              method="POST" 
                              class="d-inline"
                              onsubmit="return confirm('Yakin ingin menghapus?')">
                            @csrf
                            @method('DELETE')
                            <button class="btn text-danger">
                                <i class="bi bi-trash3-fill fs-5"></i>
                            </button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="4" class="text-center text-muted">
                        Data mata pelajaran belum tersedia
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
