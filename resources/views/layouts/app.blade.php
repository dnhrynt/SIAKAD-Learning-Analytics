<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield ('title','SIAKAD-sman-1-grabagan')</title>
    <link rel="icon" type="image/png"
      href="{{ asset('storage/images/logo-sman-1-grabagan.png') }}">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <style>
        @media (max-width: 768px) {
            .hero-section > div {
                position: static;
            }
            .hero-grid {
                grid-template-columns: 1fr;
                grid-template-rows: auto auto;
            }

            .hero-grid > div {
                grid-column: 1 !important;
                grid-row: auto !important;
                justify-self: start !important;
            }
        }


        html, body {
            height: 100%;
            margin: 0;
        }

        body {
            overflow: hidden;
        }

        /* HEADER */
        .app-header {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            height: 80px; /* sesuaikan header */
            z-index: 1000;
            background: #fff;
        }

        /* WRAPPER */
        .app-container {
            display: flex;
            height: calc(100vh - 80px);
            margin-top: 80px;
        }

        /* SIDEBAR */
        .app-sidebar {
            width: 260px;
            position: fixed;
            top: 80px;
            left: 0;
            bottom: 0;
            overflow-y: auto;
            background: linear-gradient(to bottom, #667eea, #764ba2);
            color: #fff;
        }
        .app-sidebar .nav-link {
            color: #fff;
        }
        /* CONTENT */
        .app-content {
            margin-left: 260px;
            flex-grow: 1;
            padding: 24px;
            overflow-y: auto;
        }

        .hero-section { 
            min-height: 100vh; 
            display: flex; 
            align-items: center;
            position: relative;
        }
        .hero-grid {
            display: grid;
            grid-template-columns: 1fr 1fr; /* 2 kolom */
            grid-template-rows: 1fr 1fr 1fr; /* 3 baris */
            min-height: 100vh;
            padding: 1rem;
        }
        .hero-grid img {
            transition: transform .4s ease;
        }

        .hero-grid img:hover {
            transform: translateY(-4px);
        }


        .visi-box { background: linear-gradient(to right, #667eea, #764ba2); padding: 20px; border-radius: 4px; }
        .misi-box { background-color: #d9def0ff; border-left: 5px solid #3413f0ff; padding: 20px; border-radius: 4px; }
        .footer-icon { width: 20px; height: 20px; margin-right: 8px; }
        .gradient-text-primary {
            background: linear-gradient(135deg, #f40f67ff, #3413f0ff);
            background-clip: text;
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }
        .gradient-text-secondary {
            background: linear-gradient(90deg, #667eea, #764ba2);
            background-clip: text;
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }
        .gradient-text-info {
            background: linear-gradient(135deg, #f013aaff, #3dd8f3ff);
            background-clip: text;
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }
        .btn-gradient-primary {
            padding: 12px 24px;
            border: none;
            border-radius: 8px;
            font-weight: 600;
            color: #fff;
            cursor: pointer;

            background: linear-gradient(90deg, #f40f67ff, #3413f0ff);
            transition: transform .2s ease, box-shadow .2s ease;
        }
        .btn-gradient-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 20px rgba(0,0,0,.2);
        }
        .btn-gradient-secondary {
            padding: 12px 24px;
            border: none;
            border-radius: 8px;
            font-weight: 600;
            color: #fff;
            cursor: pointer;

            background: linear-gradient(90deg, #667eea, #764ba2);
            transition: transform .2s ease, box-shadow .2s ease;
        }
        .btn-gradient-secondary:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 20px rgba(0,0,0,.2);
        }
        .btn-gradient-info {
            padding: 12px 24px;
            border: none;
            border-radius: 8px;
            font-weight: 600;
            color: #fff;
            cursor: pointer;

            background: linear-gradient(90deg, #f013aaff, #3dd8f3ff);
            transition: transform .2s ease, box-shadow .2s ease;
        }
        .btn-gradient-info:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 20px rgba(0,0,0,.2);
        }
        .table thead th {
            background: linear-gradient(135deg, #667aaecb, #764ba2c7) !important;
            color: #fff;
            padding: 10px;
        }
        .rombel-card {
        transition: transform .2s ease, box-shadow .2s ease;
        }

        .rombel-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 25px rgba(0,0,0,.1);
        }

        .bg-excellent {
            background-color: #3413f0ff !important;
            color: #fff;
        }

        .bg-good {
            background-color: #6677ea !important;
            color: #fff;
        }

        .bg-warning-custom {
            background-color: #764ba2 !important;
            color: #fff;
        }

        .bg-risk {
            background-color: #f40f67ff !important;
            color: #fff;
        }

        .text-excellent { color: #3413f0ff; }
        .text-good      { color: #6677ea; }
        .text-warning   { color: #764ba2; }
        .text-risk      { color: #f40f67ff; }

        .form-check-input {
            border: 2px solid #495057; /* lebih gelap dari default */
            width: 1.2em;
            height: 1.2em;
            cursor: pointer;
        }
        
        .form-check-input:hover {
            border-color: #0d6efd;
        }
        
        .form-check-input:checked {
            background-color: #0d6efd;
            border-color: #0d6efd;
        }
        
        .form-check-input:focus {
            box-shadow: 0 0 0 .2rem rgba(13,110,253,.25);
        }


    </style>
</head>
<body>
    @include('layouts.header')

    <div class="app-container">
        @include('layouts.sidebar')

        <main class="app-content p-5">
            @yield('content')
        </main>
    </div>

    @stack('scripts')
</body>


</html>