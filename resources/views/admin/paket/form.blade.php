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
                <label for="harga" class="block text-sm font-medium text-gray-700">Harga (Rp)</label>
                <input type="number" name="harga" id="harga" value="{{ old('harga', isset($paket) ? (int)$paket->harga : '') }}" 
                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-primary focus:ring focus:ring-primary focus:ring-opacity-50 border p-2 bg-secondary"
                    required min="1">
                @error('harga')
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
