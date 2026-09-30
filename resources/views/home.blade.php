@extends('layouts.app')

@section('content')

<!-- Hero Section -->
<section class="py-12 lg:py-16">
    <div class="max-w-6xl mx-auto px-4 sm:px-6">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-10 items-center">

            <!-- Kiri: Teks + Search -->
            <div>
                <h1 class="text-4xl lg:text-5xl font-bold text-gray-900 leading-tight">
                    Temukan Catering Terbaik untuk Setiap Kebutuhan
                </h1>
                <p class="text-gray-600 mt-4 mb-8 leading-relaxed">
                    Pesan berbagai menu dan paket catering dari penyedia catering terpercaya dalam satu platform.
                </p>

                <!-- Search Bar -->
                <div class="flex gap-2 mb-10">
                    <div class="relative flex-1">
                        <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                            </svg>
                        </div>
                        <input type="text" placeholder="Cari catering atau menu favorit anda..."
                               class="w-full pl-12 pr-4 py-3 border border-gray-200 rounded-lg text-sm focus:outline-none focus:border-orange-500 transition" />
                    </div>
                    <button class="btn-primary px-6 py-3 rounded-lg text-sm font-semibold whitespace-nowrap">Cari Catering</button>
                </div>

                <!-- Statistik -->
                <div class="grid grid-cols-3 gap-6">
                    <div>
                        <span class="block text-2xl lg:text-3xl font-bold text-orange-500">1000+</span>
                        <span class="text-xs text-gray-500 uppercase tracking-wide">Banyak Pilihan Catering</span>
                    </div>
                    <div>
                        <span class="block text-2xl lg:text-3xl font-bold text-orange-500">50K+</span>
                        <span class="text-xs text-gray-500 uppercase tracking-wide">Menu Berkualitas</span>
                    </div>
                    <div>
                        <span class="block text-2xl lg:text-3xl font-bold text-orange-500">Mudah</span>
                        <span class="text-xs text-gray-500 uppercase tracking-wide">Pemesanan Mudah</span>
                    </div>
                </div>
            </div>

            <!-- Kanan: Gambar Hero -->
            <div class="relative">
                <div class="rounded-2xl overflow-hidden shadow-lg aspect-square lg:aspect-auto lg:h-[480px]">
                    <img src="https://images.unsplash.com/photo-1555244162-803834f70033?auto=format&fit=crop&w=800&q=80"
                         alt="Catering" class="w-full h-full object-cover">
                </div>
            </div>

        </div>
    </div>
</section>

<!-- Catering Pilihan Terbaik -->
<section id="caterings" class="py-12 lg:py-16 bg-gray-50">
    <div class="max-w-6xl mx-auto px-4 sm:px-6">

        <div class="text-center mb-10">
            <h2 class="text-2xl lg:text-3xl font-bold text-gray-900">Catering Pilihan Terbaik</h2>
            <p class="text-gray-500 mt-2">Temukan catering terpercaya dengan berbagai pilihan menu.</p>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
            @forelse($caterings ?? [] as $catering)
            <div class="card-catering bg-white rounded-xl overflow-hidden border border-gray-100 shadow-sm">

                <!-- Gambar Catering -->
                <div class="h-40 overflow-hidden">
                    <img src="https://images.unsplash.com/photo-1504674900247-0877df9cc836?auto=format&fit=crop&w=600&q=80"
                         alt="{{ $catering->nama_catering }}" class="w-full h-full object-cover">
                </div>

                <div class="p-4">
                    <div class="flex items-start justify-between mb-1">
                        <h3 class="font-bold text-gray-900 truncate">{{ $catering->nama_catering }}</h3>
                        <span class="bg-gray-800 text-white px-2.5 py-1 rounded-md text-xs font-semibold whitespace-nowrap">★ 4.9</span>
                    </div>
                    <p class="text-xs text-gray-500 mb-1">{{ $catering->created_at->format('d F') }}</p>
                    <p class="text-sm text-gray-600 mb-4 line-clamp-2">
                        {{ $catering->deskripsi ?? 'Catering terpercaya dengan menu lezat dan bergizi.' }}
                    </p>
                    <a href="{{ route('catering.show', $catering->id) }}"
                       class="block w-full text-center border border-gray-300 text-sm font-medium py-2 rounded-lg hover:bg-orange-500 hover:text-white hover:border-orange-500 transition">
                        Lihat Catering
                    </a>
                </div>
            </div>
            @empty
            <div class="col-span-full text-center py-10 bg-white rounded-xl shadow-sm border border-gray-100">
                <svg class="mx-auto h-12 w-12 text-gray-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4" />
                </svg>
                <h3 class="mt-2 text-sm font-medium text-gray-900">Belum ada mitra catering</h3>
                <p class="mt-1 text-sm text-gray-500">Silakan kembali lagi nanti saat admin sudah menambahkan catering.</p>
            </div>
            @endforelse
        </div>
    </div>
</section>

@endsection