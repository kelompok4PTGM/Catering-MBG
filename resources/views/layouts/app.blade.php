<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Catering MBG</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        primary: '#F97316',
                        secondary: '#FFF7ED',
                        accent: '#6B8E23',
                        textcolor: '#374151'
                    },
                    fontFamily: {
                        sans: ['Inter', 'sans-serif'],
                    }
                }
            }
        }
    </script>
    <style>
        /* Smooth Scrolling */
        html {
            scroll-behavior: smooth;
            scroll-padding-top: 5rem;
        }

        body {
            color: #374151;
            background-color: #ffffff;
            overflow-x: hidden;
        }

        /* Modern Slim Scrollbar */
        ::-webkit-scrollbar {
            width: 8px;
            height: 8px;
        }
        ::-webkit-scrollbar-track {
            background: #f8fafc;
        }
        ::-webkit-scrollbar-thumb {
            background: #cbd5e1;
            border-radius: 9999px;
            border: 2px solid #f8fafc;
        }
        ::-webkit-scrollbar-thumb:hover {
            background: #f97316;
        }

        /* Reading Scroll Progress Bar */
        #scroll-progress-bar {
            position: fixed;
            top: 0;
            left: 0;
            height: 3px;
            width: 0%;
            background: linear-gradient(90deg, #ea580c, #f97316, #fb923c);
            z-index: 100;
            pointer-events: none;
            transition: width 0.08s ease-out;
        }

        /* GPU-accelerated Scroll Reveal Animations (Super Light) */
        .reveal-on-scroll {
            opacity: 0;
            transform: translateY(24px);
            transition: opacity 0.65s cubic-bezier(0.16, 1, 0.3, 1), transform 0.65s cubic-bezier(0.16, 1, 0.3, 1);
            will-change: opacity, transform;
        }
        .reveal-on-scroll.is-revealed {
            opacity: 1;
            transform: translateY(0);
        }

        /* Staggered Delays */
        .delay-100 { transition-delay: 80ms; }
        .delay-200 { transition-delay: 160ms; }
        .delay-300 { transition-delay: 240ms; }
        .delay-400 { transition-delay: 320ms; }

        /* Interactive Movement & Cards */
        .card-interactive {
            transition: transform 0.35s cubic-bezier(0.16, 1, 0.3, 1), box-shadow 0.35s ease, border-color 0.3s ease;
            will-change: transform, box-shadow;
        }
        .card-interactive:hover {
            transform: translateY(-6px);
            box-shadow: 0 16px 32px -8px rgba(249, 115, 22, 0.12), 0 4px 12px -2px rgba(0, 0, 0, 0.05);
            border-color: rgba(249, 115, 22, 0.35);
        }

        .img-zoom {
            transition: transform 0.5s cubic-bezier(0.16, 1, 0.3, 1);
            will-change: transform;
        }
        .card-interactive:hover .img-zoom {
            transform: scale(1.06);
        }

        /* Button Micro-interactions */
        .btn-primary {
            background-color: #f97316;
            color: white;
            transition: all 0.25s cubic-bezier(0.16, 1, 0.3, 1);
        }
        .btn-primary:hover {
            background-color: #ea580c;
            transform: translateY(-1px);
            box-shadow: 0 4px 12px rgba(249, 115, 22, 0.3);
        }
        .btn-primary:active, .btn-press:active {
            transform: scale(0.97);
        }

        /* Glassmorphism Navbar on Scroll */
        nav.nav-scrolled {
            background-color: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(12px);
            -webkit-backdrop-filter: blur(12px);
            box-shadow: 0 4px 20px -2px rgba(0, 0, 0, 0.06);
        }

        @media (prefers-reduced-motion: reduce) {
            html { scroll-behavior: auto; }
            .reveal-on-scroll { opacity: 1; transform: none; transition: none; }
            .card-interactive:hover { transform: none; }
        }
    </style>
</head>
<body class="flex flex-col min-h-screen">
    <!-- Hairline Scroll Progress Bar -->
    <div id="scroll-progress-bar"></div>

    <!-- Navbar -->
    <nav id="main-nav" class="bg-white border-b border-gray-100 shadow-xs sticky top-0 z-50 transition-all duration-300">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16 items-center">

                <!-- Logo -->
                <a href="{{ route('home') }}" class="flex items-center gap-2">
                    <span class="text-2xl">🍽️</span>
                    <span class="text-xl font-bold text-orange-500">Catering MBG</span>
                </a>

                <!-- Menu Tengah -->
                <div class="hidden md:flex items-center gap-8" id="nav-links">
                    <a href="{{ route('home') }}" id="nav-home" class="nav-item text-sm font-medium text-orange-500 border-b-2 border-orange-500 pb-1 transition-all">Beranda</a>
                    <a href="{{ route('home') }}#caterings" id="nav-caterings" class="nav-item text-sm font-medium text-gray-600 hover:text-orange-500 pb-1 transition-all">Cari Catering</a>
                    <a href="{{ route('home') }}#testimoni" id="nav-testimoni" class="nav-item text-sm font-medium text-gray-600 hover:text-orange-500 pb-1 transition-all">Testimoni Kami</a>
                </div>

                <!-- Kanan -->
                <div class="flex items-center gap-3">
                    <!-- Icon Search -->
                    <button class="text-gray-500 hover:text-orange-500 transition">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                        </svg>
                    </button>

                    <!-- Icon Cart / Keranjang -->
                    <a href="{{ route('cart.index') }}" class="relative text-gray-500 hover:text-orange-500 transition">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 100 4 2 2 0 000-4z" />
                        </svg>
                        @if(session()->has('cart') && count(session()->get('cart')) > 0)
                            <span class="absolute -top-2 -right-2 bg-orange-500 text-white text-xs font-bold rounded-full h-5 w-5 flex items-center justify-center">
                                {{ count(session()->get('cart')) }}
                            </span>
                        @endif
                    </a>

                    @auth
                        @if(Auth::user()->role === 'User')
                            <a href="{{ route('user.orders') }}" class="text-sm font-medium text-gray-600 hover:text-orange-500 transition">Pesanan Saya</a>
                        @endif
                        <a href="{{ route('dashboard') }}" class="text-sm font-medium text-gray-600 hover:text-orange-500 transition">Dashboard</a>
                        <span class="text-sm font-semibold text-gray-700">Halo, {{ Auth::user()->username }}</span>
                        <form method="POST" action="{{ route('logout') }}" class="inline">
                            @csrf
                            <button type="submit" class="text-sm font-medium text-gray-600 hover:text-orange-500 transition">Logout</button>
                        </form>
                    @else
                        <a href="{{ route('login') }}" class="text-sm font-medium text-gray-600 hover:text-orange-500 transition">Login</a>
                        <a href="{{ route('register') }}" class="btn-primary text-sm font-semibold px-5 py-2 rounded-full">Daftar</a>
                    @endauth
                </div>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <main class="flex-grow">
        @yield('content')
    </main>

    <!-- Footer -->
    <footer class="bg-white border-t border-gray-100 mt-10">
        <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8 flex justify-between items-center">
            <p class="text-sm text-gray-500">&copy; {{ date('Y') }} Kelompok 4 PTGM. All rights reserved.</p>
            <p class="text-sm text-gray-500">Makan Bergizi Gratis (MBG)</p>
        </div>
    </footer>

    <!-- Floating Back to Top Button -->
    <button id="back-to-top" 
        class="fixed bottom-6 right-6 z-40 bg-white/90 backdrop-blur-md text-orange-500 hover:bg-orange-500 hover:text-white p-3 rounded-full shadow-lg border border-orange-100 opacity-0 translate-y-4 pointer-events-none transition-all duration-300 focus:outline-none cursor-pointer group" 
        title="Kembali ke atas">
        <svg class="w-5 h-5 transform group-hover:-translate-y-0.5 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 10l7-7m0 0l7 7m-7-7v18"/>
        </svg>
    </button>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // ===== 1. Scroll-triggered Reveal Animations (Ultra Lightweight) =====
            const reveals = document.querySelectorAll('.reveal-on-scroll');
            if ('IntersectionObserver' in window && reveals.length > 0) {
                const revealObserver = new IntersectionObserver((entries, observer) => {
                    entries.forEach(entry => {
                        if (entry.isIntersecting) {
                            entry.target.classList.add('is-revealed');
                            observer.unobserve(entry.target); // Unobserve immediately to free memory/CPU
                        }
                    });
                }, {
                    root: null,
                    threshold: 0.1,
                    rootMargin: '0px 0px -40px 0px'
                });

                reveals.forEach(el => revealObserver.observe(el));
            } else {
                // Fallback for older browsers
                reveals.forEach(el => el.classList.add('is-revealed'));
            }

            // ===== 2. High Performance Scroll Effects (requestAnimationFrame throttled) =====
            const mainNav = document.getElementById('main-nav');
            const progressBar = document.getElementById('scroll-progress-bar');
            const backToTopBtn = document.getElementById('back-to-top');
            const navItems = document.querySelectorAll('.nav-item');
            const cateringsSec = document.getElementById('caterings');
            const testimoniSec = document.getElementById('testimoni');

            let ticking = false;

            function onScroll() {
                const scrollY = window.scrollY;
                const docHeight = document.documentElement.scrollHeight - window.innerHeight;

                // Reading progress bar
                if (progressBar && docHeight > 0) {
                    const scrollPct = Math.min(100, Math.max(0, (scrollY / docHeight) * 100));
                    progressBar.style.width = scrollPct + '%';
                }

                // Navbar elevation on scroll
                if (mainNav) {
                    if (scrollY > 15) {
                        mainNav.classList.add('nav-scrolled');
                    } else {
                        mainNav.classList.remove('nav-scrolled');
                    }
                }

                // Back to Top button
                if (backToTopBtn) {
                    if (scrollY > 280) {
                        backToTopBtn.classList.remove('opacity-0', 'translate-y-4', 'pointer-events-none');
                        backToTopBtn.classList.add('opacity-100', 'translate-y-0');
                    } else {
                        backToTopBtn.classList.add('opacity-0', 'translate-y-4', 'pointer-events-none');
                        backToTopBtn.classList.remove('opacity-100', 'translate-y-0');
                    }
                }

                // Nav Links Active Indicator
                const hash = window.location.hash;
                if (hash === '#testimoni' || (testimoniSec && scrollY >= testimoniSec.offsetTop - 150)) {
                    setActiveNav('nav-testimoni');
                } else if (hash === '#caterings' || (cateringsSec && scrollY >= cateringsSec.offsetTop - 150)) {
                    setActiveNav('nav-caterings');
                } else {
                    setActiveNav('nav-home');
                }

                ticking = false;
            }

            function setActiveNav(activeId) {
                navItems.forEach(item => {
                    if (item.id === activeId) {
                        item.classList.add('text-orange-500', 'border-b-2', 'border-orange-500');
                        item.classList.remove('text-gray-600');
                    } else {
                        item.classList.remove('text-orange-500', 'border-b-2', 'border-orange-500');
                        item.classList.add('text-gray-600');
                    }
                });
            }

            window.addEventListener('scroll', function() {
                if (!ticking) {
                    window.requestAnimationFrame(onScroll);
                    ticking = true;
                }
            }, { passive: true });

            window.addEventListener('hashchange', onScroll);

            // Back to top click handler
            if (backToTopBtn) {
                backToTopBtn.addEventListener('click', function() {
                    window.scrollTo({
                        top: 0,
                        behavior: 'smooth'
                    });
                });
            }

            // Initial check
            onScroll();
        });
    </script>
</body>
</html>