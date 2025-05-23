<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>{{ setting('site_title') }}</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-SgOJa3DmI69IUzQ2PVdRZhwQ+dy64/BUtbMJw1MZ8t5HZApcHrRKUc4W0kG879m7" crossorigin="anonymous" />

    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet" />
    @vite(['resources/css/main.css'])
</head>

<body>
    <header class="navbar navbar-expand-lg navbar-light py-3 w-100 bg-navbar position-fixed top-0 z-3">
        <div class="container">
            <a class="navbar-brand bg-white logo-brand" href="/">
                <img src="{{ asset('images/logo-meca-192x192.png') }}" alt="Logo" />
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse justify-content-between" id="navbarNav">
                <ul class="navbar-nav mx-auto">
                    @php
                        $links = setting('nav_links');
                    @endphp
                    @if (!empty($links))
                        @foreach (explode(',', $links) as $item)
                            @php
                                [$text, $url] = array_pad(explode('|', $item), 2, null);
                            @endphp

                            @if ($text && $url)
                                <li class="nav-item nav-item-spacing">
                                    <a class="nav-link" href="{{ route($url) }}">{{ trim($text) }}</a>
                                </li>
                            @endif
                        @endforeach
                    @endif
                </ul>
                <div class="d-flex align-items-center gap-4 text-white social-icons">
                    <a href="{{ setting('instagram_url') }}" target="_blank"><i
                            class="fab fa-instagram fa-lg text-white"></i></a>
                    <a href="{{ setting('facebook_url') }}" target="_blank"><i
                            class="fab fa-facebook-f fa-lg text-white"></i></a>
                    <a href="{{ setting('web_url') }}" target="_blank"><i
                            class="fa-solid fa-globe fa-lg text-white"></i></a>

                    {{-- @if (Route::has('login'))
                    @auth
                    <a href="{{ url('/dashboard') }}"><i class="fa-solid fa-gauge fa-lg text-white"></i></a>
                    @else
                    <a href="{{ route('login') }}"><i class="fa-solid fa-right-to-bracket fa-lg text-white"></i></a>
                    @endauth
                    @endif --}}
                </div>
            </div>
        </div>
    </header>

    <main>
        {{ $slot }}
    </main>

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
                <livewire:blog.category-index />
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
                        <a href="#" class="text-white text-decoration-none">Términos y condiciones</a>
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
