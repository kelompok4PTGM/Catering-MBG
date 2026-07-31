<?php

namespace App\Http\Controllers;

use App\Models\Catering;
use App\Models\Menu;
use App\Models\Paket;
use Illuminate\Http\Request;

class CartController extends Controller
{
    public function index()
    {
        $cart = session()->get('cart', []);
        $cateringId = session()->get('cart_catering_id');
        $catering = $cateringId ? Catering::find($cateringId) : null;

        $total = 0;
        foreach ($cart as $item) {
            $total += $item['harga'] * $item['jumlah'];
        }

        return view('cart.index', compact('cart', 'catering', 'total'));
    }

    public function add(Request $request)
    {
        $request->validate([
            'type' => 'required|in:menu,paket',
            'id' => 'required|integer',
            'jumlah' => 'required|integer|min:1',
        ]);

        $type = $request->type;
        $id = $request->id;
        $jumlah = (int) $request->jumlah;

        if ($type === 'menu') {
            $item = Menu::findOrFail($id);
            $nama = $item->nama_menu;
            $harga = $item->harga;
            $cateringId = $item->id_catering;
        } else {
            $item = Paket::findOrFail($id);
            $nama = $item->nama_paket;
            $harga = $item->harga;
            $cateringId = $item->id_catering;
        }

        $currentCateringId = session()->get('cart_catering_id');

        // Cart constraint: items must be from the same catering
        if ($currentCateringId && $currentCateringId != $cateringId && count(session()->get('cart', [])) > 0) {
            return redirect()->back()->with('error', 'Keranjang Anda berisi menu dari catering lain. Selesaikan pesanan atau kosongkan keranjang terlebih dahulu.');
        }

        $cart = session()->get('cart', []);
        $key = $type . '_' . $id;

        if (isset($cart[$key])) {
            $cart[$key]['jumlah'] += $jumlah;
        } else {
            $cart[$key] = [
                'type' => $type,
                'id' => $id,
                'nama' => $nama,
                'harga' => $harga,
                'jumlah' => $jumlah,
                'id_catering' => $cateringId,
            ];
        }

        session()->put('cart', $cart);
        session()->put('cart_catering_id', $cateringId);

        return redirect()->back()->with('success', 'Item berhasil ditambahkan ke keranjang!');
    }

    public function update(Request $request)
    {
        $request->validate([
            'key' => 'required|string',
            'jumlah' => 'required|integer|min:1',
        ]);

        $cart = session()->get('cart', []);
        $key = $request->key;

        if (isset($cart[$key])) {
            $cart[$key]['jumlah'] = (int) $request->jumlah;
            session()->put('cart', $cart);
            return redirect()->route('cart.index')->with('success', 'Jumlah pesanan berhasil diperbarui.');
        }

        return redirect()->route('cart.index')->with('error', 'Item tidak ditemukan.');
    }

    public function remove($key)
    {
        $cart = session()->get('cart', []);

        if (isset($cart[$key])) {
            unset($cart[$key]);
            session()->put('cart', $cart);

            if (empty($cart)) {
                session()->forget('cart_catering_id');
            }

            return redirect()->route('cart.index')->with('success', 'Item berhasil dihapus dari keranjang.');
        }

        return redirect()->route('cart.index')->with('error', 'Item tidak ditemukan.');
    }

    public function clear()
    {
        session()->forget('cart');
        session()->forget('cart_catering_id');

        return redirect()->route('cart.index')->with('success', 'Keranjang berhasil dikosongkan.');
    }
}
