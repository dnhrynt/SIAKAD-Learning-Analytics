@extends('layouts.app')

@section('content')
<div class="container">

    {{-- HEADER --}}
    <div class="mb-3">
        <h3 class="gradient-text-info mb-2">
            <i class="bi bi-bullseye me-2"></i>
            Tujuan Pembelajaran
        </h3>

        <p class="text-muted mb-3">
            {{ $guruMapel->mapel->nama_mapel }} –
            {{ $guruMapel->rombel->nama_rombel }}
        </p>

        <div class="text-end">
            <a href="{{ route('tujuan-pembelajaran.create', $guruMapel->id) }}"
               class="btn btn-gradient-secondary">
                <i class="bi bi-plus-circle me-1"></i>
                Tambah Tujuan
            </a>
        </div>
    </div>

    {{-- TABLE --}}
    <table class="table table-bordered table-hover align-middle">
        <thead class="fw-bold">
            <tr>
                <th width="5%">No</th>
                <th width="20%">Nama Tujuan</th>
                <th width="25%">Deskripsi</th>
                <th width="35%">Jenis Penilaian</th>
                <th width="15%" class="text-center">Aksi</th>
            </tr>
        </thead>
        <tbody>

        @forelse($tujuanList as $tujuan)
            <tr>
                <td>{{ $loop->iteration }}</td>

                <td class="fw-semibold">
                    {{ $tujuan->nama_tujuan }}
                </td>

                <td>
                    {{ $tujuan->deskripsi ?? '-' }}
                </td>
{{-- JENIS PENILAIAN --}}
<td>
    @php
        $totalBobot = $tujuan->jenisPenilaian->sum('bobot');
    @endphp

    @forelse($tujuan->jenisPenilaian as $jp)
        <div class="d-flex justify-content-between align-items-center">
            <span>
                {{ $jp->nama_jenis }}
                <span class="text-muted">
                    ({{ $jp->bobot }}%)
                </span>
            </span>

            {{-- BUTTON EDIT --}}
            <button class="btn btn-link gradient-text-info"
                    data-bs-toggle="modal"
                    data-bs-target="#editJenisModal{{ $jp->id }}">
                <i class="bi bi-pencil-square fs-5"></i>
            </button>
        </div>

        {{-- MODAL EDIT (SATU PER DATA) --}}
        <div class="modal fade"
             id="editJenisModal{{ $jp->id }}"
             tabindex="-1">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">

                    {{-- Header --}}
                    <div class="modal-header">
                        <h5 class="modal-title gradient-text-primary">
                            <i class="bi bi-pencil-square me-2"></i>
                            Edit Jenis Penilaian
                        </h5>
                        <button type="button"
                                class="btn-close"
                                data-bs-dismiss="modal"></button>
                    </div>

                    {{-- Body --}}
                    <div class="modal-body">
                        <form action="{{ route('jenis-penilaian.update', $jp->id) }}"
                              method="POST">
                            @csrf
                            @method('PUT')

                            <div class="row">

                                <div class="col-md-12 mb-3">
                                    <label class="form-label fw-semibold">
                                        Nama Jenis
                                    </label>
                                    <input type="text"
                                           name="nama_jenis"
                                           class="form-control"
                                           value="{{ old('nama_jenis', $jp->nama_jenis) }}"
                                           required>
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label class="form-label fw-semibold">
                                        Bobot (%)
                                    </label>
                                    <input type="number"
                                           name="bobot"
                                           class="form-control"
                                           min="1"
                                           max="100"
                                           value="{{ old('bobot', $jp->bobot) }}"
                                           required>
                                </div>

                            </div>

                            {{-- Footer --}}
                            <div class="d-flex justify-content-end gap-2 mt-4">
                                <button type="button"
                                        class="btn btn-gradient-secondary"
                                        data-bs-dismiss="modal">
                                    Batal
                                </button>

                                <button type="submit"
                                        class="btn btn-gradient-primary d-inline-flex align-items-center gap-2">
                                    <i class="bi bi-save"></i>
                                    Update
                                </button>
                            </div>

                        </form>
                    </div>

                </div>
            </div>
        </div>

    @empty
        <span class="text-muted fst-italic">
            Belum ada jenis penilaian
        </span>
    @endforelse

    <div class="d-flex justify-content-between align-items-center pe-2">
        <div class="small text-muted mt-1">
            Total Bobot: <strong>{{ $totalBobot }}%</strong>
        </div>

        <button class="btn btn-sm btn-outline-primary mt-2"
                data-bs-toggle="modal"
                data-bs-target="#tambahJenisModal"
                data-tujuan="{{ $tujuan->id }}">
            <i class="bi bi-plus-circle me-1"></i>
            Tambah Jenis
        </button>
    </div>
</td>


                {{-- AKSI --}}
                <td class="text-center">
                    <a href="{{ route('tujuan-pembelajaran.edit', $tujuan->id) }}"
                       class="btn btn-link gradient-text-primary p-0 fs-5"
                       title="Edit Tujuan">
                        <i class="bi bi-pencil-square"></i>
                    </a>

                    <form action="{{ route('tujuan-pembelajaran.destroy', $tujuan->id) }}"
                          method="POST"
                          class="d-inline"
                          onsubmit="return confirm('Yakin hapus tujuan ini?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit"
                                class="btn btn-link text-danger p-0 fs-5"
                                title="Hapus Tujuan">
                            <i class="bi bi-trash3-fill"></i>
                        </button>
                    </form>
                </td>
            </tr>
        @empty
            <tr>
                <td colspan="5" class="text-center text-muted">
                    Belum ada tujuan pembelajaran
                </td>
            </tr>
        @endforelse

        </tbody>
    </table>

</div>


{{-- ================= MODAL TAMBAH ================= --}}
<div class="modal fade" id="tambahJenisModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
<form method="POST"
      action="{{ route('jenis-penilaian.store') }}"
      id="formTambahJenis"
      class="modal-content">            @csrf

            <input type="hidden" name="tujuan_pembelajaran_id" id="tambah_tujuan_id">
            <div class="modal-header">
                    <h5 class="gradient-text-primary">
                        <i class="bi bi-plus-circle me-2"></i>
                        Tambah Jenis Penilaian
                    </h5>

                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <div class="modal-body">
                <div class="mb-3">
                    <label class="form-label fw-semibold">Nama Jenis</label>
                    {{-- Tambahkan is-invalid jika ada error --}}
                    <input type="text" 
                           name="nama_jenis" 
                           class="form-control @error('nama_jenis') is-invalid @enderror" 
                           value="{{ old('nama_jenis') }}"
                           required>
                    
                    {{-- Tampilkan Pesan Error --}}
                    @error('nama_jenis')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label class="form-label fw-semibold">Bobot (%)</label>
                    <input type="number" 
                           name="bobot" 
                           class="form-control @error('bobot') is-invalid @enderror"
                           min="1" max="100" 
                           value="{{ old('bobot') }}"
                           required>

                    @error('bobot')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-gradient-secondary" data-bs-dismiss="modal">
                    Batal
                </button>
                <button type="submit" class="btn btn-gradient-primary gap-2 d-inline-flex align-items-center">
                    <i class="bi bi-save"></i>
                    Simpan
                </button>
            </div>
        </form>
    </div>
</div>

{{-- ================= MODAL EDIT ================= --}}
<div class="modal fade" id="editJenisModal" tabindex="-1">
    <div class="modal-dialog">
        <form method="POST" id="formEditJenis" class="modal-content">
            @csrf
            @method('PUT')

            <div class="modal-header">
                <h5 class="gradient-text-info">
                    <i class="bi bi-pencil me-2"></i>
                    Edit Jenis Penilaian
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <div class="modal-body">
                <div class="mb-3">
                    <label class="form-label">Nama Jenis</label>
                    <input type="text" name="nama_jenis" id="edit_nama" class="form-control" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Bobot (%)</label>
                    <input type="number" name="bobot" id="edit_bobot"
                           class="form-control" min="1" max="100" required>
                </div>
            </div>

            <div class="modal-footer">
                <button class="btn btn-gradient-secondary d-inline-flex align-items-center gap-2" data-bs-dismiss="modal">
                    <i class="bi bi-arrow-left"></i>
                    Batal
                </button>
                <button class="btn btn-gradient-primary d-inline-flex align-items-center gap-2">
                    <i class="bi bi-arrow-up-circle"></i>
                    Update
                </button>
            </div>
        </form>
    </div>
</div>

@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {

    const hasErrors   = "{{ $errors->any() ? '1' : '0' }}" === "1";
    const oldTujuanId = "{{ old('tujuan_pembelajaran_id') }}";
    const oldMethod   = "{{ old('_method') }}";

    /**
     * ===============================
     * HANDLE MODAL SAAT VALIDATION ERROR
     * ===============================
     */
    if (hasErrors) {

        // ERROR SAAT TAMBAH DATA
        if (oldTujuanId && oldMethod !== 'PUT') {
            const tambahModalEl = document.getElementById('tambahJenisModal');
            if (tambahModalEl) {
                document.getElementById('tambah_tujuan_id').value = oldTujuanId;
                new bootstrap.Modal(tambahModalEl).show();
            }
        }

        // ERROR SAAT EDIT DATA
        if (oldMethod === 'PUT') {
            const editModalEl = document.getElementById('editJenisModal');
            if (editModalEl) {
                new bootstrap.Modal(editModalEl).show();
            }
        }
    }

    /**
     * ===============================
     * MODAL TAMBAH JENIS PENILAIAN
     * ===============================
     */
    const tambahModal = document.getElementById('tambahJenisModal');
    if (tambahModal) {
        tambahModal.addEventListener('show.bs.modal', function (event) {
            const button = event.relatedTarget;
            if (!button) return;

            const tujuanId = button.getAttribute('data-tujuan');
            document.getElementById('tambah_tujuan_id').value = tujuanId;

            console.log('Tambah jenis - tujuan ID:', tujuanId);
        });
    }

    /**
     * ===============================
     * MODAL EDIT JENIS PENILAIAN
     * ===============================
     */
   const editModal = document.getElementById('editJenisModal');

    if (editModal) {
    editModal.addEventListener('show.bs.modal', function (event) {

        const button = event.relatedTarget;
        if (!button) return; // ⬅️ WAJIB di atas

        const nama  = button.getAttribute('data-nama');
        const bobot = button.getAttribute('data-bobot');
        const id    = button.getAttribute('data-id');

        document.getElementById('edit_nama').value  = nama;
        document.getElementById('edit_bobot').value = bobot;

        const form = document.getElementById('formEditJenis');
        form.action = `/jenis-penilaian/${id}`;
    });
}


});
</script>
@endpush


