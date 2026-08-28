@extends('layouts.superadmin')

@section('content')
<!-- Page Header -->
<div class="flex justify-between items-center mb-6">
    <div>
        <h2 class="text-2xl font-bold text-gray-800">Dashboard Superadmin</h2>
        <p class="text-sm text-gray-500">Statistik agregat seluruh platform catering</p>
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
                <p class="text-sm text-gray-500 font-medium">Total Pendapatan</p>
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
                <p class="text-sm text-gray-500 font-medium">Total Catering</p>
                <p class="text-3xl font-bold text-gray-800 mt-1">{{ $totalCatering ?? 0 }}</p>
            </div>
            <div class="bg-blue-100 p-3 rounded-lg">
                <i class="fas fa-store text-blue-600 text-xl"></i>
            </div>
        </div>
    </div>
    <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-100 hover:shadow-md transition">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm text-gray-500 font-medium">Total Pengguna</p>
                <p class="text-3xl font-bold text-gray-800 mt-1">{{ $totalPengguna ?? 0 }}</p>
            </div>
            <div class="bg-purple-100 p-3 rounded-lg">
                <i class="fas fa-users text-purple-600 text-xl"></i>
            </div>
        </div>
    </div>
</div>

<!-- Charts -->
<div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-8">
    <div class="lg:col-span-2 bg-white rounded-xl shadow-sm p-6 border border-gray-100">
        <h3 class="font-semibold text-gray-700 mb-4">📈 Pendapatan Harian Seluruh Platform (7 Hari Terakhir)</h3>
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

<!-- Top 10 Catering -->
<div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
    <div class="px-6 py-4 border-b border-gray-100">
        <h3 class="font-semibold text-gray-700">🏆 Top 10 Catering dengan Pendapatan Tertinggi</h3>
    </div>
    <div class="p-6">
        <div style="position: relative; height: 240px;">
            <canvas id="chartTopCatering"></canvas>
        </div>
        @if(empty($labelsTopCatering) || count($labelsTopCatering) == 0)
        <div class="text-center text-gray-400 text-sm mt-2">Belum ada data catering</div>
        @endif
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    var labelsPendapatan = <?php echo json_encode($labelsPendapatan ?? []); ?>;
    var dataPendapatan = <?php echo json_encode($dataPendapatan ?? []); ?>;
    var dataStatus = <?php echo json_encode($dataStatus ?? [0, 0, 0, 0]); ?>;
    var labelsTopCatering = <?php echo json_encode($labelsTopCatering ?? []); ?>;
    var dataTopCatering = <?php echo json_encode($dataTopCatering ?? []); ?>;

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
                borderColor: '#28a745',
                backgroundColor: 'rgba(40, 167, 69, 0.1)',
                borderWidth: 3,
                fill: true,
                tension: 0.3,
                pointRadius: 5,
                pointBackgroundColor: '#28a745'
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

    // Chart Top Catering
    var ctx3 = document.getElementById('chartTopCatering').getContext('2d');
    if (labelsTopCatering.length === 0) {
        labelsTopCatering = ['Tidak ada data'];
        dataTopCatering = [0];
    }
    new Chart(ctx3, {
        type: 'bar',
        data: {
            labels: labelsTopCatering,
            datasets: [{
                label: 'Pendapatan (Rp)',
                data: dataTopCatering,
                backgroundColor: 'rgba(54, 162, 235, 0.8)',
                borderColor: 'rgba(54, 162, 235, 1)',
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: { legend: { display: false } },
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: { callback: function(v) { return 'Rp ' + v.toLocaleString('id-ID'); } }
                }
            }
        }
    });
</script>
@endsection