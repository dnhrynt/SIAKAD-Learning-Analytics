@extends('layouts.app')

@section('content')
<div class="container pb-4">

    {{-- Header --}}
    <div class="mb-4">

        {{-- Judul & Deskripsi --}}
        <div class="mb-3">
            <h3 class="gradient-text-info mb-1">
                <i class="bi bi-calendar2-week-fill me-2"></i>
                Manajemen Tahun Ajaran
            </h3>
            <p class="text-muted mb-0">
                Kelola data tahun ajaran dan tentukan tahun ajaran yang aktif
            </p>
        </div>

        {{-- Tombol Tambah --}}
        <div class="d-flex justify-content-end">
            <a href="{{ route('tahun-ajaran.create') }}"
            class="btn btn-gradient-secondary d-inline-flex align-items-center gap-2">
                <i class="bi bi-plus-circle"></i>
                <span>Tahun Ajaran Baru</span>
            </a>
        </div>

    </div>


    {{-- Alert --}}
    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show">
            <i class="bi bi-check-circle me-1"></i>
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    @if (session('error'))
        <div class="alert alert-danger alert-dismissible fade show">
            <i class="bi bi-exclamation-triangle me-1"></i>
            {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    {{-- Card Table --}}
    <div class="card border-0 shadow-sm">
        <div class="card-body p-0">

            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-light">
                        <tr class="text-center">
                            <th width="60">No</th>
                            <th class="text-start">Nama Tahun Ajaran</th>
                            <th width="120">Semester</th>
                            <th width="120">Status</th>
                            <th width="160">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($tahunAjaran as $item)
                            <tr>
                                <td class="text-center">{{ $loop->iteration }}</td>

                                <td>
                                    <div class="d-inline-flex align-items-center gap-2">
                                        <span class="fw-semibold">
                                            {{ $item->nama_tahun_ajaran }}
                                        </span>

                                        @if ($item->status === 'Aktif')
                                            <span class="small text-muted">
                                                ( Tahun ajaran aktif )
                                            </span>
                                        @endif
                                    </div>
                                </td>


                                <td class="text-center">
                                    <span class="badge bg-info-subtle text-dark">
                                        {{ $item->semester }}
                                    </span>
                                </td>

                                <td class="text-center">
                                    @if ($item->status === 'Aktif')
                                        <span class="badge bg-success">
                                            <i class="bi bi-check-circle me-1"></i>
                                            Aktif
                                        </span>
                                    @else
                                        <span class="badge bg-secondary">
                                            Non-Aktif
                                        </span>
                                    @endif
                                </td>

                                <td class="text-center">
                                    <div class="d-inline-flex gap-1">

                                        <a href="{{ route('tahun-ajaran.edit', $item->id) }}"
                                           class="btn gradient-text-primary"
                                           title="Edit">
                                            <i class="bi bi-pencil-square fs-4"></i>
                                        </a>

                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center py-4 text-muted">
                                    <i class="bi bi-inbox fs-4 d-block mb-2"></i>
                                    Data tahun ajaran belum tersedia
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

        </div>
    </div>

</div>
@endsection
