@extends('layouts.admin')

@section('admin_content')
<div>
    <div class="mb-6 flex items-center justify-between">
        <div>
            <a href="{{ route('admin.orders.index') }}" class="text-xs font-semibold text-primary hover:underline">&larr; Kembali ke Pesanan Masuk</a>
            <h2 class="text-2xl font-extrabold text-textcolor mt-1">Kelola Pesanan #ORD-{{ str_pad($order->id, 5, '0', STR_PAD_LEFT) }}</h2>
        </div>
        <div class="text-right">
            <span class="text-xs text-gray-500 block">ID Catering: {{ $order->id_catering }}</span>
            <span class="text-xs font-bold text-accent">Mitra: {{ $catering->nama_catering }}</span>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Order Details & Update Status -->
        <div class="lg:col-span-2 space-y-6">
            <!-- Informasi Pembeli -->
            <div class="bg-amber-50/40 p-4 rounded-xl border border-orange-100">
                <h3 class="text-xs font-bold text-gray-400 uppercase tracking-wider mb-2">Informasi Pemesan</h3>
                <div class="grid grid-cols-2 gap-4 text-sm">
                    <div>
                        <span class="text-gray-500 text-xs block">Nama Pelanggan</span>
                        <span class="font-bold text-textcolor">{{ $order->pelanggan->username ?? 'N/A' }}</span>
                    </div>
                    <div>
                        <span class="text-gray-500 text-xs block">Email</span>
                        <span class="font-bold text-textcolor">{{ $order->pelanggan->email ?? 'N/A' }}</span>
                    </div>
                </div>
            </div>

            <!-- List Detail Pesanan -->
            <div>
                <h3 class="text-xs font-bold text-gray-400 uppercase tracking-wider mb-3">Item Yang Dipesan</h3>
                <div class="border border-gray-100 rounded-xl overflow-hidden divide-y divide-gray-100">
                    @foreach($order->details as $detail)
                    <div class="p-4 flex justify-between items-center text-sm">
                        <div>
                            @if($detail->menu)
                                <span class="px-2 py-0.5 text-[10px] font-bold bg-blue-100 text-blue-800 rounded mr-2">MENU</span>
                                <span class="font-bold text-textcolor">{{ $detail->menu->nama_menu }}</span>
                            @elseif($detail->paket)
                                <span class="px-2 py-0.5 text-[10px] font-bold bg-purple-100 text-purple-800 rounded mr-2">PAKET</span>
                                <span class="font-bold text-textcolor">{{ $detail->paket->nama_paket }}</span>
                            @else
                                <span class="text-gray-400 italic">Item tidak tersedia</span>
                            @endif
                            <p class="text-xs text-gray-500 mt-1">Jumlah: {{ $detail->jumlah }} porsi</p>
                        </div>
                        <span class="font-bold text-textcolor">Rp {{ number_format($detail->subtotal, 0, ',', '.') }}</span>
                    </div>
                    @endforeach
                </div>

                <div class="mt-4 pt-3 flex justify-between items-center">
                    <span class="text-sm font-extrabold text-textcolor">Total Transaksi</span>
                    <span class="text-xl font-black text-primary">Rp {{ number_format($order->total_harga, 0, ',', '.') }}</span>
                </div>
            </div>
        </div>

        <!-- Status Management & Payment Info -->
        <div class="lg:col-span-1 space-y-6">
            <!-- Update Status Form -->
            <div class="bg-gray-50 p-5 rounded-xl border border-gray-200">
                <h3 class="text-sm font-bold text-textcolor mb-3 pb-2 border-b border-gray-200">Update Status Pesanan</h3>
                <form action="{{ route('admin.orders.status', $order->id) }}" method="POST" class="space-y-4">
                    @csrf
                    <div>
                        <label class="block text-xs font-semibold text-gray-600 mb-1">Status Saat Ini</label>
                        <select name="status_pesanan" class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm font-bold text-textcolor focus:ring-primary focus:border-primary">
                            <option value="Pending" {{ $order->status_pesanan === 'Pending' ? 'selected' : '' }}>Pending</option>
                            <option value="Diproses" {{ $order->status_pesanan === 'Diproses' ? 'selected' : '' }}>Diproses</option>
                            <option value="Selesai" {{ $order->status_pesanan === 'Selesai' ? 'selected' : '' }}>Selesai</option>
                            <option value="Batal" {{ $order->status_pesanan === 'Batal' ? 'selected' : '' }}>Batal</option>
                        </select>
                    </div>

                    <button type="submit" class="w-full bg-primary hover:bg-amber-600 text-white font-bold py-2 px-4 rounded-lg text-sm transition shadow-sm">
                        Simpan Perubahan Status
                    </button>
                </form>
            </div>

            <!-- Detail Pembayaran -->
            <div class="bg-gray-50 p-5 rounded-xl border border-gray-200">
                <h3 class="text-sm font-bold text-textcolor mb-3 pb-2 border-b border-gray-200">Status Pembayaran</h3>
                @if($order->pembayaran)
                    <div class="space-y-2 text-xs">
                        <div class="flex justify-between">
                            <span class="text-gray-500">Status:</span>
                            <span class="font-bold text-green-700">LUNAS</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-500">Metode:</span>
                            <span class="font-bold text-textcolor">{{ $order->pembayaran->metode_pembayaran }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-500">Jumlah Bayar:</span>
                            <span class="font-bold text-textcolor">Rp {{ number_format($order->pembayaran->jumlah_bayar, 0, ',', '.') }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-500">Tanggal Bayar:</span>
                            <span class="font-semibold text-gray-700">{{ date('d M Y H:i', strtotime($order->pembayaran->tanggal_bayar)) }}</span>
                        </div>
                    </div>
                @else
                    <div class="text-center py-3">
                        <span class="px-3 py-1 text-xs font-bold bg-red-100 text-red-700 rounded-full">Belum Ada Pembayaran</span>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
