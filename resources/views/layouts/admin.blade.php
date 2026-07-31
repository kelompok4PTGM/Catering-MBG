@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <div class="flex flex-col md:flex-row gap-6">
        <!-- Sidebar -->
        <div class="w-full md:w-64 bg-white rounded-lg shadow-sm border border-orange-100 p-4 h-fit">
            <h3 class="text-lg font-bold text-textcolor mb-4 pb-2 border-b">Menu Manager Catering</h3>
            <ul class="space-y-2">
                <li>
                    <a href="{{ route('admin.dashboard') }}" class="block px-4 py-2 rounded-md {{ request()->routeIs('admin.dashboard') ? 'bg-orange-50 text-primary font-medium' : 'hover:bg-gray-50 text-gray-700 transition' }}">
                        Dashboard
                    </a>
                </li>
                <li>
                    <a href="{{ route('admin.catering.profile') }}" class="block px-4 py-2 rounded-md {{ request()->routeIs('admin.catering.*') ? 'bg-orange-50 text-primary font-medium' : 'hover:bg-gray-50 text-gray-700 transition' }}">
                        Profil Catering
                    </a>
                </li>
                <li>
                    <a href="{{ route('menu.index') }}" class="block px-4 py-2 rounded-md {{ request()->routeIs('menu.*') ? 'bg-orange-50 text-primary font-medium' : 'hover:bg-gray-50 text-gray-700 transition' }}">
                        Kelola Menu
                    </a>
                </li>
                <li>
                    <a href="{{ route('paket.index') }}" class="block px-4 py-2 rounded-md {{ request()->routeIs('paket.*') ? 'bg-orange-50 text-primary font-medium' : 'hover:bg-gray-50 text-gray-700 transition' }}">
                        Kelola Paket
                    </a>
                </li>
                <li>
                    <a href="#" class="block px-4 py-2 rounded-md hover:bg-gray-50 text-gray-700 transition">
                        Pesanan Masuk
                    </a>
                </li>
            </ul>
        </div>
        
        <!-- Main Content -->
        <div class="flex-1 bg-white rounded-lg shadow-sm border border-orange-100 p-6">
            @if(session('success'))
                <div class="mb-4 bg-green-50 border-l-4 border-green-500 p-4 rounded text-sm text-green-700">
                    {{ session('success') }}
                </div>
            @endif

            @if(session('error'))
                <div class="mb-4 bg-red-50 border-l-4 border-red-500 p-4 rounded text-sm text-red-700">
                    {{ session('error') }}
                </div>
            @endif

            @yield('admin_content')
        </div>
    </div>
</div>
@endsection
