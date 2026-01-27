<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class AdminMiddleware
{
    public function handle(Request $request, Closure $next): Response
    {
        // pastikan sudah login
        if (!Auth::check()) {
            return redirect('/login');
        }

        // cek role admin
        if (Auth::user()->id_role != 1) {
            abort(403);
        }

        return $next($request);
    }
}
