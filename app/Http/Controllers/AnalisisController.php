<?php

namespace App\Http\Controllers;

use App\Models\Pesanan;
use App\Models\Catering;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\StreamedResponse;

class AnalisisController extends Controller
{
    public function laporanAdmin(Request $request)
    {
        $bulan = $request->get('bulan', now()->month);
        $tahun = $request->get('tahun', now()->year);
        $idCatering = Auth::user()->id_catering;

        if (is_null($idCatering)) {
            return redirect()->route('admin.dashboard')->with('error', 'Anda belum terhubung ke mitra catering.');
        }

        $pesanan = Pesanan::with('pelanggan')
            ->where('id_catering', $idCatering)
            ->whereMonth('tanggal_pesanan', $bulan)
            ->whereYear('tanggal_pesanan', $tahun)
            ->orderBy('id', 'desc')
            ->get();

        $totalPesanan = $pesanan->count();
        $totalPendapatan = $pesanan->where('status_pesanan', 'Selesai')->sum('total_harga');

        return view('admin.laporan-penjualan', compact('pesanan', 'totalPesanan', 'totalPendapatan', 'bulan', 'tahun'));
    }

    public function printLaporan(Request $request)
    {
        $bulan = $request->get('bulan', now()->month);
        $tahun = $request->get('tahun', now()->year);
        $idCatering = Auth::user()->id_catering;

        if (is_null($idCatering)) {
            abort(403, 'Catering belum dikonfigurasi.');
        }

        $pesanan = Pesanan::with('pelanggan')
            ->where('id_catering', $idCatering)
            ->whereMonth('tanggal_pesanan', $bulan)
            ->whereYear('tanggal_pesanan', $tahun)
            ->orderBy('id', 'desc')
            ->get();

        $totalPesanan = $pesanan->count();
        $totalPendapatan = $pesanan->where('status_pesanan', 'Selesai')->sum('total_harga');

        $catering = Catering::find($idCatering);

        return view('admin.laporan-print', compact('pesanan', 'totalPesanan', 'totalPendapatan', 'bulan', 'tahun', 'catering'));
    }

    public function exportCsv(Request $request)
    {
        $bulan = $request->get('bulan', now()->month);
        $tahun = $request->get('tahun', now()->year);
        $idCatering = Auth::user()->id_catering;

        if (is_null($idCatering)) {
            abort(403, 'Catering belum dikonfigurasi.');
        }

        $pesanan = Pesanan::with('pelanggan')
            ->where('id_catering', $idCatering)
            ->whereMonth('tanggal_pesanan', $bulan)
            ->whereYear('tanggal_pesanan', $tahun)
            ->orderBy('id', 'desc')
            ->get();

        $response = new StreamedResponse(function () use ($pesanan) {
            $handle = fopen('php://output', 'w');
            
            // Header CSV
            fputcsv($handle, ['No', 'ID Pesanan', 'Tanggal', 'Pelanggan', 'Total Harga (Rp)', 'Status']);

            foreach ($pesanan as $index => $order) {
                fputcsv($handle, [
                    $index + 1,
                    'ORD-' . str_pad($order->id, 5, '0', STR_PAD_LEFT),
                    date('d/m/Y H:i', strtotime($order->tanggal_pesanan)),
                    $order->pelanggan->username ?? 'Guest',
                    (int) $order->total_harga,
                    $order->status_pesanan
                ]);
            }

            fclose($handle);
        });

        $response->headers->set('Content-Type', 'text/csv');
        $response->headers->set('Content-Disposition', 'attachment; filename="Laporan_Penjualan_' . $bulan . '_' . $tahun . '.csv"');

        return $response;
    }
}