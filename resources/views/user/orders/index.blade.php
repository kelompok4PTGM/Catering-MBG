@extends('layouts.user')

@section('user_content')
<div class="flex justify-between items-center mb-6">
    <div>
        <h2 class="text-2xl font-bold text-gray-800">📋 Pesanan Saya</h2>
        <p class="text-sm text-gray-500">Daftar semua riwayat pesanan catering Anda</p>
    </div>
    <a href="{{ route('home') }}" class="bg-primary hover:bg-amber-600 text-white px-4 py-2 rounded-lg text-sm font-medium transition">
        <i class="fas fa-plus"></i> Pesan Baru
    </a>
</div>

<!-- Stats -->
<div class="grid grid-cols-1 sm:grid-cols-3 gap-4 mb-6">
    <div class="bg-white rounded-lg shadow-sm p-4 border border-gray-100">
        <p class="text-sm text-gray-500">Semua Pesanan</p>
        <p class="text-2xl font-bold text-gray-800">{{ $orders->count() }}</p>
    </div>
    <div class="bg-yellow-50 rounded-lg shadow-sm p-4 border border-yellow-100">
        <p class="text-sm text-yellow-600">Pending / Diproses</p>
        <p class="text-2xl font-bold text-yellow-700">{{ $orders->whereIn('status_pesanan', ['Pending', 'Diproses'])->count() }}</p>
    </div>
    <div class="bg-green-50 rounded-lg shadow-sm p-4 border border-green-100">
        <p class="text-sm text-green-600">Selesai</p>
        <p class="text-2xl font-bold text-green-700">{{ $orders->where('status_pesanan', 'Selesai')->count() }}</p>
    </div>
</div>

<!-- Table -->
<div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full text-sm">
            <thead>
                <tr class="bg-gray-50 text-left">
                    <th class="p-4 font-semibold text-gray-600">ID</th>
                    <th class="p-4 font-semibold text-gray-600">Catering</th>
                    <th class="p-4 font-semibold text-gray-600">Tanggal</th>
                    <th class="p-4 font-semibold text-gray-600">Total</th>
                    <th class="p-4 font-semibold text-gray-600">Status</th>
                    <th class="p-4 font-semibold text-gray-600">Pembayaran</th>
                    <th class="p-4 font-semibold text-gray-600">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($orders as $order)
                <tr class="border-t border-gray-100 hover:bg-gray-50 transition">
                    <td class="p-4 font-medium">#{{ $order->id }}</td>
                    <td class="p-4">{{ $order->catering->nama_catering ?? 'N/A' }}</td>
                    <td class="p-4">{{ \Carbon\Carbon::parse($order->tanggal_pesanan)->format('d/m/Y H:i') }}</td>
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
                        @if($order->pembayaran)
                            <span class="px-2 py-1 text-xs rounded-full bg-green-100 text-green-800">Lunas</span>
                        @else
                            <span class="px-2 py-1 text-xs rounded-full bg-red-100 text-red-800">Belum Bayar</span>
                        @endif
                    </td>
                    <td class="p-4">
                        <a href="{{ route('user.orders.show', $order->id) }}" class="text-primary hover:underline text-xs font-medium">
                            Detail
                        </a>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" class="p-8 text-center text-gray-400">
                        <i class="fas fa-inbox text-3xl block mb-2"></i>
                        Belum ada pesanan
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection