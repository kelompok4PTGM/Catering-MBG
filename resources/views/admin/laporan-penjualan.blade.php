@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row mb-4">
        <div class="col">
            <h2>Laporan Penjualan</h2>
            <p class="text-muted">Filter dan cetak laporan penjualan</p>
        </div>
    </div>

    <!-- Filter -->
    <div class="card mb-4">
        <div class="card-body">
            <form method="GET" action="{{ route('admin.laporan') }}" class="form-inline">
                <div class="form-group mr-2">
                    <label for="bulan" class="mr-2">Bulan:</label>
                    <select name="bulan" id="bulan" class="form-control">
                        @for ($m = 1; $m <= 12; $m++)
                            <option value="{{ $m }}" {{ $m == $bulan ? 'selected' : '' }}>
                                {{ date('F', mktime(0, 0, 0, $m, 1)) }}
                            </option>
                        @endfor
                    </select>
                </div>
                <div class="form-group mr-2">
                    <label for="tahun" class="mr-2">Tahun:</label>
                    <select name="tahun" id="tahun" class="form-control">
                        @for ($y = now()->year; $y >= 2020; $y--)
                            <option value="{{ $y }}" {{ $y == $tahun ? 'selected' : '' }}>
                                {{ $y }}
                            </option>
                        @endfor
                    </select>
                </div>
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-filter"></i> Filter
                </button>
                <a href="{{ route('admin.laporan') }}" class="btn btn-secondary ml-2">
                    <i class="fas fa-sync"></i> Reset
                </a>
            </form>
        </div>
    </div>

    <!-- Tombol Ekspor (Tanpa DomPDF) -->
    <div class="mb-4">
        <div class="btn-group">
            <a href="{{ route('admin.laporan.print', ['bulan' => $bulan, 'tahun' => $tahun]) }}" target="_blank" class="btn btn-danger">
                <i class="fas fa-file-pdf"></i> Cetak/PDF
            </a>
            <a href="{{ route('admin.laporan.csv', ['bulan' => $bulan, 'tahun' => $tahun]) }}" class="btn btn-success">
                <i class="fas fa-file-excel"></i> Export CSV
            </a>
            <button onclick="window.print()" class="btn btn-info">
                <i class="fas fa-print"></i> Print
            </button>
        </div>
    </div>

    <!-- Statistik -->
    <div class="row mb-4">
        <div class="col-md-6">
            <div class="card bg-primary text-white">
                <div class="card-body">
                    <h5 class="card-title">Total Pesanan</h5>
                    <h2 class="mb-0">{{ $totalPesanan }}</h2>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card bg-success text-white">
                <div class="card-body">
                    <h5 class="card-title">Total Pendapatan</h5>
                    <h2 class="mb-0">Rp {{ number_format($totalPendapatan, 0, ',', '.') }}</h2>
                </div>
            </div>
        </div>
    </div>

    <!-- Tabel Laporan -->
    <div class="card">
        <div class="card-header">
            <h5 class="mb-0">Detail Pesanan - {{ date('F Y', mktime(0, 0, 0, $bulan, 1, $tahun)) }}</h5>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-hover" id="laporanTable">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>ID Pesanan</th>
                            <th>Tanggal</th>
                            <th>Pelanggan</th>
                            <th>Total</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($pesanan as $index => $order)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>#{{ $order->id }}</td>
                            <td>{{ $order->created_at->format('d/m/Y H:i') }}</td>
                            <td>{{ $order->user->name ?? 'Guest' }}</td>
                            <td>Rp {{ number_format($order->total_harga, 0, ',', '.') }}</td>
                            <td>
                                <span class="badge badge-{{ $order->status == 'selesai' ? 'success' : ($order->status == 'pending' ? 'warning' : 'danger') }}">
                                    {{ ucfirst($order->status) }}
                                </span>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="text-center">Tidak ada data pesanan untuk periode ini</td>
                        </tr>
                        @endforelse
                    </tbody>
                    <tfoot>
                        <tr>
                            <th colspan="4" class="text-right">Total</th>
                            <th>Rp {{ number_format($totalPendapatan, 0, ',', '.') }}</th>
                            <th>{{ $totalPesanan }} Pesanan</th>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>
</div>

<style>
@media print {
    .btn-group, .form-inline, .card-header .mb-0 {
        display: none !important;
    }
    .card {
        border: none !important;
        box-shadow: none !important;
    }
    .badge {
        border: 1px solid #000 !important;
    }
}
</style>
@endsection