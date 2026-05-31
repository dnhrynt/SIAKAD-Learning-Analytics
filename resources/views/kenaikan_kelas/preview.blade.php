@extends('layouts.app')

@section('content')
<div class="container">

    {{-- HEADER --}}
    <div class="mb-4">
        <h3 class="gradient-text-info">
            <i class="bi bi-arrow-up-circle-fill me-2"></i>
            Preview Kenaikan Kelas
        </h3>

        <p class="text-muted mb-0">
            Dari Rombel
            <strong>{{ $rombel->nama_rombel }}</strong>
            ({{ $rombel->tahunAjaran->nama_tahun_ajaran }} {{ $rombel->tahunAjaran->semester }})
        </p>
    </div>

    @if(!$tahunTujuan || $rombelTujuan->isEmpty())
        <div class="alert alert-warning text-center">
            <p class="mb-3">
                Proses kenaikan kelas belum bisa dilakukan karena belum ada rombel tujuan yang disiapkan oleh kurikulum.
            </p>

            <a href="{{ route('siswa.index') }}" class="btn btn-gradient-secondary">
                <i class="bi bi-arrow-left"></i>
                Kembali
            </a>
        </div>
    @else

        {{-- FORM --}}
        <form action="{{ route('kenaikan-kelas.proses', $rombel->id) }}"
            method="POST">
            @csrf

            {{-- PILIH ROMBEL TUJUAN --}}
            <div class="card mb-4 border-0 shadow-sm">
                <div class="card-body">
                    <label class="form-label fw-semibold">
                        Rombel Tujuan (Tahun Ajaran Baru)
                    </label>

                    <select name="rombel_tujuan_id"
                            class="form-select @error('rombel_tujuan_id') is-invalid @enderror"
                            required>
                        <option value="">-- Pilih Rombel Tujuan --</option>
                        @foreach ($rombelTujuan as $tujuan)
                            <option value="{{ $tujuan->id }}">
                                {{ $tujuan->nama_rombel }}
                                ({{ $tujuan->tahunAjaran->nama_tahun_ajaran }} {{ $tujuan->tahunAjaran->semester }})
                            </option>
                        @endforeach
                    </select>

                    @error('rombel_tujuan_id')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            {{-- TABEL SISWA --}}
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-light fw-semibold">
                    Daftar Siswa yang Akan Naik Kelas
                </div>

                <div class="card-body p-0">
                    <table class="table table-bordered table-hover mb-0 align-middle">
                        <thead class="table-light">
                            <tr class="text-center">
                                <th width="5%">
                                    <input type="checkbox" id="checkAll">
                                </th>
                                <th width="5%">No</th>
                                <th>NIS</th>
                                <th>Nama Siswa</th>
                                <th width="10%">JK</th>
                            </tr>
                        </thead>

                        <tbody>
                            @forelse ($siswa as $item)
                            <tr>
                                <td class="text-center">
                                    <input type="checkbox"
                                        name="siswa_ids[]"
                                        value="{{ $item->siswa_id }}"
                                        checked>
                                </td>
                                <td class="text-center">{{ $loop->iteration }}</td>
                                <td>{{ $item->siswa->nis }}</td>
                                <td>{{ $item->siswa->nama_siswa }}</td>
                                <td class="text-center">
                                    {{ $item->siswa->jenis_kelamin }}
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="5" class="text-center text-muted py-3">
                                    Tidak ada siswa aktif di rombel ini
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            {{-- TOMBOL AKSI --}}
            <div class="d-flex justify-content-between mt-4">
                <a href="{{ route('siswa.index') }}"
                class="btn btn-gradient-secondary">
                    <i class="bi bi-arrow-left"></i>
                    Kembali
                </a>

                <button type="submit"
                        class="btn btn-gradient-primary">
                    <i class="bi bi-check-circle-fill me-1"></i>
                    Proses Kenaikan Kelas
                </button>
            </div>

        </form>
    @endif
</div>

{{-- SCRIPT CHECK ALL --}}
<script>
document.getElementById('checkAll')?.addEventListener('change', function () {
    document
        .querySelectorAll('input[name="siswa_ids[]"]')
        .forEach(cb => cb.checked = this.checked);
});
</script>
@endsection
