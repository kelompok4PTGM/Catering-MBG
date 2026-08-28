@extends('layouts.user')

@section('user_content')
<!-- Page Header -->
<div class="flex justify-between items-center mb-6">
    <div>
        <h2 class="text-2xl font-bold text-gray-800">Selamat Datang, {{ Auth::user()->username }}! 👋</h2>
        <p class="text-sm text-gray-500">Kelola pesanan dan temukan catering favorit Anda</p>
    </div>
    <div class="text-sm text-gray-500">
        {{ now()->format('l, d F Y') }}
    </div>
</div>

<!-- Stats Cards -->
<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
    <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-100 hover:shadow-md transition">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm text-gray-500 font-medium">Total Pesanan</p>
                <p class="text-3xl font-bold text-gray-800 mt-1">{{ $totalPesanan ?? 0 }}</p>
            </div>
            <div class="bg-orange-100 p-3 rounded-lg">
                <i class="fas fa-shopping-cart text-orange-600 text-xl"></i>
            </div>
        </div>
    </div>
    <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-100 hover:shadow-md transition">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm text-gray-500 font-medium">Pesanan Selesai</p>
                <p class="text-3xl font-bold text-gray-800 mt-1">{{ $totalSelesai ?? 0 }}</p>
            </div>
            <div class="bg-green-100 p-3 rounded-lg">
                <i class="fas fa-check-circle text-green-600 text-xl"></i>
            </div>
        </div>
    </div>
    <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-100 hover:shadow-md transition">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm text-gray-500 font-medium">Keranjang</p>
                <p class="text-3xl font-bold text-gray-800 mt-1">{{ count(session()->get('cart', [])) }}</p>
            </div>
            <div class="bg-yellow-100 p-3 rounded-lg">
                <i class="fas fa-shopping-bag text-yellow-600 text-xl"></i>
            </div>
        </div>
    </div>
    <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-100 hover:shadow-md transition">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm text-gray-500 font-medium">Total Belanja</p>
                <p class="text-3xl font-bold text-gray-800 mt-1">Rp {{ number_format($totalBelanja ?? 0, 0, ',', '.') }}</p>
            </div>
            <div class="bg-purple-100 p-3 rounded-lg">
                <i class="fas fa-money-bill-wave text-purple-600 text-xl"></i>
            </div>
        </div>
    </div>
</div>

<!-- Quick Actions -->
<div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
    <a href="{{ route('home') }}" class="bg-gradient-to-r from-orange-500 to-amber-500 rounded-xl shadow-sm p-6 text-white hover:shadow-md transition">
        <div class="flex items-center gap-4">
            <div class="bg-white/20 p-3 rounded-lg">
                <i class="fas fa-store text-2xl"></i>
            </div>
            <div>
                <h3 class="font-semibold text-lg">Cari Catering</h3>
                <p class="text-white/80 text-sm">Temukan menu sehat & bergizi</p>
            </div>
            <i class="fas fa-arrow-right ml-auto"></i>
        </div>
    </a>
    <a href="{{ route('user.orders') }}" class="bg-gradient-to-r from-blue-500 to-indigo-500 rounded-xl shadow-sm p-6 text-white hover:shadow-md transition">
        <div class="flex items-center gap-4">
            <div class="bg-white/20 p-3 rounded-lg">
                <i class="fas fa-clipboard-list text-2xl"></i>
            </div>
            <div>
                <h3 class="font-semibold text-lg">Lihat Pesanan</h3>
                <p class="text-white/80 text-sm">Cek status pesanan Anda</p>
            </div>
            <i class="fas fa-arrow-right ml-auto"></i>
        </div>
    </a>
</div>

<!-- Recent Orders -->
<div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
    <div class="px-6 py-4 border-b border-gray-100 flex justify-between items-center">
        <h3 class="font-semibold text-gray-700">📋 Pesanan Terbaru</h3>
        <a href="{{ route('user.orders') }}" class="text-sm text-primary hover:underline">Lihat semua →</a>
    </div>
    <div class="overflow-x-auto">
        <table class="w-full text-sm">
            <thead>
                <tr class="bg-gray-50 text-left">
                    <th class="p-4 font-semibold text-gray-600">ID</th>
                    <th class="p-4 font-semibold text-gray-600">Tanggal</th>
                    <th class="p-4 font-semibold text-gray-600">Catering</th>
                    <th class="p-4 font-semibold text-gray-600">Total</th>
                    <th class="p-4 font-semibold text-gray-600">Status</th>
                    <th class="p-4 font-semibold text-gray-600">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($pesanan ?? [] as $order)
                <tr class="border-t border-gray-100 hover:bg-gray-50 transition">
                    <td class="p-4 font-medium">#{{ $order->id }}</td>
                    <td class="p-4">{{ \Carbon\Carbon::parse($order->tanggal_pesanan)->format('d/m/Y H:i') }}</td>
                    <td class="p-4">{{ $order->catering->nama_catering ?? 'N/A' }}</td>
                    <td class="p-4 font-medium">Rp {{ number_format($order->total_harga, 0, ',', '.') }}</td>
                    <td class="p-4">
                        <span class="px-2 py-1 text-xs rounded-full 
                            {{ $order->status_pesanan == 'Selesai' ? 'bg-green-100 text-green-800' : 
                               ($order->status_pesanan == 'Pending' ? 'bg-yellow-100 text-yellow-800' : 
                               ($order->status_pesanan == 'Diproses' ? 'bg-blue-100 text-blue-800' : 'bg-red-100 text-red-800')) }}">
                            {{ $order->status_pesanan }}
                        </span>
                    </td>
                    <td class="p-4">
                        <a href="{{ route('user.orders.show', $order->id) }}" class="text-primary hover:underline text-xs font-medium">
                            Detail
                        </a>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="p-8 text-center text-gray-400">
                        <i class="fas fa-inbox text-3xl block mb-2"></i>
                        Belum ada pesanan. Yuk, mulai pesan sekarang!
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<!-- Info Box -->
<div class="mt-6 bg-blue-50 border-l-4 border-blue-500 p-4 rounded">
    <div class="flex items-center gap-3">
        <i class="fas fa-info-circle text-blue-500 text-lg"></i>
        <p class="text-sm text-blue-700">
            Butuh bantuan? Hubungi admin catering atau cek <a href="{{ route('user.orders') }}" class="font-semibold underline">status pesanan</a> Anda.
        </p>
    </div>
</div>
@endsection