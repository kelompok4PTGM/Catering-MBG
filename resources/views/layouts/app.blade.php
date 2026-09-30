<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Catering MBG</title>
    <script src="https://cdn.tailwindcss.com"></script>
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
        body {
            color: #374151;
            background-color: #ffffff;
        }
        .btn-primary {
            background-color: #f97316;
            color: white;
            transition: all 0.2s;
        }
        .btn-primary:hover {
            background-color: #ea580c;
        }
        .card-catering {
            transition: all 0.3s ease;
        }
        .card-catering:hover {
            transform: translateY(-4px);
            box-shadow: 0 12px 24px rgba(0,0,0,0.1);
        }
    </style>
</head>
<body class="flex flex-col min-h-screen">

    <!-- Navbar -->
    <nav class="bg-white border-b border-gray-100 shadow-sm sticky top-0 z-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16 items-center">

                <!-- Logo -->
                <a href="{{ route('home') }}" class="flex items-center gap-2">
                    <span class="text-2xl">🍽️</span>
                    <span class="text-xl font-bold text-orange-500">Catering MBG</span>
                </a>

                <!-- Menu Tengah -->
                <div class="hidden md:flex items-center gap-8">
                    <a href="{{ route('home') }}" class="text-sm font-medium text-orange-500 border-b-2 border-orange-500 pb-1">Beranda</a>
                    <a href="#caterings" class="text-sm font-medium text-gray-600 hover:text-orange-500 transition">Cari Catering</a>
                    <a href="#" class="text-sm font-medium text-gray-600 hover:text-orange-500 transition">Testimoni Kami</a>
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

</body>
</html>