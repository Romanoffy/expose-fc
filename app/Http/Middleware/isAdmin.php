<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class isAdmin
{
    public function handle(Request $request, Closure $next)
    {
        // Kalau belum login, lempar ke login
        if (!Auth::check()) {
            return redirect('/login')->with('error', 'Silakan login terlebih dahulu.');
        }

        // Kalau user tidak punya hak admin (is_active != 1)
        if (Auth::user()->is_active != 1) {
            return redirect('/')->with('error', 'Anda tidak memiliki akses ke halaman admin.');
        }

        // Kalau semua aman, lanjut
        return $next($request);
    }
}
