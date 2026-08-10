@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <div class="flex flex-col md:flex-row gap-6">
        <!-- Sidebar -->
        <div class="w-full md:w-64 bg-white rounded-lg shadow-sm border border-orange-100 p-4 h-fit">
            <h3 class="text-lg font-bold text-textcolor mb-4 pb-2 border-b">Menu Pelanggan</h3>
            <ul class="space-y-2">
                <li><a href="{{ route('user.dashboard') }}" class="block px-4 py-2 rounded-md bg-orange-50 text-primary font-medium">Dashboard</a></li>
                <li><a href="{{ route('user.orders') }}" class="block px-4 py-2 rounded-md hover:bg-gray-50 text-gray-700 transition">Pesanan Saya</a></li>
                <li><a href="{{ route('cart.index') }}" class="block px-4 py-2 rounded-md hover:bg-gray-50 text-gray-700 transition">Keranjang (Cart)</a></li>
            </ul>
        </div>
        
        <!-- Main Content -->
        <div class="flex-1 bg-white rounded-lg shadow-sm border border-orange-100 p-6">
            <h2 class="text-2xl font-bold text-textcolor mb-6">Selamat Datang, {{ Auth::user()->username }}</h2>
            
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 mb-8">
                <div class="bg-orange-50 p-4 rounded-lg border border-orange-100 flex items-center justify-between">
                    <div>
                        <p class="text-sm text-gray-500 font-medium">Pesanan Aktif</p>
                        <p class="text-3xl font-bold text-primary mt-1">1</p>
                    </div>
                    <div class="bg-orange-200 p-3 rounded-full text-amber-700">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    </div>
                </div>
                <div class="bg-green-50 p-4 rounded-lg border border-green-100 flex items-center justify-between">
                    <div>
                        <p class="text-sm text-gray-500 font-medium">Riwayat Selesai</p>
                        <p class="text-3xl font-bold text-accent mt-1">4</p>
                    </div>
                    <div class="bg-green-200 p-3 rounded-full text-green-700">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                    </div>
                </div>
            </div>
            
            <h3 class="text-lg font-bold text-textcolor mb-4">Pesanan Terakhir</h3>
            <div class="bg-white border border-gray-200 rounded-lg overflow-hidden">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">ID Pesanan</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Catering</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Total</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">#ORD-001</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">Catering Bunda Fadil</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm">
                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800">Diproses</span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">Rp 150.000</td>
                        </tr>
                    </tbody>
                </table>
            </div>
            
            <div class="mt-6">
                <a href="{{ route('home') }}" class="text-primary hover:text-amber-700 font-medium transition">&larr; Kembali cari catering</a>
            </div>
        </div>
    </div>
</div>
@endsection
