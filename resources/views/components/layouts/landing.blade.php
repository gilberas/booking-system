<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'Aurum') }}</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        *, *::before, *::after { margin: 0; padding: 0; box-sizing: border-box; }
        html { scroll-behavior: smooth; }
        body { overflow-x: hidden; }
    </style>
</head>
<body class="lp-lovable">
    <div x-data="landingNav()" x-init="init()">
        {{-- Navbar --}}
        <nav class="lp-nav" :class="scrolled && 'scrolled'">
            <div class="lp-nav-inner">
                <a class="lp-nav-logo" href="/">
                    <div class="lp-nav-logo-icon">A</div>
                    <span class="lp-nav-logo-text">{{ config('app.name') }}</span>
                </a>

                <div class="lp-nav-links">
                    <a href="/">Home</a>
                    <a href="#about">About</a>
                    <a href="#hotels">Hotels</a>
                    <a href="#services">Services</a>
                    <a href="#contact">Contact</a>
                </div>

                <div class="lp-nav-actions">
                    @auth
                        <a href="{{ route('dashboard') }}" class="lp-btn-forest"><i class="bi bi-person-circle me-1"></i> Dashboard</a>
                    @else
                        <a href="{{ route('login') }}" class="lp-nav-signin">Sign In</a>
                        <a href="{{ route('search') }}" class="lp-btn-forest">Book Now</a>
                    @endauth
                </div>

                <button class="lp-nav-mobile-toggle" @click="mobileOpen = !mobileOpen" aria-label="Toggle navigation">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <template x-if="!mobileOpen"><g><line x1="3" y1="6" x2="21" y2="6"/><line x1="3" y1="12" x2="21" y2="12"/><line x1="3" y1="18" x2="21" y2="18"/></g></template>
                        <template x-if="mobileOpen"><g><line x1="6" y1="6" x2="18" y2="18"/><line x1="6" y1="18" x2="18" y2="6"/></g></template>
                    </svg>
                </button>
            </div>
            <div class="lp-nav-mobile-menu" :class="mobileOpen && 'open'" @click.away="mobileOpen = false">
                <a href="/" @click="mobileOpen = false">Home</a>
                <a href="#about" @click="mobileOpen = false">About</a>
                <a href="#hotels" @click="mobileOpen = false">Hotels</a>
                <a href="#services" @click="mobileOpen = false">Services</a>
                <a href="#contact" @click="mobileOpen = false">Contact</a>
                @auth
                    <a href="{{ route('dashboard') }}" @click="mobileOpen = false">Dashboard</a>
                @else
                    <a href="{{ route('login') }}" @click="mobileOpen = false">Sign In</a>
                    <a href="{{ route('search') }}" class="lp-btn-forest" style="text-align:center;" @click="mobileOpen = false">Book Now</a>
                @endauth
            </div>
        </nav>

        <main class="flex-grow-1">
            {{ $slot }}
        </main>

        {{-- Footer --}}
        <footer class="lp-footer">
            <div class="lp-footer-inner">
                <div class="lp-footer-brand">
                    <a class="lp-nav-logo" href="/" style="margin-bottom:.75rem;">
                        <div class="lp-nav-logo-icon">A</div>
                        <span class="lp-nav-logo-text" style="color:#fff;">{{ config('app.name') }}</span>
                    </a>
                    <p>Curated hospitality for the discerning traveler.</p>
                </div>
                <div>
                    <h4 class="lp-footer-col-title">Quick Links</h4>
                    <ul class="lp-footer-links">
                        <li><a href="/">Home</a></li>
                        <li><a href="#about">About</a></li>
                        <li><a href="#hotels">Portfolio</a></li>
                        <li><a href="#services">Services</a></li>
                        <li><a href="#contact">Contact</a></li>
                    </ul>
                </div>
                <div>
                    <h4 class="lp-footer-col-title">Services</h4>
                    <ul class="lp-footer-links">
                        <li><a href="#services">Beach Resorts</a></li>
                        <li><a href="#services">Mountain Lodges</a></li>
                        <li><a href="#services">City Hotels</a></li>
                        <li><a href="#services">Eco Retreats</a></li>
                        <li><a href="#services">Private Islands</a></li>
                    </ul>
                </div>
                <div>
                    <h4 class="lp-footer-col-title">Contact</h4>
                    <ul class="lp-footer-links">
                        <li><a href="tel:+1800000000"><i class="bi bi-telephone me-2"></i>+1 800 000 000</a></li>
                        <li><a href="mailto:hello@aurum.co"><i class="bi bi-envelope me-2"></i>hello@aurum.co</a></li>
                        <li><a href="#"><i class="bi bi-geo-alt me-2"></i>New York, USA</a></li>
                        <li><a href="#"><i class="bi bi-clock me-2"></i>Mon–Fri 9–6pm</a></li>
                    </ul>
                </div>
            </div>
            <div class="lp-footer-bottom">
                <p>&copy; {{ date('Y') }} {{ config('app.name') }}. All rights reserved.</p>
                <p>Designed for beautiful experiences</p>
            </div>
        </footer>
    </div>

    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.14.3/dist/cdn.min.js"></script>
    <script>
        document.addEventListener('alpine:init', () => {
            Alpine.data('landingNav', () => ({
                scrolled: false,
                mobileOpen: false,
                init() {
                    window.addEventListener('scroll', () => {
                        this.scrolled = window.scrollY > 60;
                    }, { passive: true });
                }
            }));
        });
    </script>
    @stack('scripts')
</body>
</html>
