<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PetugasMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        if (!Auth::check()) {
            return redirect('/login');
        }

        // id_role = 2 untuk petugas
        if (Auth::user()->id_role != 2) {
            abort(403);
        }

        return $next($request);
    }
}
