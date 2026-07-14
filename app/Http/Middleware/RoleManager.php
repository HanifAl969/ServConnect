<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RoleManager
{
    /**
     * Handle an incoming request.
     *
     * @param  Closure(Request): (Response)  $next
     */
    public function handle(Request $request, Closure $next, $role)
    {
        if (!auth()->check()) { 
            return redirect()->route('login');
        }

        // Kalau role user tidak sesuai dengan yang diminta router, tendang ke dashboard default
        if ($request->user()->role !== $role) {
            return redirect()->route('dashboard');
        }

        return $next($request);
    }
}
