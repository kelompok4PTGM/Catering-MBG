<?php

namespace App\Http\Controllers;

use App\Models\Pesanan;
use App\Models\Catering;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    public function index()
    {
        $caterings = DB::table('catering')->where('status', 'Aktif')->get();
        return view('home', compact('caterings'));
    }

    public function dashboard()
    {
        $role = Auth::user()->role;
        
        if ($role === 'Superadmin') {
            return redirect()->route('superadmin.dashboard');
        } elseif ($role === 'Admin') {
            return redirect()->route('admin.dashboard');
        } else {
            return redirect()->route('user.dashboard');
        }
    }

    // ============ SUPERADMIN DASHBOARD WITH GRAFIK ============
    public function superadminDashboard()
    {
        // 1. Statistik
        $totalPesanan = Pesanan::count();
        $totalPendapatan = Pesanan::where('status_pesanan', 'Selesai')->sum('total_harga');
        $totalCatering = Catering::count();
        $totalPengguna = User::count();

        // 2. Grafik pendapatan bulanan (6 bulan)
        $pendapatanBulanan = Pesanan::where('status_pesanan', 'Selesai')
            ->select(
                DB::raw('MONTH(tanggal_pesanan) as bulan'),
                DB::raw('YEAR(tanggal_pesanan) as tahun'),
                DB::raw('SUM(total_harga) as total_pendapatan')
            )
            ->where('tanggal_pesanan', '>=', now()->subMonths(6)->startOfMonth())
            ->groupBy('tahun', 'bulan')
            ->orderBy('tahun', 'asc')
            ->orderBy('bulan', 'asc')
            ->get();

        $labelsPendapatan = [];
        $dataPendapatan = [];
        foreach ($pendapatanBulanan as $item) {
            $labelsPendapatan[] = date('F Y', mktime(0, 0, 0, $item->bulan, 1, $item->tahun));
            $dataPendapatan[] = (int) $item->total_pendapatan;
        }

        // 3. Grafik status
        $statusPesanan = Pesanan::select('status_pesanan', DB::raw('count(*) as total'))
            ->groupBy('status_pesanan')
            ->pluck('total', 'status_pesanan')
            ->toArray();

        $labelsStatus = ['Pending', 'Diproses', 'Selesai', 'Batal'];
        $dataStatus = [];
        foreach ($labelsStatus as $status) {
            $dataStatus[] = $statusPesanan[$status] ?? 0;
        }

        // 4. Top 10 Catering
        $topCatering = Catering::select('catering.nama_catering', DB::raw('SUM(pesanan.total_harga) as total_pendapatan'))
            ->join('pesanan', 'catering.id', '=', 'pesanan.id_catering')
            ->where('pesanan.status_pesanan', 'Selesai')
            ->groupBy('catering.id', 'catering.nama_catering')
            ->orderByDesc('total_pendapatan')
            ->limit(10)
            ->get();

        $labelsTopCatering = $topCatering->pluck('nama_catering')->toArray();
        $dataTopCatering = $topCatering->pluck('total_pendapatan')->map(function($item) {
            return (int) $item;
        })->toArray();

        return view('superadmin.dashboard', compact(
            'totalPesanan',
            'totalPendapatan',
            'totalCatering',
            'totalPengguna',
            'labelsPendapatan',
            'dataPendapatan',
            'labelsStatus',
            'dataStatus',
            'labelsTopCatering',
            'dataTopCatering'
        ));
    }

    // ============ ADMIN DASHBOARD WITH GRAFIK ============
    public function adminDashboard()
    {
        $user = Auth::user();
        $idCatering = $user->id_catering;

        // 1. Statistik
        $totalPesanan = Pesanan::where('id_catering', $idCatering)->count();
        $totalPendapatan = Pesanan::where('id_catering', $idCatering)
            ->where('status_pesanan', 'Selesai')
            ->sum('total_harga');
        $totalPending = Pesanan::where('id_catering', $idCatering)
            ->where('status_pesanan', 'Pending')
            ->count();
        $totalSelesai = Pesanan::where('id_catering', $idCatering)
            ->where('status_pesanan', 'Selesai')
            ->count();

        // 2. Grafik pendapatan bulanan (6 bulan)
        $pendapatanBulanan = Pesanan::where('id_catering', $idCatering)
            ->where('status_pesanan', 'Selesai')
            ->select(
                DB::raw('MONTH(tanggal_pesanan) as bulan'),
                DB::raw('YEAR(tanggal_pesanan) as tahun'),
                DB::raw('SUM(total_harga) as total_pendapatan')
            )
            ->where('tanggal_pesanan', '>=', now()->subMonths(6)->startOfMonth())
            ->groupBy('tahun', 'bulan')
            ->orderBy('tahun', 'asc')
            ->orderBy('bulan', 'asc')
            ->get();

        $labelsPendapatan = [];
        $dataPendapatan = [];
        foreach ($pendapatanBulanan as $item) {
            $labelsPendapatan[] = date('F Y', mktime(0, 0, 0, $item->bulan, 1, $item->tahun));
            $dataPendapatan[] = (int) $item->total_pendapatan;
        }

        // 3. Grafik status
        $statusPesanan = Pesanan::where('id_catering', $idCatering)
            ->select('status_pesanan', DB::raw('count(*) as total'))
            ->groupBy('status_pesanan')
            ->pluck('total', 'status_pesanan')
            ->toArray();

        $labelsStatus = ['Pending', 'Diproses', 'Selesai', 'Batal'];
        $dataStatus = [];
        foreach ($labelsStatus as $status) {
            $dataStatus[] = $statusPesanan[$status] ?? 0;
        }

        // 4. Pesanan terbaru (5 data)
        $pesananTerbaru = Pesanan::where('id_catering', $idCatering)
            ->orderBy('tanggal_pesanan', 'desc')
            ->limit(5)
            ->get();

        // 5. Data catering
        $catering = Catering::where('id', $idCatering)->first();

        return view('admin.dashboard', compact(
            'totalPesanan',
            'totalPendapatan',
            'totalPending',
            'totalSelesai',
            'labelsPendapatan',
            'dataPendapatan',
            'labelsStatus',
            'dataStatus',
            'pesananTerbaru',
            'catering'
        ));
    }

    public function userDashboard()
    {
        $user = Auth::user();
        
        $totalPesanan = Pesanan::where('id_pelanggan', $user->id)->count();
        $totalSelesai = Pesanan::where('id_pelanggan', $user->id)
            ->where('status_pesanan', 'Selesai')
            ->count();
        
        $pesanan = Pesanan::where('id_pelanggan', $user->id)
            ->orderBy('tanggal_pesanan', 'desc')
            ->limit(5)
            ->get();

        return view('user.dashboard', compact(
            'totalPesanan',
            'totalSelesai',
            'pesanan'
        ));
    }
}