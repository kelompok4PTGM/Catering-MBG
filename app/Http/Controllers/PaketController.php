<?php

namespace App\Http\Controllers;

use App\Models\Catering;
use App\Models\Paket;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PaketController extends Controller
{
    private function getCatering()
    {
        return Catering::where('id_admin', Auth::id())->first();
    }

    public function index()
    {
        $catering = $this->getCatering();
        if (!$catering) {
            return redirect()->route('dashboard')->with('error', 'Silakan lengkapi profil catering Anda terlebih dahulu.');
        }

        $pakets = Paket::where('id_catering', $catering->id)->get();
        return view('admin.paket.index', compact('pakets', 'catering'));
    }

    public function create()
    {
        $catering = $this->getCatering();
        if (!$catering) {
            return redirect()->route('dashboard')->with('error', 'Silakan lengkapi profil catering Anda terlebih dahulu.');
        }

        return view('admin.paket.form', compact('catering'));
    }

    public function store(Request $request)
    {
        $catering = $this->getCatering();
        if (!$catering) {
            return redirect()->route('dashboard')->with('error', 'Silakan lengkapi profil catering Anda terlebih dahulu.');
        }

        $request->validate([
            'nama_paket' => 'required|string|max:100',
            'harga' => 'required|numeric|gt:0',
        ]);

        Paket::create([
            'id_catering' => $catering->id,
            'nama_paket' => $request->nama_paket,
            'harga' => $request->harga,
        ]);

        return redirect()->route('paket.index')->with('success', 'Paket berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $catering = $this->getCatering();
        if (!$catering) {
            return redirect()->route('dashboard')->with('error', 'Silakan lengkapi profil catering Anda terlebih dahulu.');
        }

        $paket = Paket::where('id', $id)->where('id_catering', $catering->id)->firstOrFail();

        return view('admin.paket.form', compact('paket', 'catering'));
    }

    public function update(Request $request, $id)
    {
        $catering = $this->getCatering();
        if (!$catering) {
            return redirect()->route('dashboard')->with('error', 'Silakan lengkapi profil catering Anda terlebih dahulu.');
        }

        $paket = Paket::where('id', $id)->where('id_catering', $catering->id)->firstOrFail();

        $request->validate([
            'nama_paket' => 'required|string|max:100',
            'harga' => 'required|numeric|gt:0',
        ]);

        $paket->update([
            'nama_paket' => $request->nama_paket,
            'harga' => $request->harga,
        ]);

        return redirect()->route('paket.index')->with('success', 'Paket berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $catering = $this->getCatering();
        if (!$catering) {
            return redirect()->route('dashboard')->with('error', 'Silakan lengkapi profil catering Anda terlebih dahulu.');
        }

        $paket = Paket::where('id', $id)->where('id_catering', $catering->id)->firstOrFail();
        $paket->delete();

        return redirect()->route('paket.index')->with('success', 'Paket berhasil dihapus.');
    }
}
