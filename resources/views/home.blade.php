@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
    <!-- Hero Section -->
    <div class="text-center mb-16 bg-white p-10 rounded-2xl shadow-sm border border-orange-100">
        <h1 class="text-4xl font-extrabold text-primary sm:text-5xl md:text-6xl mb-4">
            Catering MBG
        </h1>
        <p class="mt-3 max-w-md mx-auto text-base text-textcolor sm:text-lg md:mt-5 md:text-xl md:max-w-3xl">
            Pesan menu sehat dan bergizi dari berbagai mitra catering terbaik kami. Mudah, cepat, dan terpercaya.
        </p>
        <div class="mt-5 max-w-md mx-auto sm:flex sm:justify-center md:mt-8">
            <div class="rounded-md shadow">
                <a href="#caterings" class="w-full flex items-center justify-center px-8 py-3 border border-transparent text-base font-medium rounded-md text-white bg-accent hover:bg-[#5a781d] md:py-4 md:text-lg md:px-10 transition">
                    Lihat Mitra Catering
                </a>
            </div>
        </div>
    </div>

    <!-- Caterings List -->
    <h2 id="caterings" class="text-3xl font-extrabold text-textcolor mb-8 text-center">Mitra Catering Kami</h2>
    
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
        @forelse($caterings ?? [] as $catering)
        <div class="bg-white rounded-xl shadow-md overflow-hidden hover:shadow-lg transition transform hover:-translate-y-1 border border-gray-100">
            <div class="h-48 bg-secondary flex items-center justify-center border-b border-orange-50">
                <svg class="h-24 w-24 text-primary opacity-50" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                </svg>
            </div>
            <div class="p-6">
                <h3 class="text-xl font-bold text-textcolor mb-2">{{ $catering->nama_catering }}</h3>
                <p class="text-sm text-gray-500 mb-4 line-clamp-2">{{ $catering->deskripsi ?? 'Catering terpercaya dengan menu lezat dan bergizi.' }}</p>
                <div class="flex justify-between items-center">
                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                        {{ $catering->status }}
                    </span>
                    <a href="{{ route('catering.show', $catering->id) }}" class="text-primary hover:text-amber-700 font-bold text-sm transition flex items-center gap-1">
                        Lihat Menu & Paket &rarr;
                    </a>
                </div>
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
@endsection
