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
    <form action="{{ isset($paket) ? route('paket.update', $paket->id) : route('paket.store') }}" method="POST" enctype="multipart/form-data">
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
                <label for="foto" class="block text-sm font-medium text-gray-700">Foto Paket Makanan</label>
                <div class="mt-2 flex items-center gap-4">
                    @if(isset($paket) && $paket->foto)
                        <div class="relative w-24 h-24 rounded-lg overflow-hidden border border-gray-200 flex-shrink-0">
                            <img src="{{ asset('storage/' . $paket->foto) }}" alt="{{ $paket->nama_paket }}" class="w-full h-full object-cover">
                        </div>
                    @endif
                    <div class="flex-1">
                        <input type="file" name="foto" id="foto" accept="image/*"
                            class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-orange-50 file:text-orange-700 hover:file:bg-orange-100 cursor-pointer">
                        <p class="mt-1 text-xs text-gray-500">Format JPG, JPEG, PNG, WEBP. Maks 2MB.</p>
                    </div>
                </div>
                @error('foto')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="harga" class="block text-sm font-medium text-gray-700">Harga Paket (Rp)</label>
                <input type="number" name="harga" id="harga" value="{{ old('harga', isset($paket) ? (int)$paket->harga : '') }}" 
                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-primary focus:ring focus:ring-primary focus:ring-opacity-50 border p-2 bg-secondary"
                    required min="0" step="500" placeholder="Cth: 35000">
                <div class="mt-1.5 flex items-center justify-between text-xs text-gray-500">
                    <span>Total harga asli menu yang dipilih: <strong id="totalAsli" class="text-gray-800 font-semibold">Rp 0</strong></span>
                    <button type="button" id="btnSalinHarga" class="text-primary hover:text-amber-700 font-medium underline">
                        Gunakan total harga asli
                    </button>
                </div>
                @error('harga')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Pilih Menu untuk Paket Ini</label>
                <div class="space-y-2 bg-secondary p-4 border border-gray-300 rounded-md max-h-60 overflow-y-auto">
                    @forelse($menus as $menu)
                        <div class="flex items-center">
                            <input id="menu_{{ $menu->id }}" name="menus[]" value="{{ $menu->id }}" data-harga="{{ $menu->harga }}" type="checkbox" 
                                {{ isset($paket) && $paket->menus->contains($menu->id) ? 'checked' : '' }}
                                class="menu-checkbox h-4 w-4 text-primary focus:ring-primary border-gray-300 rounded">
                            <label for="menu_{{ $menu->id }}" class="ml-2 block text-sm text-gray-900 cursor-pointer">
                                {{ $menu->nama_menu }} - <span class="text-accent font-semibold">Rp {{ number_format($menu->harga, 0, ',', '.') }}</span>
                            </label>
                        </div>
                    @empty
                        <p class="text-sm text-gray-500 italic">Belum ada menu yang dibuat. Silakan tambahkan Menu terlebih dahulu.</p>
                    @endforelse
                </div>
                <p class="mt-2 text-xs text-gray-500 italic">*Anda dapat menentukan harga paket secara bebas (misal lebih murah dari harga satuan menu untuk promo/paket hemat).</p>
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

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const checkboxes = document.querySelectorAll('.menu-checkbox');
        const totalAsliEl = document.getElementById('totalAsli');
        const btnSalin = document.getElementById('btnSalinHarga');
        const hargaInput = document.getElementById('harga');

        function hitungTotalAsli() {
            let total = 0;
            checkboxes.forEach(cb => {
                if (cb.checked) {
                    total += parseFloat(cb.getAttribute('data-harga') || 0);
                }
            });
            totalAsliEl.textContent = 'Rp ' + total.toLocaleString('id-ID');
            return total;
        }

        checkboxes.forEach(cb => {
            cb.addEventListener('change', function () {
                const total = hitungTotalAsli();
                // Jika input harga masih kosong (pada form tambah baru), otomatis isi dengan total harga asli
                @if(!isset($paket))
                if (!hargaInput.value || hargaInput.dataset.manual !== 'true') {
                    hargaInput.value = total;
                }
                @endif
            });
        });

        hargaInput.addEventListener('input', function () {
            hargaInput.dataset.manual = 'true';
        });

        if (btnSalin) {
            btnSalin.addEventListener('click', function () {
                const total = hitungTotalAsli();
                hargaInput.value = total;
                hargaInput.dataset.manual = 'true';
            });
        }

        hitungTotalAsli();
    });
</script>
@endsection
