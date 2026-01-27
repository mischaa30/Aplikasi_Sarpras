<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    // Halaman login
    public function login()
    {
        return view('auth.login');
    }

    // Proses login (FULL AUTH)
    public function prosesLogin(Request $r)
    {
        $r->validate([
            'username' => 'required',
            'password' => 'required'
        ]);

        if (Auth::attempt([
            'username' => $r->username,
            'password' => $r->password
        ])) {
            $r->session()->regenerate();

            $user = Auth::user();

            if ($user->id_role == 1) {
                return redirect('/admin/dashboard');
            } elseif ($user->id_role == 2) {
                return redirect('/petugas/dashboard');
            } else {
                return redirect('/pengguna/dashboard');
            }
        }

        return back()->with('eror', 'Login gagal');
    }

    // Logout
    public function logout(Request $r)
    {
        Auth::logout();
        $r->session()->invalidate();
        $r->session()->regenerateToken();

        return redirect('/login');
    }
}