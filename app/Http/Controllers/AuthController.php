<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Activity_Log;

class AuthController extends Controller
{
    // Halaman login
    public function login()
    {
        return view('auth.login');
    }

    // Proses login
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

            //LOG LOGIN
            Activity_Log::create([
                'user_id' => Auth::id(),
                'aksi' => 'login',
                'deskripsi' => 'User login ke sistem',
            ]);

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
        //LOG LOGOUT
        Activity_Log::create([
            'user_id' => Auth::id(),
            'aksi' => 'logout',
            'deskripsi' => 'User logout dari sistem',
        ]);

        Auth::logout();
        $r->session()->invalidate();
        $r->session()->regenerateToken();

        return redirect('/login');
    }
}
