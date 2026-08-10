<?php

namespace App\Http\Controllers;

use App\Models\Catering;
use App\Models\Menu;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MenuController extends Controller
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

        $menus = Menu::where('id_catering', $catering->id)->get();
        return view('admin.menu.index', compact('menus', 'catering'));
    }

    public function create()
    {
        $catering = $this->getCatering();
        if (!$catering) {
            return redirect()->route('dashboard')->with('error', 'Silakan lengkapi profil catering Anda terlebih dahulu.');
        }

        return view('admin.menu.form', compact('catering'));
    }

    public function store(Request $request)
    {
        $catering = $this->getCatering();
        if (!$catering) {
            return redirect()->route('dashboard')->with('error', 'Silakan lengkapi profil catering Anda terlebih dahulu.');
        }

        $request->validate([
            'kode_menu' => 'required|string|max:20|unique:menu,kode_menu',
            'nama_menu' => 'required|string|max:100',
            'harga' => 'required|numeric|gt:0',
            'stok' => 'required|integer|min:0',
        ]);

        Menu::create([
            'id_catering' => $catering->id,
            'kode_menu' => $request->kode_menu,
            'nama_menu' => $request->nama_menu,
            'harga' => $request->harga,
            'stok' => $request->stok,
        ]);

        return redirect()->route('menu.index')->with('success', 'Menu berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $catering = $this->getCatering();
        if (!$catering) {
            return redirect()->route('dashboard')->with('error', 'Silakan lengkapi profil catering Anda terlebih dahulu.');
        }

        $menu = Menu::where('id', $id)->where('id_catering', $catering->id)->firstOrFail();

        return view('admin.menu.form', compact('menu', 'catering'));
    }

    public function update(Request $request, $id)
    {
        $catering = $this->getCatering();
        if (!$catering) {
            return redirect()->route('dashboard')->with('error', 'Silakan lengkapi profil catering Anda terlebih dahulu.');
        }

        $menu = Menu::where('id', $id)->where('id_catering', $catering->id)->firstOrFail();

        $request->validate([
            'kode_menu' => 'required|string|max:20|unique:menu,kode_menu,' . $menu->id,
            'nama_menu' => 'required|string|max:100',
            'harga' => 'required|numeric|gt:0',
            'stok' => 'required|integer|min:0',
        ]);

        $menu->update([
            'kode_menu' => $request->kode_menu,
            'nama_menu' => $request->nama_menu,
            'harga' => $request->harga,
            'stok' => $request->stok,
        ]);

        return redirect()->route('menu.index')->with('success', 'Menu berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $catering = $this->getCatering();
        if (!$catering) {
            return redirect()->route('dashboard')->with('error', 'Silakan lengkapi profil catering Anda terlebih dahulu.');
        }

        $menu = Menu::where('id', $id)->where('id_catering', $catering->id)->firstOrFail();
        $menu->delete();

        return redirect()->route('menu.index')->with('success', 'Menu berhasil dihapus.');
    }
}
