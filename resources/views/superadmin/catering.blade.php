@extends('layouts.superadmin')

@php
    $pageTitle = 'Semua Mitra Catering';
@endphp

@section('content')
<!-- Page Header -->
<div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-6">
    <div>
        <h2 class="text-2xl font-bold text-gray-800">🏪 Semua Mitra Catering</h2>
        <p class="text-sm text-gray-500">Daftar mitra catering yang terdaftar di platform Catering MBG</p>
    </div>
    <div class="text-sm text-gray-500 bg-white px-4 py-2 rounded-lg border border-gray-100 shadow-sm">
        <i class="far fa-calendar-alt text-primary mr-2"></i>{{ now()->format('d M Y') }}
    </div>
</div>

<!-- Stats Summary -->
<div class="grid grid-cols-2 lg:grid-cols-4 gap-4 mb-6">
    <div class="bg-white p-5 rounded-xl border border-gray-100 shadow-sm">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-xs text-gray-500 uppercase font-semibold">Total Catering</p>
                <h3 class="text-2xl font-bold text-gray-800 mt-1">{{ $caterings->count() }}</h3>
            </div>
            <div class="w-10 h-10 rounded-lg bg-blue-50 text-blue-600 flex items-center justify-center text-lg">
                <i class="fas fa-store"></i>
            </div>
        </div>
    </div>
    <div class="bg-white p-5 rounded-xl border border-gray-100 shadow-sm">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-xs text-gray-500 uppercase font-semibold">Mitra Aktif</p>
                <h3 class="text-2xl font-bold text-emerald-700 mt-1">{{ $caterings->where('status', 'Aktif')->count() }}</h3>
            </div>
            <div class="w-10 h-10 rounded-lg bg-emerald-50 text-emerald-600 flex items-center justify-center text-lg">
                <i class="fas fa-check-circle"></i>
            </div>
        </div>
    </div>
    <div class="bg-white p-5 rounded-xl border border-gray-100 shadow-sm">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-xs text-gray-500 uppercase font-semibold">Total Menu Terdaftar</p>
                <h3 class="text-2xl font-bold text-orange-600 mt-1">{{ $caterings->sum(fn($c) => $c->menus ? $c->menus->count() : 0) }}</h3>
            </div>
            <div class="w-10 h-10 rounded-lg bg-orange-50 text-orange-600 flex items-center justify-center text-lg">
                <i class="fas fa-utensils"></i>
            </div>
        </div>
    </div>
    <div class="bg-white p-5 rounded-xl border border-gray-100 shadow-sm">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-xs text-gray-500 uppercase font-semibold">Total Paket Tersedia</p>
                <h3 class="text-2xl font-bold text-purple-700 mt-1">{{ $caterings->sum(fn($c) => $c->pakets ? $c->pakets->count() : 0) }}</h3>
            </div>
            <div class="w-10 h-10 rounded-lg bg-purple-50 text-purple-600 flex items-center justify-center text-lg">
                <i class="fas fa-box-open"></i>
            </div>
        </div>
    </div>
</div>

<!-- Table Container -->
<div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
    <div class="px-6 py-4 border-b border-gray-100 flex items-center justify-between">
        <h3 class="font-semibold text-gray-800">Daftar Mitra Catering</h3>
        <span class="text-xs bg-gray-100 text-gray-600 font-medium px-2.5 py-1 rounded-full">{{ $caterings->count() }} Mitra</span>
    </div>

    <div class="overflow-x-auto">
        <table class="w-full text-left text-sm text-gray-600">
            <thead class="bg-gray-50 text-xs text-gray-500 uppercase font-semibold border-b border-gray-100">
                <tr>
                    <th scope="col" class="px-6 py-3.5">ID</th>
                    <th scope="col" class="px-6 py-3.5">Nama Catering</th>
                    <th scope="col" class="px-6 py-3.5">Pengelola (Admin)</th>
                    <th scope="col" class="px-6 py-3.5">Menu & Paket</th>
                    <th scope="col" class="px-6 py-3.5">Deskripsi</th>
                    <th scope="col" class="px-6 py-3.5">Status</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @forelse($caterings as $catering)
                <tr class="hover:bg-gray-50/80 transition-colors">
                    <td class="px-6 py-4 font-mono text-xs text-gray-400">#{{ $catering->id }}</td>
                    <td class="px-6 py-4">
                        <div class="flex items-center gap-3">
                            @if($catering->foto)
                                <img src="{{ asset('storage/' . $catering->foto) }}" alt="{{ $catering->nama_catering }}" class="w-10 h-10 rounded-xl object-cover shadow-sm border border-gray-200">
                            @else
                                <div class="w-10 h-10 rounded-xl bg-gradient-to-tr from-amber-500 to-orange-400 text-white flex items-center justify-center font-bold text-sm shadow-sm">
                                    <i class="fas fa-store"></i>
                                </div>
                            @endif
                            <div>
                                <span class="font-semibold text-gray-900 block">{{ $catering->nama_catering }}</span>
                                <span class="text-xs text-gray-400">ID Mitra: {{ $catering->id }}</span>
                            </div>
                        </div>
                    </td>
                    <td class="px-6 py-4">
                        @if($catering->admin)
                            <div>
                                <span class="font-medium text-gray-800 block">{{ $catering->admin->username }}</span>
                                <span class="text-xs text-gray-400">{{ $catering->admin->email }}</span>
                            </div>
                        @else
                            <span class="text-gray-400 italic text-xs">Belum ditautkan</span>
                        @endif
                    </td>
                    <td class="px-6 py-4">
                        <div class="flex items-center gap-2">
                            <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-md text-xs font-medium bg-amber-50 text-amber-800 border border-amber-200">
                                <i class="fas fa-utensils text-[10px]"></i> {{ $catering->menus ? $catering->menus->count() : 0 }} Menu
                            </span>
                            <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-md text-xs font-medium bg-purple-50 text-purple-800 border border-purple-200">
                                <i class="fas fa-box text-[10px]"></i> {{ $catering->pakets ? $catering->pakets->count() : 0 }} Paket
                            </span>
                        </div>
                    </td>
                    <td class="px-6 py-4 max-w-xs text-gray-500 text-xs">
                        <p class="truncate" title="{{ $catering->deskripsi ?? 'Tidak ada deskripsi' }}">
                            {{ $catering->deskripsi ?? '-' }}
                        </p>
                    </td>
                    <td class="px-6 py-4">
                        @if($catering->status === 'Aktif')
                            <span class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                <span class="w-1.5 h-1.5 rounded-full bg-green-500"></span> Aktif
                            </span>
                        @else
                            <span class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800">
                                <span class="w-1.5 h-1.5 rounded-full bg-red-500"></span> Nonaktif
                            </span>
                        @endif
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="px-6 py-10 text-center text-gray-400">
                        <i class="fas fa-store-slash text-4xl mb-3 block text-gray-300"></i>
                        Belum ada data catering terdaftar.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection