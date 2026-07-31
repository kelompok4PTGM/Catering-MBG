<?php

namespace App\Http\Controllers;

use App\Models\Catering;
use App\Models\Menu;
use App\Models\Paket;
use Illuminate\Http\Request;

class CateringStoreController extends Controller
{
    public function show($id)
    {
        $catering = Catering::with(['menus', 'pakets'])->findOrFail($id);

        return view('catering.show', compact('catering'));
    }
}
