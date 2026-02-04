<?php

namespace App\Http\Middleware;

use Illuminate\Auth\Middleware\Authenticate as Middleware;
use Illuminate\Http\Request;

class Authenticate extends Middleware
{
    /**
     * Get the path the user should be redirected to when they are not authenticated.
     */
    protected function redirectTo(Request $request): ?string
    {
        if ($request->expectsJson()) {
            return null;
        }

        // Beri peringatan agar user tahu harus login terlebih dahulu
        $request->session()->flash('eror', 'Anda harus login untuk mengakses halaman tersebut');

        return route('login');
    }
}
