<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Catering;
use App\Models\Pesanan;
use Illuminate\Http\Request;

class SuperadminController extends Controller
{
    // Halaman Kelola Pengguna
    public function pengguna()
    {
        $users = User::all();
        return view('superadmin.pengguna', compact('users'));
    }

    public function approveAdmin($id)
    {
        $user = User::findOrFail($id);
        if ($user->role === 'Admin' && $user->status === 'Pending') {
            $user->update(['status' => 'Aktif']);
            return back()->with('success', 'Akun admin catering berhasil disetujui.');
        }
        return back()->with('error', 'Gagal menyetujui akun.');
    }

    // Halaman Semua Catering
    public function catering()
    {
        $caterings = Catering::with(['admin', 'menus', 'pakets'])->get();
        return view('superadmin.catering', compact('caterings'));
    }

    // Halaman Semua Pesanan
    public function pesanan()
    {
        $pesanan = Pesanan::with(['pelanggan', 'catering', 'details'])->orderBy('tanggal_pesanan', 'desc')->get();
        return view('superadmin.pesanan', compact('pesanan'));
    }
}