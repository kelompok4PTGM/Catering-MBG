<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Catering MBG</title>
    @fonts

    @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    @else
        <script src="https://cdn.tailwindcss.com"></script>
    @endif

    <!-- Custom CSS -->
    <style>
        .hero-gradient {
            background: linear-gradient(135deg, #fff7ed 0%, #ffedd5 100%);
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
        .badge-rating {
            background: #1f2937;
            color: white;
            padding: 3px 10px;
            border-radius: 6px;
            font-size: 13px;
            font-weight: 600;
        }
        .search-input:focus {
            outline: none;
            box-shadow: 0 0 0 3px rgba(249, 115, 22, 0.2);
        }
        .dark .hero-gradient {
            background: linear-gradient(135deg, #1c1917 0%, #292524 100%);
        }
    </style>
</head>
<body class="bg-white dark:bg-[#0a0a0a] text-gray-900 dark:text-white min-h-screen antialiased">

    <!-- Navbar -->
    <header class="w-full bg-white dark:bg-[#0a0a0a] border-b border-gray-100 dark:border-gray-800">
        <div class="max-w-6xl mx-auto px-4 sm:px-6 py-4 flex items-center justify-between">
            <!-- Logo -->
            <a href="/" class="flex items-center gap-2">
                <span class="text-2xl">🍽️</span>
                <span class="text-xl font-bold text-orange-500">Catering MBG</span>
            </a>

            <!-- Menu Tengah -->
            <nav class="hidden md:flex items-center gap-8">
                <a href="/" class="text-sm font-medium text-orange-500 border-b-2 border-orange-500 pb-1">Beranda</a>
                <a href="#" class="text-sm font-medium text-gray-600 dark:text-gray-300 hover:text-orange-500 transition">Cari Catering</a>
                <a href="#" class="text-sm font-medium text-gray-600 dark:text-gray-300 hover:text-orange-500 transition">Testimoni Kami</a>
            </nav>

            <!-- Kanan: Search + Login/Daftar -->
            <div class="flex items-center gap-3">
                <button class="text-gray-500 hover:text-orange-500 transition">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                    </svg>
                </button>
                <button class="text-gray-500 hover:text-orange-500 transition">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
                    </svg>
                </button>

                @if (Route::has('login'))
                    @auth
                        <a href="{{ url('/dashboard') }}" class="text-sm font-medium text-gray-600 dark:text-gray-300 hover:text-orange-500 transition">Dashboard</a>
                    @else
                        <a href="{{ route('login') }}" class="text-sm font-medium text-gray-600 dark:text-gray-300 hover:text-orange-500 transition">Login</a>
                        @if (Route::has('register'))
                            <a href="{{ route('register') }}" class="btn-primary text-sm font-medium px-5 py-2 rounded-full">Daftar</a>
                        @endif
                    @endauth
                @endif
            </div>
        </div>
    </header>

    <!-- Hero Section -->
    <section class="py-12 lg:py-16">
        <div class="max-w-6xl mx-auto px-4 sm:px-6">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-10 items-center">
                <!-- Kiri: Teks + Search -->
                <div>
                    <h1 class="text-4xl lg:text-5xl font-bold text-gray-900 dark:text-white leading-tight">
                        Temukan Catering Terbaik untuk Setiap Kebutuhan
                    </h1>
                    <p class="text-gray-600 dark:text-gray-400 mt-4 mb-8 leading-relaxed">
                        Pesan berbagai menu dan paket catering dari penyedia catering terpercaya dalam satu platform.
                    </p>

                    <!-- Search Bar -->
                    <div class="flex gap-2 mb-10">
                        <div class="relative flex-1">
                            <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                                </svg>
                            </div>
                            <input type="text" placeholder="Cari catering atau menu favorit anda..." class="search-input w-full pl-12 pr-4 py-3 border border-gray-200 dark:border-gray-700 dark:bg-[#161615] rounded-lg text-sm focus:border-orange-500 transition" />
                        </div>
                        <button class="btn-primary px-6 py-3 rounded-lg text-sm font-semibold whitespace-nowrap">Cari Catering</button>
                    </div>

                    <!-- Statistik -->
                    <div class="grid grid-cols-3 gap-6">
                        <div>
                            <span class="block text-2xl lg:text-3xl font-bold text-orange-500">1000+</span>
                            <span class="text-xs text-gray-500 dark:text-gray-400 uppercase tracking-wide">Banyak Pilihan Catering</span>
                        </div>
                        <div>
                            <span class="block text-2xl lg:text-3xl font-bold text-orange-500">50K+</span>
                            <span class="text-xs text-gray-500 dark:text-gray-400 uppercase tracking-wide">Menu Berkualitas</span>
                        </div>
                        <div>
                            <span class="block text-2xl lg:text-3xl font-bold text-orange-500">Mudah</span>
                            <span class="text-xs text-gray-500 dark:text-gray-400 uppercase tracking-wide">Pemesanan Mudah</span>
                        </div>
                    </div>
                </div>

                <!-- Kanan: Gambar Hero -->
                <div class="relative">
                    <div class="hero-gradient rounded-2xl aspect-square lg:aspect-auto lg:h-[480px] flex items-center justify-center overflow-hidden">
                        <div class="text-center p-8">
                            <div class="w-20 h-20 mx-auto bg-white rounded-2xl flex items-center justify-center shadow-lg">
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-10 h-10 text-orange-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                </svg>
                            </div>
                            <p class="text-gray-500 dark:text-gray-400 text-sm mt-4">Gambar Catering</p>
                        </div>
                    </div>
                    <!-- Aksen orange di pojok kanan bawah -->
                    <div class="absolute bottom-0 right-0 w-24 h-24 bg-orange-400 rounded-tl-3xl"></div>
                </div>
            </div>
        </div>
    </section>

    <!-- Catering Pilihan Terbaik -->
    <section class="py-12 lg:py-16 bg-gray-50 dark:bg-[#0f0f0f]">
        <div class="max-w-6xl mx-auto px-4 sm:px-6">
            <!-- Judul -->
            <div class="text-center mb-10">
                <h2 class="text-2xl lg:text-3xl font-bold text-gray-900 dark:text-white">Catering Pilihan Terbaik</h2>
                <p class="text-gray-500 dark:text-gray-400 mt-2">Temukan catering terpercaya dengan berbagai pilihan menu.</p>
            </div>

            <!-- Grid Kartu Catering -->
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">

                <!-- Kartu 1: Catering Bunda Fadli -->
                <div class="card-catering bg-white dark:bg-[#161615] rounded-xl overflow-hidden border border-gray-100 dark:border-gray-800">
                    <div class="h-40 bg-gradient-to-br from-orange-200 to-orange-100 flex items-center justify-center">
                        <span class="text-5xl">🍱</span>
                    </div>
                    <div class="p-4">
                        <div class="flex items-start justify-between mb-1">
                            <h3 class="font-bold text-gray-900 dark:text-white">Catering Bunda Fadli</h3>
                            <span class="badge-rating">★ 4.9</span>
                        </div>
                        <p class="text-xs text-gray-500 dark:text-gray-400 mb-1">0 Januari</p>
                        <p class="text-sm text-gray-600 dark:text-gray-300 mb-4 line-clamp-2">Spesial nasi kotak dari perusahaan urutan acara.</p>
                        <button class="w-full border border-gray-300 dark:border-gray-700 text-sm font-medium py-2 rounded-lg hover:bg-orange-500 hover:text-white hover:border-orange-500 transition">Lihat Catering</button>
                    </div>
                </div>

                <!-- Kartu 2: Rasa Murni Catering -->
                <div class="card-catering bg-white dark:bg-[#161615] rounded-xl overflow-hidden border border-gray-100 dark:border-gray-800">
                    <div class="h-40 bg-gradient-to-br from-amber-200 to-yellow-100 flex items-center justify-center">
                        <span class="text-5xl">🥘</span>
                    </div>
                    <div class="p-4">
                        <div class="flex items-start justify-between mb-1">
                            <h3 class="font-bold text-gray-900 dark:text-white">Rasa Murni Catering</h3>
                            <span class="badge-rating">★ 4.8</span>
                        </div>
                        <p class="text-xs text-gray-500 dark:text-gray-400 mb-1">0 Januari</p>
                        <p class="text-sm text-gray-600 dark:text-gray-300 mb-4 line-clamp-2">Menyediakan hidangan bagi masyarakat dengan menu berkualitas.</p>
                        <button class="w-full border border-gray-300 dark:border-gray-700 text-sm font-medium py-2 rounded-lg hover:bg-orange-500 hover:text-white hover:border-orange-500 transition">Lihat Catering</button>
                    </div>
                </div>

                <!-- Kartu 3: Sehat & Sedap -->
                <div class="card-catering bg-white dark:bg-[#161615] rounded-xl overflow-hidden border border-gray-100 dark:border-gray-800">
                    <div class="h-40 bg-gradient-to-br from-emerald-200 to-green-100 flex items-center justify-center">
                        <span class="text-5xl">🥗</span>
                    </div>
                    <div class="p-4">
                        <div class="flex items-start justify-between mb-1">
                            <h3 class="font-bold text-gray-900 dark:text-white">Sehat & Sedap</h3>
                            <span class="badge-rating">★ 4.7</span>
                        </div>
                        <p class="text-xs text-gray-500 dark:text-gray-400 mb-1">0 Januari</p>
                        <p class="text-sm text-gray-600 dark:text-gray-300 mb-4 line-clamp-2">Pilihan tepat untuk gaya hidup sehat dengan rasa yang lezat.</p>
                        <button class="w-full border border-gray-300 dark:border-gray-700 text-sm font-medium py-2 rounded-lg hover:bg-orange-500 hover:text-white hover:border-orange-500 transition">Lihat Catering</button>
                    </div>
                </div>

                <!-- Kartu 4: Manis Delight -->
                <div class="card-catering bg-white dark:bg-[#161615] rounded-xl overflow-hidden border border-gray-100 dark:border-gray-800">
                    <div class="h-40 bg-gradient-to-br from-pink-200 to-rose-100 flex items-center justify-center">
                        <span class="text-5xl">🍰</span>
                    </div>
                    <div class="p-4">
                        <div class="flex items-start justify-between mb-1">
                            <h3 class="font-bold text-gray-900 dark:text-white">Manis Delight</h3>
                            <span class="badge-rating">★ 4.9</span>
                        </div>
                        <p class="text-xs text-gray-500 dark:text-gray-400 mb-1">0 Januari</p>
                        <p class="text-sm text-gray-600 dark:text-gray-300 mb-4 line-clamp-2">Kreasu pencuci mulut artisan dari pastry mentah yang lembut.</p>
                        <button class="w-full border border-gray-300 dark:border-gray-700 text-sm font-medium py-2 rounded-lg hover:bg-orange-500 hover:text-white hover:border-orange-500 transition">Lihat Catering</button>
                    </div>
                </div>

            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="bg-white dark:bg-[#0a0a0a] border-t border-gray-100 dark:border-gray-800 py-8">
        <div class="max-w-6xl mx-auto px-4 sm:px-6 text-center text-sm text-gray-500 dark:text-gray-400">
            <p>© {{ date('Y') }} Catering MBG. All rights reserved.</p>
        </div>
    </footer>

</body>
</html>