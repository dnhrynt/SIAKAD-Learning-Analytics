<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Login-SIAKAD-sman-1-grabagan</title>
    <link rel="icon" type="image/png"
      href="{{ asset('storage/images/logo-sman-1-grabagan.png') }}">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        body {
            min-height: 100vh;
            background: linear-gradient(
                rgba(245, 84, 189, 0.6),
                rgba(100, 105, 251, 0.6)
            ), url('/storage/images/background.jpg');
            background-size: cover;
            background-position: center;
        }

        .auth-card {
            background: rgba(255,255,255,0.95);
            border-radius: 20px;
            box-shadow: 0 20px 40px rgba(0,0,0,.2);
            padding: 40px;
        }

        .gradient-text-primary {
            background: linear-gradient(135deg, #f40f67ff, #3413f0ff);
            background-clip: text;
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        .btn-gradient-primary {
            background: linear-gradient(90deg, #f40f67ff, #3413f0ff);
            border: none;
            color: white;
            font-weight: 600;
            border-radius: 50px;
            padding: 12px;
            transition: .2s ease;
        }

        .btn-gradient-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 20px rgba(0,0,0,.2);
        }

        .form-control {
            border-radius: 10px;
            padding: 12px;
        }

        .link-gradient {
            text-decoration: none;
            font-weight: 600;
            background: linear-gradient(135deg, #667eea, #764ba2);
            background-clip: text;
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }
    </style>
</head>
<body>

<div class="container d-flex align-items-center justify-content-center min-vh-100">
    <div class="col-md-5">

        <div class="auth-card">
            <div class="text-center mb-4">
                <h3 class="fw-bold gradient-text-primary">Login Sistem Akademik</h3>
                <p class="text-muted mb-0">SMA Negeri 1 Grabagan</p>
            </div>

            <form method="POST" action="/login">
                @csrf

                <div class="mb-3">
                    <label class="fw-semibold">Username</label>
                    <input type="text" name="username" class="form-control" placeholder="Masukkan username">
                </div>

                <div class="mb-3">
                    <label class="fw-semibold">Password</label>
                    <input type="password" name="password" class="form-control" placeholder="Masukkan password">
                </div>

                <div class="d-flex justify-content-between align-items-center mb-3">
                    <a href="/forgot-password" class="link-gradient">Lupa Password?</a>
                </div>

                <button type="submit" class="btn btn-gradient-primary w-100">
                    Login
                </button>
            </form>
            @if(session('error'))
                <div class="text-danger fw-semibold text-center mt-3">
                    <i class="bi bi-exclamation-circle"></i>
                    {{ session('error') }}
                </div>
            @endif


        </div>

        <p class="text-center text-white mt-4 small">
            © {{ date('Y') }} SMAN 1 Grabagan
        </p>

    </div>
</div>

</body>
</html>
