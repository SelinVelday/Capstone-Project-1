<!DOCTYPE html>
<html lang="en">
<head>
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <title>QuickTick - Platform Pemesanan Tiket Event</title>
    <meta content='width=device-width, initial-scale=1.0, shrink-to-fit=no' name='viewport' />
    <link rel="icon" href="{{ asset('assets/img/kaiadmin/favicon.ico') }}" type="image/x-icon"/>

    <script src="{{ asset('assets/js/plugin/webfont/webfont.min.js') }}"></script>
    <script>
        WebFont.load({
            google: {"families":["Public Sans:300,400,500,600,700"]},
            custom: {"families":["Font Awesome 5 Solid", "Font Awesome 5 Regular", "Font Awesome 5 Brands", "simple-line-icons"], urls: ['{{ asset("assets/css/fonts.min.css") }}']},
            active: function() { sessionStorage.fonts = true; }
        });
    </script>

    <link rel="stylesheet" href="{{ asset('assets/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/plugins.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/kaiadmin.min.css') }}">
    
    <style>
        .hero-section {
            background: linear-gradient(135deg, #1572e8 0%, #0d47a1 100%);
            color: white;
            min-height: 100vh;
            display: flex;
            align-items: center;
        }
        .navbar-landing {
            background-color: transparent;
            position: absolute;
            width: 100%;
            z-index: 10;
        }
    </style>
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark navbar-landing p-4">
        <div class="container">
            <a class="navbar-brand fw-bold fs-3" href="#"><i class="fas fa-ticket-alt me-2"></i>QuickTick</a>
            <div class="ms-auto">
                @auth
                    <a href="{{ url('/dashboard') }}" class="btn btn-light btn-round fw-bold text-primary">Ke Dashboard</a>
                @else
                    <a href="{{ route('login') }}" class="btn btn-link text-white text-decoration-none fw-bold me-3">Masuk</a>
                    <a href="{{ route('register') }}" class="btn btn-secondary btn-round fw-bold">Daftar Sekarang</a>
                @endauth
            </div>
        </div>
    </nav>

    <div class="hero-section">
        <div class="container text-center">
            <div class="row justify-content-center">
                <div class="col-md-8">
                    <h1 class="display-4 fw-bold mb-4">Temukan & Pesan Event Favoritmu dengan Mudah</h1>
                    <p class="lead mb-5 opacity-75">QuickTick adalah platform pemesanan tiket event tercepat dan teraman. Jangan sampai kehabisan tiket untuk konser, seminar, dan acara impianmu!</p>
                    
                    @guest
                        <a href="{{ route('register') }}" class="btn btn-secondary btn-lg btn-round px-5 py-3 fw-bold shadow-lg">Mulai Jelajahi Event <i class="fas fa-arrow-right ms-2"></i></a>
                    @else
                        <a href="{{ url('/dashboard') }}" class="btn btn-secondary btn-lg btn-round px-5 py-3 fw-bold shadow-lg">Lihat Katalog Event <i class="fas fa-arrow-right ms-2"></i></a>
                    @endguest
                </div>
            </div>
        </div>
    </div>

    <script src="{{ asset('assets/js/core/jquery-3.7.1.min.js') }}"></script>
    <script src="{{ asset('assets/js/core/bootstrap.min.js') }}"></script>
</body>
</html>