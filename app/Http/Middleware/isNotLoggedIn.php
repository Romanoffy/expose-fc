<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class isNotLoggedIn
{
    public function handle(Request $request, Closure $next)
    {
        if (Auth::check()) {
            return redirect('/admin/blogs'); // Atau ke route lain sesuai kebutuhanmu
        }

        return $next($request);
    }
}
