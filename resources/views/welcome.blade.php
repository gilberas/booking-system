<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name', 'Laravel') }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-light d-flex flex-column min-vh-100">
    <header class="py-3">
        <div class="container">
            <div class="d-flex justify-content-end">
                @if (Route::has('login'))
                    @auth
                        <a href="{{ route('dashboard') }}" class="btn btn-outline-secondary btn-sm">Dashboard</a>
                    @else
                        <a href="{{ route('login') }}" class="btn btn-outline-secondary btn-sm me-2">Log in</a>
                        @if (Route::has('register'))
                            <a href="{{ route('register') }}" class="btn btn-dark btn-sm">Register</a>
                        @endif
                    @endauth
                @endif
            </div>
        </div>
    </header>
    <main class="flex-grow-1 d-flex align-items-center">
        <div class="container text-center">
            <h1 class="display-4 fw-bold">{{ config('app.name') }}</h1>
            <p class="lead text-muted">Hotel Booking Management System</p>
        </div>
    </main>
</body>
</html>
