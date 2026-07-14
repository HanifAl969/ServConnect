<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RoleManager
{
    public function handle(Request $request, Closure $next, $role)
    {
        if (!auth()->check()) { 
            return redirect()->route('login');
        }

        $user = $request->user();

        if ($user->role !== $role) {
            return redirect()->route('dashboard');
        }

        if ($role === 'vendor') {
            if ($user->status === 'pending') {
                return redirect()->route('dashboard')
                    ->with('error', 'Akun vendor Anda masih menunggu verifikasi admin.');
            }

            if ($user->status === 'rejected') {
                return redirect()->route('dashboard')
                    ->with('error', 'Akun vendor Anda ditolak. Hubungi admin.');
            }
        }

        if ($role === 'user' && in_array($user->status, ['pending', 'rejected'])) {
            return redirect()->route('dashboard')
                ->with('error', 'Akun Anda masih menunggu verifikasi KTP oleh admin.');
        }

        return $next($request);
    }
}
