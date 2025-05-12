<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Enrollment System</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
    @vite(['resources/css/app.css'])
    <link rel="stylesheet" href="{{ asset('css/layout.css') }}">
    <link rel="stylesheet" href="{{ asset('statics/css/bootstrap.min.css') }}">

    @yield('styles')
    <script src="{{ asset('statics/js/bootstrap.bundle.min.js') }}"></script>
    <style>
        body {
            background: whitesmoke;
        }
    </style>
</head>

<body>
    <header id="navbar" class="shadow-sm">
        <div class="logo-container">
            <img src="{{ asset('img/logo.png') }}" alt="logo" class="logo" />
        </div>
        <div class="vl"></div>
        <h2>Enrollment System</h2>
        <div class="profile-container">
            <div class="dropdown">
                <a href="#" class="user-icon" id="userDropdown" data-bs-toggle="dropdown" aria-expanded="false"
                    title="User Menu">
                    <i class="fa-solid fa-circle-user"></i>
                </a>
                <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="userDropdown">
                    <li><a class="dropdown-item" href="#">Profile</a></li>
                    <li><a class="dropdown-item" href="{{ route('enrollment.show', 'accounts') }}">Accounts</a></li>
                    <li>
                        <hr class="dropdown-divider">
                    </li>
                    <li>
                        <a class="dropdown-item text-danger" href="{{ route('logout') }}"
                            onclick="event.preventDefault(); document.getElementById('logout-form-header').submit();">
                            Logout
                        </a>
                        <form id="logout-form-header" action="{{ route('logout') }}" method="POST"
                            style="display: none;">
                            @csrf
                        </form>
                    </li>
                </ul>
            </div>
            <p>{{ ucfirst(auth()->user()->username) }}</p>
        </div>
    </header>

    @include('layouts.sidebar', ['page' => $page ?? request()->route('page') ?? 'dashboard'])

    <main id="main-content">
        @yield('content')
    </main>

    @vite(['resources/js/app.js'])
    <script src="{{ asset('js/app.js') }}"></script>
    @yield('scripts')
</body>

</html>