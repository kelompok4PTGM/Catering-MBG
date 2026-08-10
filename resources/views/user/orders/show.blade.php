@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <div class="mb-6 flex items-center justify-between">
        <div>
            <a href="{{ route('user.orders') }}" class="text-sm font-semibold text-primary hover:underline">&larr; Kembali ke Pesanan Saya</a>
            <h1 class="text-3xl font-extrabold text-textcolor mt-2">Detail Pesanan #ORD-{{ str_pad($order->id, 5, '0', STR_PAD_LEFT) }}</h1>
        </div>
        <div>
            @if($order->status_pesanan === 'Pending')
                <span class="px-4 py-2 text-sm font-bold rounded-full bg-yellow-100 text-yellow-800">Status: Pending</span>
            @elseif($order->status_pesanan === 'Diproses')
                <span class="px-4 py-2 text-sm font-bold rounded-full bg-blue-100 text-blue-800">Status: Diproses</span>
            @elseif($order->status_pesanan === 'Selesai')
                <span class="px-4 py-2 text-sm font-bold rounded-full bg-green-100 text-green-800">Status: Selesai</span>
            @else
                <span class="px-4 py-2 text-sm font-bold rounded-full bg-red-100 text-red-800">Status: Batal</span>
            @endif
        </div>
    </div>

    @if(session('success'))
        <div class="mb-6 bg-green-50 border-l-4 border-accent p-4 rounded text-sm text-green-800 shadow-sm">
            {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div class="mb-6 bg-red-50 border-l-4 border-red-500 p-4 rounded text-sm text-red-700 shadow-sm">
            {{ session('error') }}
        </div>
    @endif

    <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
        <!-- Main Order Details -->
        <div class="md:col-span-2 space-y-6">
            <div class="bg-white rounded-2xl shadow-sm border border-orange-100 p-6">
                <h3 class="text-sm font-bold text-gray-400 uppercase tracking-wider mb-4 pb-2 border-b border-gray-100">Mitra Catering & Waktu</h3>
                <div class="flex justify-between items-center text-sm">
                    <div>
                        <p class="text-xs text-gray-500">Catering Penyedia</p>
                        <p class="text-lg font-bold text-textcolor">{{ $order->catering->nama_catering ?? 'N/A' }}</p>
                    </div>
                    <div class="text-right">
                        <p class="text-xs text-gray-500">Waktu Pemesanan</p>
                        <p class="font-semibold text-textcolor">{{ date('d M Y, H:i', strtotime($order->tanggal_pesanan)) }}</p>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-2xl shadow-sm border border-orange-100 p-6">
                <h3 class="text-sm font-bold text-gray-400 uppercase tracking-wider mb-4 pb-2 border-b border-gray-100">Daftar Item Pesanan</h3>
                <div class="divide-y divide-gray-100">
                    @foreach($order->details as $detail)
                    <div class="py-3 flex justify-between items-center text-sm">
                        <div>
                            @if($detail->menu)
                                <span class="px-2 py-0.5 text-[10px] font-bold bg-blue-100 text-blue-800 rounded mr-2">MENU</span>
                                <span class="font-bold text-textcolor">{{ $detail->menu->nama_menu }}</span>
                            @elseif($detail->paket)
                                <span class="px-2 py-0.5 text-[10px] font-bold bg-purple-100 text-purple-800 rounded mr-2">PAKET</span>
                                <span class="font-bold text-textcolor">{{ $detail->paket->nama_paket }}</span>
                            @else
                                <span class="text-gray-400 font-italic">Item tidak tersedia</span>
                            @endif
                            <p class="text-xs text-gray-500 mt-0.5">{{ $detail->jumlah }} x subtotal</p>
                        </div>
                        <span class="font-bold text-textcolor">Rp {{ number_format($detail->subtotal, 0, ',', '.') }}</span>
                    </div>
                    @endforeach
                </div>

                <div class="mt-6 pt-4 border-t-2 border-orange-100 flex justify-between items-center">
                    <span class="text-base font-extrabold text-textcolor">Total Bayar</span>
                    <span class="text-2xl font-black text-primary">Rp {{ number_format($order->total_harga, 0, ',', '.') }}</span>
                </div>
            </div>
        </div>

        <!-- Sidebar: Payment Section -->
        <div class="md:col-span-1">
            <div class="bg-white rounded-2xl shadow-sm border border-orange-100 p-6 sticky top-6">
                <h3 class="text-base font-extrabold text-textcolor mb-4 pb-2 border-b border-gray-100">Status Pembayaran</h3>

                @if($order->pembayaran)
                    <div class="bg-green-50 border border-green-200 rounded-xl p-4 text-center">
                        <div class="w-12 h-12 bg-accent text-white rounded-full flex items-center justify-center mx-auto mb-3">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                            </svg>
                        </div>
                        <h4 class="font-bold text-green-900 text-base">Pembayaran Lunas</h4>
                        <p class="text-xs text-green-700 mt-1">Metode: <strong>{{ $order->pembayaran->metode_pembayaran }}</strong></p>
                        <p class="text-xs text-green-600 mt-0.5">Waktu: {{ date('d M Y, H:i', strtotime($order->pembayaran->tanggal_bayar)) }}</p>
                    </div>
                @else
                    <div class="bg-amber-50 border border-amber-200 rounded-xl p-4 mb-6">
                        <p class="text-xs text-amber-800 font-medium leading-relaxed">
                            Pesanan ini belum dibayar. Silakan pilih metode pembayaran dan konfirmasi pembayaran Anda di bawah ini.
                        </p>
                    </div>

                    <form action="{{ route('user.orders.pay', $order->id) }}" method="POST" class="space-y-4">
                        @csrf
                        <div>
                            <label class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-2">Metode Pembayaran</label>
                            <select name="metode_pembayaran" required class="w-full px-3 py-2 border border-gray-300 rounded-xl text-sm focus:ring-primary focus:border-primary font-medium">
                                <option value="Transfer Bank BCA">Transfer Bank BCA</option>
                                <option value="Transfer Bank Mandiri">Transfer Bank Mandiri</option>
                                <option value="QRIS / E-Wallet">QRIS / E-Wallet</option>
                                <option value="Cash on Delivery (COD)">Cash on Delivery (COD)</option>
                            </select>
                        </div>

                        <button type="submit" class="w-full bg-accent hover:bg-[#5a781d] text-white font-bold py-3 px-4 rounded-xl shadow-md transition text-sm flex items-center justify-center gap-2">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z" />
                            </svg>
                            Bayar Sekarang (Rp {{ number_format($order->total_harga, 0, ',', '.') }})
                        </button>
                    </form>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
