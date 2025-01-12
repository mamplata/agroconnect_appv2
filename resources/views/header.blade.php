<head>
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/css/bootstrap.min.css">
    <link rel="icon" href="{{ asset('images/logo.webp') }}" type="image/webp">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" />
    <link rel="stylesheet" href="{{ asset('css/navigation.css') }}">
</head>
<div class="bg-success">
    <header class="d-flex align-items-center justify-content-between px-4 py-2 bg-success">
        <!-- Logo and Website Title -->
        <div class="d-flex align-items-center">
            <a href="{{ route('home') }}" class="me-3">
                <x-application-logo style="height: 3rem" class="block w-auto fill-current text-light" />
            </a>
            <a style="text-decoration: none" href="{{ route('home') }}" class="text-light fw-bold fs-4">AgroConnect
                Cabuyao</a>
        </div>

        <!-- Navbar -->
        <nav class="d-flex align-items-center">
            <!-- Desktop Navbar Links -->
            <div class="d-none d-md-flex">
                <a href="{{ url('/') }}"
                    class="text-light me-3 btn btn-outline-light {{ request()->is('/') ? 'active' : '' }}">Home</a>
                <a href="{{ url('/trends') }}"
                    class="text-light me-3 btn btn-outline-light {{ request()->is('trends') ? 'active' : '' }}">Trends</a>
                <a href="{{ url('/weather_forecasts') }}"
                    class="text-light me-3 btn btn-outline-light {{ request()->is('weather_forecasts') ? 'active' : '' }}">Weather
                    Forecast</a>
                <a href="{{ url('/damages/pests') }}"
                    class="text-light me-3 btn btn-outline-light {{ request()->is('/damages/pests') ? 'active' : '' }}">Damages</a>
                @auth
                    <a href="{{ url('/dashboard') }}"
                        class="text-light me-3 btn btn-outline-light {{ request()->is('dashboard') ? 'active' : '' }}">Dashboard</a>
                @else
                    <a href="{{ route('login') }}"
                        class="text-light btn btn-outline-light {{ request()->is('login') ? 'active' : '' }}">Log in</a>
                @endauth
            </div>

            <!-- Hamburger Menu for Mobile -->
            <button class="navbar-toggler bg-white d-md-none custom-toggler" type="button" data-bs-toggle="collapse"
                data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false"
                aria-label="Toggle navigation">
                <i class="fas fa-bars custom-icon"></i>
            </button>
        </nav>
    </header>
</div>

<!-- Collapsible Navbar (Mobile) -->
<div class="collapse d-md-none" id="navbarNav">
    <div class="bg-success p-3">
        <a href="{{ url('/') }}"
            class="text-light d-block py-2 link-light {{ request()->is('/') ? 'active' : '' }}">Home</a>
        <a href="{{ url('/trends') }}"
            class="text-light d-block py-2 link-light {{ request()->is('trends') ? 'active' : '' }}">Trends</a>
        <a href="{{ url('/weather_forecasts') }}"
            class="text-light d-block py-2 link-light {{ request()->is('weather_forecasts') ? 'active' : '' }}">Weather
            Forecast</a>
        <a href="{{ url('/damages/pests') }}"
            class="text-light d-block py-2 link-light {{ request()->is('/damages/pests') ? 'active' : '' }}">Damages</a>
        @auth
            <a href="{{ url('/dashboard') }}"
                class="text-light d-block py-2 link-light {{ request()->is('dashboard') ? 'active' : '' }}">Dashboard</a>
        @else
            <a href="{{ route('login') }}"
                class="text-light d-block py-2 link-light {{ request()->is('login') ? 'active' : '' }}">Log in</a>
        @endauth
    </div>
</div>
