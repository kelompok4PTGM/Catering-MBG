@extends('layouts.admin')

@section('admin_content')
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
@endsection
