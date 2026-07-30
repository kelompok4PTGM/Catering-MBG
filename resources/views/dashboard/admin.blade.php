@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <div class="flex flex-col md:flex-row gap-6">
        <!-- Sidebar -->
        <div class="w-full md:w-64 bg-white rounded-lg shadow-sm border border-orange-100 p-4 h-fit">
            <h3 class="text-lg font-bold text-textcolor mb-4 pb-2 border-b">Menu Manager Catering</h3>
            <ul class="space-y-2">
                <li><a href="#" class="block px-4 py-2 rounded-md bg-orange-50 text-primary font-medium">Dashboard</a></li>
                <li><a href="#" class="block px-4 py-2 rounded-md hover:bg-gray-50 text-gray-700 transition">Profil Catering</a></li>
                <li><a href="#" class="block px-4 py-2 rounded-md hover:bg-gray-50 text-gray-700 transition">Kelola Menu</a></li>
                <li><a href="#" class="block px-4 py-2 rounded-md hover:bg-gray-50 text-gray-700 transition">Kelola Paket</a></li>
                <li><a href="#" class="block px-4 py-2 rounded-md hover:bg-gray-50 text-gray-700 transition">Pesanan Masuk</a></li>
            </ul>
        </div>
        
        <!-- Main Content -->
        <div class="flex-1 bg-white rounded-lg shadow-sm border border-orange-100 p-6">
            <h2 class="text-2xl font-bold text-textcolor mb-6">Dashboard Catering Anda</h2>
            <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 mb-8">
                <div class="bg-orange-50 p-4 rounded-lg border border-orange-100">
                    <p class="text-sm text-gray-500 font-medium">Total Menu</p>
                    <p class="text-3xl font-bold text-primary mt-1">24</p>
                </div>
                <div class="bg-green-50 p-4 rounded-lg border border-green-100">
                    <p class="text-sm text-gray-500 font-medium">Pesanan Baru</p>
                    <p class="text-3xl font-bold text-accent mt-1">5</p>
                </div>
                <div class="bg-blue-50 p-4 rounded-lg border border-blue-100">
                    <p class="text-sm text-gray-500 font-medium">Total Pendapatan</p>
                    <p class="text-2xl font-bold text-blue-600 mt-1">Rp 1.5M</p>
                </div>
            </div>
            
            <div class="bg-blue-50 border-l-4 border-blue-400 p-4 rounded">
                <div class="flex">
                    <div class="flex-shrink-0">
                        <svg class="h-5 w-5 text-blue-400" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"/>
                        </svg>
                    </div>
                    <div class="ml-3">
                        <p class="text-sm text-blue-700">
                            Silakan lengkapi profil catering Anda terlebih dahulu sebelum menambahkan menu agar pelanggan dapat melihat catering Anda.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
