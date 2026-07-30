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
                        primary: '#F59E0B',
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
            background-color: #FFF7ED;
        }
    </style>
</head>
<body class="flex flex-col min-h-screen">
    
    <!-- Navbar -->
    <nav class="bg-primary text-white shadow-md">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16">
                <div class="flex items-center">
                    <a href="{{ route('home') }}" class="text-2xl font-bold tracking-wider">Catering MBG</a>
                </div>
                <div class="flex items-center space-x-4">
                    @auth
                        <span class="text-sm">Halo, {{ Auth::user()->username }} ({{ Auth::user()->role }})</span>
                        <a href="{{ route('dashboard') }}" class="hover:bg-amber-600 px-3 py-2 rounded-md text-sm font-medium transition">Dashboard</a>
                        <form method="POST" action="{{ route('logout') }}" class="inline">
                            @csrf
                            <button type="submit" class="hover:bg-amber-600 px-3 py-2 rounded-md text-sm font-medium transition">Logout</button>
                        </form>
                    @else
                        <a href="{{ route('login') }}" class="hover:bg-amber-600 px-3 py-2 rounded-md text-sm font-medium transition">Login</a>
                        <a href="{{ route('register') }}" class="bg-accent hover:bg-[#5a781d] px-4 py-2 rounded-md text-sm font-bold transition shadow">Daftar</a>
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
    <footer class="bg-white border-t border-gray-200 mt-10">
        <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8 flex justify-between items-center">
            <p class="text-sm text-gray-500">&copy; 2026 Kelompok 4 PTGM. All rights reserved.</p>
            <p class="text-sm text-gray-500">Makan Bergizi Gratis (MBG)</p>
        </div>
    </footer>

</body>
</html>
