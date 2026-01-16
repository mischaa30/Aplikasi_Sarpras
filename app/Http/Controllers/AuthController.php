<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
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
        //Cek user berdasarkan username & password
        $user = User::where('username', $r->username)
        ->where('password', $r->password)
        ->first();

        //Jika user ditemukan
        if($user){
            Session::put('login',true);
            Session::put('user',$user);

            return redirect('/user');
        }

        //Jika gagal
        return back()->with('eror','Login gagal');
    }

    //Logout
    public function logout()
    {
        Session::flush();
        return redirect('/login');
    }
}
