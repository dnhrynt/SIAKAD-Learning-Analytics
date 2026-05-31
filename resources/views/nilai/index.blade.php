@extends('layouts.app')

@section('content')
<div class="container-fluid">

    {{-- Header --}}
    <div class="mb-4">
        <h4 class="fw-bold gradient-text-info">
            <i class="bi bi-journal-text me-1"></i>
            Nilai {{ $mapel->nama_mapel }} ( {{ $rombel->nama_rombel }} )
        </h4>
        <small class="text-muted">
            KKTP : {{ $guruMapel->kktp }}
        </small>
    </div>

    <div>
        <div class="card-body table-responsive">

            <table class="table table-bordered align-middle text-center">
                <thead class="table-light">
                    <tr>
                        <th rowspan="2">NIS</th>
                        <th rowspan="2">Nama Siswa</th>

                        @foreach($tujuanPembelajaran as $tp)
                            <th colspan="{{ $tp->jenisPenilaian->count() }}">
                                {{ $tp->nama_tujuan }}
                            </th>
                        @endforeach
                    </tr>
                    <tr>
                        @foreach($tujuanPembelajaran as $tp)
                            @foreach($tp->jenisPenilaian as $jp)
                                <th>
                                    {{ $jp->nama_jenis }}
                                </th>
                            @endforeach
                        @endforeach
                    </tr>
                </thead>

                <tbody>
                    @foreach($siswaList as $rs)
                        <tr>
                            <td>{{ $rs->siswa->nis }}</td>
                            <td class="text-start">
                                {{ $rs->siswa->nama_siswa }}
                            </td>

                            @foreach($tujuanPembelajaran as $tp)
                                @foreach($tp->jenisPenilaian as $jp)

                                    @php
                                        $key = $rs->id.'-'.$jp->id;
                                        $dataNilai = $nilai[$key] ?? null;
                                    @endphp

                                    <td>
                                        <div class="fw-semibold">
                                            {{ $dataNilai->nilai ?? 0 }}
                                        </div>

                                        <button
                                            class="btn btn-sm btn-outline-primary mt-1"
                                            data-bs-toggle="modal"
                                            data-bs-target="#modalNilai"
                                            data-action="{{ route('nilai.store', [$rs->id, $jp->id]) }}"
                                            data-nilai="{{ $dataNilai->nilai ?? 0 }}"
                                            data-siswa="{{ $rs->siswa->nama_siswa }}"
                                            data-penilaian="{{ $jp->nama_jenis }}"
                                        >
                                            <i class="bi bi-pencil"></i>
                                        </button>


                                    </td>


                                @endforeach
                            @endforeach
                        </tr>
                    @endforeach
                </tbody>
            </table>

        </div>
    </div>

</div>

<!-- Modal Tambah -->

<div class="modal fade" id="modalNilai" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">

            <form method="POST" id="formNilai">
                @csrf
                @method('PUT')

                <div class="modal-header">
                    <h5 class="modal-title gradient-text-primary">
                        Input Nilai <span id="infoPenilaian"></span>
                    </h5>

                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>

                <div class="modal-body">
                    <p class="mb-1 fw-semibold text-secondary" id="infoSiswa"></p>
                    <br>

                    <div class="mb-3">
                        <label class="form-label fw-semibold">Nilai</label>
                        <input type="number"
                               name="nilai"
                               id="inputNilai"
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
    .getElementById('modalNilai')
    .addEventListener('show.bs.modal', function (event) {

    const button = event.relatedTarget;

    const action     = button.getAttribute('data-action');
    const nilai      = button.getAttribute('data-nilai');
    const siswa      = button.getAttribute('data-siswa');
    const penilaian  = button.getAttribute('data-penilaian');

    const form = document.getElementById('formNilai');

    form.action = action;

    document.getElementById('inputNilai').value = nilai;
    document.getElementById('infoSiswa').innerText = siswa;
    document.getElementById('infoPenilaian').innerText = penilaian;
});
</script>
@endpush

