<?php

namespace App\Http\Controllers;

use App\Models\Catering;
use App\Models\Pesanan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminOrderController extends Controller
{
    private function getAdminCatering()
    {
        return Catering::where('id_admin', Auth::id())->first();
    }

    public function index()
    {
        $catering = $this->getAdminCatering();

        if (!$catering) {
            return view('admin.orders.index', [
                'orders' => collect(),
                'catering' => null,
                'error' => 'Anda belum memiliki data catering.'
            ]);
        }

        // CRITICAL SECURITY CONSTRAINT: Filter ONLY by current Admin's catering ID
        $orders = Pesanan::with(['pelanggan', 'details.menu', 'details.paket', 'pembayaran'])
            ->where('id_catering', $catering->id)
            ->orderBy('id', 'desc')
            ->get();

        return view('admin.orders.index', compact('orders', 'catering'));
    }

    public function show($id)
    {
        $catering = $this->getAdminCatering();

        if (!$catering) {
            return redirect()->route('admin.orders.index')->with('error', 'Profil Catering belum dibuat.');
        }

        // Ensure Admin ONLY views order belonging to their own catering ID
        $order = Pesanan::with(['pelanggan', 'details.menu', 'details.paket', 'pembayaran'])
            ->where('id_catering', $catering->id)
            ->findOrFail($id);

        return view('admin.orders.show', compact('order', 'catering'));
    }

    public function updateStatus(Request $request, $id)
    {
        $request->validate([
            'status_pesanan' => 'required|in:Pending,Diproses,Selesai,Batal',
        ]);

        $catering = $this->getAdminCatering();

        if (!$catering) {
            return redirect()->route('admin.orders.index')->with('error', 'Akses ditolak.');
        }

        $order = Pesanan::where('id_catering', $catering->id)->findOrFail($id);
        $order->update([
            'status_pesanan' => $request->status_pesanan,
        ]);

        return redirect()->back()->with('success', 'Status pesanan berhasil diperbarui menjadi ' . $request->status_pesanan);
    }
}
