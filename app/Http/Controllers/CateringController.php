<?php

namespace App\Http\Controllers;

use App\Models\Catering;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CateringController extends Controller
{
    public function profile()
    {
        $catering = Catering::where('id_admin', Auth::id())->first();
        return view('admin.catering.profile', compact('catering'));
    }

    public function updateProfile(Request $request)
    {
        $request->validate([
            'nama_catering' => 'required|string|max:100',
            'deskripsi' => 'nullable|string',
        ]);

        $catering = Catering::where('id_admin', Auth::id())->first();

        if ($catering) {
            // Update existing profile
            // check uniqueness of nama_catering excluding self
            $request->validate([
                'nama_catering' => 'unique:catering,nama_catering,' . $catering->id,
            ]);

            $catering->update([
                'nama_catering' => $request->nama_catering,
                'deskripsi' => $request->deskripsi,
            ]);
            
            $message = 'Profil catering berhasil diperbarui.';
        } else {
            // Create new profile
            $request->validate([
                'nama_catering' => 'unique:catering,nama_catering',
            ]);

            Catering::create([
                'id_admin' => Auth::id(),
                'nama_catering' => $request->nama_catering,
                'deskripsi' => $request->deskripsi,
                'status' => 'Aktif',
            ]);

            $message = 'Profil catering berhasil dibuat. Sekarang Anda dapat mengelola Menu dan Paket.';
        }

        return redirect()->route('admin.dashboard')->with('success', $message);
    }
}
