<?php

namespace App\Http\Controllers;

use App\Models\Catering;
use App\Models\DetailPesanan;
use App\Models\Menu;
use App\Models\Paket;
use App\Models\Pembayaran;
use App\Models\Pesanan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    public function checkout()
    {
        $cart = session()->get('cart', []);
        $cateringId = session()->get('cart_catering_id');

        if (empty($cart) || !$cateringId) {
            return redirect()->route('cart.index')->with('error', 'Keranjang Anda masih kosong.');
        }

        $catering = Catering::findOrFail($cateringId);
        $total = 0;

        foreach ($cart as $item) {
            $total += $item['harga'] * $item['jumlah'];
        }

        return view('cart.checkout', compact('cart', 'catering', 'total'));
    }

    public function store(Request $request)
    {
        $cart = session()->get('cart', []);
        $cateringId = session()->get('cart_catering_id');

        if (empty($cart) || !$cateringId) {
            return redirect()->route('cart.index')->with('error', 'Keranjang Anda kosong.');
        }

        $total = 0;
        foreach ($cart as $item) {
            $total += $item['harga'] * $item['jumlah'];
        }

        DB::beginTransaction();
        try {
            // 1. Save Pesanan with id_catering correctly recorded
            $pesanan = Pesanan::create([
                'id_pelanggan' => Auth::id(),
                'id_catering' => $cateringId,
                'tanggal_pesanan' => now(),
                'status_pesanan' => 'Pending',
                'total_harga' => $total,
            ]);

            // 2. Save Detail Pesanan
            foreach ($cart as $item) {
                $subtotal = $item['harga'] * $item['jumlah'];

                DetailPesanan::create([
                    'id_pesanan' => $pesanan->id,
                    'id_menu' => $item['type'] === 'menu' ? $item['id'] : null,
                    'id_paket' => $item['type'] === 'paket' ? $item['id'] : null,
                    'jumlah' => $item['jumlah'],
                    'subtotal' => $subtotal,
                ]);

                // Decrement stock if menu item
                if ($item['type'] === 'menu') {
                    $menu = Menu::find($item['id']);
                    if ($menu && $menu->stok >= $item['jumlah']) {
                        $menu->decrement('stok', $item['jumlah']);
                    }
                }
            }

            DB::commit();

            // Clear session cart
            session()->forget('cart');
            session()->forget('cart_catering_id');

            return redirect()->route('user.orders.show', $pesanan->id)->with('success', 'Pesanan berhasil dibuat! Silakan lanjutkan pembayaran.');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Gagal memproses pesanan: ' . $e->getMessage());
        }
    }

    public function userOrders()
    {
        $orders = Pesanan::with(['catering', 'pembayaran'])
            ->where('id_pelanggan', Auth::id())
            ->orderBy('id', 'desc')
            ->get();

        return view('user.orders.index', compact('orders'));
    }

    public function userOrderDetail($id)
    {
        $order = Pesanan::with(['catering', 'details.menu', 'details.paket', 'pembayaran'])
            ->where('id_pelanggan', Auth::id())
            ->findOrFail($id);

        return view('user.orders.show', compact('order'));
    }

    public function pay(Request $request, $id)
    {
        $request->validate([
            'metode_pembayaran' => 'required|string|max:50',
        ]);

        $order = Pesanan::where('id_pelanggan', Auth::id())->findOrFail($id);

        if ($order->pembayaran) {
            return redirect()->back()->with('error', 'Pesanan ini sudah dibayar.');
        }

        DB::beginTransaction();
        try {
            // Create payment
            Pembayaran::create([
                'id_pesanan' => $order->id,
                'tanggal_bayar' => now(),
                'metode_pembayaran' => $request->metode_pembayaran,
                'jumlah_bayar' => $order->total_harga,
                'status_pembayaran' => 'Berhasil',
            ]);

            // Update order status to Diproses
            $order->update([
                'status_pesanan' => 'Diproses',
            ]);

            DB::commit();

            return redirect()->route('user.orders.show', $order->id)->with('success', 'Pembayaran berhasil dilakukan! Pesanan Anda sedang diproses.');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Gagal memproses pembayaran: ' . $e->getMessage());
        }
    }
}
