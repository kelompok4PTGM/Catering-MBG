@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <!-- Catering Header -->
    <div class="bg-white rounded-2xl shadow-sm border border-orange-100 p-6 md:p-8 mb-8">
        <div class="flex flex-col md:flex-row items-start md:items-center justify-between gap-6">
            <div class="flex items-start sm:items-center gap-5">
                <div class="w-20 h-20 sm:w-24 sm:h-24 rounded-2xl overflow-hidden bg-orange-50 border border-orange-200 shadow-sm flex-shrink-0 flex items-center justify-center">
                    @if($catering->foto)
                        <img src="{{ asset('storage/' . $catering->foto) }}" alt="{{ $catering->nama_catering }}" class="w-full h-full object-cover">
                    @else
                        <div class="w-full h-full bg-gradient-to-tr from-amber-500 to-orange-400 text-white flex items-center justify-center text-3xl font-bold">
                            <i class="fas fa-store"></i>
                        </div>
                    @endif
                </div>
                <div>
                    <div class="flex flex-wrap items-center gap-3">
                        <h1 class="text-2xl sm:text-3xl font-extrabold text-textcolor">{{ $catering->nama_catering }}</h1>
                        <span class="px-3 py-1 text-xs font-semibold rounded-full bg-green-100 text-green-800">
                            {{ $catering->status }}
                        </span>
                        @if($catering->total_ulasan > 0)
                            <span class="inline-flex items-center gap-1.5 px-3 py-1 text-xs font-bold rounded-full bg-amber-50 text-amber-900 border border-amber-200 shadow-xs">
                                <i class="fas fa-star text-amber-500"></i> {{ $catering->average_rating }} / 5.0 ({{ $catering->total_ulasan }} ulasan)
                            </span>
                        @else
                            <span class="inline-flex items-center gap-1 px-3 py-1 text-xs font-medium rounded-full bg-gray-100 text-gray-600">
                                <i class="far fa-star text-gray-400"></i> Belum ada ulasan
                            </span>
                        @endif
                    </div>
                    <p class="mt-2 text-gray-600 max-w-2xl text-sm sm:text-base">{{ $catering->deskripsi ?? 'Pilihan catering makanan lezat & bergizi.' }}</p>
                </div>
            </div>
            <a href="{{ route('home') }}" class="inline-flex items-center text-sm font-semibold text-primary hover:text-amber-700 whitespace-nowrap">
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
                <div class="card-interactive reveal-on-scroll delay-{{ (($loop->iteration - 1) % 3) * 100 + 100 }} bg-white rounded-2xl shadow-xs border border-orange-100 overflow-hidden flex flex-col justify-between group">
                    <div>
                        <!-- Foto Menu -->
                        <div class="h-48 overflow-hidden relative bg-gray-100">
                            @if($menu->foto)
                                <img src="{{ asset('storage/' . $menu->foto) }}" alt="{{ $menu->nama_menu }}" class="img-zoom w-full h-full object-cover">
                            @else
                                <img src="https://images.unsplash.com/photo-1546069901-ba9599a7e63c?auto=format&fit=crop&w=600&q=80" alt="{{ $menu->nama_menu }}" class="img-zoom w-full h-full object-cover opacity-80">
                            @endif
                            <span class="absolute top-2.5 right-2.5 text-xs font-bold text-amber-700 bg-white/95 backdrop-blur-sm px-2.5 py-1 rounded-md shadow-xs">
                                {{ $menu->kode_menu }}
                            </span>
                        </div>

                        <div class="p-5">
                            <div class="flex justify-between items-center mb-1">
                                <span class="text-xs font-medium text-gray-500 bg-gray-100 px-2 py-0.5 rounded">Stok: {{ $menu->stok }} porsi</span>
                            </div>
                            <h3 class="text-lg font-bold text-textcolor mb-1 group-hover:text-primary transition-colors">{{ $menu->nama_menu }}</h3>
                            <p class="text-2xl font-black text-primary mb-4">
                                Rp {{ number_format($menu->harga, 0, ',', '.') }}
                            </p>
                        </div>
                    </div>

                    <div class="p-5 pt-0">
                        <form action="{{ route('cart.add') }}" method="POST">
                            @csrf
                            <input type="hidden" name="type" value="menu">
                            <input type="hidden" name="id" value="{{ $menu->id }}">
                            <div class="flex items-center gap-2">
                                <input type="number" name="jumlah" value="1" min="1" max="{{ $menu->stok }}" class="w-20 px-3 py-2 border border-gray-300 rounded-xl text-center text-sm focus:ring-primary focus:border-primary">
                                <button type="submit" class="btn-press flex-1 bg-primary hover:bg-amber-600 text-white font-bold py-2.5 px-4 rounded-xl text-sm transition shadow-sm flex items-center justify-center gap-1 cursor-pointer" {{ $menu->stok <= 0 ? 'disabled' : '' }}>
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
                <div class="card-interactive reveal-on-scroll delay-{{ (($loop->iteration - 1) % 3) * 100 + 100 }} bg-white rounded-2xl shadow-xs border border-amber-200 overflow-hidden flex flex-col justify-between group">
                    <div>
                        <!-- Foto Paket -->
                        <div class="h-48 overflow-hidden relative bg-gray-100">
                            @if($paket->foto)
                                <img src="{{ asset('storage/' . $paket->foto) }}" alt="{{ $paket->nama_paket }}" class="img-zoom w-full h-full object-cover">
                            @else
                                <img src="https://images.unsplash.com/photo-1555244162-803834f70033?auto=format&fit=crop&w=600&q=80" alt="{{ $paket->nama_paket }}" class="img-zoom w-full h-full object-cover opacity-80">
                            @endif
                            <span class="absolute top-2.5 left-2.5 text-xs font-bold text-white bg-primary px-2.5 py-1 rounded-md shadow-xs uppercase tracking-wider">
                                Paket Spesial
                            </span>
                            <span class="absolute top-2.5 right-2.5 text-xs font-semibold text-gray-700 bg-white/95 backdrop-blur-sm px-2.5 py-1 rounded-md shadow-xs">
                                {{ $paket->menus->count() }} Menu
                            </span>
                        </div>

                        <div class="p-5">
                            <h3 class="text-xl font-bold text-textcolor mb-2 group-hover:text-primary transition-colors">{{ $paket->nama_paket }}</h3>
                            
                            <!-- List of menus inside packet -->
                            <div class="mb-4 bg-orange-50/50 p-3 rounded-xl border border-orange-100">
                                <p class="text-xs font-semibold text-gray-600 mb-1">Isi Paket:</p>
                                <ul class="text-xs text-gray-700 space-y-1">
                                    @forelse($paket->menus as $pm)
                                        <li class="flex items-center gap-1.5">
                                            <span class="text-accent font-bold">•</span> {{ $pm->nama_menu }}
                                        </li>
                                    @empty
                                        <li class="text-gray-400 italic">Menu paket belum diatur</li>
                                    @endforelse
                                </ul>
                            </div>

                            <p class="text-2xl font-black text-primary mb-4">
                                Rp {{ number_format($paket->harga, 0, ',', '.') }}
                            </p>
                        </div>
                    </div>

                    <div class="p-5 pt-0">
                        <form action="{{ route('cart.add') }}" method="POST">
                            @csrf
                            <input type="hidden" name="type" value="paket">
                            <input type="hidden" name="id" value="{{ $paket->id }}">
                            <div class="flex items-center gap-2">
                                <input type="number" name="jumlah" value="1" min="1" class="w-20 px-3 py-2 border border-gray-300 rounded-xl text-center text-sm focus:ring-primary focus:border-primary">
                                <button type="submit" class="btn-press flex-1 bg-accent hover:bg-[#5a781d] text-white font-bold py-2.5 px-4 rounded-xl text-sm transition shadow-sm flex items-center justify-center gap-1 cursor-pointer">
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

        <!-- Section Ulasan & Penilaian Pelanggan -->
        <div id="ulasan-section" class="pt-4">
            <div class="border-b border-amber-200 pb-3 mb-6 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-2">
                <div>
                    <h2 class="text-2xl font-bold text-textcolor flex items-center gap-2">
                        <i class="fas fa-star text-amber-500"></i> Ulasan & Penilaian Pelanggan
                    </h2>
                    <p class="text-sm text-gray-500">Ulasan nyata dari pelanggan yang telah memesan di {{ $catering->nama_catering }}</p>
                </div>
                @if($catering->total_ulasan > 0)
                    <div class="flex items-center gap-2 bg-amber-50 px-4 py-2 rounded-xl border border-amber-200 shadow-xs">
                        <div class="flex text-amber-400 text-base">
                            @for($i = 1; $i <= 5; $i++)
                                @if($i <= round($catering->average_rating))
                                    <i class="fas fa-star"></i>
                                @else
                                    <i class="far fa-star text-gray-300"></i>
                                @endif
                            @endfor
                        </div>
                        <span class="font-extrabold text-gray-900 text-lg">{{ $catering->average_rating }}</span>
                        <span class="text-xs text-gray-500">({{ $catering->total_ulasan }} ulasan)</span>
                    </div>
                @endif
            </div>

            <!-- List Ulasan -->
            <div class="space-y-4">
                @forelse($catering->ulasans as $ulasan)
                <div class="bg-white rounded-2xl shadow-sm border border-orange-100 p-5 sm:p-6 hover:shadow-md transition">
                    <div class="flex items-start justify-between gap-4">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 rounded-full bg-gradient-to-tr from-amber-500 to-orange-400 text-white font-bold flex items-center justify-center text-sm shadow-xs">
                                {{ strtoupper(substr($ulasan->pelanggan->username ?? 'U', 0, 1)) }}
                            </div>
                            <div>
                                <div class="flex items-center gap-2">
                                    <h4 class="font-bold text-gray-900 text-sm sm:text-base">{{ $ulasan->pelanggan->username ?? 'Pelanggan' }}</h4>
                                    <span class="inline-flex items-center gap-1 text-[10px] text-green-700 bg-green-50 border border-green-200 px-2 py-0.5 rounded-full font-semibold">
                                        <i class="fas fa-check-circle text-[9px]"></i> Pembeli Terverifikasi
                                    </span>
                                </div>
                                <div class="flex items-center gap-2 mt-0.5">
                                    <div class="flex text-amber-400 text-xs">
                                        @for($i = 1; $i <= 5; $i++)
                                            @if($i <= $ulasan->rating)
                                                <i class="fas fa-star"></i>
                                            @else
                                                <i class="far fa-star text-gray-300"></i>
                                            @endif
                                        @endfor
                                    </div>
                                    <span class="text-xs font-semibold text-gray-700">({{ $ulasan->rating }}/5)</span>
                                </div>
                            </div>
                        </div>
                        <span class="text-xs text-gray-400 whitespace-nowrap">
                            {{ $ulasan->created_at->format('d M Y, H:i') }}
                        </span>
                    </div>

                    @if($ulasan->komentar)
                        <div class="mt-3.5 pl-13 text-sm text-gray-700 leading-relaxed bg-gray-50/80 p-3.5 rounded-xl border border-gray-100">
                            {{ $ulasan->komentar }}
                        </div>
                    @else
                        <p class="mt-3 text-xs text-gray-400 italic">Memberikan rating tanpa komentar tertulis.</p>
                    @endif
                </div>
                @empty
                <div class="col-span-full py-12 text-center bg-white rounded-2xl border border-dashed border-gray-300 p-8">
                    <div class="w-16 h-16 rounded-full bg-amber-50 text-amber-400 flex items-center justify-center mx-auto mb-3 text-2xl">
                        <i class="far fa-comment-dots"></i>
                    </div>
                    <h3 class="font-bold text-gray-800 text-base mb-1">Belum Ada Ulasan</h3>
                    <p class="text-gray-500 text-sm max-w-md mx-auto">
                        Catering ini belum memiliki ulasan dari pembeli. Lakukan pemesanan pertama dan jadilah yang pertama memberikan penilaian!
                    </p>
                </div>
                @endforelse
            </div>
        </div>
    </div>
</div>
@endsection
