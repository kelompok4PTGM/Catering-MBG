@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <div class="flex flex-col md:flex-row gap-6">
        <!-- Sidebar -->
        <div class="w-full md:w-64 bg-white rounded-lg shadow-sm border border-orange-100 p-4 h-fit">
            <h3 class="text-lg font-bold text-textcolor mb-4 pb-2 border-b">Menu Superadmin</h3>
            <ul class="space-y-2">
                <li><a href="#" class="block px-4 py-2 rounded-md bg-orange-50 text-primary font-medium">Dashboard</a></li>
                <li><a href="#" class="block px-4 py-2 rounded-md hover:bg-gray-50 text-gray-700 transition">Kelola Pengguna</a></li>
                <li><a href="#" class="block px-4 py-2 rounded-md hover:bg-gray-50 text-gray-700 transition">Semua Catering</a></li>
                <li><a href="#" class="block px-4 py-2 rounded-md hover:bg-gray-50 text-gray-700 transition">Semua Pesanan</a></li>
            </ul>
        </div>
        
        <!-- Main Content -->
        <div class="flex-1 bg-white rounded-lg shadow-sm border border-orange-100 p-6">
            <h2 class="text-2xl font-bold text-textcolor mb-6">Dashboard Superadmin</h2>
            <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 mb-8">
                <div class="bg-orange-50 p-4 rounded-lg border border-orange-100">
                    <p class="text-sm text-gray-500 font-medium">Total Pengguna</p>
                    <p class="text-3xl font-bold text-primary mt-1">125</p>
                </div>
                <div class="bg-green-50 p-4 rounded-lg border border-green-100">
                    <p class="text-sm text-gray-500 font-medium">Total Catering</p>
                    <p class="text-3xl font-bold text-accent mt-1">15</p>
                </div>
                <div class="bg-blue-50 p-4 rounded-lg border border-blue-100">
                    <p class="text-sm text-gray-500 font-medium">Total Transaksi</p>
                    <p class="text-3xl font-bold text-blue-600 mt-1">320</p>
                </div>
            </div>
            
            <div class="bg-yellow-50 border-l-4 border-yellow-400 p-4 rounded">
                <div class="flex">
                    <div class="flex-shrink-0">
                        <svg class="h-5 w-5 text-yellow-400" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd" />
                        </svg>
                    </div>
                    <div class="ml-3">
                        <p class="text-sm text-yellow-700">
                            Sebagai Superadmin, Anda memiliki hak penuh terhadap keseluruhan sistem Catering MBG.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
