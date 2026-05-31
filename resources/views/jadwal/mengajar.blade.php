@extends('layouts.app')

@section('content')
<div class="container">

    {{-- Header --}}
    <h3 class="gradient-text-info mb-5">
        <i class="bi bi-person-workspace me-1"></i>
        Jadwal Mengajar Saya
        <small class="text-muted">
            ({{ $tahunAktif->nama_tahun_ajaran }} {{ $tahunAktif->semester }})
        </small>
    </h3>

    {{-- Tabel Jadwal --}}
    @include('jadwal.partials.tabel-per-hari')

</div>

{{-- MODAL EDIT KKTP --}}
<div class="modal fade" id="modalKKTP" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">

            <form method="POST" id="formKKTP">
                @csrf
                @method('PUT')

                <div class="modal-header">
                    <h5 class="modal-title gradient-text-primary">Masukkan KKTP</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>

                <div class="modal-body">
                    <p class="fw-semibold mb-1" id="infoMapel"></p>
                    <p class="text-muted" id="infoRombel"></p>

                    <div class="mb-3">
                        <label class="form-label fw-semibold">KKTP</label>
                        <input type="number"
                               name="kktp"
                               id="inputKKTP"
                               class="form-control"
                               min="0"
                               max="100"
                               required>
                    </div>
                </div>

                <div class="modal-footer">
                    <button class="btn btn-gradient-secondary" data-bs-dismiss="modal">
                        Batal
                    </button>
                    <button class="btn btn-gradient-primary">
                        <i class="bi bi-save"></i>
                        Simpan
                    </button>
                </div>

            </form>

        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
document
    .getElementById('modalKKTP')
    .addEventListener('show.bs.modal', function (event) {

        const button = event.relatedTarget;

        const action = button.getAttribute('data-action');
        const kktp   = button.getAttribute('data-kktp');
        const mapel  = button.getAttribute('data-mapel');
        const rombel = button.getAttribute('data-rombel');

        const form = document.getElementById('formKKTP');

        form.action = action;
        document.getElementById('inputKKTP').value = kktp;
        document.getElementById('infoMapel').innerText = mapel;
        document.getElementById('infoRombel').innerText = rombel;
});
</script>
@endpush
