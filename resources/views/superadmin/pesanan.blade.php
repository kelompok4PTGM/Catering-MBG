@extends('layouts.superadmin')

@php
    $pageTitle = 'Semua Pesanan';
@endphp

@section('content')
<!-- Page Header -->
<div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-6">
    <div>
        <h2 class="text-2xl font-bold text-gray-800">📦 Semua Pesanan</h2>
        <p class="text-sm text-gray-500">Seluruh riwayat transaksi pesanan catering di platform Catering MBG</p>
    </div>
    <div class="text-sm text-gray-500 bg-white px-4 py-2 rounded-lg border border-gray-100 shadow-sm">
        <i class="far fa-calendar-alt text-primary mr-2"></i>{{ now()->format('d M Y') }}
    </div>
</div>

<!-- Stats Summary -->
<div class="grid grid-cols-2 lg:grid-cols-4 gap-4 mb-6">
    <div class="bg-white p-5 rounded-xl border border-gray-100 shadow-sm">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-xs text-gray-500 uppercase font-semibold">Total Pesanan</p>
                <h3 class="text-2xl font-bold text-gray-800 mt-1">{{ $pesanan->count() }}</h3>
            </div>
            <div class="w-10 h-10 rounded-lg bg-orange-50 text-primary flex items-center justify-center text-lg">
                <i class="fas fa-clipboard-list"></i>
            </div>
        </div>
    </div>
    <div class="bg-white p-5 rounded-xl border border-gray-100 shadow-sm">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-xs text-gray-500 uppercase font-semibold">Volume Transaksi</p>
                <h3 class="text-2xl font-bold text-emerald-700 mt-1">Rp {{ number_format($pesanan->sum('total_harga'), 0, ',', '.') }}</h3>
            </div>
            <div class="w-10 h-10 rounded-lg bg-emerald-50 text-emerald-600 flex items-center justify-center text-lg">
                <i class="fas fa-money-bill-wave"></i>
            </div>
        </div>
    </div>
    <div class="bg-white p-5 rounded-xl border border-gray-100 shadow-sm">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-xs text-gray-500 uppercase font-semibold">Pesanan Selesai</p>
                <h3 class="text-2xl font-bold text-green-600 mt-1">{{ $pesanan->where('status_pesanan', 'Selesai')->count() }}</h3>
            </div>
            <div class="w-10 h-10 rounded-lg bg-green-50 text-green-600 flex items-center justify-center text-lg">
                <i class="fas fa-check-double"></i>
            </div>
        </div>
    </div>
    <div class="bg-white p-5 rounded-xl border border-gray-100 shadow-sm">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-xs text-gray-500 uppercase font-semibold">Aktif / Berjalan</p>
                <h3 class="text-2xl font-bold text-blue-600 mt-1">{{ $pesanan->whereIn('status_pesanan', ['Pending', 'Diproses'])->count() }}</h3>
            </div>
            <div class="w-10 h-10 rounded-lg bg-blue-50 text-blue-600 flex items-center justify-center text-lg">
                <i class="fas fa-clock"></i>
            </div>
        </div>
    </div>
</div>

<!-- Table Container -->
<div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
    <div class="px-6 py-4 border-b border-gray-100 flex items-center justify-between">
        <h3 class="font-semibold text-gray-800">Daftar Transaksi Pesanan</h3>
        <span class="text-xs bg-gray-100 text-gray-600 font-medium px-2.5 py-1 rounded-full">{{ $pesanan->count() }} Pesanan</span>
    </div>

    <div class="overflow-x-auto">
        <table class="w-full text-left text-sm text-gray-600">
            <thead class="bg-gray-50 text-xs text-gray-500 uppercase font-semibold border-b border-gray-100">
                <tr>
                    <th scope="col" class="px-6 py-3.5">ID Pesanan</th>
                    <th scope="col" class="px-6 py-3.5">Pelanggan</th>
                    <th scope="col" class="px-6 py-3.5">Mitra Catering</th>
                    <th scope="col" class="px-6 py-3.5">Tanggal</th>
                    <th scope="col" class="px-6 py-3.5">Total Harga</th>
                    <th scope="col" class="px-6 py-3.5">Status</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @forelse($pesanan as $order)
                <tr class="hover:bg-gray-50/80 transition-colors">
                    <td class="px-6 py-4 font-mono font-medium text-xs text-gray-700">
                        #{{ $order->id }}
                    </td>
                    <td class="px-6 py-4">
                        <div class="flex items-center gap-3">
                            <div class="w-8 h-8 rounded-full bg-slate-100 border border-slate-200 text-slate-700 font-bold flex items-center justify-center text-xs">
                                {{ strtoupper(substr($order->pelanggan->username ?? 'G', 0, 2)) }}
                            </div>
                            <div>
                                <span class="font-medium text-gray-900 block">{{ $order->pelanggan->username ?? 'Pelanggan Guest' }}</span>
                                <span class="text-xs text-gray-400">{{ $order->pelanggan->email ?? '-' }}</span>
                            </div>
                        </div>
                    </td>
                    <td class="px-6 py-4">
                        <span class="font-medium text-gray-800 flex items-center gap-1.5">
                            <i class="fas fa-store text-orange-400 text-xs"></i>
                            {{ $order->catering->nama_catering ?? 'Mitra Dihapus' }}
                        </span>
                    </td>
                    <td class="px-6 py-4 text-xs text-gray-500">
                        {{ \Carbon\Carbon::parse($order->tanggal_pesanan)->translatedFormat('d M Y, H:i') }}
                    </td>
                    <td class="px-6 py-4 font-bold text-gray-900">
                        Rp {{ number_format($order->total_harga, 0, ',', '.') }}
                    </td>
                    <td class="px-6 py-4">
                        @if($order->status_pesanan == 'Selesai')
                            <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                <i class="fas fa-check-circle text-[10px]"></i> Selesai
                            </span>
                        @elseif($order->status_pesanan == 'Diproses')
                            <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                <i class="fas fa-spinner fa-spin text-[10px]"></i> Diproses
                            </span>
                        @elseif($order->status_pesanan == 'Pending')
                            <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full text-xs font-medium bg-amber-100 text-amber-800">
                                <i class="fas fa-hourglass-half text-[10px]"></i> Menunggu
                            </span>
                        @else
                            <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full text-xs font-medium bg-red-100 text-red-800">
                                <i class="fas fa-times-circle text-[10px]"></i> {{ $order->status_pesanan }}
                            </span>
                        @endif
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="px-6 py-10 text-center text-gray-400">
                        <i class="fas fa-box-open text-4xl mb-3 block text-gray-300"></i>
                        Belum ada data pesanan.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection