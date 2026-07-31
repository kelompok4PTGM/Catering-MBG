@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <div class="mb-8">
        <a href="{{ route('cart.index') }}" class="text-sm font-semibold text-primary hover:underline">&larr; Kembali ke Keranjang</a>
        <h1 class="text-3xl font-extrabold text-textcolor mt-2">Konfirmasi Checkout</h1>
        <p class="text-sm text-gray-500">Periksa rincian pesanan sebelum menyelesaikan pesanan Anda.</p>
    </div>

    @if(session('error'))
        <div class="mb-6 bg-red-50 border-l-4 border-red-500 p-4 rounded text-sm text-red-700 shadow-sm">
            {{ session('error') }}
        </div>
    @endif

    <div class="bg-white rounded-2xl shadow-sm border border-orange-100 p-6 md:p-8 space-y-6">
        <!-- Info Catering -->
        <div class="border-b border-gray-100 pb-4">
            <h3 class="text-xs font-bold text-gray-400 uppercase tracking-wider">Mitra Catering Penyedia</h3>
            <p class="text-xl font-extrabold text-textcolor mt-1">{{ $catering->nama_catering }}</p>
        </div>

        <!-- Detail Pemesan -->
        <div class="border-b border-gray-100 pb-4">
            <h3 class="text-xs font-bold text-gray-400 uppercase tracking-wider mb-2">Informasi Pemesan</h3>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-sm">
                <div>
                    <span class="text-gray-500">Nama Pembeli:</span>
                    <span class="font-semibold text-textcolor ml-2">{{ Auth::user()->username }}</span>
                </div>
                <div>
                    <span class="text-gray-500">Email:</span>
                    <span class="font-semibold text-textcolor ml-2">{{ Auth::user()->email }}</span>
                </div>
            </div>
        </div>

        <!-- Rincian Item -->
        <div>
            <h3 class="text-xs font-bold text-gray-400 uppercase tracking-wider mb-3">Rincian Item Pesanan</h3>
            <div class="divide-y divide-gray-100">
                @foreach($cart as $item)
                <div class="py-3 flex justify-between items-center text-sm">
                    <div>
                        <span class="font-bold text-textcolor">{{ $item['nama'] }}</span>
                        <span class="text-gray-500 text-xs ml-2">({{ $item['jumlah'] }} x Rp {{ number_format($item['harga'], 0, ',', '.') }})</span>
                    </div>
                    <span class="font-bold text-textcolor">Rp {{ number_format($item['harga'] * $item['jumlah'], 0, ',', '.') }}</span>
                </div>
                @endforeach
            </div>

            <div class="mt-6 pt-4 border-t-2 border-orange-100 flex justify-between items-center">
                <span class="text-base font-extrabold text-textcolor">Total Tagihan</span>
                <span class="text-2xl font-black text-primary">Rp {{ number_format($total, 0, ',', '.') }}</span>
            </div>
        </div>

        <!-- Checkout Action Form -->
        <form action="{{ route('checkout.store') }}" method="POST" class="pt-4">
            @csrf
            <div class="bg-amber-50 rounded-xl p-4 mb-6 border border-amber-200 text-xs text-amber-800">
                <p class="font-bold mb-1">Catatan Penting:</p>
                <p>Setelah menekan tombol "Buat Pesanan Sekarang", pesanan Anda akan dicatat dengan status <strong>Pending</strong>. Anda dapat melakukan pembayaran di halaman rincian pesanan.</p>
            </div>

            <button type="submit" class="w-full bg-accent hover:bg-[#5a781d] text-white font-bold py-4 rounded-xl shadow-md transition text-base">
                Buat Pesanan Sekarang &rarr;
            </button>
        </form>
    </div>
</div>
@endsection
