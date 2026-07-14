<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Jasa;

class DashboardController extends Controller
{
    /**
     * Handle arah login sesuai role (US1, US2, US3).
     */
    public function index()
    {
        // Pastikan user sudah login
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        $user = Auth::user();
        $role = $user->role;

        // Arahkan sesuai role
        if ($role === 'admin') {
            return view('admin.dashboard'); // Admin ke Panel Admin (US3)
        } 
        
        if ($role === 'vendor') {
            // Ambil data jasa milik vendor ini saja (US2 & US4)
            $jasas = Jasa::where('user_id', $user->id)->latest()->get();
            return view('vendor.dashboard', compact('jasas'));
        }

        // Default: User Biasa langsung ke Landing Page (US1)
        return redirect('/');
    }
}