<!DOCTYPE html>
<html>
<head>
    <title>Laporan Penjualan - {{ date('F Y', mktime(0, 0, 0, $bulan, 1, $tahun)) }}</title>
    <style>
        body {
            font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif;
            padding: 30px;
            color: #333;
            background-color: #fff;
            line-height: 1.4;
        }
        .header {
            text-align: center;
            margin-bottom: 30px;
            border-bottom: 3px double #ddd;
            padding-bottom: 20px;
        }
        .header h1 {
            margin: 0;
            font-size: 24px;
            color: #111;
            text-transform: uppercase;
            letter-spacing: 1px;
        }
        .header p {
            margin: 5px 0;
            color: #666;
            font-size: 14px;
        }
        .meta-info {
            margin-bottom: 20px;
            font-size: 14px;
        }
        .meta-info table {
            width: auto;
            margin-top: 0;
        }
        .meta-info td {
            border: none;
            padding: 4px 8px;
        }
        .meta-info td:first-child {
            font-weight: bold;
            color: #666;
            padding-left: 0;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 15px;
            font-size: 13px;
        }
        table th {
            background-color: #f8f9fa;
            border: 1px solid #e2e8f0;
            padding: 10px;
            text-align: left;
            font-weight: bold;
            color: #4a5568;
        }
        table td {
            border: 1px solid #e2e8f0;
            padding: 10px;
            color: #2d3748;
        }
        .footer {
            margin-top: 50px;
            display: flex;
            justify-content: space-between;
            font-size: 12px;
            color: #718096;
            border-top: 1px solid #e2e8f0;
            padding-top: 15px;
        }
        .badge {
            display: inline-block;
            padding: 2px 8px;
            border-radius: 9999px;
            font-size: 11px;
            font-weight: bold;
            text-transform: uppercase;
        }
        .badge-Selesai {
            background-color: #def7ec;
            color: #03543f;
        }
        .badge-Pending {
            background-color: #fdf6b2;
            color: #723b13;
        }
        .badge-Diproses {
            background-color: #e1effe;
            color: #1e429f;
        }
        .badge-Batal {
            background-color: #fde8e8;
            color: #9b1c1c;
        }
        .total-row {
            font-weight: bold;
            background-color: #f8f9fa;
        }
        @media print {
            .no-print {
                display: none;
            }
            body {
                padding: 0;
            }
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>LAPORAN PENJUALAN CATERING</h1>
        <p class="store-name" style="font-size: 18px; font-weight: bold; color: #F59E0B; margin-top: 5px;">{{ $catering->nama_catering ?? 'Mitra Catering' }}</p>
        <p>Periode Laporan: {{ date('F Y', mktime(0, 0, 0, $bulan, 1, $tahun)) }}</p>
    </div>

    <div class="meta-info">
        <table>
            <tr>
                <td>Total Pesanan:</td>
                <td>{{ $totalPesanan }} pesanan</td>
            </tr>
            <tr>
                <td>Total Pendapatan Selesai:</td>
                <td style="color: #6B8E23; font-weight: bold;">Rp {{ number_format($totalPendapatan, 0, ',', '.') }}</td>
            </tr>
            <tr>
                <td>Tanggal Cetak:</td>
                <td>{{ now()->format('d/m/Y H:i') }}</td>
            </tr>
        </table>
    </div>

    <table>
        <thead>
            <tr>
                <th style="width: 5%;">No</th>
                <th style="width: 15%;">ID Pesanan</th>
                <th style="width: 25%;">Tanggal Pemesanan</th>
                <th style="width: 25%;">Pelanggan</th>
                <th style="width: 15%;">Total Harga</th>
                <th style="width: 15%; text-align: center;">Status</th>
            </tr>
        </thead>
        <tbody>
            @forelse($pesanan as $index => $order)
            <tr>
                <td>{{ $index + 1 }}</td>
                <td style="font-weight: bold;">#ORD-{{ str_pad($order->id, 5, '0', STR_PAD_LEFT) }}</td>
                <td>{{ date('d/m/Y H:i', strtotime($order->tanggal_pesanan)) }}</td>
                <td>{{ $order->pelanggan->username ?? 'Guest' }}</td>
                <td style="font-weight: bold;">Rp {{ number_format($order->total_harga, 0, ',', '.') }}</td>
                <td style="text-align: center;">
                    <span class="badge badge-{{ $order->status_pesanan }}">
                        {{ $order->status_pesanan }}
                    </span>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="6" style="text-align: center; color: #718096; font-style: italic;">Tidak ada data transaksi untuk periode ini</td>
            </tr>
            @endforelse
        </tbody>
        @if($pesanan->count() > 0)
        <tfoot>
            <tr class="total-row">
                <td colspan="4" style="text-align: right; padding-right: 15px;">Total Pendapatan Selesai</td>
                <td style="color: #6B8E23;">Rp {{ number_format($totalPendapatan, 0, ',', '.') }}</td>
                <td style="text-align: center; font-size: 11px; color: #718096;">{{ $totalPesanan }} Pesanan</td>
            </tr>
        </tfoot>
        @endif
    </table>

    <div class="footer">
        <div>
            <p>Dicetak oleh: <strong>{{ auth()->user()->username }}</strong></p>
        </div>
        <div>
            <p>Catering MBG Platform &copy; {{ date('Y') }}</p>
        </div>
    </div>

    <div class="no-print" style="margin-top: 35px; text-align: center;">
        <button onclick="window.print()" style="padding: 12px 30px; background: #F59E0B; color: white; border: none; border-radius: 8px; font-weight: bold; font-size: 14px; cursor: pointer; box-shadow: 0 4px 6px -1px rgba(0,0,0,0.1); transition: all 0.2s;">
            🖨️ Cetak Laporan / Simpan PDF
        </button>
        <button onclick="window.close()" style="padding: 12px 30px; background: #cbd5e1; color: #475569; border: none; border-radius: 8px; font-weight: bold; font-size: 14px; cursor: pointer; margin-left: 10px; transition: all 0.2s;">
            ✕ Tutup Halaman
        </button>
    </div>
</body>
</html>