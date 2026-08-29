<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Aurum</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="page-bg">
    <div class="min-vh-100 d-flex flex-column">
        @include('layouts.navigation')

        @if (isset($header))
            <div class="dashboard-header" style="background: linear-gradient(135deg, var(--lp-primary) 0%, #1e293b 100%);">
                <div class="container py-3">
                    <div class="text-white">{{ $header }}</div>
                </div>
            </div>
        @endif

        <main class="flex-grow-1 py-4">
            <div class="container">
                {{ $slot }}
            </div>
        </main>
    </div>

    @stack('scripts')
</body>
</html>
