@extends('layouts.admin')

@section('admin_content')
<!-- Page Header -->
<div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4 mb-6 pb-4 border-b border-orange-100">
    <div>
        <h2 class="text-2xl font-bold text-gray-800">Laporan Penjualan</h2>
        <p class="text-sm text-gray-500">Filter, analisis, dan cetak laporan hasil penjualan catering Anda.</p>
    </div>
    
    <!-- Action buttons -->
    <div class="flex items-center gap-2">
        <a href="{{ route('admin.laporan.print', ['bulan' => $bulan, 'tahun' => $tahun]) }}" target="_blank" class="inline-flex items-center justify-center px-4 py-2 bg-red-600 hover:bg-red-700 text-white font-bold text-sm rounded-lg transition shadow-sm gap-1">
            <i class="fas fa-file-pdf"></i> Cetak / PDF
        </a>
        <a href="{{ route('admin.laporan.csv', ['bulan' => $bulan, 'tahun' => $tahun]) }}" class="inline-flex items-center justify-center px-4 py-2 bg-accent hover:bg-[#5a781d] text-white font-bold text-sm rounded-lg transition shadow-sm gap-1">
            <i class="fas fa-file-excel"></i> Ekspor CSV
        </a>
    </div>
</div>

<!-- Filter Section -->
<div class="bg-white rounded-xl shadow-sm border border-gray-100 p-5 mb-8">
    <form method="GET" action="{{ route('admin.laporan') }}" class="flex flex-col sm:flex-row items-end gap-4">
        <div class="w-full sm:w-44">
            <label for="bulan" class="block text-xs font-bold text-gray-600 uppercase tracking-wider mb-2">Bulan</label>
            <select name="bulan" id="bulan" class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm font-medium focus:ring-primary focus:border-primary">
                @for ($m = 1; $m <= 12; $m++)
                    <option value="{{ $m }}" {{ $m == $bulan ? 'selected' : '' }}>
                        {{ date('F', mktime(0, 0, 0, $m, 1)) }}
                    </option>
                @endfor
            </select>
        </div>
        
        <div class="w-full sm:w-44">
            <label for="tahun" class="block text-xs font-bold text-gray-600 uppercase tracking-wider mb-2">Tahun</label>
            <select name="tahun" id="tahun" class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm font-medium focus:ring-primary focus:border-primary">
                @for ($y = now()->year; $y >= 2020; $y--)
                    <option value="{{ $y }}" {{ $y == $tahun ? 'selected' : '' }}>
                        {{ $y }}
                    </option>
                @endfor
            </select>
        </div>
        
        <div class="flex items-center gap-2 w-full sm:w-auto">
            <button type="submit" class="w-full sm:w-auto px-5 py-2 bg-primary hover:bg-amber-600 text-white font-bold text-sm rounded-lg transition shadow-sm flex items-center justify-center gap-1">
                <i class="fas fa-filter"></i> Filter
            </button>
            <a href="{{ route('admin.laporan') }}" class="w-full sm:w-auto px-5 py-2 bg-gray-100 hover:bg-gray-200 text-gray-700 font-bold text-sm rounded-lg transition text-center">
                Reset
            </a>
        </div>
    </form>
</div>

<!-- Stats Widgets -->
<div class="grid grid-cols-1 sm:grid-cols-2 gap-6 mb-8">
    <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-100 flex items-center justify-between hover:shadow-md transition">
        <div>
            <p class="text-sm text-gray-500 font-medium">Total Pesanan (Periode Ini)</p>
            <p class="text-3xl font-black text-gray-800 mt-1">{{ $totalPesanan }}</p>
        </div>
        <div class="bg-orange-50 p-4 rounded-xl text-primary">
            <i class="fas fa-shopping-cart text-2xl"></i>
        </div>
    </div>
    
    <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-100 flex items-center justify-between hover:shadow-md transition">
        <div>
            <p class="text-sm text-gray-500 font-medium">Pendapatan Selesai (Periode Ini)</p>
            <p class="text-3xl font-black text-accent mt-1">Rp {{ number_format($totalPendapatan, 0, ',', '.') }}</p>
        </div>
        <div class="bg-green-50 p-4 rounded-xl text-accent">
            <i class="fas fa-money-bill-wave text-2xl"></i>
        </div>
    </div>
</div>

<!-- Reports Table -->
<div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
    <div class="px-6 py-4 border-b border-gray-100">
        <h3 class="font-bold text-gray-800 text-base">Detail Pesanan - {{ date('F Y', mktime(0, 0, 0, $bulan, 1, $tahun)) }}</h3>
    </div>
    
    <div class="overflow-x-auto">
        <table class="w-full text-sm">
            <thead>
                <tr class="bg-gray-50 text-left text-gray-600 border-b border-gray-100">
                    <th class="p-4 font-bold">No</th>
                    <th class="p-4 font-bold">ID Pesanan</th>
                    <th class="p-4 font-bold">Tanggal</th>
                    <th class="p-4 font-bold">Pelanggan</th>
                    <th class="p-4 font-bold">Total Harga</th>
                    <th class="p-4 font-bold text-center">Status</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @forelse($pesanan as $index => $order)
                <tr class="hover:bg-gray-50/50 transition">
                    <td class="p-4 text-gray-500">{{ $index + 1 }}</td>
                    <td class="p-4 font-bold text-gray-800">#ORD-{{ str_pad($order->id, 5, '0', STR_PAD_LEFT) }}</td>
                    <td class="p-4 text-gray-500 text-xs">{{ date('d/m/Y H:i', strtotime($order->tanggal_pesanan)) }}</td>
                    <td class="p-4 font-medium text-gray-800">{{ $order->pelanggan->username ?? 'Guest' }}</td>
                    <td class="p-4 font-bold text-primary">Rp {{ number_format($order->total_harga, 0, ',', '.') }}</td>
                    <td class="p-4 text-center">
                        <span class="px-2.5 py-1 text-xs font-bold rounded-full 
                            {{ $order->status_pesanan == 'Selesai' ? 'bg-green-100 text-green-800' : 
                               ($order->status_pesanan == 'Pending' ? 'bg-yellow-100 text-yellow-800' : 
                               ($order->status_pesanan == 'Diproses' ? 'bg-blue-100 text-blue-800' : 'bg-red-100 text-red-800')) }}">
                            {{ $order->status_pesanan }}
                        </span>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="p-8 text-center text-gray-400">
                        <i class="fas fa-inbox text-3xl block mb-2"></i>
                        Tidak ada data pesanan untuk periode ini.
                    </td>
                </tr>
                @endforelse
            </tbody>
            
            @if($pesanan->count() > 0)
            <tfoot>
                <tr class="bg-orange-50/30 border-t-2 border-orange-100 text-gray-800 font-bold">
                    <td colspan="4" class="p-4 text-right">Total Pendapatan Selesai:</td>
                    <td class="p-4 text-accent text-lg">Rp {{ number_format($totalPendapatan, 0, ',', '.') }}</td>
                    <td class="p-4 text-center text-xs text-gray-500">Dari {{ $totalPesanan }} pesanan</td>
                </tr>
            </tfoot>
            @endif
        </table>
    </div>
</div>
@endsection