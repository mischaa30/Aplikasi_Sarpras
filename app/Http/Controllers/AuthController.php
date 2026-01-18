<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;

class AuthController extends Controller
{
    //Menampilkan halaman login
    public function login(){
        return view('auth.login');
    }

    //Proses Login
    public function prosesLogin(Request $r)
    {
        //Buat user tidak bisa login tanpa isi form
        $r->validate([
            'username' => 'required',
            'password' => 'required'
        ]);

        $user = User::where('username', $r->username)->first();

        if ($user && Hash::check($r->password, $user->password)) {
            Session::put('login', true);
            Session::put('user', $user);

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

    //Logout
    public function logout()
    {
        Session::flush(); //hapus semua session
        return redirect('/login');
    }
}
