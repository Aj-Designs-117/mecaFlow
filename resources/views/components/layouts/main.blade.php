<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- SEO Básico -->
    <meta charset="UTF-8">
    <meta name="description"
        content="MecaLink: Blog de ingeniería donde encontrarás artículos, análisis y recursos sobre mecánica, robótica, diseño CAD, automatización y más.">
    <meta name="keywords"
        content="ingeniería mecánica, MecaLink, blog de ingeniería, CAD, robótica, automatización, diseño mecánico, análisis estructural, mecatrónica, control, simulaciones">
    <meta name="author" content="Alan Jafet">
    <meta name="robots" content="index, follow">
    <link rel="canonical" href="https://mecaflow-main-wxovkm.laravel.cloud/">

    <!-- Open Graph para redes sociales (Facebook, LinkedIn, etc.) -->
    <meta property="og:type" content="website">
    <meta property="og:url" content="https://mecaflow-main-wxovkm.laravel.cloud/">
    <meta property="og:title" content="MecaLink | Blog de Ingeniería Mecánica y Robótica">
    <meta property="og:description"
        content="Explora MecaLink, el blog donde la ingeniería cobra vida: contenidos sobre mecánica, automatización, CAD, robótica y más.">
    <meta property="og:image" content="{{ asset('images/logo-meca-192x192.png') }}">

    <!-- Twitter Card -->
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:url" content="https://mecaflow-main-wxovkm.laravel.cloud/">
    <meta name="twitter:title" content="MecaLink | Blog de Ingeniería Mecánica y Robótica">
    <meta name="twitter:description"
        content="Explora MecaLink, el blog donde la ingeniería cobra vida: contenidos sobre mecánica, automatización, CAD, robótica y más.">
    <meta name="twitter:image" content="{{ asset('images/logo-meca-192x192.png') }}">

    <link rel="icon" href="{{ asset('favicon.ico') }}" type="image/x-icon">

    <title>{{ setting('site_title') }}</title>

    <!-- Google tag (gtag.js) -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=G-4M3E22QC4W"></script>
    <script>
        window.dataLayer = window.dataLayer || [];

        function gtag() {
            dataLayer.push(arguments);
        }
        gtag('js', new Date());

        gtag('config', 'G-4M3E22QC4W');
    </script>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-SgOJa3DmI69IUzQ2PVdRZhwQ+dy64/BUtbMJw1MZ8t5HZApcHrRKUc4W0kG879m7" crossorigin="anonymous" />

    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet" />

    <link href="https://cdn.jsdelivr.net/npm/quill@2.0.3/dist/quill.snow.css" rel="stylesheet" />

    @vite(['resources/css/main.css'])
</head>

<body>
    <!-- Top Navbar -->
    <header class="navbar navbar-dark bg-dark py-4 fixed-top">
        <div class="container d-flex align-items-center">
            <a href="{{ route('home') }}" class="d-flex align-items-center text-white text-decoration-none">
                <img src="{{ asset('images/logo-meca-192x192.png') }}" alt="logo" class="me-2 logo-brand">
                <div class="d-flex flex-column lh-sm">
                    <span class="fs-4 fw-bold">{{ trim(setting('site_title')) ?: 'Blog' }}</span>
                    <small class="text-white-50">Donde las ideas se convierten en máquinas</small>
                </div>
            </a>
        </div>
    </header>

    <!-- Bottom Navbar -->
    <nav class="navbar navbar-expand-lg bg-navbar py-3 nav-spacing shadow-sm p-3">
        <div class="container">
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#mainNavbar">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse justify-content-between" id="mainNavbar">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <a class="nav-link text-white" href="{{ route('home') }}">INICIO</a>
                    </li>
                    {{-- <li class="nav-item">
                        <a class="nav-link text-white" href="#">SOBRE NOSOTROS</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-white" href="#">CONTACTO</a>
                    </li> --}}
                </ul>

                <div class="d-flex align-items-center gap-2">
                    <a href="{{ setting('instagram_url') }}" target="_blank" class="social-circle">
                        <i class="fab fa-instagram"></i>
                    </a>
                    <a href="{{ setting('facebook_url') }}" target="_blank" class="social-circle">
                        <i class="fab fa-facebook-f"></i>
                    </a>
                    <a href="{{ setting('web_url') }}" target="_blank" class="social-circle">
                        <i class="fa-solid fa-globe"></i>
                    </a>
                </div>
            </div>
        </div>
    </nav>

    <section>
        {{ $slot }}
    </section>

    <footer class="bg-footer p-5 position-relative text-light">
        <div class="container">
            <div class="row">
                <!-- Newsletter -->
                <div class="col-md-4 mb-4">
                    <h2 class="fw-bold">{{ setting('site_title') }}</h2>
                    <p>
                        {{ setting('site_description') }}
                    </p>
                </div>

                <!-- Logo y contacto -->
                <div class="col-md-4 text-center">
                    <div class="d-flex justify-content-center">
                        <div class="d-flex align-items-center justify-content-center rounded-circle bg-white shadow">
                            <img src="{{ asset('images/logo-meca-192x192.png') }}" alt="Logo"
                                style="width: 80px; height: 80px" />
                        </div>
                    </div>

                    <p class="fw-bold mb-0 mt-2">Mecatrónica</p>
                    <p class="mb-0">{{ setting('site_number') }}</p>
                    <a href="mailto:231244@im.upchiapas.edu.mx" class="text-white">{{ setting('site_email') }}</a>

                    <!-- Redes sociales -->
                    <div class="mt-3 d-flex justify-content-center gap-5 mt-5">
                        <a href="{{ setting('facebook_url') }}" target="_blank"><i
                                class="fab fa-instagram fs-4 text-white"></i></a>
                        <a href="{{ setting('instagram_url') }}" target="_blank"><i
                                class="fab fa-facebook-f fs-4 text-white"></i></a>
                        <a href="{{ setting('web_url') }}" target="_blank"><i
                                class="fa-solid fa-globe fs-4 text-white"></i></a>

                    </div>
                </div>

                <!-- Enlaces -->
                <div class="col-md-4 mb-4 text-center">
                    <ul class="list-unstyled">
                        <li class="mb-2">
                            <a href="{{ route('home') }}" class="text-decoration-none text-light">Inicio</a>
                        </li>
                        {{-- <li class="mb-2">
                            <a href="#" class="text-white text-decoration-none">Sobre Nosotros</a>
                        </li>
                        <li class="mb-2">
                            <a href="#" class="text-white text-decoration-none">Contacto</a>
                        </li> --}}
                        </li>
                    </ul>
                </div>

            </div>

            <!-- Línea inferior -->
            <div class="container pt-4 border-top mt-4">
                <div class="row justify-content-center text-center text-md-center align-items-center">
                    <div class="col-12 col-md-4 mb-2 mb-md-0">
                        <p class="mb-0">&copy; {{ setting('site_title') }} 2025</p>
                    </div>
                    <div class="col-12 col-md-4 mb-2 mb-md-0">
                        <p class="mb-0">Creado por <strong>{{ setting('site_author') }}</strong></p>
                    </div>
                    <div class="col-12 col-md-4">
                        <a href="{{ route('terms') }}" class="text-white text-decoration-none">Términos y
                            condiciones</a>
                    </div>
                </div>
            </div>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-k6d4wzSIapyDyv1kpU366/PK5hCdSbCRGRCMv+eplOQJWyd1fbcAu9OCUj5zNLiq" crossorigin="anonymous">
    </script>
</body>

</html>
