<header class="app-header bg-white border-bottom shadow-sm">
    <div class="container-fluid px-4 py-3">
        <div class="d-flex justify-content-between align-items-center">

            {{-- KIRI: Logo & Text --}}
            <div class="d-flex align-items-center gap-3">
                <img 
                    src="{{ asset('storage/images/logo-sman-1-grabagan.png') }}" 
                    alt="Logo SMA Negeri 1 Grabagan"
                    style="height: 55px;"
                >

                <div class="lh-sm">
                    <h5 class="mb-1 gradient-text-secondary">
                        SMA Negeri 1 Grabagan
                    </h5>
                    <p class="mb-0 text-secondary small">
                        Sistem Informasi Akademik
                    </p>
                </div>
            </div>

            {{-- KANAN: Dropdown Logout --}}
            <div class="dropdown">
                <button
                    class="btn btn-link text-danger fs-4"
                    type="button"
                    id="dropdownLogout"
                    data-bs-toggle="dropdown"
                    aria-expanded="false"
                    title="Menu Akun"
                >
                    <i class="bi bi-box-arrow-right"></i>
                </button>

                <ul class="dropdown-menu shadow" aria-labelledby="dropdownLogout">
                    <li>
                        <a class="dropdown-item d-flex align-items-center gap-2 gradient-text-secondary" href="{{ route('guru.show') }}">
                            <i class="bi bi-person-circle fs-4"></i>
                            Profil Saya
                        </a>
                    </li>

                    <li><hr class="dropdown-divider"></li>

                    <li>
                        <form action="{{ route('logout') }}" method="POST">
                            @csrf
                            <button type="submit" class="dropdown-item d-flex align-items-center gap-2 text-danger">
                                <i class="bi bi-power fs-4"></i>
                                Logout
                            </button>
                        </form>
                    </li>
                </ul>
            </div>




        </div>
    </div>
</header>
