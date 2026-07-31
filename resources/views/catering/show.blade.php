@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <!-- Catering Header -->
    <div class="bg-white rounded-2xl shadow-sm border border-orange-100 p-8 mb-8">
        <div class="flex flex-col md:flex-row items-start md:items-center justify-between gap-4">
            <div>
                <div class="flex items-center gap-3">
                    <h1 class="text-3xl font-extrabold text-textcolor">{{ $catering->nama_catering }}</h1>
                    <span class="px-3 py-1 text-xs font-semibold rounded-full bg-green-100 text-green-800">
                        {{ $catering->status }}
                    </span>
                </div>
                <p class="mt-2 text-gray-600 max-w-2xl">{{ $catering->deskripsi ?? 'Pilihan catering makanan lezat & bergizi.' }}</p>
            </div>
            <a href="{{ route('home') }}" class="inline-flex items-center text-sm font-semibold text-primary hover:text-amber-700">
                &larr; Kembali ke Beranda
            </a>
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

    <!-- Menu & Paket Sections -->
    <div class="space-y-12">
        <!-- Section Menu Standar -->
        <div>
            <div class="border-b border-amber-200 pb-3 mb-6 flex justify-between items-center">
                <h2 class="text-2xl font-bold text-textcolor">Daftar Menu</h2>
                <span class="text-sm text-gray-500">{{ $catering->menus->count() }} item tersedia</span>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @forelse($catering->menus as $menu)
                <div class="bg-white rounded-xl shadow-sm border border-orange-100 overflow-hidden hover:shadow-md transition">
                    <div class="p-6">
                        <div class="flex justify-between items-start mb-2">
                            <span class="text-xs font-semibold text-amber-600 bg-amber-50 px-2 py-0.5 rounded">Kode: {{ $menu->kode_menu }}</span>
                            <span class="text-xs font-medium text-gray-500">Stok: {{ $menu->stok }}</span>
                        </div>
                        <h3 class="text-lg font-bold text-textcolor mb-1">{{ $menu->nama_menu }}</h3>
                        <p class="text-2xl font-black text-primary mb-4">
                            Rp {{ number_format($menu->harga, 0, ',', '.') }}
                        </p>

                        <form action="{{ route('cart.add') }}" method="POST">
                            @csrf
                            <input type="hidden" name="type" value="menu">
                            <input type="hidden" name="id" value="{{ $menu->id }}">
                            <div class="flex items-center gap-2">
                                <input type="number" name="jumlah" value="1" min="1" max="{{ $menu->stok }}" class="w-20 px-3 py-2 border border-gray-300 rounded-lg text-center text-sm focus:ring-primary focus:border-primary">
                                <button type="submit" class="flex-1 bg-primary hover:bg-amber-600 text-white font-bold py-2 px-4 rounded-lg text-sm transition shadow-sm flex items-center justify-center gap-1" {{ $menu->stok <= 0 ? 'disabled' : '' }}>
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                                    </svg>
                                    + Keranjang
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
                @empty
                <div class="col-span-full py-8 text-center bg-white rounded-xl border border-dashed border-gray-300">
                    <p class="text-gray-500">Belum ada menu yang ditambahkan oleh catering ini.</p>
                </div>
                @endforelse
            </div>
        </div>

        <!-- Section Paket Hemat/Khusus -->
        <div>
            <div class="border-b border-amber-200 pb-3 mb-6 flex justify-between items-center">
                <h2 class="text-2xl font-bold text-textcolor">Daftar Paket Catering</h2>
                <span class="text-sm text-gray-500">{{ $catering->pakets->count() }} paket tersedia</span>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @forelse($catering->pakets as $paket)
                <div class="bg-white rounded-xl shadow-sm border border-amber-200 overflow-hidden hover:shadow-md transition">
                    <div class="bg-amber-50 px-6 py-3 border-b border-amber-100 flex justify-between items-center">
                        <span class="text-xs font-bold text-primary tracking-wider uppercase">Paket Spesial</span>
                        <span class="text-xs text-gray-500">{{ $paket->menus->count() }} Variasi Menu</span>
                    </div>
                    <div class="p-6">
                        <h3 class="text-xl font-bold text-textcolor mb-2">{{ $paket->nama_paket }}</h3>
                        
                        <!-- List of menus inside packet -->
                        <div class="mb-4 bg-orange-50/50 p-3 rounded-lg border border-orange-100">
                            <p class="text-xs font-semibold text-gray-600 mb-1">Isi Paket:</p>
                            <ul class="text-xs text-gray-700 space-y-1">
                                @forelse($paket->menus as $pm)
                                    <li class="flex items-center gap-1">
                                        <span class="text-accent">•</span> {{ $pm->nama_menu }}
                                    </li>
                                @empty
                                    <li class="text-gray-400 italic">Menu paket belum diatur</li>
                                @endforelse
                            </ul>
                        </div>

                        <p class="text-2xl font-black text-primary mb-4">
                            Rp {{ number_format($paket->harga, 0, ',', '.') }}
                        </p>

                        <form action="{{ route('cart.add') }}" method="POST">
                            @csrf
                            <input type="hidden" name="type" value="paket">
                            <input type="hidden" name="id" value="{{ $paket->id }}">
                            <div class="flex items-center gap-2">
                                <input type="number" name="jumlah" value="1" min="1" class="w-20 px-3 py-2 border border-gray-300 rounded-lg text-center text-sm focus:ring-primary focus:border-primary">
                                <button type="submit" class="flex-1 bg-accent hover:bg-[#5a781d] text-white font-bold py-2 px-4 rounded-lg text-sm transition shadow-sm flex items-center justify-center gap-1">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                                    </svg>
                                    + Keranjang Paket
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
                @empty
                <div class="col-span-full py-8 text-center bg-white rounded-xl border border-dashed border-gray-300">
                    <p class="text-gray-500">Belum ada paket yang dibuat oleh catering ini.</p>
                </div>
                @endforelse
            </div>
        </div>
    </div>
</div>
@endsection
