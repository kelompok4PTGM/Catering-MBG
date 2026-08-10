@extends('layouts.admin')

@section('admin_content')
<div class="mb-6">
    <div class="flex items-center space-x-3 mb-2">
        <a href="{{ route('paket.index') }}" class="text-gray-500 hover:text-primary font-bold">&larr; Kembali</a>
        <h2 class="text-2xl font-bold text-textcolor">
            {{ isset($paket) ? 'Edit Paket' : 'Tambah Paket Baru' }}
        </h2>
    </div>
</div>

<div class="bg-white rounded-lg border border-gray-200 p-6 shadow-sm">
    <form action="{{ isset($paket) ? route('paket.update', $paket->id) : route('paket.store') }}" method="POST">
        @csrf
        @if(isset($paket))
            @method('PUT')
        @endif

        <div class="space-y-4">
            <div>
                <label for="nama_paket" class="block text-sm font-medium text-gray-700">Nama Paket</label>
                <input type="text" name="nama_paket" id="nama_paket" value="{{ old('nama_paket', $paket->nama_paket ?? '') }}" 
                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-primary focus:ring focus:ring-primary focus:ring-opacity-50 border p-2 bg-secondary"
                    required maxlength="100" placeholder="Cth: Paket Hemat A">
                @error('nama_paket')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Pilih Menu untuk Paket Ini</label>
                <div class="space-y-2 bg-secondary p-4 border border-gray-300 rounded-md max-h-60 overflow-y-auto">
                    @forelse($menus as $menu)
                        <div class="flex items-center">
                            <input id="menu_{{ $menu->id }}" name="menus[]" value="{{ $menu->id }}" type="checkbox" 
                                {{ isset($paket) && $paket->menus->contains($menu->id) ? 'checked' : '' }}
                                class="h-4 w-4 text-primary focus:ring-primary border-gray-300 rounded">
                            <label for="menu_{{ $menu->id }}" class="ml-2 block text-sm text-gray-900">
                                {{ $menu->nama_menu }} - <span class="text-accent font-semibold">Rp {{ number_format($menu->harga, 0, ',', '.') }}</span>
                            </label>
                        </div>
                    @empty
                        <p class="text-sm text-gray-500 italic">Belum ada menu yang dibuat. Silakan tambahkan Menu terlebih dahulu.</p>
                    @endforelse
                </div>
                <p class="mt-2 text-xs text-gray-500 italic">*Harga paket akan dihitung otomatis berdasarkan total harga menu yang dipilih.</p>
                @error('menus')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
                @error('menus.*')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>
        </div>

        <div class="mt-6">
            <button type="submit" class="bg-primary hover:bg-amber-600 text-white font-bold py-2 px-4 rounded transition w-full md:w-auto shadow">
                {{ isset($paket) ? 'Simpan Perubahan' : 'Simpan Paket' }}
            </button>
        </div>
    </form>
</div>
@endsection
