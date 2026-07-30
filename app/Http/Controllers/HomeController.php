<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    public function index()
    {
        // For the home page, we will show available caterings
        // In a real app we'd use Eloquent Catering::where('status', 'Aktif')->get()
        $caterings = DB::table('catering')->where('status', 'Aktif')->get();
        return view('home', compact('caterings'));
    }

    public function dashboard()
    {
        $role = Auth::user()->role;
        
        if ($role === 'Superadmin') {
            return redirect()->route('superadmin.dashboard');
        } elseif ($role === 'Admin') {
            return redirect()->route('admin.dashboard');
        } else {
            return redirect()->route('user.dashboard');
        }
    }

    public function superadminDashboard()
    {
        return view('dashboard.superadmin');
    }

    public function adminDashboard()
    {
        // Admin (Manager Catering) sees their own catering stats
        return view('dashboard.admin');
    }

    public function userDashboard()
    {
        // User (Pembeli) sees their orders
        return view('dashboard.user');
    }
}
