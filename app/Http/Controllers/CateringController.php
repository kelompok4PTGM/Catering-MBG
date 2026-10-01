<?php

namespace App\Http\Controllers;

use App\Models\Catering;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

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
            'foto' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
        ]);

        $catering = Catering::where('id_admin', Auth::id())->first();

        if ($catering) {
            // Update existing profile
            // check uniqueness of nama_catering excluding self
            $request->validate([
                'nama_catering' => 'unique:catering,nama_catering,' . $catering->id,
            ]);

            $data = [
                'nama_catering' => $request->nama_catering,
                'deskripsi' => $request->deskripsi,
            ];

            if ($request->hasFile('foto')) {
                // Delete old photo if exists
                if ($catering->foto && Storage::disk('public')->exists($catering->foto)) {
                    Storage::disk('public')->delete($catering->foto);
                }
                $data['foto'] = $request->file('foto')->store('catering', 'public');
            }

            $catering->update($data);
            
            $message = 'Profil catering berhasil diperbarui.';
        } else {
            // Create new profile
            $request->validate([
                'nama_catering' => 'unique:catering,nama_catering',
            ]);

            $data = [
                'id_admin' => Auth::id(),
                'nama_catering' => $request->nama_catering,
                'deskripsi' => $request->deskripsi,
                'status' => 'Aktif',
            ];

            if ($request->hasFile('foto')) {
                $data['foto'] = $request->file('foto')->store('catering', 'public');
            }

            $catering = Catering::create($data);

            Auth::user()->update(['id_catering' => $catering->id]);

            $message = 'Profil catering berhasil dibuat. Sekarang Anda dapat mengelola Menu dan Paket.';
        }

        return redirect()->route('admin.catering.profile')->with('success', $message);
    }
}
