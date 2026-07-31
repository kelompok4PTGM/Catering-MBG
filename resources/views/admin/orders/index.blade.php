@extends('layouts.admin')

@section('admin_content')
<div>
    <div class="flex items-center justify-between mb-6 pb-4 border-b border-orange-100">
        <div>
            <h2 class="text-2xl font-extrabold text-textcolor">Pesanan Masuk</h2>
            <p class="text-xs text-gray-500 mt-1">Daftar pesanan khusus untuk catering: <strong class="text-primary">{{ $catering->nama_catering ?? '-' }}</strong></p>
        </div>
        <span class="px-3 py-1 text-xs font-bold bg-amber-100 text-amber-800 rounded-full">
            Total: {{ $orders->count() }} Pesanan
        </span>
    </div>

    @if(isset($error))
        <div class="bg-red-50 border-l-4 border-red-500 p-4 rounded text-sm text-red-700 mb-6">
            {{ $error }}
        </div>
    @endif

    @if($orders->count() > 0)
    <div class="overflow-x-auto">
        <table class="w-full text-left border-collapse">
            <thead>
                <tr class="bg-amber-50/50 border-b border-orange-100 text-xs font-bold text-gray-500 uppercase tracking-wider">
                    <th class="py-3 px-4">ID Pesanan</th>
                    <th class="py-3 px-4">Pemesan</th>
                    <th class="py-3 px-4">Tanggal</th>
                    <th class="py-3 px-4">Total</th>
                    <th class="py-3 px-4 text-center">Pembayaran</th>
                    <th class="py-3 px-4 text-center">Status Pesanan</th>
                    <th class="py-3 px-4 text-right">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100 text-sm">
                @foreach($orders as $order)
                <tr class="hover:bg-amber-50/30 transition">
                    <td class="py-3 px-4 font-bold text-textcolor">#ORD-{{ str_pad($order->id, 5, '0', STR_PAD_LEFT) }}</td>
                    <td class="py-3 px-4">
                        <p class="font-bold text-textcolor">{{ $order->pelanggan->username ?? 'N/A' }}</p>
                        <p class="text-xs text-gray-500">{{ $order->pelanggan->email ?? '' }}</p>
                    </td>
                    <td class="py-3 px-4 text-xs text-gray-500">{{ date('d M Y H:i', strtotime($order->tanggal_pesanan)) }}</td>
                    <td class="py-3 px-4 font-extrabold text-primary">Rp {{ number_format($order->total_harga, 0, ',', '.') }}</td>
                    <td class="py-3 px-4 text-center">
                        @if($order->pembayaran)
                            <span class="px-2.5 py-1 text-xs font-bold rounded-full bg-green-100 text-green-800">Lunas</span>
                        @else
                            <span class="px-2.5 py-1 text-xs font-bold rounded-full bg-red-100 text-red-800">Belum Bayar</span>
                        @endif
                    </td>
                    <td class="py-3 px-4 text-center">
                        @if($order->status_pesanan === 'Pending')
                            <span class="px-2.5 py-1 text-xs font-bold rounded-full bg-yellow-100 text-yellow-800">Pending</span>
                        @elseif($order->status_pesanan === 'Diproses')
                            <span class="px-2.5 py-1 text-xs font-bold rounded-full bg-blue-100 text-blue-800">Diproses</span>
                        @elseif($order->status_pesanan === 'Selesai')
                            <span class="px-2.5 py-1 text-xs font-bold rounded-full bg-green-100 text-green-800">Selesai</span>
                        @else
                            <span class="px-2.5 py-1 text-xs font-bold rounded-full bg-red-100 text-red-800">Batal</span>
                        @endif
                    </td>
                    <td class="py-3 px-4 text-right">
                        <a href="{{ route('admin.orders.show', $order->id) }}" class="inline-block bg-primary hover:bg-amber-600 text-white font-bold px-3 py-1.5 rounded-lg text-xs transition">
                            Kelola &rarr;
                        </a>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    @else
    <div class="py-12 text-center bg-gray-50/50 rounded-xl border border-dashed border-gray-200">
        <svg class="mx-auto h-12 w-12 text-gray-300 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
        </svg>
        <p class="text-sm font-medium text-gray-600">Belum ada pesanan masuk untuk catering Anda.</p>
    </div>
    @endif
</div>
@endsection
