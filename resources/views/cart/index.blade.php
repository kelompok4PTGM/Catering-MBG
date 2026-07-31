@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <div class="flex items-center justify-between mb-8">
        <div>
            <h1 class="text-3xl font-extrabold text-textcolor">Keranjang Belanja</h1>
            <p class="text-sm text-gray-500 mt-1">Periksa menu pesanan Anda sebelum melakukan checkout.</p>
        </div>
        @if(!empty($cart))
        <form action="{{ route('cart.clear') }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin mengosongkan keranjang?')">
            @csrf
            <button type="submit" class="text-sm text-red-600 hover:text-red-800 font-semibold transition">
                Kosongkan Keranjang
            </button>
        </form>
        @endif
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

    @if(!empty($cart) && count($cart) > 0)
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <!-- Cart Items List -->
        <div class="lg:col-span-2 space-y-4">
            @if($catering)
            <div class="bg-amber-50 border border-amber-200 rounded-xl p-4 flex items-center justify-between">
                <div class="flex items-center gap-3">
                    <div class="bg-primary text-white p-2 rounded-lg">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                        </svg>
                    </div>
                    <div>
                        <span class="text-xs font-semibold text-gray-500 uppercase tracking-wider">Mitra Catering</span>
                        <h3 class="font-bold text-textcolor">{{ $catering->nama_catering }}</h3>
                    </div>
                </div>
                <a href="{{ route('catering.show', $catering->id) }}" class="text-xs font-bold text-primary hover:underline">
                    + Tambah Menu Lain
                </a>
            </div>
            @endif

            <div class="bg-white rounded-xl shadow-sm border border-orange-100 overflow-hidden divide-y divide-gray-100">
                @foreach($cart as $key => $item)
                <div class="p-6 flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                    <div class="flex-1">
                        <div class="flex items-center gap-2 mb-1">
                            <span class="px-2 py-0.5 text-[10px] font-extrabold tracking-wider uppercase rounded {{ $item['type'] === 'paket' ? 'bg-purple-100 text-purple-800' : 'bg-blue-100 text-blue-800' }}">
                                {{ $item['type'] }}
                            </span>
                        </div>
                        <h4 class="text-base font-bold text-textcolor">{{ $item['nama'] }}</h4>
                        <p class="text-sm font-semibold text-primary">Rp {{ number_format($item['harga'], 0, ',', '.') }} / porsi</p>
                    </div>

                    <!-- Quantity Form & Subtotal -->
                    <div class="flex items-center justify-between sm:justify-end gap-6">
                        <form action="{{ route('cart.update') }}" method="POST" class="flex items-center gap-2">
                            @csrf
                            <input type="hidden" name="key" value="{{ $key }}">
                            <input type="number" name="jumlah" value="{{ $item['jumlah'] }}" min="1" class="w-16 px-2 py-1 border border-gray-300 rounded text-center text-sm font-bold focus:ring-primary focus:border-primary">
                            <button type="submit" class="text-xs bg-gray-100 hover:bg-gray-200 text-gray-700 px-2 py-1 rounded font-medium transition">
                                Ubah
                            </button>
                        </form>

                        <div class="text-right">
                            <p class="text-sm font-extrabold text-textcolor">Rp {{ number_format($item['harga'] * $item['jumlah'], 0, ',', '.') }}</p>
                            <form action="{{ route('cart.remove', $key) }}" method="POST" class="inline-block mt-1">
                                @csrf
                                <button type="submit" class="text-xs text-red-500 hover:underline">Hapus</button>
                            </form>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>

        <!-- Summary -->
        <div class="lg:col-span-1">
            <div class="bg-white rounded-xl shadow-sm border border-orange-100 p-6 sticky top-6">
                <h3 class="text-lg font-bold text-textcolor mb-4 pb-3 border-b border-gray-100">Ringkasan Pesanan</h3>
                
                <div class="space-y-3 mb-6">
                    <div class="flex justify-between text-sm text-gray-600">
                        <span>Total Item</span>
                        <span class="font-medium text-textcolor">{{ count($cart) }} macam</span>
                    </div>
                    <div class="flex justify-between text-base font-extrabold text-textcolor pt-3 border-t border-gray-100">
                        <span>Total Harga</span>
                        <span class="text-primary text-xl">Rp {{ number_format($total, 0, ',', '.') }}</span>
                    </div>
                </div>

                @auth
                    @if(Auth::user()->role === 'User')
                    <a href="{{ route('checkout') }}" class="w-full bg-accent hover:bg-[#5a781d] text-white font-bold py-3 px-4 rounded-xl text-center shadow transition block">
                        Lanjut ke Checkout &rarr;
                    </a>
                    @else
                    <div class="bg-amber-50 p-3 rounded-lg text-xs text-amber-800 text-center font-medium">
                        Anda masuk sebagai {{ Auth::user()->role }}. Login sebagai pembeli untuk checkout.
                    </div>
                    @endif
                @else
                    <a href="{{ route('login') }}" class="w-full bg-primary hover:bg-amber-600 text-white font-bold py-3 px-4 rounded-xl text-center shadow transition block">
                        Login untuk Checkout
                    </a>
                @endauth
            </div>
        </div>
    </div>
    @else
    <div class="bg-white rounded-2xl p-12 text-center border border-orange-100 shadow-sm">
        <svg class="mx-auto h-16 w-16 text-gray-300 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 100 4 2 2 0 000-4z"></path>
        </svg>
        <h3 class="text-lg font-bold text-textcolor">Keranjang Anda Masih Kosong</h3>
        <p class="text-sm text-gray-500 mt-1 mb-6">Jelajahi menu sehat & bergizi dari mitra catering kami.</p>
        <a href="{{ route('home') }}" class="inline-flex items-center px-6 py-3 bg-primary text-white font-bold text-sm rounded-xl hover:bg-amber-600 transition shadow">
            Cari Menu Catering
        </a>
    </div>
    @endif
</div>
@endsection
