@extends('layouts.superadmin')

@php
    $pageTitle = 'Kelola Pengguna';
@endphp

@section('content')
<!-- Page Header -->
<div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-6">
    <div>
        <h2 class="text-2xl font-bold text-gray-800">👥 Kelola Pengguna</h2>
        <p class="text-sm text-gray-500">Daftar seluruh pengguna sistem (User, Admin Catering, dan Superadmin)</p>
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
                <p class="text-xs text-gray-500 uppercase font-semibold">Total Pengguna</p>
                <h3 class="text-2xl font-bold text-gray-800 mt-1">{{ $users->count() }}</h3>
            </div>
            <div class="w-10 h-10 rounded-lg bg-orange-50 text-primary flex items-center justify-center text-lg">
                <i class="fas fa-users"></i>
            </div>
        </div>
    </div>
    <div class="bg-white p-5 rounded-xl border border-gray-100 shadow-sm">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-xs text-gray-500 uppercase font-semibold">Superadmin</p>
                <h3 class="text-2xl font-bold text-purple-700 mt-1">{{ $users->where('role', 'Superadmin')->count() }}</h3>
            </div>
            <div class="w-10 h-10 rounded-lg bg-purple-50 text-purple-600 flex items-center justify-center text-lg">
                <i class="fas fa-user-shield"></i>
            </div>
        </div>
    </div>
    <div class="bg-white p-5 rounded-xl border border-gray-100 shadow-sm">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-xs text-gray-500 uppercase font-semibold">Admin Mitra</p>
                <h3 class="text-2xl font-bold text-blue-700 mt-1">{{ $users->where('role', 'Admin')->count() }}</h3>
            </div>
            <div class="w-10 h-10 rounded-lg bg-blue-50 text-blue-600 flex items-center justify-center text-lg">
                <i class="fas fa-store"></i>
            </div>
        </div>
    </div>
    <div class="bg-white p-5 rounded-xl border border-gray-100 shadow-sm">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-xs text-gray-500 uppercase font-semibold">Pembeli / User</p>
                <h3 class="text-2xl font-bold text-emerald-700 mt-1">{{ $users->where('role', 'User')->count() }}</h3>
            </div>
            <div class="w-10 h-10 rounded-lg bg-emerald-50 text-emerald-600 flex items-center justify-center text-lg">
                <i class="fas fa-user"></i>
            </div>
        </div>
    </div>
</div>

<!-- Table Container -->
<div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
    <div class="px-6 py-4 border-b border-gray-100 flex items-center justify-between">
        <h3 class="font-semibold text-gray-800">Daftar Akun Pengguna</h3>
        <span class="text-xs bg-gray-100 text-gray-600 font-medium px-2.5 py-1 rounded-full">{{ $users->count() }} Terdaftar</span>
    </div>

    <div class="overflow-x-auto">
        <table class="w-full text-left text-sm text-gray-600">
            <thead class="bg-gray-50 text-xs text-gray-500 uppercase font-semibold border-b border-gray-100">
                <tr>
                    <th scope="col" class="px-6 py-3.5">ID</th>
                    <th scope="col" class="px-6 py-3.5">Pengguna</th>
                    <th scope="col" class="px-6 py-3.5">Email</th>
                    <th scope="col" class="px-6 py-3.5">Role</th>
                    <th scope="col" class="px-6 py-3.5">Status</th>
                    <th scope="col" class="px-6 py-3.5">Mitra Terkait</th>
                    <th scope="col" class="px-6 py-3.5 text-right">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @forelse($users as $user)
                <tr class="hover:bg-gray-50/80 transition-colors">
                    <td class="px-6 py-4 font-mono text-xs text-gray-400">#{{ $user->id }}</td>
                    <td class="px-6 py-4">
                        <div class="flex items-center gap-3">
                            <div class="w-9 h-9 rounded-full bg-slate-100 border border-slate-200 text-slate-700 font-bold flex items-center justify-center text-xs">
                                {{ strtoupper(substr($user->username, 0, 2)) }}
                            </div>
                            <div>
                                <span class="font-semibold text-gray-900 block">{{ $user->username }}</span>
                            </div>
                        </div>
                    </td>
                    <td class="px-6 py-4 text-gray-700">{{ $user->email }}</td>
                    <td class="px-6 py-4">
                        @if($user->role === 'Superadmin')
                            <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-medium bg-purple-100 text-purple-800">
                                <i class="fas fa-crown text-[10px]"></i> Superadmin
                            </span>
                        @elseif($user->role === 'Admin')
                            <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                <i class="fas fa-store text-[10px]"></i> Admin Catering
                            </span>
                        @else
                            <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-medium bg-emerald-100 text-emerald-800">
                                <i class="fas fa-user text-[10px]"></i> Pembeli (User)
                            </span>
                        @endif
                    </td>
                    <td class="px-6 py-4">
                        @if($user->status === 'Aktif')
                            <span class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                <span class="w-1.5 h-1.5 rounded-full bg-green-500"></span> Aktif
                            </span>
                        @elseif($user->status === 'Pending')
                            <span class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">
                                <span class="w-1.5 h-1.5 rounded-full bg-yellow-500"></span> Pending
                            </span>
                        @else
                            <span class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800">
                                <span class="w-1.5 h-1.5 rounded-full bg-red-500"></span> {{ $user->status }}
                            </span>
                        @endif
                    </td>
                    <td class="px-6 py-4 text-sm text-gray-500">
                        @if($user->catering)
                            <span class="font-medium text-gray-800 flex items-center gap-1">
                                <i class="fas fa-utensils text-orange-400 text-xs"></i> {{ $user->catering->nama_catering }}
                            </span>
                        @else
                            <span class="text-gray-400 text-xs">-</span>
                        @endif
                    </td>
                    <td class="px-6 py-4 text-right">
                        @if($user->status === 'Pending')
                            <form action="{{ route('superadmin.approve.admin', $user->id) }}" method="POST" class="inline-block">
                                @csrf
                                <button type="submit" onclick="return confirm('Setujui mitra catering ini?')" class="text-xs bg-green-500 hover:bg-green-600 text-white font-medium py-1.5 px-3 rounded shadow-sm transition">
                                    Setujui
                                </button>
                            </form>
                        @endif
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="px-6 py-10 text-center text-gray-400">
                        <i class="fas fa-users text-4xl mb-3 block text-gray-300"></i>
                        Belum ada data pengguna.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection