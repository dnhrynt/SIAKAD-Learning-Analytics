@foreach ($jadwal as $hari => $items)
    <div class="card mb-4">
        <div class="card-header fw-bold">{{ $hari }}</div>

        <table class="table table-bordered mb-0">
            <thead>
                <tr class="text-center">
                    <th>Jam</th>
                    <th>Rombongan Belajar</th>
                    <th>Mata Pelajaran</th>
                    <th>KKTP</th>
                    <th>Kelola</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($items as $row)
                    <tr>
                        <td class="text-center">
                            {{ $row->jam->jam_mulai }} - {{ $row->jam->jam_selesai }}
                        </td>
                        <td class="text-center">
                            {{ $row->guruMapel->rombel->nama_rombel }}
                        </td>
                        <td>{{ $row->guruMapel->mapel->nama_mapel }}</td>
                        <td class="text-center">
                            <div class="fw-semibold">
                                {{ $row->guruMapel->kktp }}
                            </div>

                            @if(auth()->user()->hasRole(\App\Enums\UserRole::GURU_PENGAJAR)
                                && auth()->user()->guru_id === $row->guruMapel->guru_id)

                                <button
                                    class="btn btn-sm btn-outline-primary mt-1"
                                    data-bs-toggle="modal"
                                    data-bs-target="#modalKKTP"
                                    data-action="{{ route('guru-mapel.update', $row->guruMapel->id) }}"
                                    data-kktp="{{ $row->guruMapel->kktp }}"
                                    data-mapel="{{ $row->guruMapel->mapel->nama_mapel }}"
                                    data-rombel="{{ $row->guruMapel->rombel->nama_rombel }}"
                                >
                                    <i class="bi bi-pencil"></i>
                                </button>
                            @endif
                        </td>
                        <td class="text-center">
                            <div>
                                <a href="{{ route('nilai.index', $row->guruMapel->id) }}" class="btn gradient-text-primary">
                                    <i class="bi bi-journal-text fs-5"></i>
                                </a>
                                <a href="{{ route('tujuan-pembelajaran.show', $row->guruMapel->id) }}" class="btn gradient-text-primary">
                                    <i class="bi bi-card-list fs-5"></i>
                                </a>
                            </div>
                            
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endforeach