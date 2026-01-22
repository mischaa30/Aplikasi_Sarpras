<?php

namespace App\Http\Controllers;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\facades\Session;

use Illuminate\Http\Request;

class ProfilController extends Controller
{
    public function edit()
    {
        return view('profil.edit',[
            'user' => Session::get('user')
        ]);
    }

    public function update(Request $r)
    {
        $r->validate([
            'username' => 'required',
            'password' => 'nullable|min:4'
        ]);

        $userSession = Session::get('user');
        $user = User::find($userSession->id);
        $user->username = $r->username;

        if($r->password){
            $user->password = Hash::make($r->password);
        }

        $user->save();

        //update session agar langsung berubah
        Session::put('user',$user);
        return back()->with('succes','Profil berhasil di update');
    }
}
