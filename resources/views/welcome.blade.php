<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Welcome-SIAKAD-sman-1-grabagan</title>
    <link rel="icon" type="image/png"
      href="{{ asset('storage/images/logo-sman-1-grabagan.png') }}">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .hero-section { 
            min-height: 100vh; 
            display: flex; 
            align-items: center; 
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
            background: linear-gradient(135deg, #667eea, #764ba2);
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

            background: linear-gradient(90deg, #f40f67ff), #3413f0ff;
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

    </style>
</head>
<body>
    <!-- Hero Section -->
    <section class="hero-section"  style="background-image: linear-gradient(rgba(245, 84, 189, 0.5), rgba(100, 105, 251, 0.5)), url('/storage/images/background.jpg'); background-size: cover; background-position: center; color: white;">
        <div class="row w-100 px-5">
            <div class="col-md-6 d-flex">
                <img src="{{ asset('storage/images/dashboard-image.png') }}" class="img-fluid p-5" style="width: 80%; margin-left: 50px;" alt="Dashboard Image">
            </div>
            <div class="col-md-6 d-flex flex-column justify-content-center text-left">
                <h1 class="fw-bold gradient-text-primary gradient-text-primary" style="font-size: 50px;">Sistem Informasi Akademik</h1>
                <h4 class="text-white mb-4">SMA Negeri 1 Grabagan</h4>
                <a href="/login" class="btn-gradient-secondary btn-lg fw-bold align-self-start px-5 rounded-pill">Login</a>
            </div>
        </div>
    </section>

    <!-- Visi Misi -->
    <section class="py-5 mx-5 px-5">
        <h2 class="fw-bold text-center mb-5 gradient-text-info">VISI & MISI SEKOLAH</h2>

        <div class="mb-4 visi-box">
            <h5 class="m-0 text-white fw-bold text-center">VISI: Terciptanya Insan yang Bertakwa, Berkarakter, Berprestasi, dan Berbudaya Lingkungan</h5>
        </div>

        <div class="misi-box">
            <h4 class="fw-bold mb-3" style="color: #3413f0ff">MISI</h4>
            <ol>
                <li>Meningkatkan pembinaan pengamalan nilai-nilai ketakwaan terhadap Tuhan Yang Maha Esa</li>
                <li>Membangun watak dan kepribadian warga sekolah yang jujur, disiplin, bertanggungjawab, serta berwawasan kebangsaan dan lingkungan</li>
                <li>Membangun watak dan kepribadian warga sekolah "belajar sepanjang hayat"</li>
                <li>Membangun watak dan kepribadian warga sekolah bebas NAPZA</li>
                <li>Mengembangkan sumberdaya manusia melalui penguasaan IPTEK dan Seni</li>
                <li>Menumbuhkan budaya kreasi dan bermental juara</li>
                <li>Meningkatkan kualitas dan kuantitas lulusan yang diterima di perguruan tinggi</li>
                <li>Menciptakan Lulusan Yang Mampu Bersaing Di Dalam Dunia Kerja</li>
                <li>Menciptakan Lulusan Yang Mampu Menciptakan Lapangan Kerja (Berwiraswasta)</li>
                <li>Meningkatkan profesionalisme tenaga pendidik dan kependidikan</li>
                <li>Menumbuhkan sikap peduli dan sadar lingkungan</li>
                <li>Menciptakan lingkungan sekolah yang bersih, sehat, asri, nyaman, rapi, dan tertib</li>
            </ol>
        </div>
    </section>

    <!-- Kontak -->
    <footer class="pt-3 mt-5 text-white" style="background: linear-gradient(to right, #667eea, #764ba2);">
        <div class="container">
            <h4 class="fw-bold mb-3">Kontak Kami</h4>
            <div class="row" style="font-size: smaller;">
                <div class="col-md-6 mb-2">
                    <p><img class="footer-icon" src="https://img.icons8.com/ios-filled/50/ffffff/marker.png"> Jl. Raya Pasar Wage No.1, Grabagan, Tuban, Jawa Timur</p>
                    <p><img class="footer-icon" src="https://img.icons8.com/ios-filled/50/ffffff/phone.png"> (0356) 8810240</p>
                    <p><img class="footer-icon" src="https://img.icons8.com/ios-filled/50/ffffff/new-post.png"> info@sman1grabagan.sch.id</p>
                </div>

                <div class="col-md-6">
                    <p><img class="footer-icon" src="https://img.icons8.com/ios-filled/50/ffffff/facebook-new.png"> Sman Grabagan</p>
                    <p><img class="footer-icon" src="https://img.icons8.com/ios-filled/50/ffffff/instagram-new.png"> sman_grabagan</p>
                    <p><img class="footer-icon" src="https://img.icons8.com/ios-filled/50/ffffff/youtube-play.png"> SMAN 1 GRABAGAN</p>
                </div>
            </div>
        </div>
    </footer>

</body>
</html>
