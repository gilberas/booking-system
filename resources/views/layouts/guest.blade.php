<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Aurum</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;600;700&family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="guest-body">
    <div class="container">
        <div class="row justify-content-center py-5">
            <div class="col-md-6 col-lg-5 col-xl-4">
                <a href="/" class="auth-logo">
                    <span>✦ Aurum</span>
                    <small>Luxury Hotel &amp; Residences</small>
                </a>
                <div class="auth-card">
                    {{ $slot }}
                </div>
            </div>
        </div>
    </div>
    <script>
    function togglePassword(inputId, el) {
        const input = document.getElementById(inputId);
        if (!input) return;
        const icon = el.querySelector('i');
        if (input.type === 'password') {
            input.type = 'text';
            icon.className = 'bi bi-eye-slash';
        } else {
            input.type = 'password';
            icon.className = 'bi bi-eye';
        }
    }
    </script>
    @stack('scripts')
</body>
</html>
