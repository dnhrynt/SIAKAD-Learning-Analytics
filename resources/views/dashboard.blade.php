@extends('layouts.app')

@section('title', 'Dashboard-SIAKAD-sman-1-grabagan')

@section('content')
<section class="hero-grid">

    {{-- A1 --}}
    <div style="grid-row: 1; grid-column: 1;">
        <h2 class="fw-bold gradient-text-primary mb-1">
            {{ $sapaan }},
        </h2>

        <h1 class="fw-bold gradient-text-secondary mb-2">
            {{ $guru->nama_guru }}
        </h1>
    </div>



    {{-- A2 : Mini Highlight --}}
    <div style="grid-row: 2; grid-column: 1;">
        <img 
            src="{{ asset('storage/images/dashboard-elemen.png') }}"
            alt="Dashboard Image"
            class="img-fluid"
            style="max-width: 520px; margin-top: -90px; margin-left: 50px;"
        >
    </div>

    {{-- B2 --}}
    <div style="grid-row: 2; grid-column: 2; justify-self: end; margin-top: -90px; margin-right: 100px;">
        <div class="card shadow-lg border-0" style="max-width: 400px; background: linear-gradient(90deg, #667eeaa3, #764ba294);">
            <div class="card-body text-white">
                <h5 class="fw-bold gradient-text-primary mb-3">
                    ✨ Filosofi Kita
                </h5>
                <p class="fst-italic mb-0">
                    "{{ $quote }}"
                </p>
            </div>
        </div>
    </div>

</section>

@endsection
