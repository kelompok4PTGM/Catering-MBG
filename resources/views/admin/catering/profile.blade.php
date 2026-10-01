@extends('layouts.admin')

@php
    $pageTitle = 'Profil Catering';
@endphp

@section('admin_content')
<div class="mb-6">
    <h2 class="text-2xl font-bold text-textcolor">
        {{ $catering ? 'Edit Profil Catering' : 'Lengkapi Profil Catering' }}
    </h2>
    <p class="text-gray-500 mt-1 text-sm">
        {{ $catering ? 'Kelola informasi identitas, foto profil, dan deskripsi usaha catering Anda.' : 'Anda harus membuat profil catering terlebih dahulu sebelum bisa menambahkan Menu atau Paket.' }}
    </p>
</div>

@if(session('success'))
    <div class="mb-6 bg-green-50 border-l-4 border-green-500 p-4 rounded-lg shadow-sm text-sm text-green-700 flex items-center justify-between">
        <div class="flex items-center gap-2">
            <i class="fas fa-check-circle text-green-500 text-lg"></i>
            <span>{{ session('success') }}</span>
        </div>
    </div>
@endif

<div class="bg-white rounded-xl border border-gray-200 p-6 md:p-8 shadow-sm">
    <form action="{{ route('admin.catering.update') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <div class="space-y-6">
            <!-- Foto Profil Catering -->
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-2">Foto / Logo Profil Catering</label>
                <div class="flex flex-col sm:flex-row items-start sm:items-center gap-6 p-4 bg-gray-50 rounded-xl border border-dashed border-gray-300">
                    <div class="relative w-28 h-28 rounded-2xl overflow-hidden bg-white shadow-sm border border-gray-200 flex-shrink-0 flex items-center justify-center">
                        <img id="catering-photo-preview" 
                             src="{{ ($catering && $catering->foto) ? asset('storage/' . $catering->foto) : 'https://images.unsplash.com/photo-1555244162-803834f70033?auto=format&fit=crop&w=400&q=80' }}" 
                             alt="Preview Catering" 
                             class="w-full h-full object-cover {{ ($catering && $catering->foto) ? '' : 'opacity-70' }}">
                        <span id="preview-badge" class="absolute bottom-1 right-1 bg-black/60 text-white text-[10px] px-1.5 py-0.5 rounded backdrop-blur-sm">
                            {{ ($catering && $catering->foto) ? 'Foto Aktif' : 'Default' }}
                        </span>
                    </div>

                    <div class="flex-1 space-y-2">
                        <input type="file" name="foto" id="foto" accept="image/*"
                            class="block w-full text-sm text-gray-500 file:mr-4 file:py-2.5 file:px-5 file:rounded-lg file:border-0 file:text-sm file:font-semibold file:bg-orange-500 file:text-white hover:file:bg-orange-600 file:cursor-pointer cursor-pointer transition">
                        <p class="text-xs text-gray-500">
                            Format yang didukung: <span class="font-medium text-gray-700">JPG, JPEG, PNG, WEBP</span>. Ukuran file maksimal <span class="font-medium text-gray-700">2MB</span>. Disarankan rasio persegi atau 4:3.
                        </p>
                        @error('foto')
                            <p class="text-xs text-red-600 font-medium">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>

            <!-- Nama Catering -->
            <div>
                <label for="nama_catering" class="block text-sm font-semibold text-gray-700 mb-1">Nama Catering <span class="text-red-500">*</span></label>
                <input type="text" name="nama_catering" id="nama_catering" value="{{ old('nama_catering', $catering->nama_catering ?? '') }}" 
                    class="block w-full rounded-lg border-gray-300 shadow-sm focus:border-primary focus:ring focus:ring-primary focus:ring-opacity-50 border p-2.5 bg-secondary text-gray-800"
                    required maxlength="100" placeholder="Cth: Catering Bunda Fadil">
                @error('nama_catering')
                    <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Deskripsi Catering -->
            <div>
                <label for="deskripsi" class="block text-sm font-semibold text-gray-700 mb-1">Deskripsi Catering</label>
                <textarea name="deskripsi" id="deskripsi" rows="4" 
                    class="block w-full rounded-lg border-gray-300 shadow-sm focus:border-primary focus:ring focus:ring-primary focus:ring-opacity-50 border p-2.5 bg-secondary text-gray-800"
                    placeholder="Ceritakan tentang layanan catering Anda, keunggulan gizi, paket makanan, dan variasi menu...">{{ old('deskripsi', $catering->deskripsi ?? '') }}</textarea>
                @error('deskripsi')
                    <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                @enderror
            </div>
        </div>

        <div class="mt-8 pt-4 border-t border-gray-100 flex items-center gap-4">
            <button type="submit" class="bg-primary hover:bg-amber-600 text-white font-bold py-2.5 px-6 rounded-lg transition shadow-sm flex items-center justify-center gap-2">
                <i class="fas fa-save"></i>
                <span>{{ $catering ? 'Simpan Perubahan' : 'Buat Profil Catering' }}</span>
            </button>
            <a href="{{ route('admin.dashboard') }}" class="text-sm text-gray-500 hover:text-gray-700 font-medium">
                Batal
            </a>
        </div>
    </form>
</div>

<script>
    const fotoInput = document.getElementById('foto');
    const photoPreview = document.getElementById('catering-photo-preview');
    const previewBadge = document.getElementById('preview-badge');

    if (fotoInput) {
        fotoInput.addEventListener('change', function(e) {
            const file = e.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(event) {
                    photoPreview.src = event.target.result;
                    photoPreview.classList.remove('opacity-70');
                    if (previewBadge) {
                        previewBadge.textContent = 'Preview Baru';
                        previewBadge.className = 'absolute bottom-1 right-1 bg-green-600 text-white text-[10px] px-1.5 py-0.5 rounded backdrop-blur-sm font-medium';
                    }
                };
                reader.readAsDataURL(file);
            }
        });
    }
</script>
@endsection
