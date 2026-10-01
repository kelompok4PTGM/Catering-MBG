<?php

namespace App\Http\Controllers;

use App\Models\Pesanan;
use App\Models\Ulasan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UlasanController extends Controller
{
    public function store(Request $request, $orderId)
    {
        $order = Pesanan::with('ulasan')->where('id_pelanggan', Auth::id())->findOrFail($orderId);

        if ($order->status_pesanan !== 'Selesai') {
            return redirect()->back()->with('error', 'Penilaian hanya dapat diberikan untuk pesanan yang sudah selesai.');
        }

        if ($order->ulasan) {
            return redirect()->back()->with('error', 'Anda sudah memberikan penilaian untuk pesanan ini.');
        }

        $request->validate([
            'rating' => 'required|integer|min:1|max:5',
            'komentar' => 'nullable|string|max:1000',
        ]);

        Ulasan::create([
            'id_pesanan' => $order->id,
            'id_pelanggan' => Auth::id(),
            'id_catering' => $order->id_catering,
            'rating' => $request->rating,
            'komentar' => $request->komentar,
        ]);

        return redirect()->back()->with('success', 'Terima kasih! Penilaian dan ulasan Anda berhasil disimpan.');
    }
}
