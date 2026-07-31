@extends('layouts.admin')

@section('admin_content')
<div class="mb-6">
    <h2 class="text-2xl font-bold text-textcolor">
        {{ $catering ? 'Edit Profil Catering' : 'Lengkapi Profil Catering' }}
    </h2>
    @if(!$catering)
        <p class="text-gray-500 mt-2 text-sm">
            Anda harus membuat profil catering terlebih dahulu sebelum bisa menambahkan Menu atau Paket.
        </p>
    @endif
</div>

<div class="bg-white rounded-lg border border-gray-200 p-6 shadow-sm">
    <form action="{{ route('admin.catering.update') }}" method="POST">
        @csrf

        <div class="space-y-4">
            <div>
                <label for="nama_catering" class="block text-sm font-medium text-gray-700">Nama Catering</label>
                <input type="text" name="nama_catering" id="nama_catering" value="{{ old('nama_catering', $catering->nama_catering ?? '') }}" 
                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-primary focus:ring focus:ring-primary focus:ring-opacity-50 border p-2 bg-secondary"
                    required maxlength="100" placeholder="Cth: Catering Bu Sri">
                @error('nama_catering')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="deskripsi" class="block text-sm font-medium text-gray-700">Deskripsi Catering</label>
                <textarea name="deskripsi" id="deskripsi" rows="4" 
                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-primary focus:ring focus:ring-primary focus:ring-opacity-50 border p-2 bg-secondary"
                    placeholder="Ceritakan sedikit tentang katering Anda...">{{ old('deskripsi', $catering->deskripsi ?? '') }}</textarea>
                @error('deskripsi')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>
        </div>

        <div class="mt-6">
            <button type="submit" class="bg-primary hover:bg-amber-600 text-white font-bold py-2 px-4 rounded transition w-full md:w-auto shadow">
                {{ $catering ? 'Simpan Perubahan' : 'Buat Profil Catering' }}
            </button>
        </div>
    </form>
</div>
@endsection
