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

    // ============ ADMIN DASHBOARD ============
    public function adminDashboard()
    {
        $user = Auth::user();
        $idCatering = $user->id_catering;

        // CEK: kalo id_catering NULL, kasih data kosong
        if (is_null($idCatering)) {
            return view('admin.dashboard', [
                'totalPesanan' => 0,
                'totalPendapatan' => 0,
                'totalPending' => 0,
                'totalSelesai' => 0,
                'labelsPendapatan' => [],
                'dataPendapatan' => [],
                'labelsStatus' => ['Pending', 'Diproses', 'Selesai', 'Batal'],
                'dataStatus' => [0, 0, 0, 0],
                'pesananTerbaru' => [],
                'catering' => null
            ]);
        }

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

        // ===== GRAFIK HARIAN (7 HARI TERAKHIR) =====
        // Logika ini sudah benar: Ambil data sum per tanggal dari 7 hari terakhir
        $pendapatanHarian = Pesanan::where('id_catering', $idCatering)
            ->where('status_pesanan', 'Selesai')
            ->select(
                DB::raw('DATE(tanggal_pesanan) as tanggal'),
                DB::raw('SUM(total_harga) as total_pendapatan')
            )
            ->where('tanggal_pesanan', '>=', now()->subDays(7)->startOfDay())
            ->groupBy('tanggal')
            ->orderBy('tanggal', 'asc')
            ->get();

        $labelsPendapatan = [];
        $dataPendapatan = [];
        
        // Buat 7 hari terakhir (termasuk hari ini)
        for ($i = 6; $i >= 0; $i--) {
            $tanggal = now()->subDays($i)->format('Y-m-d');
            $labelsPendapatan[] = now()->subDays($i)->format('d M');
            
            // Cari data untuk tanggal ini
            $found = $pendapatanHarian->firstWhere('tanggal', $tanggal);
            $dataPendapatan[] = $found ? (int) $found->total_pendapatan : 0;
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

        // ==========================================
        // 4. Pesanan terbaru (DIUBAH SESUAI REQUEST ANDA)
        // ==========================================
        // Sekarang diurutkan berdasarkan ID terbesar (desc), bukan tanggal acak
        $pesananTerbaru = Pesanan::where('id_catering', $idCatering)
            ->orderBy('id', 'desc') 
            ->limit(10)
            ->get();

        $catering = Catering::where('id', $idCatering)->first();

        return view('admin.dashboard', [
            'totalPesanan' => $totalPesanan,
            'totalPendapatan' => $totalPendapatan,
            'totalPending' => $totalPending,
            'totalSelesai' => $totalSelesai,
            'labelsPendapatan' => $labelsPendapatan,
            'dataPendapatan' => $dataPendapatan,
            'labelsStatus' => $labelsStatus,
            'dataStatus' => $dataStatus,
            'pesananTerbaru' => $pesananTerbaru,
            'catering' => $catering
        ]);
    }

    // ============ SUPERADMIN DASHBOARD ============
    public function superadminDashboard()
    {
        $totalPesanan = Pesanan::count();
        $totalPendapatan = Pesanan::where('status_pesanan', 'Selesai')->sum('total_harga');
        $totalCatering = Catering::count();
        $totalPengguna = User::count();

        // ===== GRAFIK HARIAN (7 HARI TERAKHIR) =====
        $pendapatanHarian = Pesanan::where('status_pesanan', 'Selesai')
            ->select(
                DB::raw('DATE(tanggal_pesanan) as tanggal'),
                DB::raw('SUM(total_harga) as total_pendapatan')
            )
            ->where('tanggal_pesanan', '>=', now()->subDays(7)->startOfDay())
            ->groupBy('tanggal')
            ->orderBy('tanggal', 'asc')
            ->get();

        $labelsPendapatan = [];
        $dataPendapatan = [];
        for ($i = 6; $i >= 0; $i--) {
            $tanggal = now()->subDays($i)->format('Y-m-d');
            $labelsPendapatan[] = now()->subDays($i)->format('d M');
            $found = $pendapatanHarian->firstWhere('tanggal', $tanggal);
            $dataPendapatan[] = $found ? (int) $found->total_pendapatan : 0;
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

        return view('superadmin.dashboard', [
            'totalPesanan' => $totalPesanan,
            'totalPendapatan' => $totalPendapatan,
            'totalCatering' => $totalCatering,
            'totalPengguna' => $totalPengguna,
            'labelsPendapatan' => $labelsPendapatan,
            'dataPendapatan' => $dataPendapatan,
            'labelsStatus' => $labelsStatus,
            'dataStatus' => $dataStatus,
            'labelsTopCatering' => $labelsTopCatering,
            'dataTopCatering' => $dataTopCatering
        ]);
    }

    // ============ USER DASHBOARD ============
    public function userDashboard()
    {
        $user = Auth::user();
        
        $totalPesanan = Pesanan::where('id_pelanggan', $user->id)->count();
        $totalSelesai = Pesanan::where('id_pelanggan', $user->id)
            ->where('status_pesanan', 'Selesai')
            ->count();
        $totalBelanja = Pesanan::where('id_pelanggan', $user->id)
            ->where('status_pesanan', 'Selesai')
            ->sum('total_harga');
        
        $pesanan = Pesanan::where('id_pelanggan', $user->id)
            ->with('catering')
            ->orderBy('tanggal_pesanan', 'desc')
            ->limit(5)
            ->get();

        return view('user.dashboard', [
            'totalPesanan' => $totalPesanan,
            'totalSelesai' => $totalSelesai,
            'totalBelanja' => $totalBelanja,
            'pesanan' => $pesanan
        ]);
    }
}