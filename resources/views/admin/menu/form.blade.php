@extends('layouts.admin')

@section('admin_content')
<div class="mb-6">
    <div class="flex items-center space-x-3 mb-2">
        <a href="{{ route('menu.index') }}" class="text-gray-500 hover:text-primary font-bold">&larr; Kembali</a>
        <h2 class="text-2xl font-bold text-textcolor">
            {{ isset($menu) ? 'Edit Menu' : 'Tambah Menu Baru' }}
        </h2>
    </div>
</div>

<div class="bg-white rounded-lg border border-gray-200 p-6 shadow-sm">
    <form action="{{ isset($menu) ? route('menu.update', $menu->id) : route('menu.store') }}" method="POST">
        @csrf
        @if(isset($menu))
            @method('PUT')
        @endif

        <div class="space-y-4">
            <div>
                <label for="kode_menu" class="block text-sm font-medium text-gray-700">Kode Menu</label>
                <input type="text" name="kode_menu" id="kode_menu" value="{{ old('kode_menu', $menu->kode_menu ?? '') }}" 
                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-primary focus:ring focus:ring-primary focus:ring-opacity-50 border p-2 bg-secondary"
                    required maxlength="20" placeholder="Cth: MNU-01">
                @error('kode_menu')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="nama_menu" class="block text-sm font-medium text-gray-700">Nama Menu</label>
                <input type="text" name="nama_menu" id="nama_menu" value="{{ old('nama_menu', $menu->nama_menu ?? '') }}" 
                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-primary focus:ring focus:ring-primary focus:ring-opacity-50 border p-2 bg-secondary"
                    required maxlength="100" placeholder="Cth: Nasi Goreng Spesial">
                @error('nama_menu')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label for="harga" class="block text-sm font-medium text-gray-700">Harga (Rp)</label>
                    <input type="number" name="harga" id="harga" value="{{ old('harga', isset($menu) ? (int)$menu->harga : '') }}" 
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-primary focus:ring focus:ring-primary focus:ring-opacity-50 border p-2 bg-secondary"
                        required min="1">
                    @error('harga')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="stok" class="block text-sm font-medium text-gray-700">Stok (Porsi)</label>
                    <input type="number" name="stok" id="stok" value="{{ old('stok', $menu->stok ?? '') }}" 
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-primary focus:ring focus:ring-primary focus:ring-opacity-50 border p-2 bg-secondary"
                        required min="0">
                    @error('stok')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
            </div>
        </div>

        <div class="mt-6">
            <button type="submit" class="bg-primary hover:bg-amber-600 text-white font-bold py-2 px-4 rounded transition w-full md:w-auto shadow">
                {{ isset($menu) ? 'Simpan Perubahan' : 'Simpan Menu' }}
            </button>
        </div>
    </form>
</div>
@endsection
