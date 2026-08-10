@extends('layouts.admin')

@section('admin_content')
<!-- Page Header -->
<div class="flex justify-between items-center mb-6">
    <div>
        <h2 class="text-2xl font-bold text-gray-800">Dashboard</h2>
        <p class="text-sm text-gray-500">Selamat datang kembali, {{ Auth::user()->username }}!</p>
    </div>
    <div class="text-sm text-gray-500">
        {{ now()->format('l, d F Y') }}
    </div>
</div>

<!-- Stats Cards -->
<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
    <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-100 hover:shadow-md transition">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm text-gray-500 font-medium">Total Pesanan</p>
                <p class="text-3xl font-bold text-gray-800 mt-1">{{ $totalPesanan ?? 0 }}</p>
            </div>
            <div class="bg-orange-100 p-3 rounded-lg">
                <i class="fas fa-shopping-cart text-orange-600 text-xl"></i>
            </div>
        </div>
    </div>
    <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-100 hover:shadow-md transition">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm text-gray-500 font-medium">Pendapatan</p>
                <p class="text-3xl font-bold text-gray-800 mt-1">Rp {{ number_format($totalPendapatan ?? 0, 0, ',', '.') }}</p>
            </div>
            <div class="bg-green-100 p-3 rounded-lg">
                <i class="fas fa-money-bill-wave text-green-600 text-xl"></i>
            </div>
        </div>
    </div>
    <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-100 hover:shadow-md transition">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm text-gray-500 font-medium">Pending</p>
                <p class="text-3xl font-bold text-gray-800 mt-1">{{ $totalPending ?? 0 }}</p>
            </div>
            <div class="bg-yellow-100 p-3 rounded-lg">
                <i class="fas fa-clock text-yellow-600 text-xl"></i>
            </div>
        </div>
    </div>
    <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-100 hover:shadow-md transition">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm text-gray-500 font-medium">Selesai</p>
                <p class="text-3xl font-bold text-gray-800 mt-1">{{ $totalSelesai ?? 0 }}</p>
            </div>
            <div class="bg-blue-100 p-3 rounded-lg">
                <i class="fas fa-check-circle text-blue-600 text-xl"></i>
            </div>
        </div>
    </div>
</div>

<!-- Charts -->
<div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-8">
    <div class="lg:col-span-2 bg-white rounded-xl shadow-sm p-6 border border-gray-100">
        <h3 class="font-semibold text-gray-700 mb-4">📈 Pendapatan Harian (7 Hari Terakhir)</h3>
        <div style="position: relative; height: 260px;">
            <canvas id="chartPendapatan"></canvas>
        </div>
        @if(empty($labelsPendapatan) || count($labelsPendapatan) == 0)
        <div class="text-center text-gray-400 text-sm mt-2">Belum ada data pendapatan</div>
        @endif
    </div>
    <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-100">
        <h3 class="font-semibold text-gray-700 mb-4">🍩 Status Pesanan</h3>
        <div style="position: relative; height: 260px;">
            <canvas id="chartStatus"></canvas>
        </div>
        @if(array_sum($dataStatus ?? []) == 0)
        <div class="text-center text-gray-400 text-sm mt-2">Belum ada data pesanan</div>
        @endif
    </div>
</div>

<!-- Recent Orders -->
<div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
    <div class="px-6 py-4 border-b border-gray-100 flex justify-between items-center">
        <h3 class="font-semibold text-gray-700">📋 Pesanan Terbaru</h3>
        <a href="{{ route('admin.orders.index') }}" class="text-sm text-primary hover:underline">Lihat semua →</a>
    </div>
    <div class="overflow-x-auto">
        <table class="w-full text-sm">
            <thead>
                <tr class="bg-gray-50 text-left">
                    <th class="p-4 font-semibold text-gray-600">ID</th>
                    <th class="p-4 font-semibold text-gray-600">Tanggal</th>
                    <th class="p-4 font-semibold text-gray-600">Pelanggan</th>
                    <th class="p-4 font-semibold text-gray-600">Total</th>
                    <th class="p-4 font-semibold text-gray-600">Status</th>
                    <th class="p-4 font-semibold text-gray-600">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($pesananTerbaru ?? [] as $order)
                <tr class="border-t border-gray-100 hover:bg-gray-50 transition">
                    <td class="p-4 font-medium">#{{ $order->id }}</td>
                    <td class="p-4">{{ \Carbon\Carbon::parse($order->tanggal_pesanan)->format('d/m/Y H:i') }}</td>
                    <td class="p-4">{{ $order->pelanggan->username ?? 'Guest' }}</td>
                    <td class="p-4 font-medium">Rp {{ number_format($order->total_harga, 0, ',', '.') }}</td>
                    <td class="p-4">
                        <span class="px-2 py-1 text-xs rounded-full 
                            {{ $order->status_pesanan == 'Selesai' ? 'bg-green-100 text-green-800' : 
                               ($order->status_pesanan == 'Pending' ? 'bg-yellow-100 text-yellow-800' : 
                               ($order->status_pesanan == 'Diproses' ? 'bg-blue-100 text-blue-800' : 'bg-red-100 text-red-800')) }}">
                            {{ $order->status_pesanan }}
                        </span>
                    </td>
                    <td class="p-4">
                        <a href="{{ route('admin.orders.show', $order->id) }}" class="text-primary hover:underline text-xs font-medium">
                            Detail
                        </a>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="p-8 text-center text-gray-400">Belum ada pesanan</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    var labelsPendapatan = <?php echo json_encode($labelsPendapatan ?? []); ?>;
    var dataPendapatan = <?php echo json_encode($dataPendapatan ?? []); ?>;
    var dataStatus = <?php echo json_encode($dataStatus ?? [0, 0, 0, 0]); ?>;

    // Chart Pendapatan
    var ctx1 = document.getElementById('chartPendapatan').getContext('2d');
    if (labelsPendapatan.length === 0) {
        labelsPendapatan = ['Tidak ada data'];
        dataPendapatan = [0];
    }
    new Chart(ctx1, {
        type: 'line',
        data: {
            labels: labelsPendapatan,
            datasets: [{
                label: 'Pendapatan (Rp)',
                data: dataPendapatan,
                borderColor: '#F59E0B',
                backgroundColor: 'rgba(245, 158, 11, 0.1)',
                borderWidth: 3,
                fill: true,
                tension: 0.3,
                pointRadius: 5,
                pointBackgroundColor: '#F59E0B'
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: { legend: { display: true, position: 'top' } },
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: { callback: function(v) { return 'Rp ' + v.toLocaleString('id-ID'); } }
                }
            }
        }
    });

    // Chart Status
    var ctx2 = document.getElementById('chartStatus').getContext('2d');
    var totalStatus = dataStatus.reduce((a, b) => a + b, 0);
    if (totalStatus === 0) {
        dataStatus = [1];
        var statusLabels = ['Belum ada data'];
        var statusColors = ['#e5e7eb'];
    } else {
        var statusLabels = ['Pending', 'Diproses', 'Selesai', 'Batal'];
        var statusColors = ['#ffc107', '#17a2b8', '#28a745', '#dc3545'];
    }
    new Chart(ctx2, {
        type: 'doughnut',
        data: {
            labels: statusLabels,
            datasets: [{
                data: dataStatus,
                backgroundColor: statusColors,
                borderWidth: 2,
                borderColor: '#fff'
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: { legend: { position: 'bottom' } }
        }
    });
</script>
@endsection