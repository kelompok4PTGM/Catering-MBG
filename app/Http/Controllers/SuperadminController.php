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

    // Halaman Semua Catering
    public function catering()
    {
        $caterings = Catering::all();
        return view('superadmin.catering', compact('caterings'));
    }

    // Halaman Semua Pesanan
    public function pesanan()
    {
        $pesanan = Pesanan::with(['pelanggan', 'catering'])->orderBy('tanggal_pesanan', 'desc')->get();
        return view('superadmin.pesanan', compact('pesanan'));
    }
}