@extends('layouts.admin')

@section('admin_content')
<div class="flex justify-between items-center mb-6">
    <h2 class="text-2xl font-bold text-textcolor">Kelola Menu</h2>
    <a href="{{ route('menu.create') }}" class="bg-primary hover:bg-amber-600 text-white px-4 py-2 rounded-md font-medium transition shadow">
        + Tambah Menu
    </a>
</div>

<div class="overflow-x-auto bg-white rounded-lg border border-gray-200">
    <table class="min-w-full divide-y divide-gray-200">
        <thead class="bg-secondary">
            <tr>
                <th scope="col" class="px-6 py-3 text-left text-xs font-bold text-gray-700 uppercase tracking-wider">Kode</th>
                <th scope="col" class="px-6 py-3 text-left text-xs font-bold text-gray-700 uppercase tracking-wider">Nama Menu</th>
                <th scope="col" class="px-6 py-3 text-left text-xs font-bold text-gray-700 uppercase tracking-wider">Harga</th>
                <th scope="col" class="px-6 py-3 text-left text-xs font-bold text-gray-700 uppercase tracking-wider">Stok</th>
                <th scope="col" class="px-6 py-3 text-right text-xs font-bold text-gray-700 uppercase tracking-wider">Aksi</th>
            </tr>
        </thead>
        <tbody class="bg-white divide-y divide-gray-200">
            @forelse($menus as $menu)
            <tr class="hover:bg-gray-50">
                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">{{ $menu->kode_menu }}</td>
                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">{{ $menu->nama_menu }}</td>
                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">Rp {{ number_format($menu->harga, 0, ',', '.') }}</td>
                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">{{ $menu->stok }}</td>
                <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                    <a href="{{ route('menu.edit', $menu->id) }}" class="text-accent hover:text-[#5a781d] mr-3 font-bold">Edit</a>
                    <form action="{{ route('menu.destroy', $menu->id) }}" method="POST" class="inline-block" onsubmit="return confirm('Apakah Anda yakin ingin menghapus menu ini?');">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="text-red-600 hover:text-red-900 font-bold">Hapus</button>
                    </form>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="5" class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 text-center">Belum ada menu.</td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
