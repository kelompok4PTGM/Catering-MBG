@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <div class="mb-8">
        <h1 class="text-3xl font-extrabold text-textcolor">Pesanan Saya</h1>
        <p class="text-sm text-gray-500 mt-1">Daftar semua riwayat pesanan catering yang telah Anda buat.</p>
    </div>

    @if(session('success'))
        <div class="mb-6 bg-green-50 border-l-4 border-accent p-4 rounded text-sm text-green-800 shadow-sm">
            {{ session('success') }}
        </div>
    @endif

    @if($orders->count() > 0)
    <div class="bg-white rounded-2xl shadow-sm border border-orange-100 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-amber-50/50 border-b border-orange-100 text-xs font-bold text-gray-500 uppercase tracking-wider">
                        <th class="py-4 px-6">ID Pesanan</th>
                        <th class="py-4 px-6">Catering</th>
                        <th class="py-4 px-6">Tanggal</th>
                        <th class="py-4 px-6">Total Harga</th>
                        <th class="py-4 px-6 text-center">Status Pesanan</th>
                        <th class="py-4 px-6 text-center">Pembayaran</th>
                        <th class="py-4 px-6 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100 text-sm">
                    @foreach($orders as $order)
                    <tr class="hover:bg-amber-50/30 transition">
                        <td class="py-4 px-6 font-bold text-textcolor">#ORD-{{ str_pad($order->id, 5, '0', STR_PAD_LEFT) }}</td>
                        <td class="py-4 px-6 font-semibold text-textcolor">{{ $order->catering->nama_catering ?? 'Catering N/A' }}</td>
                        <td class="py-4 px-6 text-gray-500 text-xs">{{ date('d M Y, H:i', strtotime($order->tanggal_pesanan)) }}</td>
                        <td class="py-4 px-6 font-extrabold text-primary">Rp {{ number_format($order->total_harga, 0, ',', '.') }}</td>
                        <td class="py-4 px-6 text-center">
                            @if($order->status_pesanan === 'Pending')
                                <span class="px-3 py-1 text-xs font-bold rounded-full bg-yellow-100 text-yellow-800">Pending</span>
                            @elseif($order->status_pesanan === 'Diproses')
                                <span class="px-3 py-1 text-xs font-bold rounded-full bg-blue-100 text-blue-800">Diproses</span>
                            @elseif($order->status_pesanan === 'Selesai')
                                <span class="px-3 py-1 text-xs font-bold rounded-full bg-green-100 text-green-800">Selesai</span>
                            @else
                                <span class="px-3 py-1 text-xs font-bold rounded-full bg-red-100 text-red-800">Batal</span>
                            @endif
                        </td>
                        <td class="py-4 px-6 text-center">
                            @if($order->pembayaran)
                                <span class="px-3 py-1 text-xs font-bold rounded-full bg-green-100 text-green-800">Lunas ({{ $order->pembayaran->metode_pembayaran }})</span>
                            @else
                                <span class="px-3 py-1 text-xs font-bold rounded-full bg-red-100 text-red-800">Belum Bayar</span>
                            @endif
                        </td>
                        <td class="py-4 px-6 text-right">
                            <a href="{{ route('user.orders.show', $order->id) }}" class="inline-block bg-primary hover:bg-amber-600 text-white font-bold px-4 py-2 rounded-lg text-xs transition shadow-sm">
                                Detail & Bayar &rarr;
                            </a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    @else
    <div class="bg-white rounded-2xl p-12 text-center border border-orange-100 shadow-sm">
        <svg class="mx-auto h-16 w-16 text-gray-300 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
        </svg>
        <h3 class="text-lg font-bold text-textcolor">Belum Ada Pesanan</h3>
        <p class="text-sm text-gray-500 mt-1 mb-6">Anda belum pernah membuat pesanan catering.</p>
        <a href="{{ route('home') }}" class="inline-flex items-center px-6 py-3 bg-primary text-white font-bold text-sm rounded-xl hover:bg-amber-600 transition shadow">
            Mulai Pesan Sekarang
        </a>
    </div>
    @endif
</div>
@endsection
