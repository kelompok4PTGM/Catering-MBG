@extends('layouts.app')

@section('content')

<!-- Hero -->
<section class="py-10 lg:py-14 border-b border-gray-100">
    <div class="max-w-6xl mx-auto px-4 sm:px-6">
        <h1 class="text-4xl lg:text-6xl font-black text-gray-900 leading-none tracking-tight">
            TEMUKAN<br>CATERING<br>FAVORIT ANDA
        </h1>
    </div>
</section>

<!-- Filter Bar -->
<section class="border-b border-gray-100 py-4">
    <div class="max-w-6xl mx-auto px-4 sm:px-6">
        <div class="flex flex-wrap items-center gap-3">
            <div class="relative flex-1 min-w-[200px]">
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                    </svg>
                </div>
                <input type="text" placeholder="Cari catering, menu, atau anda..."
                       class="w-full pl-9 pr-3 py-2.5 border border-gray-200 rounded-lg text-sm focus:outline-none focus:border-orange-500 transition">
            </div>

            <select class="border border-gray-200 rounded-lg px-3 py-2.5 text-sm bg-white focus:outline-none focus:border-orange-500">
                <option>Kategori</option>
                <option>Nasi Kotak</option>
                <option>Prasmanan</option>
                <option>Snack Box</option>
            </select>

            <select class="border border-gray-200 rounded-lg px-3 py-2.5 text-sm bg-white focus:outline-none focus:border-orange-500">
                <option>Lokasi</option>
                <option>Jakarta</option>
                <option>Bandung</option>
                <option>Surabaya</option>
            </select>

            <select class="border border-gray-200 rounded-lg px-3 py-2.5 text-sm bg-white focus:outline-none focus:border-orange-500">
                <option>Rating</option>
                <option>4.5+</option>
                <option>4.0+</option>
                <option>3.5+</option>
            </select>

            <select class="border border-gray-200 rounded-lg px-3 py-2.5 text-sm bg-white focus:outline-none focus:border-orange-500">
                <option>Harga</option>
                <option>&lt; Rp 25.000</option>
                <option>Rp 25.000 - 50.000</option>
                <option>&gt; Rp 50.000</option>
            </select>

            <button class="bg-gray-100 hover:bg-gray-200 text-gray-700 px-4 py-2.5 rounded-lg text-sm font-medium transition">
                Urut Terpopuler
            </button>
        </div>
    </div>
</section>

<!-- Produk Grid -->
<section class="py-8">
    <div class="max-w-6xl mx-auto px-4 sm:px-6">

        @if(isset($caterings) && count($caterings) > 0)
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-5">
                @foreach($caterings as $catering)
                <div class="card-interactive reveal-on-scroll delay-{{ (($loop->iteration - 1) % 3) * 100 + 100 }} bg-white rounded-2xl overflow-hidden border border-gray-100 shadow-sm flex flex-col justify-between group">
                    <div>
                        <div class="h-44 overflow-hidden relative bg-gray-100">
                            <img src="{{ $catering->foto ? asset('storage/' . $catering->foto) : 'https://images.unsplash.com/photo-1504674900247-0877df9cc836?auto=format&fit=crop&w=600&q=80' }}"
                                 alt="{{ $catering->nama_catering }}" class="img-zoom w-full h-full object-cover">
                            @if($loop->first)
                                <span class="absolute top-3 left-3 bg-orange-500 text-white text-xs font-bold px-2.5 py-1 rounded shadow-xs">TERLARIS</span>
                            @elseif($loop->iteration == 5)
                                <span class="absolute top-3 left-3 bg-green-500 text-white text-xs font-bold px-2.5 py-1 rounded shadow-xs">VEGAN FRIENDLY</span>
                            @endif
                        </div>
                        <div class="p-4">
                            <div class="flex items-start justify-between mb-1">
                                <h3 class="font-bold text-gray-900 group-hover:text-orange-500 transition-colors">{{ $catering->nama_catering }}</h3>
                                @if($catering->total_ulasan > 0)
                                    <span class="bg-amber-500 text-white px-2 py-0.5 rounded text-xs font-bold whitespace-nowrap shadow-xs flex items-center gap-1" title="{{ $catering->total_ulasan }} ulasan">
                                        <i class="fas fa-star text-[10px]"></i> {{ $catering->average_rating }}
                                    </span>
                                @else
                                    <span class="bg-gray-100 text-gray-500 px-2 py-0.5 rounded text-xs font-medium whitespace-nowrap">
                                        Baru
                                    </span>
                                @endif
                            </div>
                            <p class="text-xs text-gray-500 mb-2">
                                <i class="fas fa-map-marker-alt mr-1"></i>{{ $catering->lokasi ?? 'Jakarta' }}
                            </p>
                            <p class="text-sm text-gray-600 mb-3 line-clamp-2">
                                {{ $catering->deskripsi ?? 'Catering terpercaya dengan menu lezat dan bergizi.' }}
                            </p>
                        </div>
                    </div>
                    @php
                        $minMenu = $catering->menus ? $catering->menus->min('harga') : null;
                        $minPaket = $catering->pakets ? $catering->pakets->min('harga') : null;
                        $prices = array_filter([$minMenu, $minPaket]);
                        $minHarga = !empty($prices) ? min($prices) : 0;
                    @endphp
                    <div class="p-4 pt-0 flex items-center justify-between">
                        <div>
                            <p class="text-xs text-gray-500">Mulai dari</p>
                            <p class="font-bold text-gray-900">
                                @if($minHarga > 0)
                                    Rp {{ number_format($minHarga, 0, ',', '.') }}
                                @else
                                    -
                                @endif
                                <span class="text-xs font-normal text-gray-500">/pax</span>
                            </p>
                        </div>
                        <a href="{{ route('catering.show', $catering->id) }}"
                           class="btn-press bg-orange-500 hover:bg-orange-600 text-white text-sm font-semibold px-4 py-2 rounded-xl transition shadow-xs">
                            Lihat
                        </a>
                    </div>
                </div>
                @endforeach
            </div>
        @else
            <!-- Kalau belum ada data: 6 slot kosong -->
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-5">
                @for($i = 1; $i <= 6; $i++)
                <div class="bg-white rounded-xl overflow-hidden border border-dashed border-gray-200">
                    <div class="h-44 bg-gray-50 flex items-center justify-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-12 h-12 text-gray-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                        </svg>
                    </div>
                    <div class="p-4">
                        <div class="h-4 bg-gray-100 rounded w-3/4 mb-2"></div>
                        <div class="h-3 bg-gray-100 rounded w-1/2 mb-3"></div>
                        <div class="h-3 bg-gray-100 rounded w-full mb-1"></div>
                        <div class="h-3 bg-gray-100 rounded w-2/3 mb-4"></div>
                        <div class="flex items-center justify-between">
                            <div class="h-4 bg-gray-100 rounded w-20"></div>
                            <div class="h-8 bg-gray-100 rounded w-16"></div>
                        </div>
                    </div>
                </div>
                @endfor
            </div>

            <div class="text-center mt-8">
                <p class="text-sm text-gray-400">
                    <i class="fas fa-info-circle mr-1"></i>
                    Belum ada mitra catering. Silakan kembali lagi nanti.
                </p>
            </div>
        @endif

    </div>
</section>

@endsection