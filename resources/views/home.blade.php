@extends('layouts.app')

@section('content')

<!-- Hero Section -->
<section class="py-12 lg:py-16 overflow-hidden">
    <div class="max-w-6xl mx-auto px-4 sm:px-6">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-10 items-center">

            <!-- Kiri: Teks + Search -->
            <div class="reveal-on-scroll">
                <span class="inline-flex items-center gap-1.5 px-3.5 py-1 rounded-full text-xs font-bold bg-orange-50 text-orange-600 border border-orange-200/60 mb-4 shadow-2xs">
                    <span class="w-2 h-2 rounded-full bg-orange-500 animate-pulse"></span> Platform Catering MBG #1
                </span>
                <h1 class="text-4xl lg:text-5xl font-extrabold text-gray-900 leading-tight tracking-tight">
                    Temukan Catering Terbaik untuk Setiap Kebutuhan
                </h1>
                <p class="text-gray-600 mt-4 mb-8 leading-relaxed text-base sm:text-lg">
                    Pesan berbagai menu dan paket catering dari penyedia catering terpercaya dalam satu platform yang higienis, lezat, dan bergizi.
                </p>

                <!-- Search Bar -->
                <div class="flex gap-2 mb-10 reveal-on-scroll delay-100">
                    <div class="relative flex-1 group">
                        <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none text-gray-400 group-focus-within:text-orange-500 transition-colors">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                            </svg>
                        </div>
                        <input type="text" placeholder="Cari catering atau menu favorit anda..."
                               class="w-full pl-12 pr-4 py-3.5 border border-gray-200 rounded-xl text-sm focus:outline-none focus:border-orange-500 focus:ring-2 focus:ring-orange-100 transition shadow-xs" />
                    </div>
                    <a href="#caterings" class="btn-primary btn-press px-6 py-3.5 rounded-xl text-sm font-bold whitespace-nowrap inline-flex items-center justify-center shadow-md">
                        Cari Catering
                    </a>
                </div>

                <!-- Statistik -->
                <div class="grid grid-cols-3 gap-4 sm:gap-6 reveal-on-scroll delay-200">
                    <div class="p-3 bg-orange-50/50 rounded-xl border border-orange-100/60 transition hover:bg-orange-50">
                        <span class="block text-2xl lg:text-3xl font-extrabold text-orange-500">1000+</span>
                        <span class="text-xs text-gray-600 font-medium tracking-wide">Pilihan Menu</span>
                    </div>
                    <div class="p-3 bg-orange-50/50 rounded-xl border border-orange-100/60 transition hover:bg-orange-50">
                        <span class="block text-2xl lg:text-3xl font-extrabold text-orange-500">50K+</span>
                        <span class="text-xs text-gray-600 font-medium tracking-wide">Porsi Terkirim</span>
                    </div>
                    <div class="p-3 bg-orange-50/50 rounded-xl border border-orange-100/60 transition hover:bg-orange-50">
                        <span class="block text-2xl lg:text-3xl font-extrabold text-orange-500">100%</span>
                        <span class="text-xs text-gray-600 font-medium tracking-wide">Higienis & Bergizi</span>
                    </div>
                </div>
            </div>

            <!-- Kanan: Gambar Hero -->
            <div class="relative reveal-on-scroll delay-300">
                <div class="rounded-3xl overflow-hidden shadow-2xl aspect-square lg:aspect-auto lg:h-[480px] border-4 border-white group">
                    <img src="https://images.unsplash.com/photo-1555244162-803834f70033?auto=format&fit=crop&w=800&q=80"
                         alt="Catering" class="w-full h-full object-cover transform group-hover:scale-105 transition-transform duration-700 ease-out">
                </div>
                <div class="absolute -bottom-4 -left-4 bg-white/95 backdrop-blur-md p-4 rounded-2xl shadow-xl border border-orange-100 hidden sm:flex items-center gap-3">
                    <div class="w-10 h-10 rounded-xl bg-orange-100 text-orange-600 flex items-center justify-center text-lg">
                        <i class="fas fa-check-circle"></i>
                    </div>
                    <div>
                        <p class="text-xs text-gray-500 font-medium">Kualitas Terjamin</p>
                        <p class="text-sm font-bold text-gray-800">Sertifikasi Bergizi</p>
                    </div>
                </div>
            </div>

        </div>
    </div>
</section>

<!-- Catering Pilihan Terbaik -->
<section id="caterings" class="py-12 lg:py-20 bg-gray-50/80">
    <div class="max-w-6xl mx-auto px-4 sm:px-6">

        <div class="text-center mb-12 reveal-on-scroll">
            <span class="text-xs font-bold text-orange-500 tracking-wider uppercase bg-orange-50 px-3 py-1 rounded-full border border-orange-100">
                Mitra Terpercaya
            </span>
            <h2 class="text-2xl lg:text-3xl font-extrabold text-gray-900 mt-2">Catering Pilihan Terbaik</h2>
            <p class="text-gray-500 mt-2 max-w-lg mx-auto text-sm sm:text-base">Temukan mitra catering terpercaya dengan pilihan paket lezat, higienis, dan harga bersahabat.</p>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
            @forelse($caterings ?? [] as $catering)
            <div class="card-interactive reveal-on-scroll delay-{{ (($loop->iteration - 1) % 4) * 100 + 100 }} bg-white rounded-2xl overflow-hidden border border-gray-100 shadow-sm flex flex-col justify-between group">

                <div>
                    <!-- Gambar Catering -->
                    <div class="h-44 overflow-hidden bg-gray-100 relative">
                        <img src="{{ $catering->foto ? asset('storage/' . $catering->foto) : 'https://images.unsplash.com/photo-1504674900247-0877df9cc836?auto=format&fit=crop&w=600&q=80' }}"
                             alt="{{ $catering->nama_catering }}" class="img-zoom w-full h-full object-cover">
                        <span class="absolute top-2.5 right-2.5 bg-white/90 backdrop-blur-sm text-gray-800 text-[11px] font-bold px-2 py-0.5 rounded-md shadow-xs">
                            {{ $catering->status }}
                        </span>
                    </div>

                    <div class="p-5">
                        <div class="flex items-start justify-between gap-2 mb-1.5">
                            <h3 class="font-bold text-gray-900 truncate group-hover:text-orange-500 transition-colors">{{ $catering->nama_catering }}</h3>
                            @if($catering->total_ulasan > 0)
                                <span class="bg-amber-50 text-amber-900 border border-amber-200 px-2 py-0.5 rounded-md text-xs font-bold whitespace-nowrap shadow-2xs flex items-center gap-1" title="{{ $catering->total_ulasan }} ulasan">
                                    <i class="fas fa-star text-amber-500 text-[10px]"></i> {{ $catering->average_rating }}
                                </span>
                            @else
                                <span class="bg-gray-100 text-gray-500 px-2 py-0.5 rounded-md text-xs font-medium whitespace-nowrap">
                                    Baru
                                </span>
                            @endif
                        </div>
                        <p class="text-xs text-gray-400 mb-2 flex items-center gap-1">
                            <i class="far fa-calendar-alt text-[10px]"></i> {{ !empty($catering->created_at) ? \Carbon\Carbon::parse($catering->created_at)->format('d M Y') : 'Terbaru' }}
                        </p>
                        <p class="text-sm text-gray-600 line-clamp-2 leading-relaxed">
                            {{ $catering->deskripsi ?? 'Catering terpercaya dengan menu lezat dan bergizi.' }}
                        </p>
                    </div>
                </div>

                <div class="p-5 pt-0">
                    <a href="{{ route('catering.show', $catering->id) }}"
                       class="btn-press block w-full text-center border-2 border-orange-500 text-orange-500 text-sm font-bold py-2.5 rounded-xl hover:bg-orange-500 hover:text-white transition shadow-2xs">
                        Lihat Catering & Menu &rarr;
                    </a>
                </div>
            </div>
            @empty
            <div class="col-span-full text-center py-12 bg-white rounded-2xl shadow-sm border border-gray-100 p-8 reveal-on-scroll">
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

<!-- Section Testimoni -->
<section id="testimoni" class="py-12 lg:py-20 bg-white border-t border-gray-100">
    <div class="max-w-6xl mx-auto px-4 sm:px-6">
        <div class="text-center mb-12 reveal-on-scroll">
            <span class="text-xs font-bold text-orange-500 tracking-wider uppercase bg-orange-50 px-3 py-1 rounded-full border border-orange-100">
                Ulasan Nyata
            </span>
            <h2 class="text-2xl lg:text-3xl font-extrabold text-gray-900 mt-2">Testimoni Pelanggan</h2>
            <p class="text-gray-500 mt-2 max-w-lg mx-auto text-sm sm:text-base">Apa kata pengguna tentang layanan pemesanan Catering MBG.</p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <div class="card-interactive reveal-on-scroll delay-100 p-6 bg-gray-50/70 rounded-2xl border border-gray-100 hover:bg-white transition flex flex-col justify-between">
                <div>
                    <div class="flex items-center gap-1 text-amber-400 text-sm mb-3">
                        <i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i>
                    </div>
                    <p class="text-sm text-gray-600 mb-6 italic leading-relaxed">"Makanan sangat lezat, pengiriman tepat waktu untuk acara sekolah. Pilihan menu bergizi dan sehat!"</p>
                </div>
                <div class="flex items-center gap-3 pt-4 border-t border-gray-100">
                    <div class="w-9 h-9 rounded-full bg-orange-100 text-orange-600 font-bold flex items-center justify-center text-xs">AF</div>
                    <div>
                        <div class="font-bold text-gray-900 text-sm">Ahmad Fauzi</div>
                        <div class="text-xs text-gray-400">Koordinator Sekolah</div>
                    </div>
                </div>
            </div>

            <div class="card-interactive reveal-on-scroll delay-200 p-6 bg-gray-50/70 rounded-2xl border border-gray-100 hover:bg-white transition flex flex-col justify-between">
                <div>
                    <div class="flex items-center gap-1 text-amber-400 text-sm mb-3">
                        <i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i>
                    </div>
                    <p class="text-sm text-gray-600 mb-6 italic leading-relaxed">"Sangat terbantu dengan aplikasi ini. Cari mitra catering cepat dan pilihannya berkualitas tinggi."</p>
                </div>
                <div class="flex items-center gap-3 pt-4 border-t border-gray-100">
                    <div class="w-9 h-9 rounded-full bg-orange-100 text-orange-600 font-bold flex items-center justify-center text-xs">SR</div>
                    <div>
                        <div class="font-bold text-gray-900 text-sm">Siti Rahma</div>
                        <div class="text-xs text-gray-400">Orang Tua Murid</div>
                    </div>
                </div>
            </div>

            <div class="card-interactive reveal-on-scroll delay-300 p-6 bg-gray-50/70 rounded-2xl border border-gray-100 hover:bg-white transition flex flex-col justify-between">
                <div>
                    <div class="flex items-center gap-1 text-amber-400 text-sm mb-3">
                        <i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i>
                    </div>
                    <p class="text-sm text-gray-600 mb-6 italic leading-relaxed">"Paket MBG Bunda Fadil porsi pas, kemasan higienis, dan rasa bintang lima!"</p>
                </div>
                <div class="flex items-center gap-3 pt-4 border-t border-gray-100">
                    <div class="w-9 h-9 rounded-full bg-orange-100 text-orange-600 font-bold flex items-center justify-center text-xs">BS</div>
                    <div>
                        <div class="font-bold text-gray-900 text-sm">Budi Santoso</div>
                        <div class="text-xs text-gray-400">Pengelola Program</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

@endsection